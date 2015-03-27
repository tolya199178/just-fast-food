<?php 
//lycos
$cookie_file_path = $tempdirpath."cookie.txt";
$ssl_ver=0;
function getContactList($username,$password){
		
			$username = trim( $username );
			$password = trim( $password );
			global $cookie_file_path;
			global $ssl_ver;
			// login to lycos and authenticate the user ...
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"https://registration.lycos.com/login.php?m_PR=27");
			curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
			curl_setopt($ch, CURLOPT_COOKIEFILE,$cookieFile);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $ssl_ver);
			
			$name = urlencode($username);
			$pass = urlencode($password );
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,"m_PR=27&m_CBURL=http%3A%2F%2Fmail.lycos.com&m_U=$name&m_P=$pass&login=Sign+In");
			curl_exec($ch);

			// navigate to the address book ...
			curl_setopt($ch, CURLOPT_URL,"http://mail.lycos.com/lycos/addrbook/ViewAddrBook.lycos");
			$output = curl_exec($ch);
			//submit form
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,"http://mail.lycos.com/lycos/addrbook/ViewAddrBook.lycos&ptype=search&sr_field=name&sr_opr=contains&sr_input=%25");
			curl_exec($ch);
			$output = curl_exec($ch);
			curl_close( $ch );
			// now filter the output and get the contact list ...
			preg_match_all( '/<tbody>(.*?)<\/tbody>/s', $output, $trs );
			$grabbedArea = $trs[0][0];
			preg_match_all( '/<td width=\"170\" nowrap>(.*?)<\/td>/s', $grabbedArea, $emails );
			preg_match_all( '/<td width=\"100%\" nowrap>(.*?)<\/td>/s',$grabbedArea, $names );
			$contactList = array();
			///
			global $handlecontacts;
			if(!isset($handlecontacts))
			{$handlecontacts="1";}
			
			foreach( $names[1] as $key => $name )
			{
				//$contactList[$name] = $emails[1][$key];
				if(trim($emails[1][$key])!="")
				{
				
					if(trim($name)=="(".trim($emails[1][$key]).")") //name "()"
					{
					
						 if($handlecontacts=="0") //do not import
						   {
						   $fname="";
						   }
						 if($handlecontacts=="1") //email->name
						   {
						   $fname=$emails[1][$key];
						   }  
						 if($handlecontacts=="2") //id->name
						   {
						   $nn=explode("@",$emails[1][$key]);
					       $fname=trim($nn[0]);
						   } 
					
					
					}
					
					 else ///
				 	{
					 $pos1 = stripos(trim($name), "(");
						 if($pos1==0) //nik
						 {
							$fname=str_replace(")","",$name);
							$fname=str_replace("(","",$fname);
						 }
						 else
						 {
						 $newname=explode("(",$name);
						 $fname=$newname[0];
						 }
				 	}
								
				}
				
				if($fname!="" && $emails[1][$key]!="")
				{
					$contactList[] = array('name' => $fname, 'email' => trim($emails[1][$key]));
				}
				
			}
			@sort($contactList);
			return $contactList;
		}
?>
