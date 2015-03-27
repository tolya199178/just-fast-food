<?php

session_start();
ob_start("ob_gzhandler");
include("include/functions.php");

$hide_form = "false";



$ARRAY = array( 'managerName', 'email', 'phoneno', 'city', 'postcode', 'resName','j_rest_delivery');



foreach($ARRAY as $v) {

    $ARRAYTEMP[$v] = '';

}



if(isset($_SESSION['access_key']) && isset($_POST['access']) && $_POST['access'] == $_SESSION['access_key']) {



    if(isset($_POST['SUBMIT'])) {



        include_once("include/email-send.php");



        $json_post = getEandN($_POST['j_postcode']);

        if($json_post) {



            $value = "NULL, ";

            $value .= "'0', ";

            foreach($ARRAY as $values) {

                $value .= "'".mysql_real_escape_string($_POST[$values])."', ";

            }

            $value .= "'pending', ";

            $value .= "'', ";

            $value .= "NULL";



            $extra = "`j_email` = '".$_POST['j_email']."'";

            $result = INSERT($value ,'join_restaurant' ,'unique' ,$extra);



            if($result) {



                $_SESSION['success'] = "Thank you for your interest in Just-FastFood. One of our Sales advisors will be in touch soon!";



                $hide_form = "true";

                unset($_SESSION['access_key']);

                $STRSEND = array(

                    'type' => 'new-join_rest',

                    'email' => $_POST['email'],

                    'user_email' => $_POST['email'],

                    'rest_name' => $_POST['resName'],

                    'post_code' => $_POST['postcode'],

                    'user_name' => $_POST['managerName'],

                    'phone_no' => $_POST['phoneno']

                );

                SENDMAIL($STRSEND , true);

            } else {

                foreach($ARRAY as $v) {

                    $ARRAYTEMP[$v] = $_POST[$v];

                }



                $_SESSION['error'] = "Email Address Already Exist!";

            }

        } else {

            foreach($ARRAY as $v) {

                $ARRAYTEMP[$v] = $_POST[$v];

            }



            $_SESSION['error']  = "ERROR!! Invalid Post Code. <span style='font-size:13px'>( Please enter only full UK postode)</span>";

        }

    }



}



$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());



?>



<!DOCTYPE html>



<html>

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <meta name="description" content="Restaurant owner.  Register on our website to reach more customers. Profit maximization and Sales increase">

    <meta name="keywords" content="Account Creation!, <?= getDataFromTable('setting','keywords'); ?>">

    <meta name="author" content="Just-FastFood">



    <title>Restaurant Owner - Put Your Restaurant Online. Signup to reach more customers</title>

    <link rel="shortcut icon" type="image/png" href="favicon.png" />

    <link rel="icon" type="image/png" href="favicon.png" />

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




  <script>
    (function(f,b,g){
      var xo=g.prototype.open,xs=g.prototype.send,c;
      f.hj=f.hj||function(){(f.hj.q=f.hj.q||[]).push(arguments)};
      f._hjSettings={hjid:7206, hjsv:2};
      function ls(){f.hj.documentHtml=b.documentElement.outerHTML;c=b.createElement("script");c.async=1;c.src="//static.hotjar.com/c/hotjar-7206.js?sv=2";b.getElementsByTagName("head")[0].appendChild(c);}
      if(b.readyState==="interactive"||b.readyState==="complete"||b.readyState==="loaded"){ls();}else{if(b.addEventListener){b.addEventListener("DOMContentLoaded",ls,false);}}
      if(!f._hjPlayback && b.addEventListener){
        g.prototype.open=function(l,j,m,h,k){this._u=j;xo.call(this,l,j,m,h,k)};
        g.prototype.send=function(e){var j=this;function h(){if(j.readyState===4){f.hj("_xhr",j._u,j.status,j.response)}}this.addEventListener("readystatechange",h,false);xs.call(this,e)};
      }
    })(window,document,window.XMLHttpRequest);
  </script>
</head>



<body>



