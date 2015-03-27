<?php
	session_start();
	include("include/functions.php");

	$success = FALSE;
	if(isset($_SESSION['access_key']) && isset($_POST['access']) && $_POST['access'] == $_SESSION['access_key']) {
		if(isset($_POST['SUBMIT']) && ($_POST['name'] != "") && ($_POST['message'] != "") || ($_POST['email'] != "")) {

			$to = admin_email();
			$name = mysql_real_escape_string(strip_tags($_POST['name']));
			$email = mysql_real_escape_string(strip_tags($_POST['email']));
			$phone = mysql_real_escape_string(strip_tags($_POST['phone']));

			$message = '<strong>'.$name." Wants To Contact  Just-FastFood.com.<br/> His/Her Email : ".$email.'.<br/> Phoneno : '.$phone.'</strong><br/>';
			$message .= '"<i>'.mysql_real_escape_string(strip_tags($_POST['message'])).'</i>"';

			$subject = $_POST['subject']." | Contact us Email";
			$headers = "From:Just-FastFood <info@just-fastfood.com>\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			if(mail($to, $subject, $message, $headers)) {
				$_SESSION['success'] = "Message Sent";
				$success = TRUE;
			} else {
				$_SESSION['error'] = "Email Not Send";
			}
		} else {
			$_SESSION['error'] = "Fill All Field";
		}
	}

	$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="<?= getDataFromTable('setting','meta'); ?>">
	<meta name="keywords" content="<?= getDataFromTable('setting','keywords'); ?>, Contact Us">
	<meta name="author" content="M Awais">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="apple-touch-icon" href="items-pictures/default_rest_img.png">

	<link rel="shortcut icon" href="images/favicon.ico">
	<title>Contact Us - Just-FastFood  </title>
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
		.content {
			width:70%;
			margin: 0 auto;
			padding: 10px;
			background-color: #fff;
			border: 1px solid #ccc;
		}

	</style>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/validate.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/mobileMenu.js"></script>
    <script type="text/javascript" src="js/parsely.min.js"></script>
    <script type="text/javascript" src="js/zepto.icheck.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){

			$("#form").parsley({
                successClass: 'row',
                errorClass: 'row'
            });

		});
	</script>

</head>
<body>
	<div class="header">
		<?php require('templates/header.php');?>
	</div>
	<div class="content">
		<div class="wrapper">
			<div class=" box-wrap" style="margin:20px; ">
			<!--	<h1 class="subheading">Contact Us</h1><hr>-->
				<!--<p>
					<strong>Helpline:</strong> 0, From: 11:00AM - 8:00PM
				</p>-->
			<!--	<p>
					<strong>Email:</strong> <span style="font-style:italic">info@just-fastfood.com</span>
				</p>
				<p>
					<strong>Office Address: :</strong><br>
						145-157 ST JOHN STREET LONDON<br>
						ENGLAND<br>
						EC1V 4PW<br>
				</p>-->
				<h1 class="subheading">Contact Form</h1><hr>
				<?php include('include/notification.php');?>
				<?php
					if(!$success) {
				?>

				<div class="cbox-wrap margin-top login-wrap contactusWrap" style="width:96%">
					<p>All fields marked <span class="red">*</span> are required.</p>
					<form action="" method="post" id="loginForm" data-validate="parsley" >
						<div class="row">
							<label for="name"  class="b">Name: <span class="red">*</span></label><input type="text" name="name" id="name" class="input required" data-rangelength ="[4, 25]"/>
						</div>
						<div class="row">
							<label for="email" class="b">Email Address: <span class="red">*</span></label><input type="text" name="email" id="email" class="input required email" data-type="email"/>
						</div>
						<div class="row">
							<label for="phone"  class="b">Phone No: <span class="red">*</span></label><input type="text" name="phone" id="phone" class="input required" data-type="phone"/>
						</div>
						<div class="row">
							<label for="subject" class="b">Subject: <span class="red">*</span></label>
							<select name="subject" id="subject" style="width:27%; padding:3px">
								<option value="General Inquiry">General Inquiry</option>
								<option value="I Did Not Receive My Order">I Did Not Receive My Order</option>
								<option value="Suggest A Restaurant">Suggest A Restaurant</option>
								<option value="Issue With Our Website">Issue With Our Website</option>
								<option value="Problem With Your Order">Problem With Your Order</option>
							</select>
						</div>
						<div class="row">
							<label for="message"  class="b">Message <span style="font-family: segoe ui; font-weight: lighter; font-size: 9px">(200 char max)</span> <span class="red">*</span></label>
							<textarea name="message" id="message" class="required" style="width:60%; height: 125px; resize: vertical" data-rangelength= "[5,200]"></textarea>
						</div>
						<div class="row txt-right">
							<input type="submit" value="Submit" name="SUBMIT" class="btn"/>
							<input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
						</div>
					</form>
				</div>
				<?php
					}
				?>
			</div>
		</div>
	</div>
	<div class="footer">
		<?php require('templates/footer.php');?>
	</div>
</body>
</html>
