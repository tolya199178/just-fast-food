<?php
session_start();

/* if($_POST['access'] != $_SESSION['access_key']){
    header('Location:index.php');
    die();
} */

// CARD POCESSING
if(isset($_POST['stripeToken'])) {
    $_SESSION['CARD_PROCESSING'] = $_POST;
    if(!empty($_POST['N_Addr'])) {
        $_SESSION['CARD_PROCESSING']['address'] = $_POST['N_Addr'];
        $_SESSION['CARD_PROCESSING']['postcode'] = $_POST['N_Postcode'];
    }
    header('Location:include/card/process.php');
    die();
}

include('include/functions.php');
$s = false;
$SET = array($_SESSION['access_key'] , $_SESSION['CART'] , $_SESSION['CURRENT_POSTCODE'], $_SESSION['type_min_order'], $_SESSION['CURRENT_MENU']);

$ERROR = false;
foreach($SET as $val) {
    if(!isset($val)) {
        $ERROR = true;
        break;
    }
}
if($ERROR){
    $_SESSION['error'] = "Session Key Expire. Please Try Again";
    header('Location:order-details.php');
    die();
}

if($_SESSION['CART_SUBTOTAL'] < $_SESSION['type_min_order']) {
    $_SESSION['error'] = "Minimum Order Amount Should Be &pound;".$_SESSION['type_min_order'];
    header('Location:'.$_SESSION['CURRENT_MENU']);
    die();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['PAY_POST_VALUE'] = $_POST;
}

if(!isset($_SESSION['user']) && !isset($_SESSION['userId'])){
    $ARRAY = array('user_name', 'user_password', 'user_email', 'user_phoneno', 'user_address', 'user_address_1', 'user_city', 'user_dob', 'user_hear', 'user_status');

    $json_post = getEandN($_SESSION['CURRENT_POSTCODE']);
    if($json_post) {

        $value = "NULL, ";
        foreach($ARRAY as $values) {
            if($values == "user_password") {
                $value .= "'".md5(mysql_real_escape_string($_POST[$values]))."', ";
            } else {
                $value .= "'".mysql_real_escape_string($_POST[$values])."', ";
            }
        }
        $value .= "NULL";
        $extra = "`user_email` = '".$_POST['user_email']."'";
        $result = INSERT($value ,'user' ,'unique' ,$extra);
        if(!$result) {
            $_SESSION['error'] = "Email Address Already Exist!";
            header('Location:order-details.php');
            die();
        } else {
            $select = "`id`,`user_email`,`user_password`,`user_name`";
            $where = "`user_email` = '".$_POST['user_email']."' AND `user_password` = '".md5($_POST['user_password'])."' AND `user_status` = 'active'";

            $result = SELECT($select ,$where, 'user', 'array');
            if($result) {
                $_SESSION['user'] = $result['user_name'];
                $_SESSION['userId'] = $result['id'];
            }
        }
    } else {
        $_SESSION['error']  = "ERROR!! Invalid Post Code. <span style='font-size:13px'>( Please enter only full UK postode)</span>";
        header('Location:order-details.php');
        die();
    }
}
//$_SESSION['CART_SUBTOTAL'] = $_SESSION['CART_SUBTOTAL'] + process_fee();
$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());

