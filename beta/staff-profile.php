<?php
	session_start();
	if(!isset($_SESSION['user_type'])) {
		header('location:staff-login.php');
		die();
	}

	require('include/auth.php');
	include_once('include/functions.php');

	$ARRAY = array('staff_email', 'staff_name', 'staff_address', 'staff_phoneno', 'staff_postcode');

	if(isset($_SESSION['access_key']) && isset($_POST['access']) && $_POST['access'] == $_SESSION['access_key']) {

		include_once('include/order-movement.php');

		if(isset($_POST['CHANGE_ORDER_STATUS'])) {

			$newstatus = ($_POST['order_status'] == 'yes') ? 'assign' : 'cancel';
			confirmFastFoodOrder($_POST['order_id'] ,$newstatus);

		}

		else if(isset($_POST['UPDATE'])){
			$json_post = getEandN($_POST['staff_postcode']);
			if($json_post) {
				$val = "";
				foreach($ARRAY as $values) {
					if($values == "staff_postcode"){
						$p[$_POST[$values]] = getEandN($_POST[$values]);
						$val .= "`".$values."` = '".json_encode($p)."',";
					} else {
						$val .= "`".$values."` = '".$_POST[$values]."',";
					}
				}
				$val = substr($val ,0 ,-1);
				$query = "UPDATE  `staff` SET ".$val."  WHERE `staff_id` = '".$_SESSION['userId']."'";
				$obj -> query_db($query) or die(mysql_error());
				$_SESSION['success'] = "Profile Updated Successfully";
			} else {
				$_SESSION['error']  = "ERROR!! Invalid Post Code. <span style='font-size:13px'>( Please enter only full UK postode)</span>";
			}
		}

		else if (isset($_POST['UPDATEPASS'])) {

			$value = $obj->query_db("SELECT * FROM `staff` WHERE `staff_id` = '".$_SESSION['userId']."' AND `staff_password` = '".md5($_POST['o_staff_password'])."'") or die(mysql_error());
			$res = $obj->fetch_db_array($value);

			if ($res > 0) {
				$value = $obj  -> query_db ("UPDATE `staff` SET  `staff_password` =  '".md5($_POST['staff_password'])."' WHERE `staff_id` ='".$_SESSION['userId']."'") or die(mysql_error());
				$_SESSION['success'] = "Successfully Password Changed..";
			} else	{
				$_SESSION['error'] = "Wrong Current Password! ";
			}
		}

		else if(isset($_POST['SUBMIT_STATUS'])) {

			foreach($_POST['order_status'] as $key => $id) {
				if($id != "") {
					if(orderComplete($id) == 'false'){						$_SESSION['error'] = "Error in Order Completion!";					}
				}
			}
		}
	}

	$NEW_ORDER = false;
	$query = "SELECT * FROM `orders`,`staff_order` WHERE staff_order.staff_order_staff_id = '".$_SESSION['userId']."' AND orders.order_id = staff_order.staff_order_order_id  AND staff_order.staff_order_status = 'to_confirm' ORDER BY staff_order.staff_order_date_added ASC";
	$toconfirm_obj = $obj->query_db($query);

	if($obj -> num_rows($toconfirm_obj) > 0) {
		$NEW_ORDER = true;
	}

	$select = "*";
	$where = "`staff_id` = '".$_SESSION['userId']."'";
	$result = SELECT($select ,$where, 'staff', 'array');
	foreach($ARRAY as $v) {
		if($v == 'staff_postcode') {
			$ARRAYTEMP[$v] = key(json_decode($result[$v], true));
		} else {
			$ARRAYTEMP[$v] = $result[$v];
		}
	}
	$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="images/favicon.ico">
	<title>Just-FastFood - Staff Profile</title>
	<link rel="stylesheet" href="css/style.css" />

	<link rel="stylesheet" type="text/css" href="admin/css/ui-custom.css"/>
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="admin/components/ui/jquery.ui.min.js"></script>

	<script type="text/javascript" src="js/validate.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
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
							echo '<div class="txt-right b">Total : &pound; '.$Array['TOTAL'].'</div>';
							foreach($Array as $key => $val) {
								if($key != 'TOTAL') {
									echo '<div class="details">';
										echo '<span>'.$val['QTY'].'x </span>';										echo '<span>'.$val['NAME'].'</span>';										echo '<span class="fl-right">&pound; '.number_format($val['TOTAL'], 2).'</span>';
									echo '</div>';
								}
							}
						?>
						<div class="txt-right b">Phone No : <?php echo $new_order['order_phoneno']?></div>
						<div class="txt-right b">Address : <?php echo $new_order['order_address']; ?></div>
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
				<div class="by-card b"><a href="javascript:;" class="slideupdown">Update Profile</a></div>
				<div class="profile-container">
					<div class="sign-up-wrap">
					<form action="" method="post" id="signupForm">
						<div class="row">
							<label for="staff_email">Email Address<span>*</span></label><?php echo $ARRAYTEMP['staff_email'];?>
							<input type="hidden" name="staff_email" value="<?php echo $ARRAYTEMP['staff_email'];?>"/>
						</div>
						<div class="row">
							<label for="staff_name">Full Name<span>*</span></label><input type="text" name="staff_name" id="staff_name" class="input required" value="<?php echo $ARRAYTEMP['staff_name'];?>"/>
						</div>
						<div class="row">
							<label for="staff_phoneno">Phone No<span>*</span></label><input type="text" name="staff_phoneno" id="staff_phoneno" class="input required" value="<?php echo $ARRAYTEMP['staff_phoneno'];?>"/>
						</div>
						<hr class="hr"/>
						<p class="small txt-right">Address:</p>
						<div class="row">
							<label for="staff_address">Address<span>*</span></label><input type="text" name="staff_address" id="staff_address" class="input required" value="<?php echo $ARRAYTEMP['staff_address'];?>"/>
						</div>

						<div class="row">
							<label for="staff_postcode">Post Code<span>*</span></label><?php echo $ARRAYTEMP['staff_postcode'];?>
							<input type="hidden" name="staff_postcode" value="<?php echo $ARRAYTEMP['staff_postcode'];?>"/>
						</div>
						<div class="row">
							<input type="hidden" name="user_status" value="active"/>
							<input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
						</div>
						<div class="row txt-right">
							<input type="submit" value="Update" class="btn" name="UPDATE"/>
						</div>
					</form>
					</div>
				</div>
				<div class="by-card b"><a href="javascript:;" class="slideupdown">My Orders (Pending)</a></div>
				<div class="orders-container" style="display:block;">
					<?php

						$query = "SELECT * FROM `orders`,`staff_order` WHERE staff_order.staff_order_staff_id = '".$_SESSION['userId']."' AND orders.order_id = staff_order.staff_order_order_id  AND staff_order.staff_order_status = 'assign' ORDER BY staff_order.staff_order_date_added DESC";
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
											echo '<span>'.$val['QTY'].'x </span>';											echo '<span>'.$val['NAME'].'</span>';											echo '<span class="fl-right">&pound; '.number_format($val['TOTAL'], 2).'</span>';
										echo '</div>';
									}
								}
							?>
							<div class="txt-right b">Post Code : <?php echo key(json_decode($res['order_postcode'], true))?></div>
							<div class="txt-right b">Address : <?php echo $res['order_address']; ?></div>
							<div class="txt-right b">DATED : <?php echo $res['staff_order_date_added']?></div><br>
							<div class="txt-right b">
								Change Status:
								<select name="order_status[<?php echo $res['staff_order_order_id'];?>]" id="">
									<option value="">Pending</option>
									<option value="<?php echo $res['staff_order_order_id']?>">Complete</option>
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

						$query = "SELECT * FROM `orders`,`staff_order` WHERE staff_order.staff_order_staff_id = '".$_SESSION['userId']."' AND orders.order_id = staff_order.staff_order_order_id  AND staff_order.staff_order_status = 'complete' ORDER BY staff_order.staff_order_date_added DESC";
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
												echo '<span>'.$k.':  &pound; '.$v.'</span>';
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
							<div class="txt-right b">DATED : <?php echo $res['staff_order_date_added']?></div>
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