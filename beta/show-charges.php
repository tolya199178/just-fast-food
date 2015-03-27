<?php
	session_start();
	include('include/functions.php');
	
	if(!isset($_GET['go']) || !isset($_GET['c']) || !isset($_GET['id']) || !isset($_GET['for'])){
		header('Location:index.php');
		die();
	} else {
		unset($_SESSION['CART']);
		//getDistTwoPost();
		$_SESSION['DELIVERY_CHARGES'] = $_GET['c'];
		$_SESSION['DELIVERY_REST_ID'] = $_GET['id'];
		$_SESSION['OPH_FOR'] = $_GET['for'];
		
		header('Location:'.$_GET['go']);
		die();
	}
	
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Just-FastFood | Delivery Charges</title>
	<link rel="stylesheet" href="css/style.css" />


	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />
	<script type="text/javascript" src="js/jquery.js"></script>

	<script type="text/javascript" src="js/validate.js"></script>
	<script type="text/javascript" src="js/script.js"></script>

</head>
<body>
	<div class="header">
		<?php require('templates/header.php');?>
	</div>
	<div class="content">
		<div class="wrapper ">
			<h1 class="heading">Small Delivery Charges</h1>
			<hr class="hr"/>
			<?php include('include/notification.php');?>
			<div class="explor box-wrap no-padding">
				<div class="by-card b"><a href="javascript:;" class="slideupdown">Continue to your Fast Food and Takeaways</a></div>
				<div class="profile-container" style="display:block;">
					<div class="sign-up-wrap">
						<form action="<?php echo $_GET['go']?>" method="post" id="fForm">
							<div class="row">
								<?php
									if($_SESSION['DELIVERY_CHARGES'] == '0') {
										echo '<h2>FREE SHIPPING!!!<br> TO POST CODE : '.$_SESSION['CURRENT_POSTCODE'].'</h2>';
									} else {
								?>
									Nearer Restaurant Distence From Your Postcode <strong><?php echo $_SESSION['CURRENT_POSTCODE']; ?></strong> approx : <strong><?php echo $_SESSION['DELIVERY_CHARGES'];?>KM</strong><br><br>
									Our 1KM distence delivery charges is &pound;<?php echo delivery_charges(); ?><br/><br/>
									Your Delivery Charges : <strong>&pound; <?php echo round($_SESSION['DELIVERY_CHARGES'] * delivery_charges(),2); ?></strong>
								<?php
									}
								?>
							</div>
							<div class="row txt-right">
								<input type="submit" value="Continue" class="btn" />
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer">
		<?php require('templates/footer.php');?>
	</div>
</body>
</html>
