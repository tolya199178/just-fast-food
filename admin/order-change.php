<?php
	include_once("../include/functions.php");
	$result = $_REQUEST["table-1"];
	foreach($result as  $k => $value) {
		$arr = explode('.' ,$value);
		$q = "UPDATE `categories` SET `category_order` = '".$k."' WHERE `category_id` = '".$arr[0]."'";
		$obj->query_db($q);
	}
?>