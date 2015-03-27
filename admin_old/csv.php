<?php
	require_once('include/auth.php');
	//include("include/AL postcodes.php");
	include("../include/functions.php");

	//print_r($array['AL5 2AR']);
	$files = array('AB','AL','B');
	
	//echo count($files);
	$i = $_GET['i'];
	//for($i = $j; $i < $j; $i ++) {
		$array = csv_to_array('include/csv/'.$files[$i].' postcodes.csv');
		$str =  '<?php$'.$files[$i].'postcodes=array(';
		foreach($array as $key => $value){
			$str .= '"'.$value['Postcode'].'"=>array(
						"Latitude"=>"'.$value['Latitude'].'",
						"Longitude"=>"'.$value['Longitude'].'",
						"Easting"=>"'.$value['Easting'].'",
						"Northing"=>"'.$value['Northing'].'"
			),';
		}
		$str = substr($str,0,-1);
		$str .= ');?>';
		$str = preg_replace('/\s+/', '', $str);
		//print($str);
		$fp = fopen("include/php/text/".$files[$i]."postcode.txt", "w");
		fwrite($fp, $str);
		fflush($fp);
		fclose($fp);
	//}
	echo $i.'<br>';
	echo $files[$i].'<br>';
	echo '<a href="csv?i='.($i+1).'">GO'.($i+1).'</a>';
	//echo calcDis('AL10 9ER' ,'AL1 1AE',$array);
	/* function calcDis($orig ,$dest ,$array) {
		$N1 = $array[$orig]['Northing'];
		$N2 = $array[$dest]['Northing'];

		$E1 = $array[$orig]['Easting'];
		$E2 = $array[$dest]['Easting'];

		return round((sqrt(($N1-$N2)*($N1-$N2)+($E1-$E2)*($E1-$E2))/1000)/1.6093 , 3);
	}

	calcMinDis('AL10 9ER', $array);
	function calcMinDis($p1 ,$array) {
		foreach($array as $key => $val) {
			if($p1 != $key) {
				$ar[$key] = calcDis($p1, $key ,$array);
			}
		}
		//print_r($ar);
		asort($ar);
		echo '<pre>';
		print_r($ar);
		echo '</pre>';

	} */


?>