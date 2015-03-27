<?php

	include('../../include/functions.php');
	
	if(isset($_GET['value']) && isset($_GET['table']) && isset($_GET['column'])) {
		$value = $obj->query_db("SELECT * FROM `".$_GET['table']."` WHERE `".$_GET['column']."` = '".$_GET['value']."' ") or die(mysql_error());
		$res = $obj->num_rows($value);
		if ($res > 0){
			$value = $obj->query_db("DELETE FROM `".$_GET['table']."` WHERE `".$_GET['column']."` = '".$_GET['value']."' ") or die(mysql_error());
			echo 'true';
			//header('Location:'.mysql_real_escape_string($_GET['backURL']).'');
		} else {
			echo 'Record Not Found';
			//header('Location:'.$_SERVER['HTTP_REFERER'].'');
		}
	} else {
		echo 'ERROR!';
		//header('Location:'.$_SERVER['HTTP_REFERER'].'');
	}
?>