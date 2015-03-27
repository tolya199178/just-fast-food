<?php
	session_start();
	$cat = "";
	$error = false;
	include_once('include/functions.php');

	if(!isset($_GET['category']) || !isset($_GET['catID']) || !isset($_GET['Postcode']) || !isset($_SESSION['DISTENCE'])) {
		header('location:index.php');
		die();
	} else {

		$cat = str_replace('-',' ', $_GET['category']);
		$select = "*";
		$from = '`categories`,`menu_type`';
		$where = "categories.type_id = ".$_GET['catID']." AND menu_type.type_id = ".$_GET['catID']." AND menu_type.type_name = '".$cat."' ORDER BY categories.category_name ASC";
		$query = 'SELECT '.$select.' FROM '.$from.' WHERE '.$where.'';

		$catvalue = $obj->query_db($query);

		if($obj-> num_rows($catvalue) < 1) {
			$error = true;
			header('location:index.php');
			die();
		} else {
			while($r = $obj->fetch_db_assoc($catvalue)) {
				$CATTEMP['category_name'] = $r['category_name'];
				$CATTEMP['category_id'] = $r['category_id'];
				$CATTEMP['category_img'] = $r['type_picture'];
				$CATTEMP['type_steps'] = $r['type_steps'];
				$CATTEMP['category_detail'] = $r['category_detail'];
				$CATTEMP['type_category'] = $r['type_category'];
				$_SESSION['type_min_order'] = $r['type_min_order'];
				$oph = json_decode($r['type_opening_hours'] ,true);
				$type_special_offer = json_decode($r['type_special_offer'] ,true);
				$CATARRAY[] = $CATTEMP;
			}
		}
	}
	
	if(!isset($_SESSION['delivery_type']['type'])) {
		$_SESSION['delivery_type'] = array();
		$_SESSION['delivery_type']['type'] = 'delivery';
		$_SESSION['delivery_type']['time']  = 'ASAP';
	}

	if(count($_POST)) {
		if(isset($_POST['delivery_type'])) {
			if($_SESSION['delivery_type']['type'] != $_POST['delivery_type']) {
				$_SESSION['delivery_type']['time'] = 'ASAP';
			} else {
				$_SESSION['delivery_type']['time'] = $_POST['delivery_best_time'];
			}
			$_SESSION['delivery_type']['type'] = $_POST['delivery_type'];
			
		}
	}
	$_SESSION['DELIVERY_CHARGES'] = $_SESSION['DISTENCE'][$_GET['catID']];
	$_SESSION['DELIVERY_REST_ID'] = $_GET['catID'];

	if(isset($_SESSION['DELIVERY_REST_ID_PREV']) && ($_SESSION['DELIVERY_REST_ID_PREV'] != $_SESSION['DELIVERY_REST_ID'])) {
		unset($_SESSION['CART']);
		unset($_SESSION['SPECIAL_OFFER']);
		$_SESSION['delivery_type']['type'] = 'delivery';
		$_SESSION['delivery_type']['time']  = 'ASAP';

	}
	$_SESSION['DELIVERY_CHARGES'] = getTotalDeliveryCharges($CATTEMP['type_steps'] ,$_SESSION['DELIVERY_REST_ID'] ,$_SESSION['DELIVERY_CHARGES']);
	$_SESSION['DELIVERY_REST_ID_PREV'] = $_SESSION['DELIVERY_REST_ID'];
	$_SESSION['CURRENT_MENU'] = str_replace(' ', '-', 'menu-'.$cat.'-'.$_SESSION['DELIVERY_REST_ID'].'-'.$_GET['Postcode']);
	$_SESSION['RESTAURANT_TYPE_CATEGORY'] = $CATTEMP['type_category'];


