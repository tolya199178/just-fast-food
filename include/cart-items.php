<?php
@session_start();
include('functions.php');

if( isset($_SESSION['CART']) ) {                             
    $numbers = array();
    foreach($_SESSION['CART'] as $num => $value) {
        $numbers[] = $value['QTY'];
    }       
    print array_sum($numbers);
} else {
    print '0';
}