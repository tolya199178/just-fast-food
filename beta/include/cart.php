<?php
	session_start();
	include('functions.php');

	if(!isset($_SESSION['CART'])) {
		$_SESSION['CART'] = array();
	}

	$error = false;
	$errorMSG = "";
	$successMSG = "";
	$ID = str_replace('id','',$_GET['ID']);
	$QTY = '1';;
	$NAME = "";
	$action = $_GET['action'];
	$PRICE = 0;
	$STOCK = 0;

	switch ($action) {
		case 'add':
			if(isValidID($ID)) {
				if($QTY > $STOCK) {
					$errorMSG = "ERROR!! Quantity Out Of Stock.<br><b>Total Stock : ".$STOCK."</b>";
					break;
				}
				if(isset($_SESSION['CART'][$ID]['QTY'])) {
					if($_SESSION['CART'][$ID]['QTY'] >= $STOCK) {
						$errorMSG = "ERROR !! Quantity Out Of Stock.<br><b>Total Stock : ".$STOCK."</b>";
						break;
					}
				}
				if(isAlready($ID)){
					$_SESSION['CART'][$ID]['QTY'] = $QTY + $_SESSION['CART'][$ID]['QTY'];
					$_SESSION['CART'][$ID]['TOTAL'] = $_SESSION['CART'][$ID]['QTY'] * $PRICE;
					quantityCheck($ID);
				} else {
					$_SESSION['CART'][$ID]['ID'] = $ID;
					$_SESSION['CART'][$ID]['QTY'] = $QTY;
					$_SESSION['CART'][$ID]['NAME'] = $NAME;
					$_SESSION['CART'][$ID]['TOTAL'] = $QTY * $PRICE;
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
				$errorMSG = "Error in Update! This Product Not Exist In Shoping Cart";
			}

			break;
		case 'delete':
			if(isAlready($ID)){
				if(isValidID($ID)){
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
			} else {
				$error = true;
				$errorMSG = "Error in Delete Product Not Exist In Shoping Cart";
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
				$errorMSG = "Error in Delete Product Not Exist In Shoping Cart";
			}

			break;

		case 'unset':
			if(isset($_SESSION['CART'])) {
				unset($_SESSION['CART']);
				$successMSG = " Cart Empty";
			} else {
				$error = true;
				$errorMSG = "Error In Unset Cart";
			}

			break;

		default:
			$error = true;
			$errorMSG = "Error In Shoping Cart";
	}
	TOTAL();
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

		$value = $obj -> query_db("SELECT `item_id`,`item_name`,`item_price`,`item_in_stock` FROM `items` WHERE `item_id` = '".$id."'");
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

	function isAlready($ID){
		if(array_key_exists($ID ,$_SESSION['CART'])) {
			return true;
		} else {
			return false;
		}
	}

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

	echo $successMSG;
	echo $errorMSG;
?>