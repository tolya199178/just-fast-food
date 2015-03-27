<?php  $csv_output = "Contact Name,Contact Email\nCustomer service,customers@super-tell-a-friend.com\nContact person,contact@super-tell-a-friend.com\nTest email,test@super-tell-a-friend.com\n"; 
	$filename="sample.csv";
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename= ".$filename.";size=".$size_in_bytes);
	print $csv_output;
	exit; 
?>
