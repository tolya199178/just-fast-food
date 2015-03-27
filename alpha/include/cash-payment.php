<?php
session_start();
require('auth.php');
include_once("functions.php");

if(is_user_cash_verified($_SESSION['userId']) != 'true') {
    $_SESSION['error'] = 'Your order by cash payment NOT verified';
    header('Location:my-profile.php');
    die();
}

if(!isset($_SESSION['CART']) || !isset($_POST['user_address']) || !isset($_POST['order_note']) || !isset($_POST['user_phoneno'])){
    header('Loation:/');
    //die();
}

require_once('order-movement.php');

$_SESSION['CHECKOUT_WITH'] = "By Cash";
$_SESSION['CART_SUBTOTAL'] = $_SESSION['CART_SUBTOTAL'] + process_fee();
$_SESSION['ORDER_TRANSACTION_DETAILS'] = array("By Cash Payment");
$_SESSION['ORDER_TRANSACTION_DETAILS']['TRANSACTIONID'] = 'cash_'.rand();
$_SESSION['user_address'] = $_POST['user_address'];
$_SESSION['order_note'] = $_POST['order_note'];
$_SESSION['user_phoneno'] = $_POST['user_phoneno'];
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

header('location:../order-complete.php');
die();
?>