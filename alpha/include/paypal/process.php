<?php
session_start();
if(!isset($_SESSION['user'])){
	header('Loation:/');
}

if(!isset($_SESSION['CART'])) {
	header('location:/');
	die();

}

if(!isset($_SESSION['CART']) || empty($_SESSION['CART'])){
	$_SESSION['error'] = 'ERROR!. CART is EMPTY!';
	header('Loation:../../order-details.php');
}

if(!isset($_GET["token"]) || !isset($_GET["PayerID"])) {
	if(!isset($_POST['user_address']) || empty($_POST['user_address']) || empty($_POST['user_phoneno'])) {
		$_SESSION['error'] = "Sorry! Your Session Key Expired!. Please try again to continue";
		header('Location:../../order-details.php');
		die();
	}
}

/*
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
//die();
 */
include_once("config.php");
include_once("paypal.class.php");
include_once("../functions.php");


if(isset($_SESSION['CART']) && isset($_POST['user_address']) && isset($_POST['order_note']) && isset($_POST['user_phoneno']))
{
	$ITEMS = '';
	$count = 0;
	if(!isset($_SESSION['ALREADY_ADDED_PROCESS_FEE'])) {
		$_SESSION['CART_SUBTOTAL'] = $_SESSION['CART_SUBTOTAL'] + process_fee();
		$_SESSION['ALREADY_ADDED_PROCESS_FEE'] = 'true';
	}

	$_SESSION['CHECKOUT_WITH'] = 'paypal';
	$_SESSION['user_address'] = $_POST['user_address'];
	$_SESSION['order_note'] = $_POST['order_note'];
	$_SESSION['user_phoneno'] = $_POST['user_phoneno'];

	foreach($_SESSION['CART'] as $key => $value) {
		if($key != 'TOTAL') {
			$ITEMS .= '&L_PAYMENTREQUEST_0_NAME'.$count.'='.urlencode($value['NAME']);
			$ITEMS .= '&L_PAYMENTREQUEST_0_NUMBER'.$count.'='.urlencode($value['ID']);
			$ITEMS .= '&L_PAYMENTREQUEST_0_AMT'.$count.'='.urlencode($value['TOTAL'] / $value['QTY']);
			$ITEMS .= '&L_PAYMENTREQUEST_0_QTY'.$count.'='.urlencode($value['QTY']);

			$count ++;
		}
	}
	$ITEMS .= '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($_SESSION['CART']['TOTAL']);
	$ITEMS .= '&PAYMENTREQUEST_0_TAXAMT='.urlencode($_SESSION['DELIVERY_CHARGES'] + process_fee());
	$ITEMS .= '&PAYMENTREQUEST_0_SHIPDISCAMT=-'.urlencode($_SESSION['SPECIAL_DISCOUNT']);
	$ITEMS .= '&PAYMENTREQUEST_0_AMT='.urlencode($_SESSION['CART_SUBTOTAL']);

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
						'&AMT='.urlencode($_SESSION['CART_SUBTOTAL']).
						'&CURRENCYCODE='.urlencode($PayPalCurrencyCode);

	//We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
	$paypal= new MyPayPal();
	$httpParsedResponseAr = $paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

	//Check if everything went ok..
	if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
	{
		include_once('../functions.php');
		include_once('../order-movement.php');

		$_SESSION['ORDER_TRANSACTION_DETAILS']['TRANSACTIONID'] = $httpParsedResponseAr["TRANSACTIONID"];
		$_SESSION['ORDER_TRANSACTION_DETAILS']['PAYMENTSTATUS'] = $httpParsedResponseAr["PAYMENTSTATUS"];

		$transactionID = urlencode($httpParsedResponseAr["TRANSACTIONID"]);
		$nvpStr = "&TRANSACTIONID=".$transactionID;
		$paypal= new MyPayPal();
		$httpParsedResponseAr = $paypal->PPHttpPost('GetTransactionDetails', $nvpStr, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
			$_SESSION['ORDER_TRANSACTION_DETAILS']['SUCCESS'] = $httpParsedResponseAr;
		} else  {
			$_SESSION['ORDER_TRANSACTION_DETAILS']['ERROR'] = $httpParsedResponseAr;
		}

		$_SESSION['delivery_type'] = json_encode($_SESSION['delivery_type']);

		$_SESSION['CURRENT_ORDER_ID'] = insertOrder();

		$select = "`setting_auto_order`";
		$where = " 1 ";
		$result_setting = SELECT($select ,$where, 'setting', 'array');

		if(($_SESSION['RESTAURANT_TYPE_CATEGORY'] == 'fastfood') && ($result_setting['setting_auto_order'] == 'on') && ($_SESSION['delivery_type'] != 'delivery')) {
			$json_post = getEandN($_SESSION['CURRENT_POSTCODE']);
			assignOrder($_SESSION['CURRENT_ORDER_ID'] ,toStaffId($json_post ,$_SESSION['CURRENT_POSTCODE']));
		} else if($_SESSION['RESTAURANT_TYPE_CATEGORY'] == 'takeaway'){

			$select = "`type_is_delivery`";
			$where = "`type_id` = '".$_SESSION['DELIVERY_REST_ID']."'";
			$result_setting = SELECT($select ,$where, 'menu_type', 'array');
			if($result_setting['type_is_delivery'] == 'no') {
				$json_post = getEandN($_SESSION['CURRENT_POSTCODE']);
				assignOrder($_SESSION['CURRENT_ORDER_ID'] ,toStaffId($json_post ,$_SESSION['CURRENT_POSTCODE']));
			} else {
				assignOrderTakeaway();
			}
		}

		/* echo '<pre>';
		print_r($_SESSION);
		echo '</pre>'; */
		header('location:../../order-complete.php');
		die();
	}else{
			echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
			echo '<pre>';
			print_r($httpParsedResponseAr);
			echo '</pre>';
	}
}

?>