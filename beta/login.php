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
				//$_SESSION['success'] = "Successfully Login <a href='my-profile.php'>Go To My Profile</a>";
				header('Location:'.$_POST['backURL']);
				die();
			} else {
				$_SESSION['error'] = "User Email OR Password Incorrect!";
			}


		}

	}

	$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());

?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="images/favicon.ico">
	<title>Just-FastFood | Login - Create Account</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/validate.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#loginForm").validate();
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
						<div class="row">
							<h2>Login <img src="images/lock.png" alt="" /></h2>
							<p>Please enter your email address and password to sign in</p>
						</div>
						<div class="row">
							<label for="user_email0" class="b">Email Address</label><input type="text" name="user_email" id="user_email0" class="input required email"  value="<?php echo $ARRAYTEMP['user_email'];?>"/>
						</div>
						<div class="row">
							<label for="user_password"  class="b">Password</label><input type="password" name="user_password" id="user_password0" class="input required"/>
						</div>
						<div class="row txt-right">
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