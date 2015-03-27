<?php
$location = "";
$cookiearr = array();
$chget = null;
$chpost = null;

function read_header($ch, $string)
{
    global $location;
    global $cookiearr;
    global $chget;
    global $chpost;
   
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
      curl_setopt($chget, CURLOPT_COOKIE, $cookie);
      curl_setopt($chpost, CURLOPT_COOKIE, $cookie);
    }

    return $length;
}
function conv_hiddens($html)
{
preg_match_all('|<input[^>]+type="hidden"[^>]+name\="([^"]+)"[^>]+value\="([^"]*)"[^>]*>|',$html,$getinputs,PREG_SET_ORDER);
return $getinputs;
}
function conv_hiddens2txt($getinputs)
{
$ac=null;
foreach($getinputs as $eachinput){
$ac.="&".urlencode(html_entity_decode(@$eachinput[1]))."=".urldecode((@$eachinput[2]));}
return $ac;
}
function htmlentities2utf8 ($string) 
{
   $string = preg_replace_callback('~&(#(x?))?([^;]+);~', 'html_entity_replace', $string);
   return $string;
} 
function hotmail_login($email, $password)
{
 
  global $location;
  global $cookiearr;
  global $chget;
  global $chpost;

  $cookiearr['CkTst']= "G" . time() . "000";

   #initialize the curl session
    $chget = curl_init();
    $chpost = curl_init();
   
  #get the login form:
    curl_setopt($chget, CURLOPT_URL,"http://login.live.com/login.srf?id=2&svc=mail&cbid=24325&msppjph=1&tw=0&fs=1&fsa=1&fsat=1296000&lc=1033");
    curl_setopt($chget, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.3) Gecko/20060426 Firefox/1.5.0.3");
	curl_setopt($chpost, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.3) Gecko/20060426 Firefox/1.5.0.3");
    curl_setopt($chget, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($chget, CURLOPT_REFERER, "");
	curl_setopt($chpost, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($chpost, CURLOPT_REFERER, "");
    curl_setopt($chget, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($chget, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($chget, CURLOPT_HEADERFUNCTION, 'read_header');
    $html = curl_exec($chget);
  
    $matches = array();
    preg_match('/<form [^>]+action\="([^"]+)"[^>]*>/', $html, $matches);
    $opturl = $matches[1];
  
    //parse the hidden fields:
    preg_match_all('/<input type\="hidden"[^>]*name\="([^"]+)"[^>]*value\="([^"]*)">/', $html, $matches);
    $values = $matches[2];
    $params = "";
   
    $i=0;
    foreach ($matches[1] as $name)
    {
      $params .= "$name=" . urlencode($values[$i]);
      ++$i;
      if(isset($matches[$i]))
      {
        $params .= "&";
      }
    }
   
    $params = trim ($params, "&");
   
    #submit the javascript form:
    curl_setopt($chpost, CURLOPT_URL, $opturl);
    curl_setopt($chpost, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($chpost, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($chpost, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($chpost, CURLOPT_POST, 1);
    curl_setopt($chpost, CURLOPT_POSTFIELDS, $params);
    curl_setopt($chpost, CURLOPT_HEADERFUNCTION, 'read_header');
    $html = curl_exec($chpost);
 
  #parse the login form:
    $matches = array();
    preg_match('/<form [^>]+action\="([^"]+)"[^>]*>/', $html, $matches);
    $opturl = $matches[1];
   
   
    #parse the hidden fields:
    preg_match_all('/<input type="hidden"[^>]*name\="([^"]+)"[^>]*value\="([^"]*)"[^>]*>/', $html, $matches);
    $values = $matches[2];
    $params = "";
       
    $i=0;
    foreach ($matches[1] as $name)
    {
      $paramsin[$name]=$values[$i];
      ++$i;
    }

    $lPad=strlen($sPad)-strlen($password);
    $PwPad=substr($sPad, 0,($lPad<0)?0:$lPad);
   
    $paramsin['PwdPad']=urlencode($PwPad);

    foreach ($paramsin as $key=>$value)
    {
      $params .= "$key=" . urlencode($value) . "&";
    }

    curl_setopt($chpost, CURLOPT_URL,$opturl);
    curl_setopt($chpost, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($chpost, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($chpost, CURLOPT_POST, 1);
    curl_setopt($chpost, CURLOPT_POSTFIELDS, $params . "login=" . urlencode($email) . "&passwd=" . urlencode($password) . "&LoginOptions=3");
    $html = curl_exec($chpost);
    if((preg_match('/replace[^"]*"([^"]*)"/', $html, $matches)==0) && (preg_match("/url=([^\"]*)\"/si", $html, $matches)==0 || eregi("password is incorrect", $html)))
    {
    return 0;
    }
   
//get domain
if(strpos(strstr($email, '@'),"hotmail"))
	{
    curl_setopt($chget, CURLOPT_URL,$matches[1]);
    curl_setopt($chget, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($chget, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($chget, CURLOPT_HEADERFUNCTION, 'read_header');
	$html = curl_exec($chget);
	
	 //get form
	preg_match('/<form [^>]+action\="([^"]+)"[^>]*>/', $html, $matches);
	$formtosubmit=urldecode($matches[1]);
    $inputs=conv_hiddens($html);

	curl_setopt($chpost, CURLOPT_URL,urldecode($location));
    curl_setopt($chpost, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($chpost, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($chpost, CURLOPT_POST, 1);
	curl_setopt($chpost, CURLOPT_HEADERFUNCTION, 'read_header');
    curl_setopt($chpost, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($chpost, CURLOPT_POSTFIELDS,conv_hiddens2txt($inputs));
    $html = curl_exec($chpost);
 
	///???check address///
	
	curl_setopt($chget, CURLOPT_URL,"http://mail.live.com/mail/ContactPickerLight.aspx?n=".rand(0,20000));
    curl_setopt($chget, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($chget, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($chget, CURLOPT_HEADERFUNCTION, 'read_header');
    $html = curl_exec($chget);


}		
if(strpos(strstr($email, '@'),"live"))
	{
	curl_setopt($chget, CURLOPT_URL,$matches[1]);
    curl_setopt($chget, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($chget, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($chget, CURLOPT_HEADERFUNCTION, 'read_header');
	$html = curl_exec($chget);
	
	//we spoke....
	///live 
	  preg_match('/<form [^>]+action\="([^"]+)"[^>]*>/', $html, $matches);
	  $liveloc=explode("/MessageAtLogin.aspx?",urldecode($location));
	  $formtosubmit=urldecode($matches[1]);
      $inputs=conv_hiddens($html);

 $newliveloc=$liveloc[0]."/"."/TodayLight.aspx?n=".rand(0,20000);

	curl_setopt($chpost, CURLOPT_URL,$newliveloc);
   curl_setopt($chpost, CURLOPT_RETURNTRANSFER,0);
    curl_setopt($chpost, CURLOPT_FOLLOWLOCATION, 1);
   curl_setopt($chpost, CURLOPT_POST, 1);
	curl_setopt($chpost, CURLOPT_HEADERFUNCTION, 'read_header');
   curl_setopt($chpost, CURLOPT_SSL_VERIFYPEER, 0);
   curl_setopt($chpost, CURLOPT_POSTFIELDS,trim(conv_hiddens2txt($inputs)));
   $html = curl_exec($chpost);
 
	
	curl_setopt($chget, CURLOPT_URL,"http://mail.live.com/mail/ContactPickerLight.aspx?n=".rand(0,20000));
    curl_setopt($chget, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($chget, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($chget, CURLOPT_HEADERFUNCTION, 'read_header');
 $html = curl_exec($chget);

////end live
	}
	   //parse contacts
   $regex = "/<tr>.*?<td class=\"dContactPickerBodyNameCol\">.*?&#x200.;\\s*(.*?)\\s*&#x200.;.*?<\/td>\\s*<td class=\"dContactPickerBodyEmailCol\">\\s*([^<]*?)\\s*<\/td>.*?<\/tr>/ims";
   $contactList = array();
   preg_match_all($regex, $html, $matches, PREG_SET_ORDER);
   $handlecontacts="1";
			foreach( $matches as $val)
			{
				
				if($handlecontacts=="0") //do not import
				{
				 $name = trim($val[1]);
				 $email = trim($val[2]);
				 if($name==$email) //hotmail always return email as name
				 	{
					$name="";
					$email="";
					}
				 $name = trim($name);
				 $email = trim($email);
				    if($email!="")
					 { $contactList[] = array('name' => $name, 'email' => $email);}
				}
				////
				if($handlecontacts=="1") //email->name
				{
				 $name = trim($val[1]);
				 $email = trim($val[2]);
				 
				    if($email!=""){ $contactList[] = array('name' => $name, 'email' => $email);}
				}
				////
				if($handlecontacts=="2") //id->name
				{
				 $name = trim($val[1]);
				 $email = trim($val[2]);
				   if($name==$email)
					   {
					   $nn=explode("&#64;",$email);
					   $name=$nn[0];
					   }
				    $name = trim($name);
				    $email = trim($email);
				    if($email!=""){ $contactList[] = array('name' => $name, 'email' => $email);}
				}
			
			}
			@sort($contactList);
		    return $contactList;

}

?>