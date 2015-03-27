<?php
//include_once "include/chat.php";
//include_once "chat/client.php";

function SENDSMS($to ,$msg ,$type) {

	if(!preg_match ('/^((\(?0\d{4}\)?\s?\d{3}\s?\d{3})|(\(?0\d{3}\)?\s?\d{3}\s?\d{4})|(\(?0\d{2}\)?\s?\d{4}\s?\d{4}))(\s?\#(\d{4}|\d{3}))?$/', $to)) {
		error_log('Phone number not correct! ('.$to.')', 0);
		return false;
	}

	//$to = '447896592291';
	$To = str_replace('+' , '' ,$to);

	switch($type){
		case 'new_order_user' :
			$TEXT = "Thanks for your order at Just-FastFood.com. Your Order Is On Its Way!";
			$TEXT .= " Order Id : ".$msg['order_id']." ";
			break;

        case 'new_staff_added' :
			$TEXT = "Dear ".$msg['staff_name']."! I am pleased to inform you that you have now been added as one of our delivery drivers. We look forward to working with you.";
			break;

		case 'assign_order_guy' :
			$TEXT = "Alert: ".$msg['type_name']." ID: ".$msg['order_id'];
			$TEXT .= "".key(json_decode($msg['order_postcode'], true));
			$order = json_decode($msg['order_details'] ,true);
			foreach($order as $k=> $val) {
				if($k != 'TOTAL'){
					$TEXT .= ' '.$val['QTY'].'x '.$val['NAME'] .', ';
				}
			}
			$TEXT = substr($TEXT,0,-2);
			if(!empty($msg['order_note'])) {
				$TEXT .= ". O.N: ".$msg['order_note'];
			}
			// $TEXT .= ' Total : &pound;'.$order['TOTAL'];
			break;

		case 'admin_alert' :

			$TEXT = "Alert: ID:".$_SESSION['CURRENT_ORDER_ID'].', '.$_SESSION['CURRENT_MENU'];

			$TEXT .= ". Delv Addr: ".$_SESSION['user_address'].' ';
			$TEXT .= "., ".$_SESSION['CURRENT_POSTCODE'];
			$order = $_SESSION['CART'];
			foreach($order as $k=> $val) {
				if($k != 'TOTAL'){
					$TEXT .= ' '.$val['QTY'].'x '.$val['NAME'] .', ';
				}
			}
            $TEXT .= ' Total : '.$order['TOTAL'];
			$TEXT = substr($TEXT,0,-2);
            if(!empty($msg['order_note'])) {
                $TEXT .= ". O.N: " .$msg['order_note'] .', ';
            }


			unset($_SESSION['CART']);

			break;

	}

	require_once "Services/Twilio.php";

	$AccountSid = "AC1a8187b8a142c83ad604ef9a0690e2bd";
	$AuthToken = "616fd8718af466f7ce2723f6c5d2db9f";

	$client = new Services_Twilio($AccountSid, $AuthToken);

	$From = '+442033224539';
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