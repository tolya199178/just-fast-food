<?php



	require("dbclass.php");

	$obj = new database();

	define ("MAX_SIZE","1000");

	date_default_timezone_set('Europe/London');




	function SELECT($SELECT, $WHERE, $TABLE, $CALLBACK) {

		global $obj;

		$RETURN = "";

		$query = "SELECT ".$SELECT." FROM `".$TABLE."` WHERE ".$WHERE."";

		echo $query;

		$value = $obj->query_db($query);

		$res = $obj->fetch_db_assoc($value);



		switch ($CALLBACK) {

			case 'array':

				if ($res > 0) {

					$RETURN = $res;

				} else {

					$RETURN = false;

				}

				break;



			case 'bool' :

				if ($res > 0) {

					$RETURN = true;

				} else {

					$RETURN = false;

				}

				break;



			case 'numrows' :

				$RETURN = $obj -> num_rows($value);

				break;



			default:

				$RETURN = "ERROR!".mysql_error();

		}



		return $RETURN;

	}



	function INSERT($value ,$table ,$callback ,$extra) {

		global $obj;

		$RETURN = "";

		$column = $obj -> show_column_names(''.$table.'');

       // var_dump($column);
		$query = "INSERT INTO `".$table."` (" . $column . ") VALUES( " . $value . ")";

	    // echo $query;

		switch($callback) {

			case false:

				$value = $obj->query_db($query);

				if($value) {

					$RETURN = true;

				} else {

					$RETURN = "ERROR!".mysql_error();

				}

				break;

			case 'unique':

				if(!SELECT('*', $extra, $table, 'bool')) {

					$value = $obj->query_db($query);

					if($value) {

						$RETURN = true;

					} else {

						$RETURN = "ERROR!".mysql_error();

					}

				} else {

					#$RETURN = false;
					$RETURN = mysql_error();

				}

				break;

			case 'id':

				$value = $obj->query_db($query);

				if($value) {

					$RETURN = true;

				} else {

					$RETURN = "ERROR!".mysql_error();

				}

				$RETURN = $obj -> id_db();

				break;

			default:

				$RETURN = "ERROR!".mysql_error();

		}



		return $RETURN;

	}



	function getRealIpAddr() {

		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet

			$ip=$_SERVER['HTTP_CLIENT_IP'];

		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  //to check ip is pass from proxy

			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];

		} else{

			$ip=$_SERVER['REMOTE_ADDR'];

		}



		return $ip;

	}



	function singleFileUpload ($FILES , $name) {

		$imageName = '';

		 $errors=0;

		 $msg = "";

		 $image=$FILES[$name]['name'];

		if ($image) {

			 $filename = stripslashes($FILES[$name]['name']);

			 $extension = getExtension($filename);

			 $extension = strtolower($extension);

			 if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {

				$msg = 'Unknown Image Extension!';

				$errors=1;

			 } else {

				 $size=filesize($FILES[$name]['tmp_name']);



				if ($size > MAX_SIZE*1024){

					$msg = 'You have exceeded the size limit!';

					$errors=1;

				} else {

					$image_name= 'item_'.time().'.'.$extension;

					$newname="../items-pictures/".$image_name;

					$copied = copy($FILES[$name]['tmp_name'], $newname);

					if (!$copied){

						$errors=1;

						$msg = 'Image Not Upload!!';

					} else {

						$imageName = $image_name;

					}

				}

			 }

		}

		$RETURN = array('error' => $errors , 'img_name' => $imageName , 'msg' => $msg);

		return $RETURN;

	}



	 function getExtension($str) {

		 $i = strrpos($str,".");

		 if (!$i) { return ""; }

		 $l = strlen($str) - $i;

		 $ext = substr($str,$i+1,$l);

		 return $ext;

	}



	function getMatrix($orig ,$dest) {

		$json = @file_get_contents('http://maps.googleapis.com/maps/api/distancematrix/json?origins='.$orig.'&destinations='.$dest.'&mode=bicycling&language=en-EN&sensor=false');

		$json_output = json_decode($json, true);

		$RETURN['error'] = 'false';

		$RETURN['output'] = '';



		$_dest = explode('|', $dest);



		if($json_output['status'] == "OK") {

			$rows = $json_output['rows'];

			foreach($rows as $elements){

				foreach($elements as $key_elements => $value_elements){

					foreach($value_elements as $key_val_elements => $value_val_elements){

						if($value_val_elements['status'] == 'OK'){

							$RETURN['output'][$_dest[$key_val_elements]] = round(($value_val_elements['distance']['value'] /1000) * 0.621371 , 2);

						} else {

							if($key_val_elements == 0){

								$RETURN['error'] = "true";

								break;

							}

							$RETURN['output'][] = $value_val_elements['status'];

						}

					}

				}

			}

		} else {

			$RETURN['error'] = $json_output['status'];



			$message = "<h1>Just-FastFood</h1><hr/><br/>";

			$message .= "This is automated Email Receive From Just-FastFood.com<br/><br/>";

			$message .= "Notification for : ".$RETURN['error']."  | Google Matrix API<br>";

			$message .= "Calculation redirect to own method. For more details see : <a href='https://developers.google.com/maps/documentation/distancematrix/#DirectionsResponseElements'>https://developers.google.com/maps/documentation/distancematrix/#DirectionsResponseElements</a>";



			$to = admin_email();

			$subject = $RETURN['error']."  | Google Matrix API";

			$headers = "From:Just-FastFood <admin@just-fastfood.com>\r\n";

			$headers .= 'MIME-Version: 1.0' . "\r\n";

			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";



			//mail($to, $subject, $message, $headers);

		}



		if($RETURN['error'] == 'false'){

			$RETURN['orig_add'] = $json_output['origin_addresses'][0];

		}

		return $RETURN;

	}



	function csv_to_array($filename='', $delimiter=','){

		//if(!file_exists($filename) || !is_readable($filename))

		//	return FALSE;

		ini_set("allow_url_fopen", 1);

		$header = NULL;

		$data = array();

		if (($handle = fopen($filename, 'r')) !== FALSE)

		{

			while (($row = fgetcsv($handle, 1024, $delimiter)) !== FALSE)

			{

				if(!$header)

					$header = $row;

				else

					$data[] = array_combine($header, $row);

			}

			fclose($handle);

		}

		return $data;

	}



	function calcDistance($N1 ,$N2 ,$E1 ,$E2) {

		return round(sqrt(($N1-$N2)*($N1-$N2)+($E1-$E2)*($E1-$E2))/1000 , 3);

	}



	function calcMinDis($array) {

		asort($array);



		$_SESSION['TO_STAFF_ORDER_ARRAY'] = $array;



		foreach($array as $key => $value) {

			$return[$key] = $value;

			break;

		}

		return $return;

	}



	function getEandN($postcode) {

		$postcode = str_replace(' ' ,'%20' ,$postcode);

		 $array = csv_to_array('http://www.doogal.co.uk/UKPostcodesCSV.php?Search='.$postcode.'');

		if(count($array)){

			foreach($array as $value) {

				$ar['E'] = $value['Easting'];

				$ar['N'] = $value['Northing'];

				break;

			}

		} else {

			$ar = false;

		}

		return $ar;

	}


  function getStaffOrder($staff_id) {

    global $obj;
    $res = array();

    $query = $obj->query_db("SELECT * FROM `staff_order` WHERE `staff_order_staff_id` = '".$staff_id."' AND `staff_order_status` = 'assign'");
    while($result = $obj->fetch_db_array($query)) {
      $fetched = json_decode($result['staff_order_order_id'], true);
      $res[] = explode(" ", $fetched);
    }
    return $res;
  }

	function toStaffId($EandN ,$postcode){

		global $obj;


		$query = $obj -> query_db("SELECT * FROM `staff` WHERE `staff_status` = 'active'");

		while($result = $obj -> fetch_db_array($query)){

			$fetchres = json_decode($result['staff_postcode'] , true);

			$GUYPOST[$result['staff_id']] = $fetchres;

			$fetchres_postcode[] = str_replace(' ', '',key($fetchres));

		}

		$fetch_postcode = implode('|', $fetchres_postcode);

		$google_result = getMatrix(str_replace(' ', '',$postcode), $fetch_postcode);

		$isResultFromGoogle = true;

		if($google_result['error'] == 'false'){

			$i = 0;

			foreach($GUYPOST as $k => $v){

					$array[$k] = $google_result['output'][$fetchres_postcode[$i]];

					$i ++;

			}

		} else {

			foreach($GUYPOST as $k => $v){

				foreach($v as $key => $value){

					$array[$k] = calcDistance($value['N'] ,$EandN['N'] ,$value['E'] ,$EandN['E']);

				}

			}

		}

		asort($array);

		//$narray = calcMinDis($array);

		$RETURN_ID = 'false';

		$nowTime = strtotime(date('H:i'));
		foreach($array as $id => $distence) {

			$detail = getOneStaffDetail($id ,array('staff_max_distence', 'staff_available_time'));

			$detail_time = json_decode(stripslashes($detail['staff_available_time']), true);


			if(($distence <= $detail['staff_max_distence']) && ($nowTime >= strtotime($detail_time[date('l')]['From']) && $nowTime <= strtotime($detail_time[date('l')]['To']))){

				$RETURN_ID = $id;

				break;

			}
      if($nowTime <= strtotime($detail_time[date('l')]['From'])) {
        $RETURN_ID = 'Early '.strtotime($detail_time[date('l')]['From']);
        break;
      } else if ($nowTime >= strtotime($detail_time[date('l')]['To'])) {
        $RETURN_ID = 'Late '.strtotime($detail_time[date('l')]['To']);
        break;
      }


		}

		return $RETURN_ID;

	}



	function getOneStaffDetail($id, $col) {

		global $obj;



		$columns = "";



		foreach($col as $val) {

			$columns .= "`".$val."` ,";

		}



		$columns = substr($columns , 0, -1);

		$query = $obj -> query_db("SELECT ".$columns." FROM `staff` WHERE `staff_id` = '".$id."' AND `staff_status` = 'active'");

		$result = $obj -> fetch_db_assoc($query);

		return $result;

	}



	function getMilesFromRest($postcode) {

		global $obj;



		$query = $obj -> query_db("SELECT * FROM `location` WHERE `location_status` = 'active'");

		while($result = $obj -> fetch_db_assoc($query)){

			$GUYPOST[] = json_decode($result['location_postcode'] , true);

		}



		foreach($GUYPOST as $k => $v){

			foreach($v as $key => $value){

				$array[$k] = calcDistance($value['N'] ,$postcode['N'] ,$value['E'] ,$postcode['E']);

			}

		}



		$narray = calcMinDis($array);







		foreach($narray as $mind){

			$RETURN = $mind;

			break;

		}

		return $mind;

	}



	function getCloserRest($EandN, $postcode) {

		global $obj;



		$query = $obj -> query_db("SELECT DISTINCT `location_menu_id`,`location_postcode`,`location_id` FROM `location` WHERE `location_status` = 'active'");

		while($result = $obj -> fetch_db_array($query)){

			$fetchres = json_decode($result['location_postcode'] , true);

			$GUYPOST[$result['location_menu_id'].'-'.key($fetchres).'-'.$result['location_id']] = $fetchres;

			$fetchres_postcode[] = str_replace(' ', '',key($fetchres));

		}



		$fetch_postcode = implode('|', $fetchres_postcode);

		$google_result = getMatrix(str_replace(' ', '',$postcode), $fetch_postcode);



		$isResultFromGoogle = true;

		if($google_result['error'] == 'false'){

			$i = 0;

			foreach($GUYPOST as $k => $v){

					$array[$k] = $google_result['output'][$fetchres_postcode[$i]];

					$i ++;

			}

		} else {

			foreach($GUYPOST as $k => $v){

				foreach($v as $key => $value){

					$array[$k] = calcDistance($value['N'] ,$EandN['N'] ,$value['E'] ,$EandN['E']);

				}

			}

			$isResultFromGoogle = false;

		}



		asort($array);



		$minRestDistence = minRestDis();



		$RETURNARRAY = array();

		$RETURNARRAY['array'] = array();

		foreach($array as $thisid => $rest){

			if($rest > $minRestDistence){

				break;

			} else {

				$RETURNARRAY['array'][$thisid] = $rest;

			}

		}



		asort($RETURNARRAY['array']);

		if($isResultFromGoogle){

			$RETURNARRAY['address'] = $google_result['orig_add'];

		}

		return $RETURNARRAY;

	}



	function getDistTwoPost($from, $to) {

		$_post1 = getEandN($from);

		$_post2 = getEandN($to);



		return calcDistance($_post1['N'] ,$_post2['N'] ,$_post1['E'] ,$_post2['E']);

	}



	function delivery_charges($id) {

		global $obj;



		$query = $obj -> query_db("SELECT `type_charges` FROM `menu_type` WHERE `type_id` = '".$id."'");

		$result = $obj -> fetch_db_assoc($query);

		return $result['type_charges'];

	}



	function minRestDis() {

		global $obj;



		$query = $obj -> query_db("SELECT `min_rest_distence` FROM `setting`");

		$result = $obj -> fetch_db_assoc($query);

		return $result['min_rest_distence'];

	}



	function admin_email(){

		global $obj;



		$query5 = $obj -> query_db("SELECT `admin_email` FROM `setting`");

		$res5 = $obj->fetch_db_assoc($query5);



		return $res5['admin_email'];

	}



	function process_fee(){

		global $obj;



		$query5 = $obj -> query_db("SELECT `process_fee` FROM `setting`");

		$res5 = $obj->fetch_db_assoc($query5);



		return number_format($res5['process_fee'],2);

	}



	function cash_verification_fee(){

		global $obj;



		$query5 = $obj -> query_db("SELECT `cash_verification_fee` FROM `setting`");

		$res5 = $obj->fetch_db_assoc($query5);



		return number_format($res5['cash_verification_fee'],2);

	}



	function user_verified_cash($details, $id){

		global $obj;



		$data['verifired'] = (!empty($details)) ? 'true' : 'false';

		$data['details'] = $details;



		$q = "UPDATE `user` SET `user_verified` = '".json_encode($data)."' WHERE `id` = '".$id."' ";

		$query5 = $obj -> query_db($q);

	}



	function is_user_cash_verified($id){

		global $obj;



		$query5 = $obj -> query_db("SELECT `user_verified` FROM `user` WHERE `id` = '".$id."' ");

		$res5 = $obj->fetch_db_assoc($query5);



		$RESULT = (!empty($res5['user_verified'])) ? json_decode($res5['user_verified'], true) : '' ;

		if(!empty($RESULT) && $RESULT['verified'] == 'true'){

			return 'true';

		} else {

			return 'false';

		}

	}


	function is_user_corporate($id){

		global $obj;

		$query5 = $obj -> query_db("SELECT `co_user` FROM `user` WHERE `id` = '".$id."' ");

		$res5 = $obj->fetch_db_assoc($query5);

		if(!empty($res5['co_user']) && $res5['co_user'] == 'true'){

			return true;

		} else {

			return false;

		}

	}



	function getDataFromTable($table, $col){

		global $obj;



		$query5 = $obj -> query_db("SELECT `".$col."` FROM `".$table."`");

		$res5 = $obj->fetch_db_assoc($query5);



		return $res5[$col];

	}



	function getPId($email){

		global $obj;



		$query5 = $obj -> query_db("SELECT `j_type_id` FROM `join_restaurant` WHERE `j_email` = '".$email."'");

		$res5 = $obj->fetch_db_array($query5);



		return $res5['j_type_id'];

	}



	function checkPId($PID , $email){

		global $obj;



		$query5 = $obj -> query_db("SELECT `j_type_id` FROM `join_restaurant` WHERE `j_type_id` = '".$PID."' AND `j_email` = '".$email."' AND `j_status` = 'active'");

		if($obj -> num_rows($query5) > 0){

			return true;

		} else {

			return false;

		}

		return false;

	}

	function getTotalDeliveryCharges($STEPS ,$restaurant_id ,$distence) {

		$chareged = 0;

		if($distence >= 0 && $distence <= 1) {

			$chareged = round(delivery_charges($restaurant_id),2);

		} else {

			$chareged = round(delivery_charges($restaurant_id),2);

          

			for($i = 1; $i <= $distence; $i ++){

				$chareged ++;

			}

		}
    
		/* $chareged = 0;

		if($STEPS != "" || $restaurant_id != "" || $distence != "") {

			$steps = $STEPS;

			$steps = $steps-1;

			$limit = minRestDis();

			for($i = 0; $i <= $limit; $i++){

				$new_step = (($i+$steps) >= $limit) ? $limit : $i+$steps;

				$temp_part[$i] = $new_step;

				$i = $new_step;

			}

			$count_st = 1;

			foreach($temp_part as $st => $st_val){

				if($distence >= $st && $distence <= ($st_val+1)){

					$chareged = round($count_st * delivery_charges($restaurant_id),2);

					break;

				}

				$count_st ++;

			}

		} */

		return $chareged;

	}



	function setC($name,$text) {

		$expire=time()+907200;

		setcookie($name, $text, $expire);

	}



	function showC($name){

		//if($status) {

			(isset($_COOKIE[$name])) ? $RETURN =  $_COOKIE[$name] :	$RETURN = false;

			return $RETURN;

		//}

	}



	function checkC(){

		//if($_SESSION)

	}



	function isShopOpen($rest_id){

		global $obj;



		$query5 = $obj -> query_db("SELECT `type_opening_hours` FROM `menu_type` WHERE `type_id` = '".$rest_id."'");

		$res = $obj->fetch_db_array($query5);



		$nowTime = strtotime(date('H:i'));

		$oph = json_decode(stripslashes($res['type_opening_hours']) ,true);

		$oph_from = strtotime($oph[date('l')]['From']);

		$oph_to = strtotime($oph[date('l')]['To']);



		$isAvailable = 'false';

		if($nowTime > $oph_from && $nowTime < $oph_to) {

			$isAvailable = 'true';

		}

		$RETURN['if'] = $isAvailable;

		$RETURN['time'] = $oph[date('l')]['From'];



		return $RETURN;

	}



	function getMealItem($item_id){

		global $obj;



		$meal = array();

		$query5 = $obj -> query_db("SELECT `meal_id`,`meal_name`,`meal_price`,`meal_type` FROM `items_meals` WHERE `item_id` = '".$item_id."' AND `meal_status` = 'active'");

		while($res = $obj->fetch_db_assoc($query5)){

			switch($res['meal_type']){

				case 'size':

					$meal['size'][] = $res;

					break;

				case 'drink':

					$meal['drink'][] = $res;

					break;

				case 'sides':

					$meal['sides'][] = $res;

					break;

			}

		}



		return $meal;

	}

?>