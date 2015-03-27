<?php
	session_start();
	include("include/functions.php");

	$vcode_true = "false";
	$ERROR = false;
	if(isset($_GET['vcode']) && $_GET['vcode'] != "") {
		$vcode = $_GET['vcode'];
		$value1 = $obj  -> query_db ("SELECT `email` FROM `forgot_pass` WHERE `vcode` = '".$vcode."'  AND `type` = 'user'") or die(mysql_error());
		if($obj -> num_rows($value1) > 0) {
			$vcodeObj = $obj -> fetch_db_assoc($value1);
			$email = $vcodeObj['email'];
			$vcode_true = "true";
			$_SESSION['vcode'] = $vcode;
		} else {
			$_SESSION['error'] = "Error!!. Verification Code Not Valid!";
			$ERROR = true;
		}
	}

	if(isset($_SESSION['access_key']) && isset($_POST['access']) && $_POST['access'] == $_SESSION['access_key']) {

		include_once("include/email-send.php");

		if(isset($_POST['FORGOT'])) {

            header('Content-Type: application/json');	
            		
			$value = $obj  -> query_db ("SELECT `user_email` FROM `user` WHERE `user_email` = '".$_POST['user_email']."'") or die(mysql_error());
			if($obj -> num_rows($value) > 0) {
				$value1 = $obj  -> query_db ("SELECT `vcode` FROM `forgot_pass` WHERE `email` = '".$_POST['user_email']."' AND `type` = 'user'") or die(mysql_error());
				if($obj -> num_rows($value1) > 0) {
					$vcodeObj = $obj -> fetch_db_assoc($value1);
					$vcode = $vcodeObj['vcode'];
				} else {
					$vcode = rand().md5($_POST['user_email']).rand();
					$value = "NULL, ";
					$value .= "'".$vcode."', ";
					$value .= "'".$_POST['user_email']."', ";
					$value .= "'user', ";
					$value .= "NULL";
					$result = INSERT($value ,'forgot_pass' ,false , '');
				}

				$_SESSION['success'] = "Password link will be sent to your email address";

				$STRSEND = array(
								'type' => 'upt-pass',
								'email' => $_POST['user_email'],
								'vcode' => $vcode,
								'link' => 'forgot-password'
							);
				SENDMAIL($STRSEND , false);

                echo json_encode( array('status'       => 'link_sent',
                                        'message'      => $_SESSION['success']) );
                exit();

			} else {

				$_SESSION['error'] = "Error!!. Email Not Exist!";
                echo json_encode( array('status'       => 'error',
                                        'message'      => $_SESSION['error']) );
                exit();

			}
		}

		else if(isset($_POST['UPDATE']) && $_SESSION['vcode'] == $_POST['vcode']){
			$value1 = $obj  -> query_db ("UPDATE `user` SET `user_password` = '".md5($_POST['user_password'])."' WHERE `user_email` = '".$_POST['email']."'");
			$value1 = $obj  -> query_db ("DELETE FROM `forgot_pass` WHERE `vcode` = '".$_POST['vcode']."'  AND `type` = 'user'");
			$_SESSION['success'] = "Password Updated.. Please Login To Continue";

			unset($_SESSION['vcode']);
            echo json_encode( array('status'       => 'updated',
                                     'message'     => $_SESSION['success']) );
            exit();
			$ERROR = true;
		}

	}

	$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="description" content="Forgot your Password - <?= getDataFromTable('setting','meta'); ?>">
	<meta name="keywords" content="<?= getDataFromTable('setting','keywords'); ?>,  Forgot your Password">
    <meta name="author" content="Just-FastFood">
    <title>Forgot Password - Just-FastFood </title>
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
                    <h1>
                    <?php if(!$ERROR) {	
                        if($vcode_true == 'true') { ?>
                            Update Your Password
                        <?php } else { ?>
                            Forgot Password
                    <?php } } ?>
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <div class="section_inner" >
        <div class="container">
            <div class="col-sm-6 col-sm-offset-3">
               <div class="row">
                    <form class="form-horizontal" method="post" action="" id="user-forgot-password">
			    <?php include('include/notification.php');?>
			    <?php if(!$ERROR) {	?>
			    <?php if($vcode_true == 'true') {	?>     
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="email">Email Address</label>
                            <div class="col-lg-7">
                                <p class="form-control-static"><?php echo $email; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="user_password">New Password<span class="required">*</span></label>
                            <div class="col-lg-7">
                                <input id="user_password" class="form-control" type="password" title="Enter your Password" placeholder="Enter your password..." name="user_password"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="cuser_password">Confirm Password<span class="required">*</span></label>
                            <div class="col-lg-7">
                                <input name="cuser_password" id="cuser_password"  class="form-control" type="password" title="confirm your Password" placeholder="confirm your password..." />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"></label>
                            <input class="custom_submit_button red_btn2" type="submit" value="Submit" name="UPDATE" />
						    <input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
						    <input type="hidden" name="vcode" value="<?php echo $vcode;?>"/>
						    <input type="hidden" name="email" value="<?php echo $email;?>"/>                           
                        </div>

			    <?php } else { ?>

			    		<p>Password update link will be sent to you your email address</p>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="user_email0">Email Address<span class="required">*</span></label>
                            <div class="col-lg-7">
                                <input type="text" name="user_email" id="user_email0" class="form-control" title="Enter your e-mail..." placeholder="Enter your e-mail..." />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"></label>
			    			<input class="custom_submit_button red_btn2" type="submit" value="Submit" name="FORGOT" />
			    			<input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>                       
			    	    </div>

			    <?php } } ?>                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal -->
