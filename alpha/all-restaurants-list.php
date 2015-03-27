<?php
	session_start();
	include("include/functions.php");
	
	
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">	<link rel="shortcut icon" href="images/favicon.ico">
	<title>Just-FastFood | Terms and Condition</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />

	<style type="text/css">
		.box-wrap{
			font-size:13px;
			font-family: segoe ui, arial, helvetica, sans-serif;
			color: #222;
		}
		.box-wrap h3{
			margin:5px 0px 10px 0px;
		}
		.box-wrap strong{
			font-size:12px;
		}
		.box-wrap a{
			text-decoration:underline;
			color:#D62725;
		}
		.box-wrap ul{
			margin-left:20px;
		}
	</style>

</head>
<body>
	<div class=" box-wrap" style="margin:20px; ">


		<h1 class="subheading">Registered Restaurants</h1><hr>
		<p>
			<ul>
			<?php
				$query = "SELECT `type_name` FROM `menu_type`";
				$valueOBJ = $obj->query_db($query);
				while($res = $obj->fetch_db_array($valueOBJ)) {
					echo '<li>'.$res['type_name'].'</li>';
				}
			?>
			</ul>
		</p>

	</div>


</body>
</html>