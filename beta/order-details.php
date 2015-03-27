<?php
	session_start();
	include("include/functions.php");

	if(!isset($_SESSION['CURRENT_POSTCODE']) || !isset($_SESSION['CURRENT_MENU'])) {
		header('Location:index.php');
		die();
	}

	if($_SESSION['CART_SUBTOTAL'] < $_SESSION['type_min_order']) {
		$_SESSION['error'] = "Minimum Order Amount Should Be &pound;".$_SESSION['type_min_order'];
		header('Location:'.$_SESSION['CURRENT_MENU']);
		die();
	}

	$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());

	$ARRAY = array('user_name', 'user_password', 'user_email', 'user_phoneno', 'user_address', 'user_address_1', 'user_city', 'user_dob', 'user_hear', 'user_status');

	foreach($ARRAY as $v) {
		$ARRAYTEMP[$v] = '';
	}

	$user = false;
	if(isset($_SESSION['user'])) {
		$select = "*";
		$where = "`id` = '".$_SESSION['userId']."'";

		$result = SELECT($select ,$where, 'user', 'array');
		foreach($ARRAY as $v) {
			$ARRAYTEMP[$v] = $result[$v];
		}
		$user = true;
	} else if(isset($_SESSION['PAY_POST_VALUE'])) {
		foreach($ARRAY as $v) {
			$ARRAYTEMP[$v] = $_SESSION['PAY_POST_VALUE'][$v];
		}
	}


?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="images/favicon.ico">
	<title>Order Details</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/fancybox/jquery.fancybox.css" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/validate.js"></script>
	<script type="text/javascript" src="css/fancybox/jquery.fancybox.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#loginForm").validate();
			$("#signupForm").validate({
				rules:{
					cuser_password:{
						 equalTo: "#user_password"
					 },
				},
				errorPlacement: function ($error, $element) {
					if ($element.attr("name") == "accept") {
						$error.insertAfter($element.next());
					} else {
						$error.insertAfter($element);
					}
				}
			});
			$(".pop_box").fancybox();
			
			$('.small .why-signup').hover(function() {
				$('.why-signup-text').show();
			}, function(){
				$('.why-signup-text').hide();
			});
		});
	</script>
	<style type="text/css">
		.why-signup-text{
			position:absolute;
			top:18px;
			left:0px;
			background:#fff;
			padding:5px;
			display:none;
			border:1px solid #ddd;
			border-radius:3px;
			-moz-border-radius:3px;
			-webkit-border-radius:3px;
			
			-webkit-box-shadow: rgba(0, 0, 0, 0.5) 0 1px 3px 0;
			-moz-box-shadow: rgba(0, 0, 0, 0.5) 0 1px 3px 0;
			box-shadow: rgba(0, 0, 0, 0.5) 0 1px 3px 0;
		}
	</style>
