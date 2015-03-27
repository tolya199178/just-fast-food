<?php
/* include_once('../functions.php');

	$_select = "*";
	$_where = "`order_id` = '833'";
	$order_result = SELECT($_select ,$_where, 'orders', 'array');
	$transDet = json_decode($order_result['order_transaction_details'],true);
	$transactionDetails['CrossReference'] = $transDet['CrossReference'];
	$transactionDetails['Amount'] = $order_result['order_total'];
	$transactionDetails['OrderID'] = $order_result['order_transaction_id'];

			$refund_return = refundCard($transactionDetails);

	print_r($refund_return); */

function refundCard($transactionDetails) {

error_log('REFUND: '.json_encode($transactionDetails),0);

	$RESPONSE['eror'] = 'false';

	require_once('include/lib/Stripe.php');

	Stripe::setApiKey("sk_live_30hkNXblsQSIk5kb99hKCJGW");

	$ch = Stripe_Charge::retrieve($transactionDetails['CrossReference']);
	$REFUND = $ch->refund();

	if($REFUND->failure_message == "") {
		$RESPONSE['return']['OrderID'] = $transactionDetails['OrderID'];
		$RESPONSE['return']['message'] = 'Refunded Successfuly!';
		$RESPONSE['return']['amount_refunded'] = $REFUND->amount_refunded;
		$RESPONSE['return']['description'] = $REFUND->description;
		$RESPONSE['return']['balance_transaction'] = $REFUND->balance_transaction;
		$RESPONSE['return']['id'] = $REFUND->id;
		$RESPONSE['eror'] = 'false';
	} else {
		$RESPONSE['eror'] = 'true';
		$RESPONSE['return']['message'] =  $REFUND->failure_message.' FAILURE CODE:'.$REFUND->failure_code;
	}

	return $RESPONSE;
}
?>