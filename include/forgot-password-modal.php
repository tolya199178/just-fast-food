<?php
	session_start();
	include("functions.php");

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

		include_once("email-send.php");

		if(isset($_POST['FORGOT'])) {
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
			} else {
				$_SESSION['error'] = "Error!!. Email Not Exist!";
			}
		}

		else if(isset($_POST['UPDATE']) && $_SESSION['vcode'] == $_POST['vcode']){
			$value1 = $obj  -> query_db ("UPDATE `user` SET `user_password` = '".md5($_POST['user_password'])."' WHERE `user_email` = '".$_POST['email']."'");
			$value1 = $obj  -> query_db ("DELETE FROM `forgot_pass` WHERE `vcode` = '".$_POST['vcode']."'  AND `type` = 'user'");
			$_SESSION['success'] = "Password Updated.. Please Login To Continue";
			unset($_SESSION['vcode']);
			header('location:login.php');
			die();
			$ERROR = true;
		}

	}

	$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());

?>
			<?php if(!$ERROR) {	?>

			<?php if($vcode_true == 'true') {	?>
			<div class="box-wrap ">
				<form action="forgot-password.php" method="post" id="signupForm" class="login-wrap" style="width:71%">
					<div class="row">
						<h2>Update Your Password</h2>
					</div>
					<div class="row">
						<label for="user_email0" class="b">Email Address</label><?php echo $email; ?>
					</div>
					<div class="row">
						<label for="user_password">New Password<span>*</span></label><input type="password" name="user_password" id="user_password" class="input required" />
					</div>
					<div class="row">
						<label for="cuser_password">Confirm Password<span>*</span></label><input type="password" name="cuser_password" id="cuser_password" class="input required"/>
					</div>
					<div class="row txt-right">
						<input type="submit" value="Submit" name="UPDATE" class="btn"/>
						<input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
						<input type="hidden" name="vcode" value="<?php echo $vcode;?>"/>
						<input type="hidden" name="email" value="<?php echo $email;?>"/>
					</div>
				</form>
			</div>
			<?php } else { ?>
				<form action="" method="post" id="forgot-password-form" class="form-horizontal login-form bv-form">
				
					<div class="col-lg-12">
            <p>Please enter your email below and we'll email a password link.</p>
              <div class="form-group has-feedback">
                  <label class="col-lg-3 col-sm-pull-1 control-label b" for="user_email0" style="font-size: 1em">Email Address<span class="required">*</span></label>
                <div class="col-lg-7 col-sm-pull-1">
                  <input name="user_email" id="user_email0" class="input required email form-control" required="required" type="text">

                </div>
              </div>
            <input class="btn btn-danger-custom" type="submit" value="Submit" name="FORGOT" class="btn"/>
            <input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
					</div>
			    </form>
			<?php } } ?>

<script type="text/javascript">
  $(document).ready(function(){
    $("#forgot-password-form").bootstrapValidator({

      message: 'This value is not valid',

      feedbackIcons: {

        valid: 'glyphicon glyphicon-ok',

        invalid: 'glyphicon glyphicon-remove',

        validating: 'glyphicon glyphicon-refresh'

      },

      submitHandler: function (validator, form, submitButton) {

        if($('#forgot-password-form input[name='user_email']').val()===''){
          alert('Value is empty');
        }else {
          alert('Value not empty');
        }
        $.post(form.attr('action'), form.serialize(), function (result) {

          // The result is a JSON formatted by your back-end

          // I assume the format is as following:

          //  {

          //      valid: true,          // false if the account is not found

          //      username: 'Username', // null if the account is not found

          //  }

          if (result.valid == true || result.valid == 'true') {

            // You can reload the current location

            window.location.reload();


            // Or use Javascript to update your page, such as showing the account name

            // $('#welcome').html('Hello ' + result.username);

          } else {

            // The account is not found

            // Show the errors

            $('#errors').html('The account is not found').removeClass('hide');


            // Enable the submit buttons

            $('#forgot-password-form').bootstrapValidator('disableSubmitButtons', false);

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

        }

      }

    });
  });
</script>