<div class="wrapper">

    <?php include('templates/header2.php');?>

    <div class="metahead what-we-do" style="padding: 20px 0">

        <div class="container">

            <div class="row">

                <div class="col-sm-12">

                    <h1>Restaurant Owner</h1>



                </div>

            </div>



        </div>

    </div>



    <div class="section_inner" >

        <div class="container">

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

              <h2 style="text-transform: none">Why Just-FastFood?</h2>

              <p class="small">"One of the best marketing and business move"</p>

              <hr class="hr">

            <p class="small">

                <span class="">

                    The future of business is online

                </span>

            </p>

              <ul>

                  <li>Just-FastFood users are growing tremendously daily.</li>

                  <li>10 million hungry surfers - On average, people using the internet every day order takeaway twice a month.</li>

                  <li>Customers can pay by card, PayPal or Cash on a secure website.</li>

              </ul>

              <p class="small">

                <span class="">

                    More customers, more sales

                </span>

              </p>

              <ul>

                  <li>Average revenue increase ranges from 15-25% a year.</li>

                  <li>You don't have to invest in marketing, we do all the work.</li>

                  <li>We ensure you can be reached by local customers.</li>

              </ul>

              <p class="small"><span class="">

                      You don't have delivery services? Don't worry</span><br/>

              <ul>

                  <li>We do delivery for you if your restaurants hasn't got one already.</li>

                  <li>Just get the food ready, our delivery guys will come pick it up and deliver to your customers.</li>

                  <li>Makes you focus on whats important ensuring good food is prepared and we do the rest.</li>

              </ul>

              </p>

              <p class="small"><span class="">

                      No signup fees</span><br/>

              <ul>

                  <li>It's <strong>FREE</strong> to join us. No extra or hidden fees.</li>

                  <li>Invite or recommend a restaurant and get cash back.</li>

                  <li>Dedicated portal and account manager.</li>

              </ul>

              </p>

              <hr class="hr"/>

          </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">



                <h2 style="text-transform: none">It's easy to join us.</h2>

                <p class="small">Just fill in the form below and one of our account manager will be in touch</p>

                <hr class="hr"/>

                <form class="form-horizontal login-form" id="res-signup-form" method="post" action="">

                    <div class="form-group">

                        <label class="col-lg-3 control-label">

                            Manager's Name

                            <span class="required">*</span>

                        </label>

                        <div class="col-lg-6">

                            <input id="j_managerName" class="form-control" type="text" value="" title="Enter your Manager's name" placeholder="Enter your Manager's name..." name="managerName"/>

                        </div>

                    </div>

                    <form class="form-horizontal login-form" method="post" action="">

                        <div class="form-group">

                            <label class="col-lg-3 control-label">

                                Email Address

                                <span class="required">*</span>

                            </label>

                            <div class="col-lg-6">

                                <input id="j_email" class="form-control" type="email" value="" title="Enter your email" placeholder="Enter your email..." name="email"/>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-lg-3 control-label">

                                Phone No

                                <span class="required">*</span>

                            </label>

                            <div class="col-lg-6">

                                <input id="j_phone" class="form-control" type="text" value="" title="Enter your Phone" placeholder="Enter your phone no..." name="phoneno"/>

                            </div>

                        </div>



                        <div class="form-group">

                            <label class="col-lg-3 control-label">

                                Restaurant Name

                                <span class="required">*</span>

                            </label>

                            <div class="col-lg-6">

                                <input id="j_resname" class="form-control" type="text" value="" title="Enter your Password" placeholder="Enter your restaurant name..." name="resName"/>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-lg-3 control-label">

                                Cuisines

                                <span class="required">*</span>

                            </label>

                            <div class="col-lg-6">

                                 <select class="form-control">

                                    <option value="Please Select">-Please Select-</option>

                                     <option value="American">American</option>

                                     <option value="Balti">Balti</option>

                                     <option value="Bangladeshi">Bangladeshi</option>

                                     <option value="Brazilian">Brazilian</option>

                                     <option value="Breakfast">Breakfast</option>

                                     <option value="Burgers & Chicken">Burgers & Chicken</option>

                                     <option value="Cantonese">Cantonese</option>

                                     <option value="Caribbean">Caribbean</option>

                                     <option value="Charcoal Chicken">Charcoal Chicken</option>

                                     <option value="Chinese">Chinese</option>

                                     <option value="Desserts">Desserts</option>

                                     <option value="Dim Sum">Dim Sum</option>

                                     <option value="Egyptian">Egyptian</option>

                                     <option value="Fish & Chips">Fish & Chips</option>

                                     <option value="French">French</option>

                                     <option value="Gastro">Gastro</option>

                                     <option value="Greek">Greek</option>

                                     <option value="Halal">Halal</option>

                                     <option value="Hungarian">Hungarian</option>

                                     <option value="Indian">Indian</option>

                                     <option value="Italian">Italian</option>

                                     <option value="Japanese">Japanese</option>

                                     <option value="Jerk Chicken">Jerk Chicken</option>

                                     <option value="Kebab">Kebab</option>

                                     <option value="Korean">Korean</option>

                                     <option value="Lebanese">Lebanese</option>

                                     <option value="Malaysian">Malaysian</option>

                                     <option value="Mexican">Mexican</option>

                                     <option value="Modern British">Modern British</option>

                                     <option value="Moroccan">Moroccan</option>

                                     <option value="Nepalese">Nepalese</option>

                                     <option value="Nigerian">Nigerian</option>

                                     <option value="Organic">Organic</option>

                                     <option value="Oriental">Oriental</option>

                                     <option value="Pakistani">Pakistani</option>

                                     <option value="Peking">Peking</option>

                                     <option value="Persian">Persian</option>

                                     <option value="Pizza">Pizza</option>

                                     <option value="Polish">Polish</option>

                                     <option value="Portuguese">Portuguese</option>

                                     <option value="Russian">Russian</option>

                                     <option value="Salads">Salads</option>

                                     <option value="Sandwiches">Sandwiches</option>

                                     <option value="Soups">Soups</option>

                                     <option value="South Indian">South Indian</option>

                                     <option value="Spanish">Spanish</option>

                                     <option value="Sri Lankan">Sri Lankan</option>

                                     <option value="Sushi">Sushi</option>

                                     <option value="Syrian">Syrian</option>

                                     <option value="Tapas">Tapas</option>

                                     <option value="Thai">Thai</option>

                                     <option value="Turkish">Turkish</option>

                                     <option value="Vegetarian">Vegetarian</option>

                                     <option value="Vietnamese">Vietnamese</option>

                                     <option value="Other">Other</option>

                                 </select>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-lg-3 control-label">

                               Do you have delivery service?

                                <span class="required">*</span>

                            </label>

                            <div class="col-lg-6">

                                <select class="form-control" name="j_rest_delivery">

                                    <option value="Select">-Select-</option>

                                    <option value="Yes">Yes</option>

                                    <option value="No">No</option>

                                </select>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-lg-3 control-label">

                                City

                                <span class="required">*</span>

                            </label>

                            <div class="col-lg-6">

                                <input id="j_city" class="form-control" type="text" value="" title="Enter your City" placeholder="Enter your city..." name="city"/>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-lg-3 control-label">

                                Postcode

                                <span class="required">*</span>

                            </label>

                            <div class="col-lg-6">

                                <input id="j_postcode" class="form-control" type="text" value="" title="Enter your Postcode" placeholder="Enter your postcode..." name="postcode"/>

                            </div>

                        </div>



                        <div class="form-group">

                            <label class="control-label"></label>

                            <input class="custom_submit_button red_btn2" type="submit" value="Done">

                        </div>

                        <p class="last">

                            By clicking the button you agree to the <a target="_blank" href="terms.php">Terms of Use</a> and

                            <a target="_blank" href="privacy.php">Privacy Policy</a>

                        </p>

                    </form>





            </div>



        </div>

            </div>

        </div>

    </div>

<?php include('templates/footer2.php');?>

</body>

</html>