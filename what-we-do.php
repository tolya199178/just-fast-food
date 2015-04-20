<?php







session_start();


//ob_start("ob_gzhandler");




include("include/functions.php");

?>

<!DOCTYPE html>

<html>

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <meta name="description" content="Just-FastFood - Order KFC delivery, McDonalds delivery, Burger King, Subway and many more. At your door in 45 minutes! Order Online. Get 10% OFF!">

    <meta name="keywords" content="Just-FastFood!, <?= getDataFromTable('setting','keywords'); ?>">

    <meta name="author" content="Just-FastFood">

    <title>Fast Food Delivery - McDonalds | KFC Delivery | Nandos | Burger King - Food Delivery </title>

    <!--CSS INCLUDES-->

    <link rel="shortcut icon" type="image/png" href="favicon.png" />

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,900' rel='stylesheet' type='text/css'>

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

    <link href="css/archivist.css?v1.2.6" rel="stylesheet">

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

                    <h1>WHAT WE DO</h1>

                </div>

            </div>

        </div>

    </div>

    <div class="section_nner">

        <div class="container" style="background-color: rgb(251, 252, 252); width: 100%">

            <div class="col-sm-8 col-sm-offset-2">

                <h2>

                    Want your favourite burger joint, but hate the traffic and long lines? or just need a food courier to get your food from your favourite restaurant? We will facilitate & pick up your food from any restaurant of choice and deliver within 45 minutes.

                </h2>

                <h3>

                    Your single destination for all your online food delivery

                </h3>

                <p>Just-FastFood.com is your single destination for online food ordering and delivery. We provide independent delivery services for fast food outlets such as McDonalds, KFC, Burger King, Subway and many more bringing tasty meals to your doorstep in less than an hour. We also partner with takeaways outlets such as Chinese, Thai, Indian, Italian, American restaurants to ensure your food is delivered in a timely manner.</p>

                <p>Simply choose your favourite restaurant or fast food outlet, select menus and place your order online. If we don't have your choice of restaurant on our website, please chat with <a href="#" onclick="return SnapEngage.startLink();">Debra</a> online and we'll add this for you. Happy Ordering ! </p>

              <h3>

                Enjoy variety of dishes at home or office

              </h3>

              <p>We deliver Fast Food, Chinese, Thai, Turkish, Lebanese Food, Spanish, Chinese, Seafood, Mexican, Italian, Indian, Japanese, Burgers, Pizza, Greek, McDonalds, KFC, Subway, Burger King, YO! Sushi, Strada, Chiquitos, Uncle Sams, Wagamama plus many more, all delivered right to your home or office.. Should you want any additional menu requirements or requests, please contact us <a href="#"  onclick="return SnapEngage.startLink();">online</a>.</p>


              <h3>

                    Very easy ordering steps

                </h3>

                <p>

                    You can place your order easily by entering your postcode and choosing your choice of restaurant or fast food outlets. We currently accept PayPal and Cash on delivery. Once payment is confirmed, we give you an estimated delivery time. Usually, we deliver under an hour. We also collect and deliver from any restaurants or takeaway outlets that do not offer delivery services. Please speak to a member of the team online.

                </p>




                <h3>

                    Get Rewarded

                </h3>

                <p>Earn points on your order and redeem anytime.</p>

                <!-- <small>P.S : We recently just launched our new website and still updating some of our data. If there's something you need or having trouble using our website, please speak to us online and we'll resolve this promptly.</small> -->

               <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 col-lg-offset-4 col-md-offset-3 col-sm-offset-3">

                   <form class="form-horizontal form-started" action="#">

                       <input class="btn btn-lg btn-primary btn-block" type="submit" value="Ready to order?" id="post-code-lets-begin"/>



                   </form>

               </div>



                <div class="modal fade" id="find-pc-modal" tabindex="-1" role="dialog" aria-labelledby="find-pc-modal" aria-hidden="true" style="overflow:hidden; z-index:99999999999999999999;">

                    <div class="modal-dialog">

                        <form id="find-pc-modal-form" class="form-horizontal">

                            <div class="modal-content" style="overflow: hidden;">

                                <div class="modal-header">

                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                                    <h4 class="modal-title">Ready to order?</h4>

                                </div>

                                <div class="modal-body" style="overflow: hidden;">

                                    <div class="col-lg-11">
                                      <div class="form-group has-feedback">

                                        <label class="col-lg-3 control-label" for="user_phone" style="font-size: 1em">Enter your postcode <span class="required">*</span></label>

                                        <div class="col-lg-6">

                                          <input type="text" required="" name="ukpostcode" id="postcodeuk" class="form-control" autocomplete="off" placeholder="SW7 5HR"/>

                                        </div>

                                      </div>
                                    </div>

                                </div>

                                <div class="modal-footer">

                                    <input type="submit" value="Continue" name="submit" class="btn btn-custom"/>

                                </div>

                            </div>

                        </form>

                    </div><!-- /.modal-content -->

                </div><!-- /.modal-dialog -->

            </div><!-- /.modal -->

            <script>

                $(document).ready( function(){

                    $('#post-code-lets-begin').click( function(e) {
                      e.preventDefault();
                        $('#find-pc-modal').modal();

                    });



                    $("#find-pc-modal-form").bootstrapValidator({

                        submitHandler: function(form) {
                            var dataPostCode = $('#find-pc-modal-form #postcodeuk');

                            var val = dataPostCode.val();

                            if(val.length == 6) {

                                var first3 = val.substr(0, 3);

                                var lastPart = val.substr(3, val.length);

                                val = first3+'-'+lastPart;

                            } else {

                                var first4 = val.substr(0, 4);

                                var last4  = val.substr(4, val.length);

                                val = first4 + '-'+last4;

                            }



                            if (val.indexOf(' ') >= 0){

                                val = val.replace(' ','');

                            }

                            window.location.href = 'Postcode-' + val;

                            return false;

                        },

                        message: 'This value is not valid',

                        feedbackIcons: {

                            valid: 'fa fa-check-circle-o fa-lg',

                            invalid: 'glyphicon glyphicon-remove',

                            validating: 'glyphicon glyphicon-refresh'

                        },

                        fields: {

                            ukpostcode: {

                                validators: {

                                    notEmpty: {

                                        message: 'Postcode is required and cannot be empty'

                                    },

                                    zipCode: {

                                        country: 'GB',

                                        message: 'The value is not a valid UK postcode'

                                    }

                                }

                            }

                        }

                    });

                });

            </script>

        </div>

    </div>

