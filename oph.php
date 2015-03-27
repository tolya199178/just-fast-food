<?php

	include('include/functions.php');
	
	$query = "SELECT `type_opening_hours` FROM `menu_type` WHERE `type_id` = '".$_GET['id']."'";

	$catvalue = $obj->query_db($query);
	$restaurant = $obj->fetch_db_assoc($catvalue);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="images/favicon.ico">
	<title>Opening Hours</title>
	<link rel="stylesheet" href="css/style.css" />
</head>
<body>
	<div class="restaurant-container"><br>
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
	</div>
</body>
</html>