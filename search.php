<?php
	session_start();

	$error = false;
	if(isset($_GET['q'])) {
		include('include/functions.php');
		$itemName = str_replace('-',' ',$_GET['q']);

	} else {
		$error = true;
	}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>MackyDee's</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />
	<script type="text/javascript" src="js/jquery.js"></script>

	<script type="text/javascript" src="js/script.js"></script>
</head>
<body>
	<div class="header">
		<?php require('templates/header.php');?>
	</div>
	<div class="content">
		<div class="wrapper ">
			<div class="search-wrap">
				<form action="">
					<!--<label for="search" class="i">Search MackyDee's:</label>-->
					<input type="text" name="" id="search" class="text i" placeholder="Search"/>
					<input type="button" value="Search" class="btn"/>
				</form>
			</div>
			<h1 class="heading">Search Result For : <?php echo $itemName;?></h1>
			<hr class="hr"/>
			<div class="explor">
				<?php
					if(!$error) {
						$query0_1 = "SELECT `category_id` FROM `categories` WHERE `type_id` = '".$_SESSION['DELIVERY_REST_ID']."'";
						$itemsvalue0_1 = $obj->query_db($query0_1);
						while($resultItems0_1 = $obj->fetch_db_array($itemsvalue0_1)) {
							$catInArr[] = $resultItems0_1['category_id'];
						}

						$IN = implode(',', $catInArr);

						$query = "SELECT * FROM  `items` WHERE  `category_id` IN ( ".$IN." ) AND  `item_name` LIKE  '%".$itemName."%'";
						$itemsvalue = $obj->query_db($query);
						if($obj -> num_rows($itemsvalue) > 0) {
				?>
				<div class="categories">
					<ul>
						<?php
							while($resultItems = $obj->fetch_db_array($itemsvalue)) {
						?>
						<li>
							<div class="whole-wrap">
								<img src="items-pictures/<?php echo $resultItems['item_picture']?>" alt="<?php echo $resultItems['item_name']?>" title="<?php echo $resultItems['item_name']?>"/>
								<div>
									<span class="text"><?php echo $resultItems['item_name']?></span>
									<span class="price">&pound; <?php echo $resultItems['item_price']?></span>
								</div>
								<div class="adtocart">
									<form action="javascript:;">
										<input type="text" name="" id="id<?php echo $resultItems['item_id']?>" class="text" value="1"/>
										<input type="submit" value="Order" class="button order-button" />
									</form>
								</div>
							</div>
						</li>
						<?php
							}
						?>
					</ul>
				</div>
				<?php
						} else {
							echo '<h3>No Result Found</h3>';
						}
					} else {
						echo '<h3>No Result Found</h3>';
					}
				?>
			</div>

		</div>
	</div>
	<div class="footer">
		<?php require('templates/footer.php');?>
	</div>
</body>
</html>