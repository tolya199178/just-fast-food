<?php



session_start();

ob_start("ob_gzhandler");

include("include/functions.php");



?>

<!DOCTYPE html>



<html>

<head>

<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9">

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<meta name="description" content="Just Fast Food - McDonalds | KFC | Burger King | Chinese | Nandos & other Takeaways Delivery! Order Online">

<meta name="keywords" content="What We Do!, <?= getDataFromTable('setting','keywords'); ?>">

<meta name="author" content="Just-FastFood">

<title>How It Works | Order Online - McDonalds | KFC | Nandos | Burger King - Home & Office Delivery</title>



<link href="css/archivist.css?v1.2.3" rel="stylesheet">

<link href="css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="css/responsivemobilemenu.css" type="text/css"/>

<link href="css/media.css" rel="stylesheet">

<link href="css/flexslider.css" rel="stylesheet">



<link href="css/owl.carousel.css" rel="stylesheet">

<link href="css/owl.theme.css" rel="stylesheet">





</head>



<body>

<div class="wrapper">



<?php include('templates/header2.php');?>



<div class="metahead what-we-do">

    <div class="container">

        <div class="row">

            <div class="col-sm-12">

                <h1>How It Works</h1>

            </div>

        </div>



    </div>

</div>



<style>
  .steps .col-md-4 .img {
    height: 200px;
    background-size: 100%;
    background-repeat: no-repeat;
  }
  .steps h4,
  .steps p {
    text-align: center !important;
  }
  .steps .col-md-4:first-child .img {
    background-image: url('images/place-order.png');
    background-size: 60%;
    background-position: 60px 0px;
  }
  .steps .col-md-4:nth-child(2) .img {
    background-image: url('images/jff-retaurant-900.png');
  }
  .steps .col-md-4:nth-child(3) .img {
    background-image: url('images/fast-delivery.png');
    background-size: 50% auto;
    background-position: 60px 0px;
  }
  @media only screen and (max-width: 320px) {
    .steps .col-md-4 .img {
      height: 100px;
    }
    .steps .col-md-4 {
      margin-top: 40px;
    }
  }
  @media only screen and (min-width: 360px) and (max-width: 360px) {
    .steps .col-md-4 .img {
      height: 130px;
    }
    .steps .col-md-4 {
      margin-top: 60px;
    }
  }
  @media only screen and (min-width: 480px) and (max-width: 480px) {
    .steps .col-md-4 .img {
      height: 160px;
    }
    .steps .col-md-4:first-child .img {
      background-position: 120px 0px;
      background-size: 50% auto;
    }
    .steps .col-md-4:nth-child(3) .img {
      background-position: 90px 0px;
    }
    .steps .col-md-4 {
      margin-top: 40px;
    }
  }
  @media only screen and (min-width: 640px) and (max-width: 640px) {
    .steps .col-md-4:first-child .img {
      background-position: 180px 0px;
      background-size: 40% auto;
    }
    .steps .col-md-4 .img {
      height: 180px;
    }
    .steps .col-md-4:nth-child(2) .img {
      background-position: 100px 0px;
      background-size: 60% auto;
      height: 130px;
    }
    .steps .col-md-4:nth-child(3) .img {
      background-position: 140px 0px;
      background-size: 40% auto;
    }
    .steps .col-md-4 {
      margin-top: 60px;
    }
  }
  @media only screen and (min-width: 768px) and (max-width: 768px) {
    .steps .col-md-4:first-child .img {
      background-position: 250px 0px;
      background-size: 30% auto;
    }
    .steps .col-md-4 .img {
      height: 160px;
    }
    .steps .col-md-4:nth-child(2) .img {
      background-position: 150px 0px;
      background-size: 50% auto;
      height: 130px;
    }
    .steps .col-md-4:nth-child(3) .img {
      background-position: 200px 0px;
      background-size: 30% auto;
      height: 180px;
    }
    .steps .col-md-4 {
      margin-top: 60px;
    }
  }

</style>


<!--<div class="slider_light_brown">

<div class="container">

<div class="sec_title"><h1 class="text-center">3 simple steps</h1></div>
<br/>
<div class="steps col-md-12" style="font-family: 'Lato'">
        
        <div class="col-md-4">
             <div class="img"></div>
            <h4 style="font-family: 'Lato'; font-weight: 600">Select your menus</h4>
            <p>Simply enter your postcode and choose your favourite restaurant and menus.</p>
        </div>

        <div class="col-md-4">
             <div class="img"></div>
            <h4 style="font-family: 'Lato'; font-weight: 600">We send the details to the restaurant</h4>
            <p>We immediately beam your order to the restaurant, once accepted you receive confirmation email with delivery or pickup estimates.</p>
        </div>

        <div class="col-md-4">
             <div class="img"></div>
            <h4 style="font-family: 'Lato'; font-weight: 600">Pickup & Deliver</h4>
            <p>Our drivers picks up your order and deliver within 45 minutes!</p>
        </div>
                      
        <!--<img src="images/4_step.png"  class="img-responsive" alt="4steps">-->

<?php include ('templates/desc.php');?>

</div>

<!--<div class="payments"> NO CASH? NO PROBLEM! PAY BY CASH OR PAYPAL</div>

<div class="payment_logos"><img src="images/payemnt.png"></div>-->


<div class="why_us">



<div class="container">

<div class="sec_title"><h2 class="text-center white" >Why Just-FastFood?</h2></div>



<div class="why_list col-lg-6">

<ul>

<li><img src="images/on_time.png"></li>

<li>We are on time <span>We ensure your food doesn't get cold before we deliver.</span></li>

</ul>

</div>

<div class="why_list col-lg-6">

<ul>

<li><img src="images/talk.png"></li>

<li>Talk to us anytime<span>We're available on our Live Chat to attend to any inquiries you may have.</span></li>

</ul>

</div>

<div class="why_list col-lg-6">

<ul>

<li><img src="images/on_time.png"></li>

<li>Affordable delivery charges<span>Our delivery charge is based on the distance between you and your chosen fastfood or takeaway outlets.</span></li>

</ul>

</div>

<div class="why_list col-lg-6">

<ul>

<li><img src="images/talk.png"></li>

<li>Instant Refund Facility<span>In a situation where we are not able to deliver or the menu you ordered is not available, we have an instant refund facility back into your Card or PayPal account.</span></li>

</ul>

</div>





</div>

</div>


<div class="message_block">

<div class="container">

<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"><h3 class="white">Do you Own A Restaurant ? Get more businesses...</h3></div>

<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

<div class="custom_button red_btn ">

<ul>

<li><a href="restaurant-owner.php">Get Started !</a></li></ul>

</div>



</div>





</div>

</div>











    <?php include "templates/testimonial.php";?>



    <div class="clearfix"></div>







<?php include("templates/footer2.php");?>

</div>





</body>

</html>