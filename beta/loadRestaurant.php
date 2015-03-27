<?php
	session_start();
	
	if(!isset($_GET['postcode']) || !isset($_GET['id']) || !isset($_GET['name']) || !isset($_GET['cat'])){
		header('Location:index.php');
		die();
	}
	
	$postcode = $_GET['postcode'];
	$postcode_ = $postcode;
	$rest_id = $_GET['id'];
	$name = str_replace(' ', '-' , $_GET['name']);
	$cat = str_replace(' ', '-' , $_GET['cat']);
	
	include('include/functions.php');
	$postcode = str_replace('-',' ' ,$postcode);
	
	$json_post = getEandN($postcode);
	if($json_post) {
		$restArray = getCloserRest($json_post, $postcode);
		
		foreach($restArray['array'] as $restName => $dist) {
			
			$ar = explode('-' , $restName);
			
			if($ar[0] == $rest_id){
				$_SESSION['CURRENT_POSTCODE'] = strtoupper($postcode);
				setC('postcode',$_SESSION['CURRENT_POSTCODE']);
				$postcode = str_replace(' ', '-' , $ar[1]);
				$_SESSION['DISTENCE'][$rest_id] = $dist;
				header('Location:restaurant-'.$name.'-'.$cat.'-'.$rest_id.'-'.$postcode);
				break;
				die();
			}
		}
	} else {
		header('location:Postcode-'.$postcode_);
	}
	
?>