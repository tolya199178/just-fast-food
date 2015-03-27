<?php
	session_start();

	if(isset($_SESSION['user'])) {
		header('Location:index.php');
		die();
	}
	include("include/functions.php");


	if(isset($_SESSION['access_key']) && isset($_POST['access']) && $_POST['access'] == $_SESSION['access_key']) {

		if(isset($_POST['LOGIN'])) {
			$select = "`type_id`,`type_name`,`type_email`,`type_password`";
			$where = "`type_email` = '".$_POST['staff_email']."' AND `type_password` = '".$_POST['staff_password']."' AND `type_category` = 'takeaway' AND `type_is_delivery` = 'yes' AND `type_status` = 'active'";

			$result = SELECT($select ,$where, 'menu_type', 'array');
			if($result) {
				unset($_SESSION['access_key']);
				$_SESSION['user'] = $result['type_name'].' (takeaway)';
				$_SESSION['userId'] = $result['type_id'];
				$_SESSION['user_type'] = "takeaway";
				//$_SESSION['success'] = "Successfully Login <a href='my-profile.php'>Go To My Profile</a>";
				header('Location:takeaway-profile.php');
				die();
			} else {
				$_SESSION['error'] = "Takeaway Email OR Password Incorrect! OR Takeaway delivery status is 'no'. Contact us";
			}
		}

	}

	$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());

?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="Staff Login, <?= getDataFromTable('setting','meta'); ?>">
	<meta name="keywords" content="Staff Login, <?= getDataFromTable('setting','keywords'); ?>">
	<meta name="author" content="M Awais">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="apple-touch-icon" href="items-pictures/default_rest_img.png">

	<link rel="shortcut icon" href="images/favicon.ico">
	<title>Takeaway Login - Just-FastFood</title>
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
			<div class="login-wrap">
				<div class="box-wrap">
					<form action="" method="post" id="loginForm">
						<div class="row">
							<h2>Takeaway Login <img src="images/lock.png" alt="" /></h2>
							<p>Please enter takeaway email address and password to sign in</p>
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