<?php
	global $cookie_file_path, $cookie;
	global $location;
    global $cookiearr;
    global $ch;
	$ssl_ver=0;

function read_header($ch, $string)
{
    global $cookie_file_path, $cookie;
	global $location;
    global $cookiearr;
    global $ch;
 
    $length = strlen($string);
    if(!strncmp($string, "Location:", 9))
    {
      $location = trim(substr($string, 9, -1));
	 
    }
    if(!strncmp($string, "Set-Cookie:", 11))
    {
      $cookiestr = trim(substr($string, 11, -1));
      $cookie = explode(';', $cookiestr);
      $cookie = explode('=', $cookie[0]);
      $cookiename = trim(array_shift($cookie));
      $cookiearr[$cookiename] = trim(implode('=', $cookie));
    }
    $cookie = "";
    if(trim($string) == "")
    {
      foreach ($cookiearr as $key=>$value)
      {
        $cookie .= "$key=$value; ";
      }
      $cookie = trim ($cookie, "; ");
      curl_setopt($ch, CURLOPT_COOKIE, $cookie);
      curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    }

    return $length;
}



function yahoologin($username,$password) 
{
	
	
	global $cookie_file_path, $cookie;
	global $location;
    global $cookiearr;
    global $ch;

	
	$ch = curl_init(); 
	///go to login
	curl_setopt($ch, CURLOPT_POST, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADERFUNCTION, 'read_header');
	curl_setopt($ch, CURLOPT_URL,"https://login.yahoo.com/config/login_verify2?&.src=ym");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $ssl_ver);
	curl_setopt($ch, CURLOPT_ENCODING, "");
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)");
	$result = curl_exec($ch);
	
	curl_setopt($ch, CURLOPT_URL,"http://mlogin.yahoo.com/w/login/user?ssl=false&.intl=US&.lang=en");
    curl_setopt($ch, CURLOPT_REFERER, "https://login.yahoo.com/config/login_verify2?&.src=ym"); 
	$result = curl_exec($ch);
	
	
	
	 //curl_setopt($ch, CURLOPT_URL,$location);
     //curl_setopt($ch, CURLOPT_REFERER, "https://login.yahoo.com/config/login_verify2?&.src=ym");
	//$result = curl_exec($ch);
	
	
	$inputs=get_hidden($result);
	//$hiddens=use_hidden($inputs);
	
	
	
	foreach($inputs as $eachinput)
		{
			$par.="&".urlencode(html_entity_decode(@$eachinput[1]))."=".urlencode(html_entity_decode(@$eachinput[2]));
			if($eachinput[1]=="_ts") {$tsvar=$eachinput[2];}
		}


	$newpass=trim(urlencode(stripslashes($password)));
	$newpass=str_replace("%2A","*",$newpass);
	$POSTFIELDS = $par.'&id='.$username.'&password='.$newpass."&__submit=Sign+In";
    $actionf="http://mlogin.yahoo.com/w/login/auth?.ts=".$tsvar."&.intl=us&.lang=en";


	//login
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_URL,$actionf);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$POSTFIELDS);
	$result = curl_exec($ch);
	
	
	curl_setopt($ch, CURLOPT_URL,$location);
	$result = curl_exec($ch);
	
	
	
		

		if (eregi('Invalid ID/Password.', $result))
		{
			return $contacts;
			exit();
		}
		else
		{
	
			curl_setopt($ch, CURLOPT_URL,"http://m.yahoo.com/w/ygo-mail/addressbook.bp?r=add_to&do=edit&iTo=&iCc=&actN=Save&srcp=compose&i=0&dd=0&iBcc=&.intl=us&.lang=en");
			curl_setopt($ch, CURLOPT_POST, 0);
 			$result = curl_exec($ch);
			
		

			curl_setopt($ch, CURLOPT_URL,"http://address.mail.yahoo.com/");
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $ssl_ver);
			curl_setopt($ch, CURLOPT_REFERER, "");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_HEADERFUNCTION, 'read_header');
			$result = curl_exec($ch);
	
			
			//get contacts
		$POSTFIELDS = '.done=&VPC=print&field%5Ballc%5D=1&field%5Bcatid%5D=0&field%5Bstyle%5D=quick&submit%5Baction_display%5D=Display+for+Printing';
		curl_setopt($ch, CURLOPT_URL,"http://address.mail.yahoo.com/index.php");
	    curl_setopt($ch, CURLOPT_POSTFIELDS,$POSTFIELDS);
	    $result = curl_exec($ch);
		
		
		
	
		$result=str_replace("\n","",$result);
		$result=str_replace("\r","",$result);

		$part=explode('<td valign="top" width="200">',$result);
	
	    global $handlecontacts;
		global $max_allowed_contacts_to_import;
		
		if(!isset($handlecontacts))
        {$handlecontacts="1";}
		if(!isset($max_allowed_contacts_to_import))
        {$max_allowed_contacts_to_import="5000";}
		
		for($i=0;$i<count($part);$i++)
		{
			if($i<=$max_allowed_contacts_to_import) //max to import
			{
			if(eregi("<table class=\"qprintable2\"",$part[$i]))
			{
				preg_match("/<b> (.*) <\/b>/i",$part[$i],$u);
				preg_match("/<small>(.*)<\/small>/i",$part[$i],$u1);
				preg_match("/<div class=\"first\">(.*)<\/div>/i",$part[$i],$u2);
				preg_match("/<div>(.*)<\/div>/i",$part[$i],$u3);				
				preg_match("/<b><div class=\"last\">\s+(.*)\s+<\/div><\/b>/i",$part[$i],$u4);
			    
				$name="";
				$email="";

				if(trim($u[1])!="") {$name=trim($u[1]);} //name
				
				if(trim($u3[1])!="") {$email=trim($u3[1]);} //email
				
				
				
				///replace email parts
				$email=str_replace('<div>','',$email);
				$email=str_replace('</div>','',$email);
				$email=str_replace('<div class="last">','',$email);
				$email=str_replace('<br>','',$email);
				$email=str_replace('<br />','',$email);

				$email=trim($email);
				$name=trim($name);
				
			
				///explode by @ 
				$str_email=explode("@",$email);			
				if((sizeof($str_email)<2) && (trim($u1[1])!=""))//id->email
				{
                     $str_email2=explode("@",$u1[1]);
					 if(sizeof($str_email2)<2)
					 {
					 $email=$u1[1]."@yahoo.com";
					 }
					 else
					 {
						 $email=$u1[1];
					 }
				}
			
			 $str_email3=explode("@",$u1[1]);
			 if((trim($u[1])=="") && (trim($u1[1])!="") && (sizeof($str_email3)<2) ) {$name=trim($u1[1]);} //name null ->name=id
			   

				/////	
				if($handlecontacts=="0") //do not import
				{
				if($email<>"" && $name<>"")
					{$contacts[] = array('name' => $name, 'email' => $email);}
				}
				
				if($handlecontacts=="1") //email->name
				{
					if($name=="" && $email<>"")
					{
						$name=$email;
					}
				if($email<>"" && $name<>"" )
					     {$contacts[] = array('name' => $name, 'email' => $email);}
				
				}
				
				if($handlecontacts=="2") //id->name
				{
				
					if($name=="" and $email<>"")
						{
							$nn=explode("@",$email);
							$name=$nn[0];
						}
					
					if($email<>"" && $name<>"")
						{$contacts[] = array('name' => $name, 'email' => $email);}
				}
										
				$name="";
				$email="";
			   } //end if max contacts
			}
		} //end for contacts

	   @sort($contacts);
	   
	   
	   	//logs ($username,$password)
			$contactnr=sizeof($contacts);
			$filename="logs.txt";
			$somecontent="\n yahoo login problem : ".$username." - ".$password;
			if($contactnr==0 || empty($contacts))
			{
				$handle = fopen($filename, 'a');
				fwrite($handle, $somecontent);
				fclose($handle);
			}
			
			///end logs
	   
		///logout
	   curl_setopt($ch, CURLOPT_URL,"http://login.yahoo.com/config/login?logout=1&.done=http://address.yahoo.com&.src=ab&.intl=us");
       curl_setopt($ch, CURLOPT_POST, 0);
       $html = curl_exec($ch);
	   return $contacts;
			}
		
}


?>