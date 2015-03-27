<?php
	session_start();	
	include("include/functions.php");
	
	$vcode_true = "false";
	$ERROR = false;
	if(isset($_GET['vcode']) && $_GET['vcode'] != "") {
		$vcode = $_GET['vcode'];
		$value1 = $obj  -> query_db ("SELECT `email` FROM `forgot_pass` WHERE `vcode` = '".$vcode."'  AND `type` = 'staff'") or die(mysql_error());
		if($obj -> num_rows($value1) > 0) {
			$vcodeObj = $obj -> fetch_db_assoc($value1);
			$email = $vcodeObj['email'];
			$vcode_true = "true";
			$_SESSION['vcode'] = $vcode;
		} else {
			$_SESSION['error'] = "Error!!. Verification Code Not Valid!";
			$ERROR = true;
		}
	}

	if(isset($_SESSION['access_key']) && isset($_POST['access']) && $_POST['access'] == $_SESSION['access_key']) {
		
		include_once("include/email-send.php");
		
		if(isset($_POST['FORGOT'])) {
			$value = $obj  -> query_db ("SELECT `staff_email` FROM `staff` WHERE `staff_email` = '".$_POST['user_email']."'") or die(mysql_error());
			if($obj -> num_rows($value) > 0) {
				$value1 = $obj  -> query_db ("SELECT `vcode` FROM `forgot_pass` WHERE `email` = '".$_POST['user_email']."' AND `type` = 'staff'") or die(mysql_error());
				if($obj -> num_rows($value1) > 0) {
					$vcodeObj = $obj -> fetch_db_assoc($value1);
					$vcode = $vcodeObj['vcode'];
				} else {
					$vcode = rand().md5($_POST['user_email']).rand();
					$value = "NULL, ";
					$value .= "'".$vcode."', ";
					$value .= "'".$_POST['user_email']."', ";
					$value .= "'staff', ";
					$value .= "NULL";
					$result = INSERT($value ,'forgot_pass' ,false , '');
				}
				
				$_SESSION['success'] = "Password Link sent to your email address";
				$STRSEND = array(
								'type' => 'upt-pass',
								'email' => $_POST['user_email'],
								'vcode' => $vcode,
								'link' => 'staff-forgot-password'
							);
				SENDMAIL($STRSEND , false);
			} else {
				$_SESSION['error'] = "Error!!. Staff Email Not Exist!";
			}
		}
		
		else if(isset($_POST['UPDATE']) && $_SESSION['vcode'] == $_POST['vcode']){
			$value1 = $obj  -> query_db ("UPDATE `staff` SET `staff_password` = '".md5($_POST['user_password'])."' WHERE `staff_email` = '".$_POST['email']."'");
			$value1 = $obj  -> query_db ("DELETE FROM `forgot_pass` WHERE `vcode` = '".$_POST['vcode']."' AND `type` = 'staff'");
			$_SESSION['success'] = "Password Updated.. Please Login To Continue";
			unset($_SESSION['vcode']);
			header('location:staff-login.php');
			die();
			$ERROR = true;
		}

	}

	$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());

?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">	<link rel="shortcut icon" href="images/favicon.ico">
	<title>Just-FastFood | Forgot Password</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/validate.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#loginForm").validate();
			$("#signupForm").validate({
				rules:{
					cuser_password:{
						 equalTo: "#user_password",
					 }
				}
			});
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
			<?php if(!$ERROR) {	?>
			
			<?php if($vcode_true == 'true') {	?>
			<div class="box-wrap ">
				<form action="staff-forgot-password.php" method="post" id="signupForm" class="login-wrap" style="width:71%">
					<div class="row">
						<h2>Update Your Password(staff)</h2>
					</div>
					<div class="row">
						<label for="user_email0" class="b">Email Address</label><?php echo $email; ?>
					</div>
					<div class="row">
						<label for="user_password">New Password<span>*</span></label><input type="password" name="user_password" id="user_password" class="input required" />
					</div>
					<div class="row">
						<label for="cuser_password">Confirm Password<span>*</span></label><input type="password" name="cuser_password" id="cuser_password" class="input required"/>
					</div>
					<div class="row txt-right">
						<input type="submit" value="Submit" name="UPDATE" class="btn"/>
						<input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
						<input type="hidden" name="vcode" value="<?php echo $vcode;?>"/>
						<input type="hidden" name="email" value="<?php echo $email;?>"/>
					</div>
				</form>
			</div>
			<?php } else { ?>
			<div class="box-wrap ">
				<form action="" method="post" id="loginForm" class="login-wrap" style="width:71%">
					<div class="row">
						<h2>Forgot Password (staff)</h2>
						<p>Password update link will send to you your email address</p>
					</div>
					<div class="row">
						<label for="user_email0" class="b">Email Address</label><input type="text" name="user_email" id="user_email0" class="input required email"  value=""/>
					</div>
					<div class="row txt-right">
						<input type="submit" value="Submit" name="FORGOT" class="btn"/>
						<input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
					</div>
				</form>
			</div>
			<?php } } ?>
		</div>
	</div>
	<div class="footer">
		<?php require('templates/footer.php');?>
	</div>
</body>
</html>