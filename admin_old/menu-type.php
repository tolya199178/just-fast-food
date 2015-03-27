<?php
	session_start();
	require_once('include/auth.php');
	include("../include/functions.php");

	$PARTNER = "";
	$PID = "";

	if(isset($_SESSION['ADMIN_PARTNER'])){
		$PARTNER = "true";
		$PID = getPId($_SESSION['ADMIN_PARTNER']);
	}

	if($PID != $_GET['id'] && $PID != ""){
		header('location:menu-type?edit=true&id='.$PID);
		die();
	}

	$INSERT = 'false';
	$ERROR_UPDATE = false;
	$update = false;
	$successUpdateMsg = "";
	$ARRAY = array('type_name' ,'type_email', 'type_password', 'type_picture', 'type_phoneno' ,'type_time','type_notes','type_charges' ,'type_steps', 'type_min_order' ,'type_opening_hours' ,'type_category', 'type_is_delivery' , 'type_special_offer' ,'type_status');
	foreach($ARRAY as $v) {
		$ARRAYTEMP[$v] = '';
	}

	if(isset($_POST['add'])) {

		$_POST['type_opening_hours'] = json_encode($_POST['type_opening_hours']);
		if($_POST['type_special_offer']['pound'] > 0) {
			$_POST['type_special_offer'] = json_encode($_POST['type_special_offer']);
		} else {
			$_POST['type_special_offer'] = "";
		}

		if($_POST['type_category'] == 'fastfood') {
			$_POST['type_is_delivery'] = "yes";
		}

		if(count($_FILES)  && $_FILES['type_picture']['name'] != "") {
			$upload = singleFileUpload($_FILES, 'type_picture');
		} else {
			$upload['error'] = '0';
			if(isset($_POST['update'])) {
				$upload['img_name'] = $_POST['old_type_picture'];
			} else {
				$upload['img_name'] = 'default_rest_img.png';
			}
		}

		if(isset($_POST['update'])) {
			$val = "";
			foreach($ARRAY as $values) {
				if($values == "type_picture") {
					$val .= "`".$values."` = '".$upload['img_name']."',";
				} else {
					$val .= "`".$values."` = '".$_POST[$values]."',";
				}
			}
			$val = substr($val ,0 ,-1);
			$query = "UPDATE  `menu_type` SET ".$val."  WHERE `type_id` = '".$_POST['type_id']."'";
			$obj -> query_db($query) or die(mysql_error());
			$INSERT = 'true';
			$result = 'true';
			$successUpdateMsg = "Successfully Updated";
		} else {
			if($upload['error'] == 0){
				$value = "NULL, ";
				foreach($ARRAY as $values) {
					if($values == "type_picture") {
						$value .= "'".mysql_real_escape_string($upload['img_name'])."',";
					} else {
						$value .= "'".mysql_real_escape_string($_POST[$values])."',";
					}
				}
				$value .= " NULL";
				$result = INSERT($value ,'menu_type' ,false ,'');
				$INSERT = 'true';

				$message = "<h1>Just-FastFood</h1><hr/><br/>";
				$message .= "This is automated Email Receive From Just-FastFood.com<br/><br/>";
				$message .= "A NEW Restaurant (".$_POST['type_name'].") is added at ".date('H:m:i Y-m-d');

				$to = admin_email();
				$subject = "New Restaurant Added";
				$headers = "From:Just-FastFood <admin@just-fastfood.com>\r\n";
				$headers .= 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				mail($to, $subject, $message, $headers);
			} else {
				$INSERT = 'true';
				$result = false;
				$errorMSG = $upload['msg'];
			}
		}

		if(isset($_SESSION['ADMIN_PARTNER'])){
			$message = "<h1>Just-FastFood</h1><hr/><br/>";
			$message .= "This is automated Email Receive From Just-FastFood.com<br/><br/>";
			$message .= "Restaurant updated by partner Email : ".$_SESSION['ADMIN_PARTNER'];

			$to = admin_email();
			$subject = "Add/Update Item By Partner";
			$headers = "From:Just-FastFood <admin@just-fastfood.com>\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			mail($to, $subject, $message, $headers);
		}

	}

	if(isset($_GET['edit']) && isset($_GET['id'])) {
		$select = "*";
		$where = "`type_id` = '".$_GET['id']."'";
		$result = SELECT($select ,$where, 'menu_type', 'array');
		if($result == false) {
			$ERROR_UPDATE = "ERROR!! Data Not Exist";
		} else {
			foreach($ARRAY as $v) {
				if($v == 'type_opening_hours' || $v == 'type_special_offer'){
					$ARRAYTEMP[$v] = json_decode($result[$v], true);
				} else {
					$ARRAYTEMP[$v] = $result[$v];
				}
			}
			$ARRAYTEMP['type_id'] = $_GET['id'];
		}
		$update = true;
	}

	if($PARTNER != "" && $update == false && $PID != $_GET['id']){
		header('location:menu-type?edit=true&id='.$PID);
		die();
	}

	if($PARTNER == "true" && isset($_GET['id'])) {
		if(!checkPId($_GET['id'] ,$_SESSION['ADMIN_PARTNER'])){
			$ERROR_UPDATE = "ERROR!! Data Not Exist";
			$ARRAYTEMP = array();
		}
	}
	

