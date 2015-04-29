<?php

session_start();

//ob_start("ob_gzhandler");

include("include/functions.php");



if(!isset($_SESSION['CURRENT_POSTCODE']) || !isset($_SESSION['CURRENT_MENU'])) {

    header('Location:index.php');

    die();

}



if($_SESSION['CART']['TOTAL'] < $_SESSION['type_min_order']) {

    $_SESSION['error'] = "Minimum Order Amount Should Be &pound;".$_SESSION['type_min_order'];

    header('Location:'.$_SESSION['CURRENT_MENU']);

    die();

}



$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());



$ARRAY = array('user_name', 'user_password', 'user_email', 'user_phoneno', 'user_address', 'user_address_1', 'user_city', 'user_dob', 'user_hear','user_verified' ,'user_status');



foreach($ARRAY as $v) {

    $ARRAYTEMP[$v] = '';

}



$user = false;

if(isset($_SESSION['user'])) {

    $select = "*";

    $where = "`id` = '".$_SESSION['userId']."'";



    $result = SELECT($select ,$where, 'user', 'array');

    foreach($ARRAY as $v) {

        $ARRAYTEMP[$v] = $result[$v];

    }

    $user = true;

} else if(isset($_SESSION['PAY_POST_VALUE'])) {

    foreach($ARRAY as $v) {

        $ARRAYTEMP[$v] = $_SESSION['PAY_POST_VALUE'][$v];

    }

}

$RETURN = isShopOpen($_SESSION['DELIVERY_REST_ID']);

$RETURN = true;

if($RETURN['if'] == 'false') {

    $_SESSION['error'] = "Sorry! We are not taking orders now. Opens At ".$RETURN['time']. "am. We apologize for the inconvenience!";

    $_SESSION['Staff_Not_Available'] = 'true';

} else if(true){

    if($_SESSION['RESTAURANT_TYPE_CATEGORY'] == 'fastfood' && $_SESSION['delivery_type']['type'] == 'delivery') {

        $_SESSION['TO_STAFF_ID'] = toStaffId(getEandN($_SESSION['CURRENT_POSTCODE']), $_SESSION['CURRENT_POSTCODE']);

        if($_SESSION['TO_STAFF_ID']  == 'false') {

            $_SESSION['error'] = "Sorry! We are not able to process your order at this time. Our delivery drivers are currently busy fulfilling orders. We apologize for the inconvenience!";

            $_SESSION['Staff_Not_Avialable'] = 'true';

        } else {

            unset($_SESSION['Staff_Not_Avialable']);

        }

    } else {

        unset($_SESSION['Staff_Not_Avialable']);

    }

} else {

    unset($_SESSION['Staff_Not_Avialable']);

}

?>

<!DOCTYPE HTML>

<html lang="en-US">

<head>

    <meta charset="UTF-8">

    <meta name="description" content="Order Details, <?= getDataFromTable('setting','meta'); ?>">

    <meta name="keywords" content="Order Details, <?= getDataFromTable('setting','keywords'); ?>">

    <meta name="author" content="KA">



    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="apple-touch-icon" href="items-pictures/default_rest_img.png">



    <link rel="shortcut icon" type="image/png" href="favicon.png" />

    <title>Order Details - Just-FastFood</title>



    <!--CSS INCLUDES-->

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,900' rel='stylesheet' type='text/css'>



    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>



    <link href="css/archivist.css" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/responsivemobilemenu.css" type="text/css"/>

    <link href="css/media.css" rel="stylesheet">

    <link href="css/flexslider.css" rel="stylesheet">

    <link rel="stylesheet" href="css/square/blue.css" />

    <link href="css/owl.carousel.css" rel="stylesheet">

    <link href="css/owl.theme.css" rel="stylesheet">


</head>

<body>

