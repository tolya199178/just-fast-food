<?php
	session_start();

	include("include/functions.php");
	$hide_form = "false";

	$ARRAY = array( 'j_name', 'j_email', 'j_phoneno', 'j_address', 'j_city', 'j_postcode', 'j_rest_name','j_rest_type','j_rest_delivery');

	foreach($ARRAY as $v) {
		$ARRAYTEMP[$v] = '';
	}

	if(isset($_SESSION['access_key']) && isset($_POST['access']) && $_POST['access'] == $_SESSION['access_key']) {

		if(isset($_POST['SUBMIT'])) {

			include_once("include/email-send.php");

			$json_post = getEandN($_POST['j_postcode']);
			if($json_post) {

				$value = "NULL, ";
				$value .= "'0', ";
				foreach($ARRAY as $values) {
					$value .= "'".mysql_real_escape_string($_POST[$values])."', ";
				}
				$value .= "'pending', ";
				$value .= "'', ";
				$value .= "NULL";

				$extra = "`j_email` = '".$_POST['j_email']."'";
				$result = INSERT($value ,'join_restaurant' ,'unique' ,$extra);

				if($result) {

					$_SESSION['success'] = "Thank you for your interest in Just-FastFood. One of our Sales advisors will be in touch soon!";

					$hide_form = "true";
					unset($_SESSION['access_key']);
					$STRSEND = array(
								'type' => 'new-join_rest',
								'email' => $_POST['j_email'],
								'user_email' => $_POST['j_email'],
								'rest_name' => $_POST['j_rest_name'],
								'post_code' => $_POST['j_postcode'],
								'user_name' => $_POST['j_name'],
								'phone_no' => $_POST['j_phoneno']
							);
					SENDMAIL($STRSEND , true);
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
	<meta name="description" content="Restaurant owner?  Register on our website to reach more customers. Profit maximization and Sales increase">
	<meta name="keywords" content="Restaurant owner?, <?= getDataFromTable('setting','keywords'); ?>">
	<meta name="author" content="Ade">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="apple-touch-icon" href="items-pictures/default_rest_img.png">

	<link rel="shortcut icon" href="images/favicon.ico">
	<title>Own Restaurant - Place your restaurant online. Signup to get more customers</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/fancybox/jquery.fancybox.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />

	<link href="css/iphone.css" rel="stylesheet" type="text/css" media="only screen and (min-width: 0px) and (max-width: 320px)" >
	<link href="css/ipad.css" rel="stylesheet" type="text/css"  media="only screen and (min-width: 321px) and (max-width: 768px)" >

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/validate.js"></script>
	<script type="text/javascript" src="css/fancybox/jquery.fancybox.js"></script>
	<script type="text/javascript" src="js/mobileMenu.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#signupForm").validate({
				errorPlacement: function ($error, $element) {
					if ($element.attr("name") == "accept") {
						$error.insertAfter($element.next());
					} else {
						$error.insertAfter($element);
					}
				}
			});
			$(".pop_box").fancybox();
			$('#main-nav').mobileMenu();
		});
	</script>
</head>
<body>
	<div class="header">
		<?php require('templates/header.php');?>
	</div>
	<div class="content">
		<div class="wrapper ">
			<?php include('include/notification.php');?>
			<div class="fl-left login-wrap">
				<div class="box own-res-box">
					<h2 class="red">Why join Just-FastFood?</h2>
					<p>"The best marketing and business move we've made"</p><hr class="hr"/>
					<p class="small"><span class="b red">The future of business is online</span><br/>
						<ul>
							<li>Just-FastFood users are growing tremendously daily</li>
							<li>10 million hungry surfers - On average, people using the internet every day order takeaway twice a month</li>
							<li>Customers can pay by card, PayPal or Cash on a secure website</li>
						</ul>
					</p>
					<p class="small"><span class="b red">More business</span><br/>
						<ul>
							<li>Average revenue increase ranges from 15-25% a year</li>
							<li>You don't have to invest in marketing, we do all the work</li>
                            <li>We ensure you can be reached by local customers</li>
						</ul>
					</p>
					<p class="small"><span class="b red">You don't have delivery services? Don't worry</span><br/>
						<ul>
							<li>We do delivery for you if your restaurants hasn't got one already</li>
							<li>Just get the food ready, our delivery guys will come pick it up and deliver to your customers</li>
							<li>Makes you focus on whats important ensuring good food is prepared and we do the rest</li>
						</ul>
					</p>
					<hr class="hr"/>

				</div>
			</div>

			<?php if($hide_form != 'true') {?>
			<div class="fl-left sign-up-wrap">
				<div class="box-wrap">
					<form action="" method="post" id="signupForm">
						<div class="row">
							<div class="red-wrap">
								<h2>Enquiry</h2>
							</div>

							<p class="small txt-right"><span class="red">Please note: input fields marked with a * are required fields.</span></p>
						</div>
						<div class="row">
							<label for="j_name">Manager's Name<span>*</span></label><input type="text" name="j_name" id="j_name" class="input required" value="<?php echo $ARRAYTEMP['j_name'];?>"/>
						</div>
						<div class="row">
							<label for="j_email">Email Address<span>*</span></label><input type="text" name="j_email" id="j_email" class="input required email" value="<?php echo $ARRAYTEMP['j_email'];?>"/>
						</div>

						<div class="row">
							<label for="j_phoneno">Phone No<span>*</span></label><input type="text" name="j_phoneno" id="j_phoneno" class="input required" value="<?php echo $ARRAYTEMP['j_phoneno'];?>"/>
						</div>
						<div class="row">
							<label for="j_rest_name">Restaurant name:<span>*</span></label><input type="text" name="j_rest_name" id="j_rest_name" class="input required" value="<?php echo $ARRAYTEMP['j_rest_name'];?>"/>
						</div>
						<div class="row">
							<label for="j_rest_type">Cuisines:<span>*</span></label>
							<select name="j_rest_type" id="j_rest_type" class="required " style="padding:2px">
								<option value="">- Please Select -</option>
                                
                                <option value="American">American</option>
                                <option value="Balti">Balti</option>
                                <option value="Bangladeshi">Bangladeshi</option>
                                <option value="Brazilian">Brazilian</option>
                                <option value="Breakfast">Breakfast</option>
                                <option value="Burgers & Chicken">Burgers & Chicken</option>
                                <option value="Cantonese">Cantonese</option>
                                <option value="Caribbean">Caribbean</option>
                                <option value="Charcoal Chicken">Charcoal Chicken</option>
                                <option value="Chinese">Chinese</option>
                                <option value="Desserts">Desserts</option>
                                <option value="Dim Sum">Dim Sum</option>
                                <option value="Egyptian">Egyptian</option>
                                <option value="Fish & Chips">Fish & Chips</option>
                                <option value="French">French</option>
                                <option value="Gastro">Gastro</option>
                                <option value="Greek">Greek</option>
                                <option value="Halal">Halal</option>
                                <option value="Hungarian">Hungarian</option>
                                <option value="Indian">Indian</option>
                                <option value="Italian">Italian</option>
                                <option value="Japanese">Japanese</option>
                                <option value="Jerk Chicken">Jerk Chicken</option>
                                <option value="Kebab">Kebab</option>
                                <option value="Korean">Korean</option>
                                <option value="Lebanese">Lebanese</option>
                                <option value="Malaysian">Malaysian</option>
                                <option value="Mexican">Mexican</option>
                                <option value="Modern British">Modern British</option>
                                <option value="Moroccan">Moroccan</option>
                                <option value="Nepalese">Nepalese</option>
                                <option value="Nigerian">Nigerian</option>
                                <option value="Organic">Organic</option>
                                <option value="Oriental">Oriental</option>
                                <option value="Pakistani">Pakistani</option>
                                <option value="Peking">Peking</option>
                                <option value="Persian">Persian</option>
                                <option value="Pizza">Pizza</option>
                                <option value="Polish">Polish</option>
                                <option value="Portuguese">Portuguese</option>
                                <option value="Russian">Russian</option>
                                <option value="Salads">Salads</option>
                                <option value="Sandwiches">Sandwiches</option>
                                <option value="Soups">Soups</option>
                                <option value="South Indian">South Indian</option>
                                <option value="Spanish">Spanish</option>
                                <option value="Sri Lankan">Sri Lankan</option>
                                <option value="Sushi">Sushi</option>
                                <option value="Syrian">Syrian</option>
                                <option value="Tapas">Tapas</option>
                                <option value="Thai">Thai</option>
                                <option value="Turkish">Turkish</option>
                                <option value="Vegetarian">Vegetarian</option>
                                <option value="Vietnamese">Vietnamese</option>
                                <option value="Other">Other</option>
							</select>
						</div>
						<div class="row">
							<label for="j_rest_delivery">Do you have a delivery service?:<span>*</span></label>
							<select name="j_rest_delivery" id="j_rest_delivery" class=" required" style="padding:2px">
								<option value="">- Select -</option>
								<option value="yes">Yes</option>
								<option value="no">No</option>
							</select>
						</div>
						<div class="row">
							<label for="j_address">Address<span>*</span></label><input type="text" name="j_address" id="j_address" class="input required" value="<?php echo $ARRAYTEMP['j_address'];?>"/>
						</div>
						<div class="row">
							<label for="j_city">City<span>*</span></label><input type="text" name="j_city" id="j_city" class="input required" value="<?php echo $ARRAYTEMP['j_city'];?>"/>
						</div>
						<div class="row">
							<label for="j_postcode">Post Code<span>*</span></label><input type="text" name="j_postcode" id="j_postcode" class="input required postcode" value="<?php echo $ARRAYTEMP['j_postcode'];?>"/>
						</div>
						<div class="row">
							<input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
						</div>
						<div class="row">
							<input type="checkbox" name="accept" id="" class="required"/>
							<p class="" style="display:inline">I accept the <a href="terms.php" class="u red pop_box">terms and conditions</a> &amp; <a href="privacy.php" class="u red pop_box">privacy policy</a></p>
						</div>
						<div class="row txt-right">
							<input type="submit" value="Submit" class="btn" name="SUBMIT"/>
						</div>
					</form>
				</div>
			</div>
			<?php } ?>
			<div class="clr"></div>
		</div>
	</div>
	<div class="footer">
		<?php require('templates/footer.php');?>
	</div>
</body>
</html>