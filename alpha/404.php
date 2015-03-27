<?php
	session_start();
	include("include/functions.php");
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="apple-touch-icon" href="items-pictures/default_rest_img.png">
	<link rel="shortcut icon" href="images/favicon.ico">
	<title>404 - Page not found - just-FastFood</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />

	<link href="css/iphone.css" rel="stylesheet" type="text/css" media="only screen and (min-width: 0px) and (max-width: 320px)" >
	<link href="css/ipad.css" rel="stylesheet" type="text/css"  media="only screen and (min-width: 321px) and (max-width: 768px)" >

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/validate.js"></script>
	<script type="text/javascript" src="js/mobileMenu.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#signupForm").validate();
			$('#main-nav').mobileMenu();
		});
	</script>

</head>
<body>
	<div class="header">
		<?php require('templates/header.php');?>
	</div>
	<div class="content">
		<div class="wrapper ">
			<?php include('include/notification.php');?>
			<div class="login-page">
				<div class="box-wrap" style="min-height: 500px;">
					<div class="logo">
						<h1 style="padding-top:15px;" class="txt-center">404 Page Not Found!</h1>
					</div>
					<hr class="hr"/>
					<h3 style="font-size: 18px; padding-bottom: 70px;">We couldn't find the page you requested. </h3>
					<p>If you feel something is missing that should be here, <a href="contact-us.php" class="i u">contact us</a>.</p>
					<hr class="hr"/>
				</div>
			</div>
			<div class="clr"></div>
		</div>
	</div>
	<div class="footer">
		<?php require('templates/footer.php');?>
	</div>
</body>
</html>