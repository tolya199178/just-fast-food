<?php
$cookie_file_path = $tempdirpath.md5($_POST['username']).'.staf';
$ssl_ver=0;
global $cookie_file_path, $cookie;
global $location;
global $cookiearr;
global $ch;

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
		
		function parseContent( $pattern, $subject ) 
		{
			$array = array();
			preg_match_all( $pattern, $subject, $array );
			return $array;
		}
		function getContactList($username,$password) 
		{	
			global $ch;
			global $ssl_ver;
			global $cookie_file_path;
			global $cookie;
			global $location;
			global $cookiearr;

			
			$username = trim($username);
			$password = trim($password);
			
			$ch	= curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://my.screenname.aol.com/_cqr/login/login.psp?sitedomain=sns.webmail.aol.com&lang=en&locale=us&authLev=0&siteState=ver%3a3|rt%3aSTANDARD|ac%3aWS|at%3aSNS|ld%3awebmail.aol.com|uv%3aAOL|lc%3aen-us|mt%3aAOL|snt%3aScreenName&offerId=webmail-en-us&seamless=novl');
			curl_setopt($ch,CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1) Gecko/20061010 Firefox/2.0");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $ssl_ver);
			curl_setopt($ch,CURLOPT_HEADER,1);
			curl_setopt($ch, CURLOPT_HEADERFUNCTION, 'read_header');
			//curl_setopt($ch,CURLOPT_COOKIEJAR,$cookie_file_path);
           // curl_setopt($ch,CURLOPT_COOKIEFILE,$cookie_file_path);
			$return 	= curl_exec( $ch );
		
			///build hidden fields
			$data 		= parseContent( '/<form name="AOLLoginForm"(.*?)<\/form>/s', $return );
			$hidden 	= explode( '<input type="hidden"', $data[1][0] );
			$postFields 	= '';
			foreach( $hidden as $field ) 
			{
				$field	 	= trim( $field );
				$tmp	 	= explode( ' ', $field );
				$removal 	= array( 'name=', 'value=', '"', '>', '</div' );
				$tmp[0] 	= str_replace( $removal, '', $tmp[0] );
				$tmp[1] 	= str_replace( $removal, '', $tmp[1] );
				$postFields 	.= trim($tmp[0].'='.$tmp[1]).'&';
				unset( $tmp );
			}
			
			$uname 		= $username;
			$upass 		= $password;
		
			
			$postFields .= "loginId=".urlencode($uname)."&password=".urlencode($upass);
			///done hidden
			curl_setopt($ch, CURLOPT_URL, 'https://my.screenname.aol.com/_cqr/login/login.psp');
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
			curl_setopt($ch,CURLOPT_HEADER,1);
			$return = curl_exec( $ch );
			
			/////form submitted
	      
			$path=str_replace("Today.aspx","",$location); ////     -> /35861-111/aol-6/en-us/Lite/
						
			
			$url="http://mail.aol.com".$location;

			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_HEADER,1);
			$return = curl_exec( $ch );
			
			$url="http://mail.aol.com".$path."ContactList.aspx"; ///->http://mail.aol.com/35861-111/aol-6//en-us/Lite/ContactList.aspx
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_HEADER,1);
			$return = curl_exec( $ch );
				

	
			$url="http://mail.aol.com".$path."ContactList.aspx?folder=Inbox&showUserFolders=False"; /// ->http://mail.aol.com/35861-111/aol-6//en-us/Lite/ContactList.aspx?folder=Inbox&showUserFolders=False
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch,CURLOPT_HEADER,1);
			$return = curl_exec( $ch );
			
		
			///go page 6 ///  print contacts
			preg_match("|<input type=hidden name=\'user\' value=\'([^\']*)\' />|",$return,$getuserid);
			$url="http://webmail1.mail.aol.com/".$v1."/".$v2."/en-us/Lite/addresslist-print.aspx?command=all&sort=FirstLastNick&sortDir=Ascending&nameFormat=FirstLastNick&user=".urlencode(@$getuserid[1]);
			
			
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch,CURLOPT_HEADER,0);
			$return = curl_exec( $ch );
			
			//parse contacts
			$contactsRecords 	= $return;
			$firstPhaseFilter 	= parseContent( '/fullName(.*?)contactSeparator/s',$contactsRecords );
			$contactList 		= array();
			global $handlecontacts;
			global $max_allowed_contacts_to_import;
			
			if(!isset($handlecontacts))
            {$handlecontacts="1";}
			if(!isset($max_allowed_contacts_to_import))
			{$max_allowed_contacts_to_import="5000";}
			 $cincr=0;
			
			foreach( $firstPhaseFilter[0] as $value ) 
			{
				$value 		= ''.$value; 
				$contactName 	= parseContent( '/fullName">(.*?)<\/span/s', $value );
				$contactEmail	= parseContent( '/<span>Email 1:<\/span> <span>(.*?)<\/span>/s', $value);
				if(trim($contactEmail[1][0]!=""))
				{
					
				  if($cincr<$max_allowed_contacts_to_import) //max to import
					{
					 $cincr++;
					 
					if(trim($contactName[1][0])=="")
					{
					///
					 if($handlecontacts=="0") //do not import
						{
						$fname="";
						}
					 if($handlecontacts=="1") ///email->name
						{
						$fname=$contactEmail[1][0];
						}
					if($handlecontacts=="2") ///id->name
						{
						$nn=explode("@",$contactEmail[1][0]);
					    $fname=trim($nn[0]);
						}
					
					}
					else
					{$fname=trim($contactName[1][0]);}
					//revove <i>
					$nn=explode("<i>",$contactName[1][0]);
					if($nn[0]!="")
					{
					$fname=trim($nn[0]);
					}
					
						$femail=trim($contactEmail[1][0]);
						if($femail!="" && $fname!="")
						{
						$contactList[] = array('name' => $fname, 'email' => $femail);
						}
					}//end if max
				} //end if mail
				
			} //end for each
			@sort($contactList);
			return $contactList;
		}
		
		


?>