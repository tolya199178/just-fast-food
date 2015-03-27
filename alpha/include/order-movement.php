<?php
include_once('email-send.php');
include_once('sms/send.php');

function insertOrder() {

	$json_post = getEandN($_SESSION['CURRENT_POSTCODE']);
	if($json_post) {
		$p[$_SESSION['CURRENT_POSTCODE']] = $json_post;
		$value = 'NULL ,';
		$value .= "'".$_SESSION['userId']."', ";
		$value .= "'".$_SESSION['DELIVERY_REST_ID']."', ";
		$value .= "'".$_SESSION['RESTAURANT_TYPE_CATEGORY']."', ";
		$value .= "'".$_SESSION['delivery_type']."', ";
		$value .= "'".$_SESSION['ORDER_TRANSACTION_DETAILS']['TRANSACTIONID']."', ";
		$value .= "'".addslashes(json_encode($_SESSION['ORDER_TRANSACTION_DETAILS']))."', ";
		$value .= "'".$_SESSION['CHECKOUT_WITH']."', ";
		$value .= "'".$_SESSION['CART_SUBTOTAL']."', ";
		$value .= "'".addslashes(json_encode($_SESSION['CART']))."', ";
		$value .= "'".json_encode($p)."', ";
		$value .= "'".addslashes($_SESSION['user_address'])."', ";
		$value .= "'".addslashes($_SESSION['order_note'])."', ";
		$value .= "'".addslashes($_SESSION['user_phoneno'])."', ";
		$value .= "'pending', ";
		$value .= "'".date('Y-m-d H:i:s')."', ";
		$value .= 'NULL';

		$resultID = INSERT($value ,'orders' , 'id' ,'');
		$_SESSION['CURRENT_ORDER_ID'] = $resultID;
		SENDSMS('07701057692' ,'' ,'admin_alert');


		return $resultID;
	} else {
		return false;
	}
}

function confirmFastFoodOrder($order_id ,$status) {
	global $obj;

	$_select = "*";
	$_where = "`order_id` = '".$order_id."'";
	$order_result = SELECT($_select ,$_where, 'orders', 'array');

	if(count($order_result) > 0 && $order_result['order_status'] == 'to_confirm') {

		$order_time = json_decode($order_result['order_delivery_type'],true);
		if($order_time['time'] != 'ASAP') {
			$Order_Time = date('Y-m-d').' '.$order_time['time'].':00';
		} else {
			$Order_Time = date('Y-m-d H:i:s');
		}

		$obj -> query_db('UPDATE `orders` SET `order_status` = "'.$status.'", `order_acceptence_time` = "'.$Order_Time.'" WHERE `order_id` = "'.$order_id.'"');

		if($order_result['order_rest_type'] == 'fastfood'){
			$obj -> query_db('UPDATE `staff_order` SET `staff_order_status` = "'.$status.'" WHERE `staff_order_order_id` = "'.$order_id.'"');
		}

		$select_ = "*";
		$where_ = "`id` = '".$order_result['order_user_id']."'";
		$user_result = SELECT($select_ ,$where_, 'user', 'array');

		($status == 'assign') ? $type = 'new_order_user' :  $type = 'cancel_order_user';

		$STRSEND = array(
						'type' => $type,
						'email' => $user_result['user_email'],
						'order_id' => $order_id,
						'user_name' => $user_result['user_name'],
						'user_email' => $user_result['user_email'],
						'user_phoneno' => $user_result['user_phoneno'],
						'order_postcode' => strtoupper(key(json_decode($order_result['order_postcode'] ,true))),
						'order_address' => $order_result['order_address'],
						'order_acceptence_time' => $order_result['order_acceptence_time'],
						'order_tatal' => $order_result['order_total'],
						'order_rest_id' => $order_result['order_rest_id'],
						'order_details' => $order_result['order_details'],
						'order_transaction_id' => $order_result['order_transaction_id'],
						'order_payment_type' => $order_result['order_payment_type']
					);

		if($type == 'cancel_order_user' && $order_result['order_payment_type'] == 'paypal'){
			include_once('paypal/Refund.php');
			//$refund_return = refundPaypal($order_result['order_transaction_id']);

			$rvalue = 'NULL ,';
			$rvalue .= "'".$order_id."', ";
			$rvalue .= "'".$order_result['order_transaction_id']."', ";
			//$rvalue .= "'".json_encode($refund_return)."', ";
			$rvalue .= 'NULL';

			$refundID = INSERT($rvalue ,'refund' , 'id' ,'');
			$REFUND['type'] = 'refund_email';
			$REFUND['email'] = admin_email();
			//$REFUND['details'] = $refund_return;
			$REFUND['order_id'] = $order_id;
			SENDMAIL($REFUND , false);
		} else if($type == 'cancel_order_user' && $order_result['order_payment_type'] == 'By Card'){
			include_once('card/refund.php');

			$transDet = json_decode($order_result['order_transaction_details'],true);
			$transactionDetails['CrossReference'] = $transDet['CrossReference'];
			$transactionDetails['Amount'] = $order_result['order_total'];
			$transactionDetails['OrderID'] = $order_result['order_transaction_id'];

			$refund_return = refundCard($transactionDetails);

			$rvalue = 'NULL ,';
			$rvalue .= "'".$order_id."', ";
			$rvalue .= "'".$order_result['order_transaction_id']."', ";
			$rvalue .= "'".json_encode($refund_return)."', ";
			$rvalue .= 'NULL';

			$refundID = INSERT($rvalue ,'refund' , 'id' ,'');

			$REFUND['type'] = 'refund_email';
			$REFUND['email'] = admin_email();
			$REFUND['details'] = $refund_return;
			$REFUND['order_id'] = $order_id;
			SENDMAIL($REFUND , false);
		}

		SENDMAIL($STRSEND , true);
		//SENDSMS($order_result['order_phoneno'] ,$STRSEND ,$type);

	} else {
		return 'false';
	}
}

