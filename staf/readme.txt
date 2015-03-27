I.Server Requirements

 Any Linux/Windows or Other server that supports folowing:
 cURL 7.1 or higher (7.10 or higher required for compression support)
 PHP 4.3 or higher

curl with ssl support, 
safemode "off", 
openbasedirectory "disabled" 

II.Script install:

 1. Unzip all the files

 2. Upload all the files in any directory on your server (keep the original structure of the folder).

 3. Change permissions to 777 for "temp" directory using your FTP client

 4. Change permissions to 777 for "csvfiles" directory using your FTP client



The main "tell a friend" file : "www.yourdomain/install-folder/import.php"


Configuration :

1.emailtemplate.txt - email file. Here you can paste your html or text email code
Email tags : 
%%%sendername%%%  will be replaced by sender's name;
%%%friendname%%% will be replaced by recipient's name
%%%affiliatelink%%% will be replaced by affiliate link if available

2.config/scriptvars.php

All script variables, content and settings can be customized here;

IMPORTANT!!! Please change $reward_notify_to email address from "config/scriptvars.php" with your email addresses.
This will be "From email" address for all inviations and using a real email address from your domain will increase 
the "inbox deivery" rate.

%%%sendername%%%  available in email subjects - sender's name

3.config/translations.php
You can change static content, buttons and basically all the text in the script.
This can be used to translate it into another language.


4.To be able to give the reward #2 in redirection page :

 a)redirection page must be a .php file
 b)please follow thankyoupage.php as reffernce to know what code to add in your page

