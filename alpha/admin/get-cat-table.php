<?php
	session_start();
	require_once('include/auth.php');
?>
<table id="table-1" cellspacing="2" cellpadding="2" border="1" style="width: 50%;">
<?php
	include_once("../include/functions.php");

	$query = "SELECT * FROM `categories` WHERE `type_id` = '".$_REQUEST['cat']."' ORDER BY `category_order` ASC";
	$valueOBJ = $obj->query_db($query) or die(mysql_error());
	$i = 1;
	while($res = $obj->fetch_db_assoc($valueOBJ)) {
		echo '<tr id="'.$res['category_id'].'.'.$i.'"><td>'.$i.'</td><td>'.$res['category_name'].'</td></tr>';
		$i ++;
	}
?>
</table>
