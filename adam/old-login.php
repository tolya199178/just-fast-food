<?php
session_start();
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
                    'message'      => 'Unfortunately, '. $_SESSION['user'] .', Your account is not verified, please verify your account by clicking the link we sent in your email',
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
</head>
<body>
<div class="wrapper">
    <?php include('templates/header2.php');?>
    <div class="metahead what-we-do" style="padding: 20px 0">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1>Login</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="section_inner" >
        <div class="container">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="row">
                    <form id="user-login-form" class="form-horizontal" method="post" action="">
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="email">Email Address<span class="required">*</span></label>
                            <div class="col-lg-7">
                                <input id="email" class="form-control" type="text" value="" title="Enter your Email" placeholder="Enter your email..." name="email"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="password">Password<span class="required">*</span></label>
                            <div class="col-lg-7">
                                <input id="password" class="form-control" type="password" value="" title="Enter your Password" placeholder="Enter your password..." name="password"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"></label>
                            <div class="controls">
                                <label for="j_remember">
                                    <input type="checkbox" name="checkbox" value="rememberme">Remember Me</label>
                            </div>
                            <input type="hidden" name="backURL" value="<?php if(isset($_SERVER['HTTP_REFERER'])) { echo htmlspecialchars($_SERVER['HTTP_REFERER']); } else { echo 'index.php';}?>"/>
                            <input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"></label>
                            <input class="custom_submit_button red_btn2" type="submit" value="Login" name="LOGIN" />
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
</body>
</html>