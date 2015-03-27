<?php
	session_start();
	if(!isset($_SESSION['user_type']) && $_SESSION['user_type'] != 'takeaway') {
		header('location:takeaway-login.php');
		die();
	}

	require('include/auth.php');
	include_once('include/functions.php');

	if(isset($_SESSION['access_key']) && isset($_POST['access']) && $_POST['access'] == $_SESSION['access_key']) {

		include_once('include/order-movement.php');

		if(isset($_POST['CHANGE_ORDER_STATUS'])) {

			$newstatus = ($_POST['order_status'] == 'yes') ? 'assign' : 'cancel';
			confirmFastFoodOrder($_POST['order_id'] ,$newstatus);

		} else if (isset($_POST['UPDATEPASS'])) {

			$value = $obj->query_db("SELECT * FROM `menu_type` WHERE `type_id` = '".$_SESSION['userId']."' AND `type_password` = '".$_POST['o_staff_password']."'") or die(mysql_error());
			$res = $obj->fetch_db_array($value);

			if ($res > 0) {
				$value = $obj  -> query_db ("UPDATE `menu_type` SET  `type_password` =  '".$_POST['staff_password']."' WHERE `type_id` ='".$_SESSION['userId']."'") or die(mysql_error());
				$_SESSION['success'] = "Successfully Password Changed..";
			} else	{
				$_SESSION['error'] = "Wrong Current Password! ";
			}
		}

		else if(isset($_POST['SUBMIT_STATUS'])) {

			foreach($_POST['order_status'] as $key => $id) {
				if($id != "") {
					if(orderComplete($id) == 'false'){
						$_SESSION['error'] = "Error in Order Completion!";
					}
				}
			}
		}
	}

	$NEW_ORDER = false;
	$query = "SELECT * FROM `orders` WHERE `order_rest_id` = '".$_SESSION['userId']."' AND `order_status` = 'to_confirm' ORDER BY `order_date_added` ASC";
	$toconfirm_obj = $obj->query_db($query);

	if($obj -> num_rows($toconfirm_obj) > 0) {
		$NEW_ORDER = true;
	}

	$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="Staff Profile, <?= getDataFromTable('setting','meta'); ?>">
	<meta name="keywords" content="Staff Profile, <?= getDataFromTable('setting','keywords'); ?>">
	<meta name="author" content="M Awais">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="apple-touch-icon" href="items-pictures/default_rest_img.png">

	<link rel="shortcut icon" href="images/favicon.ico">
	<title>Just-FastFood - Takeaway Profile</title>
	<link rel="stylesheet" href="css/style.css" />

	<link rel="stylesheet" type="text/css" href="admin/css/ui-custom.css"/>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />

	<link href="css/iphone.css" rel="stylesheet" type="text/css" media="only screen and (min-width: 0px) and (max-width: 320px)" >
	<link href="css/ipad.css" rel="stylesheet" type="text/css"  media="only screen and (min-width: 321px) and (max-width: 768px)" >

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="admin/components/ui/jquery.ui.min.js"></script>

	<script type="text/javascript" src="js/validate.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/mobileMenu.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#signupForm").validate();
			$("#updtPassForm").validate({
				rules:{
					c_staff_password:{
						 equalTo: "#staff_password"
					 },
				}
			});

			$('.order_status_form .select').change(function(){
				$(this).parents('form').submit();
			});

			//refreshPage(90000 ,'staff-profile.php');
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
			<h1 class="heading"><?php echo $_SESSION['user']; ?> Profile</h1>
			<hr class="hr"/>
			<?php include('include/notification.php');?>

			<?php
				if($NEW_ORDER) {
			?>
			<div class="explor box-wrap" style="margin-bottom:10px">
				<h3 class="">New Order(s)</h3>
				<?php while($new_order = $obj->fetch_db_assoc($toconfirm_obj)) {?>
				<div class="myorderslist">
					<div class="b id">Order ID : <?php echo $new_order['order_id']?></div>
					<div class="b">Restaurant :
						<?php
							$select1 = "`type_name`";
							$where1 = "`type_id` = '".$new_order['order_rest_id']."'";
							$result_restaurant_name = SELECT($select1 ,$where1, 'menu_type', 'array');
							echo $result_restaurant_name['type_name'];
						?>
					</div>
						<?php
							$Array = json_decode($new_order['order_details'] ,true);
							echo '<div class="txt-right b">Total : &pound; '.number_format($Array['TOTAL'], 2).'</div>';
							foreach($Array as $key => $val) {
								if($key != 'TOTAL') {
									echo '<div class="details">';
										echo '<span>'.$val['QTY'].'x </span>';
										echo '<span>'.$val['NAME'].'</span>';
										echo '<span class="fl-right">&pound; '.number_format($val['TOTAL'], 2).'</span>';
									echo '</div>';
								}
							}
						?>
						<div class="txt-right b">Phone No : <?php echo $new_order['order_phoneno']?></div>
						<div class="txt-right b">Address : <?php echo $new_order['order_address'].' '.key(json_decode($new_order['order_postcode'], true)); ?></div>
						<div class="">Order Note From User: <span class="i b"><?php echo $new_order['order_note']; ?></span></div>
						<div class="txt-right b">
							<form action="" method="post" class="order_status_form">
								Are you available to Deliver?
								<select class="select" name="order_status">
									<option value="">Please Select</option>
									<option value="yes">Yes</option>
									<option value="no">No</option>
								</select>
								<input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
								<input type="hidden" name="CHANGE_ORDER_STATUS" />
								<input type="hidden" name="order_id" value="<?php echo $new_order['order_id']?>"/>
							</form>
						</div>
				</div>
				<?php } ?>
			</div>
			<?php } ?>

			<div class="explor box-wrap no-padding">
				<div class="by-card b"><a href="javascript:;" class="slideupdown">My Orders (Pending)</a></div>
				<div class="orders-container" style="display:block;">
					<?php

						$query = "SELECT * FROM `orders` WHERE `order_rest_id` = '".$_SESSION['userId']."'  AND `order_status` = 'assign' ORDER BY `order_date_added` DESC";
						$value = $obj->query_db($query);
						if($obj -> num_rows($value) < 1) {
							echo '<h4>No Order Yet<h4>';
						} else {
						echo '<form action="" method="post">';
						echo '<div class="txt-right b">Total Orders: '.$obj -> num_rows($value).'</div><br>';
						echo '<div class="txt-right"><input type="submit" value="Submit" class="btn" name="SUBMIT_STATUS"/></div><hr class="hr" />';
						while($res = $obj->fetch_db_assoc($value)) {
					?>
					<div class="myorderslist">
						<div class="b id">Order ID : <?php echo $res['order_id']?></div>

							<?php
								$Array = json_decode($res['order_details'] ,true);
								foreach($Array as $key => $val) {
									if($key != 'TOTAL') {
										echo '<div class="details">';
											echo '<span>'.$val['QTY'].'x </span>';
											echo '<span>'.$val['NAME'].'</span>';
											echo '<span class="fl-right">&pound; '.number_format($val['TOTAL'], 2).'</span>';
										echo '</div>';
									}
								}
							?>
							<div class="txt-right b">Post Code : <?php echo key(json_decode($res['order_postcode'], true))?></div>
							<div class="txt-right b">Address : <?php echo $res['order_address']; ?></div>
							<div class="txt-right b">DATED : <?php echo $res['order_acceptence_time']?></div><br>
							<div class="txt-right b">
								Change Status:
								<select name="order_status[<?php echo $res['order_id'];?>]" id="">
									<option value="">Pending</option>
									<option value="<?php echo $res['order_id']?>">Complete</option>
								</select>
							</div>
					</div>
					<?php
						}
						echo '<hr class="hr" /><div class="txt-right"><input type="submit" value="Submit" class="btn" name="SUBMIT_STATUS"/></div>';
						echo '<input type="hidden" name="access" value="'.$_SESSION['access_key'].'"/>';
						echo '</form>';
					}
					?>
				</div>
				<div class="by-card b"><a href="javascript:;" class="slideupdown">My Orders (Completed)</a></div>
				<div class="orders-container">
					<?php

						$query = "SELECT * FROM `orders` WHERE `order_rest_id` = '".$_SESSION['userId']."'  AND `order_status` = 'complete' ORDER BY `order_date_added` DESC";
						$value = $obj->query_db($query);
						if($obj -> num_rows($value) < 1) {
							echo '<h4>No Order Yet<h4>';
						} else {
						echo '<div class="txt-right b">Total Orders: '.$obj -> num_rows($value).'</div><br>';
						while($res = $obj->fetch_db_assoc($value)) {
					?>
					<div class="myorderslist">
						<div class="b id">Order ID : <?php echo $res['order_id']?></div>

							<?php
								$Array = json_decode($res['order_details'] ,true);
								foreach($Array as $key => $val) {
									if($key != 'TOTAL') {
										echo '<div class="details">';
										foreach($val as $k => $v) {
											if($k == 'TOTAL') {
												echo '<span>'.$k.':  &pound; '.number_format($v,2).'</span>';
											} else {
												echo '<span>'.$k.' :  '.$v.'</span>';
											}
										}
										echo '</div>';
									}
								}
							?>
							<div class="txt-right b">Post Code : <?php echo key(json_decode($res['order_postcode'], true))?></div>
							<div class="txt-right b">Address : <?php echo $res['order_address']; ?></div>
							<div class="txt-right b">DATED : <?php echo $res['order_acceptence_time']?></div>
					</div>
					<?php
						}
					}
					?>
				</div>
				<div class="by-card b"><a href="javascript:;" class="slideupdown">Update Password</a></div>
				<div class="profile-container">

					<div class="sign-up-wrap">
						<form action="" method="post" id="updtPassForm">
							<div class="row">
								<label for="o_staff_password">Current Password<span>*</span></label><input type="password" name="o_staff_password" id="o_staff_password" class="input required" />
							</div>
							<div class="row">
								<label for="staff_password">New Password<span>*</span></label><input type="password" name="staff_password" id="staff_password" class="input required" />
							</div>
							<div class="row">
								<label for="c_staff_password">Confirm Password<span>*</span></label><input type="password" name="c_staff_password" id="c_staff_password" class="input required"/>
							</div>
							<div class="row">
								<input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
							</div>
							<div class="row txt-right">
								<input type="submit" value="Update" class="btn" name="UPDATEPASS"/>
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