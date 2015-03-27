<?php
	session_start();
	include('include/functions.php');

	$res_name = "Not Found";
	$error = false;
	if(!isset($_GET['name']) || !isset($_GET['cat']) || !isset($_GET['id'])) {
		$error = true;
	} else {

		$res_name = str_replace('-',' ',$_GET['name']) .' - '.str_replace('-',' ',$_GET['cat']);;

		$from = '`menu_type`';
		$where = "`type_id` = '".$_GET['id']."' AND `type_name` LIKE '".str_replace('-',' ',$_GET['name'])."'";
		$query = 'SELECT * FROM '.$from.' WHERE '.$where.'';

		$catvalue = $obj->query_db($query);

		if($obj-> num_rows($catvalue) < 1) {
			$error = true;
			$res_name = "Restaurant Not Found";
		} else {
			$restaurant = $obj->fetch_db_assoc($catvalue);
		}
		
		$_postcode = $_GET['postcode'];
		
	}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="images/favicon.ico">
	<title><?php echo $res_name.' '.$_GET['postcode']; ?> | Just-FastFood</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="admin/css/timepicker.css"  />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/validate.js"></script>
	<link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
	<script src="js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&region=GB"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("a[rel^='prettyPhoto']").prettyPhoto();
		});

		var geocoder;
		var map;

		function initialize() {
			geocoder = new google.maps.Geocoder();
			var myOptions = {
				zoom: 18,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
			map = new google.maps.Map(document.getElementById("google_map"), myOptions);

			setTimeout(showMap ,500);
		}

		function showMap() {

			var address = '<?php echo $_GET['name'].' '.$_GET['postcode'];?>';
			geocoder.geocode({
				'address': address
			}, function (results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					map.setCenter(results[0].geometry.location);
					var marker = new google.maps.Marker({
						map: map,
						position: results[0].geometry.location
					});
				} else {
					alert("Geocode was not successful for the following reason: " + status);
				}
			});
		}
		window.onload = initialize;
	</script>

