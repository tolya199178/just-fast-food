<?php
session_start();
if(isset($_SESSION['user'])) {
    header('Location:index.php');
    die();
}

include("include/functions.php");

$ARRAY = array('user_name','user_screen_name', 'user_password', 'user_email', 'user_phoneno', 'user_address', 'user_address_1', 'user_city', 'user_post_code', 'user_dob', 'user_hear', 'user_verified', 'user_status');

foreach($ARRAY as $v) {
    $ARRAYTEMP[$v] = '';
}

include ('include/recaptchalib.php');
$privateKey = "6LcOieYSAAAAADEeDGmUofYRe2skQfRpgu4iovVy";

$CLOSE_FANCY = false;

if(isset($_SESSION['access_key']) && isset($_POST['access']) && ($_POST['access'] == $_SESSION['access_key']) && isset($_POST['SIGNUP'])) {

    $resp = recaptcha_check_answer ($privateKey,
        $_SERVER["REMOTE_ADDR"],
        $_POST["recaptcha_challenge_field"],
        $_POST["recaptcha_response_field"]);
    if (!$resp->is_valid) {
        foreach($ARRAY as $v) {
            $ARRAYTEMP[$v] = $_POST[$v];
        }
        $_SESSION['error'] = $resp->error;

    } else {

        $json_post = getEandN($_POST['user_post_code']);
        if($json_post) {

            include_once('include/email-send.php');

            $value = "NULL, ";
            foreach($ARRAY as $values) {
                if($values == "user_password") {
                    $value .= "'".md5(mysql_real_escape_string($_POST[$values]))."', ";
                } else {
                    $value .= "'".mysql_real_escape_string($_POST[$values])."', ";
                }
            }
            $value .= "NULL";
            $extra = "`user_email` = '".$_POST['user_email']."'";
            $result = INSERT($value ,'user' ,'unique' ,$extra);
            $email = $_POST['user_email'];
            $confirmEmail = $_POST['confirm_user_email'];
            $userPassword = $_POST['user_password'];
            $confirmUserPassword = $_POST['c_user_password'];


            setC('user',$_POST['user_name']);

            if($result) {

                $STRSEND = array(
                    'type' => 'new-user-reg',
                    'email' => admin_email(),
                    'user_email' => $_POST['user_email'],
                    'user_name' => $_POST['user_name'],
                    'user_postcode' => $_POST['user_post_code'],
                );
                SENDMAIL($STRSEND , false);

                $Verify_Code = md5($_POST['user_email']) .'_' . rand();
                mysql_query("INSERT INTO `verify_email` VALUES (NULL, '". $Verify_Code ."', '". $_POST['user_email'] ."', NULL) ");

                $STRSEND['type'] = 'verify-acct';
                $STRSEND['email'] = $_POST['user_email'];
                $STRSEND['Verify_Code'] = $Verify_Code;

                SENDMAIL($STRSEND , false);

                $_SESSION['success'] = "Account Successfully Created. We've just sent you an email to validate your account. Please follow the activation link sent to your email";
                $CLOSE_FANCY = true;
                echo  $_GET['newuseremail'];
                unset($_SESSION['access_key']);
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
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Signup Free, <?= getDataFromTable('setting','meta'); ?>">
    <meta name="keywords" content="Signup Free, <?= getDataFromTable('setting','keywords'); ?>">
    <meta name="author" content="M Awais">

    <link rel="shortcut icon" href="images/favicon.ico">
    <title>Signup - Just-FastFood</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/fancybox/jquery.fancybox.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script type="text/javascript" src="css/fancybox/jquery.fancybox.js"></script>
    <script type="text/javascript" src="js/validate.js"></script>
    <script type="text/javascript" src="js/additional-methods.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            $("#signupForm").validate({
                rules:{
                    cuser_password:{
                        equalTo: "#user_password"
                    },
                    user_email: {email: true},
                    user_screen_name : {minlength:5},
                    confirm_user_email: {equalTo: "#user_email"},
                    user_phone : {minlength:11, digits:true},
                    user_name : {minlength: 7},
                    user_address: {minlength:8}

                },
                messages : {
                    user_email : "Please enter a valid email",
                    user_password : "Please fill in password correctly. 6 characters minimum",
                    user_name : "Please enter your full name",
                    user_address : "Please enter a valid address",
                    user_screen_name: "Please enter a valid screen name",
                    user_city : "Please enter your city",
                    user_postcode : "Please enter your postcode",
                    user_phone : "Please enter a valid phone number"
                },
                errorPlacement: function ($error, $element) {
                    if ($element.attr("name") == "accept") {
                        $error.insertAfter($element.next());
                    } else {
                        $error.insertAfter($element);
                    }
                }
            });
            $(".pop_box").fancybox();


            $('.autocomplete li').live('click',function(){
                $('#signupForm').find('#user_address').val($(this).text());
                $('.autocomplete').hide();
            });
            var g = "";
            $('#users_postcode').live('keyup',function(){
                if(g != "")
                    g.abort();
                if($(this).val() == "")
                    return false;
                $.ajax({
                    url: "include/loadAddr.php",
                    type: "get",
                    data: {p : $(this).val()},
                    success: function(data){
                        $('.autocomplete').show();
                        $('.autocomplete ul').html(data);
                        setTimeout(function(){$('.autocomplete').hide();},7000);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        /*   $(document).ready(function(){
         var name = document.getElementsByName("SIGNUP");
         if ($(name).click(function(){
         $(this).hide();
         //  alert("Just clicked");
         }));
         //  alert("Change here");
         }); */

    </script>
    <style type="text/css">
        .row{
            position:relative;
        }
        .autocomplete li{
            list-style-type:none;
        }
        .autocomplete{
            position:absolute;
            left: 150px;
            top: 25px;
            max-width: 400px;
            background:#fff;
            font-size:12px;
            z-index:99;
            display:none;
        }
        .autocomplete div{
            border:1px solid #ddd;
            padding:3px;
        }
        .autocomplete div li{
            cursor:pointer;
            padding-bottom:3px;
        }
        .autocomplete div li:hover{
            text-decoration:underline;
        }
        .row {
            text-emphasis-color: orangered;
            text-decoration: orange;
            text-underline-position: auto;
            font-family: segoe ui;
            font-weight: lighter;

        }
        .shadow {
            -moz-box-shadow: 0 0 5px rgba(0,0,0,0.5);
            -webkit-box-shadow: 0 0 5px rgba(0,0,0,0.5);
            box-shadow: 0 0 5px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body>
<div class="content">
    <div class=" ">
        <?php include('include/notification.php');?>
        <div class="fl-left login-wrap">

        </div>
        <div class="fl-left sign-up-wrap" style="width:100%;">
            <div class="box-wrap">
                <form action="" method="post" id="signupForm">

                    <div class="row">
                        <h2 style="font-family: Rockwell; background-color: red; text-decoration-color: yellow; text-align: center">Signup</h2>
                        <p class="small txt-right">Please note: input fields marked with a <span style="text-decoration-color: red"> * </span>  are required fields.</p>
                    </div>
                    <div class="row">
                        <label for="user_email">Email Address<span>*</span></label><input type="text" name="user_email" id="user_email" class="input required email" value="<?php echo $ARRAYTEMP['user_email'];?>"/>
                    </div>
                    <div class="row">
                        <label for="confirm_user_email">Confirm Email Address<span>*</span></label><input type="text" name="confirm_user_email" id="confirm_user_email" class="input required email" value="<?php echo $ARRAYTEMP['confirm_user_email'];?>"/>
                    </div>
                    <div class="row">
                        <label for="user_screen_name">Screen Name<span>*</span></label><input type="text" name="user_screen_name" id="user_screen_name" class="input" value="<?php echo $ARRAYTEMP['user_screen_name'];?>"/>
                    </div>
                    <div class="row">
                        <label for="user_password">Password<span>*</span></label><input type="password" name="user_password" id="user_password" class="input required" />
                    </div>
                    <div class="row">
                        <label for="cuser_password">Confirm Password<span>*</span></label><input type="password" name="cuser_password" id="cuser_password" class="input required"/>
                    </div>
                    <div class="row">
                        <label for="user_name">Full Name<span>*</span></label><input type="text" name="user_name" id="user_name" class="input required" value="<?php echo $ARRAYTEMP['user_name'];?>"/>
                    </div>
                    <div class="row">
                        <label for="user_phone">Phone No<span>*</span></label><input type="text" name="user_phoneno" id="user_phoneno" class="input required" value="<?php echo $ARRAYTEMP['user_phoneno'];?>"/>
                    </div>

                    <p class="small txt-right" style="font-family: RockwellRegular; font-weight: bolder">Delivery address:</p>
                    <div class="row">
                        <label for="user_address">Address<span>*</span></label><input type="text" name="user_address" id="user_address" class="input required" value="<?php echo $ARRAYTEMP['user_address'];?>"/>
                    </div>
                    <div class="row">
                        <label for="user_address_1">Address 1</label><input type="text" name="user_address_1" id="user_address_1" class="input" value="<?php echo $ARRAYTEMP['user_address_1'];?>"/>
                    </div>
                    <div class="row">
                        <label for="user_city">City<span>*</span></label><input type="text" name="user_city" id="user_city" class="input required" value="<?php echo $ARRAYTEMP['user_city'];?>"/>
                    </div>
                    <div class="row">
                        <label for="user_postcode">Post Code<span>*</span></label><input type="text" name="user_post_code" id="user_postcode" class="input required postcode" value="<?php echo $ARRAYTEMP['user_post_code'];?>"/>
                        <div class="autocomplete">
                            <div>
                                <ul></ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <input type="hidden" name="user_dob" value=""/>
                        <input type="hidden" name="user_status" value="active"/>
                        <input type="hidden" name="user_hear" value=""/>
                        <input type="hidden" name="user_verified" value=""/>
                        <input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
                    </div>
                    <div class="row">
                        <input type="checkbox" name="accept" id="" class="required"/>
                        <p class="" style="display:inline">I accept the <a href="terms.php" class="u pop_box">terms and conditions</a> &amp; <a href="privacy.php" class="u pop_box">privacy policy</a></p>
                    </div>
                    <div class="row">
                        <?php
                        $publickey = "6LcOieYSAAAAAC3aca_Bj8GehM77moZ6_S4SXhG4"; // you got this from the signup page
                        echo recaptcha_get_html($publickey, null, true);
                        ?>
                    </div>
                    <div class="row txt-right">
                        <input type="submit" value="Create Account" class="btn" id="signupN" name="SIGNUP"/>
                      <!--    <a href="facebook-connect.php" class="facebook-login"><img src="/images/fbimg.png" width="140" height="25" border="0" alt="Test" title="Login With Facebook" style="image-rendering: optimize-contrast; padding: 9px 10px 9px 8px; position: relative; background-color: #fff"> -->

                    </div>
                </form>
            </div>
        </div>
        <div class="clr"></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        <?php if($CLOSE_FANCY) {?>
        $('.jquery-msgbox-buttons .btn').click(function (){
            window.parent.$.prettyPhoto.close();
        });
        <?php } ?>
    });
</script>
</body>
</html>