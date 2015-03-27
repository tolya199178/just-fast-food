<?php
	session_start();
	require('include/auth.php');
	include('include/functions.php');

	$ARRAY = array('user_name','user_screen_name', 'user_email', 'user_phoneno', 'user_address', 'user_address_1', 'user_city', 'user_post_code', 'user_dob', 'user_hear', 'user_status');

	if(isset($_SESSION['access_key']) && isset($_POST['access']) && $_POST['access'] == $_SESSION['access_key']) {
		if(isset($_POST['UPDATE'])){
			$json_post = getEandN($_POST['user_post_code']);
			if($json_post) {
				$val = "";
				foreach($ARRAY as $values) {
					$val .= "`".$values."` = '".$_POST[$values]."',";
				}
				$val = substr($val ,0 ,-1);
				$query = "UPDATE  `user` SET ".$val."  WHERE `id` = '".$_SESSION['userId']."'";
				$obj -> query_db($query) or die(mysql_error());
				$_SESSION['success'] = "Profile Updated Successfully";
			} else {
				$_SESSION['error']  = "ERROR!! Invalid Post Code. <span style='font-size:13px'>( Please enter only full UK postode)</span>";
			}
		}

		else if (isset($_POST['UPDATEPASS'])) {

			$value = $obj->query_db("SELECT * FROM `user` WHERE `id` = '".$_SESSION['userId']."' AND `user_password` = '".md5($_POST['c_user_password'])."'") or die(mysql_error());
			$res = $obj->fetch_db_array($value);

			if ($res > 0) {
				$value = $obj  -> query_db ("UPDATE `user` SET  `user_password` =  '".md5($_POST['user_password'])."' WHERE `id` ='".$_SESSION['userId']."'") or die(mysql_error());
				$_SESSION['success'] = "Successfully Password Changed..";
			} else	{
				$_SESSION['error'] = "Wrong Current Password! ";
			}
		}

		else if (isset($_POST['rating'])) {

			$ar['Quality'] = $_POST['Quality'];
			$ar['Service'] = $_POST['Service'];
			$ar['Value'] = $_POST['Value'];
			$ar['Delivery'] = $_POST['Delivery'];

			$r_details = json_encode($ar);

			$value = "NULL, ";
			$value .= "'".$_POST['r_rest_id']."', ";
			$value .= "'".$_POST['r_user_id']."', ";
			$value .= "'".$_POST['r_order_id']."', ";
			$value .= "'".$r_details."', ";
			$value .= "'".mysql_real_escape_string(strip_tags($_POST['r_message']))."', ";
			$value .= "NULL";

			$extra = "`r_order_id` = '".$_POST['r_order_id']."'";
			$result = INSERT($value ,'rating' ,'unique' ,$extra);

			if($result) {
				$_SESSION['success'] = "Successfully Posted Rating of Your Order.";
			} else {
				$_SESSION['error'] = "ERROR! You have already rated this order";
			}
		}

	}


	$select = "*";
	$where = "`id` = '".$_SESSION['userId']."'";
	$result = SELECT($select ,$where, 'user', 'array');
	foreach($ARRAY as $v) {
		$ARRAYTEMP[$v] = $result[$v];
	}
	$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="images/favicon.ico">
	<title>Just-FastFood | My Profile</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="admin/css/timepicker.css"  />
	<link rel="stylesheet" type="text/css" href="admin/css/ui-custom.css"/>
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="admin/components/ui/jquery.ui.min.js"></script>
	<script type="text/javascript" src="admin/components/ui/timepicker.js"></script>
	<script type="text/javascript" src="js/validate.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#signupForm").validate();
			$("#updtPassForm").validate({
				rules:{
					cuser_password:{
						 equalTo: "#user_password"
					 },
				}
			});
			$( "input.birthday" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat:'yy-mm-dd'
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
			<h1 class="heading"><?php echo $_SESSION['user']; ?> Profile</h1>
			<hr class="hr"/>
			<?php include('include/notification.php');?>
			<?php				$NEW_ORDER = false;				$query = "SELECT * FROM `orders` WHERE `order_user_id` = '".$_SESSION['userId']."' AND `order_status` = 'to_confirm' ORDER BY `order_date_added` DESC";				$toconfirm_obj = $obj->query_db($query);				if($obj -> num_rows($toconfirm_obj) > 0) {					$NEW_ORDER = true;				}			if($NEW_ORDER) {			?>			<div class="explor box-wrap" style="margin-bottom:10px">				<h3 class="">Orders Not Confirm Yet!</h3><hr class="hr" />				<?php while($new_order = $obj->fetch_db_assoc($toconfirm_obj)) {?>				<div class="myorderslist">					<div class="b id">Order ID : <?php echo $new_order['order_id']?></div>					<div class="b">Restaurant :						<?php							$select1 = "`type_name`";							$where1 = "`type_id` = '".$new_order['order_rest_id']."'";							$result_restaurant_name = SELECT($select1 ,$where1, 'menu_type', 'array');							echo $result_restaurant_name['type_name'];						?>					</div>					<div class="b">Payment Type: <span class="id"><?php echo strtoupper($new_order['order_payment_type'])?></span></div>						<div class="txt-right b">Total : &pound; <?php echo number_format($new_order['order_total'], 2)?><span style="font-weight:normal; font-size:11px;"> (including tax and delivery charges)</span></div>						<?php							$Array = json_decode($new_order['order_details'] ,true);							foreach($Array as $key => $val) {								if($key != 'TOTAL') {									echo '<div class="details">';																													echo '<span>'.$val['QTY'].'x </span>';										echo '<span>'.$val['NAME'].'</span>';										echo '<span>&pound; '.number_format($val['TOTAL'], 2).'</span>';																												echo '</div>';								}							}						?>						<div class="txt-right b">Phone No : <?php echo $new_order['order_phoneno']?></div>						<div class="txt-right b">Address : <?php echo $new_order['order_address']; ?></div>						<div class="txt-right b">At : <?php echo date('H:i:s l, j F Y' , strtotime($new_order['order_date_added']))?></div>						<div class="">Order Note From User: <span class="i b"><?php echo $new_order['order_note']; ?></span></div>				</div>				<?php } ?>				<hr class="hr" />				<p style="font-size:12px;" class="txt-center">Having problem in orders make a live chat with us or send us email at <a href="mailto:info@just-fastfood.com" class="u b">info@just-fastfood.com</a> (while contacting must provide order id on subject of email). </p>			</div>			<?php } ?>
			<?php
				$NEW_ORDER = false;

				$query = "SELECT * FROM `orders` WHERE `order_user_id` = '".$_SESSION['userId']."' AND `order_status` = 'assign' ORDER BY `order_date_added` DESC";
				$toconfirm_obj = $obj->query_db($query);

				if($obj -> num_rows($toconfirm_obj) > 0) {
					$NEW_ORDER = true;
				}

			if($NEW_ORDER) {
			?>
			<div class="explor box-wrap" style="margin-bottom:10px">
				<h3 class="">Pending Orders - Yet to be delivered!</h3><hr class="hr" />
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
					<div class="b">Payment Type: <span class="id"><?php echo strtoupper($new_order['order_payment_type'])?></span></div>
						<div class="txt-right b">Total : &pound; <?php echo number_format($new_order['order_total'], 2)?><span style="font-weight:normal; font-size:11px;"> (including tax and delivery charges)</span></div>
						<?php
							$Array = json_decode($new_order['order_details'] ,true);
							foreach($Array as $key => $val) {
								if($key != 'TOTAL') {
									echo '<div class="details">';
									
																				echo '<span>'.$val['QTY'].'x </span>';										echo '<span>'.$val['NAME'].'</span>';
										echo '<span>&pound; '.number_format($val['TOTAL'], 2).'</span>';
										
									
									echo '</div>';
								}
							}
						?>
						<div class="txt-right b">Phone No : <?php echo $new_order['order_phoneno']?></div>
						<div class="txt-right b">Address : <?php echo $new_order['order_address']; ?></div>
						<div class="txt-right b">At : <?php echo date('H:i:s l, j F Y' , strtotime($new_order['order_date_added']))?></div>
						<div class="">Order Note From User: <span class="i b"><?php echo $new_order['order_note']; ?></span></div>
				</div>
				<?php } ?>
				<hr class="hr" />
				<p style="font-size:12px;" class="txt-center">Having problem with orders, please use the live chat us or send us an email at <a href="mailto:info@just-fastfood.com" class="u b">info@just-fastfood.com</a> (while contacting must provide order id on subject of email). </p>
			</div>
			<?php } ?>

			<div class="explor box-wrap no-padding">
				<div class="by-card b"><a href="javascript:;" class="slideupdown">Update Profile</a></div>
				<div class="profile-container">
					<div class="sign-up-wrap">
					<form action="" method="post" id="signupForm">
						<div class="row">
							<label for="user_email">Email Address<span>*</span></label><?php echo $ARRAYTEMP['user_email'];?>
							<input type="hidden" name="user_email" value="<?php echo $ARRAYTEMP['user_email'];?>"/>
						</div>
						<div class="row">
							<label for="user_screen_name">Screen Name</label><input type="text" name="user_screen_name" id="user_screen_name" class="input" value="<?php echo $ARRAYTEMP['user_screen_name'];?>"/>
						</div>
						<div class="row">
							<label for="user_name">Full Name<span>*</span></label><input type="text" name="user_name" id="user_name" class="input required" value="<?php echo $ARRAYTEMP['user_name'];?>"/>
						</div>
						<div class="row">
							<label for="user_phone">Phone No<span>*</span></label><input type="text" name="user_phoneno" id="user_phoneno" class="input required" value="<?php echo $ARRAYTEMP['user_phoneno'];?>"/>
						</div>
						<hr class="hr"/>
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
							<label for="user_postcode">Date of Birth<span></span></label><input type="text" name="user_dob" id="user_dob" class="input birthday" value="<?php echo $ARRAYTEMP['user_dob'];?>"/>
						</div>
						<div class="row">
							<label for="user_postcode">Where did you hear about us?<span></span></label><input type="text" name="user_hear" id="user_hear" class="input" value="<?php echo $ARRAYTEMP['user_hear'];?>"/>
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
				<div class="by-card b"><a href="javascript:;" class="slideupdown">Orders Fulfiled</a></div>
				<div class="orders-container">
					<?php
						$query = "SELECT * FROM `orders` WHERE `order_user_id` = '".$_SESSION['userId']."' AND `order_status` = 'complete' ORDER BY `order_date_added` DESC";
						$value = $obj->query_db($query);
						if($obj -> num_rows($value) < 1) {
							echo '<h4>No Order Yet<h4>';
						} else {
						echo '<div class="txt-right b">Total Orders: '.$obj -> num_rows($value).'</div><br>';
						while($res = $obj->fetch_db_assoc($value)) {
					?>
					<div class="myorderslist">
						<div class="b id">Order ID : <?php echo $res['order_id']?></div>
						<p class="b">Restaurant :
							<?php
								$select1 = "`type_name`";
								$where1 = "`type_id` = '".$res['order_rest_id']."'";
								$result_restaurant_name = SELECT($select1 ,$where1, 'menu_type', 'array');
								echo $result_restaurant_name['type_name'];
							?>
						</p>
						<div class="fl-left" style="width:600px">
							<?php
								$Array = json_decode($res['order_details'] ,true);
								foreach($Array as $key => $val) {
									if($key != 'TOTAL') {
										echo '<div class="details" style="width:100%">';
										echo '
											<span>'.$val['QTY'].' x</span>
											<span>'.$val['NAME'].'</span>
											<span>&pound; '.number_format($val['TOTAL'], 2).'</span>
										';
										echo '</div>';
									}
								}
								$_SESSION['reorder'][$res['order_id']] = $res['order_details'];
							?>
							<div class="b u i"><a href="reorder.php?order=<?php echo $res['order_id']?>" class="reorder">Reorder</a></div>
						</div>
						<div class="fl-right">
							<?php
								$query1 = "SELECT * FROM `rating` WHERE `r_order_id` = '".$res['order_id']."'";
								$r = $obj -> query_db($query1);
								
								if($obj -> num_rows($r) > 0) {
									$rating = $obj->fetch_db_assoc($r);
							?>
								<div class="cbox-wrap" style="margin:0px 0px 10px 0px">
								<div class="fl-left">
									<div>Quality:</div>
									<div>Service:</div>
									<div>Value:</div>
									<div>Delivery:</div>
								</div>
								<div class="fl-left">
								<?php
									$rat = json_decode($rating['r_details'], true);
									echo '<div class="rating">';
									echo '<div class="r-5_'.$rat['Quality'].'" title="Quality ('.$rat['Quality'].'/10)"></div>';
									echo '<div class="r-5_'.$rat['Service'].'" title="Service ('.$rat['Service'].'/10)"></div>';
									echo '<div class="r-5_'.$rat['Value'].'" title="Value ('.$rat['Value'].'/10)"></div>';
									echo '<div class="r-5_'.$rat['Delivery'].'" title="Delivery ('.$rat['Delivery'].'/10)"></div>';
									echo '</div>';
								?>
								</div>
								<div class="clr"></div>
								<div class="review-Details" style="padding:8px 5px 5px 0px">
									<div class="message">"<?php echo $rating['r_message']?>"</div>
								</div>
								</div>
							<?php } ?>
						</div>
						<div class="clr"></div>
						<div class="b">TOTAL : &pound; <?php echo number_format($res['order_total'], 2)?></div><br>
						<div class="b">Deliver to  : <?php echo $res['order_address']?></div>
						<div class="b">Dated : <?php echo date('l, j F Y H:i:s' , strtotime($res['order_date_added']))?></div>
						<div class="myrating">
							<?php
								$qu = "SELECT * FROM `rating` WHERE `r_order_id` = '".$res['order_id']."'";
								$valueOBJECT = $obj->query_db($qu);
								if($obj -> num_rows($valueOBJECT) < 1) {
									echo 'You Have Not Rated Yet. <a href="javascript:;" class="b u id rate-now">Rate This Order Now</a>';
									echo '<form action="my-profile.php" class="box-wrap" method="post">';
									$show = '
										<h4>Rate This Order</h4><hr class="hr" />
										<div class="fl-left">
										<p class="row">
											<label for="">Quality</label>
											<select name="Quality" id="">
									';

												for($i = 10; $i > 0 ;$i --) {
													$show .= '<option value="'.$i.'">'.$i.'</option>';
												}

									$show .= '
											</select>
										</p>
									';
									$show .= '
										<p class="row">
											<label for="">Service</label>
											<select name="Service" id="">
									';

												for($i = 10; $i > 0 ;$i --) {
													$show .= '<option value="'.$i.'">'.$i.'</option>';
												}

									$show .= '
											</select>
										</p>
									';
									$show .= '
										<p class="row">
											<label for="">Value</label>
											<select name="Value" id="">
									';

												for($i = 10; $i > 0 ;$i --) {
													$show .= '<option value="'.$i.'">'.$i.'</option>';
												}

									$show .= '
											</select>
										</p>
									';
									$show .= '
										<p class="row">
											<label for="">Delivery</label>
											<select name="Delivery" id="">
									';

												for($i = 10; $i > 0 ;$i --) {
													$show .= '<option value="'.$i.'">'.$i.'</option>';
												}

									$show .= '
											</select>
										</p>
									</div>
									<div class="fl-left">
										<div class="fl-left"><label for="">Message</label></label></div>
										<div class="fl-left">
											<textarea name="r_message" id="" cols="30" rows="8"></textarea>
										</div>
										<div class="clr"></div>
									</div>
									<div class="clr"></div>
									<div style="text-align:center;">
										<input type="submit" value="Submit" class="button" name="rating"/>
										<input type="hidden" name="r_order_id" value="'.$res['order_id'].'"/>
										<input type="hidden" name="r_user_id" value="'.$_SESSION['userId'].'"/>
										<input type="hidden" name="r_rest_id" value="'.$res['order_rest_id'].'"/>
										<input type="hidden" name="access" value="'.$_SESSION['access_key'].'"/>
										(Rating does not change after submit)
									</div>
									';
									echo $show;
									echo '</form>';
								} else {

								}
							?>
						</div>
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
								<label for="c_user_password">Current Password<span>*</span></label><input type="password" name="c_user_password" id="c_user_password" class="input required" />
							</div>
							<div class="row">
								<label for="user_password">New Password<span>*</span></label><input type="password" name="user_password" id="user_password" class="input required" />
							</div>
							<div class="row">
								<label for="cuser_password">Confirm Password<span>*</span></label><input type="password" name="cuser_password" id="cuser_password" class="input required"/>
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
