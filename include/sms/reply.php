<?php
	session_start();
	include_once('../email-send.php');
	include_once('../order-movement.php');

require_once "Services/Nexmo/NexmoMessage.php";


$apiKey = "6aeaa543";

$apiSecret = "aece4e30";

$nexmo_sms = new nexmoMessage($apiKey, $apiSecret);
if($nexmo_sms->inboundText()){
    $nexmo_sms->reply("You said " . $nexmo_sms->text);
    mail('dev@just-fastfood.com', 'Reply SMS', $nexmo_sms->text);

} else {
    mail('dev@just-fastfood.com', 'Reply SMS', 'NO SMS');
}

	$from = $_REQUEST['msisdn'];
	$body = $_REQUEST['text'];

	$ERROR = false;

	$explode = explode('-', $body);


	if(count($explode) != 2){
		$ERROR = true;
		$r = 'No1';
	} else if(true) {

		$order_id = $explode[1];
		if($explode[0] == 'C'){
			if(orderComplete($order_id) == 'false'){
				$STR['details'] = $_REQUEST;
				$STR['email'] = admin_email();
				$STR['type'] = "order_complete_error";
				SENDMAIL($STR,false);
				/* header("content-type: text/xml");
				echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
				echo					<Response>						<Sms>Error in order complete!</Sms>					</Response>				'; */
			}
			$ERROR = false;
			die();
		} else if ($explode[0] == 'y' || $explode[0] == 'Y'){
			$status = 'assign';
		} else if($explode[0] == 'n' || $explode[0] == 'N') {
			$status = 'cancel';
		} else {
			$ERROR = true;
			$r = 'No2';
		}

		if(confirmFastFoodOrder($order_id , $status) == 'false') {
			$ERROR = true;
			$r = 'No3';
		}
	} else {
		$ERROR = true;
	}
	//mail('awaiskhan88172@yahoo.com', 'Reply SMS', json_encode($_REQUEST).' <br>R='.$r);

	if($ERROR == true) {
		header("content-type: text/xml");
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		echo '
			<Response>
				<Sms>Error! Reply y-order_id  to accept or n-order_id to cancel this order (i.e: y-123)</Sms>
			</Response>
		';
	}
?>