<?php
/* session_start();
include ('functions.php');
//$ar = getEandN('po5 4py');
echo getAddress('40100');
function getAddress($postcode) {
	$postcode = preg_replace('/\s+/', '', $postcode);
	$json = @file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$postcode.'&sensor=false');
	$json_output = json_decode($json, true);
	if($json_output['status'] == "OK") {
		foreach($json_output['results'] as $key => $value) {
			echo $value['formatted_address'].'<br>';
		}
	}
} */
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title></title>
	<style type="text/css">
	ul,li{
		margin:0px;
		padding:0px;
		list-style-type:none;
	}
	.row {
		padding-bottom: 10px;
		position: relative;
	}
	.autocomplete{
		position:absolute;
		left: 150px;
		top: 25px;
		max-width: 400px;
		background:#fff;
		font-size:12px;
	}
	.autocomplete div{
		border:1px solid #ddd;
		display:none;
		padding:3px;
	}
	.autocomplete div li{
		cursor:pointer;
		padding-bottom:3px;
	}
	.autocomplete div li:hover{
		text-decoration:underline;
	}
	</style>
	<script type="text/javascript" src="../js/jquery.js"></script>
	<link rel="stylesheet" href="../css/style.css">
	<script type="text/javascript">
		$(document).ready(function(){
			$('.autocomplete li').live('click',function(){
				$('#signupForm').find('#user_address').val($(this).text());
				$('.autocomplete div').hide();
			});
			$('#user_postcode').live('keyup',function(){
				if($(this).val() == "")
					return false;
				$.ajax({
					url: "loadAddr.php",
					type: "get",
					data: {p : $(this).val()},
					success: function(data){
						$('.autocomplete div').show();
						$('.autocomplete ul').html(data);
					}
				});
			});
		});
	</script>
</head>
<body>
	<form action="" class="sign-up-wrap" id="signupForm">
		<div class="row">
			<label for="user_address">Address<span>*</span></label><input type="text" name="user_address" id="user_address" class="input required" value="">
		</div>
		<div class="row">
			<label for="user_postcode">Post Code<span>*</span></label><input type="text" name="user_post_code" id="user_postcode" class="input required postcode" value="">
			<div class="autocomplete">
				<div>
					<ul></ul>
				</div>
			</div>
		</div>
	</form>
</body>
</html>
