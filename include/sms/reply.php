<?php
	session_start();
	include_once('../email-send.php');
	include_once('../order-movement.php');


    // Get the from mobile number and message
    // body
    $request = array_merge($_GET, $_POST);


	$from = $request['msisdn'];
	$body = $request['text'];

    //mail('dev@just-fastfood.com', 'Request', json_encode($_REQUEST));
	$ERROR = false;

	$explode = explode('-', $body);


	if(count($explode) != 2){
		$ERROR = true;
		$r = 'No1';
	} else {

		$order_id = $explode[1];
		if($explode[0] == 'C'){
			if(orderComplete($order_id) == 'false'){
				$STR['details'] = $_REQUEST;
				$STR['email'] = admin_email();
				$STR['type'] = "order_complete_error";
				SENDMAIL($STR,false);
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
	}

	if($ERROR == true) {

		echo 'Error! Reply y-order_id  to accept or n-order_id to cancel this order (i.e: y-123)';
	}
?>