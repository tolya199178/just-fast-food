<?php
	session_start();
	include("include/functions.php");

	
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="images/favicon.ico">
	<title>What We Do! | Just-FastFood  </title>
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
				<h1 class="subheading">What we do!</h1><hr>
				<h3>INTRODUCTION</h3>
				<p>		We are an online fastfood and takeaway ordering and delivery company. We act as 'middle men' between the customers and the restaurants involved e.g McDonalds, KFC, Nandos etc. Our company is in not affliated with these fast food outlets however we work closely with takeaways outlets such as chinnese, Thai, Indian restaurants etc to ensure your food is delivered in a timely manner. </p> <p>You can now order your favourite fast food and takeway easily by logging in and choosing your menu. We currently accept Credit/Debit card payment and PayPal at the moment. Once payment is confirmed, we give you an estimated delivery time.</p><p> We have a certified Customer Representative to handle all queries regarding your order. Should you want any additional menu/meal, use the 'Chat Online' button at the left handside to chat with a representative. We promise never to dissapoint!<p><h5 class="subheading">Your Food Is On Its Way!</h5></p>		</p>
			</div>
		</div>
	</div>
	<div class="footer">
		<?php require('templates/footer.php');?>
	</div>
</body>
</html>