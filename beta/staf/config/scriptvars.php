<?php  
/* dynamic script variables */
/* These variables will customize the look and feel of the script. You do not need to change all, just the one reffering to your website and emails.*/

/*1.GENERAL SCRIPT SETTINGS AND PATHS */
$redirection="invitethankyoupage.php"; //this is the page where the user will be redirected after sending invitations.
$tempdirpath="temp/"; //temp directory for unix server - if you have windows server , edit this path conforming to your installation folder like in the example 
$csvfilepath="csvfiles/"; //csv files directory for unix server - if you have windows server , edit this path conforming to your installation folder like in the example 
//$tempdirpath="D:\\Inetpub\\path\\importer\\temp\\"; //change path like this if you are using windows server
//$csvfilepath="D:\\Inetpub\\path\\importer\\csvfiles\\"; //change path like this if you are using windows server
$yoursitename="www.super-tell-a-friend.com";  //your website url
$skin="gray"; //importer skin ; available : gray,blue,gray2,blue2,indigo
$htmlcharset="iso-8859-1"; //import.php - main page character set 
$emailcharset="iso-8859-1"; //email character set


/*2.IMPORTER SETTINGS */
/* input filed options and features */
$shownameinput=true; //if name field is visible
$showaffiliatelink=false; //if affiliate field is visible
$nameinputrequired=false; //if name is mandatory before submitting the invite form
$affliliateinputrequired=false; //if affliate link is mandatory before submitting the invite form
$showextratextinform=true; //extra text below import form - can be used to link to create account/affiliate link. If true complete the text below :
$extratextinformtext="<br><b>After importing the contacts you will be asked to select them before sending the test email.<br>The emails are sent in next step.</b><br>";
$showservicesicons=false; //if show yahoo,gmail,etc icons
/*display text settings */
$show_importer_main_text=true; // show main text above importer  - true or false. If true complete the text below :
$importer_main_text="It's really easy to invite your friends to our site.<br>Choose '<b>Regional domains</b>' if your email address is other than '.com' (.co.uk, .de, .fr, .it, .es , etc.) <br>In these cases you have to insert your full email address.<br>Next, click on <b>'Import Contacts'</b>."; //main text above importer
$showemailbody=true;  //if email body will be shown to the user BEFORE sending emails : true or false
$showwarningbox=true; //if warning box is visible in import section : true or false. If true complete the text below :
$youaresafeboxtext= "www.your-site.com WILL NOT store your personal information."; //warninge box content - importer section
$showcsvexport=false; //if export to csv is available after importing contacts
$showexcelexport=false; //if excel export is available after importing contacts

/*3.MANUAL ADD EMAILS SETTINGS */
$showmanualimport=false; //if manual import feature is available : true or false
$show_manual_main_text=true; // show main text above manual add emails  - true or false. If true complete the text below :
$manual_main_text="You can also add friends one by one.<br>Fill in friend's email and name one by one and then click <b>'Add Email'</b>.<br>Finally, insert your name and email address and click on <b>'Invite'</b> button."; //main text above manual invite
$showwarningbox_manual=true; //if warning box is visible in manual add emails section : true or false
$youaresafeboxtext_manual="We WILL NOT store your personal information."; //you are safe box content - manual add emails

/*4.YM INVITE */
$showyminvite=false; //if send yahoo messenger message is available
$show_ym_main_text=true; // show main text above ym invite  - true or false. If true complete the text below :
$manual_ym_text="<font>With a few clicks you can invite your Yahoo Messenger friends. <br>First, click on <b>'Send YM Message'</b>, then the application will ask to select your contacts.<br>Below you can preview your message.<br><br>Thank you."; //main text above ym
$ym_message='Check this website : http://www.super-tell-a-friend.com 
I am sure it will help you to promote your online business.';

