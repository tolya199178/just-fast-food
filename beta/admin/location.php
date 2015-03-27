<?php
	session_start();
	require_once('include/auth.php');
	include("../include/functions.php");
	$INSERT = 'false';
	$ERROR_UPDATE = false;
	$update = false;
	$successUpdateMsg = "";
	$ARRAY = array( 'location_city', 'location_postcode', 'location_menu_id', 'location_status',);
	foreach($ARRAY as $v) {
		$ARRAYTEMP[$v] = '';
	}


	$WHERE_CLAUSE = "";
	$WHERE_CLAUSE1 = "";
	$PARTNER ="";
	$PID = "";
	if(isset($_SESSION['ADMIN_PARTNER'])){
		$PARTNER = "true";

		$PID = getPId($_SESSION['ADMIN_PARTNER']);

		$WHERE_CLAUSE = " WHERE `type_id` = '".$PID."'";
		$WHERE_CLAUSE1 = ' AND  menu_type.type_id= "'.$PID.'"';

	}


	$TABLE_NAME = "location";
	$TABLE_ID = "location_id";

	if(isset($_POST['add'])) {
		$json_post = getEandN($_POST['location_postcode']);
		if($json_post) {
			$p[$_POST['location_postcode']] = $json_post;
			if(isset($_POST['update'])) {
				$val = "";
				foreach($ARRAY as $values) {
					if($values == 'location_postcode'){
						$val .= "`".$values."` = '".json_encode($p)."',";
					} else {
						$val .= "`".$values."` = '".$_POST[$values]."',";
					}
				}
				$val = substr($val ,0 ,-1);
				$query = "UPDATE  `".$TABLE_NAME."` SET ".$val."  WHERE `".$TABLE_ID."` = '".$_POST[$TABLE_ID]."'";
				$obj -> query_db($query) or die(mysql_error());
				$INSERT = 'true';
				$result = 'true';
				$successUpdateMsg = "Successfully Updated";
			} else {
				$value = "NULL, ";
				foreach($ARRAY as $values) {
					if($values == 'location_postcode'){
						$value .= "'".json_encode($p)."',";
					} else {
						$value .= "'".mysql_real_escape_string($_POST[$values])."',";
					}
				}
				$value .= "NULL";
				$result = INSERT($value , $TABLE_NAME ,'unique' ,'`location_postcode` = \''.json_encode($p).'\' AND `location_menu_id` = "'.$_POST['location_menu_id'].'"');
				if($result) {
					$INSERT = 'true';
				} else {
					foreach($ARRAY as $v) {
						if($v == 'location_postcode')
							$ARRAYTEMP[$v] = $_POST['location_postcode'];
						else
							$ARRAYTEMP[$v] = $_POST[$v];
					}
					$ERROR_UPDATE = "ERROR!! Post Code and Menu Already Exist";
				}
			}
		} else {
			$ERROR_UPDATE = "ERROR!! Post Code Not Valid";
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
				if($v == 'location_postcode'){
					$ARRAYTEMP[$v] = key(json_decode($result[$v]));
				} else {
					$ARRAYTEMP[$v] = $result[$v];
				}
			}

			$ARRAYTEMP[$TABLE_ID] = $result[$TABLE_ID];
			$update = true;
		}
	}

	/* if($PARTNER != "" && $update == false){
		header('location:location?edit=true&id='.$PID);
		die();
	}
	if(isset($_GET['id']) && $_GET['id'] != $PID && $PARTNER != ""){
		header('location:location?edit=true&id='.$PID);
		die();
	} */

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
						<div class="header"><span><span class="ico  gray connect"></span>Menu Location</span>
						</div>
						<!-- End header -->
						<div class="clear"></div>
						<div class="content">
							<div id="uploadTab">
								<ul class="tabs">
									<li><a href="#tab1" id="2">  Add New Location </a>

									</li>
									
									<li><a href="#tab2" id="3"> Browse All<img src="images/icon/new.gif" width="20" height="9" /></a>

									</li>
									
								</ul>
								<div class="tab_container">
									<div id="tab1" class="tab_content">
										<div class="load_page">
											<div class="formEl_b">
												
												<form id="validation" method="post" action="location">
													<fieldset>
														<legend>Location</legend>
														<div class="section last">
															<label>Restaurant Address</label>
															<div>
																<input type="text" class="large" name="location_city" id="location_city" value="<?php echo $ARRAYTEMP['location_city']; ?>">
															</div>
														</div>
														<div class="section last">
															<label>Postcode</label>
															<div>
																<input type="text" class="validate[required,custom[postcode]] large" name="location_postcode" id="location_postcode" value="<?php echo $ARRAYTEMP['location_postcode']; ?>">
															</div>
														</div>
														<?php
															if($update) {
																echo '<input type="hidden" name="location_menu_id" value="'.$ARRAYTEMP['location_menu_id'].'"/>';
															} else {
														?>
														<div class="section last">
															<label>Select Restaurant</label>
															<div>
																<select name="location_menu_id" id="location_menu_id">
																	<?php
																		$query = "SELECT * FROM `menu_type` ".$WHERE_CLAUSE."";
																		$valueOBJ = $obj->query_db($query);
																		while($res = $obj->fetch_db_array($valueOBJ)) {
																			($ARRAYTEMP['location_menu_id'] == $res['type_id']) ? $sel = 'selected' : $sel = '';
																	?>
																		<option value="<?php echo $res['type_id']?>" <?php echo $sel; ?>><?php echo $res['type_name']?></option>
																	<?php
																		}
																	?>
																</select>
															</div>
														</div>
														<?php } ?>

														<div class="section last">
															<label>Status</label>
															<div>
																<select name="location_status" id="">
																	<option value="active">Active</option>
																	<option value="non-active">Non Actie</option>
																</select>
															</div>
														</div>

														<div class="section last">
															<input type="hidden" name="add" value="add"/>
															<?php
																if($update) {
																	echo '<input type="hidden" name="update" value="true"/>';
																	echo '<input type="hidden" name="'.$TABLE_ID.'" value="'.$ARRAYTEMP[$TABLE_ID].'"/>';
																}
															?>
															<div> <a class="uibutton submit_form">Add</a></div>
														</div>

													</fieldset>
												</form>
												
											</div>
										</div>
									</div>
									<!--tab1-->
									
									<div id="tab2" class="tab_content">
										<div class="load_page">
											<form class="tableName toolbar">
												<h3>All Delivery Guys</h3>
												<script type="text/javascript">
													var dataSend = [{'location_city':'City', 'location_postcode': 'Post Code' ,'type_name':'Menu', 'location_status':'Status'}];
													$.ajax({
														  type: "POST",
														  url: 'include/browse-table.php',
														  data: { col : dataSend, table : '`location`,`menu_type`', status : 'staff_status' , editURL : 'location?edit=true&id=', delColumn : '<?php echo $TABLE_ID ?>' , where : ' WHERE location.location_menu_id = menu_type.type_id  <?php echo $WHERE_CLAUSE1; ?>' , actualTable : '<?php echo $TABLE_NAME ?>'},
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