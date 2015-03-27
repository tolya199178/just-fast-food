<?php
if(!function_exists('curl_init')) {
 	print ("cURL library not available. cURL is required for Address Book Importer "); 
}
else {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"https://www.google.com/accounts/ServiceLogin");
	curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; WINDOWS; .NET CLR 1.1.4322)');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Charset'=>'utf-8,*'));
	if (defined('CURLOPT_ENCODING')) curl_setopt($ch, CURLOPT_ENCODING, "");
	$res=curl_exec ($ch);
	if($res==null){
		echo "<h1>Your version of cURL does not support HTTPS protocol.</h1>Make sure OpenSSL is installed.<br>Error : ".curl_error($ch);
	}else{
		echo "<h1>Congratulations!</h1>Your version of cURL is functional and compatible with the Address Book Importer !";
	}
	
	if (!defined('CURLOPT_ENCODING')) {
		echo "<div>Your curl does not support compression</div>";
	}
	
	curl_close ($ch);
}
?>