?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="images/favicon.ico">
    <title>Pay Order - Just-FastFood</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script type="text/javascript" src="js/validate.js"></script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">

        $(document).ready(function(){
            var Addr = '<?php echo $_SESSION['PAY_POST_VALUE']['user_address'] ?>';
            var Zip = '<?php echo $_SESSION['CURRENT_POSTCODE'] ?>';
            $("#pay-by-cradit-card").validate({
                submitHandler: function(form) {
                    $('#submitBtn-card').attr("disabled", "disabled");
                    $('#submitBtn-card').val('Sending...Please Do NOT Refresh...');

                    var ccNum = $('#card_no').val(), cvcNum = $('#csc').val(), expMonth = $('#MM').val(), expYear = $('#YYYY').val(), Name = $('#full_name').val();

                    if($('#N_Addr').val() != ''){
                        Addr = $('#N_Addr').val();
                    }
                    if($('#N_Postcode').val() != ''){
                        Zip = $('#N_Postcode').val();
                    }

                    Stripe.setPublishableKey("pk_live_ilF5EvWx76sIw49zdNB8KNsG");
                    Stripe.createToken({
                        number: ccNum,
                        cvc: cvcNum,
                        exp_month: expMonth,
                        exp_year: expYear,
                        name : Name,
                        address_line1 : Addr,
                        address_zip : Zip
                    }, stripeResponseHandler);

                    //return false;
                }
            });
            $('#same_adrress').live('click',function() {
                if(!$(this).is(':checked')) {
                    $('p.notsameaddress').slideDown();
                } else {
                    $('p.notsameaddress').slideUp();
                }
            });
        });

        function stripeResponseHandler(status, response) {
            // Check for an error:
            if (response.error) {
                alert(response.error.message);
                $('#submitBtn-card').removeAttr("disabled");
                $('#submitBtn-card').val('Place my Order');
            } else { // No errors, submit the form:
                var f = $("#pay-by-cradit-card");
                // Token contains id, last4, and card type:
                var token = response['id'];
                // Insert the token into the form so it gets submitted to the server
                f.append("<input type='hidden' name='stripeToken' value='" + token + "' />");

                // Submit the form:
                f.get(0).submit();
            }
        }
    </script>
    <style type="text/css">
        p.notsameaddress{
            display:none;
        }
        .pay-by-cradit-card{
            display:block;
        }
        .pay-by-cradit-card .select{
            width:90px;
        }
    </style>
</head>
<body>

<div class="header">
    <?php require('templates/header.php');?>
</div>
<div class="content">
<div class="wrapper ">
<div class="breadcrum">
    <ul>
        <li><a href="index.php">Begin Search</a></li>
        <li><a href="Postcode-<?php echo str_replace(' ','-',$_SESSION['CURRENT_POSTCODE']); ?>">Postcode-<?php echo $_SESSION['CURRENT_POSTCODE']; ?></a></li>
        <li><a href="<?php echo $_SESSION['CURRENT_MENU']?>"><?php echo $_SESSION['CURRENT_MENU']?></a></li>
        <li class="u">Confirm Payment</li>
        <!--   <li><a href="">Cancel This Order</a></li>-->
    </ul>
</div>
<div class="fl-left">
    <div class="box-wrap">
        <div class="order-details-wrap">
            <div class="txt-center b">Order Details</div>
            <hr class="hr" />
            <div class="order pay">
                <ul>
                    <?php
                    $iii = 0;
                    foreach($_SESSION['CART'] as $key => $value) {
                        if($key != 'TOTAL') {
                            ?>
                            <li>
                                <div class="<?php echo ($iii %2 == 0) ? 'erow' : 'orow'?>">
                                    <span class="detail fl-left"><?php echo $value['QTY']; ?> x <?php echo $value['NAME']; ?></span>
                                    <div class="fl-right">
                                        <span>&pound; </span>
                                        <span class="p"><?php echo number_format($value['TOTAL'], 2); ?></span>
                                    </div>
                                    <div class="clr"></div>
                                </div>
                            </li>
                            <?php
                            $iii ++;
                        }
                    }
                    ?>
                </ul>
                <div class="txt-right total b">
                    <span>Total</span>
                    <span>&pound; <?php echo number_format($_SESSION['CART']['TOTAL'], 2); ?></span>
                </div>
                <div class="txt-right total">
                    <div class="row">
                        <span class="span">Delivery Charges : </span>
                        <span class="b">&pound; <?php echo number_format($_SESSION['DELIVERY_CHARGES'],2)?></span>
                    </div>
                    <div class="row">
                        <span class="span">Processing Fee : </span>
                        <span class="b">&pound; <?php echo process_fee()?></span>
                    </div>
                    <div class="row">
                        <span class="span">Discount : </span>
                        <span class="b">&pound; <?php echo number_format($_SESSION['SPECIAL_DISCOUNT'],2);?></span>
                    </div>
                </div>

                <div class="totalpay b">
                    <p class="fl-right">
                        <span class="">Sub Total : &nbsp;&nbsp;</span>
                        <span> &pound; </span><span class="p"><?php echo number_format(($_SESSION['CART_SUBTOTAL']+process_fee()),2);?></span>
                    </p>
                    <div class="clr"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="order-address box-wrap">
        <h3>Delivery Address</h3>
        <div class="txt-right u"><a href="order-details.php">Edit</a></div>
        <hr class="hr" />
        <p>
            <span class="b"><?php echo $_SESSION['PAY_POST_VALUE']['user_address'].' , '.$_POST['user_city']?></span>
        </p>
        <p>
            <span class="b"><?php echo $_SESSION['CURRENT_POSTCODE']?></span>
        </p>
        <p>
            <span>Phone No: </span><span class="b"><?php echo $_SESSION['PAY_POST_VALUE']['user_phoneno']?></span>
        </p>
        <div>
            <span>Order/Delivery Note :</span> <br/>
            <p class="i b"><?php echo $_SESSION['PAY_POST_VALUE']['order_note']?></p>
        </div>
    </div>
