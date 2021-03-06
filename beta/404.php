<?php
	session_start();
	include("include/functions.php");
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="images/favicon.ico">
	<title>404 - Page not found - just-FastFood</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/script.js"></script>

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