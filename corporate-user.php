<?php

session_start();

include("include/functions.php");

$hide_form = "false";



$ARRAY = array('user_name', 'user_screen_name', 'user_password', 'user_email', 'user_phoneno', 'user_address', 'user_address_1', 'user_city', 'user_post_code', 'user_dob', 'user_hear', 'user_verified', 'user_status', 'co_user', 'co_company_name', 'co_job_title', 'co_total_employees', 'co_pay_method');



foreach($ARRAY as $v) {

    $ARRAYTEMP[$v] = '';

}



if(isset($_SESSION['access_key']) && isset($_POST['access']) && $_POST['access'] == $_SESSION['access_key']) {



    if(isset($_POST['SUBMIT'])) {



        header('Content-Type: application/json');



        include_once("include/email-send.php");



        $json_post = getEandN($_POST['user_post_code']);



        if($json_post) {



            $value = "'', ";

            foreach($ARRAY as $values) {



                if ($values == 'user_password') {

                     $value .= "'".md5(mysql_real_escape_string($_POST[$values]))."', ";

                } else if ($values == 'user_screen_name') {

                     $co_username = explode('@', $_POST['user_email']);

                     $value .= "'".mysql_real_escape_string($co_username['0'])."', ";

                } else if ($values == 'co_user') {

                     $value .= "'".mysql_real_escape_string('true')."', ";

                } else if ($values == 'user_verified') {

                     $value .= "'".mysql_real_escape_string('true')."', ";

                } else if ($values == 'user_status') {

                  $value .= "'" . mysql_real_escape_string('active') . "', ";

                } else if ($value == 'co_company_name') {

                  $value .= "'" . mysql_real_escape_string('active') . "', ";

                } else {

                     $value .= "'".mysql_real_escape_string($_POST[$values])."', ";

                }




            }

            $value .= "NULL";



            $extra = "`user_email` = '".$_POST['user_email']."'";



            $result = INSERT($value ,'user', 'unique', $extra);



            if($result) {



                $_SESSION['success'] = "Thank you for your interest in Just-FastFood. Please login with the information sent to your email";

                $hide_form = "true";

                unset($_SESSION['access_key']);



                $STRSEND = array(

                    'type'       => 'corporate_user',

                    'email'      => $_POST['user_email'],

                    'co_email' => $_POST['user_email'],

                    'co_password'  => $_POST['user_password'],

                    'user_name'  => $_POST['user_screen_name'],

                );


                $MSG = array(
                  'type'              => 'admin_corporate_user',
                  'email'             => admin_email(),
                  'co_company_name'   => $_POST['co_company_name'],
                  'co_full_name'      => $_POST['user_name'],
                  'co_job_title'      => $_POST['co_job_title'],
                  'co_address'        => $_POST['user_address'],
                  'co_city'           => $_POST['user_city'],
                  'co_employee_no'    => $_POST['co_total_employees'],
                  'co_email_addy'     => $_POST['user_email'],
                );

                SENDMAIL($MSG, false);

                SENDMAIL($STRSEND , false);




                echo json_encode( array('status'       => 'sent',

                                        'message'      => $_SESSION['success']) );

                exit();                



            } else {



                foreach($ARRAY as $v) {

                    $ARRAYTEMP[$v] = $_POST[$v];

                }



                $_SESSION['error'] = "Email Address Already Exist!";

                echo json_encode( array('status'       => 'account_exist',

                                        'message'      => "There's an account with the exact email address you entered. Please try another email") );

                exit(); 



            }



        } else {



            foreach($ARRAY as $v) {

                $ARRAYTEMP[$v] = $_POST[$v];

            }



            $_SESSION['error']  = "ERROR!! Invalid Post Code. <span style='font-size:13px'>( Please enter only full UK postode)</span>";

            echo json_encode( array('status'       => 'zip_code',

                                    'message'      => "Invalid Post Code, Please enter only full UK postode") );

            exit();             



        }



    }







}



$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());



function randomPassword($length = 7) {

    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}

?>


<!DOCTYPE html>

<html>

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <meta name="description" content="Just FastFood Corporate Account.  Register on our website and place your order.">

    <meta name="keywords" content="Account Creation!, <?= getDataFromTable('setting','keywords'); ?>">

    <meta name="author" content="Just-FastFood">

    <title>Corporate Account Signup - Just FastFood</title>

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

</head>

<body>

