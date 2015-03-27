<?php
    session_start();
ob_start("ob_gzhandler");
    include("include/functions.php");

    $success = FALSE;
    if(isset($_SESSION['access_key']) && isset($_POST['access']) && $_POST['access'] == $_SESSION['access_key']) {
        if(isset($_POST['SUBMIT']) && ($_POST['name'] != "") && ($_POST['message'] != "") || ($_POST['email'] != "")) {

            $to = admin_email();
            $name = mysql_real_escape_string(strip_tags($_POST['name']));
            $email = mysql_real_escape_string(strip_tags($_POST['email']));
            $phone = mysql_real_escape_string(strip_tags($_POST['phone']));

            $message = '<strong>'.$name." Wants To Contact  Just-FastFood.com.<br/> His/Her Email : ".$email.'.<br/> Phoneno : '.$phone.'</strong><br/>';
            $message .= '"<i>'.mysql_real_escape_string(strip_tags($_POST['message'])).'</i>"';

            $subject = $_POST['subject']." | Contact us Email";
            $headers = "From:Just-FastFood <info@just-fastfood.com>\r\n";
            $headers .= 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            if(mail($to, $subject, $message, $headers)) {
                $_SESSION['success'] = "Message Sent";
                $success = TRUE;
            } else {
                $_SESSION['error'] = "Email Not Sent";
            }
        } else {
            $_SESSION['error'] = "Fill All Field";
        }
    }

    $_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Just Fast Food - Contact us - Order Food Online - Fast Food Online">
    <meta name="author" content="Just-FastFood">
    <title>Contact Us | Just-FastFood</title>
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
    <div class="metahead what-we-do" style="padding: 20px 0">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1 style="text-transform: none">Reach out to us</h1>
                </div>
            </div>

        </div>
    </div>

<?php if($success) { ?>
<div class="modal fade" id="email-sent-modal" style="z-index:999999999; overflow: hidden;" tabindex="-1" role="dialog" aria-labelledby="email-sent-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">E-mail Sent</h4>
      </div>
      <div class="modal-body">
      <p>Thanks for your email. Someone will be in touch within 2 hours</p>
      </div>
      <div class="modal-footer">
         <button id="index-go" type="button" class="btn" data-dismiss="modal">Ok</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
$(document).ready(function(){
    setTimeout(function(){
       $('#email-sent-modal').modal({ backdrop: 'static', keyboard: false })     
    }, 700); 
    $('#index-go').click(function(){
        window.location.href = '/';
    });
    console.log(<?php echo $_SESSION['error']; ?>);
});
</script>
<?php } ?>
<script>
 console.log(<?php echo $_SESSION['error']; echo $_SESSION['error']; ?>);
</script>
        <div class="container" style="width: 100%">
            <div class="row">
                <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-body col-md-12">
                                    <div class="row" style="margin-top: -16px; margin-bottom:16px;">
                                         <div id="google_map" style="width:100%; height:400px;"></div>
                                    </div>
                                    <div class="col-md-12">
                                         <div class="col-md-6">
                                                <form id="contact-form" class="form-horizontal" method="post" action="contact.php">
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label" for="name">Name<span class="required">*</span></label>
                                                        <div class="col-lg-7">
                                                            <input id="name" class="form-control" type="text" value="" title="Enter your name" placeholder="Enter your Name..." name="name"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label" for="email">Email Address<span class="required">*</span></label>
                                                        <div class="col-lg-7">
                                                            <input id="email" class="form-control" type="text" value="" title="Enter your email" placeholder="Enter your email..." name="email"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label" for="phone">Phone No.<span class="required">*</span></label>
                                                        <div class="col-lg-7">
                                                            <input id="phone" class="form-control" type="text" value="" title="Enter your phone number" placeholder="Enter your phone number..." name="phone"/>
                                                        </div>
                                                    </div>                                                   
                                                    <div class="form-group">
                                                        <label class="col-lg-3 control-label" for="email">Subject<span class="required">*</span></label>
                                                        <div class="col-lg-7">
                                                                <select name="subject" id="subject" class="form-control">
                                                                    <option value="General Inquiry">General Inquiry</option>
                                                                    <option value="I Did Not Receive My Order">I Did Not Receive My Order</option>
                                                                    <option value="Suggest A Restaurant">Suggest A Restaurant</option>
                                                                    <option value="Issue With Our Website">Issue With Our Website</option>
                                                                    <option value="Problem With Your Order">Problem With Your Order</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" style="position: relative;"> 
                                                        <label class="col-lg-3 control-label">Message</label>
                                                      <div class="col-lg-7 col-md-9 col-xs-10 col-sm-9">
                                                        <textarea name="message" class="form-control" rows="7" style="resize: vertical;"></textarea>

                                                      </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label"></label>
                                                        <input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
                                                        <input class="custom_submit_button red_btn2" type="submit" value="Submit" name="SUBMIT" />
                                                    </div>
                                                    <p class="last">
                                                        By clicking the button you agree to the <a target="_blank" href="terms.php">Terms of Use</a> and
                                                        <a target="_blank" href="privacy.php">Privacy Policy</a>
                                                    </p>
                                                </form>                                        
                                         </div>
                                         <div class="col-md-offset-2 col-md-4">
                                                <div class="panel panel-default">
                                                    <div class="panel-body">                               
                                                        <address>
                                                          <strong>Just FastFood</strong><br>
                                                            45-157 ST JOHN STREET<br>
                                                            LONDON, ENGLAND<br>
                                                            EC1V 4PW<br>
                                                            <abbr title="Phone">E-mail:</abbr> <a href="mailto:info@just-fastfood.com">info@just-fastfood.com</a><br/>
                                                        </address>
                                                    </div>
                                                </div>
                                         </div>
                </div>
            </div>                     
        </div>
    </div>
</div>
</div>

<script>
$(document).ready(function(){
    $('#contact-form').bootstrapValidator({

        message: 'This value is not valid',

        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        submitHandler: function() {
         document.forms["contact-form"].submit();
        },
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email is required and cannot be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            name : {
                message: 'Please enter your full name',
                validators: {
                    notEmpty: {
                        message: 'Your full name is required'
                    }
                }
            },
            subject : {
                    validators: {
                        notEmpty: {
                            message: 'The subject is required'
                        }
                    }               
            },
            message: {
                message: '',
                validators: {
                    notEmpty: {
                        message: 'This is a required field.'
                    }

                }
            },
            phone : {
                message: 'Please enter your mobile number',
                validators: {
                    notEmpty: {
                        message: 'We need your phone number to contact you should there be any question regarding your order'
                    },
                    numeric: {
                        message: 'A phone number can\'t contain alphabetical characters'
                    }
                }
            }
        }
    });
});
</script>
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