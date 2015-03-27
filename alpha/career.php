<?php
	session_start();
	include("include/functions.php");

    if(isset($_SESSION['access_key']) && isset($_POST['access']) && $_POST['access'] == $_SESSION['access_key']) {
       if(isset($_POST['SUBMIT']) && ($_POST['name'] != "") && ($_POST['message'] != "") && ($_POST['subject']) || ($_POST['email'] != "")) {
           $to      = admin_email();
           $name    = mysql_real_escape_string(strip_tags($_POST['name']));
           $message = mysql_real_escape_string(strip_tags($_POST['message']));
           $email   = mysql_real_escape_string(strip_tags($_POST['email']));
           $subject = mysql_real_escape_string(strip_tags($_POST['subject']));


           $message = '<strong>'.$name." is interested in working for Just-FastFood. <br/> His/Her Email : ".$email.'.<br/> Phoneno : '.$phone.' <b> Subject: '.$subject.' .</br></strong><br/>';
           $message .= '"<i>'.mysql_real_escape_string(strip_tags($_POST['message'])).'</i>"';
          // $message .= '"<i>'.mysql_real_escape_string(strip_tags($_POST['subject'])).'</i>';
           $subject = $_POST['subject']." | Contact us Email";
           $headers = "From:Just-FastFood <info@just-fastfood.com>\r\n";
           $headers .= 'MIME-Version: 1.0' . "\r\n";
           $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
           if(mail($to, $subject, $message, $headers)) {
               $_SESSION['success'] = "Message Sent";
               $success = TRUE;

           } else {
               $_SESSION['error'] = "Email Not Send";
           }
       } else {
           $_SESSION['error'] = "Fill All Fields";
       }
    }

$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());
?>

	

<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="images/favicon.ico">
	<title> Careers | Just-FastFood  </title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />

	<style type="text/css">
		.box-wrap{
			font-size:13px;
			font-family: segoe ui, arial, helvetica, sans-serif;
			color: #222;
		}
		.box-wrap h3{
			margin:5px 0px 10px 0px;
		}
		.box-wrap strong{
			font-size:12px;
		}
		.box-wrap a{
			text-decoration:underline;
			color:#D62725;
		}
		
	</style>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/validate.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script type="text/javascript" src="js/mobileMenu.js"></script>
    <script type="text/javascript" src="js/parsely.min.js"></script>
    <script type="text/javascript" src="js/zepto.icheck.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            $("#form").parsley({
                successClass: 'row',
                errorClass: 'row'
            });

        });
    </script>
</head>
<body>
	<div class="header">
		<?php require('templates/header.php');?>
	</div>
	<div class="content">
		<div class="wrapper" style="font-family: "segoe ui>
			<div class=" box-wrap" style="margin:20px";>
				<h1 class="subheading">Self-Employed Delivery Drivers Needed</h1><hr>
				<h3>We urgently require self-employed delivery drivers in Manchester, Birmingham, London (any part), Leicester, Reading, Brighton, Bristol and surroundings. </h3>
				<p>	Interested applicants should fill in the contact form or email hr@just-fastfood.com</p>
				<p>We pay good rates per delivery including mileage!

                <div class="cbox-wrap margin-top login-wrap contactusWrap" style="width:96%">
                    <p>All fields marked <span class="red">*</span> are required.</p>
                    <form action="" method="post" id="loginForm" data-validate="parsley" >
                        <div class="row">
                            <label for="name"  class="b">Name: <span class="red">*</span></label><input type="text" name="name" id="name" class="input required" data-rangelength ="[4, 25]"/>
                        </div>
                        <div class="row">
                            <label for="email" class="b">Email Address: <span class="red">*</span></label><input type="text" name="email" id="email" class="input required email" data-type="email"/>
                        </div>
                        <div class="row">
                            <label for="phone"  class="b">Phone No: <span class="red">*</span></label><input type="text" name="phone" id="phone" class="input required" data-type="phone"/>
                        </div>
                        <div class="row" style="font-family: "segoe ui">
                            <label for="subject" class="b">Subject: <span class="red">*</span></label>
                            <select name="subject" id="subject" style="width:27%; padding:3px">
                                <option value="Interested in Manchester Jobs">Interested in Manchester Jobs</option>
                                <option value="Interested in Reading Jobs">Interested in Reading Jobs</option>
                                <option value="Interested in Leicester Jobs">Interested in Leicester Jobs</option>
                                <option value="Interested in Brighton Jobs">Interested in Brighton Jobs</option>
                                <option value="Interested in Bristol Jobs">Interested in Bristol Jobs</option>
                            </select>
                        </div>
                        <div class="row">
                            <label for="message" class="b">Message <span style="font-family: segoe ui; font-weight: lighter; font-size: 9px">(200 char max)</span> <span class="red">*</span></label>
                            <textarea name="message" id="message" class="required" style="width:60%; height: 125px; resize: vertical" data-rangelength= "[5,200]"></textarea>
                        </div>
                        <div class="row txt-right">
                            <input type="submit" value="Submit" name="SUBMIT" class="btn"/>
                            <input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
                        </div>
                    </form>
                </div>
			</div>
		</div>
	</div>
	<div class="footer">
		<?php require('templates/footer.php');?>
	</div>

</body>
</html>