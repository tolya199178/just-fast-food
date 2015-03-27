<?php
	session_start();
	include('include/functions.php');
	/* echo '<pre>';
	print_r($_SESSION);
	echo '</pre>'; */
	$res_name = "Not Found";
	$error = false;
	if(!isset($_GET['name']) || !isset($_GET['cat']) || !isset($_GET['id'])) {
		$error = true;
	} else {

		$res_name = str_replace('-',' ',$_GET['name']) .' - '.str_replace('-',' ',$_GET['cat']);;

		$from = '`menu_type`';
		$where = "`type_id` = '".$_GET['id']."' AND `type_name` LIKE '".str_replace('-',' ',$_GET['name'])."'";
		$where = "`type_id` = '".$_GET['id']."'";
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
	<meta name="description" content="<?= $res_name.' '.$_GET['postcode'].', '.getDataFromTable('setting','meta'); ?>">
	<meta name="keywords" content="<?= $res_name.' '.$_GET['postcode'].', '.getDataFromTable('setting','keywords'); ?>">
	<meta name="author" content="M Awais">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="apple-touch-icon" href="items-pictures/default_rest_img.png">

	<link rel="shortcut icon" href="images/favicon.ico">
	<title><?php echo $res_name.' '.$_GET['postcode']; ?> | Just-FastFood</title>
    <!--CSS INCLUDES-->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,900' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
    <link href="css/archivist.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/responsivemobilemenu.css" type="text/css"/>
    <link href="css/media.css" rel="stylesheet">
    <link href="css/flexslider.css" rel="stylesheet">
    <link rel="stylesheet" href="css/square/blue.css" />
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.theme.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.9.0.min.js"></script>
    <style>
        .cart-header, 
        .order-header,
        .sign-in-header,
        .sign-up-header,
        .red-wrap h3,
        .red-wrap h2,
        .order-confirm,
         {
            display:block;
            text-transform: uppercase;
            padding: 10px 40px;
            background: #e74c3c;
            color:#fff;
            text-align: center;
            width:100%;
            margin-top:-4px;
            border-radius: 5px;
        }
        .panel {
        	overflow: hidden; 
        }
        .panel > h3.header {
            width: 97%;
            text-align: center;
        }
        .panel .m-header,
        .list-group-item.m-header {
            text-transform: uppercase;
            background: #e74c3c;
            color:#fff;
            text-align: center;
            font-size: 18px;    	
        }
    </style>
</head>
<body>
<div class="wrapper">
    <?php include('templates/header2.php'); ?>
    <div class="page_header">
         <div class="inner_title"><h2 class="text-center white">Find a <span>Takeaway</span> below</h2></div>
         <div class="custom_button yellow_btn small_but text-center ">
              <ul><li><a href="Postcode-<?php echo str_replace(' ','-',$_SESSION['CURRENT_POSTCODE']); ?>">Change Restaurant</a></li></ul>
         </div>
    </div>
    <div class="breadcrum">
        <ul>
            <li><a href="index.php">Begin Search</a></li>
            <li><a href="Postcode-<?php echo str_replace(' ','-',$_SESSION['CURRENT_POSTCODE']); ?>">Postcode-<?php echo $_SESSION['CURRENT_POSTCODE']; ?></a></li>
        </ul>
    </div>
    <?php include('include/notification.php');?>

    <div class="section_inner">
        <div class="container">
           <div class="col-md-12 explor">
                
	    		    <div class="col-md-7">

				            	<?php
				            		if($error){
				            			echo '<h3 class="heading">ERROR! Restaurant Not Found</h3>';
				            		} else {
				            	?>
				            	<div class="panel panel-default">
				            	    <h3 class="header"><?php echo $res_name; ?></h3> <hr class="hr">
                                    <div class="panel-body col-md-12">
                                        <div class="col-md-5">
				            	              	<img class="img-rounded" style="width:100%;" src="items-pictures/<?php echo $restaurant['type_picture'] ?>" />
				            	        		<?php
				            	        			$LINK = 'menu-'.str_replace(' ', '-', $restaurant['type_name']).'-'.$restaurant['type_id'].'-'.$_postcode.'';
				            	        		?>
				            	        		<a class="btn" style="color:#fff; margin-bottom:20px;" href="<?php echo $LINK;?>">Order Now</a>
				            	        	    <div class="fl-left notes"><?php echo $restaurant['type_notes'] ?></div>
                                        </div>
                                        <div class="cold-md-6">
                                        <div id="google_map" class="fl-right" style="width:300px; height:250px; border:1px solid #ddd"></div>
                                        </div>
                                    </div>
                                </div>
	<script type="text/javascript">
        var geocoder;
        var map;
        function initialize() {
          geocoder = new google.maps.Geocoder();
          var latlng = new google.maps.LatLng(-34.397, 150.644);
          var mapOptions = {
            zoom: 18,
            center: latlng
          }
          map = new google.maps.Map(document.getElementById("google_map"), mapOptions);
          codeAddress();
        }
        
        function codeAddress() {
          var address = '<?php echo $_GET['name'].' '.$_GET['postcode'];?>';
          geocoder.geocode( { 'address': address} , function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              map.setCenter(results[0].geometry.location);
              var marker = new google.maps.Marker({
                  map: map,
                  position: results[0].geometry.location
              });
            } else {
              alert('Geocode was not successful for the following reason: ' + status);
            }
          });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
	</script>
				            	<div class="panel panel-default">
				            	    <h3 class="header">Available Food from <?php echo $res_name; ?></h3><hr class="hr" />
				            	    <div class="panel-body col-md-12">
				            				<?php
				            					$query4 = "SELECT `category_id`,`category_name` FROM `categories` WHERE `type_id` = '".$_GET['id']."' AND `category_status` = 'active'";
				            					$c = $obj -> query_db($query4);
            
            				            					$string = '';
            				            					while($cat = $obj->fetch_db_assoc($c)){ 						
            				            						$query4_1 = "SELECT `item_name` FROM `items` WHERE `category_id` = '".$cat['category_id']."' AND `item_status` = 'active'";
            				            						$it = $obj -> query_db($query4_1);
            				            						$string .= '<ul class="list-group">';
            				            						$string .= '<li class="list-group-item m-header">'.$cat['category_name'].'</li>';
            				            						while($items = $obj->fetch_db_assoc($it)){
            				            							$string .= '
            				            								<li class="list-group-item">'.$items['item_name'].'</li>
            				            							';
            				            						}
            				            						$string .= '</ul>';
            				            						$string .='';
            				            					}
            				            					$string .= '';
				            					echo $string;
								            ?>
								    </div>
							    </div>

					    </div>
                    <!-- LEFT SIDE -->
	    	        <div class="col-md-4">
						<ul class="list-group">
							<li class="list-group-item m-header">Restaurant Category</li>
							<li class="list-group-item"><?php echo strtoupper($restaurant['type_category']);?></li>
					    </ul>
						<ul class="list-group">
							<li class="list-group-item m-header">Rating and Reviews</li>
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
							<li class="list-group-item">
							<?php
								echo ($T_RATINGS == 0) ? 'No Reviews Yet' : '<a href="reviews.php?id='.$restaurant['type_id'].'/?iframe=true&amp;width=400&amp;height=500" rel="prettyPhoto" class="u">'.($T_RATINGS).' Reviews</a> ('.$t_rating.' Ratings)<br>';
							?>
							</li>
							</ul>
							<!--<div class="cbox-wrap">
							<?php
								echo ($t_rating == 0) ? '' : '<div class="fl-left">Overall:&nbsp;</div><div class="rating fl-left"><div class="r-5_'.$t_rating.'" title="Overall Rating ('.$t_rating.'/10)"></div></div>';
							?>
							</div>-->
							<ul class="list-group">
								<li class="list-group-item">Quality:</li>
								<li class="list-group-item">Service:</li>
								<li class="list-group-item">Value:</li>
								<li class="list-group-item">Delivery:</li>
							</ul>
							<div class="fl-left">
								<div class="rating">
									<?php echo $rat_str; ?>
								</div>
							</div>

						    <ul class="list-group">
						    	<li class="list-group-item m-header">Opening Hours</li>
						    	<?php
						    		$oph = json_decode($restaurant['type_opening_hours'] ,true);
						    		foreach($oph as $day => $time) {
						    			echo '<li class="'.(($day == date('l')) ? 'cur b' : '').' list-group-item" title="'.(($day == date('l')) ? 'Today' : '').'">'.$day.' '.$time['From'].' - '.$time['To'].'</li>';
						    		}
						    	?>
					        </ul>
                            <ul class="list-group">
								<li class="list-group-item m-header">Users Reviews for <?php echo $res_name; ?></li>
								<?php
									$query1 = "SELECT * FROM `rating` WHERE `r_rest_id` = '".$_GET['id']."'  ORDER BY `r_date_added` DESC LIMIT 0,10";
									$r = $obj -> query_db($query1);

									while($rating = $obj->fetch_db_assoc($r)){
								?>
								<li class="list-group-item">
								        <div>Quality:</div>
								        <div>Service:</div>
								        <div>Value:</div>
								        <div>Delivery:</div>
									    <?php
									    	$rat = json_decode($rating['r_details'], true);
									    	echo '<div class="rating">';
									    	echo '<div class="r-5_'.$rat['Quality'].'" title="Quality ('.$rat['Quality'].'/10)"></div>';
									    	echo '<div class="r-5_'.$rat['Service'].'" title="Service ('.$rat['Service'].'/10)"></div>';
									    	echo '<div class="r-5_'.$rat['Value'].'" title="Value ('.$rat['Value'].'/10)"></div>';
									    	echo '<div class="r-5_'.$rat['Delivery'].'" title="Delivery ('.$rat['Delivery'].'/10)"></div>';
									    	echo '</div>';
									    ?>
									    <div class=" message-details" style="margin-top:10px;">
									    	<div class="name">
									    		<?php $phpdate = strtotime( $rating['r_date_added'] ); ?>
									    		<?php echo date("F j / Y   g:i a", $phpdate); ?>
									    		<br><span class="">Customer Said:</span>
									    	</div>
									    		<?php echo ($rating['r_message'] != '') ? '"'.$rating['r_message'].'"' : ''; ?>
									    </div>
								</li>
								<?php
									}
									if(!count($rating)) {
										echo '<li class="list-group-item"><h2>No Reviews Yet</h2></li>';
									}
								?>
								</ul>
							</div>
						</div>
					</div>
	    	        </div>
					<?php
						}
					?>	    	        
	        </div>
	    </div>
    </div>
</div>
	<div class="footer">
		<?php require('templates/footer2.php');?>
	</div>
</body>
</html>
