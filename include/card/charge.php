<?php
/**
 * Created by PhpStorm.
 * User: kunleadetayo1
 * Date: 25/04/15
 * Time: 00:55
 */

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

// Include the Braintree library:
require_once('../../include/braintree-php/lib/Braintree.php');

// Production
Braintree_Configuration::environment('production');
Braintree_Configuration::merchantId('rdvwm7pdng9sh85c');
Braintree_Configuration::publicKey('99bynrv9nq6vscm9');
Braintree_Configuration::privateKey('e30c825740e7b00bc623e160a6ec559f');

/* Sandbox
Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('k54nrwhr42sqwfz4');
Braintree_Configuration::publicKey('86pmzd5bzdysnn5q');
Braintree_Configuration::privateKey('341f05ee992ec4bec234c6c52453c783');
*/

$_SESSION['T_CART_SUBTOTAL'] = $_SESSION['CART_SUBTOTAL'] + process_fee();
$_SESSION['Current_Trans_Id'] = 'order_'.$_SESSION['access_key'];

// Set the order amount somehow:
$amount = $_SESSION['T_CART_SUBTOTAL'];
$description = 'An '.$_SESSION['RESTAURANT_TYPE_CATEGORY'].' Order. Amount '.$_SESSION['T_CART_SUBTOTAL'].' pound. By '.$_SESSION['user'].' (user id: '.$_SESSION['userId'].')';

/* Charge the order
echo '<pre>';
var_dump($_SESSION['CARD_PROCESSING']);
echo '</pre>';*/


if(isset($_SESSION['CARD_PROCESSING'])) {
    $error = array();

    if(isset($_SESSION['CARD_PROCESSING']['payment_method_nonce'])){

        // get the payment nonce

        $nonce = $_SESSION['CARD_PROCESSING']['payment_method_nonce'];
        // Check for a duplicate submission, just in case:

        if (isset($_SESSION['CARD_PROCESSING']['payment_method_nonce']) && ($_SESSION['CARD_PROCESSING']['payment_method_nonce'] == $nonce)) {
            $errors['nonce'] = 'You have apparently resubmitted the form. Please do not do that.';
        } else {
        // New submission.
            $_SESSION['CARD_PROCESSING']['payment_method_nonce'] = $nonce;
        }

        // process transaction. First get firstname & lastname
        $customerName = explode(" ", $_SESSION['CARD_PROCESSING']['full_name']);
        $firstName = $customerName[0];
        $lastName  = $customerName[1];

        $result = Braintree_Transaction::sale(array(
            'amount' => $amount,
            'paymentMethodNonce' => $_SESSION['CARD_PROCESSING']['payment_method_nonce'],
            'customer' => array(
                'firstName' => $firstName,
                'lastName' => $lastName,
                'phone' => $_SESSION['PAY_POST_VALUE']['user_phoneno'],

            ),
            'customFields' => array(
                'assigned_driver' => $_SESSION['TO_STAFF_ID'],
                'menu_total' => $_SESSION['CART']['TOTAL'],
                'cart_total' => $_SESSION['T_CART_SUBTOTAL'],
                'delivery_charges' => $_SESSION['DELIVERY_CHARGES'],
                'order_note' => $_SESSION['PAY_POST_VALUE']['order_note'],
                'address' => $_SESSION['PAY_POST_VALUE']['user_address'],
                'postcode' => $_SESSION['CARD_PROCESSING']['N_Postcode'],
                'city' => $_SESSION['PAY_POST_VALUE']['user_city'],
                'description' => $description,
                'order_id' => $_SESSION['CURRENT_ORDER_ID']
            ),
            'billing' => array(
                'firstName' => $firstName,
                'lastName' => $lastName,
                'streetAddress' => $_SESSION['PAY_POST_VALUE']['user_address'],
                'locality' => $_SESSION['PAY_POST_VALUE']['user_city'],
                'postalCode' => $_SESSION['CARD_PROCESSING']['N_Postcode'],
                'countryCodeAlpha2' => 'GB'

            ),
            'shipping' => array(
                'firstName' => $firstName,
                'lastName' => $lastName,
                'streetAddress' => $_SESSION['PAY_POST_VALUE']['user_address'],
                'locality' => $_SESSION['PAY_POST_VALUE']['user_city'],
                'postalCode' => $_SESSION['CARD_PROCESSING']['N_Postcode'],
                'countryCodeAlpha2' => 'GB'
            ),
            'options'=> array(
                'submitForSettlement' => true,
                'storeInVaultOnSuccess' => true
            ),

        ));

        if ($result->success) {

            require_once('../order-movement.php');

            $_SESSION['CHECKOUT_WITH'] = "By Card";
            $_SESSION['CART_SUBTOTAL'] = $_SESSION['T_CART_SUBTOTAL'];
            $_SESSION['ORDER_TRANSACTION_DETAILS'] = (array)$charge;
            $_SESSION['ORDER_TRANSACTION_DETAILS']['TRANSACTIONID'] = $_SESSION['Current_Trans_Id'];
            $_SESSION['ORDER_TRANSACTION_DETAILS']['CrossReference'] = $charge->id;
            $_SESSION['user_address'] = $_SESSION['PAY_POST_VALUE']['user_address'];
            $_SESSION['order_note'] = $_SESSION['CARD_PROCESSING']['order_note'];
            $_SESSION['user_phoneno'] = $_SESSION['PAY_POST_VALUE']['user_phoneno'];
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


        } else if ($result->transaction) {
            $_SESSION['CARD_ERROR'] = '<strong>'. $result->message.'</strong>. Error processing transaction, please try again! ';
            error_log("Error occurred while processing transaction ". $result->message);
            unset($_SESSION['CARD_PROCESSING']);
            header('Location:../../pay.php');
            die();


        } else {
            $_SESSION['CARD_ERROR'] = 'Message '. $result->message;
            error_log($result->message);
            unset($_SESSION['CARD_PROCESSING']);
            header('Location:../../pay.php');
            die();

        }
    }
}

?>

    </body>
</html>