<div class="wrapper">

    <?php include('templates/header2.php'); ?>



    <div class="page_header">

        <div class="inner_title"><h2 class="text-center white">Almost there, login to complete your <span>order</span></h2></div>





        <div class="custom_button yellow_btn small_but text-center ">

            <ul><li><a href="Postcode-<?php echo str_replace(' ','-',$_SESSION['CURRENT_POSTCODE']); ?>">Change Restaurant</a></li></ul>

        </div>

    </div>

    <div class="breadcrum">

        <ul>

            <li><a href="index.php">Begin Search</a></li>

            <li><a href="Postcode-<?php echo str_replace(' ','-',$_SESSION['CURRENT_POSTCODE']); ?>">Postcode-<?php echo $_SESSION['CURRENT_POSTCODE']; ?></a></li>

            <li><a href="<?php echo $_SESSION['CURRENT_MENU']?>" class="u b">Add More</a></li>

        </ul>

    </div>

    <?php include('include/notification.php');?>


    <hr class="hr">
    <div class="section_inner">

        <div class="container" >



            <div class="col-md-12 explor">



                <div class="col-md-5">

                    <div class="box-wrap order-details-wrap">

                        <h3 class="order-header">Your Order</h3>

                        <hr class="hr" />

                        <div class="order">

                            <div class="order-cart-wrapper"></div>

                        </div>

                    </div>

                    <?php

                    if(!isset($_SESSION['user'])) {

                        ?>

                        <div class="box-wrap login-wrap" style="font-family: 'Lato', 'Open Sans'">
                            <form class="form-horizontal bv-form" action="login.php" method="post" id="order-login-form">
                                <h3 class="sign-in-header">Login</h3>
                                <p>Please enter your email address and password to sign in</p>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="email" >Email</label>
                                    <div class="col-lg-7">
                                        <input type="text" name="email" id="password" placeholder="Email Address" class="input required email form-control"/>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="password" >Password</label>
                                    <div class="col-lg-7">
                                        <input type="password" name="password" id="password" placeholder="Password" class="input required form-control"/>
                                    </div>
                                </div>

                                <div class="form-group login-reset-btn">
                                    <input type="submit" value="Login" name="LOGIN" class="col-sm-offset-2 btn"/>
                                    <input type="hidden" name="backURL" value="order-details.php"/>
                                    <input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
                                    <a id="init-p-form" href="#" >Can't access your account?</a>
                                </div>
                            </form>

                            <!-- ==============

                                 PASSWORD RESET

                                 ============== -->

                            <div class="modal fade" id="request-p-form" tabindex="-1" role="dialog" aria-labelledby="request-p-form" aria-hidden="true">

                                <div class="modal-dialog">

                                    <div class="modal-content">

                                        <div class="modal-header">

                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                                            <h4 class="modal-title">Forgot Password</h4>

                                        </div>

                                        <div class="modal-body">

                                        </div>

                                    </div><!-- /.modal-content -->

                                </div><!-- /.modal-dialog -->

                            </div><!-- /.modal -->

                        </div>

                    <?php } ?>

                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 box-wrap sign-up-wrap">

                    <form class="form-horizontal signup-form bv-form" action="pay.php" method="post" <?php if(!$user) { echo 'id="order-sign-up-form"'; } else { echo 'id="order-confirm-delivery"'; } ?>>
                        <?php

                        if(!$user) {

                            ?>

                            <h3 class="sign-up-header">Don't have an account?</h3>

                            <p>Don't worry you can create one now before anyone notices</p>

                            <p class="small txt-right" style="color:#D62725">Please note: input fields marked with a * are required fields.</p>

                            <p class="small" style="position: relative; font-size: smaller"><a href="javascript:;" class="why-signup"><span class="b red">Why Signup?</span></a><span class="why-signup-text">Get local offers by email every week, re-order saved meals in a few clicks, store your delivery address and build a list of your favourite local takeaways.</span></p>

                            <div class="form-group has-feedback">

                                <label class="col-lg-3 control-label" for="user_email">Email <span class="required">*</span>

                                </label>

                                <div class="col-lg-7">

                                    <input type="text" name="user_email" id="user_email" placeholder="Email address" class="input required email form-control" value="<?php echo $ARRAYTEMP['user_email'];?>"/>

                                </div>

                            </div>

                            <div class="form-group has-feedback">

                                <label class="col-lg-3 control-label" for="user_password">Password<span class="required">*</span></label>

                                <div class="col-lg-7">

                                    <input type="password" name="user_password" placeholder="Password" id="user_password" class="input required form-control" />

                                </div>

                            </div>

                            <div class="form-group has-feedback">

                                <label class="col-lg-3 control-label" for="cuser_password">Confirm Password<span class="required">*</span></label>

                                <div class="col-lg-7">

                                    <input type="password" name="cuser_password" placeholder="Confirm Password" id="cuser_password" class="input required form-control"/>

                                    <input type="hidden" name="first_time" value="true"/>

                                </div>

                            </div>

                        <?php } else {?>

                            <h3 class="order-confirm">Confirm</h3>

                            <p class="small txt-right" style="color:#D62725">Please note: input fields marked with a * are required fields.</p>

                        <?php

                        }

                        ?>

                        <div class="form-group has-feedback">

                            <label class="col-lg-3 control-label" for="user_fullname">Full Name<span class="required">*</span></label>

                            <div class="col-lg-7">

                                <input type="text" name="user_name" id="user_fullname" placeholder="Full Name" class="input required form-control" value="<?php echo $ARRAYTEMP['user_name'];?>" data-dump="<?php echo $ARRAYTEMP['user_screen_name'];?>"/>

                            </div>

                        </div>

                        <div class="form-group has-feedback">

                            <label class="col-lg-3 control-label" for="user_phone">Phone No.<span class="required">*</span></label>

                            <div class="col-lg-7">

                                <input type="text" name="user_phoneno" id="user_phoneno" placeholder="In case we need to reach you" class="input required form-control" value="<?php echo $ARRAYTEMP['user_phoneno'];?>"/>

                            </div>

                        </div>

                        <!--<hr class="hr"/>

                        <p class="small txt-center">Delivery address:</p>-->

                        <div class="form-group has-feedback">

                            <label class="col-lg-3 control-label" for="user_address">Address<span class="required">*</span></label>

                            <div class="col-lg-7">

                                <input type="text" name="user_address" id="user_address" placeholder="Delivery Address" class="input required form-control" value="<?php echo $ARRAYTEMP['user_address'];?>"/>

                            </div>

                        </div>

                        <!--	<div class="form-group has-feedback">

							<label class="col-lg-3 control-label" for="user_address_1">Address 1</label>

							<div class="col-lg-6">

							<input type="text" name="user_address_1" id="user_address_1" class="input form-control" value="<?php echo $ARRAYTEMP['user_address_1'];?>"/>

							</div>

						</div>-->

                        <div class="form-group has-feedback">

                            <label class="col-lg-3 control-label" for="user_city">City<span class="required">*</span></label>

                            <div class="col-lg-7">

                                <input type="text" name="user_city" id="user_city" placeholder="City" class="input required form-control" value="<?php echo $ARRAYTEMP['user_city'];?>"/>

                            </div>

                        </div>

                        <div class="form-group has-feedback">

                            <label class="col-lg-3 control-label" for="user_postcode">Post Code</label>

                            <div class="col-lg-7">
                                <?php echo $_SESSION['CURRENT_POSTCODE'];?>
                                <?php if(!$user) { ?>
                                    <input name="user_post_code" id="user_postcode" placeholder="e.g SE7 5HR" class="input required form-control" value="<?php echo $_SESSION['CURRENT_POSTCODE'];?>" type="hidden" />
                                <?php } ?>
                            </div>

                        </div>

                        <br/>

                        <div class="additional">

                            <p>

                                <span class="b red">Leave a note for the restaurant</span><br/> If you have any allergies or dietary requirements please specify this in the comments box. Also use the comments box if you want to leave a note about delivery for the delivery driver.

                            </p>

                            <textarea name="order_note" class="form-control" id="order_note" cols="49" rows="8" style="width: 100%; height: 60px; resize:vertical; font-size: 14px !important;"></textarea>

                        </div>

                        <div>
                            <input type="hidden" name="user_dob" value=""/>
                            <input type="hidden" name="user_status" value=""/>
                            <input type="hidden" name="user_hear" value=""/>
                            <input type="hidden" name="user_screen_name" value=""/>
                            <input type="hidden" name="user_address_1" value=""/>
                            <input type="hidden" name="user_verified" value=""/>
                            <input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
                        </div>

                        <div class="form-group has-feedback agree-tos-pp">

                            <input type="checkbox" name="accept" id="" class="required"/>

                            <p>I accept the <a href="terms.php" class="u pop_box red">terms and conditions</a> &amp; <a href="privacy.php" class="u pop_box red">privacy policy</a></p>

                        </div>

                        <div class="txt-right">
                            <?php if(!$user) { ?>
                                <input type="hidden" name="user_dob" value=""/>
                                <input type="hidden" name="user_status" value=""/>
                                <input type="hidden" name="user_hear" value=""/>
                                <input type="hidden" name="user_verified" value=""/>
                                <input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
                                <input class="btn btn-lg btn-primary btn-block" type="submit" name="SIGNUP" value="Sign Up" />
                                <!-- modal -->
                                <div class="modal fade" id="signup-modal" tabindex="-1" role="dialog" aria-labelledby="signup-modal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title"></h4>
                                            </div>
                                            <div class="modal-body">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-lg btn-primary btn-block" data-dismiss="modal">Try Again</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            <?php } else { ?>
                                <input type="submit" value="Proceed" class="btn btn-lg btn-primary btn-block" name="PROCEED"/>
                            <?php } ?>


                        </div>

                    </form>

                </div>

                <div class="clr"></div>

            </div>

        </div>

    </div>

</div>

<!-- ======================
     MODAL 
     ====================== -->
<div class="modal fade" id="item-modal" tabindex="-1" role="dialog" aria-labelledby="item-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Remove from Cart</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button id="item-keep" type="button" class="btn" data-dismiss="modal">No, keep</button>
                <button id="item-remove" type="button" class="btn btn-danger-custom">Yes, remove</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- modal -->
<div class="modal fade" id="user-signin-modal" tabindex="-1" role="dialog" aria-labelledby="signin-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-lg btn-primary btn-block" data-dismiss="modal">Try Again</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php require('templates/footer2.php');?>

</body>

</html>