<div class="wrapper">

    <?php include('templates/header2.php');?>

    <div class="metahead what-we-do" style="padding: 20px 0">

        <div class="container">

            <div class="row">

                <div class="col-sm-12">

                    <h1>Corporate Account</h1>

                </div>

            </div>

        </div>

    </div>

    <div class="section_inner" >

        <div class="container">

          <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12" style="font-family: 'Open Sans'">

              <h2 style="text-transform: none">Why Just-FastFood?</h2>

              <p class="small">"It's fast, easy and convenient"</p>

              <div class="hr"></div>

                <h5 style="color: orangered; text-transform: none; font-family: 'Open Sans'; font-weight: 600">Feed the office their favourite meal</h5>

              <ul>

                  <li>Online ordering from top restaurants deliver to your office</li>

                  <li>Checkout made easy</li>

                  <li>Faster and more accurate ordering.</li>

              </ul>

               <br/>

              <h5 style="color: orangered; text-transform: none; font-family: 'Open Sans'; font-weight: 600">Pay monthly or cash on delivery</h5>

              <ul>

                  <li>You can choose to pay cash on delivery or have invoices sent to you on a monthly basis</li>

                  <li>Order for the whole office or a particular employee</li>

                  <li>We aim to deliver under an hour.</li>

              </ul>

              <br/>

              <h5 style="color: orangered; text-transform: none; font-family: 'Open Sans'; font-weight: 600">New restaurants added daily</h5>

              <ul>

                  <li>Should you want any restaurant or fast food outlet that's not currently available on our website, We'll add this for you!</li>


                  <li>Let your employee have their lovely meal at their desk when they want it most!</li>

              </ul>

              <br/>

              <div class="hr"/></div>

          </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">

                <h2 style="text-transform: none">It's easy to join us.</h2>

                <p class="small">Just fill in the form below and your account details will be passed across.</p>

                <hr class="hr"/>

                <form id="corporate-user-form" class="form-horizontal" method="post" action="">

                        <div class="form-group">

                            <label class="col-lg-3 control-label">

                                Full Name

                                <span class="required">*</span>

                            </label>

                            <div class="col-lg-6">

                                <input class="form-control" type="text" value="" title="Enter your full name" placeholder="Enter your full name..." name="user_name"/>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-lg-3 control-label">

                                Company Name

                                <span class="required">*</span>

                            </label>

                            <div class="col-lg-6">

                                <input id="j_companyname" class="form-control" type="text" value="" title="Enter your Company's name" placeholder="Enter your company's name..." name="co_company_name"/>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-lg-3 control-label">

                                Email Address

                                <span class="required">*</span>

                            </label>

                            <div class="col-lg-6">

                                <input id="co_email" class="form-control" type="email" value="" title="Enter your email" placeholder="Enter your email..." name="user_email"/>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-lg-3 control-label">

                                Address

                                <span class="required">*</span>

                            </label>

                            <div class="col-lg-6">

                                <input id="co_address" class="form-control" type="text" value="" title="Enter your Address" placeholder="Enter your Address..." name="user_address"/>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-lg-3 control-label">

                                City

                                <span class="required">*</span>

                            </label>

                            <div class="col-lg-6">

                                <input id="j_city" class="form-control" type="text" value="" title="Enter your City" placeholder="Enter your city..." name="user_city"/>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-lg-3 control-label">

                                Postcode

                                <span class="required">*</span>

                            </label>

                            <div class="col-lg-6">

                                <input id="j_postcode" class="form-control" type="text" value="" title="Enter your Postcode" placeholder="Enter your postcode..." name="user_post_code"/>

                            </div>

                        </div>                                       

                        <div class="form-group">

                            <label class="col-lg-3 control-label">

                                Phone No

                                <span class="required">*</span>

                            </label>

                            <div class="col-lg-6">

                                <input id="j_phone" class="form-control" type="text" value="" title="Enter your Phone" placeholder="Enter your phone no..." name="user_phoneno"/>

                            </div>

                        </div>

                         <div class="form-group">

                            <label class="col-lg-3 control-label">

                                Job Title

                                <span class="required">*</span>

                            </label>

                            <div class="col-lg-6">

                                <input id="j_jobtitle" class="form-control" type="text" value="" title="Enter your job title" placeholder="Enter your job title..." name="co_job_title"/>

                            </div>

                        </div>

                         <div class="form-group">

                            <label class="col-lg-3 control-label">

                                Total Office Employees

                                <span class="required">*</span>

                            </label>

                            <div class="col-lg-6">

                                <input id="j_totalEmployees" class="form-control" type="text" value="" title="Enter your Total Office Employees" placeholder="Number of employees..." name="co_total_employees"/>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-lg-3 control-label">

                                How does your company pay for meals?

                                <span class="required">*</span>

                            </label>

                            <div class="col-lg-6">

                                <select class="form-control" name="co_pay_method">

                                    <option value="">Select...</option>

                                    <option value="Corporate Cards">Corporate Cards</option>

                                    <option value="House Accounts">House Accounts</option>

                                    <!--<option value="Personal Credit Cards - Reimbursement">Personal Credit Cards - Reimbursement</option>-->

                                    <option value="Other">Other</option>                                              

                                </select>

                            </div>

                        </div>                                                                  

                        <div class="form-group">

                            <label class="control-label"></label>

                            <input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>

                            <input name="user_password" type="hidden" value="<?php echo randomPassword(); ?>">

                            <input class="custom_submit_button red_btn2" name="SUBMIT" type="submit" value="Done">

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

