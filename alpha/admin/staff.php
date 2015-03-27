<?php
session_start();
require_once('include/auth.php');
include("../include/functions.php");
include_once('../include/sms/send.php');

$INSERT           = 'false';
$ERROR_UPDATE     = false;
$update           = false;
$successUpdateMsg = "";
$ARRAY            = array(
    'staff_email',
    'staff_name',
    'staff_password',
    'staff_address',
    'staff_phoneno',
    'staff_postcode',
	'staff_max_distence',
	'staff_available_time',
    'staff_status'
);
foreach ($ARRAY as $v) {
    $ARRAYTEMP[$v] = '';
}
$TABLE_NAME = "staff";
$TABLE_ID   = "staff_id";
if (isset($_POST['add'])) {

	$_POST['staff_available_time'] = json_encode($_POST['staff_available_time']);
    if (isset($_POST['update'])) {
        $val = "";
        foreach ($ARRAY as $values) {
            if ($values == 'staff_postcode') {
                $p[$_POST[$values]] = getEandN($_POST[$values]);
                $val .= "`" . $values . "` = '" . json_encode($p) . "',";
            } else if ($values == 'staff_available_time') {
				$val .= "`" . $values . "` = " . json_encode($_POST['staff_available_time']) . ",";
			} else {
                $val .= "`" . $values . "` = '" . $_POST[$values] . "',";
            }
        }
        $val   = substr($val, 0, -1);
        $query = "UPDATE  `" . $TABLE_NAME . "` SET " . $val . "  WHERE `" . $TABLE_ID . "` = '" . $_POST[$TABLE_ID] . "'";
        $obj->query_db($query) or die(mysql_error());
        $INSERT           = 'true';
        $result           = 'true';
        $successUpdateMsg = "Successfully Updated";
    } else {
        $value = "NULL, ";
        foreach ($ARRAY as $values) {
			switch ($values) {

				case 'staff_password' :
					$value .= "'" . md5(mysql_real_escape_string($_POST[$values])) . "',";
					break;

				case 'staff_postcode' :
					$p[$_POST[$values]] = getEandN($_POST[$values]);
					$value .= "'" . json_encode($p) . "',";
					break;

				default :
					$value .= "'" . mysql_real_escape_string($_POST[$values]) . "',";
					break;
			}
        }
        $value .= "NULL";
        $result = INSERT($value, $TABLE_NAME, false, '');
        $INSERT = 'true';

		$SRTSEND['staff_name'] = $_POST['staff_name'];
		SENDSMS($_POST['staff_phoneno'] ,$SRTSEND , 'new_staff_added');
    }
}

