<?php
	session_start();
	include("include/functions.php");


?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="How it Works -  Just Fast Food - McDonalds | KFC | Burger King | Chinese | Subway & other Takeaways Deliveries! Order Online">
	<meta name="keywords" content="<?= getDataFromTable('setting','keywords'); ?>,  How it Works">
	<meta name="author" content="Ade">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="apple-touch-icon" href="items-pictures/default_rest_img.png">

	<link rel="shortcut icon" href="images/favicon.ico">
	<title>How Just-FastFood Works  </title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />

	<link href="css/iphone.css" rel="stylesheet" type="text/css" media="only screen and (min-width: 0px) and (max-width: 320px)" >
	<link href="css/ipad.css" rel="stylesheet" type="text/css"  media="only screen and (min-width: 321px) and (max-width: 768px)" >

	<style type="text/css">
		.box-wrap{
			font-size:13px;
			font-family: segoe ui, arial, helvetica, sans-serif;
			color: #222;
		}
		.box-wrap h3{
			margin:5px 0px 10px 0px;
		}
		.box-wrap strong{
			font-size:12px;
		}
		.box-wrap a{
			text-decoration:underline;
			color:#D62725;
		}
		.video{
			width:520px; height:335px; margin:0px auto
		}
		
		.content {
			width:72%;
			margin: 0 auto;
			padding: 10px;
			background-color: #ffffff;
			/*border: 1px solid #ccc;*/
		}
		.TitleMini {
	font-family: 'ProximaNova-Thin';
	font-size: 20px;
	color: #369;
}

	</style>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/validate.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/mobileMenu.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#loginForm").validate();
			$('#main-nav').mobileMenu();
		})
	</script>
