<?php

	session_start();

	include('functions.php');



	if(isset($_POST['ID'])) {



		$select = "`order_status`";

		$where = "`order_id` = '".$_POST['ID']."'";

		$result = SELECT($select ,$where, 'orders', 'array');



		if($result['order_status'] == 'assign') {

			$return = 'true';

		} else if($result['order_status'] == 'cancel') {

			$return = 'cancel';

		} else {

			$return = 'false';

		}



		echo $return;



	} else {

		echo '

			<!DOCTYPE HTML>
			<html lang="en-US">
			<head>
				<meta charset="UTF-8">
				<title>Error!!!</title>

				<script type="text/javascript">

					setTimeout(function(){ window.location.href = "http://just-fastfood.com"} ,3000);

				</script>
			</head>
			<body>
				You Successfully HACKED our Site!


</body>
			</html>

		';

	}

?>