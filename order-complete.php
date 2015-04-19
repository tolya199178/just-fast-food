<?php



session_start();

/* echo '<pre>';

print_r($_SESSION);

echo '</pre>';*/



include('include/functions.php');



if(!isset($_SESSION['CURRENT_ORDER_ID']) && isset($_SESSION['user'])){

    header('location:my-profile.php');

    exit();

}



if(!isset($_SESSION['CURRENT_ORDER_ID'])){

    header('location:my-profile.php');

    exit();

}



$select = "*";

$where = "`order_id` = '".$_SESSION['CURRENT_ORDER_ID']."'";

$result_order = SELECT($select ,$where, 'orders', 'array');



$select_time = "`type_time`";

$where_time = "`type_id` = '".$result_order['order_rest_id']."'";

$estimated_menu_time = SELECT($select_time ,$where_time, 'menu_type', 'array');

//print_r($estimated_menu_time);


if($result_order['order_status'] == 'assign') {

    $return_status = 'true';

} else if($result_order['order_status'] == 'cancel') {

    $return_status = 'cancel';

} else {

    $return_status = 'false';

}

?>

<!DOCTYPE HTML>

<html lang="en-US">

<head>

    <meta charset="UTF-8">

    <meta name="description" content="Your Order - Confirmation and Response, <?= getDataFromTable('setting','meta'); ?>" />

    <meta name="keywords" content="Your Order - Confirmation and Response, <?= getDataFromTable('setting','keywords'); ?>" />

    <meta name="author" content="JFF" />

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <link rel="apple-touch-icon" href="items-pictures/default_rest_img.png" />

    <link rel="shortcut icon" type="image/png" href="favicon.png" />

    <title>Your Order - Confirmation and Response | Just-FastFood</title>

    <!--CSS INCLUDES-->

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,900' rel='stylesheet' type='text/css' />

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css' />

    <link href="css/star-rating.min.css" media="all" rel="stylesheet" type="text/css" />

    <link href="css/archivist.css" rel="stylesheet" />

    <link href="css/bootstrap.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="css/responsivemobilemenu.css" type="text/css"/>

    <link href="css/media.css" rel="stylesheet" />

    <link href="css/flexslider.css" rel="stylesheet" />

    <link rel="stylesheet" href="css/square/blue.css" />

    <link href="css/owl.carousel.css" rel="stylesheet" />

    <link href="css/owl.theme.css" rel="stylesheet" />

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,800italic,400,600,700,800' rel='stylesheet' type='text/css'>

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,700italic,900' rel='stylesheet' type='text/css'>

    <script>

        <?php if( $return_status == 'false' ) { ?>

        var time = 1;

        var sec;

        load();



        function load(){

            $.ajax({

                type: "POST",

                url: 'include/order-check.php',

                data: { ID : <?php echo $_SESSION['CURRENT_ORDER_ID']?>},

                success: function(data) {
                    if( data == 'false' ){


                        if( time == 100 ) {

                            $('#order-status').fadeOut(function() {

                                $('#order-status').html('Restaurant is busy at the moment... <br /> You will be notified once your order is accepted');

                                $('#order-status').fadeIn();

                            });

                        }

                        sec = window.setTimeout('load()',1500);

                        time ++;



                    } else {

                        time = 100;

                        $('.order-complete-wrap .ltext').text('100% Complete');

                        window.setTimeout(function() {window.location.href = 'order-complete.php';},800);

                    }

                },
                error: function (error) {
                    console.log(error);
                }

            });

        }

        <?php } ?>

    </script>

    <style>
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

        <div class="inner_title"><h2 class="text-center white">See Your <span>Order Status</span> below</h2></div>

        <div class="custom_button yellow_btn small_but text-center ">

            <ul><li><a href="Postcode-<?php echo str_replace(' ','-',$_SESSION['CURRENT_POSTCODE']); ?>">Need Help? We're Online</a></li></ul>

        </div>

    </div>

    <div class="breadcrum">

        <ul>

            <li><a href="index.php">Begin Search</a></li>

            <li><a href="Postcode-<?php echo str_replace(' ','-',$_SESSION['CURRENT_POSTCODE']); ?>">Postcode-<?php echo $_SESSION['CURRENT_POSTCODE']; ?></a></li>

            <li><a href="order-details2.php">Delivery Address</a></li>

            <li class="u">Order Complete</li>

        </ul>

    </div>

    <?php

    if ($return_status == 'true') {

        ?>

        <!--  <div class="alert alert-success alert-dismissable" role="alert" style="margin-left: 10em; width: 80%"> Thanks for your order! Please note we do encounter some delay at the restaurants during peak periods! You ca</div>-->

    <?php

    }

    ?>

    <?php include('include/notification.php');?>

    <div class="section_inner">

        <div class="container">

            <div class="col-md-12 explor">
                <?php

                $query_location = $obj -> query_db("SELECT * FROM `location`,`menu_type` WHERE location.location_menu_id = '".$_SESSION['DELIVERY_REST_ID']."' AND  menu_type.type_id = '".$_SESSION['DELIVERY_REST_ID']."'");

                $locationObj = $obj -> fetch_db_assoc($query_location);

                $oph = json_decode($locationObj['type_opening_hours'] ,true);

                $type_special_offer = json_decode($locationObj['type_special_offer'] ,true);

                ?>

                <!-- <div class="panel panel-default shadow">

                    <h3 class="header"><?php echo $locationObj['type_name'];?> <span><?php echo $locationObj['location_city'];?></span></h3>

                    <hr class="hr" />

                    <div class="panel-body col-md-12">

                        <div class="col-md-3">

                            <img class="img-rounded" style="width:100%;" src="items-pictures/<?php echo $locationObj['type_picture'];?>" />

                            <a class="btn" style="color:#fff; margin-top: 30px; width: 100%; " href="oph.php?id=<?php echo $_SESSION['DELIVERY_REST_ID']?>">View All Opening Hours</a>

                        </div>

                        <div class="col-md-6">

                            <ul class="list-group">

                                <p class"small"><?php echo date("l, j F Y, h:i A")?></p>

                                <li class="list-group-item m-header">Opening Hours</li>

                                <li class="list-group-item"><?php echo date('l');?>: <?php echo  $oph[date('l')]['From'] . ' - ' .$oph[date('l')]['To']?></li>

                                <li class="list-group-item"><?php echo date('l', time()+86400)?>: <?php echo  $oph[date('l', time()+86400)]['From'] . ' - ' .$oph[date('l')]['To']?></li>

                            </ul>

                            <ul class="list-group">

                                <li class="list-group-item m-header">Special Offers</li>

                                <li class="list-group-item">

                                    <?php

                if($type_special_offer != "") {

                    echo $type_special_offer['off']. ' % off today on orders over &pound; '.$type_special_offer['pound'];



                } else {

                    echo 'No special Offers';

                }

                ?>

                                </li>

                            </ul>

                        </div>

                    </div>

                </div>-->

                <div class="panel panel-default shadow">

                    <h3 class="header">Order Status</h3>

                    <hr class="hr" />

                    <div class="panel-body col-md-12">

                        <h5>Your Order is being sent to our drivers</h5><!--<?php echo $locationObj['type_name'];?></h5>-->

                        <div class="order-comp">

                            <h5><span >Your Order ID : </span><strong><?php echo $_SESSION['CURRENT_ORDER_ID'];?></strong></h5>

                            <h5><span>Your Transaction ID : </span><strong><?php echo $result_order['order_transaction_id'] ;?></strong></h5>

                        </div>

                        <ul class="list-group col-md-6 col-md-offset-3">

                            <?php if($return_status == 'true') { ?>

                                <li class="list-group-item">Thank You </span><strong><?php echo $_SESSION['user'];?></strong>!</p> Please check your order status below.</li>

                                <li class="list-group-item"><span>Order Status :</span> <strong>Accepted</strong></li>

                                <li class="list-group-item"><span>Time Accepted : </span><strong><?php echo date('l, F t, Y h:i:s A' ,strtotime($result_order['order_acceptence_time']));?></strong></li>

                                <?php

                                $delivery_type = json_decode($result_order['order_delivery_type'] , true);

                                ?>

                                <?php if($delivery_type['time'] == "ASAP") {?>

                                    <li class="list-group-item"><span>Estimated Delivery Time  : </span><strong><?php echo date('h:i A' ,strtotime($result_order['order_acceptence_time']) + $estimated_menu_time['type_time']*60) .' (' .$estimated_menu_time['type_time'] .' minutes aprox)';?></strong></li>

                                <?php } ?>

                                <li class="list-group-item"><span>Order Type : </span><strong style="text-transform: capitalize;"><?php echo $delivery_type['type'] .'  '.$delivery_type['time']?></strong></li>

                                <li class="list-group-item"><span>Payment Method : </span><strong style="text-transform: capitalize;"><?php echo ($result_order['order_payment_type'] == 'By Card') ? 'Card Payment' : $result_order['order_payment_type'];?></strong></li>

                                <li class="list-group-item">You order is on its way!</li>

                            <?php } else if($return_status == 'cancel'){ ?>

                                <li class="list-group-item alert-info">

                                    <h4 class="alert alert-info last">Ohh! Looks like our drivers are fully booked! </h4>

                                    <h5 class="last-a">The driver assigned to your order has a few orders in the queue to be fulfilled.</h5>

                                    <h5 class="last-a">As we try to ensure your food gets to you within 45 minutes, we wouldn't be able to deliver this order now. We're sincerely sorry about this, please try again in a little while.</h5>


                                    <h5 class="last-a"> Full refunds are automatically processed when orders are cancelled. </h5>

                                    <h5> For more details, please contact us via our Live Chat or email us your Order ID</h5>

                                </li>

                            <?php } else {?>

                                <li class="list-group-item centered-text">

                                    <p id="order-status" class="alert alert-warning">We're sending your order . . . <br />
                                    </p>

                                    <p class="last-a"><i>Please wait for confirmation to ensure order acceptance!</i></p>

                                    <p class="last-a">IMPORTANT: Direct response can take up to 90 seconds<p>

                                    <div class="spinner">

                                        <div class="bounce1"></div>

                                        <div class="bounce2"></div>

                                        <div class="bounce3"></div>

                                    </div>

                                </li>

                            <?php } ?>

                            <?php

                            // if($return_status != 'false') {

                            $notunset = array('user', 'userId', 'cokiee_enabled', 'CURRENT_ORDER_ID', 'CURRENT_POSTCODE');


                            foreach($_SESSION as $k => $v){

                                if(in_array($k, $notunset)) continue;

                                unset($_SESSION[$k]);

                            }

                            ?>

                            <div class="txt-right" style="margin-top:20px;">

                                <a href="my-profile.php" class="btn">Continue</a>

                            </div>

                            <?php //} ?>

                            </li>

                        </ul>

                    </div>

                </div>

            </div>



        </div>

    </div>

</div>


<?php require('templates/footer2.php');?>


</body>

</html>