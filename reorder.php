<?php
	session_start();
	require('include/auth.php');
	include('include/functions.php');
	
	if(isset($_GET['order']) && isset($_SESSION['reorder'][$_GET['order']])){
		unset($_SESSION['CART']);
		$_SESSION['CART'] = json_decode($_SESSION['reorder'][$_GET['order']], true);
		unset($_SESSION['reorder']);
		header('location:order-details.php');
	} else {
		header('location:my-profile.php');
	}
?>