/*5.CSV IMPORTER SETTINGS */
$showcsvimport=false; //if csv import is visible - true or false. 
$show_csv_main_text=false; // show main text above csv import - true or false.If true complete the text below :
$csvimport_main_text="Now, you can import your contact list exported directly from Outlook or Thunderbird.<br>
Or simply upload a CSV file with two columns : names and contacts.<br>
<b><a href='#' class=\"slink\" style=\"font-size:14px\" onclick=\"window.location='forcedownload.php'\">Click here to download and test a sample csv file.</a></b>";
$showwarningbox_csv=true; //if warning box is visible in import csv section : true or false. If true complete the text below :
$csvwarningtext="You are safe! We don't store your contacts or personal information.";

/*EMAIL INVITATION SETTINGS - for email import, csv import and manual */
$invite_subject="%%%friendname%%%, %%%sendername%%% sent you an invitation";  //invitation email subject you can use tags %%%friendname%%%, %%%friendname%%%
$emailtxtpath="template/emailtemplate.txt"; //email text file path. Edit that page to change your email's content. You can use html or plain text
/* Max emails allowed seetings */
$maxemailnr=20; //max number of emails sent once
$show_maxemailnr=false; //true or false ->after importing the contacts if the user will see how many emails is allowed to send
$maxemailnr_text="<b>This time, you can invite maximum %%%maxemailnr%%% friends.</b><br> Select your contacts one by one or click on the first checkbox 
to select the first %%%maxemailnr%%% contacts."; /// if $show_maxemailnr=true ->this is the text the user will see after importing
$allowusertocheck=false; //true or false - true if the user can check more contacts than max of emails llowsd to be sent 
//if name field is not mandatory, this will be from name field in email.Otherwise from name will be replaced by sender's name
$emailfromname="Super Tell a Friend";
$show_email_footer=true; 

/*REWARD SETTINGS #1 - email received by the user if he sends at least X number of emails*/
/* It must be lower than $maxemailnr defined above*/
$reward1_enabled=false; //if reward email is enabled true or false
$reward1_nrofemailssent=1; //reward email is sent if the user invites X friends 
$reward1_emailsubject="%%%sendername%%%, your reward inside."; //reward email subject
$reward1_fromname="Super-Tell-A-Friend Rewards"; //reward email from name
$reward1_fromemail="customers@yourdomain.com";//reward email from email name
$reward1_emailbody="%%%sendername%%%, thank you for inviting your friends to our website!<br>Belowe is your reward.<br><br><b><a href='http://www.super-tell-a-friend.com/contact-importer-demo.html'>Click here to download</a></b>.<br><br>Best regards,<br>Super-Tell-A-Friend team";//reward email body
$reward1_name="Reward1";
/*REWARD SETTINGS #2 - email received by the user if he sends X number of emails*/
$reward2_enabled=false; ////if reward on thank you page is enabled true or false
$reward2_nrofemailssent=2;  //reward2 is visible on thankyou page if the user invites X friends 
$reward2_name="Second Reward";
//REWARDS NOTIFICATIONS FOR SITE OWNER
$reward_notify=false; //if you will be notified by email if an user receives the reward
$reward_notify_emailsubject="New reward for %%%sendername%%% - Check attachment"; //reward email subject
$reward_notify_fromname="Super-Tell-A-Friend Admin Notification"; //reward email from name
$reward_notify_fromemail="customers@yourdomain.com";//reward email from email name
$reward_notify_emailbody="%%%sendername%%% invited his friends and received the rewards.<br><br><b>Check this email's attachment for details.</b><br><br>Rewards : ";//reward email body
$reward_notify_to="admin@yourdomain.com"; //your email address to receive notification

/*  
EMAIL TAGS -> these tags must be used in emailtemplate.txt

%%%sendername%%%  - will be replaced by sender's name;
%%%friendname%%% - will be replaced by recipient's name;
%%%affiliatelink%%% - will be replaced by affiliate link if it is visible;

SCRIPT  TAGS -> this tag must be used in $maxemailnr_text variable.
%%%maxemailnr%%% - if the user will see how many emails is allowed to send once ->this tag will be replaced by $maxemailnr

*/

?>
