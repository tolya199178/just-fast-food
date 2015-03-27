<?php
session_start();

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
    $_SESSION['Staff_Not_Avialable'] = 'true';
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
    <meta name="author" content="M Awais">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="apple-touch-icon" href="items-pictures/default_rest_img.png">

    <link rel="shortcut icon" href="images/favicon.ico">
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

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script type="text/javascript" src="js/validate.js"></script>

    <script type="text/javascript" src="css/fancybox/jquery.fancybox.js"></script>
    <script type="text/javascript" src="js/mobileMenu.js"></script>
    <style type="text/css">
        .why-signup-text{
            position:absolute;
            top:18px;
            left:0px;
            background:#fff;
            padding:5px;
            display:none;
            border:1px solid #ddd;
            border-radius:3px;
            -moz-border-radius:3px;
            -webkit-border-radius:3px;

            -webkit-box-shadow: rgba(0, 0, 0, 0.5) 0 1px 3px 0;
            -moz-box-shadow: rgba(0, 0, 0, 0.5) 0 1px 3px 0;
            box-shadow: rgba(0, 0, 0, 0.5) 0 1px 3px 0;
            z-index: 1;
        }
        .box-wrap {
            font-family: Roboto;
        }
        .shadow {
            -moz-box-shadow: 0 0 5px rgba(0,0,0,0.5);
            -webkit-box-shadow: 0 0 5px rgba(0,0,0,0.5);
            box-shadow: 0 0 5px rgba(0,0,0,0.5);
        }
        .login-wrap {
            margin-top: 30px;
        }
        @media only screen and (max-width: 780px) {
            .sign-up-wrap {
                margin-top: 40px;
            }
        }

        .order-details-wrap {
            overflow: hidden;
        }
        .cart-header,
        .order-header,
        .sign-in-header,
        .sign-up-header,
        .red-wrap h3,
        .red-wrap h2 {
            display:block;
            text-transform: uppercase;
            padding: 10px 40px;
            background: #e74c3c;
            color:#fff;
            text-align: center;
            width:100%;
            margin-top:-4px;
            border-radius: 5px;
        }
        .sign-in-header {
            margin-top: -25px;
        }
        .sign-up-header {
            margin-top: -24px;
        }
        .order-header {
            margin-top: 1px;
        }
        .additional,
        .agree-tos-pp {
            margin-bottom: 10px;
            font-size: 14px;
        }
        .agree-tos-pp p {
            display: inline;
        }
        .login-reset-btn p {
            display: inline;
        }
        .order-cart-wrapper * {
            font-family: 'Roboto';
            font-size: 14px;
            color: #000;
        }
        .order-cart-wrapper ul li .del {
            margin-top: -2px;
        }
        .order-cart-wrapper ul li .del img {
            vertical-align: middle;
        }
        .order-cart-wrapper ul li .p {
            float: right;
            margin-right: 10px;
        }
        .login-wrap .form-control {
            width:50%;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.box-wrap').each(function(){
                $(this).hover(function(){
                    $(this).toggleClass('shadow')
                });
            });
        });
    </script>
</head>