</head>
<body>
	<div class="header">
		<?php require('templates/header.php');?>
	</div>
	<div class="content">
		<div class="wrapper ">
			<div class="breadcrum">
				<ul>
					<li><a href="index.php">Begin Search</a></li>
					<li><a href="Postcode-<?php echo str_replace(' ','-',$_postcode); ?>" class="u">Postcode-<?php echo str_replace('-',' ',$_postcode); ?></a></li>
				</ul>
			</div>
			<h1 class="heading" style="display:none"><?php echo $res_name; ?></h1>
			<hr class="hr"/>
			<div class="explor box-wrap no-padding">
				<div class="by-card b txt-center" style="color:#000;"><?php echo $res_name; ?></div>
				<div class="restaurant-container" style="display:block">
					<?php
						if($error){
							echo '<h3 class="heading">ERROR! Restaurant Not Found</h3>';
						} else {
					?>
					<div class="leftCol fl-left">
							<div class="rest-details">
								<div class="fl-left">
									<img src="items-pictures/<?php echo $restaurant['type_picture'] ?>" alt="" class=""/><br><br>
									<?php
										$LINK = 'menu-'.str_replace(' ', '-', $restaurant['type_name']).'-'.$restaurant['type_id'].'-'.$_postcode.'';
									?>
									<a class="btn" href="<?php echo $LINK;?>">Order Now</a>
								</div>
								<div class="fl-left  notes"><?php echo $restaurant['type_notes'] ?></div>
								<div id="google_map" class="fl-right" style="width:260px; height:250px; border:1px solid #ddd"></div>
								<div class="clr"></div>
							</div>
							<div class="available-foods rest-details">
								<h3>Available Food from <?php echo $res_name; ?></h3><hr class="hr" />
								<?php
									$query4 = "SELECT `category_id`,`category_name` FROM `categories` WHERE `type_id` = '".$_GET['id']."' AND `category_status` = 'active'";
									$c = $obj -> query_db($query4);

									$string = '<ul>';
									while($cat = $obj->fetch_db_assoc($c)){
										$string .='
											<li><span class="b">'.$cat['category_name'].'</span>
										';
										$query4_1 = "SELECT `item_name` FROM `items` WHERE `category_id` = '".$cat['category_id']."' AND `item_status` = 'active'";
										$it = $obj -> query_db($query4_1);
										$string .= '<ul>';
										while($items = $obj->fetch_db_assoc($it)){
											$string .= '
												<li>'.$items['item_name'].'</li>
											';
										}
										$string .= '</ul>';
										$string .='</li>';
									}
									$string .= '</ul>';
									echo $string;
								?>
							</div>
							<hr class="hr" />
							
					</div>
					<div class="rightCol fl-right">
						<div class="cbox-wrap">
							<h4>Restaurant Category</h4>
							<p>&nbsp;</p>
							<p class="txt-right b"><?php echo strtoupper($restaurant['type_category']);?></p>
						</div>
						<div class="box-wrap">
							<h4>Rating and Reviews</h4><br>
							<div class="review-Details">
							<?php

								$Quality = 0;
								$Service = 0;
								$Value = 0;
								$Delivery = 0;

								$T_RATINGS = 0;
								$t_rating = 0;

								$query2 = "SELECT * FROM `rating` WHERE `r_rest_id` = '".$_GET['id']."'";
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
							<div class="cbox-wrap">
							<?php
								echo ($t_rating == 0) ? '' : '<div class="fl-left">Overall:&nbsp;</div><div class="rating fl-left"><div class="r-5_'.$t_rating.'" title="Overall Rating ('.$t_rating.'/10)"></div></div>';
							?>
							<div class="clr"></div>
							</div>
							<br />
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
							<p></p>
							<?php
								echo ($T_RATINGS == 0) ? 'No Reviews Yet' : '<a href="reviews.php?id='.$restaurant['type_id'].'/?iframe=true&amp;width=400&amp;height=500" rel="prettyPhoto" class="u">'.($T_RATINGS).' Reviews</a> ('.$t_rating.' Ratings)<br>';
							?>
							</div>
						</div>
						<div class="cbox-wrap oph">
							<h4 class="">Opening Hours</h4>
							<ul>
							<?php
								$oph = json_decode($restaurant['type_opening_hours'] ,true);
								foreach($oph as $day => $time) {
									echo '<li class="'.(($day == date('l')) ? 'cur b' : '').'" title="'.(($day == date('l')) ? 'Today' : '').'"><label for="">'.$day.'</label> '.$time['From'].' - '.$time['To'].'</li>';
								}
							?>
							</ul>
						</div>
						<div class="box-wrap">
							<div class="review-Details">
								<h4>Users Reviews for <?php echo $res_name; ?></h4>
								<hr class="hr" />
								<ul>
								<?php
									$query1 = "SELECT * FROM `rating` WHERE `r_rest_id` = '".$_GET['id']."'  ORDER BY `r_date_added` DESC LIMIT 0,10";
									$r = $obj -> query_db($query1);

									while($rating = $obj->fetch_db_assoc($r)){
								?>
									<li>
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
										<div class=" message-details" style="margin-top:10px;">
											<div class="name">
												<?php $phpdate = strtotime( $rating['r_date_added'] ); ?>
												<?php echo date("F j / Y   g:i a", $phpdate); ?>
												<br><span class="">Customer Said:</span>
											</div>
											<div class="message">
												<?php echo ($rating['r_message'] != '') ? '"'.$rating['r_message'].'"' : ''; ?>
											</div>
										</div>
										<div class="clr"></div>
									</li>
								<?php
									}
									if(!count($rating)) {
										echo '<li><h2>No Reviews Yet</h2></li>';
									}
								?>
								</ul>
							</div>
						</div>
					</div>
					<div class="clr"></div>
					<?php
						}
					?>
				</div>

			</div>

		</div>
	</div>
	<div class="footer">
		<?php require('templates/footer.php');?>
	</div>
</body>
</html>
