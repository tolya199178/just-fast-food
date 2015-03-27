<?php

function SENDSMS($to ,$msg ,$type) {
	$to = '447896592291';
	$To = str_replace('+' , '' ,$to);

	switch($type){
		case 'new_order_user' :
			$TEXT = "Thanks for order at Just-FastFood.com. Your order is on the way.";
			$TEXT .= " Order Id : ".$msg['order_id']." ";
			break;

		case 'cancel_order_user' :
			$TEXT = "Your Order is canceled. Restaurant is busy or closed at the moment. Please try again at Just-FastFood.com";
			$TEXT .= " Order Id : ".$msg['order_id']." ";
			break;

		case 'assign_order_guy' :

			$TEXT = "New Order For: ".$msg['type_name'];
			$TEXT .= ". ID: ".$msg['order_id'];
			$TEXT .= ". Del Addr: ".$msg['order_address'].'. ';
			$order = json_decode($msg['order_details'] ,true);
			foreach($order as $k=> $val) {
				if($k != 'TOTAL'){
					$TEXT .= ' '.$val['QTY'].'x '.$val['NAME'] .', ';
				}
			}
			$TEXT = substr($TEXT,0,-2);
			/* $TEXT .= ' Total : &pound;'.$order['TOTAL']; */
			break;
	}

	require "Services/Twilio.php";

	$AccountSid = "ACabcd6ec6c694528b87896a9c573bd552";
	$AuthToken = "b13b6d26021f516e5320c35a43bdafab";

	$client = new Services_Twilio($AccountSid, $AuthToken);

	$From = '+442033223027';
	$message = $TEXT;

	if(strlen($message) > 160){

		$messages = str_split($message , 152);
		$how_many = count($messages);
		foreach($messages as $index => $message){
			$msg_number = ($index + 1);
			$message = "(".$msg_number."/".$how_many.") ".$message;

			$client->account->sms_messages->create($From, $To, $message);
		}
	}
	else{
		$client->account->sms_messages->create($From, $To, $message);
	}
}

?>