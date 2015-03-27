<?php
	session_start();
	if(isset($_SESSION['user'])) {
		header('Location:index.php');
		die();
	}
	include("include/functions.php");

	$ARRAY = array('user_name', 'user_password', 'user_email', 'user_phoneno', 'user_address', 'user_address_1', 'user_city', 'user_post_code', 'user_dob', 'user_hear', 'user_status');

	foreach($ARRAY as $v) {
		$ARRAYTEMP[$v] = '';
	}

	if(isset($_SESSION['access_key']) && isset($_POST['access']) && $_POST['access'] == $_SESSION['access_key']) {

		if(isset($_POST['LOGIN'])) {
			$select = "`id`,`user_email`,`user_password`,`user_name`";
			$where = "`user_email` = '".$_POST['user_email']."' AND `user_password` = '".md5($_POST['user_password'])."' AND `user_status` = 'active'";

			$result = SELECT($select ,$where, 'user', 'array');
			if($result) {
				unset($_SESSION['access_key']);
				$_SESSION['user'] = $result['user_name'];
				setC('user' ,$_SESSION['user']);
				$_SESSION['userId'] = $result['id'];
			//	$_SESSION['success'] = "Successfully Login <a href='my-profile.php'>Go To My Profile</a>";
				header('Location:'.$_POST['backURL']);
				die();
			} else {
				$_SESSION['error'] = "Email OR Password Incorrect. Please try again";
			}


		}

	}

	$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());

?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="Login - Create your Free Account, <?= getDataFromTable('setting','meta'); ?>">
	<meta name="keywords" content="<?= getDataFromTable('setting','keywords'); ?>, Login, Create Free Account">
	<meta name="author" content="M Awais">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="apple-touch-icon" href="items-pictures/default_rest_img.png">

	<link rel="shortcut icon" href="images/favicon.ico">
	<title>Just-FastFood - Login - Account Creation</title>
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
			$("#loginForm").validate();
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
				<div class="box-wrap">
					<form action="" method="post" id="loginForm" class="login-wrap fl-left">
						<div class="row" style="font-family: rockwellregular; font-size: 14px">
							<h2>Login <img src="images/lock.png" alt="" /></h2>
							<p>Please enter your email address and password to sign in</p>
						</div>
						<div class="row" style="font-family: rockwellregular; font-size: 14px">
							<label for="user_email0" class="b">Email Address</label><input type="text" name="user_email" id="user_email0" class="input required email"  value="<?php echo $ARRAYTEMP['user_email'];?>"/>
						</div>
						<div class="row" style="font-family: rockwellregular; font-size: 14px">
							<label for="user_password"  class="b">Password</label><input type="password" name="user_password" id="user_password0" class="input required"/>
						</div>
						<div class="row txt-right">
                         <a href="facebook-connect.php" class="facebook-login"><img src="/images/fbimg.png" width="140" height="25" border="0" alt="Test" title="Login With Facebook" style="image-rendering: optimize-contrast; padding: 9px 10px 9px 8px; position: relative; background-color: #fff">
							<input type="submit" value="Login" name="LOGIN" class="btn"/>

                                <input type="hidden" name="backURL" value="<?php if(isset($_SERVER['HTTP_REFERER'])) { echo htmlspecialchars($_SERVER['HTTP_REFERER']); } else { echo 'index.php';}?>"/>
							<input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
						</div>
						<div class="row can-not">

                                <a href="forgot-password.php?iframe=true&amp;width=600&amp;height=400" rel="prettyPhoto">Can't access your account</a>
						</div>

					</form>
					<div class="fl-left info-signup">
						<div class="row">
							<h2>No account?</h2>
							<p>Don't worry you can create one now before anyone notices</p>
						</div>
						<div class="row">
							<a href="signup.php?iframe=true&amp;width=600&amp;height=550" rel="prettyPhoto"><button class="btn">Create Account</button></a>
						</div>
						<div class="row why-signup">
							<h4>Why sign up?</h4>
							<ul>
								<li>Get exclusive discounts and offers by email</li>
								<li>Save and re-order your favourite meals</li>
								<li>Store your delivery addresses for quick and easy checkout</li>
							</ul>
						</div>
					</div>
					<div class="clr"></div>
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