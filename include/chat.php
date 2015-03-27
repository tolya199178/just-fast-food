<?php
	
	if(!(isset($_GET['type'])) || !(isset($_GET['CID'])))
		echo 'false';
		//die();
	$file = preg_replace('/\s+/', '', $_GET['CID']);
	if(!file_exists('chat/c_'.$file.'.php')) {
		echo 'false';
		//die();
	}
	
	
	$fp = fopen('chat/c_'.$file.'.php', 'a+');
	
	$Text = $_GET['text'];
	if($Text != "") {
		if($_GET['type'] == 'g') {
		
			$str = '<li class="to"><span class="name">Guest</span> : <span class="text">'.$Text.'</span></li>';
			fwrite($fp, $str);
			
		} else if($_GET['type'] == 's') {
			
			$str = '<li class="from"><span class="name">Staff</span> : <span class="text">'.$Text.'</span></li>';
			fwrite($fp, $str);
		}
	}
	
	$theData = file_get_contents('chat/c_'.$file.'.php');
	echo $theData;
	fclose($fp);
?>