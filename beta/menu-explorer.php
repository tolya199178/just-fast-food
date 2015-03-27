<?php
	session_start();
	include('include/functions.php');

	$_postcode = "";

	if(isset($_GET['postcode'])){

		$res_full_address = "";
		$_postcode = str_replace('-',' ',$_GET['postcode']);
		$FULL_ADDRESS = "Restaurants in ".$_postcode;

		$patt = '/^([A-PR-UWYZ0-9][A-HK-Y0-9][AEHMNPRTVXY0-9]?[ABEHMNPRVWXY0-9]? {1,2}[0-9][ABD-HJLN-UW-Z]{2}|GIR 0AA)$/i';
		unset($_SESSION['min_rest_Array']);

		if(preg_match($patt, $_postcode)) {

			$json_post = getEandN($_postcode);
			if($json_post) {
				$_SESSION['CURRENT_POSTCODE'] = strtoupper($_postcode);
				$restArray = getCloserRest($json_post, str_replace(' ','' ,$_postcode));
				if(count($restArray['array'])){
					foreach ($restArray['array'] as $val) { $_SESSION['DELIVERY_CHARGES'] = $val ; break; }
					$_SESSION['min_rest_Array'] = $restArray['array'];
					if(array_key_exists('address' ,$restArray))
						$res_full_address = $restArray['address'];
						$FULL_ADDRESS = "Restaurants in ".$res_full_address;
				} else {
					$_SESSION['error'] = "No restaurants open in your area now";
				}
				
				setC('postcode',$_SESSION['CURRENT_POSTCODE']);
			} else {
				$_SESSION['error'] = "Post code not valid";
			}
		} else {
			$_SESSION['error'] = "Post code not valid";
		}
	} else {
		$_SESSION['error'] = "Post code not valid";
	}

?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="images/favicon.ico">
	<title><?php echo $FULL_ADDRESS; ?> | Just-FastFood</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/validate.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<link rel="stylesheet" href="css/fancybox/jquery.fancybox.css" />
	<script type="text/javascript" src="css/fancybox/jquery.fancybox.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){

			$("#order-search").validate({
				submitHandler: function(form) {
					var val = document.post.ukpostcode.value;
					val = val.replace(' ','-');
					window.location.href = 'Postcode-'+val;
					return false;
			   },
				rules: {
				 ukpostcode	: "required",
			   },
				messages: {
				 ukpostcode: "UK Post code Not Valid",
				},
				errorPlacement: function ($error, $element) {
					if ($element.attr("name") == "ukpostcode") {
						$error.insertAfter($element.next().next());
					} else {
						$error.insertAfter($element);
					}
				}
			});
			$(".pop_box").fancybox();
			$('.header .chat-wrap').css({'bottom':'auto', 'top':'3px','right':'3px','left':'auto'});
		});
	</script>
	<style type="text/css">
		.menu-explorer .header .outercart-wrapper {
			display:none;
		}
		h1.heading{
			font-size: 1.3em;
			text-align:center;
		}
		.menu-explorer .explor{
			border-bottom:none;
		}
	</style>

