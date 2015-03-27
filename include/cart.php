<?php
	session_start();
	include('functions.php');

  // If there's no item in the basket, create a new 'Cart'
  // array and 'CART_IS_MEAL' array

	if(!isset($_SESSION['CART'])) {
		$_SESSION['CART'] = array();
		$_SESSION['CART_IS_MEAL'] = array();
	}


	$error = false;
	$errorMSG = "";
	$successMSG = "";
	$ID = str_replace('id','',$_GET['ID']);
	$QTY = '1';;
	$NAME = "";
	$action = $_GET['action'];
	$PRICE = 0;
	$STOCK = 0;	$sub_item = false;

	$_ID = str_replace('id','',$_GET['ID']);

	$__ID = explode('|',$_ID);
	$orig_ID = $__ID[0];
	$ID = $_ID;

	$IS_MEAL = strip_tags($_GET['MEAL']);
	$MEAL_ARRAY = strip_tags($_GET['MEAL_ARRAY']);

	if(array_key_exists(1, $__ID)) {
		$sub_item = true;
		$SUB_ID = $__ID[1];
	}
	switch ($action) {
		case 'add':
			if(isValidID($ID)) {
				if($sub_item) {
					getSubitemDetails($SUB_ID);
				}
				if($QTY > $STOCK) {
					$errorMSG = "ERROR!! Quantity Out Of Stock.<br><b>Total Stock : ".$STOCK."</b>";
					break;
				}
				if($IS_MEAL == 'true'){
					getMealitemDetails($MEAL_ARRAY);
				}
				if(isset($_SESSION['CART'][$ID]['QTY'])) {
					if($_SESSION['CART'][$ID]['QTY'] >= $STOCK) {
						$errorMSG = "ERROR !! Quantity Out Of Stock.<br><b>Total Stock : ".$STOCK."</b>";
						break;
					}
				}
				if(isAlready($ID)){
					if($IS_MEAL == 'true'){
						/* if($_SESSION['CART'][$ID]['TOTAL'] == $PRICE) {
							$_SESSION['CART'][$ID]['TOTAL'] = $_SESSION['CART'][$ID]['QTY'] * $PRICE;
						} else { */
							$_SESSION['CART'][$ID]['NAME'] .= $NAME;
							$_SESSION['CART'][$ID]['TOTAL'] = $_SESSION['CART'][$ID]['TOTAL'] + $PRICE;
						/* } */
					} else {
						$_SESSION['CART'][$ID]['TOTAL'] = ($_SESSION['CART'][$ID]['QTY'] + $QTY) * $PRICE;
					}
					$_SESSION['CART'][$ID]['QTY'] = $QTY + $_SESSION['CART'][$ID]['QTY'];
					quantityCheck($ID);
				} else {
					$_SESSION['CART'][$ID]['ID'] = $ID;
					$_SESSION['CART'][$ID]['QTY'] = $QTY;
					$_SESSION['CART'][$ID]['NAME'] = $NAME;
					$_SESSION['CART'][$ID]['TOTAL'] = $QTY * $PRICE;
					if($IS_MEAL == 'true'){
						$_SESSION['CART_IS_MEAL'][$ID] = $NAME;
					}
					quantityCheck($ID);
				}
				$successMSG = $NAME." Added To Cart";
			} else {
				$error = true;
				$errorMSG = "Error! ID not Valid";
			}

			break;

		case 'update_sub':
			if(isAlready($ID)){
				$_price = getSubPrice($ID);
				$_SESSION['CART'][$ID]['NAME'] = $_SESSION['CART'][$ID]['NAME'] .' + &pound;'.$_price;
				$_SESSION['CART'][$ID]['TOTAL'] = $_SESSION['CART'][$ID]['TOTAL'] + $_price;
				$successMSG = "true";
			} else {
				$error = true;
				$errorMSG = "Error Occurred! This Product Is Not Available In Shopping Cart";
			}

			break;
		case 'delete':
			if(isAlready($ID)){
				if(isValidID($ID)){
					if($sub_item) {
						getSubitemDetails($SUB_ID);
					}
					$_SESSION['CART'][$ID]['QTY'] =  $_SESSION['CART'][$ID]['QTY'] - $QTY;
					$_SESSION['CART'][$ID]['TOTAL'] = $_SESSION['CART'][$ID]['QTY'] * $PRICE;
				}

				if($_SESSION['CART'][$ID]['QTY'] <= 0) {
					if(strpos($_SESSION['CART'][$ID]['NAME'], "+")) {
						echo 'id'.$ID;
					} else {
						$successMSG = 'true';
					}
					unset($_SESSION['CART'][$ID]);
				}
				if(array_key_exists($ID ,$_SESSION['CART_IS_MEAL'])) {
					unset($_SESSION['CART'][$ID]);
					unset($_SESSION['CART_IS_MEAL'][$ID]);
				}
			} else {
				$error = true;
				$errorMSG = "Error Occurred! Product Not Available In Shopping Cart";
			}

			break;

		case 'sub_delete':
			if(isAlready($ID)){
				$_price = getSubPrice($ID);
				if(isValidID($ID)) {
					$_SESSION['CART'][$ID]['NAME'] = $NAME;
					$_SESSION['CART'][$ID]['TOTAL'] = $_SESSION['CART'][$ID]['TOTAL'] - $_price;
					echo 'id'.$ID;
				}

			} else {
				$error = true;
				$errorMSG = "Error Occurred! Product Not Available In Shopping Cart";
			}

			break;

		case 'unset':
			if(isset($_SESSION['CART'])) {
				unset($_SESSION['CART']);
				unset($_SESSION['CART_IS_MEAL']);
				$successMSG = " Cart Empty";
			} else {
				$error = true;
				$errorMSG = "Error In Unset Cart";
			}

			break;

		default:
			$error = true;
			$errorMSG = "Error In Shopping Cart";
	}
	TOTAL();

