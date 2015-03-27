<?php
	session_start();
	include("include/functions.php");


?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="images/favicon.ico">
	<title>How it Works | Just-FastFood  </title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />

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

	</style>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/validate.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#loginForm").validate();
		})
	</script>
</head>
<body>
	<div class="header">
		<?php require('templates/header.php');?>
	</div>
	<div class="content">
		<div class="wrapper">
			<div class=" box-wrap" style="margin:20px; ">
				<h1 class="subheading">How it works</h1><hr>
				<h3>This is a quick guide of how to use the website</h3>
				<div style="width:520px; height:335px; margin:0px auto">
					<iframe width="520" height="335" src="http://www.youtube.com/embed/Mh-kpFIJtzY" frameborder="0" allowfullscreen></iframe>
				</div>
			</div>
		</div>
	</div>
	<div class="footer">
		<?php require('templates/footer.php');?>
	</div>
</body>
</html>