</head>
<body>
	<div class="header">
		<?php require('templates/header.php');?>
	</div>
	<div class="content">
		<div class="wrapper ">
			<div class="breadcrum">
				<ul>
					<li><a href="index.php">Begin Search</a></li>
					<li><a href="Postcode-<?php echo str_replace(' ','-',$_SESSION['CURRENT_POSTCODE']); ?>">Postcode-<?php echo $_SESSION['CURRENT_POSTCODE']; ?></a></li>
					<li><a href="<?php echo $_SESSION['CURRENT_MENU']?>" class="u b">Add More</a></li>
				</ul>
			</div>
			<?php include('include/notification.php');?>
			<div class="fl-left login-wrap">
				<div class="box-wrap">
					<div class="order-details-wrap">
						<h4 class="title red txt-center">Your Order</h4>
						<hr class="hr" />
						<div class="order">
							<div class="order-cart-wrapper"></div>
						</div>
					</div>
				</div>
				<?php
					if(!isset($_SESSION['user'])) {
				?>
				<div class="cbox-wrap margin-top">
					<form action="login.php" method="post" id="loginForm">
						<div class="row">
							<h2>Login <img src="images/lock.png" alt="" /></h2>
							<p>Please enter your email address and password to sign in</p>
						</div>
						<div class="row">
							<label for="user_email0" class="b">Email Address</label><input type="text" name="user_email" id="user_email0" class="input required email"/>
						</div>
						<div class="row">
							<label for="user_password1"  class="b">Password</label><input type="password" name="user_password" id="user_password1" class="input required"/>
						</div>
						<div class="row txt-right">
							<input type="submit" value="Login" name="LOGIN" class="btn"/>
							<input type="hidden" name="backURL" value="order-details.php"/>
							<input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
						</div>
						<div class="row can-not">
							<a href="">Can't access your account</a>

						</div>

					</form>
				</div>
				<?php } ?>
			</div>
			<div class="fl-left sign-up-wrap" style="">
				<div class="box-wrap">
					<form action="pay.php" method="post" id="signupForm">
						
						<?php
							if(!$user) {
						?>
						<div class="row">
							<div class="red-wrap"><h2>No account?</h2></div>
							<p>Don't worry you can create one now before anyone notices</p>
							<p class="small txt-right" style="color:#D62725">Please note: input fields marked with a * are required fields.</p>
							<p class="small" style="position: relative;"><a href="javascript:;" class="why-signup"><span class="b red">Why Signup?</span></a><span class="why-signup-text">Get local offers by email every week, re-order saved meals in a few clicks, store your delivery address and build a list of your favourite local takeaways.</span></p>
						</div>
						<div class="row">
							<label for="user_email">Email Address<span>*</span></label><input type="text" name="user_email" id="user_email" class="input required email" value="<?php echo $ARRAYTEMP['user_email'];?>"/>
						</div>
						<div class="row">
							<label for="user_password">Password<span>*</span></label><input type="password" name="user_password" id="user_password" class="input required" />
						</div>
						<div class="row">
							<label for="cuser_password">Confirm Password<span>*</span></label><input type="password" name="cuser_password" id="cuser_password" class="input required"/>
							<input type="hidden" name="first_time" value="true"/>
						</div>
						<?php } else {?>
						<div class="row">
							<div class="red-wrap"><h2>Confirm?</h2></div>
							<p class="small txt-right" style="color:#D62725">Please note: input fields marked with a * are required fields.</p>
						</div>
						
						<?php
							}

						?>
						
						<div class="row">
							<label for="user_name">Full Name<span>*</span></label><input type="text" name="user_name" id="user_name" class="input required" value="<?php echo $ARRAYTEMP['user_name'];?>"/>
						</div>
						<div class="row">
							<label for="user_phone">Phone No<span>*</span></label><input type="text" name="user_phoneno" id="user_phoneno" class="input required" value="<?php echo $ARRAYTEMP['user_phoneno'];?>"/>
						</div>
						<!--<hr class="hr"/>
						<p class="small txt-center">Delivery address:</p>--> 
						<div class="row">
							<label for="user_address">Address<span>*</span></label><input type="text" name="user_address" id="user_address" class="input required" value="<?php echo $ARRAYTEMP['user_address'];?>"/>
						</div>
						<div class="row">
							<label for="user_address_1">Address 1</label><input type="text" name="user_address_1" id="user_address_1" class="input" value="<?php echo $ARRAYTEMP['user_address_1'];?>"/>
						</div>
						<div class="row">
							<label for="user_city">City<span>*</span></label><input type="text" name="user_city" id="user_city" class="input required" value="<?php echo $ARRAYTEMP['user_city'];?>"/>
						</div>
						<div class="row">
							<label for="user_postcode">Post Code</label><?php echo $_SESSION['CURRENT_POSTCODE'];?>
						</div>
						<br/>
						<div class="row additional">
							<p>
								<span class="b red">Leave a note for the restaurant</span><br/> If you have any allergies or dietary requirements please specify this in the comments box. Also use the comments box if you want to leave a note about delivery for the delivery driver.
							</p>
							<textarea name="order_note" id="order_note" cols="49" rows="3" style="width:97%"></textarea>
						</div>
						<div class="row">
							<input type="hidden" name="user_dob" value=""/>
							<input type="hidden" name="user_status" value="active"/>
							<input type="hidden" name="user_hear" value=""/>
							<input type="hidden" name="order_notes" id="order_notes" value=""/>
							<input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
						</div>
						<div class="row">
							<input type="checkbox" name="accept" id="" class="required"/>
							<p class="" style="display:inline">I accept the <a href="terms.php" class="u pop_box red">terms and conditions</a> &amp; <a href="privacy.php" class="u pop_box red">privacy policy</a></p>
						</div>
						<div class="row txt-right">
							<input type="submit" value="Proceed" class="btn" name="PROCEED"/>
						</div>
					</form>
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