<?php
/**
 * Created by PhpStorm.
 * User: ade
 * Date: 25/10/14
 * Time: 13:34
 */
ob_start("ob_gzhandler");
session_start();

include('include/functions.php');


$arr = array('drv_name', 'drv_email', 'drv_no', 'drv_location', 'drv_vehicle', 'drv_referrer', 'drv_details');

  foreach($arr as $details) {
    $drv[$details] = '';
  }

  $CLOSE_FANCY = false;

if(isset($_SESSION['access_key']) && isset($_POST['access']) && ($_POST['access'] == $_SESSION['access_key']) && ($_POST['submit'])) {

      header('Content-Type: application/json');

      $name = mysql_real_escape_string($_POST['drv_name']);
      $email = mysql_real_escape_string($_POST['drv_email']);
      $drv_detail = mysql_real_escape_string(strip_tags($_POST['drv_details']));
      $phone = $_POST['drv_no'];
      $location = $_POST['drv_location'];
      $vehicle = $_POST['drv_vehicle'];
      $referred = $_POST['drv_referred'];

      include_once('include/email-send.php');
      $status = false;

      $DETAILS = array(
        'type' => 'driver_email',
        'email' => admin_email(),
        'drv_email' => $email,
        'drv_name' => $name,
        'drv_no' => $phone,
        'drv_location' => $location,
        'drv_vehicle' => $vehicle,
        'drv_referred' => $referred,
        'drv_details'  => $drv_detail
      );


        SENDMAIL($DETAILS, false);

        //$status = true;
        $CLOSE_FANCY = true;
        echo json_encode( array('status' => 'email_sent', 'message' => 'Thanks for your interest.'));
        exit();

  }

  $_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());

?>

