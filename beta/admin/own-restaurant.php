<?php
	session_start();
	require_once('include/auth.php');
	include("../include/functions.php");
	$INSERT = 'false';
	$ERROR_UPDATE = false;
	$update = false;
	$successUpdateMsg = "";
	$ARRAY = array('j_name', 'j_email', 'j_phoneno', 'j_address', 'j_city', 'j_postcode', 'j_rest_name','j_rest_type','j_rest_delivery');

	$TABLE_NAME = "join_restaurant";
	$TABLE_ID = "j_id";

	foreach($ARRAY as $v) {
		$ARRAYTEMP[$v] = '';
	}

	if(isset($_POST['add'])) {
		if(isset($_POST['update'])) {

			$alsoUpd = "";
			$passStr = "";
			if($_POST['j_status'] == 'active') {

				$select = "*";
				$where = "`".$TABLE_ID."` = '".$_POST['id']."'";
				$join_rest = SELECT($select ,$where, $TABLE_NAME, 'array');

				$randpassword = 'join-'.rand().rand();
				$passStr = ", `j_password` = '".md5($randpassword)."'";

				$ARRAY_ITEM = array('type_name' ,'type_email', 'type_password', 'type_picture', 'type_phoneno' ,'type_time','type_notes','type_charges' ,'type_steps', 'type_min_order' ,'type_opening_hours' ,'type_category', 'type_is_delivery' , 'type_special_offer' ,'type_status');

				$value = "NULL, ";
				$value .= "'".$join_rest['j_name']."',";
				$value .= "'".$join_rest['j_email']."',";
				$value .= "'".$join_rest['j_name']."',";
				$value .= "'default_rest_img.png',";
				$value .= "'".$join_rest['j_phoneno']."',";
				$value .= "'',";
				$value .= "'',";
				$value .= "'',";
				$value .= "'',";
				$value .= "'',";
				$value .= "'',";
				$value .= "'".$join_rest['j_rest_type']."',";
				$value .= "'".$join_rest['j_rest_delivery']."',";
				$value .= "'',";
				$value .= "'pending',";
				$value .= " NULL";

				$result_ID = INSERT($value ,'menu_type' ,'id' ,'');
				$alsoUpd = ", `j_type_id` = '".$result_ID."'";

				$message = "<h1>Just-FastFood</h1><hr/><br/>";
				$message .= "This is automated Email Receive From Just-FastFood.com<br/><br/>";
				$message .= "Congratulations! Your Account has been approved as Partner at just-fastfood.com<br>";
				$message .= "Please follow this link to change status as active of your restaurant, so that it will appear on Just-FastFood. Add categories and items to your Restaurant.</br>";
				$message .= "<a href='http://just-fastfood.com/admin/?type=partner'>http://just-fastfood.com/admin/?type=partner</a><br><br>";
				$message .= "EMAIL : ".$_POST['j_email'].'<br/>';
				$message .= "PASSWORD : ".$randpassword;
				$message .= "RESTAURANT ID : ".$result_ID;

				$to = $_POST['j_email'];
				$subject = "Partner Account Approved!";
				$headers = "From:Just-FastFood <admin@just-fastfood.com>\r\n";
				$headers .= 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				mail($to, $subject, $message, $headers);
				
			}

			$query = "UPDATE  `".$TABLE_NAME."` SET `j_status` = '".$_POST['j_status']."' ".$passStr."  ".$alsoUpd."  WHERE `j_id` = '".$_POST['id']."'";
			$obj -> query_db($query) or die(mysql_error());
			$INSERT = 'true';
			$result = 'true';
			$successUpdateMsg = "Successfully Updated";
		}
	}

	if(isset($_GET['edit']) && isset($_GET['id'])) {
		$select = "*";
		$where = "`".$TABLE_ID."` = '".$_GET['id']."'";
		$result = SELECT($select ,$where, $TABLE_NAME, 'array');
		if($result == false) {
			$ERROR_UPDATE = "ERROR!! Data Not Exist";
		} else {
			foreach($ARRAY as $v) {
				$ARRAYTEMP[$v] = $result[$v];
			}
			$ARRAYTEMP['id'] = $_GET['id'];
			$update = true;
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
						<div class="header"><span><span class="ico  gray connect"></span>Join Restaurant Details</span>
						</div>
						<!-- End header -->
						<div class="clear"></div>
						<div class="content">
							<div id="uploadTab">
								<ul class="tabs">
									<?php
										if($update) {
									?>
										<li><a href="#tab1" id="2"> Edit</a></li>
									<?php
										}
									?>
									<li><a href="#tab2" id="3"> Browse <img src="images/icon/new.gif" width="20" height="9" /></a></li>
								</ul>
								<div class="tab_container">
									<?php
										$id = "";
										if($update) {
											$id = $_GET['id'];
									?>
									<div id="tab1" class="tab_content">
										<div class="load_page">
											<form class="tableName toolbar" method="post" action="own-restaurant">

												<div class="section last">
													<label>Owner Name</label>
													<div>
														<label for=""><?php echo $ARRAYTEMP['j_name']?></label>
													</div>
												</div>
												<div class="section last">
													<label>Email</label>
													<div>
														<label for="" style="text-transform: none;"><?php echo $ARRAYTEMP['j_email']?></label>
														<input type="hidden" name="j_email" value="<?php echo $ARRAYTEMP['j_email']?>"/>
													</div>
												</div>
												<div class="section last">
													<label>Restaurant Name</label>
													<div>
														<label for=""><?php echo $ARRAYTEMP['j_rest_name']?></label>
													</div>
												</div>
												<div class="section last">
													<label>Restaurant Type</label>
													<div>
														<label for=""><?php echo $ARRAYTEMP['j_rest_type']?></label>
													</div>
												</div>
												<div class="section last">
													<label>Own Delivery</label>
													<div>
														<label for=""><?php echo $ARRAYTEMP['j_rest_delivery']?></label>
													</div>
												</div>
												<div class="section last">
													<label>Restaurant Postcode</label>
													<div>
														<label for=""><?php echo $ARRAYTEMP['j_postcode']?></label>
														<input type="hidden" name="j_rest_name" value="<?php echo $ARRAYTEMP['j_rest_name']?>"/>
													</div>
												</div>
												<div class="section last">
													<label>Restaurant Address</label>
													<div>
														<label for=""><?php echo $ARRAYTEMP['j_address']?></label>
													</div>
												</div>

												<div class="section last">
													<label>Chabge Status</label>
													<div>
														<select name="j_status" id="">
															<option value="pending">Pending</option>
															<option value="active">Active</option>
														</select>
													</div>
												</div>

												<div class="section last">
													<input type="hidden" name="add" value="add"/>
													<input type="hidden" name="update" value="update"/>
													<input type="hidden" name="id" value="<?php echo $id?>"/>
													<div><input type="submit" value="Update" class="uibutton" /></div>
												</div>
											</form>
										</div>
									</div>
									<?php
										}
									?>
									<!--tab1-->
									<div id="tab2" class="tab_content">
										<div class="load_page">
											<form class="tableName toolbar">
												<h3>Join Restaurant</h3>
												<?php
													$where_clause = "";
													if(isset($_GET['type'])) {
														if($_GET['type'] == 'active'){
															$where_clause = ' WHERE `j_status` = "active"';
														} else if($_GET['type'] == 'pending'){
															$where_clause = ' WHERE `j_status` = "pending"';;
														}
													}
												?>
												<script type="text/javascript">
													var dataSend = [{'j_name':'Full Name','j_email':'Email', 'j_phoneno': 'Phone No' ,'j_address':'Address', 'j_city':'City' , 'j_postcode':'Post Code','j_rest_name':'Restaurant Name','j_status':'Status'}];
													$.ajax({
														  type: "POST",
														  url: 'include/browse-table.php',
														  data: { col : dataSend, table : '`<?php echo $TABLE_NAME;?>`', status : 'j_status' , editURL : 'own-restaurant?edit=true&id=', delColumn : '<?php echo $TABLE_ID;?>' , where : '<?php echo $where_clause;?>' , actualTable : '<?php echo $TABLE_NAME;?>'},
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