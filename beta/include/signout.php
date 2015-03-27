<?php
	session_start();
	if(isset($_SESSION['user'])) {
		unset($_SESSION['user']);
		unset($_SESSION['id']);
		unset($_SESSION['user_type']);
	}
	header("Location:".$_SERVER['HTTP_REFERER']);
?>