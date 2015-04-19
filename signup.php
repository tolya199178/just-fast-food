<?php
session_start();
//ob_start("ob_gzhandler");
ini_set ('display_errors', '1');

if( isset($_COOKIE['jjf_username']) && isset($_COOKIE['jjf_password']) ) {
  $_SESSION['user'] = $_COOKIE['jjf_username'];
  header('Location:index.php');
  exit();
} else if ( isset($_SESSION['user']) ){
  header('Location:index.php');
  exit();
}

include __DIR__."/include/functions.php";

$ARRAY = array('user_name', 'user_screen_name', 'user_password', 'user_email', 'user_phoneno', 'user_address', 'user_address_1', 'user_city', 'user_post_code', 'user_dob', 'user_hear', 'user_verified', 'user_status');

foreach($ARRAY as $v) {
  $ARRAYTEMP[$v] = '';
}

$CLOSE_FANCY = false;

if( isset($_SESSION['access_key']) && isset($_POST['access']) && ($_POST['access'] == $_SESSION['access_key']) && isset($_POST['SIGNUP']) ) {

  header('Content-Type: application/json');


  $json_post = getEandN($_POST['user_post_code']);

  if($json_post) {

    $value = "'', ";
    foreach($ARRAY as $values) {
      if($values == "user_password") {
        $value .= "'".md5(mysql_real_escape_string($_POST[$values]))."', ";
      } else if ($values == "user_screen_name" ) {
        $usernameFEmail = explode('@', $_POST['user_email']);
        $value .= "'".mysql_real_escape_string($usernameFEmail[0])."', ";
      } else {
        $value .= "'".mysql_real_escape_string($_POST[$values])."', ";
      }
    }
    $value .= "'', '', '', '', '', NULL";
    $extra = "`user_email` = '".$_POST['user_email']."'";
    $result = INSERT($value, 'user', 'unique', $extra);
    $email = $_POST['user_email'];
    //$confirmEmail = $_POST['confirm_user_email'];
    $userPassword = $_POST['user_password'];
    $confirmUserPassword = $_POST['cuser_password'];

    setC('user', $_POST['user_name']);

    if($result) {

      include_once('include/email-send.php');

      $STRSEND = array(
        'type' => 'new-user-reg',
        'email' => admin_email(),
        'user_email' => $_POST['user_email'],
        'user_name' => $_POST['user_screen_name'],
        'user_postcode' => $_POST['user_post_code'],
      );
      SENDMAIL($STRSEND , false);

      $Verify_Code = md5($_POST['user_email']) .'_' . rand();
      mysql_query("INSERT INTO `verify_email` VALUES (NULL, '". $Verify_Code ."', '". $_POST['user_email'] ."', NULL) ");

      $STRSEND['type'] = 'verify-acct';
      $STRSEND['email'] = $_POST['user_email'];
      $STRSEND['Verify_Code'] = $Verify_Code;

      SENDMAIL($STRSEND , false);

      $_SESSION['success'] = "Account Successfully Created. We just sent you an email to validate your account. Please follow the activation link sent to your email";
      $CLOSE_FANCY = true;
      echo json_encode( array('status'  =>'account_created', 'message' => "We just sent you an email to validate your account. Please check your email including spam folder for activation link."));
      unset($_SESSION['access_key']);
      exit();

    } else {
      foreach($ARRAY as $v) {
        $ARRAYTEMP[$v] = $_POST[$v];
      }

      $_SESSION['error'] = "Email Address Already Exist!";
      echo json_encode( array('status'  => 'account_exist',
        'message' => "There's an account with the exact email address. Please try another email.") );
      exit();
    }

  } else {

    foreach($ARRAY as $v) {
      $ARRAYTEMP[$v] = $_POST[$v];
    }

    $_SESSION['error']  = "ERROR! Invalid Post Code ( Please enter only full UK postcode)";
    echo json_encode(array('status' => 'zip_code',
      'message' => "The post code entered is invalid. Please enter only full UK postcode. e.g SW7 5HR"));
    exit();
  }
}

$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());

