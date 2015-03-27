<?php
session_start();
if(!isset($_GET['p']) || empty($_GET['p'])) {
	die();
}

include ('functions.php');

getAddress($_GET['p']);
function getAddress($postcode) {
	$postcode = preg_replace('/\s+/', '', $postcode);
	$json = @file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$postcode.'&sensor=false');
	$json_output = json_decode($json, true);
	if($json_output['status'] == "OK") {
		foreach($json_output['results'] as $key => $value) {
			echo '<li>'.$value['formatted_address'].'</li>';
		}
	}
}
?>