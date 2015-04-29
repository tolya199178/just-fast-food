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

// set your secret key: remember to change this to your live secret key in production
// see your keys here https://manage.stripe.com/account
//Stripe::setApiKey('sk_live_xVEJg6Mx4rqiM0e0wDS0dZyA');

Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('k54nrwhr42sqwfz4');
Braintree_Configuration::publicKey('86pmzd5bzdysnn5q');
Braintree_Configuration::privateKey('341f05ee992ec4bec234c6c52453c783');

// Charge the order:
/*$charge = Stripe_Charge::create(array(
    "amount" => $amount, // amount in cents, again
    "currency" => "gbp",
    "card" => $token,
    "description" => $description
    )
);*/


$_SESSION['T_CART_SUBTOTAL'] = $_SESSION['CART_SUBTOTAL'] + process_fee();
$_SESSION['Current_Trans_Id'] = 'order_'.$_SESSION['access_key'];

// Set the order amount somehow:
$amount = $_SESSION['T_CART_SUBTOTAL'] *100;
$description = 'An '.$_SESSION['RESTAURANT_TYPE_CATEGORY'].' Order. Amount '.$_SESSION['T_CART_SUBTOTAL'].' pound. By '.$_SESSION['user'].' (user id: '.$_SESSION['userId'].')';
// Validate other form data!

// Charge the order

$result =  Braintree_Transaction::sale(array(
        'amount' => $amount,
        'creditCard'=> array(
            'number'=> '',
            'expirationMonth' => '',
            'expirationYear' => ''
        )
    )
);

if ($result->success) {
    print_r("success!: " . $result->transaction->id);
} else if ($result->transaction) {
    print_r("Error processing transaction:");
    print_r("\n  message: " . $result->message);
    print_r("\n  code: " . $result->transaction->processorResponseCode);
    print_r("\n  text: " . $result->transaction->processorResponseText);
} else {
    print_r("Message: " . $result->message);
    print_r("\nValidation errors: \n");
    // print_r($result->errors->deepAll());
}