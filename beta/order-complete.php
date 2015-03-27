<?php
	session_start();

	include('include/functions.php');
	/* if(!isset($_SESSION['CURRENT_ORDER_ID']) && isset($_SESSION['user'])){
		header('location:my-profile.php');
		die();
	} */

	if(!isset($_SESSION['CURRENT_ORDER_ID'])){
		header('location:my-profile.php');
		die();
	}

	$select = "`order_status`,`order_date_added`";
	$where = "`order_id` = '".$_SESSION['CURRENT_ORDER_ID']."'";
	$result_order = SELECT($select ,$where, 'orders', 'array');

	if($result_order['order_status'] == 'assign') {
		$return_status = 'true';
	} else if($result_order['order_status'] == 'cancel') {
		$return_status = 'cancel';
	} else {
		$return_status = 'false';
	}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="images/favicon.ico">
	<title>Your Order - Confirmation and Response - Just-FastFood</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/validate.js"></script>

	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript">
		<?php if($return_status == 'false') {?>
		var time = 1;
		var sec;
		load();

		function load(){
			$.ajax({
				  type: "POST",
				  url: 'include/order-check.php',
				  data: { ID : <?php echo $_SESSION['CURRENT_ORDER_ID']?>},
				  success: function(data) {
					if(data == 'false'){
						$('.order-complete-wrap  .order-loading .loading-90 div').css('width', time + '%');
						$('.order-complete-wrap .ltext').text(time+'% Complete');
						time ++;
						if(time > 100) {
							clearInterval(sec);
							$('.order-complete-wrap  .order-loading .loading-90').hide();
							$('.order-complete-wrap  .order-loading .txt-center').append('Restaurant is busy at the moment... You will be notify when we receive your order');
							window.setTimeout(function() {window.location.href = 'order-complete.php';},5000);
						} else {
							sec = window.setTimeout('load()',1000);
						}
					} else {
						time = 100;
						$('.order-complete-wrap .ltext').text('100% Complete');
						window.setTimeout(function() {window.location.href = 'order-complete.php';},800);

					}
				  }
			});
		}
		<?php } ?>
	</script>

