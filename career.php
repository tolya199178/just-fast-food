<?php 
include_once('include/functions.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Just Fast Food - Contact us - Order Food Online - Fast Food Online">
    <meta name="author" content="Just-FastFood">
    <title>Career | Just-FastFood</title>
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
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <style>
        .panel {
            overflow: hidden; 
        }
        .panel > h3.header {
            width: 97%;
            text-align: center;
        }
        .panel .m-header,
        .list-group-item.m-header {
            text-transform: uppercase;
            text-align: center;
            font-size: 18px;        
        }
    </style>
</head>
<body>
<div class="wrapper">
    <?php include('templates/header2.php'); ?>
    <div class="page_header">
    <div class="inner_title"><h2 class="text-center white">Career</h2></div>
    </div>
    <div class="breadcrum">
        <ul>
            <li><a href="index.php">Begin Search</a></li>
            <li class="u">Career</li>
        </ul>
    </div>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                                <ul class="list-group">
                                    <li class="list-group-item" style="margin-bottom: 10em">
                                        <h4 style="text-transform: none; font-family: Roboto">We have no vacancy at the moment... </h4>
                                            </p>Having said that, we are always on the look out for Delivery Drivers and Sales executives. Email us your CV and a member of the team will be in touch. </p>
											 <abbr title="Phone">E-mail:</abbr> <a href="mailto:info@just-fastfood.com">info@just-fastfood.com</a>   
											 </li>
                                </ul>                 
        </div>
    </div>
</div>
</div>
<!-- modal -->
<div class="modal fade" id="user-signin-modal" tabindex="-1" role="dialog" aria-labelledby="signin-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" data-dismiss="modal">Try Again</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php include('templates/footer2.php');?>
        <script type="text/javascript">
        var geocoder;
        var map;
        function initialize() {
          geocoder = new google.maps.Geocoder();
          var latlng = new google.maps.LatLng(51.523313,-0.102528);
          var mapOptions = {
            zoom: 18,
            center: latlng
          }
          map = new google.maps.Map(document.getElementById("google_map"), mapOptions);
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
</body>
</html>