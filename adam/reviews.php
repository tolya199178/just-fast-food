<?php
	session_start();
	if(!isset($_GET['id'])){
		echo '<h3>Error! Reviews Not Found</h3>';
		die();
	}
	
	include('include/functions.php');
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Reviews</title>	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="stylesheet" href="css/style.css" />

    <style>
        .fl-left {
            font-family: rockwellregular;
        }

    </style>
</head>

<body class="iframe-review">

	<div class="review-Details">
		<hr class="hr" />
		<ul>
		<?php
			$query1 = "SELECT * FROM `rating` WHERE `r_rest_id` = '".$_GET['id']."'  ORDER BY `r_date_added` DESC";
			$r = $obj -> query_db($query1);
			
			while($rating = $obj->fetch_db_assoc($r)){
		?>
			<li>
				<div class="name">
					<?php $phpdate = strtotime( $rating['r_date_added'] ); ?>
					<?php echo date("F j / Y   g:i a", $phpdate); ?>
					<br><span class="">Customer Said:</span>
				</div>
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
				<div class="fl-right message-details">
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
</body>
</html>