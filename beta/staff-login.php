<?php
	session_start();
	
	if(isset($_SESSION['user'])) {
		header('Location:index.php');
		die();
	}
	include("include/functions.php");


	if(isset($_SESSION['access_key']) && isset($_POST['access']) && $_POST['access'] == $_SESSION['access_key']) {

		if(isset($_POST['LOGIN'])) {
			$select = "`staff_id`,`staff_email`,`staff_password`,`staff_name`";
			$where = "`staff_email` = '".$_POST['staff_email']."' AND `staff_password` = '".md5($_POST['staff_password'])."' AND `staff_status` = 'active'";

			$result = SELECT($select ,$where, 'staff', 'array');
			if($result) {
				unset($_SESSION['access_key']);
				$_SESSION['user'] = $result['staff_name'].' (staff)';
				$_SESSION['userId'] = $result['staff_id'];
				$_SESSION['user_type'] = "staff";
				//$_SESSION['success'] = "Successfully Login <a href='my-profile.php'>Go To My Profile</a>";
				header('Location:staff-profile.php');
				die();
			} else {
				$_SESSION['error'] = "Staff User Email OR Password Incorrect!";
			}
		}

	}

	$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());

?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">	<link rel="shortcut icon" href="images/favicon.ico">
	<title>MackyDee's</title>
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
			<div class="login-wrap">
				<div class="box-wrap">
					<form action="" method="post" id="loginForm">
						<div class="row">
							<h2>Login <img src="images/lock.png" alt="" /></h2>
							<p>Please enter your email address and password to sign in</p>
						</div>
						<div class="row">
							<label for="staff_email" class="b">Email Address</label><input type="text" name="staff_email" id="staff_email" class="input required email"/>
						</div>
						<div class="row">
							<label for="staff_password"  class="b">Password</label><input type="password" name="staff_password" id="staff_password" class="input required"/>
						</div>
						<div class="row txt-right">
							<input type="submit" value="Login" name="LOGIN" class="btn"/>
							<input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
						</div>
						<div class="row can-not">
							<a href="staff-forgot-password.php">Can't access your account</a>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="footer">
		<?php require('templates/footer.php');?>
	</div>
</body>
</html>