<?php
$ssl_ver=0;
function get_contacts($login, $password)
{
   global $curl;
   global $csv_encoding;
   global $ssl_ver;
   
	if ((isset($login) && trim($login)=="") || (isset($password) && trim($password)==""))
	{
		return 0;
		exit();
	}
	
	    ///new code
		$user = $login;
		$password = $password;
		
		// step 1: login
		$login_url = "https://www.google.com/accounts/ClientLogin";
		$fields = array(
		  'Email'       => $user,
		  'Passwd'      => $password,
		  'service'     => 'cp',
		  'source'      => 'test-google-contact-grabber',
		  'accountType' => 'GOOGLE',
		);
		 
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL,$login_url);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS,$fields);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,$ssl_ver);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
		$result = curl_exec($curl);
		 
		$returns = array();
		 
		foreach (explode("\n",$result) as $line) :
		  $line = trim($line);
		  if(!$line) continue;
		  list($k,$v) = explode("=",$line,2);
		
		  $returns[$k] = $v;
		endforeach;
		 
		curl_close($curl);
		 
		// step 2: grab the contact list
		$feed_url = "http://www.google.com/m8/feeds/contacts/default/property-email?max-results=9999";
		$header = array( 'Authorization: GoogleLogin auth=' . $returns['Auth'] );
		 
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $feed_url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $ssl_ver);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
		 
		$result = curl_exec($curl);
		curl_close($curl);
		
		//////////////handle the contacts
		  $names = array();
		  $emails = array();
		  global $handlecontacts; 
		  
		 if(!isset($handlecontacts))
		 {$handlecontacts="1";}
		  
			$parts = explode('<entry>', $result);
				foreach($parts as $v)
				{
					if (preg_match("/(?:<title type='text'>)([^<]*)<.*?(?:<gd:email)[^>]*?address='([^']+)'/si", $v, $matches))
					{
						$name = $matches[1];
						$email = $matches[2];
		
						///handle contacts
						 if($handlecontacts=="0") //do not import contacts with no name
						   {
							   if(trim($name)=="")
							   { 
							   $name="";
							   $email="";
							   }
						   }
						   
						     if($handlecontacts=="1") //email->name
								{
								  if(trim($name)=="")
								   { 
								   $name=$email;
								   }
								}
								
							if($handlecontacts=="2") //name->id
							  {
								 if(trim($name)=="")
								   {
								   $nn=explode("@",$email);
								   $name=$nn[0];
								   }
							  }
							  //done contacts ->array
							  if($name!="" && $email!="")
								{
								 $contactList[] = array('name' => $name, 'email' =>$email);
								}
										   
		
					}
				}

////////////
///end new code
@sort($contactList);
return $contactList;
}

?>