</div>
<div class="fl-left pay-detail">

    <div class=" login-wrap">
        <div class="inner-border">
            <div class="red-wrap" style="padding: 6px;">
                <h2 style="font-size: 18px;">How would you like to pay?</h2>
            </div>
            <!--<hr class="hr" />-->
            <?php include('include/notification.php');?>
            <div class="wrapper-pay-sel">
               <!-- <div class="by-card b"><a href="javascript:;" class="slideupdown">Pay By Card *</a></div>
                <form action="" class="pay-by-cradit-card" method="post" id="pay-by-cradit-card">
                    <p class="row txt-center">
                        <!--<label for="" >Card Type:</label>
                        <select name="" id="" class="select">
                            <option value="">Visa	</option>
                            <option value="">Mastercard </option>
                            <option value="">Visa Debit </option>
                            <option value="">Discover </option>
                            <option value="">American Express </option>
                        </select>
                        <img src="images/c_card.png" alt="We process" />
                    </p>
                    <p class="row">
                        <label for="" >Card Number:</label>
                        <input type="text" name="card_no" id="card_no" class="input required creditcard" autocomplete="off" maxlength="20"/>
                    </p>
                    <div class="">
                        <label for="" >Expiry Date:</label>
                    </div>
                    <div class="fl-left" >
                        <select name="MM" id="MM" class="select required" style="margin-right:10px">
                            <option value="">MM</option>
                            <?php
                            $month = array('01'=>'Jan', '02'=>'Feb' , '03'=>'Mar' ,'04'=>'Apr' ,'05'=>'May' , '06'=>'Jun' , '07'=>'Jul' , '08'=>'Aug' , '09'=>'Sep' , '10'=>'Oct' , '11'=>'Nov' ,'12'=>'Dec');
                            foreach($month as $k => $m) {
                                echo '<option value="'.$k.'">'.$k.' ('.$m.') </option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="fl-left">
                        <select name="YYYY" id="YYYY" class="select required">
                            <option value="">YYYY</option>
                            <?php
                            $now = date('Y');
                            for($i = $now ; $i < $now + 11 ; $i ++) {
                                $y = substr($i, strlen($i)-2, 2);
                                echo '<option value="'.$y.'">'.$i.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="clr"></div>
                    <p class="row">&nbsp;</p>
                    <div class="">
                        <label for="">Security number(CSC):</label>
                    </div>
                    <div class="fl-left">
                        <input type="text" name="csc" id="csc" class="input required number" autocomplete="off" maxlength="4"/>
                    </div>
                    <div class="fl-left">
                        <img src="images/card-last3digits.png" alt="" />
                        <span class="small">Last 3 digits of the number on the back of your card</span>
                    </div>
                    <div class="clr"></div>
                    <p class="row">&nbsp;</p>
                    <p class="row">
                        <label for="" >Name on Card:</label>
                        <input type="text" name="full_name" id="full_name" class="input full_name required" value="<?php echo $_SESSION['PAY_POST_VALUE']['user_name']?>"/>
                    </p>
                    <p class="row">
                        <input type="checkbox" name="same_adrress" checked="true" id="same_adrress"/><label for="" style="display:inline-block; width:auto;">Billing address the same as delivery address:</label>
                    </p>
                    <p class="row notsameaddress">
                        <label for="" >Address:</label>
                        <input type="text" name="N_Addr" id="N_Addr" class="input required"/>
                    </p>
                    <p class="row notsameaddress">
                        <label for="" >Postcode:</label>
                        <input type="text" name="N_Postcode" id="N_Postcode" class="input required" />
                    </p>
                    <p class="row txt-center">
                        <label for="" ></label>
                        <input type="submit" name="bycard" id="submitBtn-card" class="btn" value="Place my Order"/>
                        <input type="hidden" name="address" value="<?php echo $_SESSION['PAY_POST_VALUE']['user_address'].', '.$_SESSION['CURRENT_POSTCODE']?>"/>
                        <input type="hidden" name="postcode" value="<?php echo $_SESSION['CURRENT_POSTCODE']?>"/>
                        <input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
                    </p>
                    <div class="row" style="font-size:12px; padding-left:20px">
                        <span>* Card Processing Fee : <b>&pound; <?php echo process_fee()?></b></span>
                    </div>
                </form>
            </div>
            <div class="wrapper-pay-sel" style="display:block">
                <!--<div class="by-card b"><a href="javascript:;" class="slideupdown">Pay Cash On Delivery</a></div>
                <form action="include/cash-payment.php" method="post">
                    <p class="row">
                        <?php
                        if(is_user_cash_verified($_SESSION['userId']) == 'true') {
                            ?>
                            <input type='submit' name='submit' class="btn"  value="Pay by Cash"/>
                            <input type="hidden" name="user_address" value="<?php echo $_SESSION['PAY_POST_VALUE']['user_address'].', '.$_SESSION['CURRENT_POSTCODE']?>"/>
                            <input type="hidden" name="order_note" value="<?php echo $_SESSION['PAY_POST_VALUE']['order_note']?>"/>
                            <input type="hidden" name="user_phoneno" value="<?php echo $_SESSION['PAY_POST_VALUE']['user_phoneno']?>"/>
                        <?php } else {?>
                            *Cash Payment on Delivery Not Verified. <br/>  <br/>

                            <a href="cash-verify.php" class="btn">Verify Now</a>
                        <?php }?>
                    </p>
                </form>
            </div>
        </div>-->


                <div class="wrapper-pay-sel">
                    <div class="by-card b bypaypal">
                        <form action="include/paypal/process.php" method="post">
                            <input type='image' name='submit' src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif' border='0' align='top' alt='Check out with PayPal'/>
                            <input type="hidden" name="user_address" value="<?php echo $_SESSION['PAY_POST_VALUE']['user_address'].', '.$_SESSION['CURRENT_POSTCODE']?>"/>
                            <input type="hidden" name="order_note" value="<?php echo $_SESSION['PAY_POST_VALUE']['order_note']?>"/>
                            <input type="hidden" name="user_phoneno" value="<?php echo $_SESSION['PAY_POST_VALUE']['user_phoneno']?>"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row" style="font-size:12px; padding-left:20px; padding-top:20px">
        <span>* Processing Fee  : <b>&pound; <?php echo process_fee()?></b></span><br>
    </div>
</div>
<div class="clr"></div>
</div>
</div>
<div class="footer">
    <?php require('templates/footer.php');?>
</div>

<!-- Message box include -- >
<?php include_once('include/notification.php');?>

<script type="text/javascript" src="include/sessioncam.js"></script>
<!-- SessionCam -->
</body>
</html>