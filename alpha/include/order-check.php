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
			<script type="text/javascript">
adroll_adv_id = "JQVQA2EPTFBIVFRG4SDKBR";
adroll_pix_id = "O56HCPIZBJDYXNIE4XFZX2";
(function () {
var oldonload = window.onload;
window.onload = function(){
   __adroll_loaded=true;
   var scr = document.createElement("script");
   var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
   scr.setAttribute("async", "true");
   scr.type = "text/javascript";
   scr.src = host + "/j/roundtrip.js";
   ((document.getElementsByTagName("head") || [null])[0] ||
    document.getElementsByTagName("script")[0].parentNode).appendChild(scr);
   if(oldonload){oldonload()}};
}());
</script>

</body>
			</html>

		';

	}

?>