</head>
<body class="menu-explorer">
	<div class="header">
		<?php require('templates/header.php');?>
	</div>
	<div class="content">
		<div class="wrapper ">
			<div class="breadcrum">
				<ul>
					<li><a href="index.php">Begin Search</a></li>
					<li><a href="Postcode-<?php echo str_replace(' ','-',$_postcode); ?>" class="u">Postcode-<?php echo $_postcode; ?></a></li>
				</ul>
			</div>
			<?php include('include/notification.php');?>
				<!--<div class=" order-wrap">
					<div class="macky">
						<form action="" method="post" id="order-search" name="post">
							<label for="postcode">Your Post Code:</label>
							<input type="text" name="ukpostcode" id="postcode" class="text required postcode b" value="<?php echo $_postcode; ?>" placeholder="UK Post Code"/>
							<input type="submit" value="Go" name="submit" class="btn"/>
						</form>
					</div>
				</div>-->
			<?php if(isset($_SESSION['min_rest_Array'])) {?>
			<div class="leftColumn">
				<h1 class="heading i"><?php echo $FULL_ADDRESS; ?></h1>
				<div class="clr"></div>

				<div class="explor selectMenu">
					<ul>
					<?php
					
						$_SESSION['min_rest_Array'] = array_reverse($_SESSION['min_rest_Array'], true);
						foreach($_SESSION['min_rest_Array'] as $restName => $dist) {
							$ar = explode('-' , $restName);
							$restNam[$ar[0]] = $dist;
							$post_arr[$ar[0]] = $ar[1];
						}

						asort($restNam);
						foreach($restNam as $id => $distence) {

							$_SESSION['DISTENCE'][$id] = $distence;

							$restaurant_postcode = str_replace(' ','-' ,$post_arr[$id]);

							$query = "SELECT * FROM `menu_type` WHERE `type_id` = '".$id."'";
							$menu = $obj -> query_db($query);
							while($res = $obj->fetch_db_array($menu)) {
							$T_RATINGS = 0;
							$t_rating = 0;

							$nowTime = strtotime(date('H:i'));
							$oph = json_decode(stripslashes($res['type_opening_hours']) ,true);

							$oph_from = strtotime($oph[date('l')]['From']);
							$oph_to = strtotime($oph[date('l')]['To']);

							$isAvailable = false;
							if($nowTime > $oph_from && $nowTime < $oph_to) {
								$isAvailable = true;
							}

							$chareged = getTotalDeliveryCharges($res['type_steps'] ,$res['type_id'] ,$distence);
							//$chareged = round($distence * delivery_charges($res['type_id']),2);
					?>
							<li class="list-resaurant">
								<div class="fl-left">
									<img src="items-pictures/<?php echo $res['type_picture'];?>" alt="" />
								</div>
								<div class="fl-left">
									<a href="restaurant-<?php echo str_replace(' ', '-', $res['type_name']).'-'.str_replace(' ', '', $res['type_category']).'-'.$res['type_id'].'-'.$restaurant_postcode; ?>" class="menutype"><?php echo $res['type_name']?></a>
									<div class="style">
										<span style="color:#989888">Approximate distance, delivery time and charges.</span> <br/>
										Distence: <strong><?php echo $distence;?></strong> miles <br/>
										Delivery: <strong><?php echo $res['type_time']; ?></strong> minutes  (approx)<br/><br/>
										Delivery Charges: <strong><?php echo ($chareged == 0) ? 'Free Shipping' : '&pound; '.number_format($chareged, 2);?></strong><br/>
									</div>
								</div>
								<?php
									if($res['type_special_offer'] != "") {
										$type_special_offer = json_decode($res['type_special_offer'] ,true);
										echo '<div class="special-offer"><strong>';
										echo $type_special_offer['off']. ' % off today on orders over &pound; '.number_format($type_special_offer['pound'], 2);
										echo '</strong></div>';
									}
								?>
								<div class="fl-left note i b">
									<?php echo $res['type_notes'];?>
								</div>
								<div class="fl-right">
									<div class="review-Details" style="padding:0px;">
										<?php

											$Quality = 0;
											$Service = 0;
											$Value = 0;
											$Delivery = 0;

											$T_RATINGS = 0;
											$t_rating = 0;

											$query2 = "SELECT * FROM `rating` WHERE `r_rest_id` = '".$res['type_id']."'";
											$r1 = $obj -> query_db($query2);

											while($rating = $obj->fetch_db_assoc($r1)){
												$ratArr = json_decode($rating['r_details'], true);

												$Quality += $ratArr['Quality'];
												$Service += $ratArr['Service'];
												$Value += $ratArr['Value'];
												$Delivery += $ratArr['Delivery'];

												$T_RATINGS ++;
											}
											if($T_RATINGS != 0) {
												$Quality = round($Quality / $T_RATINGS);
												$Service = round($Service / $T_RATINGS);
												$Value = round($Value / $T_RATINGS);
												$Delivery = round($Delivery / $T_RATINGS);
											}

											if($T_RATINGS == 0) {

											$rat_str = '
												<div class="r-5_0"></div>
												<div class="r-5_0"></div>
												<div class="r-5_0"></div>
												<div class="r-5_0"></div>
											';
											} else {

												$t_rating = round(($Quality + $Service + $Value + $Delivery) / 4);

												$rat_str = '<div class="r-5_'.$Quality.'" title="Quality ('.$Quality.'/10)"></div>';
												$rat_str .= '<div class="r-5_'.$Service.'" title="Service ('.$Service.'/10)"></div>';
												$rat_str .= '<div class="r-5_'.$Value.'" title="Value ('.$Value.'/10)"></div>';
												$rat_str .= '<div class="r-5_'.$Delivery.'" title="Delivery ('.$Delivery.'/10)"></div>';

											}
										?>
										<div class="cbox-wrap" style="margin-bottom:2px">
										<?php
											echo ($t_rating == 0) ? '' : '<div class="fl-left" style="padding-top:3px;">Overall:&nbsp;</div><div class="rating fl-left"><div class="r-5_'.$t_rating.'" title="Overall Rating ('.$t_rating.'/10)"></div></div><div class="fl-left"  style="padding-top:3px;"></div>';
										?>
										<div class="clr"></div>
										</div>
										<div class="cbox-wrap">
											<div class="fl-left">
												<div style="padding-top:1px;">Quality:</div>
												<div style="padding-top:1px;">Service:</div>
												<div style="padding-top:1px;">Value:</div>
												<div style="padding-top:1px;">Delivery:</div>
											</div>
											<div class="fl-left">
												<div class="rating">
													<?php echo $rat_str; ?>
												</div>
											</div>
											<div class="clr"></div>
											<br />
											<?php
												echo ($T_RATINGS == 0) ? 'No Reviews Yet' : '<a href="reviews.php?id='.$res['type_id'].'/?iframe=true&amp;width=400&amp;height=500" rel="prettyPhoto" class="u">'.($T_RATINGS).' Reviews</a> ('.$t_rating.' Ratings)<br>';
											?>
										</div>
									</div>
								</div>
								<div class="clr"></div>
								<div class="btn-wrap">
									<?php
										$shopClosed = '';
										$LINK = 'menu-'.str_replace(' ', '-', $res['type_name']).'-'.$res['type_id'].'-'.$restaurant_postcode.'';

										if($isAvailable){
											echo '<div><a class="btn" title="Shop is Open" href="'.$LINK.'">View Menu and Order</a></div>';
											$shopClosed = 'Shop is Open';
										} else {
											echo '<div><a class="redbtn" title="Shop is Closed Now" href="'.$LINK.'">View Menu</a></div>';
											$shopClosed = 'Shop is Closed Now.';
										}
									?>
									<br><span class="i">(<?php echo $shopClosed; ?>)</span>
								</div>
							</li>
					<?php
							}
						}
					?>
					</ul>
				</div>
				<hr class="hr"/><br>
				<?php } ?>
			</div>
			<div class="clr"></div>
		</div>
	</div>
	<div class="footer">
		<?php require('templates/footer.php');?>
	</div>
</body>
</html>