/**
 * Find the total cost of the items in Cart.
 */
	function TOTAL() {
		$total = 0;
		foreach($_SESSION['CART'] as $value){
			$total += $value['TOTAL'];
		}
		$_SESSION['CART']['TOTAL'] = $total;
	}

	function isValidID($id) {
		global $NAME;
		global $PRICE;
		global $obj;
		global $STOCK;
		global $orig_ID;

		$value = $obj -> query_db("SELECT `item_id`,`item_name`,`item_price`,`item_in_stock` FROM `items` WHERE `item_id` = '".$orig_ID."'");
		if($obj -> num_rows($value) > 0) {
			$res = $obj -> fetch_db_array($value);
			$NAME = $res['item_name'];
			$PRICE = $res['item_price'];
			$STOCK = $res['item_in_stock'];
			return true;
		} else {
			return false;
		}
	}

/** Checks the prices of the sub-items
 *  and process accordingly.
 * @param $id
 * @return string
 */
	function getSubPrice($id) {
		global $obj;

		$value = $obj -> query_db("SELECT `item_subitem_price` FROM `items` WHERE `item_id` = '".$id."'");
		if($obj -> num_rows($value) > 0) {
			$res = $obj -> fetch_db_assoc($value);
			$PRICE = $res['item_subitem_price'];
			return $PRICE;
		} else {
			return '';
		}
	}

/** Checks if item is already inside cart
 * @param $ID
 * @return bool
 */
	function isAlready($ID){
		if(array_key_exists($ID ,$_SESSION['CART'])) {
			return true;
		} else {
			return false;
		}
	}

/** Checks the number of items remaining
 *  in the database.
 * @param $ID
 */
	function quantityCheck($ID){
		global $STOCK;
		global $PRICE;
		global $errorMSG;

		if($_SESSION['CART'][$ID]['QTY'] >= $STOCK) {
			$_SESSION['CART'][$ID]['QTY'] = $STOCK;
			$_SESSION['CART'][$ID]['TOTAL'] = $_SESSION['CART'][$ID]['QTY'] * $PRICE;
			$errorMSG = "<br>Total Quantity ".$STOCK." Added To Your  Cart";
		}
	}

/** Finds out if the item in question has an associated
 *  subitem with it. It then processes these sub-items.
 * @param $id
 */
	function getSubitemDetails($id){
		global $NAME;
		global $PRICE;
		global $obj;
		$value = $obj -> query_db("SELECT `subitem_id`,`subitem_name`,`subitem_price` FROM `subitems` WHERE `subitem_id` = '".$id."'");
		if($obj -> num_rows($value) > 0) {
			$res = $obj -> fetch_db_assoc($value);
			$NAME = $NAME . ' ' .$res['subitem_name'];
			$PRICE = $res['subitem_price'];
		}
	}

/** Checks if item is meal, if it is, find the
 *  associated meal items.
 * @param $ids
 */
	function getMealitemDetails($ids){
		global $NAME;
		global $ID;
		global $PRICE;
		global $obj;

		$ids = json_decode($ids, true);
		$INAR = array();
		foreach($ids as $id){
			$a = explode('_', $id);
			$INAR[] = $a[0];
		}

		$value = $obj -> query_db("SELECT `meal_name`,`meal_price`,`meal_type` FROM `items_meals` WHERE `meal_id` IN (".implode(',' ,$INAR).")");
		if($obj -> num_rows($value) > 0) {

			if(isAlready($ID)) {
				$name = " ";
			} else {
				$name = $NAME;
			}
			$price = $PRICE;

			while($res = $obj -> fetch_db_assoc($value)){
				switch($res['meal_type']){
					case 'size':
						$name .= ' S:'.$res['meal_name'];
						break;
					case 'drink':
						$name .= ' D:'.$res['meal_name'];
						break;
					case 'sides':
						$name .= ' Z:'.$res['meal_name'];
						break;
				}
				$price += $res['meal_price'];
			}
			$NAME = '('.$name.')';
			$PRICE = $price;
		}
	}

	echo $successMSG;
	echo $errorMSG;
	/* echo '<pre>';
	print_r($_SESSION['CART']);
	echo '<pre>'; */
?>