function assignOrder($order_id ,$staff_id) {
	global $obj;

	$value = "NULL, ";
	$value .= "'".$staff_id."',";
	$value .= "'".$order_id."',";
	$value .= "'to_confirm',";
	$value .= "NULL";

	$result = INSERT($value , 'staff_order' ,false ,'');
	$obj -> query_db('UPDATE `orders` SET `order_status` = "to_confirm" WHERE `order_id` = "'.$order_id.'"');

	$_select = "*";
	$_where = "`order_id` = '".$order_id."'";
	$order_result = SELECT($_select ,$_where, 'orders', 'array');

	$__select = "*";
	$__where = "`type_id` = '".$order_result['order_rest_id']."'";
	$rest_result = SELECT($__select ,$__where, 'menu_type', 'array');
 //   $email = "'smartdelivery@outlook.com ' & 'staff_email";
	$select_ = "`staff_phoneno`";
	$where_ = "`staff_id` = '".$staff_id."'";
	$staff_result = SELECT($select_ ,$where_, 'staff', 'array');

	$SRTSEND= array_merge($order_result , $rest_result);

	SENDSMS($staff_result['staff_phoneno'] ,$SRTSEND , 'assign_order_guy');
	$SRTSEND['type'] = "new_order_staff";
	$SRTSEND['email'] = admin_email();
	SENDMAIL($SRTSEND , false);
}

function assignOrderTakeaway() {
	global $obj;

	$obj -> query_db('UPDATE `orders` SET `order_status` = "to_confirm" WHERE `order_id` = "'.$_SESSION['CURRENT_ORDER_ID'].'"');

	$_select = "*";
	$_where = "`order_id` = '".$_SESSION['CURRENT_ORDER_ID']."'";
	$order_result = SELECT($_select ,$_where, 'orders', 'array');

	$__select = "*";
	$__where = "`type_id` = '".$order_result['order_rest_id']."'";
	$rest_result = SELECT($__select ,$__where, 'menu_type', 'array');

	$_select_ = "*";
	$_where_ = "`id` = '".$order_result['order_user_id']."'";
	$user_result = SELECT($_select_ ,$_where_, 'user', 'array');

	$SRTSEND= array_merge($order_result , $rest_result , $user_result);
	$SRTSEND['type'] = "new_order_takeaway";
	$SRTSEND['email'] = $rest_result['type_email'];
	SENDMAIL($SRTSEND , false);
	SENDSMS($rest_result['type_phoneno'] ,$SRTSEND , 'assign_order_guy');
}

function orderComplete($order_id) {
	global $obj;
	$_select = "*";
	$_where = "`order_id` = '".$order_id."'";
	$order_result = SELECT($_select ,$_where, 'orders', 'array');

	if(count($order_result) > 0 && $order_result['order_status'] == 'assign') {
		$obj -> query_db('UPDATE `orders` SET `order_status` = "complete" WHERE `order_id` = "'.$order_id.'"') or die(mysql_error());
		$obj -> query_db('UPDATE `staff_order` SET `staff_order_status` = "complete" WHERE `staff_order_order_id` = "'.$order_id.'"') or die(mysql_error());
		return 'true';
	} else {
		return 'false';
	}
}

?>