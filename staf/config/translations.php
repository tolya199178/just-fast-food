<?php
/* the translations for the static text/controls in the script */
/* most of them accept html code */
/* These translations are the default in English and usually you do not need to change it*/
/* If you want to customize the script or to translate it another language, feel free to change all variables.*/
/* Please keep the comments for each variable in order to know the original value */

/* Top links - visible in all sections - html formatting allowed */
$toplink[0]="<b>Import your address book</b>"; // top navigation link : <b>Import your address book</b>
$toplink[1]="<b>Import contacts from csv</b>"; //  top navigation link : <b>Import contacts from csv</b>
$toplink[2]="<b>Manually add emails</b>"; //  top navigation link : <b>Manually add emails</b>
$toplink[3]="<b>Invite your YM friends</b>"; //  top navigation link : <b>Invite your YM friends</b>

/* 1.Contact importer section */

$importtexttop="Invite Friends from Your Address Book"; //text above contact importer before importing process :  Invite Friends from Your Address Book

/*importer form text */
$importerform[0]="Email Address :"; //Email Address :
$importerform[1]="Password :"; //Password :
$importerform[2]="Your Name :"; //Your Name :
$importerform[3]="Affiliate Link :"; //Affiliate Link :
/*contact importer fields validation 
if you want to use single quote, escape it like this: \' 
for double quotes, use : &quot;
*/
$contactimporter_validation[0]="Please complete your email address."; //Please complete your email address.
$contactimporter_validation[1]="Please insert your password."; //Please insert your password.
$contactimporter_validation[2]="Please complete your name."; //Please complete your name.
$contactimporter_validation[3]="Please complete your affliliate link."; //Please complete your affliliate link.
$contactimporter_validation[4]="Please insert a valid email address."; //If "Other domain" selected and email has wrong format -> Please insert a valid email address.
$contactimporter_validation[5]="For &quot;.com&quot; accounts insert only your account name.";
/*contact importer controls */
$importerform_combo_option="Regional domains"; ///the last option in select service dropdown
$contactimporter_button[0]="Import Contacts"; //Submit button initial state : Import Contacts
$contactimporter_button[1]="Please wait..."; //Submit button last state : Please wait...
$contactimporter_button[2]="Invite Contacts"; //Invite Contacts button text
$contactimporter_button[3]="Export to CSV"; // Export to CSV button text
$contactimporter_button[4]="Export to Excel"; //Export to Excel button text
$contactimporter_button[5]="Cancel"; //Cancel button text
/* text after importing */
$cimp_afterimport[0]="Invalid login or no contacts found."; //Invalid username or password.
$cimp_afterimport[2]=" contact(s) found in your address book."; // X contact(s) found in your address book. <br>
$cimp_afterimport[3]="Email service unsupported."; // Email service unsupported.
$hintafterimport="";  //top hint after importing contacts
$yourmessagebeforeemailtext="Here is what your message will look like : <br>"; //text above email's body after import
$contactsheader[0]="Contact Name"; //Contact Name
$contactsheader[1]="Email Address"; //Email Address
$notavaliablecontact="Not Available"; //Not Available contact
$preview_email_tag_replace="[your friend name here]"; //after import -> replace friend mae tag with this inPreview email
$contactimporter_ai_validation="Please select at least one contact to invite."; //Please select at least one contact.

/* 2.CSV importer section */
$csvimporttexttop="Import and invite your friends from a CSV file"; //top text csv importer section : Import and invite your friends from a CSV file

/*csv importer form text */
$csvimporterform[0]="Your Name :"; // Your Name :
$csvimporterform[1]="Your Email Address :"; // Your Email Address :
$csvimporterform[2]="Csv File Format :"; // Csv File Format :
$csvimporterform[3]="Csv File To Import :"; // Csv File To Import :
/*csv importer fields validation 
if you want to use single quote, escape it like this: \' 
for double quotes, use : &quot;
*/
$csvcontactimporter_validation[0]="Incorrect file format."; //Incorrect file format.
$csvcontactimporter_validation[1]="Please complete your name."; //Please complete your name.
$csvcontactimporter_validation[2]="Please complete your email address."; //Please complete your email address.
$csvcontactimporter_validation[3]="Please insert a valid email address."; //Please insert a valid email address.
$csvcontactimporter_validation[4]="Browse for your csv file."; //Browse for your csv file.
$csvcontactimporter_validation[5]="Incorrect file format."; //Incorrect file format.
/*csv contact importer controls */
$csvimporterform_combo_option="Generic CSV file"; //Generic CSV file - the last option in select csv type dropdown
$csvcontactimporter_button[0]="Import Contacts"; //Submit button initial state : Import Contacts
$csvcontactimporter_button[1]="Please wait..."; //Submit button last state : Please wait...
$csvcontactimporter_button[2]="Invite Selected Friends"; //Invite Selected Friends text button
$csvcontactimporter_button[3]="Cancel"; //Cancel button text
//text after importing
$csvimp_afterimport[0]=" contact(s) found in your csv file."; // X contact(s) found in your csv file. <br>
$csvimp_afterimport[1]="No contacts found in your csv file."; //error : No contacts found in your csv file.  <br>
$csvimp_afterimport[2]="Error uploading file."; //error : Error uploading file.
$csvcontactsheader[0]="Contact Name"; //Contact Name
$csvcontactsheader[1]="Email Address"; //Email Address
$csvnotavaliablecontact="Not Available"; //Not Available contact
$csvpreview_email_tag_replace="[your friend name here]"; //after import -> replace friend name tag with this in Preview email
$csvcontactimporter_ai_validation="Please select at least one contact to invite."; //Please select at least one contact.

/* 3.Classic tell a friend section */
$manualinvitetexttop="Manually add emails and invite your friends "; //text above manual inviter before sending the manual invite : Manually add emails and invite your friends 

/*manual add emails form text */
$manualform[0]="Your Name :"; //Your Name : 
$manualform[1]="Your Email Address :"; //Your Email Address :
$manualform[2]="Friend's Name :"; //Friend's Name :
$manualform[3]="Friend's Email Address :"; //Friend's Email Address :
/*form fields validation 
if you want to use single quote, escape it like this: \' 
for double quotes, use : &quot;
*/
$manualform_validation[0]="Your name and email address are required. Please fill in."; //Your name and email address are required. Please fill in.
$manualform_validation[1]="Please insert a valid email address."; //Please insert a valid email address.
$manualform_validation[2]="Please add at least one email address."; //Please add at least one email address.
$manualform_validation[3]="Friend name is required."; //Friend name is required.
$manualform_validation[4]="Please insert a valid email address."; //Please insert a valid email address.
$manualform_validation[5]="[Remove this email]"; //[Remove this email]
/*form controls */
$manualform_button[0]="Add Email"; //add email button: Add Email
$manualform_button[1]="Invite Friends"; //Invite Selected Friends text button : Invite Friends
$manualform_button[2]="Please wait..."; //Submit button last state : Please wait...
$manualform_textabovefriendlist="Friends to invite : "; //Friends to invite : 

/* 4.YM messages section */
$mymtexttop="Invite Yahoo Messenger Contacts"; //text above yahoo messenger message sender : Invite Yahoo Messenger Contacts

?>