<?php
	session_start();
	include('include/functions.php');

	
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>MackyDee's</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/ticker-style.css" />
	

	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />
	
	

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.cycle.all.min.js"></script>
	<script type="text/javascript" src="js/validate.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	
	<script type="text/javascript" src="js/jquery.ticker.js"></script>
	



	<script type="text/javascript">

		$(document).ready(function(){

			$("#order-search").validate({
				submitHandler: function(form) {
					var val = document.post.ukpostcode.value;
					val = val.replace(' ','-');
					window.location.href = 'Postcode-'+val;
					return false;
				},
				rules: {
				 ukpostcode	: "required"
			   },
				messages: {
				 ukpostcode: "UK Post code Not Valid",
				},
				errorPlacement: function ($error, $element) {
					if ($element.attr("name") == "ukpostcode") {
						$error.insertAfter($element.next().next());
					} else {
						$error.insertAfter($element);
					}
				}
			});

			 $('.slider').cycle({
				fx:     'fade',
				speed:  1500,
				timeout: 4000,
				pause:  1
			});

			 $('#marquee').ticker({
				titleText : 'Latest Updates :'
			 });

		});


	</script>
	
	<!--[if IE 8]>
	<style type="text/css">
		.box-radius{
			behavior: url(ie-css3.htc);
		}
	</style>
	<![endif]-->
