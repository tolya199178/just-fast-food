<?php

session_start();
ob_start("ob_gzhandler");
ini_set ('display_errors', '1');

if( isset($_COOKIE['jjf_username']) && isset($_COOKIE['jjf_password']) ) {

    $_SESSION['user'] = $_COOKIE['jjf_username'];

    header('Location:index.php');

    exit();

} else if ( isset($_SESSION['user']) ){

    header('Location:index.php');

    exit();

}

include("include/functions.php");



$ARRAY = array('user_name', 'user_password', 'user_email', 'user_phoneno', 'user_address', 'user_address_1', 'user_city', 'user_post_code', 'user_dob', 'user_hear', 'user_status');



foreach($ARRAY as $v) {

    $ARRAYTEMP[$v] = '';

}



if(isset($_SESSION['access_key']) && isset($_POST['access']) && $_POST['access'] == $_SESSION['access_key']) {



    if(isset($_POST['LOGIN'])) {



        header('Content-Type: application/json');



        $select = "`id`,`user_email`,`user_password`,`user_name`,`user_status`";

        $where = "`user_email` = '".$_POST['email']."' AND `user_password` = '".md5($_POST['password'])."'";



        $result = SELECT($select, $where, 'user', 'array');



        if($result) {



            if( $result['user_status'] == 'active' || strpos($result['user_status'], 'active') !== false ) {



                unset($_SESSION['access_key']);

                $_SESSION['user'] = $result['user_name'];

                setC('user' ,$_SESSION['user']);

                $_SESSION['userId'] = $result['id'];

                //  $_SESSION['success'] = "Successfully Login <a href='my-profile.php'>Go To My Profile</a>";

                if( isset($_POST['checkbox']) ) {

                    setcookie('jjf_username', $result['user_name'], time() + 1*24*60*60);

                    setcookie('jjf_password', md5($_POST['password']), time() + 1*24*60*60);

                } else {

                    setcookie('jjf_username', '', time() - 1*24*60*60);

                    setcookie('jjf_password', '', time() - 1*24*60*60);

                }

                echo json_encode( array('status'       => 'logged_in',

                    'message'      => 'Welcome back '. $_SESSION['user'],

                    'redirect_uri' => $_POST['backURL']) );

                exit();



            } else {



                echo json_encode( array('status'       => 'not_verified',


                    'message'      => 'Looks like your account is not verified yet. Please verify your account by clicking the link sent to your email. Emails do get trapped in Spam folder a times.',

                    'redirect_uri' => $_POST['backURL']) );
                exit();



            }

        } else {



            $_SESSION['error'] = "Email OR Password Incorrect. Please try again";

            echo json_encode( array('status'  => 'incorrect_data',

                'message' => 'Email OR Password Incorrect. Please try again') );

            exit();

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
    <meta name="description" content="Just Fast Food - Account Creation - Order Food Online - Fast Food Online">
    <meta name="keywords" content="Account Creation!, <?= getDataFromTable('setting','keywords'); ?>">
    <meta name="author" content="Just-FastFood">
    <title>Just-FastFood - Login - Account Creation</title>
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
<style>
    .form-control.glyphicon {
        font-family:inherit;
    }
    .form-control.glyphicon::-webkit-input-placeholder:first-letter {
        font-family:"Glyphicons Halflings";
    }
    .form-control.glyphicon:-moz-placeholder:first-letter {
        font-family:"Glyphicons Halflings";
    }
    .form-control.glyphicon::-moz-placeholder:first-letter {
        font-family:"Glyphicons Halflings";
    }
    .form-control.glyphicon:-ms-input-placeholder:first-letter {
        font-family:"Glyphicons Halflings";
    }
</style>
<div class="wrapper">
    <?php include('templates/header2.php');?>
    <div class="metahead what-we-do" style="padding: 20px 0">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1 style="text-transform: none">Returning User</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="section_inner" style="background-color: #f6f8f8; " >
        <div class="container">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-lg-offset-2 col-md-offset-3 col-sm-offset-3">
                <div class="row">
                    <div class="page-header" style="margin-left: 200px;">
                        <h1>Sign In</h1>
                    </div>
                    <form id="user-login-form" class="form-horizontal signin-form" method="post" action="">
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="email">Email<span class="required">*</span></label>
                            <div class="col-lg-7">
                                <input id="email" class="form-control" type="text" value="" title="Enter your Email" placeholder="Email Address" name="email"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="password">Password<span class="required">*</span></label>
                            <div class="col-lg-7">
                                <input id="password" class="form-control" type="password" value="" title="Enter your Password" placeholder="Password" name="password"/>
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="col-lg-3 control-label" for="password"></label>
                            <div class="col-lg-7">
                                    <label class="control-label" style="width: auto">
                                       <input type="checkbox" class="checkbox icheckbox_square-blue"  name="checkbox" value="rememberme" /> Remember Me
                                    </label>
                            </div>
                        </div>                       
                        <div class="form-group">
                            <input type="hidden" name="backURL" value="<?php if(isset($_SERVER['HTTP_REFERER'])) { echo htmlspecialchars($_SERVER['HTTP_REFERER']); } else { echo 'index.php';}?>"/>
                            <input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-lg btn-primary btn-block" style="text-transform: none; width: 53.3%; margin-right: 25px; float: right" type="submit" value="Login" name="LOGIN" >
                        </div>

                          <div><a href="signup.php" >Sign up</a></div>
                          <div><a id="init-p-form" href="#" >Forgot your password?</a></div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
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

                        <!-- ==============

                             PASSWORD RESET

                             ============== -->

                        <div class="modal fade login-wrap" id="request-p-form" tabindex="-1" role="dialog" aria-labelledby="request-p-form" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                               <h4 class="modal-title">Forgot Password</h4>
                              </div>
                               <div class="modal-body">
                             </div>                           
                            </div><!-- /.modal-content -->
                          </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

<?php include('templates/footer2.php');?>

</body>

</html>