<body>
<div class="wrapper">
    <?php include('templates/header2.php'); ?>

    <div class="page_header">
        <div class="inner_title"><h2 class="text-center white">Complete Your <span>Order</span> - Few Clicks Away</h2></div>


        <div class="custom_button yellow_btn small_but text-center ">
            <ul><li><a href="Postcode-<?php echo str_replace(' ','-',$_SESSION['CURRENT_POSTCODE']); ?>">Change Restaurant</a></li></ul>
        </div>
    </div>
    <div class="breadcrum" style="font-size: 11px">
        <ul>
            <li><a href="index.php">Begin Search</a></li>
            <li><a href="Postcode-<?php echo str_replace(' ','-',$_SESSION['CURRENT_POSTCODE']); ?>">Postcode-<?php echo $_SESSION['CURRENT_POSTCODE']; ?></a></li>
            <li><a href="<?php echo $_SESSION['CURRENT_MENU']?>" class="u b">Add More</a></li>
        </ul>
    </div>
    <?php include('include/notification.php');?>

    <div class="section_inner">
        <div class="container">
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
                        <div class="box-wrap login-wrap">
                            <form class="form-horizontal login-form bv-form" action="login.php" method="post" id="loginForm">
                                <h3 class="sign-in-header" style="margin-bottom: 10px">Login</h3>
                                <p style="margin-bottom: 20px; margin-top: 20px; padding-left: 20px">Please enter your email address and password to sign in</p>
                                <div class="form-group has-feedback">
                                    <label class="col-lg-3 control-label b" for="user_email0" >Email Address</label><input type="text" name="user_email" id="user_email0" class="input required email form-control"/>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="col-lg-3 control-label b" for="user_password1" >Password</label><input type="password" name="user_password" id="user_password1" class="input required form-control"/>
                                </div>
                                <div class="login-reset-btn">
                                    <input type="submit" value="Login" name="LOGIN" class="btn"/>
                                    <input type="hidden" name="backURL" value="order-details.php"/>
                                    <input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
                                    <a id="init-p-form" href="#" rel="prettyPhoto" style="font-size: 11px">Can't access your account?</a>
                                    <!-- ============== PASSWORD RESET ============== -->
                                    <div class="modal fade" id="request-p-form" tabindex="-1" role="dialog" aria-labelledby="request-p-form" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" style="font-family: Roboto">It's easy to retrieve your password</h4>
                                                </div>
                                                <div class="modal-body">
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->

                                </div>
                            </form>
                            <div id="passowrd-reset" class="hidden">
                                <div class="form-group has-feedback">
                                    <label class="control-label b" for="user-email-rest" >Email Address</label>
                                    <input placeholder="Enter your email address"type="text" name="user-email-reest" id="user-email-reset" class="input required email form-control"/>
                                </div>
                                <p id="p-error" class="hidden">The email field can't be empty</p><br/>
                                <p id="p-success" class="hidden">Please check your email, as well as the spam folder</p>
                                <input id="request-p-email" type="button" value="Login" name="LOGIN" class="btn"/>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-md-6 box-wrap sign-up-wrap col-sm-offset--1">
                    <form class="form-horizontal login-form bv-form" action="pay.php" method="post" id="signupForm">

                        <?php
                        if(!$user) {
                            ?>
                            <h3 class="sign-up-header">Create an account</h3>
                            <p style="margin-bottom: 10px; margin-top: 20px; padding-left: 20px">Don't worry you can create one now before anyone notices</p>
                            <p class="small" style="position: relative; padding-left: 20px"><a href="javascript:;" class="why-signup"><span class="b red">Why Signup?</span></a><span class="why-signup-text">Get local offers by email every week, re-order saved meals in a few clicks, store your delivery address and build a list of your favourite local takeaways and fastfood outlets.</span></p>
                            <div class="form-group has-feedback">
                                <label class="col-lg-3 control-label" for="user_email">Email Address<span class="required">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" name="user_email" id="user_email" class="input required email form-control" value="<?php echo $ARRAYTEMP['user_email'];?>"/>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="col-lg-3 control-label" for="user_screen_name">Screen Name<span class="required">*</span></label>
                                <div class="col-lg-6">
                                    <input type="text" name="user_screen_name" id="user_screen_name" class="input valid form-control" value="">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="col-lg-3 control-label" for="user_password">Password<span class="required">*</span></label>
                                <div class="col-lg-6">
                                    <input type="password" name="user_password" id="user_password" class="input required form-control" />
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="col-lg-3 control-label" for="cuser_password">Confirm Password<span class="required">*</span></label>
                                <div class="col-lg-6">
                                    <input type="password" name="cuser_password" id="cuser_password" class="input required form-control"/>
                                    <input type="hidden" name="first_time" value="true"/>
                                </div>
                            </div>
                        <?php } else {?>
                            <div class="red-wrap"><h2>Confirm?</h2></div>
                            <p class="small txt-right" style="color:#D62725">Please note: input fields marked with a * are required fields.</p>
                        <?php
                        }

                        ?>

                        <div class="form-group has-feedback">
                            <label class="col-lg-3 control-label" for="user_name">Full Name<span class="required">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" name="user_name" id="user_name" class="input required form-control" value="<?php echo $ARRAYTEMP['user_name'];?>"/>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label class="col-lg-3 control-label" for="user_phone">Phone No<span class="required">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" name="user_phoneno" id="user_phoneno" class="input required form-control" value="<?php echo $ARRAYTEMP['user_phoneno'];?>"/>
                            </div>
                        </div>
                        <!--<hr class="hr"/>
                        <p class="small txt-center">Delivery address:</p>-->
                        <div class="form-group has-feedback">
                            <label class="col-lg-3 control-label" for="user_address">Delivery Address<span class="required">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" name="user_address" id="user_address" class="input required form-control" value="<?php echo $ARRAYTEMP['user_address'];?>"/>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label class="col-lg-3 control-label" for="user_city">City<span class="required">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" name="user_city" id="user_city" class="input required form-control" value="<?php echo $ARRAYTEMP['user_city'];?>"/>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label class="col-lg-3 control-label" for="user_postcode">Post Code</label>
                            <div class="col-lg-6">
                                <?php echo $_SESSION['CURRENT_POSTCODE'];?>
                            </div>
                        </div>
                        <br/>
                        <div class="additional" style="font-size: 11px">
                            <p>
                                <span class="b red">Leave a note for the restaurant</span><br/> If you have any allergies or dietary requirements please specify this in the comments box. Also use the comments box if you want to leave a note about delivery for the delivery driver.
                            </p>
                            <textarea name="order_note" class="form-control" id="order_note" cols="49" rows="8" style="width: 100%; height: 60px; resize: vertical;"></textarea>
                        </div>
                        <div>
                            <input type="hidden" name="user_dob" value=""/>
                            <inpu
                                t type="hidden" name="user_status" value="active"/>
                            <input type="hidden" name="user_hear" value=""/>
                            <input type="hidden" name="user_verified" value=""/>
                            <input type="hidden" name="order_notes" id="order_notes" value=""/>
                            <input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
                        </div>
                        <div class="agree-tos-pp">
                            <input type="checkbox" name="accept" id="" class="required"/>
                            <p>I accept the <a href="terms.php" class="u pop_box red">terms and conditions</a> &amp; <a href="privacy.php" class="u pop_box red">privacy policy</a></p>
                        </div>
                        <div class="txt-right">
                            <input type="submit" value="Proceed" class="btn" name="PROCEED"/>
                        </div>
                    </form>
                </div>
                <div class="clr"></div>
            </div>
        </div>
    </div>
    </div>


    <?php require('templates/footer2.php');?>

</body>
</html>

<script type="text/javascript">
    $(document).ready(function(){
        $('.small .why-signup').hover(function() {
            $('.why-signup-text').show();
        }, function(){
            $('.why-signup-text').hide();
        });
    });
</script>