$isSearch = false;
if (isset($_POST['SEARCH'])) {
    $isSearch     = true;
    $query_search = "SELECT COUNT(*) AS NumberOfOrders FROM `staff_order` WHERE  `staff_order_status` = 'complete' AND `staff_order_staff_id` = '" . $_POST['staff_serach_id'] . "' AND `staff_order_date_added` BETWEEN '" . $_POST['search_from'] . "' AND '" . $_POST['search_to'] . "'";
    $valueOBJSearch = $obj->query_db($query_search) or die(mysql_error());
    $array_Search = $obj->fetch_db_assoc($valueOBJSearch);
}
if (isset($_GET['edit']) && isset($_GET['id'])) {
    $select = "*";
    $where  = "`" . $TABLE_ID . "` = '" . $_GET['id'] . "'";
    $result = SELECT($select, $where, $TABLE_NAME, 'array');
    if ($result == false) {
        $ERROR_UPDATE = "ERROR!! Data Not Exist";
    } else {
        foreach ($ARRAY as $v) {
			if($v == 'staff_postcode') {
				$ARRAYTEMP[$v] = key(json_decode($result[$v]));
			} else if($v == 'staff_available_time') {
				$ARRAYTEMP[$v] = json_decode(stripslashes($result[$v]), true);
			} else {
				$ARRAYTEMP[$v] = $result[$v];
			}
        }
        $ARRAYTEMP[$TABLE_ID] = $_GET['id'];
        $update  = true;
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
						echo '<script type="text/javascript">window.onload = function() {showSuccess("Success",5000);}</script>';
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
        <?php include( 'templates/header.php'); ?>
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
                <div class="header"><span><span class="ico  gray connect"></span>Staff</span></div>
                <!-- End header -->
                <div class="clear"></div>
                <div class="content">
                    <div id="uploadTab">
                        <ul class="tabs">
                            <?php
								if ($isSearch) {
									echo '<li><a href="#tab0" id="1">Search Result</a>';
								}
							?>
                            <li>
                                <a href="#tab1" id="2">Add New Delivery Guy</a>
                            </li>
                            <li>
                                <a href="#tab2" id="3">Browse All
                                    <img src="images/icon/new.gif" width="20" height="9" />
                                </a>
                            </li>
                            <li>
                                <a href="#tab3" id="4">Their Orders</a>
                            </li>
                            <li>
                                <a href="#tab4" id="5">Total Orders</a>
                            </li>
                        </ul>
                        <div class="tab_container">
                            <?php if ($isSearch) { ?>
                            <div id="tab0" class="tab_content">
                                <div class="load_page">
                                    <div class="formEl_b">
                                        <fieldset>
                                            <legend>Search Result</legend>
                                            <div class="section" style="font-size: 17px;">
                                                <?php
													echo 'Total No of orders completed by staff id ' . $_POST['staff_serach_id'] . ' :
													<strong style="font-size:28px">
													' . $array_Search[ 'NumberOfOrders'] . '
													</strong>

													<br/>
													From [' . $_POST[ 'search_from'] . '] to [' . $_POST[ 'search_to'] . ']';
												?>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div id="tab1" class="tab_content">
                                <div class="load_page">
                                    <div class="formEl_b">
                                        <form id="validation" method="post" action="staff">
                                            <fieldset>
                                                <legend>Staff</legend>
                                                <div class="section last">
                                                    <label>Name</label>
                                                    <div>
                                                        <input type="text" class="validate[required] large" name="staff_name" id="staff_name" value="<?= $ARRAYTEMP['staff_name']; ?>">
                                                    </div>
                                                </div>
                                                <div class="section last">
                                                    <label>Email</label>
                                                    <div>
                                                        <input type="text" class="validate[required,custom[email]] large" name="staff_email" id="staff_email" value="<?= $ARRAYTEMP['staff_email']; ?>">
                                                    </div>
                                                </div>
                                                <div class="section last">
                                                    <label>Phone No</label>
                                                    <div>
                                                        <input type="text" class="validate[required] large" name="staff_phoneno" id="staff_phoneno" value="<?= $ARRAYTEMP['staff_phoneno']; ?>">
                                                    </div>
                                                </div>
                                                <div class="section last">
                                                    <label>Post Code
														<small>
														Specific Postcode For This Guy
														</small>
                                                    </label>
                                                    <div>
                                                        <input type="text" class="validate[required,custom[postcode]] large" name="staff_postcode" id="staff_postcode" value="<?= $ARRAYTEMP['staff_postcode']; ?>">
													</div>

												</div>
												<div class="section">
                                                    <label>Max Distence Covered <small>Distence in miles</small></label>
                                                    <div>
                                                        <input type="text" class="validate[required] sDec" name="staff_max_distence" id="staff_max_distence" value="<?= $ARRAYTEMP['staff_max_distence']; ?>">
                                                    </div>
                                                </div>
												<br/>
												<fieldset>
													<legend>Working Times</legend>
													<?php
														$daysofweek = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
														foreach($daysofweek as $value){
													?>
														<div class="section">
															<label><?php echo $value?></label>
															<div>From: <input type="text" class="timepicker"  readonly="readonly" name="staff_available_time[<?= $value;?>][From]" value="<?php echo ($ARRAYTEMP['staff_available_time'] == '') ? '' : $ARRAYTEMP['staff_available_time'][$value]['From']?>"/></div>
															<div>To: &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="timepicker"  readonly="readonly" name="staff_available_time[<?= $value;?>][To]"  value="<?php  echo ($ARRAYTEMP['staff_available_time'] == '') ? '' : $ARRAYTEMP['staff_available_time'][$value]['To']?>"/></div>
														</div>
													<?php
														}
													?>
												</fieldset>
												<?php if(!$update) { ?>
												<div class="section last">
                                                    <label>Password for New Staff</label>
                                                    <div>
														<input type="text" name="staff_password" value="<?= rand(); ?>"/>
													</div>
												</div>
												<?php } ?>
												<div class=" section last ">
													<label>
													Status
													</label>
													<div>
														<select name="staff_status" id=" ">
															<option value="active">Active</option>
															<option value="non-active">Non Actie</option>
														</select>
													</div>
												</div>
												<div class="section last ">
													<input type="hidden" name="add" value="add"/>
													<input type="hidden" name="staff_address" value="<?= $ARRAYTEMP['staff_address']; ?>" />
													<?php
														if ($update) {
															echo '<input type="hidden" name="update" value="true"/>';
															echo '<input type="hidden" name="staff_password" value="'.$ARRAYTEMP['staff_password'].'"/>';
															echo '<input type="hidden" name="' . $TABLE_ID . '" value="' . $ARRAYTEMP[$TABLE_ID]. '"/>';
														}
													?>
													<div>
														<a class="uibutton submit_form">Add</a>
													</div>
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
                                            <h3>
											  All Delivery Guys
											</h3>

                                            <script type="text/javascript">
                                                var dataSend = [{
                                                    'staff_id': 'Staff ID',
                                                    'staff_email': 'Email',
                                                    'staff_name': 'Name',
                                                    'staff_address': 'Address',
                                                    'staff_phoneno': 'Phone No',
                                                    'staff_postcode': 'Post Code',
													'staff_max_distence': 'Max Dist',
                                                    'staff_status': 'Status'
                                                }];
                                                $.ajax({
                                                    type: "POST",
                                                    url: 'include/browse-table.php',
                                                    data: {
                                                        col: dataSend,
                                                        table: '`<?= $TABLE_NAME;?>`',
                                                        status: 'staff_status',
                                                        editURL: 'staff?edit=true&id=',
                                                        delColumn: '<?= $TABLE_ID; ?>',
                                                        where: '',
                                                        actualTable: '<?= $TABLE_NAME;?>'
                                                    },
                                                    success: function (data) {
                                                        $('.ajax-response1').html(data);
                                                    }
                                                });
                                            </script>
                                            <div class="ajax-response1"></div>
                                        </form>
                                    </div>
                                </div>
                                <!--tab2-->
                                <div id="tab3" class="tab_content">
                                    <div class="load_page">
                                        <form class="tableName toolbar">
                                            <h3>
											  All Delivery Guys
											</h3>
                                            <script type="text/javascript">
                                                window.onload = function () {
                                                    var dataSend = [{
                                                        'staff_order_staff_id': 'Staff ID',
                                                        'staff_order_order_id': 'Order ID',
                                                        'staff_order_status': 'Status',
                                                        'staff_order_date_added': 'Dated'
                                                    }];
                                                    $.ajax({
                                                        type: "POST",
                                                        url: 'include/browse-table.php',
                                                        data: {
                                                            col: dataSend,
                                                            table: '`staff_order`',
                                                            status: 'staff_order_status',
                                                            editURL: '',
                                                            delColumn: 'staff_order_id',
                                                            where: '',
                                                            actualTable: 'staff_order'
                                                        },
                                                        success: function (data) {
                                                            $('.ajax-response2').html(data);
                                                        }
                                                    });
                                                }
                                            </script>
                                            <div class="ajax-response2"></div>
                                        </form>
                                    </div>
                                </div>
                                <!--tab3-->
                                <div id="tab4" class="tab_content">
                                    <div class="load_page">
                                        <div class="formEl_b">
                                            <form action="" method="post">
                                                <fieldset>
                                                    <legend>Find</legend>
                                                    <div class="section last">
                                                        <label>Staff ID</label>
                                                        <div>
                                                            <input type="text" class="validate[required] small" name="staff_serach_id"
                                                            id="staff_serach_id" value="">
                                                        </div>
                                                    </div>
                                                    <div class="section">
                                                        <label>From</label>
                                                        <div>
                                                            <input type="text" id="datepick0" class="datepicker_000" readonly="readonly"
                                                            name="search_from" />
                                                        </div>
                                                    </div>
                                                    <div class="section">
                                                        <label>To</label>
                                                        <div>
                                                            <input type="text" id="datepick1" class="datepicker_000" readonly="readonly"
                                                            name="search_to" />
                                                        </div>
                                                    </div>
                                                    <!-- <div class="section">

														<label>
														Select Type
														</label>

														<div>

														<div>

														<input type="radio" name="search_type" id="radio-1" value="w"  class="ck" checked="checked"/>

														<label for="radio-1">
														This Week
														</label>

														</div>

														<div>

														<input type="radio" name="search_type" id="radio-2" value="m"  class="ck"  />

														<label for="radio-2" >
														This Month
														</label>

														</div>

														</div>

														</div>
														-->
                                                    <div class="section last">
                                                        <div>
                                                            <input type="submit" name="SEARCH" value="Search Completed Orders" class="uibutton submit_form"
                                                            />
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--tab4-->
                            </div>
                        </div>
                        <!--/END TAB/-->
                        <div class="clear" /></div>
                </div>
                <div class="clear"></div>
            </div>
            <?php include( 'templates/footer.php'); ?>
            <!--// End inner -->
        </div>
        <!--// End content -->
    </body>

</html>