<div class="modal fade" id="corporate-user-modal" tabindex="-1" role="dialog" aria-labelledby="signin-modal" aria-hidden="true">

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

<script>

$(document).ready( function(){

    $('#corporate-user-form').bootstrapValidator({



        message: 'This value is not valid',



        feedbackIcons: {

            valid: 'fa fa-check-circle-o fa-lg',

            invalid: 'glyphicon glyphicon-remove',

            validating: 'glyphicon glyphicon-refresh'

        },

        submitHandler: function(validator, form, submitButton) {



            $.post(form.attr('action'), form.serialize(), function(result) {



                if (result.status == 'sent' ) {

                    // You can reload the current location

                    $('#corporate-user-modal .modal-title').text('Email Sent');

                    $('#corporate-user-modal .modal-body').text( result.message );

                    $('#corporate-user-modal .btn').hide();

                    $('#corporate-user-modal').modal();

                    setTimeout(function(){ 

                        $(location).attr('href', '/')

                    }, 6000);





                } else if ( result.status == 'account_exist' ) {



                    $('#corporate-user-modal .modal-title').text('Account Exists');

                    $('#corporate-user-modal .modal-body').text( result.message );

                    $('#corporate-user-modal').modal();

                    $('#corporate-user-form').bootstrapValidator('disableSubmitButtons', false);



                } else if ( result.status == 'zip_code') {



                    $('#corporate-user-modal .modal-title').text('Invalid Post Code');

                    $('#corporate-user-modal .modal-body').text( result.message );

                    $('#corporate-user-modal').modal();

                    $('#corporate-user-form').bootstrapValidator('disableSubmitButtons', false);



                } else {

                    $('#corporate-user-modal .modal-title').text('Something Went Wrong');

                    $('#corporate-user-modal .modal-body').text( 'Something weong wrong, please try again' );

                    $('#corporate-user-modal').modal();

                    $('#corporate-user-form').bootstrapValidator('disableSubmitButtons', false);

                }

            }, 'json');

        },



        fields: {



            user_name : {

                message: 'Please enter your Full name',

                validators: {

                    notEmpty: {

                        message: 'Your full name is required'

                    }

                }

            },

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

            co_company_name: {

                validators: {

                    notEmpty: {

                        message: 'The Company name is required and cannot be empty'

                    }

                }

            },            

            user_phoneno : {

                message: 'Please enter your mobile number',

                validators: {

                    notEmpty: {

                        message: 'We need your phone number to contact you'

                    },

                    numeric: {

                        message: 'A phone number can\'t contain alphabetical characters'

                    }

                }

            },

            user_address : {

                message: 'Please enter your Full address',

                validators: {

                    notEmpty: {

                        message: 'The delivery address cannot be empty'

                    }

                }

            },

            user_city : {

                message: 'Please enter your city',

                validators: {

                    notEmpty: {

                        message: 'Your current city is required'

                    }

                }

            },

            user_post_code : {

                message: 'Please enter post code',

                validators: {

                    notEmpty: {

                        message: 'Post code is required in order to deliver the order'

                    }

                }               

            },

            co_job_title : {

                message: 'Please enter your job title',

                validators: {

                    notEmpty: {

                        message: 'Your job title is required'

                    }

                }              

            },

            co_total_employees : {

                message: 'Please enter total office employees',

                validators: {

                    notEmpty: {

                        message: 'Total office employees is required'

                    },

                    numeric: {

                        message: 'Total office employees can\'t contain alphabetical characters'

                    }

                }              

            },

            co_pay_method : {

                message: 'Please select your payment method',

                validators: {

                    notEmpty: {

                        message: 'Payment method is required'

                    }

                }              

            }

        }

    });

});  

</script>

</body>

</html>