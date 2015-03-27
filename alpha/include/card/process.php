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
<body style="background:#F0EEDF">
	<div style="background: white; margin-bottom:15px"><img src="../../email-images/logo.png" alt="LOGO"/></div>
	<h1 style="text-align:center;">Processing ...</h1>
	<h3 style="text-align:center">Please Wait While Your Payment Is Processed ...</h3>
	<div style="text-align:center; margin:20px" ><img src="Ajax_Loading.gif" alt=""/></div>
<?php

// Check for a form submission:
if(isset($_SESSION['CARD_PROCESSING'])) {

	// Stores errors:
	$errors = array();

	// Need a payment token:
	if (isset($_SESSION['CARD_PROCESSING']['stripeToken'])) {

		$token = $_SESSION['CARD_PROCESSING']['stripeToken'];

		// Check for a duplicate submission, just in case:
		// Uses sessions, you could use a cookie instead.
		if (isset($_SESSION['token']) && ($_SESSION['token'] == $token)) {
			$errors['token'] = 'You have apparently resubmitted the form. Please do not do that.';
		} else { // New submission.
			$_SESSION['token'] = $token;
		}

	} else {
		$errors['token'] = 'The order cannot be processed. Invalid Token. Try Again';
	}

	if (isset($errors) && !empty($errors) && is_array($errors)) {
		$_SESSION['error'] = $errors['token'];
		header('Location:../../pay.php');
		die();
	}

	$_SESSION['T_CART_SUBTOTAL'] = $_SESSION['CART_SUBTOTAL'] + process_fee();
	$_SESSION['Current_Trans_Id'] = 'order_'.$_SESSION['access_key'];

	// Set the order amount somehow:
	$amount = $_SESSION['T_CART_SUBTOTAL'] *100;
	$description = 'An '.$_SESSION['RESTAURANT_TYPE_CATEGORY'].' Order. Amount '.$_SESSION['T_CART_SUBTOTAL'].' pound. By '.$_SESSION['user'].' (user id: '.$_SESSION['userId'].')';
	// Validate other form data!

	// If no errors, process the order:
	if (empty($errors)) {

		// create the charge on Stripe's servers - this will charge the user's card
		try {

			// Include the Stripe library:
			require_once('include/lib/Stripe.php');

			// set your secret key: remember to change this to your live secret key in production
			// see your keys here https://manage.stripe.com/account
			Stripe::setApiKey('sk_live_30hkNXblsQSIk5kb99hKCJGW');

			// Charge the order:
			$charge = Stripe_Charge::create(array(
				"amount" => $amount, // amount in cents, again
				"currency" => "gbp",
				"card" => $token,
				"description" => $description
				)
			);

			// Check that it was paid:
			if ($charge->paid == true) {

				// Store the order in the database.
				// Send the email.
				/* echo 'Celebrate!';
				echo '<pre>';
				print_r((array)$charge);
				echo '</pre>'; */


				require_once('../order-movement.php');

				$_SESSION['CHECKOUT_WITH'] = "By Card";
				$_SESSION['CART_SUBTOTAL'] = $_SESSION['T_CART_SUBTOTAL'];
				$_SESSION['ORDER_TRANSACTION_DETAILS'] = (array)$charge;
				$_SESSION['ORDER_TRANSACTION_DETAILS']['TRANSACTIONID'] = $_SESSION['Current_Trans_Id'];
				$_SESSION['ORDER_TRANSACTION_DETAILS']['CrossReference'] = $charge->id;
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


			} else { // Charge was not paid!
				$_SESSION['error'] =  'Payment System Error!<br/>Your payment could NOT be processed (i.e., you have not been charged) because the payment system rejected the transaction. You can try again or use another card.';
			}

		} catch (Stripe_CardError $e) {
		    // Card was declined.
			$e_json = $e->getJsonBody();
			$err = $e_json['error'];
			$errors['stripe'] = $err['message'];
			$_SESSION['error'] = 'Card was declined.<br/>'.$errors['stripe'];
			error_log('ERROR in Card Transaction. User '.$_SESSION['user'].' Id: '.$_SESSION['userId'].' '.$errors['stripe'],0);
			unset($_SESSION['CARD_PROCESSING']);
			header('Location:../../pay.php');
			die();

		} catch (Stripe_ApiConnectionError $e) {
		    // Network problem, perhaps try again.

			$_SESSION['error'] = 'Network problem, perhaps try again';
			error_log('Network problem, perhaps try again. User '.$_SESSION['user'].' Id: '.$_SESSION['userId'],0);
			unset($_SESSION['CARD_PROCESSING']);
			header('Location:../../pay.php');
			die();

		} catch (Stripe_InvalidRequestError $e) {
		    // You screwed up in your programming. Shouldn't happen!

			$_SESSION['error'] = 'You screwed up.<br/>';
			error_log('Network problem, perhaps try again. User '.$_SESSION['user'].' Id: '.$_SESSION['userId'],0);
			unset($_SESSION['CARD_PROCESSING']);
			header('Location:../../pay.php');
			die();

		} catch (Stripe_ApiError $e) {
		    // Stripe's servers are down!

			$_SESSION['error'] = "Server are down!.<br/>";
			error_log('Server are down!. '.$_SESSION['user'].' Id: '.$_SESSION['userId'],0);
			unset($_SESSION['CARD_PROCESSING']);
			header('Location:../../pay.php');
			die();

		} catch (Stripe_CardError $e) {
		    // Something else that's not the customer's fault.

			$_SESSION['error'] = "Something else that's not the customer's fault..<br/>";
			error_log("Something else that's not the customer's fault.. ".$_SESSION['user'].' Id: '.$_SESSION['userId'],0);
			unset($_SESSION['CARD_PROCESSING']);
			header('Location:../../pay.php');
			die();
		}

	} // A user form submission error occurred, handled below.

} else {
	header('Loation:/');
		die();
}

?>

</body>
</html>