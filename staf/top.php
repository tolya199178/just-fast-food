<?php session_start();
if(!isset($_SESSION['reff'])){$_SESSION['reff']=$_SERVER['HTTP_REFERER'];}
include("config/scriptvars.php"); 
include("config/translations.php"); 
include("includes/functions.php"); 
set_time_limit(0);
error_reporting(0);
?>