<div class="modal fade" id="user-forgot-password-m" tabindex="-1" role="dialog" aria-labelledby="user-forgot-password-m" aria-hidden="true">
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
<script>
$(document).ready(function(){

   $('#user-forgot-password').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        submitHandler: function(validator, form, submitButton) {

            $.post(form.attr('action'), form.serialize(), function(result) {

                if (result.status == 'link_sent' ) {
                    // You can reload the current location
                    $('#user-forgot-password-m .modal-title').text('Check Your Email');
                    $('#user-forgot-password-m .modal-body').text( result.message );
                    $('#user-forgot-password-m .btn').addClass('hidden');
                    $('#user-forgot-password-m').modal();
                    setTimeout(function(){
                    		$(location).attr('href', '/');
                    }, 8000);

                } else if ( result.status == 'error' ) {

                    $('#user-forgot-password-m .modal-title').text('Email Doesn\'t Exist');
                    $('#user-forgot-password-m .modal-body').text( result.message );
                    $('#user-forgot-password-m').modal();
                    $('#user-forgot-password').bootstrapValidator('disableSubmitButtons', false);

                } else if ( result.status == 'updated' ) {

                    $('#user-forgot-password-m .modal-title').text('Password Updaetd');
                    $('#user-forgot-password-m .modal-body').text( result.message );
                    $('#user-forgot-password-m').modal();
                    setTimeout(function(){
                    		$(location).attr('href', '/login.php');
                    }, 8000);

                } else {

                    $('#user-forgot-password-m .modal-title').text('Something Went Wrong');
                    $('#user-forgot-password-m .modal-body').text( 'Something weong wrong, please try again' );
                    $('#user-forgot-password-m').modal();               
                    $('#user-forgot-password').bootstrapValidator('disableSubmitButtons', false);
                }
            }, 'json');
        },

        fields: {

            user_email: {
                validators: {
                    notEmpty: {
                        message: 'The email is required and cannot be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            user_password: {
                message: 'Password is not valid',
                validators: {
                    notEmpty: {
                        message: 'The username is required and cannot be empty'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The password must be more than 6 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'The username can only consist of alphabetical, number and underscore'
                    }
                }
            },
            cuser_password: {
                message: 'The confirm password is required and cannot be empty',
                validators: {
                    notEmpty: {
                        message: 'The password is required and cannot be empty'
                    },
                    identical: {
                        field: 'user_password',
                        message: 'The password and its confirm must be the same'
                    }
                }
            }

        }
    });
});
</script>
<?php include('templates/footer2.php');?>
</body>
</html>