</div>

<?php include ('templates/desc.php');?>

<div class="why_us">

    <div class="container">

        <div class="sec_title"><h2 class="text-center white" >Why Just-FastFood?</h2></div>

        <div class="why_list col-lg-6">

            <ul>

                <li><img src="images/on_time.png"></li>

                <li>Very easy to use <span>Efficient, intuitive and simple online ordering.</span></li>

            </ul>

        </div>

        <div class="why_list col-lg-6">

            <ul>

                <li><img src="images/low_cost.png"></li>

                <li>Re-ordering has never been easy<span>A complete and accurate history of all your past order for easy reordering in as little as three clicks.</span></li>

            </ul>

        </div>

        <div class="why_list col-lg-6">

            <ul>

                <li><img src="images/talk.png"></li>

                <li>No communication barriers<span>Elimination of phone order misunderstandings arising from communication barriers</span></li>

            </ul>

        </div>

        <div class="why_list col-lg-6">

            <ul>

                <li><img src="images/refund.png"></li>

                <li>Instant Refund Facility<span>In a situation where we are not able to deliver or the menu ordered is not available, we have instant refund facility back into your Card or PayPal account.</span></li>

            </ul>

        </div>

    </div>

</div>

<div class="message_block">

    <div class="container">

        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"><h3 class="white" style="text-transform: none; font-weight: 300">Need a corporate account? <span>Signup</span> and get your favourite meal delivered daily</h3></div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

            <div class="custom_button red_btn ">

                <ul>

                    <li><a href="corporate-user.php">Get Started !</a></li></ul>

            </div>

        </div>

    </div>

</div>



<?php include('templates/testimonial.php');?>

<?php include('templates/user-signup.php');?>

<?php include('templates/footer2.php');?>

</body>

</html>