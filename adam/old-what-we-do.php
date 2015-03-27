<?php
	session_start();
	include("include/functions.php");


?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="Just Fast Food - McDonalds | KFC | Burger King | Chinese | Subway & other Takeaways Deliveries! Order Online">
	<meta name="keywords" content="What We Do!, <?= getDataFromTable('setting','keywords'); ?>">
	<meta name="author" content="Just-FastFood">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="apple-touch-icon" href="items-pictures/default_rest_img.png">

	<link rel="shortcut icon" href="images/favicon.ico">
	<title>What We Do | Order Online - McDonalds | KFC | Nandos | Burger King etc  </title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />

	<link href="css/iphone.css" rel="stylesheet" type="text/css" media="only screen and (min-width: 0px) and (max-width: 320px)" >
	<link href="css/ipad.css" rel="stylesheet" type="text/css"  media="only screen and (min-width: 321px) and (max-width: 768px)" >

	<style type="text/css">
		.box-wrap{
			font-size:13px;
			font-family: segoe ui, arial, helvetica, sans-serif;
			color: #222;
			background-color:#eee;
			margin:5px;
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
		
		p {
			margin:0 0 .75em 0;
			line-height:1.5em;
		}
		.textAttribute {

		}
		.content {
			width:70%;
			margin: 0 auto;
			padding: 10px;
			background-color: #f8f8f8;
			border: 1px solid #ccc;
		}
        .box-wrap p, h1 {
            font-family: "segoe ui";
            font-weight: lighter;
            font-size: 15px;
        }
        .box-wrap h5 {
            font-family: "segoe ui";
            text-align: center;

        }
	    .subheading h1 {
            font-family: "segoe ui";
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
		<div class="wrapper" ">
			<div class=" box-wrap" style="margin:20px; ">
			  <h1 class="subheading">What We Do!<span class="box-wrap" style="margin:20px"><a href="http://www.just-fastfood.com"><img src="/include/Images/signup.png" width="130" height="35" border="0" /></a></span></h1>
              
			  <hr >
				
				<p>		Just-FastFood creates a platform for online ordering and offers fast food and takeaway deliveries. We work with diverse restaurants to bring tasty meals to your doorstep. We also act as 'middle men' between the customers and restaurants such as McDonalds, KFC, Burger King, Subway etc. Our company is not affliated with these fast food outlets however we work closely with takeaways outlets such as African, Chinese, Thai, Indian restaurants etc to ensure your food is delivered in a timely manner. </p>
                <p>
                In the unlikely event that you are not happy with the food or the delivery service, please contact us and we will resolve the issue with the retailer..
                </p>
                <p>
                We also collect and deliver from any restaurants or takeaway outlets that does not offer delivery service.
                </p>
                <p>You can now order your favourite fast food and takeaway easily by entering your postcode and choosing your choice of restaurant. We currently accept Credit/Debit card payment and PayPal. Once payment is confirmed, we give you an estimated delivery time.</p><p> We have certified Customer Representatives to handle all queries regarding your order. Should you want any additional menu/meal, please use the 'Chat Online' button at the left handside to chat with a representative.
				<p> Just-FastFood prides itself on having several cusines ranging from African (Nigerian & Ghanaian Fried & Jollof rice, Egusi soup, Moi Moi, Plantain, Goat meat, Fried Yam and Egg, Puff Puff, Afang soup, Vegetable soup, Porridge, Moi Moi, Beans and Plantain, Oha soup) to exotic Indian and Chinese food such as Korma, spicy Szechuan chicken and the ever-popular sweet and sour.
				<p> Not to forget your favourite <span class="textAttribute">McDonalds, KFC, Burger King </span> e.t.c right at your doorsteps!
				<p> We're a customer focused company and will address any issue whatsoever within a reasonable time frame. Please contact, support or use the Live Chat to make any complaints or suggestions.

				<p><h5 class="subheading">Your Food Is On Its Way!</h5></p>		</p>
</div>
		</div>
	</div>
    
<div class="footer">
		<?php require('templates/footer.php');?>
	</div>
    
</body>
</html>