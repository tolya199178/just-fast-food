<?php

$MSG = "";
$MSG_SUBJ = "";
include_once('functions.php');

function SENDMAIL($GET ,$CC) {
	switch($GET['type']) {
		case 'verify-acct':
			$MSG = '<strong>Thank you! for your interest in Just-FastFood.com.</strong><br/><br/>';
			$MSG .= 'Please Follow This Link To Verify Your Email. <strong><a href="http://just-fastfood.com/verify-email.php?">Veify My Email</a></strong><br/><br/>';
			$MSG .= 'If Link Does Not Work Please Copy And Paste This Address in Your Address Bar';

			$MSG_SUBJ = "Verify Your Account";
		break;
		
		case 'new-user-reg-live':
			$MSG = '<strong>Thanks for visit at Just-FastFood.com. You will be notify when we live.</strong><br/><br/>';

			$MSG_SUBJ = "Thanks for visit";
		break;

		case 'upt-pass':
			$MSG = '<strong>Thank you! for your interest in Just-FastFood.com.</strong><br/><br/>';
			$MSG .= 'Please Follow This Link To Update Your Password. <strong><a href="http://just-fastfood.com/beta/forgot-password.php?vcode='.$GET['vcode'].'">http://just-fastfood.com/'.$GET['link'].'.php?vcode='.$GET['vcode'].'</a></strong><br/><br/>';
			$MSG .= 'If Link Does Not Work Please Copy And Paste This Link to Your Address Bar';

			$MSG_SUBJ = "Update Your Password";
		break;		case 'order_complete_error':			$MSG = '<strong>An Error occoured in Order Completion!</strong><br/>';			$MSG .= 'Details Below<br/><br/>';			foreach($GET['details'] as $name => $detail) {				$MSG .= $name . ' : '. urldecode($detail).'<br/>';			}			$MSG_SUBJ = "Error in Order Completion";		break;		case 'refund_email':			$MSG = '<strong>A Refund Status Details Below:</strong><br/>';			$MSG .= 'ERROR : '.$GET['details']['eror'].'<br><br>';			foreach($GET['details']['return'] as $name => $detail) {				$MSG .= $name . ' : '. urldecode($detail).'<br/>';			}			$MSG_SUBJ = "Refund Status Order id : ".$GET['order_id'];		break;

		case 'new_order_takeaway':
			$MSG = 'A New Order Received From <strong>'.$GET['user_name'].'</strong><br/><br/>';

			$order_type = json_decode($GET['order_delivery_type'] ,true);

			$MSG .= '<h2>Order Type:'.$order_type['type'].' '.$order_type['time'].'</h2>';
			$MSG .= 'Email : <strong>'.$GET['user_email'].'</strong><br/>';
			$MSG .= 'Order ID : <strong>'.$GET['order_id'].'</strong><br/>';
			$MSG .= 'Transaction ID : <strong>'.$GET['order_transaction_id'].'</strong><br/>';
			$MSG .= 'Post Code : <strong>'.$GET['order_postcode'].'</strong><br/>';
			$MSG .= 'Address : <strong>'.$GET['order_address'].'</strong><br/><br/>';
			$MSG .= 'Order Note : <strong>'.$GET['order_note'].'</strong><br/>';
			$MSG .= 'Phone No : <strong>'.$GET['order_phoneno'].'</strong><br/>';

			$Array = json_decode($GET['order_details'] ,true);

			$MSG .= 'Total Items : <strong>'.(count($Array) -1).'</strong><br/>';
			$MSG .= 'Orderd List Below: <br/>';

			$MSG .= '<div>';

			foreach($Array as $key => $val) {
				if($key != 'TOTAL') {
					$MSG .= '<p style="border: 1px dotted #DDDDDD; padding: 2px;">';
					foreach($val as $k => $v) {
						if($k == 'TOTAL') {
							$MSG .= '<span style="display: block; padding: 0px 5px 0px 5px; margin:0px; font-size: 12px;">'.$k.':  &pound; '.number_format($v, 2).'</span>';
						} else {
							$MSG .= '<span style="display: block; padding: 0px 5px 0px 5px; margin:0px; font-size: 12px;">'.$k.' :  '.$v.'</span>';
						}
					}
					$MSG .= '</p>';
				}
			}

			$MSG .= '</div>';
			$MSG .= 'Please see SMS or go to your profile to Confirm or Cancel This Order<br/>';

			$MSG_SUBJ = "New Order Places";
			break;

		case 'new_order_user':

			$Array = json_decode($GET['order_details'] ,true);

			$MSG = '<strong>Thanks for your order at Just-FastFood.com</strong><br/><br/>';
			$MSG .= 'Your Order Details:<br/><br/>';
			$MSG .= 'Order ID : <strong>'.$GET['order_id'].'</strong><br/>';
			$MSG .= 'Transaction ID : <strong>'.$GET['order_transaction_id'].'</strong><br/>';
			$MSG .= 'Payment Type : <strong>'.strtoupper($GET['order_payment_type']).'</strong><br/>';
			$MSG .= 'Name : <strong>'.$GET['user_name'].'</strong><br/>';
			$MSG .= 'Email : <strong>'.$GET['user_email'].'</strong><br/>';
			$MSG .= 'Post Code : <strong>'.$GET['order_postcode'].'</strong><br/>';
			$MSG .= 'Address : <strong>'.$GET['order_address'].'</strong><br/><br/>';
			$MSG .= 'Total Items : <strong>'.(count($Array) -1).'</strong><br/>';
			$MSG .= 'Orderd List Below: <br/>';

			$MSG .= '<div>';

			foreach($Array as $key => $val) {
				if($key != 'TOTAL') {
					$MSG .= '<p style="border: 1px dotted #DDDDDD; padding: 2px;">';
					foreach($val as $k => $v) {
						if($k == 'TOTAL') {
							$MSG .= '<span style="display: block; padding: 0px 5px 0px 5px; margin:0px; font-size: 12px;">'.$k.':  &pound; '.number_format($v, 2).'</span>';
						} else {
							$MSG .= '<span style="display: block; padding: 0px 5px 0px 5px; margin:0px; font-size: 12px;">'.$k.' :  '.$v.'</span>';
						}
					}
					$MSG .= '</p>';
				}
			}

			$MSG .= '</div>';
			$MSG .= 'Total Amount : <strong>&pound; '.number_format($GET['order_tatal'], 2).'</strong><br/><br/>';
			$MSG .= '<strong>Your Order is on the way.</strong><br/>';
			$MSG_SUBJ = "Thanks for your order!";
			break;

		case 'cancel_order_user':
			$MSG = '<strong>Your order is canceled at Just-FastFood.com</strong><br/><br/>';
			$MSG .= 'We apologise for this order cancellation. Restaurant is busy this time or Restaurant closed<br/>';
			$MSG .= 'Please try again for your order<br/><br/>';
			$MSG .= '<strong>Your all payment will be refunded (if your payment type not cash). If you do not receive your payment back please contact or live chat to our live support</strong><br/>';
			$MSG .= '<strong>Your order ID : '.$GET['order_id'].'</strong><br/>';
			$MSG .= '<strong>Total order amount : '.number_format($GET['order_tatal'], 2).'</strong><br/>';
			$MSG .= '<strong>Payment Type : '.$GET['order_payment_type'].'</strong><br/>';

			$MSG_SUBJ = "Order cancelled!";
			break;

		case 'new-feedback':
			$MSG = 'A New Feedback Received From <strong>Awais &lt;'.$GET['user_email'].'&gt;</strong><br/><br/>';
			$MSG .= '<p style="border: 1px dotted #DDDDDD; padding: 5px; font-family: Georgia; ">'.$GET['feedback'].'</p>';

			$MSG_SUBJ = "New Feedback received";
			break;

		case 'new-user-reg':
			$MSG = 'A New User Registered <strong>Awais &lt;'.$GET['user_email'].'&gt;</strong><br/>';
			$MSG .= 'Post Code : <strong>'.$GET['user_postcode'].'</strong><br/>';

			$MSG_SUBJ = "New User Registered";
			break;

		case 'new-join_rest':
			$MSG = '<strong>Thank you! for your interest in Just-FastFood.com.</strong><br/><br/>';
			$MSG .= 'You want to add a new restaurant Name: <strong>'.$GET['rest_name'].'</strong> , Phone No: <strong>'.$GET['phone_no'].'</strong> and Post Code : <strong>'.$GET['post_code'].'</strong> at Just-FastFood.com<br/><br/>';
			$MSG .= '<strong>Your Application is reviewing by Admin. After reviewing you will be contact soon. If you will be a owner of this restaurant then you can add own menu, categories and items.</strong><br/><br/>';
			$MSG .= '<p style="font-size:11px; font-family:Verdana; padding:0px; text-align:right; margin:0px;">* Please Note: All Restaurant and menu`s are UK only.</p>';

			$MSG_SUBJ = "New Restaurant";
			break;

		case 'new-join_rest-admin':
			$MSG = '<strong>'.$GET['user_name'].'Wants an Add a new Restaurant Name: <strong>'.$GET['rest_name'].'</strong> and Post Code : <strong>'.$GET['post_code'].'</strong>.</strong><br/><br/>';
			$MSG .= '<p style="font-size:11px; font-family:Verdana; padding:0px; margin:0px;">Please go to admin and see details.</p>';

			$MSG_SUBJ = $GET['user_name'].'Wants to add New Restaurant';
			break;
	}


	if($MSG == "") {
		return false;
	}

	$message = '
	<!DOCTYPE HTML>
	<html lang="en-US">
	<head>
		<meta charset="UTF-8">
		<title>Just-FastFood.com | Email</title>
		<style type="text/css">
			a{
				color: #363636;
				text-decoration: underline;
			}
			a:hover{
				color:#D62725;
			}
		</style>
	</head>
	<body>
		<div class="wrapper" style="padding:15px; border:1px solid #ddd; margin:20px; font-family:Verdana;">
			<div>
				<h1 style="font: bolder 30px Rockwell,Tahoma,Arial,sans-serif; padding-bottom: 10px; margin:0px; padding:0px; color:#D62725;" title="Just-FastFood.com">Just-FastFood</h1>
				<span style="font-size:11px; font-family:Verdana; font-style:italic">Order Your Favourite Fast Food & Takeaways Online</span>
				<p style="font-size:11px; font-family:Verdana; padding:0px; text-align:right; margin:0px;">* This Email Receive From <a href="http://just-fastfood.com">Just-FastFood.com</a></p>
			</div>
			<hr style="height:1px; background:#ddd; margin:10px;"/>
			<div>
				<div style="font-size:13px; font-family:Verdana; margin:5px; padding:10px;">'.$MSG.'</div>
			</div>
			<hr style="height:1px; background:#ddd; margin:10px;"/>
			<div>
				<p style="font-size:12px; font-family:arial; padding-bottom:10px; color:#bbb">&copy; Just-FastFood.com</p>
				<p style="font-size:10px; font-family:verdana; padding:0px; margin:0px; color:#bbb; text-align:right;font-style:italic">Powered By : M. Awais</p>
			</div>
		</div>
	</body>
	</html>
	';
	//echo $message;

	$to = $GET['email'];
	$subject = $MSG_SUBJ;

	$headers = "From:Just-FastFood <info@just-fastfood.com>\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	if($CC) {
		$headers .= "Cc:".admin_email()."\n";
	}

	if(mail($to, $subject, $message, $headers))
		return true;
	else
		return false;
}
?>