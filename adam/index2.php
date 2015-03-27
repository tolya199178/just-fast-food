<?php
session_start();

include('include/functions.php');

if(isset($_GET['c'])) {
    ($_GET['c'] == 'y') ? $_SESSION['cokiee_enabled'] = 'true' : $_SESSION['cookiee_enabled'] = 'false';
    header('location:/');
    die();
}
?>
<!DOCTYPE html>

<html lang="en-GB" class="no-js" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9">
    <meta name="content-language" content="en-GB">
    <meta name="author" content="Just-FastFood">
    <meta name="description" content="Just Fast Food - McDonalds | KFC | Burger King | Chinese | Subway & other Takeaways Deliveries! Order Online">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="<?= getDataFromTable('setting', 'keywords');?>">
    <title>Order Fast Food Online - Food Delivered In Minutes - Takeaway</title>

    <!--CSS INCLUDES-->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,900' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>



    <link href="css/archivist.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/responsivemobilemenu.css" type="text/css"/>
    <link href="css/media.css" rel="stylesheet">
    <link href="css/flexslider.css" rel="stylesheet">
    <link href="css/bootstrapValidator.min.css" rel="stylesheet">

    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.theme.css" rel="stylesheet">
    <link href="css/bootstrap-dialog.min.css" rel="stylesheet">


</head>



<body>

<div class="wrapper">
    <?php include('templates/header2.php');?>
    <?php include('templates/welcomeMsg.php'); ?>

    <div class="slider_red">
        <div class="container">

            <div class="content form-group">
                <h1 class="white text-center">FastFood & Takeaways in your area</h1>
                <form action="" method="post" class="text_field col-lg-6 input-group input-group-lg text-center post" id="home-search-box" >

                    <input type="text" required="" name="ukpostcode" id="postcodeuk" class="form-control text-center postcode" autocomplete="off" placeholder="Enter your postcode e.g SW7 5HR" style="font-size: 19px; font-family: segoe ui; font-weight: 700" >
                    <input type="submit" name="submit" class="custom_submit_button yellow_btn2 text-center sbtn" value="Search">
                </form>


            </div>
        </div>
    </div>
    <div class="shay"></div>
    <div class="slider_light_brown">

        <div class="container">

            <div class="sec_title"><h1 class="text-center">4 Easy Steps</h1></div>
            <div class="steps"><img src="images/4_step.png"  class="img-responsive" alt="4steps"></div>

            <div class="payments"> NO CASH? NO PROBLEM! PAY BY CASH OR PAYPAL</div>
            <div class="payment_logos"><img src="images/payemnt.png"></div>

        </div>

    </div>
    <div class="slider-image">

    </div>
    <div class="message_block">
        <div class="container">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"><h3 class="white">Do you Own A Restaurant ? Get more businesses...</h3></div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="custom_button red_btn ">
                    <ul>
                        <li><a href="restaurant-owner.php">Join us NOW </a></li>
                    </ul>
                </div>

            </div>


        </div>
    </div>

    <div class="section">

        <div class="container">

            <div class="takeaways col-lg-8 col-md-8 col-sm-12 col-xs-12">

                <div class="sec_title"><ul><li class="takeaway">Takeaways & Fastfood added today</li></ul></div>


                <div class="flexslider">
                    <ul class="slides">

                        <li>
                            <div class="takeaway_list">
                                <ul>
                                    <li>McDonalds <span>In Fratton PO5</span></li>
                                    <li>Burger King <span>In Commercial Rd PO4</span></li>
                                    <li>KFC <span>In Commercial Rd PO4</span></li>
                                    <li>Ocean Swell - Fish & Chips<span>n Copnor Rd PO2</span></li>
                                    <li>McDonalds <span>In Fratton PO5</span></li>
                                    <li>Burger King <span>In Commercial Rd PO4</span></li>
                                    <li>KFC <span>In Commercial Rd PO4</span></li>
                                    <li>Ocean Swell - Fish & Chips<span>n Copnor Rd PO2</span></li>
                                    <li>McDonalds <span>In Fratton PO5</span></li>
                                    <li>Burger King <span>In Commercial Rd PO4</span></li>
                                    <li>KFC <span>In Commercial Rd PO4</span></li>
                                    <li>Ocean Swell - Fish & Chips<span>n Copnor Rd PO2</span></li>

                                </ul>

                            </div>
                        </li>
                        <li>
                            <div class="takeaway_list">
                                <ul>
                                    <li>KFC <span>In Commercial Rd PO4</span></li>
                                    <li>Ocean Swell - Fish & Chips<span>n Copnor Rd PO2</span></li>
                                    <li>McDonalds <span>In Fratton PO5</span></li>
                                    <li>Burger King <span>In Commercial Rd PO4</span></li>
                                    <li>KFC <span>In Commercial Rd PO4</span></li>
                                    <li>McDonalds <span>In Fratton PO5</span></li>
                                    <li>Burger King <span>In Commercial Rd PO4</span></li>
                                    <li>Ocean Swell - Fish & Chips<span>n Copnor Rd PO2</span></li>
                                    <li>McDonalds <span>In Fratton PO5</span></li>
                                    <li>Burger King <span>In Commercial Rd PO4</span></li>

                                </ul>

                            </div>
                        </li>

                    </ul>

                </div>

                </ul>
            </div>




            <div class="orders col-lg-4 col-md-4 col-sm-12 col-xs-12">

                <div class="sec_title"><ul><li class="delivery">Latest Orders & Updates</li></ul></div>

                <div id="nt-example1-container">

                    <ul id="nt-example1">
                        <?php
                        $query = "SELECT `user_screen_name`,`order_total`,`order_details`,`order_date_added`,`order_acceptence_time` FROM `orders`,`user` WHERE orders.order_status = 'complete' AND orders.order_user_id = user.id  ORDER BY orders.order_date_added DESC LIMIT 0 , 10";
                        $valueOBJ = $obj->query_db($query);
                        $odd = 0;
                        while($res = $obj->fetch_db_array($valueOBJ)) {

                            ?>
                            <li class="order-details"> <?php
                                $Array = json_decode($res['order_details'] ,true);
                                echo '<span class="order-list" style="color: #000000;">';
                                foreach($Array as $key => $val) {

                                    if($key != 'TOTAL') {

                                        echo $val['QTY'] . 'x '.$val['NAME'] .',';
                                    }

                                }?> <span><?php echo  date('g:i a D M Y', strtotime($res['order_acceptence_time']));?></span><span class="red">
Ordered By: <?php echo ($res['user_screen_name'] != '') ?  $res['user_screen_name'] : 'Customer '?> </span>
                            </li>

                            <?php
                            $odd++;

                        }
                        ?>
                    </ul>
                    <div class="navigations">
                        <ul>
                            <li id="nt-example1-prev"></li>
                            <li id="nt-example1-next"> </li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>


    </div>


    <?php include("templates/testimonial.php"); ?>
    <?php include('templates/user-signup.php');?>

    <?php include "templates/footer2.php";?>


</body>
</html>