<?php//ob_start("ob_gzhandler");session_start();include('include/functions.php');if(isset($_GET['c'])) {    ($_GET['c'] == 'y') ? $_SESSION['cokiee_enabled'] = 'true' : $_SESSION['cookiee_enabled'] = 'false';    header('location:/');    die();}echo $_SESSION['error'];?><!DOCTYPE html><html lang="en-GB" class="no-js" xmlns="http://www.w3.org/1999/xhtml"><head>    <meta charset="UTF-8">    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9; IE=EmulateIE10; IE=edge">    <meta name="content-language" content="en-GB">    <meta name="author" content="Just-FastFood">    <meta name="description" content="Just Fast Food - McDonalds | KFC | Burger King | Chinese | Subway & Takeaway Delivery! Order Online | London Delivery">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">    <meta name="keywords" content="kfc delivery, McDonalds delivery, online food order, do kfc deliver, nandos delivery, delivery service, order fast food online, just fast food">    <title>KFC Delivery | Nandos Delivery | Order Takeaway | Food Delivery Online</title>    <link rel="shortcut icon" type="image/png" href="favicon.png" />    <link rel="icon" type="image/png" href="favicon.png" />    <!--CSS INCLUDES-->    <link href="css/archivist.css?v1.2.3" rel="stylesheet">    <link href="css/bootstrap.min.css" rel="stylesheet">    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">    <link rel="stylesheet" href="css/responsivemobilemenu.css" type="text/css"/>    <link href="css/media.css" rel="stylesheet">    <link href="css/flexslider.css" rel="stylesheet">   <!-- <link href="css/CreativeButtons/css/default.css" rel="stylesheet">-->    <link href="css/CreativeButtons/css/component.css?v1.0" rel="stylesheet">    <link href="css/bootstrapValidator.min.css" rel="stylesheet">    <link href="css/owl.carousel.css?v1.0.0" rel="stylesheet">    <link href="css/owl.theme.css?v1.0.0" rel="stylesheet">  <style>    .form-control .text-center .postcode{      font-size: 19px;    }    .move-up {      top: 10px !important;    }  </style></head><body style="font-family: 'Lato', sans-serif"><div class="wrapper">    <?php include('templates/header2.php');?>    <?php include('templates/welcomeMsg.php'); ?>      <div class="slider_red">        <div class="container">            <div class="content form-group">                <h1 class="white text-center" style="text-shadow: 0 0 15px orangered, 0 0 15px red, 0 0 15px blue; font-weight: 600; text-transform: none">Order Food Delivery From Your Favourite Restaurants</h1>                <form action="" method="post" class="text_field col-lg-6 input-group input-group-lg text-center post" id="home-search-box" >                    <input type="text" required="" name="ukpostcode" id="postcodeuk" class="form-control text-center postcode input-lg" autocomplete="off" placeholder="Enter your postcode e.g SW7 5HR" style="font-size: 19px; font-family: 'Lato', sans-serif; font-weight: 300" >                    <!--<input type="submit" name="submit" class="custom_submit_button yellow_btn2 sbtn" value="Search">-->                   <button type="submit" name="submit" class="btn btn-2" style="top: 10px; border-radius: 999em"><i class="fa fa-paper-plane-o fa-lg"> </i> Search</button>                </form>            </div>        </div>    </div>    <div class="shay"></div>    <div class="slider_light_brown">        <div class="container">            <div class="sec_title"><h1 class="text-center">4 Easy Steps</h1></div>            <div class="steps"><img src="images/4_step.png"  class="img-responsive" alt="delivery mcdonalds"></div>            <div class="payments" style="font-family: 'Lato', 'Open Sans'; text-transform: none">No Cash? No Problem! Pay with PayPal or Debit Card</div>            <div class="payment_logos"><img src="images/payemnt.png" alt="free delivery food"></div>        </div>    </div>    <div class="comp_section">      <div class="container">        <div class="row">          <div class="col-lg-5 col-md-5 col-sm-4 col-xs-12">            <a href="corporate-user.php">              <img class="img-rounded" style="height: auto; width: 100%; vertical-align: middle; border: 0 none" src="images/food2.jpg" alt="company_order">            </a>          </div>          <div class="col-lg-6 col-lg-offset-1 col-md-6 col-md-offset-1 col-sm-8 col-xs-12">            <h3 style="color: darkmagenta">Trending Dishes Delivered</h3>            <p class="block-text">At Just-FastFood, we deliver trending dishes from restaurant of choice to home or your office. You can even signup to have variety dishes delivered to you every afternoon just like you want it!  Join us <a href="signup.php">here</a>. For more information, <a href="#" onclick="return SnapEngage.startLink();">ask</a> us online.</p>          </div>        </div>      </div>    </div>    <!--<section class="big-section big-section--white big-padding section-hide-overflow">      <div class="row">        <div class="col-xs-7">          <div class="medium-7 large-6 large-push-1 column">            <div class="padded-section">              <ol class="big-numbered-list">                <li class="big-numbered-list-item">                  <div class="h3">                    Put your postcode to find restaurants in your area                  </div>                  <p class="skinny-p">Simply enter your postcode to select a restaurant of choice. From Chinese, to India, Thai and American cuisine.</p>                </li>                <li class="big-numbered-list-item">                  <div class="h3">                    Select favourite restaurant & menus.                  </div>                  <p class="skinny-p">Put your menus in the e-Basket - specify any additional information for the driver e.g dietary requirements, allergies e.t.c</p>                </li>              </ol>            </div>          </div>        </div>      </div>    </section>-->    <div class="message_block">        <div class="container">            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"><h3 class="white" style="text-transform: none; font-weight: 300">Want to order for the whole office? <a href="corporate-user.php"><span> Signup </span></a>for a corporate account.</h3></div>            <!-- <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"><h3 class="white">Do you Own A Restaurant ? Get more businesses...</h3></div>-->            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">                <div class="custom_button red_btn">                    <ul>                        <li><a href="corporate-user.php" style="border-radius: 999em">Get Started </a></li>                    </ul>                </div>            </div>        </div>    </div>    <div class="section" style="background-color: rgb(246, 250, 250); ">        <div class="container">            <div class="takeaways col-lg-8 col-md-8 col-sm-12 col-xs-12">                <div class="sec_title"><ul><li class="takeaway">Takeaways & Fastfood added today</li></ul></div>                <div class="flexslider">                    <ul class="slides">                        <li>                            <div class="takeaway_list">                                <ul>                                    <li>KFC <span>London SE4</span></li>                                    <li>Ocean Swell - Fish & Chips<span>Copnor Rd PO2</span></li>                                    <li>McDonalds <span>W6</span></li>                                    <li>Burger King <span>SE8</span></li>                                    <li>KFC <span>E2</span></li>                                    <li>McDonalds <span>E1W</span></li>                                    <li>Burger King <span>E4</span></li>                                    <li>Bay Water - Chinese<span>W1</span></li>                                    <li>McDonalds <span>EC2</span></li>                                    <li>Burger King <span>E1</span></li>                                </ul>                            </div>                        </li>                        <li>                            <div class="takeaway_list">                                <ul>                                    <li>McDonalds <span>N12</span></li>                                    <li>KFC <span>Commercial Rd PO4</span></li>                                    <li>Ocean Swell - Fish & Chips<span>Copnor Rd PO2</span></li>                                    <li>McDonalds <span>N1</span></li>                                    <li>Burger King <span>Commercial Rd PO4</span></li>                                    <li>McDonalds <span>SW8</span></li>                                    <li>H & D Fish and Chips<span>Portsmouth Rd</span></li>                                    <li>KFC <span>Fratton PO4</span></li>                                    <li>Alpha Amazing<span>North End</span></li>                                </ul>                            </div>                        </li>                        <li>                            <div class="takeaway_list">                                <ul>                                    <li>KFC <span>Copnor Rd PO2</span></li>                                    <li>McDonalds <span>SE28</span></li>                                    <li>KFC <span>SE1</span></li>                                    <li>McDonalds <span>E1W</span></li>                                    <li>Burger King <span>EC1</span></li>                                    <li>McDonalds <span>EC2</span></li>                                    <li>Burger King <span>N12</span></li>                                </ul>                            </div>                        </li>                    </ul>                </div>                </ul>            </div>            <div class="orders col-lg-4 col-md-4 col-sm-12 col-xs-12">                <div class="sec_title"><ul><li class="delivery">Latest Orders & Updates</li></ul></div>                <div id="nt-example1-container">                    <ul id="nt-example1">                        <?php                        $query = "SELECT `user_screen_name`,`order_total`,`order_details`,`order_date_added`,`order_acceptence_time` FROM `orders`,`user` WHERE orders.order_status = 'complete' AND orders.order_user_id = user.id  ORDER BY orders.order_acceptence_time DESC LIMIT 0 , 10";                        $valueOBJ = $obj->query_db($query);                        $odd = 0;                        while($res = $obj->fetch_db_array($valueOBJ)) {                            ?>                            <li class="order-details" style="font-family: 'Lato'; font-weight: 300;"> <?php                                $Array = json_decode($res['order_details'] ,true);                                echo '<span class="order-list" style="color: #000000">';                                foreach($Array as $key => $val) {                                    if($key != 'TOTAL') {                                        echo $val['QTY'] . 'x '.$val['NAME'] .',';                                    }                                }?> <span class="" style="font-size: smaller"><?php echo  date('g:i a D M Y', strtotime($res['order_acceptence_time']));?></span><span class="red" style="font-size: smaller">                                Ordered By: <?php echo ($res['user_screen_name'] != '') ?  $res['user_screen_name'] : 'jff_cust '?> </span>                            </li>                            <?php                            $odd++;                        }                        ?>                    </ul>                    <div class="navigations">                        <ul>                            <li id="nt-example1-prev"></li>                            <li id="nt-example1-next"> </li>                        </ul>                    </div>                </div>            </div>        </div>    </div>    <section class="cus-padding" style="background-color: rgb(244, 248, 248); box-shadow:inset 0 0 7px #cac3aa">      <div class="container">        <h2 class="text-center">CHOOSE FROM THE BEST RESTAURANTS</h2>        <p class="text-center">We are proud to work with the best restaurants and outlets across the cities <br> to ensure we bring you that great taste you always desire.</p>        <div class="sep-center"></div>        <div class="my-carousel">          <div class="owl-carousel" id="restaurants">            <div class="item"> <img src="images/res-01.png" alt="featured image" > </div>            <div class="item"> <img src="images/res-02.png" alt="featured image" > </div>            <div class="item"> <img src="images/res-03.png" alt="featured image" > </div>            <div class="item"> <img src="images/res-04.png" alt="featured image" > </div>            <div class="item"> <img src="images/res-05.png" alt="featured image" > </div>            <div class="item"> <img src="images/res-03.png" alt="featured image" > </div>            <div class="item"> <img src="images/res-02.png" alt="featured image" > </div>          </div>        </div>      </div>    </section>    <div class="clearfix"></div>    <div class="row">      <div class="map-icon"><i class="fa fa-map-marker"></i></div>    </div>    <section class="cus-padding-normal dark">      <div class="container">        <h2 class="text-center white upper" style="font-weight: 300">CITIES WE COVER</h2>        <div class="sep-center"></div>        <div class="my-carousel">          <div id="cities" class="owl-carousel">            <div class="item cities">              <ul>                <li><img src="images/london.jpg" alt="featured image" ></li>                <li>London</li>              </ul>            </div>            <div class="item cities">              <ul>                <li><img src="images/birmingham.jpg" alt="featured image" ></li>                <li>Birmingham</li>              </ul>            </div>            <div class="item cities">              <ul>                <li><img src="images/manchester.jpg" alt="featured image" ></li>                <li>Manchester</li>              </ul>            </div>            <div class="item cities">              <ul>                <li><img src="images/Portsmouth.jpg" alt="featured image" ></li>                <li>Portsmouth</li>              </ul>            </div>            <div class="item cities">              <ul>                <li><img src="images/Leicester.jpg" alt="featured image" ></li>                <li>Leicester</li>              </ul>            </div>          </div>        </div>        </div>    </section>    <div class="clearfix"></div>    <?php include("templates/testimonial.php"); ?>    <?php include('templates/user-signup.php');?>    <?php include "templates/footer2.php";?></body></html>