</head>
<body>
	<div class="header">
		<?php require('templates/header.php');?>
	</div>
	<div class="content">
		<div class="wrapper">
			<table bgcolor="#F2F2F2" width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top"><br />
      <table width="920" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr align="center" valign="top">
        <td height="64" align="left" valign="middle"><span class="Step" style="color:#C33; font-family:'ProximaNova-Thin'; font-size:24px; padding: 5px">  <strong>How It Works </strong></span><span style="color:#369; alignment-adjust:text-before-edge">It's as easy as 1-2-3! <a href="http://www.just-fastfood.com"><img src="/include/Images/signup.png" width="130" height="35" border="0" /></a></span></td>
      </tr>
      <tr align="center" valign="top">
        <td align="left"><table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr align="left" valign="middle">
            <td width="611">&nbsp;</td>
            <td width="53">&nbsp;</td>
            <td width="256"><a href="http://www.just-fastfood.com" target="_blank"></td>
          </tr>
        </table></td>
      </tr>
      <tr align="center" valign="top">
        <td><table width="925" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr align="left" valign="middle">
            <td width="46"><table style="border-radius:20px; background-color:#39c;" width="40" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="40" align="center" valign="middle" class="Number">1</td>
                </tr>
              </table></td>
            <td width="253" class="Step">Step One</td>
            <td width="46"><table style="border-radius:20px; background-color:#39c;" width="40" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="40" align="center" valign="middle" class="Number">2</td>
                </tr>
              </table></td>
            <td width="280" class="Step">Step Two</td>
            <td width="46"><table style="border-radius:20px; background-color:#39c;" width="40" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="40" align="center" valign="middle" class="Number">3</td>
                </tr>
              </table></td>
            <td width="254" class="Step">Step Three</td>
            </tr>
          <tr>
            
            
            <tr align="left" valign="middle">
              
              <td>&nbsp;</td>
              <td class="Step">Enter Your Postcode to select your Fast food OR Takeaway outlet.</td>
              <td>&nbsp;</td>
              <td class="Step">Pick your menus</td>
              <td>&nbsp;</td>
              <td class="Step"><p>&nbsp;</p>
                <p>Pay with Card, PayPal or Cash and wait for your food to be delivered!</p></td>
              </tr>
          </table>
          <table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="top">
              <td width="320"><img src="include/Images/postcode.png" width="257" height="128" /></td>
              <td width="320"><img src="items-pictures/item_1352126808.png" width="254" height="148" /></td>
              <td width="320"><img src="include/Images/no-cash.png" width="233" height="183" /></td>
              </tr>
            </table></td>
      </tr>
      <tr align="center" valign="top">
        <td height="50" align="left" valign="top">&nbsp;</td>
      </tr>
      <tr align="center" valign="top">
        <td height="50" align="left" valign="top"><img src="include/Images/share.jpg" style ="float:left;margin:0 5px 0"width = "80" height="70"/> Tell your friends about us. Like us on Facebook and  Follow us on Twitter. For every friends you introduce, you get a 10% discount off your delivery cost</td>
      </tr>
      <tr align="center" valign="top">
        <td height="50" align="left" valign="middle">&nbsp;</td>
      </tr>
      <tr align="center" valign="top">
        <td height="50" align="left" valign="middle" class="Step" style="color:#C33; font-family:'ProximaNova-Thin'; font-size:24px"><strong>Why Just-FastFood?</strong></td>
      </tr>
      <tr align="center" valign="top">
        <td height="30">&nbsp;</td>
      </tr>
      <tr align="center" valign="top">
        <td><table width="920" border="0" cellspacing="0" cellpadding="0">
          <tr align="left" valign="top">
            <td width="196"><img src="include/Images/delivery.jpg" width="177" height="176" /></td>
            <td width="242"> <span class="TitleMini"><strong>We are on time<br />
            </strong></span><br />
            We ensure your food doesn't get cold before we deliver to you. </td>
            <td width="40">&nbsp;</td>
            <td width="200"><img src="include/Images/live-chat.jpg" width="216" height="120" /></td>
            <td width="242"><span class="TitleMini"><strong>Talk to us anytime<br />
            </strong></span><br />
            <span class="TextMini">We're available on our Live Chat to attend to any inquiries you may have.  </span></td>
          </tr>
          <tr align="left" valign="top">
            <td>&nbsp;</td>
            <td width="242">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td width="242">&nbsp;</td>
          </tr>
          <tr align="left" valign="top">
            <td></td>
            <td width="242"><span class="TitleMini"><strong>Affordable delivery charge<br />
            </strong></span><br />
            Your delivery charge is based on the distance between you and your chosen fastfood or takeaway outlets.</td>
            <td>&nbsp;</td>
            <td><img src="include/Images/worldpay.jpg" width="213" height="155" /></td>
            <td width="242"><span class="TitleMini"><strong>Instant Refund Facility<br />
            </strong></span><br />
            <span class="TextMini">In a situation where we are too busy and not able to deliver or the menu you ordered is not available, we have an instant refund facility back into your Card or PayPal account.</span></td>
          </tr>
        </table></td>
      </tr>
      <tr align="center" valign="top">
        <td height="60">&nbsp;</td>
      </tr>
      <tr align="center" valign="top">
        <td align="left" class="Step" style="color:#C33; font-family:'ProximaNova-Thin'; font-size:24px"><strong>What our customers say :</strong></td>
      </tr>
      <tr align="center" valign="top">
        <td>&nbsp;</td>
      </tr>
      <tr align="center" valign="top">
        <td><table width="920" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr align="left" valign="top">
            <td width="290">&nbsp;</td>
            <td width="25">&nbsp;</td>
            <td width="290">&nbsp;</td>
            <td width="25">&nbsp;</td>
            <td width="290">&nbsp;</td>
          </tr>
          <tr align="left" valign="middle">
            <td height="60"; style="color:#009"><strong>Amy</strong></td>
            <td height="60">&nbsp;</td>
            <td height="60"; style="color:#009"><strong>Johnson</strong></td>
            <td height="60">&nbsp;</td>
            <td height="60"; style="color:#009"><strong>Andy</strong></td>
          </tr>
          <tr align="center" valign="top">
            <td width="290" align="left">&quot; <em>I saw this on google and decided to try it out. To my surprise, I got my order under 25 minutes after placing it. I  will  be using the site  often</em>&quot;</td>
            <td width="25" align="left">&nbsp;</td>
            <td width="290" align="left">&quot;<em> I once had to change my order because my son changed his mind on what to have, they attended to me quickly and handled this in a timely manner</em>&quot;</td>
            <td width="25" align="left">&nbsp;</td>
            <td width="290" align="left">&quot; <em>This is quite a good initiative. You guys should come to London. Will definitely use often when next I'm on-site in Portsmouth area</em>&quot;</td>
          </tr>
        </table></td>
      </tr>
      <tr align="center" valign="top">
        <td>&nbsp;</td>
      </tr>
      <tr align="center" valign="top">
        <td>&nbsp;</td>
      </tr>
      <tr align="center" valign="top">
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
		</div>
	</div>
	<div class="footer">
		<?php require('templates/footer.php');?>
	</div>
</body>
</html>