?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="description" content="Just-FastFood - Create Account - Order Food Online - Fast Food Online">
  <meta name="keywords" content="Account Creation!, <?= getDataFromTable('setting','keywords'); ?>">
  <meta name="author" content="Just-FastFood">
  <title>Just-FastFood - SignUp - Account Creation</title>
  <!--CSS INCLUDES-->
  <link rel="shortcut icon" type="image/png" href="favicon.png" />

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

  <!-- start Mixpanel -->
  <script type="text/javascript">(function(f,b){if(!b.__SV){var a,e,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
      for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=f.createElement("script");a.type="text/javascript";a.async=!0;a.src="//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";e=f.getElementsByTagName("script")[0];e.parentNode.insertBefore(a,e)}})(document,window.mixpanel||[]);
    mixpanel.init("bfe6c0035792f5d4fd1e58d0b928d12d");
  </script>

  <!-- end Mixpanel -->

</head>
<body>
<div class="wrapper" >
  <?php include('templates/header2.php');?>
  <div class="metahead what-we-do" style="padding: 20px 0">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h1 style="text-transform: none">Create Account</h1>
        </div>
      </div>
    </div>
  </div>
  <div class="section_inner" style="background-color: #f6f8f8; ">
    <div class="container">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-lg-offset-2 col-md-offset-3 col-sm-offset-3">
        <div class="row">
          <div class="page-header" style="float: right">
            <h1>Signup takes few seconds</h1>
          </div>
          <form class="form-horizontal signup-form" method="post" action="">
            <div class="form-group">
              <label class="col-lg-3 control-label" for="user_email">Email<span class="required">*</span></label>
              <div class="col-lg-7">
                <input id="user_email" class="form-control" type="text" value="" title="Enter your Email" placeholder="Email Address" name="user_email"/>
              </div>
            </div>

            <div class="form-group">
              <label class="col-lg-3 control-label" for="user_password">Password<span class="required">*</span></label>
              <div class="col-lg-7">
                <input id="user_password" class="form-control" type="password" value="" title="Enter your Password" placeholder="Password" name="user_password"/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label" for="cuser_password">Confirm Password<span class="required">*</span></label>
              <div class="col-lg-7">
                <input id="cuser_password" class="form-control" type="password" value="" title="Enter your Password" placeholder="Password" name="cuser_password"/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label">Full name<span class="required">*</span></label>
              <div class="col-lg-7">
                <input id="j_firstName" class="form-control" type="text" value="" title="Enter your Full name" placeholder="Full Name" name="user_name"/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label" for="user_phoneno">Phone No<span class="required">*</span></label>
              <div class="col-lg-7">
                <input name="user_phoneno" id="user_phoneno" class="input required form-control" value="" placeholder="Phone number" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label" for="user_address">Delivery Address<span class="required">*</span></label>
              <div class="col-lg-7">
                <input type="text" name="user_address" id="user_address" placeholder="Delivery address" title="Enter delivery address" class="input required form-control" value="<?php echo $ARRAYTEMP['user_address'];?>"/>
              </div>
            </div>

            <div class="form-group">
              <label class="col-lg-3 control-label" for="user_city">City<span class="required">*</span></label>
              <div class="col-lg-7">
                <input type="text" name="user_city" id="user_city" placeholder="City" class="input required form-control" value="<?php echo $ARRAYTEMP['user_city'];?>"/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label" for="user_post_code">Post Code<span class="required">*</span></label>
              <div class="col-lg-7">
                <input type="text" name="user_post_code" id="user_city" placeholder="Postcode" class="input required form-control" value=""/>
              </div>
            </div>
            <div class="form-group">
              <input type="hidden" name="user_dob" value=""/>
              <input type="hidden" name="user_status" value=""/>
              <input type="hidden" name="user_hear" value=""/>
              <input type="hidden" name="user_address_1" value=""/>
              <input type="hidden" name="user_screen_name" value=""/>
              <input type="hidden" name="user_verified" value=""/>
              <input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
              <label class="control-label"></label>
              <input class="btn btn-lg btn-primary btn-block" type="submit" name="SIGNUP" value="Sign Up" style="text-transform: none; float: right; width: 50%; margin-right: 34px" />
            </div>
            <div class="col-lg-11 col-xs-6 col-sm-push-2">
              <center>
                By clicking the button you agree to the <a target="_blank" href="terms.php">Terms of Use</a> and
                <a target="_blank" href="privacy.php">Privacy Policy</a>
              </center>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
  <!-- modal -->
  <div class="modal fade" id="signup-modal" tabindex="-1" role="dialog" aria-labelledby="signup-modal" aria-hidden="true">
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
</body>
</html>