?>
<!DOCTYPE html>
<html>

<head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="description" content="Admin" />
        <meta name="keywords" content="Admin,Just-FastFood" />

        <title>Just-FastFood - Admin</title>
        <!-- Link shortcut icon-->
        <link rel="shortcut icon" href="images/favicon.ico">
        <!-- Link css-->
        <link rel="stylesheet" type="text/css" href="css/zice.style.css"/>
        <link rel="stylesheet" type="text/css" href="css/icon.css"/>
        <link rel="stylesheet" type="text/css" href="css/ui-custom.css"/>
        <link rel="stylesheet" type="text/css" href="css/timepicker.css"  />
        <link rel="stylesheet" type="text/css" href="components/colorpicker/css/colorpicker.css"  />
        <link rel="stylesheet" type="text/css" href="components/elfinder/css/elfinder.css" />
        <link rel="stylesheet" type="text/css" href="components/datatables/dataTables.css"  />
        <link rel="stylesheet" type="text/css" href="components/validationEngine/validationEngine.jquery.css" />

        <link rel="stylesheet" type="text/css" href="components/jscrollpane/jscrollpane.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="components/fancybox/jquery.fancybox.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="components/tipsy/tipsy.css" media="all" />
        <link rel="stylesheet" type="text/css" href="components/editor/jquery.cleditor.css"  />
        <link rel="stylesheet" type="text/css" href="components/chosen/chosen.css" />
        <link rel="stylesheet" type="text/css" href="components/confirm/jquery.confirm.css" />
        <link rel="stylesheet" type="text/css" href="components/sourcerer/sourcerer.css"/>
        <link rel="stylesheet" type="text/css" href="components/fullcalendar/fullcalendar.css"/>
        <link rel="stylesheet" type="text/css" href="components/Jcrop/jquery.Jcrop.css"  />


        <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="components/flot/excanvas.min.js"></script><![endif]-->

        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="components/ui/jquery.ui.min.js"></script>
        <script type="text/javascript" src="components/ui/jquery.autotab.js"></script>
        <script type="text/javascript" src="components/ui/timepicker.js"></script>
        <script type="text/javascript" src="components/colorpicker/js/colorpicker.js"></script>
        <script type="text/javascript" src="components/checkboxes/iphone.check.js"></script>
        <script type="text/javascript" src="components/elfinder/js/elfinder.full.js"></script>
        <script type="text/javascript" src="components/datatables/dataTables.min.js"></script>
        <script type="text/javascript" src="components/scrolltop/scrolltopcontrol.js"></script>
        <script type="text/javascript" src="components/fancybox/jquery.fancybox.js"></script>
        <script type="text/javascript" src="components/jscrollpane/mousewheel.js"></script>
        <script type="text/javascript" src="components/jscrollpane/mwheelIntent.js"></script>
        <script type="text/javascript" src="components/jscrollpane/jscrollpane.min.js"></script>
        <script type="text/javascript" src="components/spinner/ui.spinner.js"></script>
        <script type="text/javascript" src="components/tipsy/jquery.tipsy.js"></script>
        <script type="text/javascript" src="components/editor/jquery.cleditor.js"></script>
        <script type="text/javascript" src="components/chosen/chosen.js"></script>
        <script type="text/javascript" src="components/confirm/jquery.confirm.js"></script>
        <script type="text/javascript" src="components/validationEngine/jquery.validationEngine.js" ></script>
        <script type="text/javascript" src="components/validationEngine/jquery.validationEngine-en.js" ></script>
        <script type="text/javascript" src="components/vticker/jquery.vticker-min.js"></script>
        <script type="text/javascript" src="components/sourcerer/sourcerer.js"></script>
        <script type="text/javascript" src="components/fullcalendar/fullcalendar.js"></script>
        <script type="text/javascript" src="components/flot/flot.js"></script>
        <script type="text/javascript" src="components/flot/flot.pie.min.js"></script>
        <script type="text/javascript" src="components/flot/flot.resize.min.js"></script>
        <script type="text/javascript" src="components/flot/graphtable.js"></script>

        <script type="text/javascript" src="components/uploadify/swfobject.js"></script>
        <script type="text/javascript" src="components/uploadify/uploadify.js"></script>
        <script type="text/javascript" src="components/checkboxes/customInput.jquery.js"></script>
        <script type="text/javascript" src="components/effect/jquery-jrumble.js"></script>
        <script type="text/javascript" src="components/filestyle/jquery.filestyle.js" ></script>
        <script type="text/javascript" src="components/placeholder/jquery.placeholder.js" ></script>
		<script type="text/javascript" src="components/Jcrop/jquery.Jcrop.js" ></script>
        <script type="text/javascript" src="components/imgTransform/jquery.transform.js" ></script>
        <script type="text/javascript" src="components/webcam/webcam.js" ></script>
		<script type="text/javascript" src="components/rating_star/rating_star.js"></script>
		<script type="text/javascript" src="components/dualListBox/dualListBox.js"  ></script>
		<script type="text/javascript" src="components/smartWizard/jquery.smartWizard.min.js"></script>
        <script type="text/javascript" src="js/jquery.cookie.js"></script>
        <script type="text/javascript" src="js/zice.custom.js"></script>

		<?php

			if($INSERT == 'true') {
				if($result) {
					if($successUpdateMsg != "") {
						echo '<script type="text/javascript">window.onload = function() {showSuccess("'.$successUpdateMsg.'",5000);}</script>';
					} else {
						echo '<script type="text/javascript">window.onload = function() {showSuccess("Successfully Inserted",5000);}</script>';
					}
				} else {
					echo '<script type="text/javascript">window.onload = function() {showError("Error in Inserting",2000);}</script>';
				}
			}
			if($ERROR_UPDATE != false) {
				echo '<script type="text/javascript">window.onload = function() {showError("'.$ERROR_UPDATE.'",7000);}</script>';
			}
		?>
        </head>
        <body class="dashborad">
			<?php include('templates/header.php');?>


            <div id="content">
				<div class="inner">
					<div class="topcolumn">
						<div class="logo"></div>
						<ul id="shortcut">
							<li> <a href="dashbord" title="Back To home"> <img src="images/icon/shortcut/home.png" alt="home"/><strong>Home</strong> </a></li>
							<li> <a href="setting" title="Setting"> <img src="images/icon/shortcut/setting.png" alt="setting" /><strong>Setting</strong></a></li>
						</ul>
					</div>

				</div>
				<div class="clear"></div>
					<div class="onecolumn">
						<div class="header"><span><span class="ico  gray connect"></span>Menu Types</span>
						</div>
						<!-- End header -->
						<div class="clear"></div>
						<div class="content">
							<div id="uploadTab">
								<ul class="tabs">
									<li><a href="#tab1" id="2">  Add New Type  </a>

									</li>
									<?php if ($PARTNER == ""){ ?>
									<li><a href="#tab2" id="3"> Browse <img src="images/icon/new.gif" width="20" height="9" /></a>

									</li>
									<?php } ?>
								</ul>
								<div class="tab_container">
									<div id="tab1" class="tab_content">
										<div class="load_page">
											<div class="formEl_b">
												<?php if(!$ERROR_UPDATE) { ?>
												<form id="validation" method="post" action="menu-type"  enctype="multipart/form-data">
													<fieldset>
														<legend>Restaurant</legend>
														<div class="section last">
															<label>Restaurant Name<small>New Menu Type (i:e KFC)</small></label>
															<div>
																<input type="text" class="validate[required] large" name="type_name" id="type_name" value="<?php echo $ARRAYTEMP['type_name']?>">
															</div>
														</div>
														<div class="section last">
															<label>Restaurant Email<small>(Order will sent to this email also for login Restaurant Profile)</small></label>
															<div>
																<input type="text" class="validate[required,custom[email]] large" name="type_email" id="type_email" value="<?php echo $ARRAYTEMP['type_email']?>">
															</div>
														</div>
														<div class="section last">
															<label>Restaurant Password<small>(Password for login Restaurant Profile)</small></label>
															<div>
																<input type="text" class="validate[required] large" name="type_password" id="type_password" value="<?php echo $ARRAYTEMP['type_password']?>">
															</div>
														</div>
														<div class="section last">
															<label>Restaurant Phoneno<small>Orders will sent on this no (if takeaway restaurant)</small></label>
															<div>
																<input type="text" class="validate[required] large" name="type_phoneno" id="type_phoneno" value="<?php echo $ARRAYTEMP['type_phoneno']?>">
															</div>
														</div>
														<div class="section last">
															<label>Restaurat Category</label>
															<div>
																<select name="type_category" id="type_category">
																	<option <?php echo ($ARRAYTEMP['type_category'] == 'fastfood') ? 'selected' : ''; ?> value="fastfood">Fast Food</option>
																	<option <?php echo ($ARRAYTEMP['type_category'] == 'takeaway') ? 'selected' : ''; ?> value="takeaway">Takeaway</option>
																</select>
															</div>
														</div>
														<div class="section last">
															<label>Is providing own delivery?</label>
															<div>
																<select name="type_is_delivery" id="type_is_delivery">
																	<option <?php echo ($ARRAYTEMP['type_is_delivery'] == 'yes') ? 'selected' : ''; ?> value="yes">Yes</option>
																	<option <?php echo ($ARRAYTEMP['type_is_delivery'] == 'no') ? 'selected' : ''; ?> value="no">No</option>
																</select>
															</div>
														</div>
														<?php
															if($update) {
														?>
														<div class="section last">
															<label>Old Picture</label>
															<div>
																<img src="../items-pictures/<?php echo $ARRAYTEMP['type_picture']; ?>" alt="" style="width:200px; height:200px"/>
																<input type="hidden" name="old_type_picture" value="<?php echo $ARRAYTEMP['type_picture']; ?>"/>
															</div>
														</div>
														<?php
														}
														?>
														<div class="section last">
															<label>Picture</label>
															<div>
																<input type="file" class="file fileupload" name="type_picture" id="type_picture">
															</div>
														</div>
														<div class="section last">
															<label>1mile Delivery Time<small>approx (i.e : 45)</small></label>
															<div>
																<input type="text" class="validate[required,custom[onlyNumberSp]] xxsmall" name="type_time" id="type_time" value="<?php echo $ARRAYTEMP['type_time']?>">
															</div>
														</div>
														<div class="section last">
															<label>Delivery Charges/Mile (0 for free shipping)<small>All Charges in &pound; (pound)</small></label>
															<div>
																<input type="text" class="validate[required]" name="type_charges" id="sDec" value="<?php echo $ARRAYTEMP['type_charges']?>">
															</div>
														</div>
														<div class="section last">
															<label>Delivery Charges Steps<small>i.e : 4 (mean : [0-3 , 4-7...]*delivery charges)</small></label>
															<div>
																<input type="text" class="validate[required] xxsmall" name="type_steps" id="type_steps" value="<?php echo $ARRAYTEMP['type_steps']?>">
															</div>
														</div>																												<div class="section last">															<label>Minimum Order Amount<small>0 for no limit</small></label>															<div>																<input type="text" class="validate[required] sDec" name="type_min_order" id="type_min_order" value="<?php echo $ARRAYTEMP['type_min_order']?>">															</div>														</div>
														<div class="section last">
															<label>Special Note</label>
															<div>
																<input type="text" class="large" name="type_notes" id="type_notes" value="<?php echo $ARRAYTEMP['type_notes']?>">
															</div>
														</div>
														<div class="section last">
															<label>Special Offer</label>
															<div>
																After Ordr of &pound; <input type="text" class="sDec" name="type_special_offer[pound]" value="<?php echo $ARRAYTEMP['type_special_offer']['pound']?>"><br/>
																<input type="text" class="sDec" name="type_special_offer[off]"  value="<?php echo $ARRAYTEMP['type_special_offer']['off']?>"> % off
															</div>
														</div>
														<div class="section last">
															<label>Status</label>
															<div>
																<select name="type_status" id="">
																	<option value="active">Active</option>
																	<option value="non-active">Non Actie</option>
																</select>
															</div>
														</div>


													</fieldset><br>
													<fieldset>
														<legend>Opening Hours</legend>
														<?php
															$daysofweek = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
															foreach($daysofweek as $value){
														?>
															<div class="section">
																<label><?php echo $value?></label>
																<div>From: <input type="text" class="timepicker"  readonly="readonly" name="type_opening_hours[<?php echo $value;?>][From]" value="<?php echo ($ARRAYTEMP['type_opening_hours'] == '') ? '' : $ARRAYTEMP['type_opening_hours'][$value]['From']?>"/></div>
																<div>To: &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="timepicker"  readonly="readonly" name="type_opening_hours[<?php echo $value;?>][To]"  value="<?php  echo ($ARRAYTEMP['type_opening_hours'] == '') ? '' : $ARRAYTEMP['type_opening_hours'][$value]['To']?>"/></div>
															</div>
														<?php
															}
														?>
													</fieldset>

													<div class="section last">
														<input type="hidden" name="add" value="add"/>
														<?php
															if($update) {
																echo '<input type="hidden" name="update" value="true"/>';
																echo '<input type="hidden" name="type_id" value="'.$ARRAYTEMP['type_id'].'"/>';
															}
														?>
														<div> <a class="uibutton submit_form">Add</a></div>
													</div>
												</form>
												<?php } ?>
											</div>
										</div>
									</div>
									<!--tab1-->
									<?php if ($PARTNER == ""){ ?>
									<div id="tab2" class="tab_content">
										<div class="load_page">
											<form class="tableName toolbar">
												<h3>All Types</h3>
												<script type="text/javascript">
													var dataSend = [{'type_id':'ID','type_name':'Name', 'type_status':'Status','type_time':'1mile Delivery Time','type_notes':'Special Notes', 'type_category':'Category'}];
													$.ajax({
														  type: "POST",
														  url: 'include/browse-table.php',
														  data: { col : dataSend, table : 'menu_type', status : 'type_status' , editURL : 'menu-type?edit=true&id=', delColumn : 'type_id', where : '' , actualTable : 'menu_type'},
														  success: function(data) {
															$('.ajax-response').html(data);
														  }
													});
												</script>
												<div class="ajax-response">

												</div>
											</form>
										</div>
									</div>
									<?php } ?>
									<!--tab2-->
								</div>
							</div>
							<!--/END TAB/-->
							<div class="clear" /></div>
					</div>
				<div class="clear"></div>

			</div>
			<?php include('templates/footer.php');?>
			<!--// End inner -->
			</div>
			<!--// End content -->
</body>
</html>