</head>
<body>
	<div class="header">
		<?php require('templates/header.php');?>
	</div>
	<div class="content">
		<div class="wrapper">
			<div class="breadcrum">
				<ul>
					<li><a href="index.php">Begin Search</a></li>
					<li><a href="Postcode-<?php echo str_replace(' ','-',$_SESSION['CURRENT_POSTCODE']); ?>">Postcode-<?php echo $_SESSION['CURRENT_POSTCODE']; ?></a></li>
					<li><a href="<?php echo $_SESSION['CURRENT_MENU']?>"><?php echo $_SESSION['CURRENT_MENU']?></a></li>
					<li><a href="order-details.php">Delivery Address</a></li>
					<li class="u">Order Complete</li>
				</ul>
			</div>

			<div class="MENU">
				<?php
					$query_location = $obj -> query_db("SELECT * FROM `location`,`menu_type` WHERE location.location_menu_id = '".$_SESSION['DELIVERY_REST_ID']."' AND  menu_type.type_id = '".$_SESSION['DELIVERY_REST_ID']."'");
					$locationObj = $obj -> fetch_db_array($query_location);
					$oph = json_decode($locationObj['type_opening_hours'] ,true);
					$type_special_offer = json_decode($locationObj['type_special_offer'] ,true);
				?>
				<div class="todayTime txt-right"><?php echo date("l, j F Y, G:i")?></div>
				<div class="box-wrap menu-details">
					<div class="fl-left img">
						<img src="items-pictures/<?php echo $locationObj['type_picture'];?>" alt=""/>
					</div>
					<div class="fl-left details">
						<h1><?php echo $locationObj['type_name'];?> <span><?php echo $locationObj['location_city'];?></span></h1>
						<strong>Opening hours</strong><br>
						<ul>
							<li class="i"><label for=""><?php echo date('l');?>:</label><?php echo  $oph[date('l')]['From'] . ' - ' .$oph[date('l')]['To']?></li>
							<li style="color:gray"><label for=""><?php echo date('l', time()+86400)?>:</label><?php echo  $oph[date('l', time()+86400)]['From'] . ' - ' .$oph[date('l')]['To']?></li>
						</ul>
						<a href="oph.php?id=<?php echo $_SESSION['DELIVERY_REST_ID']?>/?iframe=true&amp;width=300&amp;height=300" rel="prettyPhoto" class="showMore u"> View all opening times</a>
					</div>
					<div class="clr"></div>
					<?php
						if($type_special_offer != "") {
							echo '<div class="special-offer"><strong>';
							echo $type_special_offer['off']. ' % off today on orders over &pound; '.$type_special_offer['pound'];
							echo '</strong></div>';
						}
					?>
				</div>
			</div>

			<div class="box-wrap" style="margin-top:20px;">
				<div class="order-complete-wrap">
					<h5>Your Order is being sent to <?php echo $locationObj['type_name'];?></h5>
					<hr class="hr" />
					<div class="order-comp">
						<p>
							<span>Your Order ID : </span><strong><?php echo $_SESSION['CURRENT_ORDER_ID'];?></strong>
						</p>
						<p>
							<span>Your Transaction ID : </span><strong><?php echo $_SESSION['ORDER_TRANSACTION_DETAILS']['TRANSACTIONID'];?></strong>
						</p>
					</div>
					<hr class="hr" />
					<?php if($return_status == 'true') {?>
					<div>
						<h1 class="subheading txt-center">
							Thank You </span><strong><?php echo $_SESSION['user'];?></strong>!</p> Please check you order status below.
						</h1>
						<div class="cbox-wrap  current-status">
							<div class="fl-left">
								<p><span>Order Status :</span> <strong>Accepted</strong></p>
								<p><span>Time Accepted : </span><strong><?php echo date('d-m-Y H:i:s' ,strtotime($result_order['order_date_added']));?></strong></p>
							</div>
							<div class="fl-left">
								<?php
									$_SESSION['delivery_type'] = json_decode($_SESSION['delivery_type'] , true);
								?>
								<p><span>Order Type : </span><strong><?php echo $_SESSION['delivery_type']['type'] .'  '.$_SESSION['delivery_type']['time']?></strong></p>
								<p><span>Payment Method : </span><strong><?php echo $_SESSION['CHECKOUT_WITH'];?></strong></p>
							</div>
							<div class="clr"></div>
							<p style="padding-left:200px;">You order is on its way!</p>
						</div>
					</div>
					<?php } else if($return_status == 'cancel'){?>
					<div class="order-loading">
						<div class="cbox-wrap txt-center">
							<h2>Sorry!! Your order has been canceled.<br> Restaurant is very busy or closed at the moment.<br>Please try again</h2>
							<p>You have not been charged for this order</p>
							<p>For more details please click on Live Chat and/or email us with your order and transaction id</p>
						</div>
					</div>
					<?php } else {?>
					<div class="order-loading">
						<div class="cbox-wrap txt-center">
							<h2>We're sending your order . . . <br/> Please wait for confirmation to ensure order acceptance! </h2>
							<!--<div class="loading-90"><div></div></div>-->
							<img src="include/bycard/Ajax_Loading.gif" alt="" style="width:110px; "/>
							<div class="ltext"></div>
						</div>
					</div>
					<?php } ?>
					<?php
						if($return_status != 'false') {
						$session_user = $_SESSION['user'];
						$session_id = $_SESSION['userId'];

						foreach($_SESSION as $k => $v){
							unset($_SESSION[$k]);
						}

						$_SESSION['user'] = $session_user;
						$_SESSION['userId'] = $session_id;
					?>

					<div class="txt-right" style="margin-top:20px;">
						<a href="my-profile.php" class="btn">Continue</a>
					</div>
					<?php } ?>
				</div>
			</div>

		</div>
	</div>
	<div class="footer">
		<?php require('templates/footer.php');?>
	</div>
</body>
</html>