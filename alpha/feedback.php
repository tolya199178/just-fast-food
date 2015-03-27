<?php
	session_start();
	include('include/functions.php');

	$ARRAY = array('f_name', 'f_email', 'f_feed', 'f_order');

	if(isset($_SESSION['access_key']) && isset($_POST['access']) && $_POST['access'] == $_SESSION['access_key']) {

		include_once("include/email-send.php");

		if(isset($_POST['FEEDBACK'])){
			$value = "NULL, ";
			foreach($ARRAY as $values) {
				$value .= "'".substr(strip_tags(mysql_real_escape_string($_POST[$values])) , 0 , 500)."', ";
			}
			$value .= " 'pending', ";
			$value .= "NULL";

			$result = INSERT($value ,'feedback' , false ,'');
			if($result) {

				$_SESSION['success'] = "Thank you for your Feedback ..Your Feedback will be posted soon";
				$STRSEND = array(
								'type' => 'new-feedback',
								'email' => admin_email(),
								'user_email' => $_POST['f_email'],
								'name' => $_POST['f_name'],
								'feedback' => substr(strip_tags(mysql_real_escape_string($_POST['f_feed'])) , 0 , 500)
							);
				SENDMAIL($STRSEND , false);
			} else {
				$_SESSION['error'] = "Error!..Feedback Not submit";
			}
		}
	}

	$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="<?= getDataFromTable('setting','meta'); ?>">
	<meta name="keywords" content="<?= getDataFromTable('setting','keywords'); ?>, Send us Feedback">
	<meta name="author" content="M Awais">

	<title>Feedback - Just-FastFood</title>
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="stylesheet" href="css/style.css" />


	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />
	<script type="text/javascript" src="js/jquery.js"></script>

	<script type="text/javascript" src="js/validate.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#fForm").validate();
		});
	</script>

</head>
<body>

	<div class="content">
		<div class=" ">
			<h1 class="heading">Send us Feedback</h1>
			<hr class="hr"/>
			<?php include('include/notification.php');?>
			<div class="explor box-wrap no-padding">
				<div class="by-card b"><a href="javascript:;" class="slideupdown">Send us Feedback</a></div>
				<div class="profile-container" style="display:block;">
					<div class="sign-up-wrap">
						<form action="" method="post" id="fForm">
							<div class="row">
								<p class="small txt-right">Please note: input fields marked with a * are required fields.</p>
								<p class="small txt-right">HTML tag Not Allowed (max charcter 500)</p>
							</div>
							<div class="row">
								<label for="f_name">Your Name<span>*</span></label><input type="text" name="f_name" id="f_name" class="input required" />
							</div>
							<div class="row">
								<label for="f_email">Email<span>*</span></label><input type="text" name="f_email" id="f_email" class="input required email" />
							</div>
							<div class="row">
								<label for="f_feed">Feedback*<span></span></label><textarea name="f_feed" id="" cols="30" rows="10" class="required"></textarea>
							</div>
							<div class="row">
								<label for="f_order">Any Item or Product you want to see on this site?<span></span></label><textarea name="f_order" id="" cols="30" rows="10"></textarea>
							</div>
							<div class="row">
								<input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
							</div>
							<div class="row txt-right">
								<input type="submit" value="Submit" class="btn" name="FEEDBACK"/>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>