</head>
<body class="home">
	<div class="header">
		<?php require('templates/header.php');?>
	</div>
	<div class="content">
		<div class="wrapper" style="margin-top: -10px;">
			<div class="latest-news-moeque">
				<ul id="marquee">
					<li>This site will complete soon!!!</li>
					<li>We enjoyed working on this site ....</li>
					<li>Now payment integration on the way ...</li>
					<li>Live Chat Session Will Start Soon ....</li>
					<li>Hope You Satisfied With This Site..?</li>
					<li>We are waiting for your feedback?</li>
				</ul>
			</div>
			<div class="clr"></div>
			<div class="slider-wrapper">
				<div class="slider fl-left" id="banner">
					<?php
						$query = "SELECT `slider_picture` FROM `slider` WHERE `slider_type` = 'left' AND `slider_status` = 'active'";
						$valueOBJ = $obj->query_db($query) or die(mysql_error());;
						while($res = $obj->fetch_db_array($valueOBJ)) {
					?>
						<img src="items-pictures/<?php echo $res['slider_picture']?>" alt="<?php echo $res['slider_picture']?>" class=""/>
					<?php
						}
					?>
				</div>
				<div class="slider fl-left" id="banner">
					<?php
						$query = "SELECT `slider_picture` FROM `slider` WHERE `slider_type` = 'right' AND `slider_status` = 'active'";
						$valueOBJ = $obj->query_db($query) or die(mysql_error());;
						while($res = $obj->fetch_db_array($valueOBJ)) {
					?>
						<img src="items-pictures/<?php echo $res['slider_picture']?>" alt="<?php echo $res['slider_picture']?>" class=""/>
					<?php
						}
					?>
				</div>
				<div class="clr"></div>
				<div class="order-wrap ">
				<div class="macky">

				<form action="" method="post" id="order-search" name="post">
					<label for="postcode">Your Post Code:</label>
					<input type="text" name="ukpostcode" id="postcode" class="text required postcode" placeholder="UK Post Code"/>
					<input type="submit" value="Go" name="submit" class="btn"/>
				</form>
				</div>
				</div>
				<hr class="hr"/>
			</div>
			
			<!--<div class=" order-wrap">
				<h1 class="heading">Enter Your Delivery Post Code</h1>
				<div class="macky">
					<form action="" method="post" id="order-search">
						<label for="postcode">Your Post Code:</label>
						<input type="text" name="ukpostcode" id="postcode" class="text required postcode" placeholder="UK Post Code"/>
						<!--<select name="type" id="" class="select">
							<?php
								$query = "SELECT `type_id`,`type_name` FROM `menu_type` WHERE `type_status` = 'active'";
								$valueOBJ = $obj->query_db($query);
								while($res = $obj->fetch_db_array($valueOBJ)) {
							?>
								<option value="menu-<?php echo str_replace(' ', '-' ,$res['type_name']).'-'.$res['type_id']?>"><?php echo $res['type_name']?></option>
							<?php
								}
								echo mysql_error();
							?>
						</select>
						<input type="submit" value="Order Now" name="submit" class="btn"/>
					</form>
				</div>
			</div> -->

			<div class="recommend" style="display:none">
				<div class="wrap">
					<h1 class="title">Why not try</h1>
					<div class="fl-left column">
						<ul>
							<li>
								<div class="img fl-left">
									<a href=""><img src="images/s-mcdonalds-McCafe-Mocha-Small.png" alt="mcdonalds-Angus-Bacon-Cheese" /></a>
								</div>
								<div class="fl-left middleTest">
									<h3 class="heading"><a href="">MackyDee's Angus Bacon Cheese</a></h3>
									<div class="small">MackyDee's Burger</div>
									<div class="rating">
										<div class="r-5_5"></div>
									</div>
								</div>
								<div class="fl-left">
									<h4 class="imgText">Highly Rated</h4>
								</div>
								<div class="clr"></div>
							</li>
							<li>
								<div class="img fl-left">
									<a href=""><img src="images/s-mcdonalds-McCafe-Mocha-Small.png" alt="mcdonalds-Angus-Bacon-Cheese" /></a>
								</div>
								<div class="fl-left middleTest">
									<h3 class="heading"><a href="">MackyDee's Angus Bacon Cheese</a></h3>
									<div class="small">MackyDee's Burger</div>
									<div class="rating">
										<div class="r-5_5"></div>
									</div>
								</div>
								<div class="fl-left">
									<h4 class="imgText">Highly Rated</h4>
								</div>
								<div class="clr"></div>
							</li>
							<li>
								<div class="img fl-left">
									<a href=""><img src="images/s-mcdonalds-McCafe-Mocha-Small.png" alt="mcdonalds-Angus-Bacon-Cheese" /></a>
								</div>
								<div class="fl-left middleTest">
									<h3 class="heading"><a href="">MackyDee's Angus Bacon Cheese</a></h3>
									<div class="small">MackyDee's Burger</div>
									<div class="rating">
										<div class="r-5_5"></div>
									</div>
								</div>
								<div class="fl-left">
									<h4 class="imgText">Highly Rated</h4>
								</div>
								<div class="clr"></div>
							</li>
						</ul>
					</div>
					<div class="fl-left column">
						<ul>
							<li>
								<div class="img fl-left">
									<a href=""><img src="images/s-mcdonalds-McCafe-Mocha-Small.png" alt="mcdonalds-Angus-Bacon-Cheese" /></a>
								</div>
								<div class="fl-left middleTest">
									<h3 class="heading"><a href="">MackyDee's Angus Bacon Cheese</a></h3>
									<div class="small">MackyDee's Burger</div>
									<div class="rating">
										<div class="r-5_5"></div>
									</div>
								</div>
								<div class="fl-left">
									<h4 class="imgText">Highly Rated</h4>
								</div>
								<div class="clr"></div>
							</li>
							<li>
								<div class="img fl-left">
									<a href=""><img src="images/s-mcdonalds-McCafe-Mocha-Small.png" alt="mcdonalds-Angus-Bacon-Cheese" /></a>
								</div>
								<div class="fl-left middleTest">
									<h3 class="heading"><a href="">MackyDee's Angus Bacon Cheese</a></h3>
									<div class="small">MackyDee's Burger</div>
									<div class="rating">
										<div class="r-5_5"></div>
									</div>
								</div>
								<div class="fl-left">
									<h4 class="imgText">Highly Rated</h4>
								</div>
								<div class="clr"></div>
							</li>
							<li>
								<div class="img fl-left">
									<a href=""><img src="images/s-mcdonalds-McCafe-Mocha-Small.png" alt="mcdonalds-Angus-Bacon-Cheese" /></a>
								</div>
								<div class="fl-left middleTest">
									<h3 class="heading"><a href="">MackyDee's Angus Bacon Cheese</a></h3>
									<div class="small">MackyDee's Burger</div>
									<div class="rating">
										<div class="r-5_5"></div>
									</div>
								</div>
								<div class="fl-left">
									<h4 class="imgText">Highly Rated</h4>
								</div>
								<div class="clr"></div>
							</li>
						</ul>
					</div>
					<div class="clr"></div>
				</div>
				<div class="more"><a href="" class="b">See More MackyDee's</a></div>
			</div>

			<div class="how-works">
				<h1 class="title">How It Works</h1>
				<hr class="hr"/>
				<img src="images/icon_promo1.png" alt="" />
				<img src="images/icon_promo2.png" alt="" />
				<img src="images/icon_promo3.png" alt="" />
			</div>
		</div>
	</div>
	<div class="footer">
		<?php require('templates/footer.php');?>
	</div>
</body>
</html>