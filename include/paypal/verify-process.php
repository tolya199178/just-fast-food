<?php
session_start();

require('../auth.php');
/*
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
//die();
 */
include_once("config.php");
include_once("paypal.class.php");
include_once("../functions.php");

$PayPalReturnURL 		= 'https://just-fastfood.com/include/paypal/verify-process.php'; //Point to process.php page
$PayPalCancelURL 		= 'https://just-fastfood.com/my-profile.php'; //Cancel URL if user clicks cancel

$cash_verification_fee = cash_verification_fee();
$process_fee = process_fee();
$ITEMS = '';
$count = 0;
$_SESSION['T_SUBTOTAL'] = $cash_verification_fee + $process_fee;

$ITEMS .= '&L_PAYMENTREQUEST_0_NAME'.$count.'='.urlencode('Cash Verification Fee');
$ITEMS .= '&L_PAYMENTREQUEST_0_NUMBER'.$count.'='.urlencode($_SESSION['userId']);
$ITEMS .= '&L_PAYMENTREQUEST_0_AMT'.$count.'='.urlencode($cash_verification_fee);
$ITEMS .= '&L_PAYMENTREQUEST_0_QTY'.$count.'='.urlencode('1');
$ITEMS .= '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($cash_verification_fee);
$ITEMS .= '&PAYMENTREQUEST_0_TAXAMT='.urlencode($process_fee);
$ITEMS .= '&PAYMENTREQUEST_0_SHIPDISCAMT=-'.urlencode('');
$ITEMS .= '&PAYMENTREQUEST_0_AMT='.urlencode($_SESSION['T_SUBTOTAL']);

//Data to be sent to paypal
$padata = 	'&CURRENCYCODE='.urlencode($PayPalCurrencyCode).
    '&PAYMENTACTION=Sale'.
    '&ALLOWNOTE=1'.
    '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
    $ITEMS.
    '&RETURNURL='.urlencode($PayPalReturnURL ).
    '&CANCELURL='.urlencode($PayPalCancelURL);

//We need to execute the "SetExpressCheckOut" method to obtain paypal token
$paypal= new MyPayPal();
$httpParsedResponseAr = $paypal->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

//Respond according to message we receive from Paypal
if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
{

    if($PayPalMode=='sandbox')
    {
        $paypalmode 	=	'.sandbox';
    }
    else
    {
        $paypalmode 	=	'';
    }
    //Redirect user to PayPal store with Token received.
    $paypalurl ='https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
    header('Location: '.$paypalurl);

}else{
    //Show error message
    echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
    echo '<pre>';
    print_r($httpParsedResponseAr);
    echo '</pre>';
}


//Paypal redirects back to this page using ReturnURL, We should receive TOKEN and Payer ID
if(isset($_GET["token"]) && isset($_GET["PayerID"]))
{
    //we will be using these two variables to execute the "DoExpressCheckoutPayment"
    //Note: we haven't received any payment yet.

    $token = $_GET["token"];
    $playerid = $_GET["PayerID"];

    $padata = 	'&TOKEN='.urlencode($token).
        '&PAYERID='.urlencode($playerid).
        '&PAYMENTACTION='.urlencode("SALE").
        '&AMT='.urlencode($_SESSION['T_SUBTOTAL']).
        '&CURRENCYCODE='.urlencode($PayPalCurrencyCode);

    //We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
    $paypal= new MyPayPal();
    $httpParsedResponseAr = $paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

    //Check if everything went ok..
    if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
    {
        $details['by'] = 'Paypal';
        $details['details'] = $httpParsedResponseAr;
        user_verified_cash($details, $_SESSION['userId']);
        /* echo '<pre>';
        print_r($_SESSION);
        echo '</pre>'; */
        unset($_SESSION['TO_CASH_VERIFIED']);
        if(isset($_SESSION['CART'])) {
            header('location:../../pay.php');
        } else {
            header('location:../../my-profile.php');
        }
        die();
    }else{
        echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
        echo '<pre>';
        print_r($httpParsedResponseAr);
        echo '</pre>';
    }
}

?>