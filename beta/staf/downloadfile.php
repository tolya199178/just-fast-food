<?php 
include("config/scriptvars.php");  
if($_GET['type']=='csv') //csv
{
$filename=$_GET['username']."_".$_GET['service'].".csv";
$filelocation=$csvfilepath.$_GET['username']."_".$_GET['service'].".csv";
$size_in_bytes = filesize($filelocation);
header("Content-type: application/vnd.ms-excel");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false); 
header("Content-Disposition: attachment; filename= ".$filename.";size=".$size_in_bytes);
header('Pragma: public');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
readfile($filelocation);
exit();
}
if($_GET['type']=='excel') //csv
{
$filename=$_GET['username']."_".$_GET['service'].".xls";
$filelocation=$csvfilepath.$_GET['username']."_".$_GET['service'].".xls";
$size_in_bytes = filesize($filelocation);
header("Content-type: application/octet-stream");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false); 
header("Content-Disposition: attachment; filename= ".$filename.";size=".$size_in_bytes);
header('Pragma: public');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
readfile($filelocation);
exit();
}
?>
