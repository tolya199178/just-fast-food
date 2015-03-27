<?php
	session_start();
	if(!isset($_SESSION['user'])){
		header('Location:/');
		die();
	}
	if(!isset($_SESSION['CARD_PROCESSING'])) {
		header('Location:/');
		die();
	}
	if(!isset($_SESSION['CART']) || empty($_SESSION['CART'])){
		$_SESSION['error'] = 'ERROR!. CART is EMPTY!';
		header('Location:../../order-details.php');
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
	<title>Card Processing - Please Wait .. - Just-FastFood</title>
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
		} else {

		// New submission.
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

			// Include the Braintree library:
			require_once('include/braintree-php/lib/Braintree.php');

			// set your secret key: remember to change this to your live secret key in production
			// see your keys here https://manage.stripe.com/account
			//Stripe::setApiKey('sk_live_xVEJg6Mx4rqiM0e0wDS0dZyA');

            Braintree_Configuration::environment('sandbox');
            Braintree_Configuration::merchantId('k54nrwhr42sqwfz4');
            Braintree_Configuration::publicKey('86pmzd5bzdysnn5q');
            Braintree_Configuration::privateKey('341f05ee992ec4bec234c6c52453c783');

			// Charge the order:
			/*$charge = Stripe_Charge::create(array(
				"amount" => $amount, // amount in cents, again
				"currency" => "gbp",
				"card" => $token,
				"description" => $description
				)
			);*/

            // Charge the order

            $charge =  Braintree_Transaction::sale(array(
                    'amount' => $amount,
                    'creditCard'=> array(
                        'number'=> '',
                        'expirationMonth' => '',
                        'expirationYear' => ''
                    )
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
			  echo $_SESSION['error'];
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
      echo $_SESSION['error'];
			error_log('Network problem, perhaps try again. User '.$_SESSION['user'].' Id: '.$_SESSION['userId'],0);
			unset($_SESSION['CARD_PROCESSING']);
			header('Location:../../pay.php');
			die();

		} catch (Stripe_InvalidRequestError $e) {
		    // You screwed up in your programming. Shouldn't happen!

			$_SESSION['error'] = 'You screwed up.<br/>';
      echo $_SESSION['error'];
			error_log('Network problem, perhaps try again. User '.$_SESSION['user'].' Id: '.$_SESSION['userId'],0);
			unset($_SESSION['CARD_PROCESSING']);
			header('Location:../../pay.php');
			die();

		} catch (Stripe_ApiError $e) {
		    // Stripe's servers are down!

			$_SESSION['error'] = "Server are down!.<br/>";
      echo $_SESSION['error'];
			error_log('Server are down!. '.$_SESSION['user'].' Id: '.$_SESSION['userId'],0);
			unset($_SESSION['CARD_PROCESSING']);
			header('Location:../../pay.php');
			die();

		} catch (Stripe_CardError $e) {
		    // Something else that's not the customer's fault.

			$_SESSION['error'] = "Something else that's not the customer's fault..<br/>";
      echo $_SESSION['error'];
      error_log("Something else that's not the customer's fault.. ".$_SESSION['user'].' Id: '.$_SESSION['userId'],0);
			unset($_SESSION['CARD_PROCESSING']);
			header('Location:../../pay.php');
			die();
		}

	} // A user form submission error occurred, handled below.

} else {
	header('Location:/');
		die();
}

?>

<?php if($_SESSION['error']){ ?>
  <div class="modal fade" style="z-index:999999999; overflow: hidden;" id="error-modal" tabindex="-1" role="dialog" aria-labelledby="error-modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="overflow: hidden">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title" style="font-weight: normal; font-size: 20px">
            <?php echo 'Transaction error!';?>
          </h4>
        </div>
        <div class="modal-body" style="font-weight: 300">
          <?php echo $_SESSION['error'];?>
        </div>
        <div class="modal-footer">
          <button id="index-go" type="button" class="btn" data-dismiss="modal">OK</button>
        </div>
      </div>
    </div>

  </div>
<?php } ?>
</body>
</html>