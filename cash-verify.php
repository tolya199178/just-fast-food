<?php
session_start();
require('include/auth.php');
include('include/functions.php');


if(is_user_cash_verified($_SESSION['userId']) == 'true') {
    $_SESSION['success'] = 'Your order by cash payment already verified';
    header('Location:my-profile.php');
    die();
}

// CARD POCESSING
if(isset($_POST['bycard'])) {
    $_SESSION['CARD_PROCESSING'] = $_POST;
    $_SESSION['TO_CASH_VERIFIED'] = 'true';
    if(!empty($_POST['N_Addr'])) {
        $_SESSION['CARD_PROCESSING']['address_1'] = $_POST['N_Addr'];
        $_SESSION['CARD_PROCESSING']['postcode_1'] = $_POST['N_Postcode'];
    }
    header('Location:include/card/PaymentForm.php');
    die();
}

$cash_verification_fee = cash_verification_fee();

//$_SESSION['CART_SUBTOTAL'] = $_SESSION['CART_SUBTOTAL'] + process_fee();
$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());

?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Verify Order By Cash, <?= getDataFromTable('setting','meta'); ?>">
    <meta name="keywords" content="Verify Cash User,Pay your Order , Paypal , Cradit Card, <?= getDataFromTable('setting','keywords'); ?>">
    <meta name="author" content="M Awais">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="apple-touch-icon" href="items-pictures/default_rest_img.png">

    <link rel="shortcut icon" href="images/favicon.ico">
    <title>Verify Cash User - Just-FastFood</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />

    <link href="css/iphone.css" rel="stylesheet" type="text/css" media="only screen and (min-width: 0px) and (max-width: 320px)" >
    <link href="css/ipad.css" rel="stylesheet" type="text/css"  media="only screen and (min-width: 321px) and (max-width: 768px)" >

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script type="text/javascript" src="js/validate.js"></script>
    <script type="text/javascript" src="js/mobileMenu.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#pay-by-cradit-card").validate();
            $('#main-nav').mobileMenu();
        });
    </script>
    <style type="text/css">
        .securebycardsave{
            background: #DDD;
            padding: 7px;
            margin-bottom: 15px;
            border-radius: 50px;
            padding-top: 18px;
            margin-top: -12px;
        }
        #pay-by-cradit-card{
            display:block;
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
                <li><a href="my-profile.php">My Profile</a></li>
                <li class="u">Cash Verify</li>
                <?php if(isset($_SESSION['CART'])) {?>
                    <li><a href="pay.php">Back to Order</a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="fl-left cash-verifyWrap">
            <div class="box-wrap">
                <div class="order-details-wrap order-details-wrapcash" style="width:380px">
                    <div class="txt-center b">Details</div>
                    <hr class="hr" />
                    <div class="order pay">

                        <div class="txt-left total b">
                            <span>Cash Verification Fee: </span>
                            <span>&pound; <?php echo number_format($cash_verification_fee, 2); ?></span>
                        </div>
                        <div class="txt-right total">
                            <div class="row">
                                <span class="span">Processing Fee : </span>
                                <span class="b">&pound; <?php echo process_fee()?></span>
                            </div>
                        </div>

                        <div class="totalpay b">
                            <p class="fl-right">
                                <span class="">Sub Total : &nbsp;&nbsp;</span>
                                <?php
                                $TOTAL = $cash_verification_fee + process_fee();
                                ?>
                                <span> &pound; </span><span class="p"><?php echo number_format($TOTAL,2);?></span>
                            </p>
                            <div class="clr"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-address weprocess cbox-wrap txt-center">
                <img src="images/41268133.png" alt="We process" />
            </div>
        </div>
        <div class="fl-left pay-detail verify-Detail-card">

            <div class=" login-wrap">
                <div class="inner-border">
                    <div class="red-wrap" style="padding: 6px;">
                        <h2 style="font-size: 18px;">How would you like to pay?</h2>
                    </div>
                    <!--<hr class="hr" />-->

                    <?php include('include/notification.php');?>
                    <!--<div class="wrapper-pay-sel">
                        <div class="by-card b"><a href="javascript:;" class="slideupdown">Pay By Card *</a></div>

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
                                <img src="images/c_card.png" alt="We process" class="img"/>
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
                            <div class="fl-left" style="margin-left:10px">
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
                                <input type="text" name="csc" id="csc" class="input required" autocomplete="off" maxlength="4"/>
                            </div>
                            <div class="fl-left">
                                <img src="images/card-last3digits.png" alt="" />
                                <span class="small">Last 3 digits of the number on the back of your card</span>
                            </div>
                            <div class="clr"></div>
                            <p class="row">&nbsp;</p>
                            <p class="row">
                                <label for="" >Name on Card:</label>
                                <input type="text" name="full_name" id="full_name" class="input full_name required" value="<?php echo $_POST['user_name']?>"/>
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
                                <input type="submit" name="bycard" id="" class="btn" value="Submit"/>
                                <input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
                            </p>
                            <div class="row" style="font-size:12px; padding-left:20px">
                                <span>* Card Processing Fee : <b>&pound; <?php echo process_fee()?></b></span>
                            </div>
                        </form>
                    </div>-->


                    <div class="wrapper-pay-sel">
                        <div class="by-card b bypaypal">
                            <form action="include/paypal/verify-process.php" method="post">
                                <input type='image' name='submit' src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif' border='0' align='top' alt='Check out with PayPal'/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="font-size:12px; padding-left:20px; padding-top:20px">
                <span>* Processing Fee  : <b>&pound; <?php echo process_fee()?></b></span><br>
                <span>* The <strong><b>£1 </b></strong>verification fee is for us to ensure we don't get spammed</span>
                <span>* Its a one-time verification. You wouldn't be asked to do this again.  </span>
            </div>
        </div>
        <div class="clr"></div>
    </div>
</div>
<div class="footer">
    <?php require('templates/footer.php');?>
</div>
</body>
</html>