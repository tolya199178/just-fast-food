<?php
	include('functions.php');
	
	$query = "SELECT * FROM `chat_staff` WHERE `cs_online_status` = 'online' LIMIT 1";
	$valueOBJ = $obj->query_db($query);
	if($obj -> num_rows($valueOBJ) < 1){
		echo 'false';
		die();
	}
	
	$res = $obj->fetch_db_array($valueOBJ);
	$CID = time().rand().rand();
	
	$str = '';
	
	$fp = fopen('chat/c_'.$CID.'.php', 'w');
	fwrite($fp, $str);
	fflush($fp);
	fclose($fp);
	
	echo $CID;
	
	$fp = fopen('chat/'.$res['cs_name'].'.txt', 'w');
	fwrite($fp, $CID);
	
?>