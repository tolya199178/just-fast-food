<?php
	session_start();
	if(isset($_SESSION['user'])) {
		header('Location:index.php');
		die();
	}
	include("include/functions.php");

	$ARRAY = array('user_name','user_screen_name', 'user_password', 'user_email', 'user_phoneno', 'user_address', 'user_address_1', 'user_city', 'user_post_code', 'user_dob', 'user_hear', 'user_status');

	foreach($ARRAY as $v) {
		$ARRAYTEMP[$v] = '';
	}

	if(isset($_SESSION['access_key']) && isset($_POST['access']) && $_POST['access'] == $_SESSION['access_key']) {

		if(isset($_POST['SIGNUP'])) {

			$json_post = getEandN($_POST['user_post_code']);
			if($json_post) {

				include_once('include/email-send.php');

				$value = "NULL, ";
				foreach($ARRAY as $values) {
					if($values == "user_password") {
						$value .= "'".md5(mysql_real_escape_string($_POST[$values]))."', ";
					} else {
						$value .= "'".mysql_real_escape_string($_POST[$values])."', ";
					}
				}
				$value .= "NULL";
				$extra = "`user_email` = '".$_POST['user_email']."'";
				$result = INSERT($value ,'user' ,'unique' ,$extra);
				
				setC('user',$_POST['user_name']);
				
				if($result) {

					$STRSEND = array(
									'type' => 'new-user-reg',
									'email' => admin_email(),
									'user_email' => $_POST['f_email'],
									'user_postcode' => $_POST['user_post_code'],
								);
					SENDMAIL($STRSEND , false);

					$_SESSION['success'] = "Successfully Created.Please Login To Continue";
					unset($_SESSION['access_key']);
				} else {
					foreach($ARRAY as $v) {
						$ARRAYTEMP[$v] = $_POST[$v];
					}

					$_SESSION['error'] = "Email Address Already Exist!";
				}
			} else {
				foreach($ARRAY as $v) {
					$ARRAYTEMP[$v] = $_POST[$v];
				}

				$_SESSION['error']  = "ERROR!! Invalid Post Code. <span style='font-size:13px'>( Please enter only full UK postode)</span>";
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
	<title>MackyDee's</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/fancybox/jquery.fancybox.css" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/validate.js"></script>
	<script type="text/javascript" src="css/fancybox/jquery.fancybox.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#signupForm").validate({
				rules:{
					cuser_password:{
						 equalTo: "#user_password",
					 }
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
		});
	</script>
</head>
<body>
	<div class="content">
		<div class=" ">
			<?php include('include/notification.php');?>
			<div class="fl-left login-wrap">

			</div>
			<div class="fl-left sign-up-wrap" style="width:100%;">
				<div class="box-wrap">
					<form action="" method="post" id="signupForm">
						<div class="row">
							<h2>Signup</h2>
							<p class="small txt-right">Please note: input fields marked with a * are required fields.</p>
						</div>
						<div class="row">
							<label for="user_email">Email Address<span>*</span></label><input type="text" name="user_email" id="user_email" class="input required email" value="<?php echo $ARRAYTEMP['user_email'];?>"/>
						</div>
						<div class="row">
							<label for="user_screen_name">Screen Name</label><input type="text" name="user_screen_name" id="user_screen_name" class="input" value="<?php echo $ARRAYTEMP['user_screen_name'];?>"/>
						</div>
						<div class="row">
							<label for="user_password">Password<span>*</span></label><input type="password" name="user_password" id="user_password" class="input required" />
						</div>
						<div class="row">
							<label for="cuser_password">Confirm Password<span>*</span></label><input type="password" name="cuser_password" id="cuser_password" class="input required"/>
						</div>
						<div class="row">
							<label for="user_name">Full Name<span>*</span></label><input type="text" name="user_name" id="user_name" class="input required" value="<?php echo $ARRAYTEMP['user_name'];?>"/>
						</div>
						<div class="row">
							<label for="user_phone">Phone No<span>*</span></label><input type="text" name="user_phoneno" id="user_phoneno" class="input required" value="<?php echo $ARRAYTEMP['user_phoneno'];?>"/>
						</div>

						<p class="small txt-right">Delivery address:</p>
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
							<label for="user_postcode">Post Code<span>*</span></label><input type="text" name="user_post_code" id="user_postcode" class="input required postcode" value="<?php echo $ARRAYTEMP['user_post_code'];?>"/>
						</div>
						<div class="row">
							<input type="hidden" name="user_dob" value=""/>
							<input type="hidden" name="user_status" value="active"/>
							<input type="hidden" name="user_hear" value=""/>
							<input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
						</div>
						<div class="row">
							<input type="checkbox" name="accept" id="" class="required"/>
							<p class="" style="display:inline">I accept the <a href="terms.php" class="u pop_box">terms and conditions</a> &amp; <a href="privacy.php" class="u pop_box">privacy policy</a></p>
						</div>
						<div class="row txt-right">
							<input type="submit" value="Create Account" class="btn" name="SIGNUP"/>
						</div>
					</form>
				</div>
			</div>
			<div class="clr"></div>
		</div>
	</div>
</body>
</html>