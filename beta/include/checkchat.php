<?php
	include('functions.php');
	if(!file_exists('chat/'.$_GET['name'].'.txt')){
		echo 'false';
		die();
	}
	
	$myFile = 'chat/'.$_GET['name'].'.txt';
	$fh = fopen($myFile, 'r');
	$theData = fgets($fh);
	fclose($fh);
	echo $theData;
	
	
	//$query = "UPDATE `chat_staff` SET `cs_online_status` = 'busy' WHERE `cs_id` = '".$_GET['ID']."' LIMIT 1";
?>