<!DOCTYPE html>
<html>
  <head lang="en-GB" class="no-js" xmlns="http://www.w3.org/1999/xhtml">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9">
    <meta name="content-language" content="en-GB">
    <meta name="author" content="Just-FastFood">
    <meta name="description" content="Just Fast Food - McDonalds | KFC | Burger King | Chinese | Subway & other Takeaways Deliveries! Order Online | Food Delivery">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="delivery driver, McDonalds delivery, online food delivery, kfc driver, nandos delivery, delivery service, courier">
    <title>Become A Courier. Join The Team</title>
    <link rel="shortcut icon" type="image/png" href="favicon.png" />
    <link rel="icon" type="image/png" href="favicon.png" />
    <!--CSS INCLUDES-->
    <link href="css/archivist.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/responsivemobilemenu.css" type="text/css"/>
    <link href="css/media.css" rel="stylesheet">
    <link href="css/flexslider.css" rel="stylesheet">
    <link href="css/CreativeButtons/css/default.css" rel="stylesheet">
    <link href="css/CreativeButtons/css/component.css" rel="stylesheet">
    <link href="css/bootstrapValidator.min.css" rel="stylesheet">
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.theme.css" rel="stylesheet">

    <style>
      .form-control {
        height: 46px;
      }

       label {
        font-size: 14px;
      }

    </style>

  </head>



  <body style="font-family: 'Lato', 'Open Sans'">
    <div class="wrapper">
      <?php include('templates/header2.php');?>
      <div class="metahead what-we-do" style="padding: 20px 0">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <h1 style="text-transform: none">Become a courier. Join the team.</h1>
            </div>
          </div>

        </div>
      </div>

      <div class="driver-cover" style="font-family: 'Lato', 'Open Sans'">
        <div class="container">
          <div class="col-md-6 col-lg-6 col-xs-6 col-md-offset-3">
            <h3 class="subheader" style="color: #ffffff">Earn up to &pound;8.50 / hour. Flexible work schedule.</h3>
          </div>
        </div>

      </div>


        <div class="content-section section_2">
          <div class="row">
          <div class="col-lg-7 col-md-6 col-xs-10">

            <div class="col-lg-8 col-md-6 col-xs-8 col-sm-push-2">
              <h4 class="just-info">Just-FastFood is a tech startup providing delivery for restaurants and fast food outlets. We bring convenience to our customers by delivering their favourite menus from choice of restaurants, and we help our restaurants grow by bringing them more customers and revenue. </h4>
              <p>We love people who are friendly and outgoing, because that's how we delight our customers. </p>
              <p>We operate every day between 11am-2pm and 4:30pm-10pm. You make your schedule each week. Work a few days or every day, it's up to you. If you're applying in London, we're operating all day between 11am and 10pm. The more you work, the more you earn!</p>
              <p>Our people loves us, they love their job because they make good money and work their own schedule. Join our team, lets keep putting smiles on faces.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-5 col-sm-5 col-xs-5 col-sm-pull-1">
              <div class="content-section-headings" id="feedback" style="display: none">
                <h3 class="event">Thank you for your interest.</h3>
                <h5 class="event">We'll review the information sent to us and get in touch.</h5>
                <h5 class="event"> Should you have any questions in the mean time, please <a href="mailto:info@just-fastfood.com">get in touch</a>.</h5>
                <h6 class="event">While you are here, why don't you have look around, check out the requirement and job details.</h6>
                <div class="twitter-button"><a href="https://twitter.com/JustFastFood" class="twitter-follow-button" data-width="85px" data-show-count="true" data-lang="en" data-show-screen-name="false">Follow</a></div>
                <div><iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FJustFastFoods&amp;width81&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:81px; height:21px;" allowTransparency="true"></iframe></div>

              </div>
              <form class="driver-apply-form driver-apply-padding driver-apply-roundbox form-horizontal" method="post" action="" id="driverForm">
                <div class="content-section-headings">
                  <h3 style="margin-bottom: 5px">Fill in the form below to join us.</h3>
                  <h5 class="content-section-subheader">We review most applications within 48 hours after which we schedule a phone interview.</h5>

                  <div class="form-group">
                    <label class="col-xs-3 control-label">Name<span class="required">*</span></label>
                    <div class="col-lg-7 col-xs-10 col-sm-9 col-md-8">
                      <input type="text" class="form-control input required" name="drv_name" placeholder="David Hart">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-3 control-label">Mobile Number<span class="required">*</span></label>
                    <div class="col-lg-7 col-xs-10 col-sm-9 col-md-8">
                      <input type="text" class="form-control input required" name="drv_no" placeholder="e.g 07896592644">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-3 control-label">Email<span class="required">*</span></label>
                    <div class="col-lg-7 col-xs-10 col-sm-9 col-md-8">
                      <input type="text" class="form-control input required" name="drv_email" placeholder="davidh@hotmail.com">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-3 control-label">Location<span class="required">*</span></label>
                    <div class="col-lg-7 col-xs-10 col-sm-9 col-md-8">
                      <select class="form-control input required" name="drv_location">
                        <option value="" disabled selected>Where are you based?</option>
                        <option value="London">London</option>
                        <option value="Birmingham">Birmingham</option>
                        <option value="Manchester">Manchester</option>
                        <option value="Southampton">Southampton</option>
                        <option value="Manchester">Manchester</option>
                        <option value="Leeds">Leeds</option>
                        <option value="Portsmouth">Portsmouth</option>
                        <option value="Leicester">Leicester</option>
                        <option value="other">Other </option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-xs-3  control-label">Vehicle<span class="required">*</span></label>
                    <div class="col-lg-7 col-xs-10 col-sm-9 col-md-8">
                      <select class="form-control input required" name="drv_vehicle">
                        <option value="" disabled selected>What type of vehicle?</option>

                        <option value="Motorbike">Motorbike</option>
                        <option value="Car">Car</option>
                        <option value="Scooter">Scooter</option>
                        <option value="Bicycle">Bicycle</option>
                      </select>
                    </div>
                </div>



                  <div class="form-group">
                    <label class="col-xs-3 control-label">Referred By(Optional)</label>
                    <div class="col-lg-7 col-xs-10 col-sm-9 col-md-8">
                      <input type="text" class="form-control input required" name="drv_referred" placeholder="">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-xs-3 control-label">Application Details<span class="required">*</span></label>
                    <div class="col-lg-7 col-xs-10 col-sm-9 col-md-8">
                      <textarea rows="5" cols="49" name="drv_details" class="form-control" placeholder="Please provide other information in support of your application?" style="font-size: 14px"></textarea>
                    </div>
                  </div>

                  <input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>

                  <div class="form-group">


                    <input type="submit" class="btn btn-6 btn-6a apply col-sm-push-2" name="submit" value="Submit"/>

                </div>
              </form>
            </div>
        </div>

      </div>
      <div class="row">
        <div class="page-section">
          <div class="row">
            <div class="col-md-9 col-xs-12 col-sm-6 col-sm-push-2" style="background: none repeat scroll 0 0 #f7f7f7; border-radius: 6px; margin-bottom: 0">
              <div class="col-lg-6 col-md-4 col-xs-12">
                <!--<h5 class="space" style="font-family: 'Lato'"><i class="fa fa-check-circle-o"></i>   Second section in this place</h5>
                <h5 class="space" style="font-family: 'Lato'"><i class="fa fa-check-circle-o"></i>   Third section in this place</h5>-->
                <h4 style="font-family: 'Lato'; font-weight: 600;">Details</h4>
                <ul class="list-unstyled">
                  <li class="event"><i class="fa fa-check text-success"></i> Our customers keep us in business, its our duty to delight them.</li>
                  <li class="event"><i class="fa fa-check text-success"></i> Our drivers make up to &pound;8.50/hr.</li>
                  <li class="event"><i class="fa fa-check text-success"></i> This is an independent contractor position.</li>
                  <li class="event"><i class="fa fa-check text-success"></i> Refer a driver and earn extra.</li>
                  <li class="event"><i class="fa fa-check text-success"></i> Monthly team meeting.</li>
                  <li class="event"><i class="fa fa-check text-success"></i> Room for progression within the company.</li>
                </ul>
              </div>
              <div class="col-lg-6 col-md-4 col-xs-12">
                <!-- <h5 class="space" style="font-family: 'Lato'"><i class="fa fa-check-circle-o"></i>   Fourth section in this place.</h5>-->
                <h4 style="font-family: 'Lato'; font-weight: 600">Requirement</h4>
                <ul class="list-unstyled" style="font-family: 'Lato'">
                  <li class="event"><i class="fa fa-check text-success"></i> Must be at least 18 years old with a smartphone (Any would do!).</li>
                  <li class="event"><i class="fa fa-check text-success"></i> Your own Scooter or Bike.</li>
                  <li class="event"><i class="fa fa-check text-success"></i> Polite with colleague and our customers.</li>
                  <li class="event"><i class="fa fa-check text-success"></i> Valid driving license.</li>
                  <li class="event"><i class="fa fa-check text-success"></i> Clean driving record.</li>
                  <li class="event"><i class="fa fa-check text-success"></i> 1 year driving experience.</li>
                </ul>
              </div>
            </div>
            </div>
        </div>
      </div>
    </div>
    <div class="page-section-2">
      <div class="row">
        <div class="col-md-7 col-xm 12 col-sm-6 col-lg-6 col-sm-push-3">
          <div class="content-section-headings">
            <h3 class="event">Work in your city.</h3>
            <h3 class="event">Money deposited into your account every week.</h3>

            <a href="#driverForm" class="btn btn-6 btn-6a applynow" name="apply" value="Apply Here">Apply Here</a>
          </div>
        </div>
      </div>
    </div>

    <?php include ("templates/footer2.php");?>

  </body>
</html>

