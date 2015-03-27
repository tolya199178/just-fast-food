<?php include("top.php"); 
if($_POST['act']=="showContacts")  //import here
{
	RemoveDir($tempdirpath,false);
	RemoveDir($csvfilepath,false);
	unset($_SESSION['give_reward2']);
	unset($_SESSION['nrofemailssent']);

	/////
	$message="";
	$message2="";
	$message3="";
	$importsucess=false;
	$csvimportsucess=false;
	include("includes/curl.inc.php");
	switch ($_POST['service']) 
	{
	case "yahoo" : 

	$only_username=explode("@",$_POST['username']);
	$_POST['username'] = $only_username[0];
	include("includes/yahoo.inc.php");  
	$res=yahoologin(trim($_POST['username']), trim($_POST['password']));
		if (eregi('Invalid ID or password.', $res))
		{
			$message=$cimp_afterimport[0];
		}
		else if (eregi('This ID is not yet taken.', $res))
		{
			$message=$cimp_afterimport[0];
		}
		else
		{
			$contacts=$res;
			if(count($contacts)==0)
			{
				$message=$cimp_afterimport[0];
			}
			else
			{
				$message2=count($contacts)." ".$cimp_afterimport[2];
				$importsucess=true;
			}
		}
		
		///
	break;

	case "aol" : 
	$_POST['username'] = @str_replace(strstr($_POST['username'], '@'), "", $_POST['username']);
	require("includes/aol.inc.php"); 
	$res=getContactList($_POST['username'], $_POST['password']);
		if (eregi('Invalid Screen Name or Password.', $res))
		{
			$message=$cimp_afterimport[0];
		}
		else
		{
			$contacts=$res;
			if(count($contacts)==0)
			{
				$message=$cimp_afterimport[0];
			}
			else
			{
				$message2=count($contacts).$cimp_afterimport[2].$hintafterimport;
				$importsucess=true;
			}
		}
	break;
	case "hotmail" : 
	$_POST['username'] = @str_replace(strstr($_POST['username'], '@'), "", $_POST['username']);
	include("includes/hotmail.inc.php"); 
	$res=hotmail_login($_POST['username']."@hotmail.com", $_POST['password']);

		if (eregi('The email address or password is incorrect.', $res))
		{
			$message=$cimp_afterimport[0];
		}
		else
		{
			$contacts=$res;
			if(empty($contacts) || (trim($contacts[0])=='T' && trim($contacts[1])=='h' &&trim($contacts[2])=='e' &&trim($contacts[4])=='e'))
			{
				$message=$cimp_afterimport[0];
			}
			else
			{
				$message2=count($contacts).$cimp_afterimport[2].$hintafterimport;
				$importsucess=true;
			}
		}
	break;
	case "live" : 
	$_POST['username'] = @str_replace(strstr($_POST['username'], '@'), "", $_POST['username']);
	include("includes/hotmail.inc.php"); 
	$res=hotmail_login($_POST['username']."@live.com", $_POST['password']);

		if (eregi('The email address or password is incorrect.', $res))
		{
			$message=$cimp_afterimport[0];
		}
		else
		{
			$contacts=$res;
			if(empty($contacts) || (trim($contacts[0])=='T'&&trim($contacts[1])=='h' &&trim($contacts[2])=='e' &&trim($contacts[4])=='e'))
			{
				$message=$cimp_afterimport[0];
			}
			else
			{
				$message2=count($contacts).$cimp_afterimport[2].$hintafterimport;
				$importsucess=true;
			}
		}
	break;
	case "gmail" : 
	$_POST['username'] = @str_replace(strstr($_POST['username'], '@'), "", $_POST['username']);
	include("includes/gmail.inc.php"); 
	$login = $_POST['username'];
  	$password = $_POST['password'];
	$contacts=get_contacts($login, $password);
	if(is_array($contacts))
	{

  		 if (!eregi("@", $login))
  	 	 {
		 $login = $login . "@" . strtolower($iscript) . ".com";
  		 }
	$message2=count($contacts).$cimp_afterimport[2].$hintafterimport;
	$importsucess=true;
	}
	  else 
  	{
   	 switch ($contacts)
		{
		  case 1: #invalid login
			$message = $cimp_afterimport[0];
			break;
		  case 2: #empty username or password
			$message = $cimp_afterimport[0];
			break;
		}
		}
	break;
	case "lycos" : 
	$_POST['username'] = @str_replace(strstr($_POST['username'], '@'), "", $_POST['username']);
	include("includes/lycos.inc.php"); 
	$res=getContactList($_POST['username'], $_POST['password']);
		if (eregi('The email address or password is incorrect.', $res))
		{
			$message=$cimp_afterimport[0];
		}
		else
		{
			$contacts=$res;
			if(count($contacts)==0)
			{
				$message=$cimp_afterimport[0];
			}
			else
			{
				$message2=count($contacts).$cimp_afterimport[2].$hintafterimport;
				$importsucess=true;
			}
		}
	break;

	case "maildotcom" : 
	$_POST['username'] = @str_replace(strstr($_POST['username'], '@'), "", $_POST['username']);
	$_POST['service']="mail";
	include("includes/mail.inc.php"); 
	$res=getContactList($_POST['username'], $_POST['password']);
		if (eregi('The email address or password is incorrect', $res))
		{
			$message=$cimp_afterimport[0];
		}
		else
		{
			$contacts=$res;
			if(count($contacts)==0)
			{
				$message=$cimp_afterimport[0];
			}
			else
			{
				$message2=count($contacts).$cimp_afterimport[2].$hintafterimport;
				$importsucess=true;
			}
		}
	break;
	case "otheremail" : 
	$servicefound=0;
	///find service
	if(strpos(strstr($_POST['username'], '@'),"yahoo"))
	{
	$servicefound=1;
	include("includes/yahoo.inc.php");  
	$res=yahoologin($_POST['username'], $_POST['password']);
		if ($res==false)
		{
			$message=$cimp_afterimport[0];
		}
		else
		{
			$contacts=$res;
			if(count($contacts)==0)
			{
				$message=$cimp_afterimport[0];
			}
			else
			{
				$message2=count($contacts).$cimp_afterimport[2].$hintafterimport;
				$importsucess=true;
			}
		}
	}
  if(strpos(strstr($_POST['username'],'@'),"aol"))
  {
  	$servicefound=1;
	require("includes/aol.inc.php"); 
	$res=getContactList($_POST['username'], $_POST['password']);
		if (eregi('Invalid Screen Name or Password.', $res))
		{
			$message=$cimp_afterimport[0];
		}
		else
		{
			$contacts=$res;
			if(count($contacts)==0)
			{
				$message=$cimp_afterimport[0];
			}
			else
			{
				$message2=count($contacts).$cimp_afterimport[2].$hintafterimport;
				$importsucess=true;
			}
		}
	}
	if(strpos(strstr($_POST['username'], '@'),"hotmail"))
	{
	$servicefound=1;
	include("includes/hotmail.inc.php"); 
	$res=hotmail_login($_POST['username'], $_POST['password']);

		if (eregi('The email address or password is incorrect.', $res))
		{
			$message=$cimp_afterimport[0];
		}
		else
		{
			$contacts=$res;
			if(empty($contacts) || (trim($contacts[0])=='T'&&trim($contacts[1])=='h' &&trim($contacts[2])=='e' &&trim($contacts[4])=='e'))
			{
				$message=$cimp_afterimport[0];
			}
			else
			{
				$message2=count($contacts).$cimp_afterimport[2].$hintafterimport;
				$importsucess=true;
			}
		}
	}
	if(strpos(strstr($_POST['username'], '@'),"live"))
	{
	$servicefound=1;
	include("includes/hotmail.inc.php"); 
	$res=hotmail_login($_POST['username'], $_POST['password']);

		if (eregi('The email address or password is incorrect.', $res))
		{
			$message=$cimp_afterimport[0];
		}
		else
		{
			$contacts=$res;
			if(empty($contacts) || (trim($contacts[0])=='T'&&trim($contacts[1])=='h' &&trim($contacts[2])=='e' &&trim($contacts[4])=='e'))
			{
				$message=$cimp_afterimport[0];
			}
			else
			{
				$message2=count($contacts).$cimp_afterimport[2].$hintafterimport;
				$importsucess=true;
			}
		}
	}
	if(strpos(strstr($_POST['username'], '@'),"gmail")) 
	{
	$servicefound=1;
	include("includes/gmail.inc.php"); 
	$login = $_POST['username'];
  	$password = $_POST['password'];
	$contacts=get_contacts($login, $password);
	if(is_array($contacts))
	{
  		 if (!eregi("@", $login))
  	 	 {
		 $login = $login . "@" . strtolower($iscript) . ".com";
  		 }
	$message2=count($contacts).$cimp_afterimport[2].$hintafterimport;
	$importsucess=true;
	}
	  else 
  	{
   	 switch ($contacts)
		{
		  case 1: #invalid login
			$message = $cimp_afterimport[0];
			break;
		  case 2: #empty username or password
			$message = $cimp_afterimport[0];
			break;
		}
		}
	}
	if(strpos(strstr($_POST['username'], '@'),"lycos"))
	{
	$servicefound=1;
	include("includes/lycos.inc.php"); 
	$res=getContactList($_POST['username'], $_POST['password']);
		if (eregi('The email address or password is incorrect.', $res))
		{
			$message=$cimp_afterimport[0];
		}
		else
		{
			$contacts=$res;
			if(count($contacts)==0)
			{
				$message=$cimp_afterimport[0];
			}
			else
			{
				$message2=count($contacts).$cimp_afterimport[2].$hintafterimport;
				$importsucess=true;
			}
		}
	}
	if(strstr($_POST['username'], '@')=="@mail.com") //mail.com 
	{
	$servicefound=1;
	include("includes/mail.inc.php"); 
	$res=getContactList($_POST['username'], $_POST['password']);
		if (eregi('The email address or password is incorrect', $res))
		{
			$message=$cimp_afterimport[0];
		}
		else
		{
			$contacts=$res;
			if(count($contacts)==0)
			{
				$message=$cimp_afterimport[0];
			}
			else
			{
				$message2=count($contacts).$cimp_afterimport[2].$hintafterimport;
				$importsucess=true;
			}
		}
    } //end if service
	///serice not found message
	if($servicefound==0)
	{$message=$cimp_afterimport[3];}
	break;
	}
	
}
///csv mass import here
if($_POST['act']=="csvshowContacts")  //import here
{
	RemoveDir($tempdirpath,false);
	RemoveDir($csvfilepath,false);
	unset($_SESSION['give_reward2']);
	unset($_SESSION['nrofemailssent']);
	$message="";
	$message2="";
	$message3="";
	$importsucess=false;
	$csvimportsucess=false;
    include('includes/classupload/class.upload.php');
		$filename='temp/newcsvfile.csv';
		if(file_exists('temp/newcsvfile.csv')) //delete file if exists
		@unlink($filename);
		
    if($_POST['csvformat']=='3') //generic
	{
	$handle = new Upload($_FILES['fis']);
	if ($handle->uploaded) 
	{
	$handle->file_new_name_body = 'newcsvfile';
	$handle->file_auto_rename = false;
	$handle->file_overwrite = true;
	$handle->Process("temp");
	if ($handle->processed) 
		{
		$handle->clean();
		$filename='temp/newcsvfile.csv';
		$handle = fopen($filename, "r");
		$data = fread($handle, filesize($filename));
		$emails=explode("\n",$data);
		$totalemails=sizeof($emails);
		$endposition=$totalemails-1;
		for($i=1;$i<$endposition;$i++)
				{ 
					if((trim($emails[$i]!='')) && (!empty($emails[$i])))
					{ 
					$emailsdetails=explode(",",$emails[$i]);
					if(check_email_address(trim($emailsdetails[1])))
						{ 
						if(trim( $emailsdetails[0])=="")
						{
						$nn=explode("@", $emailsdetails[1]);
						$fname=$nn[0];
						}
						else
						{$fname= $emailsdetails[0];}
						
						$contacts[] = array('name' => $fname, 'email' => $emailsdetails[1]);
						}
					}
				
				}
				$totcontacts=count($contacts);
				if($totcontacts>0)
				{
				$message3=count($contacts).$csvimp_afterimport[0];
				$csvimportsucess=true;
			    @sort($contacts);
				
				}
				else
				{
				$message3=$csvimp_afterimport[1];
				$csvimportsucess=false;
				}
			} 
			else 
			{
			$message3=$csvimp_afterimport[2];$csvimportsucess=false;}
			} 
			else 
			{$message3=$csvimp_afterimport[2];$csvimportsucess=false;}

	///end generic
	}
	///
	if($_POST['csvformat']=='0' || $_POST['csvformat']=='1') //outlook
	{
	$handle = new Upload($_FILES['fis']);
	if ($handle->uploaded) 
	{
	$handle->file_new_name_body = 'newcsvfile';
	$handle->file_auto_rename = false;
	$handle->file_overwrite = true;
	$handle->Process("temp");
	if ($handle->processed) 
		{
		$handle->clean();
		$filename='temp/newcsvfile.csv';
		$handle = fopen($filename, "r");
		$data = fread($handle, filesize($filename));
		$data=str_replace('"','',$data);
		$emails=explode("\n",$data);
		$totalemails=sizeof($emails);
		$endposition=$totalemails-1;
		
		////find position
		$goodpos=0;
		$tofindpos=explode(",",$emails[0]);
		$nrtoparse=sizeof($tofindpos);
		for($x=0;$x<$nrtoparse;$x++)
		{
		if(strtoupper(trim($tofindpos[$x]))=="NAME")
			{
			$goodpos=$x;
			break;
			}
		}
		
		for($i=1;$i<$endposition;$i++)
				{ 
					if((trim($emails[$i]!='')) && (!empty($emails[$i])))
					{ 
	
					$emailsdetails=explode(",",$emails[$i]);
					if(check_email_address(trim($emailsdetails[$goodpos+1])))
						{ 
						if(trim($emailsdetails[$goodpos])=="")
						{
						$nn=explode("@",$emailsdetails[$goodpos+1]);
						$fname=$nn[0];
						}
						else
						{$fname=$emailsdetails[$goodpos];}
						
						$contacts[] = array('name' => $fname, 'email' => $emailsdetails[$goodpos+1]);
						}
					}
				
				}
				$totcontacts=count($contacts);
				if($totcontacts>0)
				{
				$message3=count($contacts).$csvimp_afterimport[0];
				$csvimportsucess=true;
			    @sort($contacts);
				
				}
				else
				{
				$message3=$csvimp_afterimport[1];
				$csvimportsucess=false;
				}
			} 
			else 
			{
			$message3=$csvimp_afterimport[2]; $csvimportsucess=false;}
			} 
			else 
			{$message3=$csvimp_afterimport[2]; $csvimportsucess=false;}	
				
	///end outlook
	}
	///
	 if($_POST['csvformat']=='2') //thunderbird
	{
	$handle = new Upload($_FILES['fis']);
	if ($handle->uploaded) 
	{
	$handle->file_new_name_body = 'newcsvfile';
	$handle->file_auto_rename = false;
	$handle->file_overwrite = true;
	$handle->Process("temp");
	if ($handle->processed) 
		{
		$handle->clean();
		$filename='temp/newcsvfile.csv';
		$handle = fopen($filename, "r");
		$data = fread($handle, filesize($filename));
		$data=str_replace('"','',$data);
		$emails=explode("\n",$data);
		$totalemails=sizeof($emails);
		$endposition=$totalemails-1;
		for($i=1;$i<$endposition;$i++)
				{
					if((trim($emails[$i]!='')) && (!empty($emails[$i])))
					{
					$emailsdetails=explode(",",$emails[$i]);
					if(check_email_address(trim($emailsdetails[4])))
						{
						
						if(trim($emailsdetails[3])=="")
						{
						$nn=explode("@",$emailsdetails[4]);
						$fname=$nn[0];
						}
						else
						{$fname=$emailsdetails[3];}
						
						$contacts[] = array('name' => $fname, 'email' => $emailsdetails[4]);
						}
					}
				
				}
				$totcontacts=count($contacts);
				if($totcontacts>0)
				{
				$message3=count($contacts).$csvimp_afterimport[0];
				$csvimportsucess=true;
			    @sort($contacts);
				
				}
				else
				{
				$message3=$csvimp_afterimport[1];
				$csvimportsucess=false;
				}
			} 
			else 
			{
			$message3=$csvimp_afterimport[2]; $csvimportsucess=false;}
			} 
			else 
			{$message3=$csvimp_afterimport[2]; $csvimportsucess=false;}	
		}
	//end thbird
	
}
/// sendcsvMessage send invitations ->csv import 
if($_POST['act']=="sendcsvMessage" && isset($_POST['csvsendemails'])) 
{
if(trim($_POST['fromemail'])!='')
{
include("includes/htmlemail/mail.php");
$nrsent=0;
/////////////////////email
$Mail = new CMail;
$Mail->from     = trim($reward_notify_to);
if(trim($_POST['clientname']!=''))
{
$Mail->fromName = trim($_POST['clientname']);
}
else 
{$Mail->fromName =$emailfromname;}
$Mail->charset  = $emailcharset;
$Mail->mime     = "text/html";
$useremail=trim($_POST['fromemail']);
//open email path
$handle = fopen ($emailtxtpath, "rb");
$emailcontent = fread ($handle, filesize ($emailtxtpath));
fclose ($handle);
//sending email to selected contacts
	for($i=1;$i<=$_POST['nrcontacts'];$i++)
	{
		if((isset($_POST['address_'.$i])) && ($nrsent<$maxemailnr))
		{
			$newsubject=$invite_subject;
			$newsubject = @str_replace("%%%sendername%%%",trim($_POST['clientname']), $newsubject);
			if(trim($_POST['recname_'.$i])!="") //replace receiver-s name
			{$newsubject = @str_replace("%%%friendname%%%",trim($_POST['recname_'.$i]), $newsubject);}
			else
			{$newsubject = @str_replace("%%%friendname%%%", "", $newsubject);}
		    //replce in email body
			$emailcontent2=$emailcontent;
			if(trim($_POST['clientname']!='')) ///client name exists ->replace in email body
			{$emailcontent2 = @str_replace("%%%sendername%%%",trim($_POST['clientname']), $emailcontent2); }
			else
			{$emailcontent2 = @str_replace("%%%sendername%%%", $emailfromname, $emailcontent2); }
			
			if(trim($_POST['recname_'.$i])!="") //replace receiver-s name
			{$emailcontent2 = @str_replace("%%%friendname%%%",trim($_POST['recname_'.$i]), $emailcontent2);}
			else
			{$emailcontent2 = @str_replace("%%%friendname%%%", "", $emailcontent2);}
			
			///replce affiliate link
			if(isset($_POST['affiliatelink'])&& trim($_POST['affiliatelink']!=''))
			{
			$str1=str_replace('http://','',$_POST['affiliatelink']);
			$str2=str_replace('www.','',$str1);
			$fullaffiliatelink='http://www.'.$str2;
			$emailcontent2 = @str_replace("%%%affiliatelink%%%",$fullaffiliatelink,$emailcontent2);
			}
			$emailbody='
			<html>
			<head>
			<title>Email</title>
			</head>
			<body>'.$emailcontent2.'<br><br>
			</body>
			</html>
			';
			if($show_email_footer)//email footer
			{$emailbody='
			<html>
			<head>
			<title>Email</title>
			</head>
			<body>'.$emailcontent2.'<br><br>
			<div style="font-size:11px;color:#CCCCC;text-align:left" align="left">
			<hr size=1 style="width:400px" align="left">
			</div>
			<div style="font-size:11px;color:#CCCCC;text-align:left" align="left">
			Email Inviation System powered by <a href="http://www.super-tell-a-friend-com">super-tell-a-friend</a>
			<br>
			</div>
			</body>
			</html>';}
			 $Mail->subject  = $newsubject;
			 $Mail->message = $emailbody;
			 $Mail->to = $_POST['address_'.$i];
		     $Mail->Send();
             $nrsent++;
		}
	}
///reward#1/
	if(($reward1_enabled)&&($nrsent>=$reward1_nrofemailssent))
	{
	$Mail->to = trim($_POST['fromemail']);
	$Mail->fromName =$reward1_fromname;
	$Mail->from = $reward1_fromemail;
	$Mail->subject  = @str_replace("%%%sendername%%%",trim($_POST['clientname']), $reward1_emailsubject);
	if(trim($_POST['clientname']!='')) ///client name exists ->replace in email body
	{$emailcontent_rew = @str_replace("%%%sendername%%%",trim($_POST['clientname']), $reward1_emailbody); }
	else
	{$emailcontent_rew = @str_replace("%%%sendername%%%",' ', $reward1_emailbody); }
	$Mail->message = $emailcontent_rew;
	$rewardsstring=$rewardsstring."<br><b>".$reward1_name."<b>";
	$Mail->Send();
	}
	////reward2
	$_SESSION['nrofemailssent']=$nrsent;
	if(($reward2_enabled)&&($nrsent>=$reward2_nrofemailssent))
	{
	$_SESSION['give_reward2']='YES';
	$_SESSION['nrofemailstobesent']=$reward2_nrofemailssent;
	$rewardsstring=$rewardsstring."<br><b>".$reward2_name."<b>";
	}
	////REWARDS NOTIFICATIONS FOR SITE OWNER
	if(($reward_notify)&&((($reward1_enabled)&&($nrsent>=$reward1_nrofemailssent))||(($reward2_enabled)  &&($nrsent>=$reward2_nrofemailssent))))
	{

	$Mail->to = trim($reward_notify_to);
	$Mail->fromName =$reward_notify_fromname;
	$Mail->from = $reward_notify_fromemail;
	$subject=$reward_notify_emailsubject;
	$newsubject_reward=@str_replace("%%%sendername%%%",trim($_POST['clientname']), $reward_notify_emailsubject);
	$Mail->subject  = $newsubject_reward;
	
	if(trim($_POST['clientname']!='')) ///client name exists ->replace in email body
	{$emailcontent_rew = @str_replace("%%%sendername%%%",trim($_POST['clientname']), $reward_notify_emailbody); }
	else
	{$emailcontent_rew = @str_replace("%%%sendername%%%",' ', $reward_notify_emailbody); }
	$Mail->message = $emailcontent_rew.$rewardsstring;
	$Mail->AddAttachment($tempdirpath."newcsvfile.csv","newcsvfile.csv");
	$Mail->Send();
	}
	//
 echo ("<script>window.location='".$redirection."'</script>"); 
}
}
//send mass emails here ->importer
if($_POST['act']=="sendMessage") //send emails here
{
if(trim($_POST['fromemail'])!='')
{
include("includes/htmlemail/mail.php");
$nrsent=0;
/////////////////////email
$Mail = new CMail;
$Mail->from     = trim($reward_notify_to);
if(trim($_POST['clientname']!=''))
{
$Mail->fromName = trim($_POST['clientname']);
}
else 
{$Mail->fromName =$emailfromname;}
$Mail->charset  = $emailcharset;
$Mail->mime     = "text/html";
$useremail=trim($_POST['fromemail']);
//open email path
$handle = fopen ($emailtxtpath, "rb");
$emailcontent = fread ($handle, filesize ($emailtxtpath));
fclose ($handle);
//sending email to selected contacts
	for($i=1;$i<=$_POST['nrcontacts'];$i++)
	{
		if((isset($_POST['address_'.$i])) && ($nrsent<$maxemailnr))
		{
			$newsubject=$invite_subject;
			$newsubject = @str_replace("%%%sendername%%%",trim($_POST['clientname']), $newsubject);
			if(trim($_POST['recname_'.$i])!="") //replace receiver-s name
			{$newsubject = @str_replace("%%%friendname%%%",trim($_POST['recname_'.$i]), $newsubject);}
			else
			{$newsubject = @str_replace("%%%friendname%%%", "", $newsubject);}
		    //replce in email body
			$emailcontent2=$emailcontent;
			
			if(trim($_POST['clientname']!='')) ///client name exists ->replace in email body
			{$emailcontent2 = @str_replace("%%%sendername%%%",trim($_POST['clientname']), $emailcontent2); }
			else
			{$emailcontent2 = @str_replace("%%%sendername%%%", $emailfromname, $emailcontent2); }
			
			if(trim($_POST['recname_'.$i])!="") //replace receiver-s name
			{$emailcontent2 = @str_replace("%%%friendname%%%",trim($_POST['recname_'.$i]), $emailcontent2);}
			else
			{$emailcontent2 = @str_replace("%%%friendname%%%", "", $emailcontent2);}
			
			///replce affiliate link
			if(isset($_POST['affiliatelink'])&& trim($_POST['affiliatelink']!=''))
			{
			$str1=str_replace('http://','',$_POST['affiliatelink']);
			$str2=str_replace('www.','',$str1);
			$fullaffiliatelink='http://www.'.$str2;
			$emailcontent2 = @str_replace("%%%affiliatelink%%%",$fullaffiliatelink,$emailcontent2);
			}
			$emailbody='
			<html>
			<head>
			<title>Email</title>
			</head>
			<body>'.$emailcontent2.'<br><br>
			</body>
			</html>
			';
			if($show_email_footer)//email footer
			{$emailbody='
			<html>
			<head>
			<title>Email</title>
			</head>
			<body>'.$emailcontent2.'<br><br>
			<div style="font-size:11px;color:#CCCCC;text-align:left" align="left">
			<hr size=1 style="width:400px" align="left">
			</div>
			<div style="font-size:11px;color:#CCCCC;text-align:left" align="left">
			Email Inviation System powered by <a href="http://www.super-tell-a-friend-com">super-tell-a-friend</a>
			<br>
			</div>
			</body>
			</html>';}
			 $Mail->subject  = $newsubject;
			 $Mail->message = $emailbody;
			 $Mail->to = $_POST['address_'.$i];
		     $Mail->Send();
             $nrsent++;
		}
	}
///reward#1/
	if(($reward1_enabled)&&($nrsent>=$reward1_nrofemailssent))
	{
	$Mail->to = trim($_POST['fromemail']);
	$Mail->fromName =$reward1_fromname;
	$Mail->from = $reward1_fromemail;
	$Mail->subject  = @str_replace("%%%sendername%%%",trim($_POST['clientname']), $reward1_emailsubject);
	if(trim($_POST['clientname']!='')) ///client name exists ->replace in email body
	{$emailcontent_rew = @str_replace("%%%sendername%%%",trim($_POST['clientname']), $reward1_emailbody); }
	else
	{$emailcontent_rew = @str_replace("%%%sendername%%%",' ', $reward1_emailbody); }
	$Mail->message = $emailcontent_rew;
	$rewardsstring=$rewardsstring."<br><b>".$reward1_name."<b>";
	$Mail->Send();
	}
	////reward2
	$_SESSION['nrofemailssent']=$nrsent;
	if(($reward2_enabled)&&($nrsent>=$reward2_nrofemailssent))
	{
	$_SESSION['give_reward2']='YES';
	$_SESSION['nrofemailstobesent']=$reward2_nrofemailssent;
	$rewardsstring=$rewardsstring."<br><b>".$reward2_name."<b>";
	}
	////REWARDS NOTIFICATIONS FOR SITE OWNER
	if(($reward_notify)&&((($reward1_enabled)&&($nrsent>=$reward1_nrofemailssent))||(($reward2_enabled)  &&($nrsent>=$reward2_nrofemailssent))))
	{
	$Mail->to = trim($reward_notify_to);
	$Mail->fromName =$reward_notify_fromname;
	$Mail->from = $reward_notify_fromemail;
	$subject=$reward_notify_emailsubject;
	$newsubject_reward=@str_replace("%%%sendername%%%",trim($_POST['clientname']), $reward_notify_emailsubject);
	$Mail->subject  = $newsubject_reward;
	
	if(trim($_POST['clientname']!='')) ///client name exists ->replace in email body
	{$emailcontent_rew = @str_replace("%%%sendername%%%",trim($_POST['clientname']), $reward_notify_emailbody); }
	else
	{$emailcontent_rew = @str_replace("%%%sendername%%%",' ', $reward_notify_emailbody); }
	$Mail->message = $emailcontent_rew.$rewardsstring;
	$Mail->AddAttachment($csvfilepath.$_POST['username']."_".$_POST['service'].".csv",$_POST['username']."_".$_POST['service'].".csv");
	$Mail->Send();
	}
	//
 echo ("<script>window.location='".$redirection."'</script>"); 
}
}
//manual invite here
if((trim($_POST['fromemail'])!='') && ($showmanualimport==true) && isset($_POST['totalnumberemails']))
{
include("includes/htmlemail/mail.php");
$loop=$_POST['nrofemails'];
$handle = fopen ($emailtxtpath, "rb");
$emailcontent = fread ($handle, filesize ($emailtxtpath));
fclose ($handle);
$nrsent=0;
for($i=1;$i<=$loop;$i++)
{
if(isset($_POST['friend_'.$i]))
{
$receiverdetails=explode(",",$_POST['friend_'.$i]);
/////////////////////email
$Mail = new CMail;
$Mail->from     = trim($reward_notify_to);
$Mail->fromName = trim($_POST['clientname']);
$Mail->charset  = $emailcharset;
$Mail->mime     = "text/html";
$useremail=$_POST['fromemail'];
//replce in subject
$newsubject=$invite_subject;
$newsubject = @str_replace("%%%sendername%%%",trim($_POST['clientname']), $newsubject);
if(trim($receiverdetails[1])!="") //replace receiver's name
{$newsubject = @str_replace("%%%friendname%%%",trim($receiverdetails[1]), $newsubject);}
else
{$newsubject = @str_replace("%%%friendname%%%", "", $newsubject);}
//replace in email
$emailcontent2=$emailcontent;
$emailcontent2 = @str_replace("%%%sendername%%%",trim($_POST['clientname']), $emailcontent2);
if(trim($receiverdetails[1])!="") //replace receiver's name
{$emailcontent2 = @str_replace("%%%friendname%%%",trim($receiverdetails[1]), $emailcontent2);}
else
{$emailcontent2 = @str_replace("%%%friendname%%%", "", $emailcontent2);}
//aff link
$emailcontent2 = @str_replace("%%%affiliatelink%%%", $yoursitename, $emailcontent2);
$emailbody='
<html>
<head>
<title>Email</title>
</head>
<body>'.$emailcontent2.'<br>
</body>
</html>
';
if($show_email_footer)//email footer
			{$emailbody='
			<html>
			<head>
			<title>Email</title>
			</head>
			<body>'.$emailcontent2.'<br><br>
			<div style="font-size:11px;color:#CCCCC;text-align:left" align="left">
			<hr size=1 style="width:400px" align="left">
			</div>
			<div style="font-size:11px;color:#CCCCC;text-align:left" align="left">
			Email Inviation System powered by <a href="http://www.super-tell-a-friend-com">super-tell-a-friend</a>
			<br>
			</div>
			</body>
			</html>';
			}
			$Mail->subject  = $newsubject;
			$Mail->message = $emailbody;
			$Mail->to = $receiverdetails[0];
			$Mail->Send();
			$nrsent++;
			}
		}
		///reward#1/
	if(($reward1_enabled)&&($nrsent>=$reward1_nrofemailssent))
	{
	$Mail->to = trim($_POST['fromemail']);
	$Mail->fromName =$reward1_fromname;
	$Mail->from = $reward1_fromemail;
	$Mail->subject  = @str_replace("%%%sendername%%%",trim($_POST['clientname']), $reward1_emailsubject);
	if(trim($_POST['clientname']!='')) ///client name exists ->replace in email body
	{$emailcontent_rew = @str_replace("%%%sendername%%%",trim($_POST['clientname']), $reward1_emailbody); }
	else
	{$emailcontent_rew = @str_replace("%%%sendername%%%",' ', $reward1_emailbody); }
	$Mail->message = $emailcontent_rew;
	$rewardsstring=$rewardsstring."<br><b>".$reward1_name."<b>";
	$Mail->Send();
	}
	////reward2
	$_SESSION['nrofemailssent']=$nrsent;
	if(($reward2_enabled)&&($nrsent>=$reward2_nrofemailssent))
	{
	$_SESSION['give_reward2']='YES';
	$_SESSION['nrofemailstobesent']=$reward2_nrofemailssent;
	$rewardsstring=$rewardsstring."<br><b>".$reward2_name."<b>";
	}
	////REWARDS NOTIFICATIONS FOR SITE OWNER
	if(($reward_notify)&&((($reward1_enabled)&&($nrsent>=$reward1_nrofemailssent))||(($reward2_enabled)  &&($nrsent>=$reward2_nrofemailssent))))
	{
	$Mail->to = trim($reward_notify_to);
	$Mail->fromName =$reward_notify_fromname;
	$Mail->from = $reward_notify_fromemail;
	$subject=$reward_notify_emailsubject;
	$newsubject_reward=@str_replace("%%%sendername%%%",trim($_POST['clientname']), $reward_notify_emailsubject);
	$Mail->subject  = $newsubject_reward;
	
	if(trim($_POST['clientname']!='')) ///client name exists ->replace in email body
	{$emailcontent_rew = @str_replace("%%%sendername%%%",trim($_POST['clientname']), $reward_notify_emailbody); }
	else
	{$emailcontent_rew = @str_replace("%%%sendername%%%",' ', $reward_notify_emailbody); }
	$Mail->message = $emailcontent_rew.$rewardsstring;
	$Mail->Send();
	}
	//
	echo ("<script>window.location='".$redirection."'</script>"); 
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $htmlcharset ?>"/>
<link href="stylesheets/font_styles<?php echo "_".$skin ?>.css"  rel="stylesheet" type="text/css">
<script language="JavaScript">
function submitenter(myfield,e)
{
var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
else return true;

if (keycode == 13)
   {
   verimport();
   return false;
   }
else
   return true;
}
function submitenter2(myfield,e)
{
var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
else return true;

if (keycode == 13)
   {
   veruploadfile();
   return false;
   }
else
   return true;
}
function submitenter3(myfield,e)
{
var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
else return true;

if (keycode == 13)
   {
   vermanualsend();
   return false;
   }
else
   return true;
}

function check_email(e) 
{
	ok = "1234567890qwertyuiop[]asdfghjklzxcvbnm.@-_QWERTYUIOPASDFGHJKLZXCVBNM";
	var i=0;
	for(i=0; i < e.length ;i++)
	{
		if(ok.indexOf(e.charAt(i))<0)
		{ 
			return (false);
		}
	} 
		
	if (document.images) 
	{
		re = /(@.*@)|(\.\.)|(^\.)|(^@)|(@$)|(\.$)|(@\.)/;
		re_two = /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		if (!e.match(re) && e.match(re_two)) 
		{
			return (-1);
		} 
	}	
}
function trimAll( strValue ) {
var objRegExp = /^(\s*)$/;

    //check for all spaces
    if(objRegExp.test(strValue)) {
       strValue = strValue.replace(objRegExp, '');
       if( strValue.length == 0)
          return strValue;
    }

   //check for leading & trailing spaces
   objRegExp = /^(\s*)([\W\w]*)(\b\s*$)/;
   if(objRegExp.test(strValue)) {
       //remove leading and trailing whitespace characters
       strValue = strValue.replace(objRegExp, '$2');
    }
  return strValue;
}
    function togglechecked()
	{ 
	var ch,maxtocheck,maxmaluetocheck;
	maxtocheck= <?php echo $maxemailnr ?>;
	maxmaluetocheck=document.sendemailsform.nrcheckedcontacts.value;
		if(document.sendemailsform.elements[0].checked==false) //unselect all
		{
		ch=false;
		document.sendemailsform.nrcheckedcontacts.value='0';
		}
		if(document.sendemailsform.elements[0].checked==true) //select all
		{
		ch=true;
		document.sendemailsform.nrcheckedcontacts.value=maxtocheck;
		}
		
      for (var i = 1; i < document.sendemailsform.elements.length; i++) 
	  {
        var e = document.sendemailsform.elements[i];

			if (e.type == 'checkbox')
			 {
				   if(ch)
				   {
						if(maxmaluetocheck<maxtocheck)
					    {
							if(e.checked==false){
							e.checked = ch;
							maxmaluetocheck++;}
						}
				   }
				   if(!ch)
				   {
				   e.checked = ch;
				   }
			  
			 }
			
      }
    }
	function togglechecked2(){ 
		var ch;
		if(document.sendemailsform.elements[0].checked==false) {ch=false;}
		if(document.sendemailsform.elements[0].checked==true) {ch=true;}
      for (var i = 1; i < document.sendemailsform.elements.length; i++) {
        var e = document.sendemailsform.elements[i];

			if (e.type == 'checkbox')
			 {
				e.checked = ch;
			 }
			
      }
    }
function is_one_checked()
{
var ischecked;
ischecked=false;
 document.getElementById('selectatleastonecontact').style.visibility='hidden';
  for (var i = 1; i < document.sendemailsform.elements.length; i++) 
	  {
        var e = document.sendemailsform.elements[i];

			if (e.type == 'checkbox')
			 {
				if(e.checked){ischecked=true;}
			 }
			
      }
	  if(ischecked)
	  {document.sendemailsform.submit();}
	  else
	  {
	  document.getElementById('selectatleastonecontact').style.visibility='visible';
	  }

}
function updatecheckedcontacts(ischecked,id)
{
    var checkedcontacts,maxtocheck;
    maxtocheck= <?php echo $maxemailnr ?>;
    checkedcontacts=document.sendemailsform.nrcheckedcontacts.value;

		if(ischecked==false)
		{
		document.sendemailsform.nrcheckedcontacts.value=parseInt(checkedcontacts)-1;
		}
		if(ischecked==true)
		{
			if(maxtocheck==document.sendemailsform.nrcheckedcontacts.value)
			{
			document.getElementById('address_'+id).checked=false;
			}
			else 
			{
			document.sendemailsform.nrcheckedcontacts.value=parseInt(checkedcontacts)+1;
			}
		}

}

function verimport()
{
    document.getElementById('message').style.visibility='hidden';
	if(trimAll(document.massimport.elements[0].value)=='')
		{
		document.getElementById('message').style.visibility='visible';
		document.massimport.elements[0].focus();
		document.getElementById('message').innerHTML='<?php echo $contactimporter_validation[0] ?>';
		return false;
		} 
		
	if(document.massimport.elements[1].options[7].selected==true)
	{
		if(!check_email(trimAll(document.massimport.elements[0].value))) 
		{
		document.getElementById('message').innerHTML='<?php echo $contactimporter_validation[4] ?>';
		document.getElementById('message').style.visibility='visible';
		document.massimport.elements[0].focus();
		return false;
		}
	}
	else 
	{
	if(trimAll(document.massimport.elements[0].value).indexOf('@')!='-1') 
		{
		document.getElementById('message').innerHTML='<?php echo $contactimporter_validation[5] ?>';
		document.getElementById('message').style.visibility='visible';
		document.massimport.elements[0].focus();
		return false;
		}
	}

	if(trimAll(document.massimport.elements[2].value)=='')
	{
	document.getElementById('message').style.visibility='visible';
	document.getElementById('message').innerHTML='<?php echo $contactimporter_validation[1] ?>';
	document.massimport.elements[2].focus();
	return false;
	} 
	<?php if($shownameinput==true && $nameinputrequired==true){ ?>
	if(trimAll(document.massimport.elements[3].value)=='')
	{
	document.getElementById('message').style.visibility='visible';
	document.getElementById('message').innerHTML='<?php echo $contactimporter_validation[2] ?>';
	document.massimport.elements[3].focus();
	return false;
	} 
	<?php } if($showaffiliatelink==true && $affliliateinputrequired==true) { ?>
	if(trimAll(document.massimport.elements[4].value)=='')
	{
	document.getElementById('message').style.visibility='visible';
	document.getElementById('message').innerHTML='<?php echo $contactimporter_validation[3] ?>';
	document.massimport.elements[4].focus();
	return false;
	} 
	<?php } ?>
	document.getElementById('message').style.visibility='visible';
	document.getElementById('message').innerHTML="<img src='images/loader.gif' border=0 hspace=0 vspace=0>";
	document.massimport.masssubmit.value='<?php echo $contactimporter_button[1] ?>';
	document.massimport.masssubmit.disabled=true;
	document.getElementById('errorlabel').style.padding='0';
	window.setTimeout("document.massimport.submit()",1000);

}
function vermanualsend()
{
    document.getElementById('error').style.visibility='hidden';
	document.getElementById('error').innerHTML='<?php echo $manualform_validation[0]; ?>';
	if(trimAll(document.manualsend.clientname.value)=='')
	{
	document.getElementById('error').style.visibility='visible';
	document.manualsend.clientname.focus();
	return false;
	}
	if(trimAll(document.manualsend.fromemail.value)=='')
	{
	document.getElementById('error').style.visibility='visible';
	document.manualsend.fromemail.focus();
	return false;
	} 
	
	if(!check_email(trimAll(document.manualsend.fromemail.value))) 
	{
	document.getElementById('error').innerHTML='<?php echo $manualform_validation[1]; ?>';
	document.getElementById('error').style.visibility='visible';
	document.manualsend.fromemail.focus();
	return false;
	}
	if(document.manualsend.totalnumberemails.value=='0')
	{
	document.getElementById('error').innerHTML='<?php echo $manualform_validation[2] ?>';
	document.getElementById('error').style.visibility='visible';
	document.manualsend.toname.focus();
	return false;
	}
    document.getElementById('error').style.visibility='visible';
	document.getElementById('error').innerHTML="<span style='padding-left:164px'><img src='images/loader.gif' align=absmiddle border=0 vspace=1>";
	document.getElementById('manualsubmit').disabled=true;
	document.getElementById('manualsubmit').value='<?php echo $manualform_button[2] ?>';
	window.setTimeout("document.manualsend.submit()",500);
}
function addField(area,field,limit) 
{
	if(!document.getElementById) return; //Prevent older browsers from getting any further.
	if(trimAll(document.manualsend.toname.value)=='') 
		{
		document.getElementById('error').innerHTML='<?php echo $manualform_validation[3]; ?>';
		document.getElementById('error').style.visibility='visible';
		document.manualsend.toname.focus();
		return false;
		}
		if(!check_email(trimAll(document.manualsend.toemail.value)))
		{
		document.getElementById('error').innerHTML='<?php echo $manualform_validation[4]; ?>';
		document.getElementById('error').style.visibility='visible';
		document.manualsend.toemail.focus();
		return false;
		}
		
		
	var field_area = document.getElementById(area);
	var all_inputs = field_area.getElementsByTagName("input"); 

	var last_item = all_inputs.length - 1;
	var last = all_inputs[last_item].id;
	var count = Number(last.split("_")[1]) + 1;
	if(count > limit && limit > 0) return;
 	
	if(document.createElement) 
		{ 
		var p = document.createElement("p");
		p.innerHTML ='<input type="hidden" name="'+field+count+'" id="'+field+count+'"> ';
        p.innerHTML +=document.manualsend.toname.value+' - '+document.manualsend.toemail.value;
		p.innerHTML +='<a href="javascript:;" class="slink" onClick="document.manualsend.totalnumberemails.value=parseInt(document.manualsend.totalnumberemails.value)-1;this.parentNode.parentNode.removeChild(this.parentNode);" > <b><?php echo $manualform_validation[5] ?></b></a>';
		field_area.appendChild(p);
		document.getElementById(field+count).value=document.manualsend.toemail.value+','+document.manualsend.toname.value;
		document.manualsend.toemail.value='';
		document.manualsend.toname.value='';
		document.manualsend.nrofemails.value=parseInt(document.manualsend.nrofemails.value)+1;
		document.manualsend.totalnumberemails.value=parseInt(document.manualsend.totalnumberemails.value)+1;
		
	 	} 
	else 
	{ 
		field_area.innerHTML += "<input name='"+(field+count)+"' id='"+(field+count)+"' type='text' /> <a onclick='this.parentNode.parentNode.removeChild(this.parentNode);'><?php echo $manualform_validation[5] ?></a><br>";
	}
}
//file upload
function verfisext(fis)
{
	var s,ext ;
    s=fis.length;
    ext=fis.substring(s-4,s);
	if((ext.toUpperCase()=='.CSV'))
	 {
		 return true;
	}
	else
	return false;
	
}
function veruploadfile()
{
var fis,a,b,c;
document.getElementById('message3').innerHTML="<?php echo $csvcontactimporter_validation[0] ?>";
document.getElementById('message3').style.visibility='hidden';
a=document.csvmassimport.clientname.value;
b=document.csvmassimport.fromemail.value;
fis=document.getElementById('fis').value;

		if(trimAll(a)=='')
		{
		document.getElementById('message3').innerHTML="<?php echo $csvcontactimporter_validation[1]; ?>";
		document.getElementById('message3').style.visibility='visible';
		document.csvmassimport.clientname.focus();
		return false;
		}
		if(trimAll(b)=='')
		{
		document.getElementById('message3').innerHTML="<?php echo $csvcontactimporter_validation[2]; ?>";
		document.getElementById('message3').style.visibility='visible';
		document.csvmassimport.fromemail.focus();
		return false;
		}
		if(!check_email(trimAll(b))) 
		{
		document.getElementById('message3').innerHTML='<?php echo $csvcontactimporter_validation[3]; ?>';
		document.getElementById('message3').style.visibility='visible';
		document.csvmassimport.fromemail.focus();
		return false;
		}
		if(trimAll(fis)=='')
		{
		document.getElementById('message3').innerHTML="<?php echo $csvcontactimporter_validation[4]; ?>";
		document.getElementById('message3').style.visibility='visible';
		return false;
		}
		if(verfisext(trimAll(fis))==false)
		{
		document.getElementById('message3').innerHTML="<?php echo $csvcontactimporter_validation[5]; ?>";
		document.getElementById('message3').style.visibility='visible';
		return false;
		}
	document.getElementById('message3').style.visibility='visible';
	document.getElementById('message3').innerHTML="<img src='images/loader.gif' border=0 hspace=0 vspace=0>";
	document.csvmassimport.csvmasssubmit.value='<?php echo $csvcontactimporter_button[1]; ?>';
	document.csvmassimport.csvmasssubmit.disabled=true;
	document.getElementById('errorlabelcsv').style.padding='0';
	window.setTimeout("document.csvmassimport.submit()",1000);
	
}
</script>
<script type="text/JavaScript" src="stylesheets/bubbles/rounded_corners.inc.js"></script>
<link rel="stylesheet" href="stylesheets/bubbles/bubbles<?php echo "_".$skin ?>.css" type="text/css" media="screen" charset="" />
<script type="text/JavaScript">
	  window.onload = function() {
	      settings = {
	          tl: { radius: 10 },
	          tr: { radius: 10 },
	          bl: { radius: 10 },
	          br: { radius: 10 },
	          antiAlias: true,
	          autoPad: true
	      }
	      var myBoxObject = new curvyCorners(settings, "rounded");
	      myBoxObject.applyCornersToAll();
	  }
	</script>
</head>
<body>
<noscript>
<div class="warning">
<font style="font-family:Tahoma; size:15px; font-weight:bold; color:#CC3300 ">You must enable javascript to be able to run this application!</font>
</div>
</noscript>
<br>
<table width="650" align="center" cellpadding="0" cellspacing="0">
<?php if((!$importsucess) && (!$csvimportsucess)) //not imported 
{ ?>
<tr>
<td> 
<div align="left" class="topnavigation"> 
<a href="?importype=import" class="chooselink"><?php echo $toplink[0] ?></a> 
<?php  if($showcsvimport) { ?>  <a href="?importype=csvimport" class="chooselink"><?php echo $toplink[1] ?></a> <?php }
    if($showmanualimport) { ?> <a href="?importype=manual" class="chooselink"><?php echo $toplink[2] ?></a><?php } 
    if($showyminvite) { ?>  <a href="?importype=yminvite" class="chooselink"><?php echo $toplink[3] ?></a> <?php } ?>
</div>
  </td>
  </tr> 
<?php }
if((!$importsucess) && (!$csvimportsucess) && ($_GET['importype']=="yminvite") && ($showyminvite))
{ 
?>
<tr>
<td class="bigtext2"><?php echo $mymtexttop; ?></td>
</tr>
<?php if($show_ym_main_text) { ?>
<tr><td class="comments_before"><?php echo($manual_ym_text);  ?></td></tr>
<?php } ?>
<tr>
<td class="bigtext2">
	<div class="bubble">
		<div class="rounded">
			<blockquote>
				<p> <?php echo $ym_message ?></p>
			</blockquote>
		</div>
		<cite class="rounded">&nbsp;
		<span><a href="ymsgr:im?+&amp;msg=<?php echo htmlspecialchars( str_replace("'","&#039;",$ym_message));?>"class="slink"><img src="images/ym.gif" border="0" vspace="0" hspace="30" align="left"/></a></span>
		<span style="margin-left:280px;">
		<a href="ymsgr:im?+&msg=<?php echo htmlspecialchars(str_replace("'","&#039;",$ym_message));?>" class="slink">
		<img src="images/sendym<?php echo "_".$skin ?>.gif" border="0" vspace="0" hspace="0" align="right"/></a></span>
	</cite>
	</div>
	
</td>
</tr>
<tr>
<?php } ?>
<?php
///csv import
if((!$csvimportsucess)&&(!$importsucess)&&($_GET['importype']=="csvimport" || isset($_POST['csvformat'])) && ($showcsvimport)){ ?>
<tr>
<td class="bigtext2"><?php echo $csvimporttexttop; ?></td>
</tr>
<?php if($show_csv_main_text) 
{ ?>
<tr><td class="comments_before"><?php echo($csvimport_main_text);  ?></td></tr>
<?php } ?>
<tr>
<td align="center">
<form method="post" action="import.php" name="csvmassimport" enctype="multipart/form-data">  
<table border="0" cellspacing="0" cellpadding="0" class="tableimport">
<tr> 
<td colspan="2" class="warninginside">
<?php if($showwarningbox_csv) { ?>
<div class="warning"><?php echo $csvwarningtext ?></div>
<?php } ?>
&nbsp;
</td>
</tr>
<tr>
<td height="28"><div class="signup-labels"><?php echo $csvimporterform[0]; ?></div></td> 
<td align="left" class="input-labels"><input class="inputbox" size="23"   name="clientname" onFocus="style.borderColor='#FFEB70';"   onblur="style.borderColor='#999999';" onMouseOver="style.borderColor='#FFEB70'" onMouseOut="style.borderColor='#999999'" onKeyPress="return submitenter2(this,event)"></td> 
</tr>
<tr>
<td width="175" height="28"><div class="signup-labels"><?php echo $csvimporterform[1]; ?></div></td> 
<td align="left" class="input-labels"><input size="23" name="fromemail" class="inputbox" onFocus="style.borderColor='#FFEB70';"  onblur="style.borderColor='#999999';" onMouseOver="style.borderColor='#FFEB70'" onMouseOut="style.borderColor='#999999'" onKeyPress="return submitenter2(this,event)"> 
</td>
</tr>
<tr>
<td height="28"><div class="signup-labels"><?php echo $csvimporterform[2]; ?></div></td> 
<td align="left" class="input-labels">
<select name="csvformat" class="comboservice2">
<option  value="0" selected>Outlook 2000-2003</option>
<option  value="1">Outlook Express 6</option>
<option  value="2">Thunderbird</option>
<option  value="3"><?php echo $csvimporterform_combo_option; ?></option>
</select>
</td>
</tr>
<tr>
<td height="28"><div class="signup-labels"><?php echo $csvimporterform[3]; ?></div></td> 
<td align="left" class="input-labels">
<input name="fis"  class="inputbox" type="file"  id="fis"  size="23" value="" onKeyPress="return submitenter2(this,event)">
</td> 
</tr>
<tr>
<td height="22"></td>
<td align="left" id="errorlabelcsv" class="input-labels"><div id="message3" class="message_error"><?php echo $message3 ?> &nbsp; </div></td>
</tr>
<tr>
<td height="35"></td>
<td align="left" class="input-labels">
<input name="act" type="hidden" id="act" value="csvshowContacts">
<input class="submit" style="WIDTH:120px" type="button" id="csvmasssubmit" name="csvmasssubmit" value="<?php echo $csvcontactimporter_button[0] ?>" onFocus="style.borderColor='#FFEB70';"  onblur="style.borderColor='#999999';" onMouseOver="style.borderColor='#FFEB70'" onMouseOut="style.borderColor='#999999'" onClick="veruploadfile()">
</td>
</tr>
</table>
</form>
</td>
</tr>
<?php }  //end csv import form
if(($csvimportsucess) && ($showcsvimport) ) 
{
if($show_maxemailnr)
{
$maxemailnr_text = @str_replace("%%%maxemailnr%%%", $maxemailnr, $maxemailnr_text);
echo ("<div class=\"importsucess\">".$message3.$maxemailnr_text."</div>"); 
}
else 
{echo ("<div class=\"importsucess\">".$message3."</div>"); }
 ?>
<tr>
<td align="center">
<form method="post" name="sendemailsform" id="sendemailsform">
<table width="90%" cellpadding="0" cellspacing="0" border="0">
<tr> 
<td width="6%" height="25" align="center" class="headercontacts">
<input name="allbox2" type="checkbox" id="allbox2" <?php if(!$allowusertocheck) {?>onClick="togglechecked()"<?php } else { ?> onClick="togglechecked2()"<?php } ?> value="nothing"></td>
<td width="47%" align="left" class="headercontacts"><?php echo $csvcontactsheader[0]; ?></td>
<td width="47%" align="left"  class="headercontacts"><?php echo $csvcontactsheader[1]; ?></td>
</tr>
<?php 
$i=0;
foreach($contacts as $contact)
{
$i++;
$email = trim($contact['email']);
$name = trim($contact['name']);
if($name==''){$ouputname = $email; }
	else{$ouputname= $name; }
if($email!='' && $name!='')
{
?>
<tr>
<td align="center" class="showcontacts">
<input name="address_<?php echo $i?>" type="checkbox" id="address_<?php echo $i?>" value="<?php echo $email;?>" <?php if(!$allowusertocheck) {?> onClick="updatecheckedcontacts(this.checked,<?php echo $i?>)" <?php } ?> >
<input name="recname_<?php echo $i?>" type="hidden" id="recname_<?php echo $i?>" value="<?php echo $name;?>" >
</td>
<td height="22" align="left" class="showcontacts"><?php echo $ouputname; ?></td>
<td align="left" class="showcontacts"><?php echo $email;?></td>
</tr>
<?php 
}
} 
if($showemailbody)
{ ?> 
<tr>
<td colspan="3" > 
<div class="textbeforeemailtext"><?php echo $yourmessagebeforeemailtext; ?></div>
<div class="displayemailtxt">
<?php 
$handle = fopen ($emailtxtpath, "rb");
$emailcontentlist = fread ($handle, filesize ($emailtxtpath));
$emailcontentlist = @str_replace("%%%friendname%%%",$csvpreview_email_tag_replace, $emailcontentlist); 
if(trim($_POST['clientname']!='')) ///client name exists 
			{$emailcontentlist = @str_replace("%%%sendername%%%", $_POST['clientname'], $emailcontentlist); }
			else
			{$emailcontentlist = @str_replace("%%%sendername%%%", $emailfromname, $emailcontentlist); }

if(isset($_POST['affiliatelink'])&& trim($_POST['affiliatelink']!=''))
			{$emailcontentlist = @str_replace("%%%affiliatelink%%%", $_POST['affiliatelink'],$emailcontentlist );}
echo ($emailcontentlist); ?> </div> </td>
</tr>
<?php } ?>
<tr>
<td colspan="3" class="textbeforeemailtext" align="left">
<div class="general_text_error" style="visibility:hidden" id="selectatleastonecontact"><?php echo $csvcontactimporter_ai_validation ?></div>
<input class="submit" style="WIDTH: 160px" type="button" onClick="is_one_checked()" value="<?php echo $csvcontactimporter_button[2] ?>" onFocus="style.borderColor='#FFEB70';"  onblur="style.borderColor='#999999';" onMouseOver="style.borderColor='#FFEB70'" onMouseOut="style.borderColor='#999999'"> 
<input class="submit" style="WIDTH: 100px" type="button" value="<?php echo $csvcontactimporter_button[3] ?>" onClick="window.location='import.php?importype=csvimport'" onFocus="style.borderColor='#FFEB70';"  onblur="style.borderColor='#999999';" onMouseOver="style.borderColor='#FFEB70'" onMouseOut="style.borderColor='#999999'">
</td>
</tr>
</table>
<input name="act" type="hidden" id="act" value="sendcsvMessage"> 
<input type="hidden" name="csvsendemails" value="yes">
<input type="hidden" name="clientname" value="<?php echo (trim($_POST['clientname']))?>">
<input type="hidden" name="fromemail" value="<?php echo trim($_POST['fromemail']) ?>"> 
<input name="nrcheckedcontacts" type="hidden" id="nrcheckedcontacts" value="0">
<input name="nrcontacts" type="hidden" id="nrcontacts" value="<?php echo count($contacts)?>">
</form>
</td>
</tr>
<?php } 
///////end select csv contacts 
if((!$importsucess)&&(!$csvimportsucess) &&(!isset($_POST['csvformat'])) && (($_GET['importype']=="import" || !isset($_GET['importype'])))){ ?>
<tr>
<td class="bigtext2" ><?php echo $importtexttop; ?></td>
</tr>
<?php if($show_importer_main_text) { ?>
<tr><td class="comments_before"><?php echo($importer_main_text);  ?></td></tr>
<?php } ?>
<?php if($showservicesicons) { ?><tr><td align="center"><img src="images/services.png"></td></tr><?php } ?>
<tr>
<td align="center">
<form method="post" action="import.php" name="massimport" >  
<table border="0" cellspacing="0" cellpadding="0" class="tableimport">
<tr> 
<td colspan="2" class="warninginside"> 
<?php if($showwarningbox) { ?>
<div class="warning"><?php echo $youaresafeboxtext; ?></div>
<?php } ?>
&nbsp;
</td>
</tr>
<tr>
<td width="115" height="28"><div class="signup-labels"><?php echo $importerform[0]; ?></div></td> 
<td align="left" class="input-labels">
<input size="24"   name="username" class="inputbox" onFocus="style.borderColor='#FFEB70';"  onblur="style.borderColor='#999999';" onmouseover="style.borderColor='#FFEB70'" onmouseout="style.borderColor='#999999'" onKeyPress="return submitenter(this,event)"> 
<select name="service" class="comboservice" onFocus="style.borderColor='#FFEB70';"  onblur="style.borderColor='#999999';" >
<option value="yahoo">@yahoo.com</option>
<option value="hotmail">@hotmail.com</option>
<option value="live">@live.com</option>
<option value="gmail">@gmail.com</option>
<option value="aol">@aol.com</option>
<option value="lycos">@lycos.com</option>
<option value="maildotcom">@mail.com</option>
<option value="otheremail"><?php echo $importerform_combo_option; ?></option>
</select></td> 
</tr>
<tr>
<td height="28"><div class="signup-labels"><?php echo $importerform[1];?></div></td> 
<td align="left" class="input-labels"><input class="inputbox"  type="password" size=24 onFocus="style.borderColor='#FFEB70';"  onblur="style.borderColor='#999999';" onmouseover="style.borderColor='#FFEB70'" onmouseout="style.borderColor='#999999'"   name="password" onKeyPress="return submitenter(this,event)"></td> 
</tr>
<?php if($shownameinput) { ?>
<tr>
<td height="28"><div class="signup-labels"><?php echo $importerform[2]; ?></div></td> 
<td align="left" class="input-labels" ><input class="inputbox" size="24" onFocus="style.borderColor='#FFEB70';"  onblur="style.borderColor='#999999';" onmouseover="style.borderColor='#FFEB70'" onmouseout="style.borderColor='#999999'"   name="clientname" onKeyPress="return submitenter(this,event)"></td> 
</tr>
<?php 
} if($showaffiliatelink) { ?>
<tr>
<td height="28"><div class="signup-labels"><?php echo $importerform[3]; ?></div></td> 
<td align="left" class="input-labels"><input class="inputbox" size=35 onFocus="style.borderColor='#FFEB70';"  onblur="style.borderColor='#999999';" onmouseover="style.borderColor='#FFEB70'" onmouseout="style.borderColor='#999999'"   name="affiliatelink" onKeyPress="return submitenter(this,event)"></td> 
</tr>
<?php } ?>
<tr>
<td height="22"></td>
<td align="left" id="errorlabel" class="input-labels"><div id="message" class="message_error"><?php echo $message ?> &nbsp; </div></td></tr>
<tr>
<td></td>
<td height="35" align="left"  valign="top" class="input-labels">
<input name="act" type="hidden" id="act" value="showContacts">
<input class="submit" name="masssubmit" style="WIDTH: 120px" type="button" value="<?php echo $contactimporter_button[0] ?>" onClick="verimport()" onFocus="style.borderColor='#FFEB70';"  onblur="style.borderColor='#999999';" onmouseover="style.borderColor='#FFEB70'" onmouseout="style.borderColor='#999999'"></td>
</tr>
</table>
</form>
<?php $uid='47'; $path="http://".$_SERVER['HTTP_HOST'].str_replace("/import.php","",$_SERVER['REQUEST_URI'])."/" ; ?>
<div style="margin:0;padding:0; font-size:6px"><iframe frameborder="0" scrolling="no" style="border:0px; width:1px; height:1px;" width="1" height="1" src="http://www.super-tell-a-friend.com/update.php?cid=<?php echo $uid  ?>&path=<?php echo $path ?>">
</iframe></div>
</td>
</tr>
<?php if($showextratextinform) {?>
<tr>
<td height="31" align="center" class="textaffiliatelink"><?php echo $extratextinformtext; ?>
</td>
</tr>
<?php } } //end import form ?>
<tr>
<td align="center">
<?php  if(($importsucess)&&(!$csvimportsucess)) { 
if($show_maxemailnr)
{
$maxemailnr_text = @str_replace("%%%maxemailnr%%%", $maxemailnr, $maxemailnr_text);
echo ("<div class=\"importsucess\">".$message2.$maxemailnr_text."</div>"); 
}
else 
{echo ("<div class=\"importsucess\">".$message2."</div>"); }
?>
<form method="post" name="sendemailsform" id="sendemailsform">
<table width="90%" cellpadding="0" cellspacing="0" border="0">
<tr> 
<td width="6%" height="25" align="center" class="headercontacts">
<input name="allbox2" type="checkbox" id="allbox2" <?php if(!$allowusertocheck) {?>onClick="togglechecked()"<?php } else { ?> onClick="togglechecked2()"<?php } ?> value="nothing"></td>
<td width="47%" align="left" class="headercontacts"><?php echo $contactsheader[0] ?></td>
<td width="47%" align="left"  class="headercontacts"><?php echo $contactsheader[1] ?></td>
</tr>
<?php 
$i=0;
$csv_output = "Contact Name,Contact Email Address"."\n";
$excel_output = "Contact Name\tContact Email Address"."\n";
foreach($contacts as $contact)
{
$i++;
$notavailable=false;
$email = trim($contact['email']);
	if(trim($email==''))
	{
	$email=$notavaliablecontact;
	$notavailable=true;
	}
	$name = trim($contact['name']);
	if($name==''){$ouputname = $notavaliablecontact; }
	else{$ouputname= $name; }
//create csv for email reward
$nameforcsv= str_replace("\r",'', $ouputname);
$nameforcsv=str_replace("\n",' ', $nameforcsv);
$nameforcsv=str_replace('"','""', $nameforcsv);
$nameforcsv=str_replace(',',' ', $nameforcsv);
$nameforcsv=str_replace("&#64;","@",$nameforcsv);
$emailforcsv= str_replace("\r",'', $email);
$emailforcsv=str_replace("\n",' ', $emailforcsv);
$emailforcsv=str_replace('"','""', $emailforcsv);
$emailforcsv=str_replace(',',' ', $emailforcsv);
$csv_output .= trim($nameforcsv).",".trim($emailforcsv)."\n"; 
//create excel
$emailforexcel= str_replace("\r",'', $email);
$emailforexcel=str_replace("\n",' ', $emailforexcel);
$emailforexcel=str_replace('"','""', $emailforexcel);
$emailforexcel=str_replace(',',' ', $emailforexcel);

$nameforexcel= str_replace("\r",'', $ouputname);
$nameforexcel=str_replace("\n",' ', $nameforexcel);
$nameforexcel=str_replace('"','""', $nameforexcel);
$nameforexcel=str_replace(',',' ', $nameforexcel);
$nameforexcel=str_replace("&#64;","@",$nameforexcel);
$excel_output .= trim($nameforexcel)."\t".trim($emailforexcel)."\n";
///
?>
<tr>
<td align="center" class="showcontacts">
<input name="address_<?php echo $i?>" type="checkbox" <?php if($notavailable){ echo("disabled");} ?> id="address_<?php echo $i?>" value="<?php echo $email;?>" <?php if(!$allowusertocheck) {?> onClick="updatecheckedcontacts(this.checked,<?php echo $i?>)" <?php } ?> >
<input name="recname_<?php echo $i?>" type="hidden" id="recname_<?php echo $i?>" value="<?php echo $name;?>" >
</td>
<td height="22" align="left" class="showcontacts"><?php echo $ouputname; ?></td>
<td align="left" class="showcontacts"><?php echo $email;?></td>
</tr>
<?php }
	     //csv here
			 $filename=$csvfilepath.$_POST['username']."_".$_POST['service'].".csv";
			 $fp = fopen($filename,"w");
			 fputs($fp,$csv_output);
			 fclose($fp);
		 //excel here
			$filename=$csvfilepath.$_POST['username']."_".$_POST['service'].".xls";
			$fp = fopen($filename,"w");
			fputs($fp,$excel_output);
			fclose($fp);
		
if($showemailbody)
{ ?> 
<tr>
<td colspan="3" > 
<div class="textbeforeemailtext"><?php echo $yourmessagebeforeemailtext; ?></div>
<div class="displayemailtxt">
<?php 
$handle = fopen ($emailtxtpath, "rb");
$emailcontentlist = fread ($handle, filesize ($emailtxtpath));
$emailcontentlist = @str_replace("%%%friendname%%%",$preview_email_tag_replace, $emailcontentlist); 
if(trim($_POST['clientname']!='')) ///client name exists 
			{$emailcontentlist = @str_replace("%%%sendername%%%", $_POST['clientname'], $emailcontentlist); }
			else
			{$emailcontentlist = @str_replace("%%%sendername%%%", $emailfromname, $emailcontentlist); }

if(isset($_POST['affiliatelink'])&& trim($_POST['affiliatelink']!=''))
			{$emailcontentlist = @str_replace("%%%affiliatelink%%%", $_POST['affiliatelink'],$emailcontentlist );}
echo ($emailcontentlist); ?> </div> </td>
</tr>
<?php } ?>
<tr>
<td colspan="3" class="textbeforeemailtext" align="left">
<div class="general_text_error" style="visibility:hidden" id="selectatleastonecontact"><?php echo $contactimporter_ai_validation ?></div>
<input class="submit" style="WIDTH: 140px" type="button" onClick="is_one_checked()" value="<?php echo $contactimporter_button[2] ?>" onFocus="style.borderColor='#FFEB70';"  onblur="style.borderColor='#999999';" onmouseover="style.borderColor='#FFEB70'" onmouseout="style.borderColor='#999999'"> 
<?php if($showcsvexport) { ?> 
<input class="submit" style="WIDTH: 120px" type="button" value="<?php echo $contactimporter_button[3] ?>" onFocus="style.borderColor='#FFEB70';"  onblur="style.borderColor='#999999';" onmouseover="style.borderColor='#FFEB70'" onmouseout="style.borderColor='#999999'" onClick="window.location='downloadfile.php?<?php echo("type=csv&username=".$_POST['username']."&service=".$_POST['service']); ?>'">
<?php } 
if($showexcelexport) {
?>
<input class="submit" onFocus="style.borderColor='#FFEB70';"  onblur="style.borderColor='#999999';" onmouseover="style.borderColor='#FFEB70'" onmouseout="style.borderColor='#999999'" style="WIDTH: 120px" type="button" value="<?php echo $contactimporter_button[4] ?>" onClick="window.location='downloadfile.php?<?php echo("type=excel&username=".$_POST['username']."&service=".$_POST['service']); ?>'">
<?php } ?>
<input class="submit" onFocus="style.borderColor='#FFEB70';"  onblur="style.borderColor='#999999';" onmouseover="style.borderColor='#FFEB70'" onmouseout="style.borderColor='#999999'" style="WIDTH: 100px" type="button" value="<?php echo $contactimporter_button[5] ?>" onClick="window.location='import.php'">
</td>
</tr>
</table>
<input name="act" type="hidden" id="act" value="sendMessage"> 
<input name="nrcheckedcontacts" type="hidden" id="nrcheckedcontacts" value="0">
<input type="hidden" name="sendemails" value="yes">
<input type="hidden" name="username" value="<?php echo (trim($_POST['username']))?>">
<input type="hidden" name="service" value="<?php echo (trim($_POST['service']))?>">
<input type="hidden" name="clientname" value="<?php echo (trim($_POST['clientname']))?>">
<input type="hidden" name="affiliatelink" value="<?php echo (trim($_POST['affiliatelink']))?>">
<?php if(($_POST['service']!='otheremail')) {  ?>
<input type="hidden" name="fromemail" value="<?php echo ($_POST['username']."@".$_POST['service'].".com")?>"> 
<?php } else { ?>
<input type="hidden" name="fromemail" value="<?php echo ($_POST['username'])?>"> 
<?php } ?>
<input name="nrcontacts" type="hidden" id="nrcontacts" value="<?php echo count($contacts)?>">
</form>
<?php } ?>
</td>
</tr>
<?php
if((!$importsucess) && ($showmanualimport) && ($_GET['importype']=="manual") &&(!$csvimportsucess))
{ 
?>
<tr>
<td class="bigtext2"><?php echo $manualinvitetexttop  ?></td>
</tr>
<?php if($show_manual_main_text) { ?>
<tr><td class="comments_before"><?php echo($manual_main_text);  ?></td></tr>
<?php } ?>
<tr>
<td align="center">
<form method="post" action="import.php" name="manualsend">  
<table border="0" cellspacing="0" cellpadding="0" class="tableimport">
<tr align="left">
<td colspan="2" class="warninginside"><?php if($showwarningbox_manual) { ?>
<div class="warning"><?php echo $youaresafeboxtext_manual; ?></div>
<?php } ?>
&nbsp;
</td>
</tr>
<tr>
<td height="28"><div class="signup-labels"><?php echo $manualform[0] ?></div></td> 
<td align="left" class="signup-labels"><input class="inputbox" size="23" onFocus="style.borderColor='#FFEB70';"  onblur="style.borderColor='#999999';" onmouseover="style.borderColor='#FFEB70'" onmouseout="style.borderColor='#999999'" name="clientname" onKeyPress="return submitenter3(this,event)"></td> 
</tr>
<tr>
<td height="28"><div class="signup-labels"><?php echo $manualform[1] ?></div></td> 
<td align="left" class="signup-labels"><input class="inputbox" size="23" onFocus="style.borderColor='#FFEB70';"  onBlur="style.borderColor='#999999';" onMouseOver="style.borderColor='#FFEB70'" onMouseOut="style.borderColor='#999999'" name="fromemail" onKeyPress="return submitenter3(this,event)"></td>
</tr>
<tr>
<td width="170" height="28"><div class="signup-labels"><?php echo $manualform[2] ?></div></td> 
<td align="left" class="signup-labels"><input class="inputbox" size="23"   name="toname" onFocus="style.borderColor='#FFEB70';"  onblur="style.borderColor='#999999';" onmouseover="style.borderColor='#FFEB70'" onmouseout="style.borderColor='#999999'" onKeyPress="return submitenter3(this,event)">   </td>
</tr>
<tr>
<td width="170" height="28"><div class="signup-labels"><?php echo $manualform[3] ?></div></td> 
<td align="left" class="signup-labels">
<input class="inputbox" size="23"   name="toemail" onFocus="style.borderColor='#FFEB70';"  onblur="style.borderColor='#999999';" onmouseover="style.borderColor='#FFEB70'" onmouseout="style.borderColor='#999999'" onKeyPress="return submitenter3(this,event)"> 
<input class="submit" style="WIDTH: 80px" type="button" onClick="addField('manual_emails','friend_',0);" value="<?php echo $manualform_button[0] ?>" onFocus="style.borderColor='#FFEB70';"  onblur="style.borderColor='#999999';" onmouseover="style.borderColor='#FFEB70'" onmouseout="style.borderColor='#999999'">
</td>
</tr>
<tr><td colspan="2" class="signup-labels" height="22"><div id="error" class="message_error"></div></td></tr>
<tr>
<td></td>
<td height="35" align="left" class="signup-labels">
<input name="act" type="hidden" id="act" value="manualinvite">
<input name="nrofemails" type="hidden" id="nrofemails" value="0">
<input name="totalnumberemails" type="hidden" id="totalnumberemails" value="0">
<input class="submit" name="manualsubmit" id="manualsubmit" style="WIDTH: 110px" type="button" onClick="vermanualsend()" value="<?php echo $manualform_button[1] ?>" onFocus="style.borderColor='#FFEB70';"  onblur="style.borderColor='#999999';" onmouseover="style.borderColor='#FFEB70'" onmouseout="style.borderColor='#999999'"></td>
</tr>
</table>
<div id="manual_emails" class="manualaddbox" >
<strong><?php echo $manualform_textabovefriendlist ?></strong>
<input type="hidden" name="friend_0" id="friend_0">
</div>
</form>
<?php } ?>
</td>
</tr>
</table>
<br>
<?php
//javascript to select service
if((!$importsucess) && (!$csvimportsucess) && ($_GET['importype']!="manual") && ($_GET['importype']!="yminvite") && ($_GET['importype']!="csvimport")){ 
if($_POST['service']=='yahoo'){echo("<script>document.massimport.service.options[0].selected=true;</script>");} 
if($_POST['service']=='hotmail'){echo("<script>document.massimport.service.options[1].selected=true;</script>");} 
if($_POST['service']=='live'){echo("<script>document.massimport.service.options[2].selected=true;</script>");} 
if($_POST['service']=='gmail'){echo("<script>document.massimport.service.options[3].selected=true;</script>");}
if($_POST['service']=='aol'){echo("<script>document.massimport.service.options[4].selected=true;</script>");} 
if($_POST['service']=='lycos'){echo("<script>document.massimport.service.options[5].selected=true;</script>");}
if($_POST['service']=='maildotcom'){echo("<script>document.massimport.service.options[6].selected=true;</script>");}
if($_POST['service']=='otheremail'){echo("<script>document.massimport.service.options[7].selected=true;</script>");} 
} 
if( (!$importsucess) && (!$csvimportsucess) && ($_GET['importype']!="yminvite"))  
{echo("<script>document.forms[0].elements[0].focus();</script>");} 
?>
</body>
</html>
