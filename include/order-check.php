<?php

	session_start();

	include('functions.php');



	if(isset($_POST['ID'])) {

        $id = (int)$_POST['ID'];

		$select = "`order_status`";

		$where = "`order_id` = '".$id."' ";

		$result = SELECT($select ,$where, 'orders', 'array');

		if($result['order_status'] == 'assign') {

			$return = 'true';

		} else if ($result['order_status'] == 'cancel') {

			$return = 'cancel';

		} else {

			$return = 'false';

		}


		echo $return;



	} else {

		echo 'pending';

	}