?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="images/favicon.ico">
	<title>Menu <?php echo $cat;?> | Just-FastFood</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/validate.js"></script>

	<script type="text/javascript">
		<?php
			if(!$error) {
				$c = "";
				foreach($CATARRAY as $result) {
					$c .=  '"'.str_replace(' ', '_',$result['category_name']).$result['category_id'].'" ,';
				}
				$c = substr($c, 0, -1);
				echo 'var category = ['.$c.'];';
			}
		?>
	</script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/jquery.stickyscroll.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.outercart-wrapper').stickyScroll({ container: '.explor .all-menu-items' });
		})
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
					<li class="u">Menu <?php echo $cat;?></li>
				</ul>
			</div>
			<?php include('include/notification.php');?>
			<!--<h1 class="heading">Menu <?php echo $cat;?></h1>-->
			<div class="MENU">
				<?php
					$query_location = $obj -> query_db("SELECT * FROM `location` WHERE `location_menu_id` = '".$_SESSION['DELIVERY_REST_ID']."'");
					$locationObj = $obj -> fetch_db_array($query_location);
				?>
				<div class="todayTime txt-right"><?php echo date("l, j F Y, G:i")?></div>
				<div class="box-wrap menu-details">
					<div class="fl-left img">
						<img src="items-pictures/<?php echo $CATTEMP['category_img'];?>" alt=""/>
					</div>
					<div class="fl-left details">
						<h1><?php echo $cat;?> <span><?php echo $locationObj['location_city'];?></span></h1>
						<strong>Opening hours</strong><br>
						<ul>
							<li class="i"><label for=""><?php echo date('l');?>:</label><?php echo  $oph[date('l')]['From'] . ' - ' .$oph[date('l')]['To']?></li>
							<li style="color:gray"><label for=""><?php echo date('l', time()+86400)?>:</label><?php echo  $oph[date('l', time()+86400)]['From'] . ' - ' .$oph[date('l')]['To']?></li>
						</ul>
						<a href="oph.php?id=<?php echo $_SESSION['DELIVERY_REST_ID']?>/?iframe=true&amp;width=300&amp;height=300" rel="prettyPhoto" class="showMore u"> View all opening times</a>
					</div>
					<div class="fl-right delivery-type">
						<form action="" method="post">
							<h2>Select menu:</h2>
							<select name="delivery_type" id="delivery_type">
								<option value="delivery">Delivery</option>
								<?php
									if($_SESSION['RESTAURANT_TYPE_CATEGORY'] != "fastfood") {
								?>
								<option value="collection" <?php echo  ($_SESSION['delivery_type']['type'] == 'collection') ? 'selected' : '' ?>>Collection</option>
								<?php
									}
								?>
							</select>
							
							<select name="delivery_best_time" id="delivery_best_time">
								<option value="<?php echo $_SESSION['delivery_type']['time']?>"><?php echo $_SESSION['delivery_type']['time']?></option>
								<option value="ASAP">ASAP</option>
								<?php
									for($i = 2 ; $i < 24 ; $i ++) {
										if(strtotime(date('H:i', strtotime(date('H:i').'+ '.($i*30).' minutes'))) <= strtotime($oph[date('l')]['To'])) {
								?>
									<option value="<?php echo date('H:i', strtotime(date('H:i').'+ '.($i*30).' minutes'));?>"><?php echo date('H:i', strtotime(date('H:i').'+ '.($i*30).' minutes'));?></option>
								<?php }
									}
								?>
							</select>
							
							<h4>Delivery Charges<span>&pound; <?php echo $_SESSION['DELIVERY_CHARGES'];?></span></h4>
							<script type="text/javascript">
								$(document).ready(function(){
									$('#delivery_type , #delivery_best_time').change(function(){
										$(this).parents('form').submit();
									})
								});
							</script>
						</form>
						<?php
							if($_SESSION['type_min_order'] > 0) {
						?>
							<span>Minimum Order Amount &pound;<?php echo $_SESSION['type_min_order'];?></span></h4>
						<?php } ?>
					</div>
					<div class="clr"></div>
					<?php
						if($type_special_offer != "") {
							echo '<div class="special-offer"><strong>';
							echo $type_special_offer['off']. ' % off today on orders over &pound; '.$type_special_offer['pound'];
							echo '</strong></div>';
							$_SESSION['SPECIAL_OFFER'] = $type_special_offer;
						}
					?>
				</div>
			</div>
			<hr class="hr"/>
			<div class="explor">
				<?php
				if(!$error) {
				?>
				<div class="find">
					<div class="fl-left">
						<span>Categories:</span>
						<span class="active"><input type="checkbox" name="all" checked="true"/>All</span> |
					</div>
					<div class="fl-left" style="width: 750px; margin-left: 3px;">
					<?php
						foreach($CATARRAY as $result) {
							echo '<span><input type="checkbox" name="'.str_replace(' ', '_',$result['category_name']).$result['category_id'].'"  />'.$result['category_name'].'</span>';
						}
					?>
					</div>
					<div class="clr"></div>
				</div>
				<div class="fl-left all-menu-items">
					<?php
						foreach($CATARRAY as $res) {
							$query = "SELECT * FROM `items` WHERE `category_id` = '".$res['category_id']."'";
							$itemsvalue = $obj->query_db($query);

					?>
					<div class="categories" id="<?php echo str_replace(' ', '_',$res['category_name']).$res['category_id']; ?>">
						<h2 class="subheading"><?php echo $res['category_name']; ?></h2>
						<?php
							if($res['category_detail'] != "") {
						?>
							<div style="padding: 0px 10px 10px 10px"><?php echo $res['category_detail'];?></div>
						<?php
							}
						?>
						<ul>
							<?php
								while($resultItems = $obj->fetch_db_array($itemsvalue)) {
							?>
							<li>
								<div class="whole-wrap">

									<div class="fl-left">
										<div class="text fl-left b"><?php echo $resultItems['item_name']?>
											<div class="span"><?php echo $resultItems['item_details']?>
												<?php if($resultItems['item_subitem_price'] > 0) {?>
													(<a href="javascript:;" rel="id<?php echo $resultItems['item_id']?>" class="addtoo u">Add Too</a>)
												<?php } ?>
											</div>
										</div>
										<span class="price b fl-left">&pound; <?php echo $resultItems['item_price']?></span>
									</div>
									<div class="adtocart fl-right">
										<form action="javascript:;">
											<input type="submit" value=" Add " class="btn order-button" id="id<?php echo $resultItems['item_id']?>"/>
										</form>
									</div>
									<div class="clr"></div>
								</div>
							</li>
							<?php
								}
							?>
						</ul>
					</div>
					<?php
						}
					} else {
						echo "Menu Items NOT available this time";
					}
					?>
				</div>
				<div class="fl-right">
					<div class="outercart-wrapper" style="position:relative"></div>
				</div>
				<div class="clr"></div>
			</div>

		</div>
	</div>
	<div class="footer">
		<?php require('templates/footer.php');?>
	</div>
</body>
</html>