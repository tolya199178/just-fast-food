<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 24/06/14
 * Time: 23:11
 */

session_start();
include("include/functions.php");

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Just-FastFood - Page Not Found">
    <meta name="keywords" content="Account Creation!, <?= getDataFromTable('setting','keywords'); ?>">
    <meta name="author" content="Just-FastFood">
    <title>Just-FastFood - Page Not Found - 404</title>
    <!--CSS INCLUDES-->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,900' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
    <link href="css/archivist.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/responsivemobilemenu.css" type="text/css"/>
    <link href="css/media.css" rel="stylesheet">
    <link href="css/flexslider.css" rel="stylesheet">
    <link rel="stylesheet" href="css/square/blue.css" />
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.theme.css" rel="stylesheet">
</head>
<body>
<div class="wrapper">
    <?php include('templates/header2.php');?>
    <div class="metahead what-we-do" style="padding: 20px 0">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1 style="text-transform: none">OOPS - Something isn't quite right</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="section_inner" >
        <div class="container">
            <div class="col-sm-10">
                <div>
                    <h1 style="font-family: Roboto; color: blueviolet">404 Page not found</h1>

                </div>
                <hr class="hr">
                <h3 style="font-family: Roboto; text-transform: none">We couldn't find what you're looking for.</h3>
                <p style="margin-bottom: 70px">If you feel something is missing that should be here, contact us <a href="contact-us.php" class="i u">here</a> or speak to us online. We are available online 12 hours daily.</p>

            </div>
            </div>
        </div>
    </div>

<?php include("templates/footer2.php");?>
</body>
</html>