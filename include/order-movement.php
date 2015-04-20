<?php
include_once('email-send.php');
include_once('sms/send.php');


// Production:
// access token: BGweZxdYCZmpLuxKvtoV
// secret key: oKkzzZcW6ik5CBWPPosp

// Test:
// access token: FXyhEhoNXV_bVTsYUNZf
// secret key: 9xUKsde3xCqj3Lz25EE6

/*
* This function inserts new order into the database 
* and returns an ID.
*/
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

/**
 * This function checks the status of the order and
 * updates the database accordingly, it
 * @param $order_id
 * @param $status
 * @return string
 */

function confirmFastFoodOrder($order_id ,$status) {
  global $obj;

  $select = "*";
  $where = "`order_id` = '".$order_id."'";
  $order_result = SELECT($select ,$where, 'orders', 'array');

  // If order result isn't 0, and order_status is set to 'to_confirm'

  if(count($order_result) > 0 && $order_result['order_status'] == 'to_confirm') {

    // Get the time customer wants the delivery for.
    $order_time = json_decode($order_result['order_delivery_type'],true);


    if($order_time['time'] != 'ASAP') {
      $Order_Time = date('Y-m-d').' '.$order_time['time'];
    } else {
      //TODO: Check number of delivery pending for the current driver and add 45 minutes to the delivery time. Then populate!

      $Order_Time = 'ASAP';
    }
    // Update order status in the database
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
      'order_arrival_time' => $Order_Time,
      'order_transaction_id' => $order_result['order_transaction_id'],
      'order_payment_type' => $order_result['order_payment_type'],

    );

    if($type == 'cancel_order_user' && $order_result['order_payment_type'] == 'paypal'){
      include_once('paypal/Refund.php');
      //$refund_return = refundPaypal($order_result['order_transaction_id']);
      unset($_SESSION['DELIVERY_CHARGES']);
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

      // Process a refund for the customer if order is cancelled.

      include_once('card/refund.php');

      $transDet = json_decode($order_result['order_transaction_details'],true);
      $transactionDetails['CrossReference'] = $transDet['CrossReference'];
      $transactionDetails['Amount'] = $order_result['order_total'];
      $transactionDetails['OrderID'] = $order_result['order_transaction_id'];

      //$refund_return = refundCard($transactionDetails);
      $refund_return = "processed";
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

/** This function 'sends' order to the Delivery Driver i.e
 *  to their mobile number and email on file.
 * @param {String} $order_id
 * @param {String} $staff_id
 */
function assignOrder($order_id ,$staff_id) {
  global $obj;

  $value = "NULL, ";
  $value .= "'".$staff_id."',";
  $value .= "'".$order_id."',";
  $value .= "'to_confirm',";
  $value .= "NULL";

  $result = INSERT($value , 'staff_order' ,false ,'');
  $obj -> query_db('UPDATE `orders` SET `order_status` = "to_confirm" WHERE `order_id` = "'.$order_id.'"');

  $select = "*";
  $where = "`order_id` = '".$order_id."'";
  $order_result = SELECT($select, $where, 'orders', 'array');

  $__select = "*";
  $__where = "`type_id` = '".$order_result['order_rest_id']."'";
  $rest_result = SELECT($__select ,$__where, 'menu_type', 'array');
  //   $email = "'smartdelivery@outlook.com ' & 'staff_email";
  $select_ = "`staff_phoneno`, `staff_email`";
  $where_ = "`staff_id` = '".$staff_id."'";
  $staff_result = SELECT($select_ ,$where_, 'staff', 'array');

  $SRTSEND= array_merge($order_result , $rest_result);
  SENDSMS($staff_result['staff_phoneno'] ,$SRTSEND , 'assign_order_guy');
  $SRTSEND['type'] = "new_order_staff";

  //$SRTSEND['email'] = admin_email();
  $SRTSEND['name'] = $staff_result['staff_name'];
  $staff_emails =  $staff_result['staff_email'];
  $SRTSEND['email'] = $staff_emails;
  $STRSEND['order_arrival_time'] = $_SESSION['order_delivery_time'];

  $SRTSEND['order_result'] = $_SESSION[''];
  SENDMAIL($SRTSEND , true);

}

/**
 * This function sends orders to the
 * takeaway restaurant, which then get
 * accepted by the restaurant, once accepted
 * the customer sees a confirmation message of
 * order acceptance.
 */
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

/** This function check for order that has been 'assigned'
 *  to the driver and update the database according.
 *  Once order is set to status 'assigned', it then
 *  triggers an email that sends order confirmation to User.
 *  @param $order_id
 *  @return string
 */
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

<script type="text/javascript">
/**
* This function creates a new customer
* in Bingg.
*/
function createBingCustomer(user_name, user_address, user_phoneno, user_email) {
  var access_token, secret_key, params;
   access_token = 'FXyhEhoNXV_bVTsYUNZf';
   secret_key   =  '9xUKsde3xCqj3Lz25EE6';
   params = JSON.parse('{
      "name": user_name,
      "address": user_address,
      "phone": user_phoneno,
      "email": user_email
   }');

// Make the parameters into URL encoded query string

   params.timestamp = Date.now();
   params.access_token = access_token;
   var query_params = '';
   for(var key in params) {
    var value = params[key];
    if(query_params.length > 0) {
      query_params += '&';
    }
    query_params += key + '=' + encodeURIComponent(value);
   }

   // Sign the query string.
   params.signature = CryptoJS.HmacSHA1(query_params, secret_key).toString();

   // Create HTTP POST request to endpoint
   var request = null;
   request = new XMLHttpRequest();
   request.open('POST', 'http://api.bringg.com/partner_api/customers', true);
   request.setRequestHeader('Content-type', 'application/json');
   console.log('requesting... ', request);
   request.send(JSON.stringify(params));

}


  
</script>