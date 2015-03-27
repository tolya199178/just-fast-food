<?php
	if(!isset($_SESSION['ADMIN'])) {
		header('location:index.php');
	}
?>