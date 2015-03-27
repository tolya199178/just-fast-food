<?php
	session_start();
	include("include/functions.php");
	if(isset($_SESSION['access_key']) && isset($_POST['access']) && $_POST['access'] == $_SESSION['access_key']) {
		
		$type = "";
		if(isset($_POST['type']) && $_POST['type'] == "join"){
			$select = "`j_email`, `j_password`";
			$where = "`j_email` = '".$_POST['user_email']."' AND `j_password` = '".md5($_POST['user_password'])."' AND `j_status` = 'active' ";
			$table = "join_restaurant";
			
			$type = "join";
		} else {
			$select = "`user_email`,`user_password`";
			$where = "`user_email` = '".$_POST['user_email']."' AND `user_password` = '".md5($_POST['user_password'])."'";
			$table = "admin";
		}
		
		$result = SELECT($select ,$where, $table, 'bool');
		
		if($result) {
			if($type != "") {
				$_SESSION['ADMIN_PARTNER'] = $_POST['user_email'];
				echo 'partner';
			} else {

				echo 'true';
			}
			$_SESSION['ADMIN'] = $_POST['user_email'];
		} else {
			$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());
			echo $_SESSION['access_key'];
		}
	}
?>