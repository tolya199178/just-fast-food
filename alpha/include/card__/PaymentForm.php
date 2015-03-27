<?php
	session_start();
	if(!isset($_SESSION['user'])){
		header('Loation:/');
		die();
	}
	if(!isset($_SESSION['CARD_PROCESSING'])) {
		header('Loation:/');
		die();
	}
	if(!isset($_SESSION['CART']) || empty($_SESSION['CART'])){
		$_SESSION['error'] = 'ERROR!. CART is EMPTY!';
		header('Loation:../../order-details.php');
	}

	require_once ("Config.php");
	require_once ("ISOCountries.php");
	require_once ("PreProcessPaymentForm.php");
	include('../functions.php');

	/* echo '<pre>';
	print_r($_SESSION);
	echo '</pre>'; */
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Card Pocessing - Please Wait .. - Just-FastFood</title>
</head>
<body style="background:#F0EEDF" <?= $BodyAttributes ?>>
<form name="Form" action="<?= $FormAction ?>" method="post"<?= $FormAttributes ?>>
<?php
	switch ($NextFormMode) {
		case "RESULTS":
			echo '<input name="FormMode" type="hidden" value="'.$NextFormMode.'" />';
			if (isset($DuplicateTransaction) != true) {
				$DuplicateTransaction=false;
			}
			if ($DuplicateTransaction == true) {
				//echo $PreviousTransactionMessage;
				$_SESSION['error'] = '<b style="font-size:13px">Duplicate Transaction! <br/>'.$PreviousTransactionMessage.'</b>';
				header('Location:../../pay.php');
				die();
			}

			if ($TransactionSuccessful == false) {

				$_SESSION['error'] = '<b style="font-size:13px">ERROR in Card Transaction. Please Try Again <br/>'.$Message.'</b>';
				error_log('ERROR in Card Transaction. User '.$_SESSION['user'].' Id: '.$_SESSION['userId'].' '.$Message,0);
				unset($_SESSION['CARD_PROCESSING']);
				header('Location:../../pay.php');
				//die();
				//print_r($_SESSION);

			} else {
				require_once('../order-movement.php');

				$_SESSION['CHECKOUT_WITH'] = "By Card";
				$_SESSION['CART_SUBTOTAL'] = $_SESSION['T_CART_SUBTOTAL'];
				$_SESSION['ORDER_TRANSACTION_DETAILS'] = array($Message);
				$_SESSION['ORDER_TRANSACTION_DETAILS']['TRANSACTIONID'] = $_SESSION['Current_Trans_Id'];
				$_SESSION['ORDER_TRANSACTION_DETAILS']['CrossReference'] = $ActuallCrossReference;
				$_SESSION['user_address'] = $_SESSION['PAY_POST_VALUE']['user_address'];
				$_SESSION['order_note'] = $_SESSION['CARD_PROCESSING']['order_note'];
				$_SESSION['user_phoneno'] = $_SESSION['CARD_PROCESSING']['user_phoneno'];
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

				unset($_SESSION['CARD_PROCESSING']);
				header('location:../../order-complete.php');
				die();
			}

			print '<br><br><br><br>SUCCESS : '.$Message.'<br><br><br><br>';


		break;
		case "THREE_D_SECURE":
	?>
			<input name="PaReq" type="hidden" value="<?= $PaREQ ?>" />
			<input name="MD" type="hidden" value="<?= $CrossReference ?>" />
			<input name="TermUrl" type="hidden" value="<?= $SiteSecureBaseURL ?>ThreeDSecureLandingPage.php" />

			<iframe id="ACSFrame" name="ACSFrame" src="<?= $SiteSecureBaseURL ?>Loading.htm" width="800" height="400" frameborder="0"></iframe>
	<?php
		break;
		case "PAYMENT_FORM":

			if (isset($Message) == true) {
				if ($Message != "") {
					$_SESSION['error'] = '<b style="font-size:13px">ERROR In Card Details. Please Try Again <br/>'.$Message.'</b>';
					//echo $_SESSION['error'];
					header('Location:../../pay.php');
				}
			}

			$_SESSION['T_CART_SUBTOTAL'] = $_SESSION['CART_SUBTOTAL'] + process_fee();
			$_SESSION['Current_Trans_Id'] = 'order_'.$_SESSION['access_key'];
		?>
			<script type="text/javascript">
				window.onload = function() { document.Form.submit(); }
			</script>

			<div style="background: white; margin-bottom:15px"><img src="../../email-images/logo.png" alt="LOGO"/></div>
			<h1 style="text-align:center;">Processing ...</h1>
			<h3 style="text-align:center">Please Wait While Your Payment Is Processed ...</h3>
			<div style="text-align:center; margin:20px" ><img src="Ajax_Loading.gif" alt=""/></div>

				<input name="FormMode" type="hidden" value="<?= $NextFormMode ?>" />
				<input type="hidden" name="Amount" value="<?= $_SESSION['T_CART_SUBTOTAL']*100?>" />
				<input type="hidden" name="CurrencyISOCode" value="826" />
				<input type="hidden" name="OrderID" value="<?= $_SESSION['Current_Trans_Id']?>" />
				<input type="hidden" name="OrderDescription" value="<?=  'An '.$_SESSION['RESTAURANT_TYPE_CATEGORY'].' Order. Amount '.$_SESSION['T_CART_SUBTOTAL'].' pound. By '.$_SESSION['user'].' (user id: '.$_SESSION['userId'].')'?>" />
				<input type="hidden" name="CardName" value="<?= $_SESSION['CARD_PROCESSING']['full_name'] ?>"/>
				<input type="hidden" name="CardNumber" value="<?= $_SESSION['CARD_PROCESSING']['card_no'] ?>" />

				<input type="hidden" name="ExpiryDateMonth" value="<?= $_SESSION['CARD_PROCESSING']['MM'] ?>" />
				<input type="hidden" name="ExpiryDateYear" value="<?= $_SESSION['CARD_PROCESSING']['YYYY'] ?>" />
				<input type="hidden" name="IssueNumber" value="<?= $IssueNumber ?>"/>
				<input type="hidden" name="CV2" value="<?= $_SESSION['CARD_PROCESSING']['csc'] ?>" />

				<input type="hidden" name="Address1" value="<?= (isset($_SESSION['CARD_PROCESSING']['address_1'])) ? $_SESSION['CARD_PROCESSING']['address_1'] : $_SESSION['PAY_POST_VALUE']['address']; ?>"/>
				<input type="hidden" name="Address2" value="<?= $Address2 ?>"/>
				<input type="hidden" name="Address3" value="<?= $Address3 ?>"/>
				<input type="hidden" name="Address4" value="<?= $Address4 ?>"/>
				<input type="hidden" name="StartDateMonth" value="<?= $StartDateMonth ?>"/>
				<input type="hidden" name="StartDateYear" value="<?= $StartDateYear ?>"/>
				<input type="hidden" name="City" value="<?= $City ?>"/>
				<input type="hidden" name="State" value="<?= $State ?>"/>
				<input type="hidden" name="PostCode" value="<?= (isset($_SESSION['CARD_PROCESSING']['postcode_1'])) ? $_SESSION['CARD_PROCESSING']['postcode_1'] : $_SESSION['CURRENT_POSTCODE'];?>"/>
				<input type="hidden" name="CountryISOCode" value="826"/>
<?php
		break;
		default:
			echo 'SOMETHING GOING  WRONG....';
			break;
	}
?>
</form>
<script type="text/javascript">
adroll_adv_id = "JQVQA2EPTFBIVFRG4SDKBR";
adroll_pix_id = "O56HCPIZBJDYXNIE4XFZX2";
(function () {
var oldonload = window.onload;
window.onload = function(){
   __adroll_loaded=true;
   var scr = document.createElement("script");
   var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
   scr.setAttribute('async', 'true');
   scr.type = "text/javascript";
   scr.src = host + "/j/roundtrip.js";
   ((document.getElementsByTagName('head') || [null])[0] ||
    document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
   if(oldonload){oldonload()}};
}());
</script>

</body>
</html>