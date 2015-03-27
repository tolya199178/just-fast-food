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
    <meta name="description" content="Just Fast Food - Privacy">
    <meta name="keywords" content="Account Creation!, <?= getDataFromTable('setting','keywords'); ?>">
    <meta name="author" content="Just-FastFood">

    <title>Just-FastFood - Frequently Asked Questions</title>
    <link rel="shortcut icon" type="image/png" href="favicon.png" />
    <link rel="icon" type="image/png" href="favicon.png" />
    <link href="css/archivist.css?v1.0.0" rel="stylesheet">
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
                    <h1 style="text-transform: none">Frequently Asked Questions</h1>
                </div>
            </div>

        </div>
    </div>

    <div class="section_inner" style="background-color: #f6f8f8; ">
        <div class="container">
            <div class="row">
                <div class="span1">
                    <h3 class="nocaps">How does this work?</h3>
                    <p class="last">Simply put, we deliver your favourite menu from restaurants of choice. Our platform  enables you to enter your postcode and select a nearby restaurant of choice e.g McDonalds, KFC, Nandos, Wagamama e.t.c for delivery. Within each of these restaurants you will find their menus which you can add to basket, choose your payment method (PayPal or Credit / Debit Card) and submit. There you go, your order is sent to the selected restaurant or the nearby delivery driver where applicable. </p>
                    <h3 class="nocaps">Are your menu prices the same as those at the restaurant?</h3>
                    <p class="last">For many of our restaurants, the prices you pay on Just-FastFood are the same as you would pay in store. However, sometimes they are different and for different reasons. When merchants sign onto our network, they pay us a commission fee to help cover the cost of our delivery fleet. To help pay part of their commission, some merchants have decided to add a slight increase to certain menu items.

                      Other times, prices are different because most restaurant menus online - especially from third-party websites - are outdated. As a result, there will be a perceived difference in price and it's a constant challenge for our team to make sure we have the correct prices. As a result, Just-FastFood's prices are sometimes lower or higher than what appears on the menus at restaurants.

                    </p>
                  <h3>Can I order from different restaurant at the same time?</h3>
                  <p class="last">Yes! We charge a flat fee for restaurant where you place an order. For instance, you can order some menus from Wagamama and KFC, you'd be paying double in total for delivery cost.</p>
                  <h3 class="nocaps">The restaurant I want is not on the website?</h3>
                    <p class="last">If your choice of restaurant is not on the website, please click <a href="#" onclick="return SnapEngage.startLink()";>here</a> or email <a href="mailto:support@just-fastfood.com">support@just-fastfood.com</a> to chat with a customer representative who will work with you to ensure the restaurant is added and you can easily place your order. Otherwise, we'll ask you to place your order directly with the restaurant and ask one of our drivers close to that area to pick up for you. </p>
                    <h3 class="nocaps">Some menus are missing on a restaurant page?</h3>
                    <p class="last">We've had this one or two times. Please chat with <a href="#" onclick="return SnapEngage.startLink()";>Debra</a> online and she'll get the missing menu up in no time.</p>
                    <h3 class="nocaps">How does the corporate user account work?</h3>
                    <p class="last">With our corporate user account, you can set up an account for the whole company or an employee. Once an account is created, we'll send you an email with your login information which anyone in the company can use to place order without having to pay. We then issue an invoice at the end of every month for payments. </p>
                    <h3 class="nocaps">How do I specify the sides and drinks for my order?</h3>
                    <p class="last">As we know, there are meal item that comes with sides and drinks, we have a comment box for this. Once you've selected your menus and clicked continue, you will find a box asking you to provide any information to the driver regarding your order. You can use this box to provide any information you want the driver to know about your order. This includes asking the driver to provide you with : Ketchups, BBQ Sauce, Peri Peri Sauce, Salted Fries, Diet Coke or even how spicy you want your chicken!</p>
                    <h3 class="nocaps">Menu prices on the website seems a bit higher than the restaurant?</h3>
                    <p class="last">We know it would be ridiculous to charge a very high fee for the delivery charge, that's why we decided to add extra bits on each menu to cover our cost and reduce the delivery charge to ensure this is affordable for all.</p>
                    <h3 class="nocaps">Do you deliver from any restaurants?</h3>
                    <p class="last">Yes, we deliver all kind of food from top restaurants. For your KFC delivery, McDonalds delivery and online food delivery - We'll pick your food from your favourite restaurant and deliver under 45 minutes. </p>
                    <h3 class="nocaps">Delivery cost is too high?</h3>
                    <p class="last">This is due to the distance between the postcode entered and the nearest restaurant on our website. To resolve this, kindly <a  href="#" onclick="return SnapEngage.startLink()";>chat with us online</a> and we'll try to get a nearby restaurant on the website which will reduce your delivery costs. We wouldn't be able to do anything to the delivery cost unless its more than &pound;5.99.</p>
                    <h3 class="nocaps">Will my food get cold?</h3>
                    <p class="last">We do our best to ensure your food is still hot or at least warm when you receive. We'll never deliver you cold meal.</p>
                    <h3 class="nocaps">How long will my order take to arrive?</h3>
                    <p class="last">We try to ensure you get your under within 45 minutes. But at times due to restaurants queues and menu ordered being freshly prepared by the restaurant, this may affect our delivery time. You can be rest assured we will deliver as soon as we pick up (this is mostly within an hour)!</p>
                    <h3 class="nocaps">My order was cancelled?</h3>
                    <p class="last">Sometimes the driver in your area could be driving to customer's address and not able to accept order instantly, we'll usually work with you to get your order to another driver nearby. Please speak to us online regarding this or just place your order again after 30 minutes. </p>
                    <h3 class="nocaps">How long does refunds take?</h3>
                    <p class="last">Sometimes it takes about a day or two to have payments in our PayPal account and could take about the same to reflect in yours once your refund is processed. </p>
                    <h3 class="nocaps">When are you coming to my city?</h3>
                    <p class="last">We are currently working on expanding to other parts of the country. Please let us know where you are and we'll add this to our roadmap.</p>
                </div>
            </div>
        </div>
    </div>
    <?php include('templates/user-signup.php');?>

</div>
<?php include("templates/footer2.php");?>
</body>
</html>