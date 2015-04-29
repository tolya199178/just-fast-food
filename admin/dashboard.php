<?php
session_start();
require_once('include/auth.php');
include('../include/functions.php');

ini_set ('display_errors', '1');



// Total User counts
$query = $obj->query_db("SELECT COUNT(*) FROM `user`");
$members = $obj->fetch_db_array($query);

// Total User Monthly counts
$monthly = $obj->query_db("SELECT COUNT(*) FROM `user` WHERE MONTH(user_date_added) = MONTH(CURDATE()) AND YEAR(user_date_added) = YEAR(CURDATE())");
$monthlyMm = $obj->fetch_db_array($monthly);

// Corporate User
$corpUser = $obj->query_db("SELECT COUNT(*) FROM `user` WHERE `co_company_name` != ''");
$corp = $obj->fetch_db_array($corpUser);


// Pending Orders
$pending = $obj->query_db("SELECT COUNT(*) FROM `orders` WHERE `order_status` = 'to_confirm'");
$pendingOrder = $obj->fetch_db_array($pending);

// Monthly Revenue
$revenue = $obj->query_db("SELECT ROUND(SUM(order_total)) AS `value_sum` FROM `orders` WHERE MONTH(order_date_added) = MONTH(CURDATE())");
$monthlyRev = $obj->fetch_db_array($revenue);
$rev = $monthlyRev['value_sum'];

// Recent updates & activities  - Today's Order

$updates = $obj->query_db("SELECT COUNT(*) FROM `orders` WHERE `order_date_added` BETWEEN CONCAT(CURDATE(), ' ', '00:00:00') AND CONCAT(CURDATE(), ' ', '23:59:59')");
$orderUps = $obj->fetch_db_array($updates);



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
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
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

</head>
<body class="dashborad">
<?php include('templates/header.php');?>


<div id="content">
    <div class="inner">
        <div class="topcolumn">
            <div class="logo"></div>
            <ul id="shortcut">
                <li> <a href="dashbord" title="Back To home"> <img src="images/icon/shortcut/home.png" alt="home"/><strong>Home</strong> </a></li>
                <li> <a href="#" title="Setting"> <img src="images/icon/shortcut/setting.png" alt="setting" /><strong>Setting</strong></a></li>
            </ul>
        </div>

    </div>
    <div class="clear"></div>
    <div class="onecolumn">
        <div class="header"><span><span class="ico gray stats_lines"></span>JFF Statistics</span>
        </div>
        <div class="clear"></div>
        <div class="content">
            <br class="clear" />
            <div class="grid1 rightzero">
                <div class="shoutcutBox"> <span class="fa fa-cart-arrow-down fa-2x" style="color: green"></span>  <strong><?php echo $pendingOrder[0];?></strong>  <em>Pending orders</em>
                </div>
                <div class="breaks"><span></span></div>
                <!-- // breaks -->
                <div class="shoutcutBox"> <span class="fa fa-gbp fa-2x" style="color: green"></span>  <strong><?php echo $monthlyRev[0];?></strong>  <em> Monthly Revenue</em>
                </div>

                <div class="shoutcutBox"> <span class="fa fa-users fa-2x" style="color: green"></span>  <strong><?php echo $members[0]; ?></strong>  <em>Total Member</em>

                </div>
                <div class="shoutcutBox"> <span class="fa fa-user fa-2x" style="color: green"></span>  <strong><?php echo $monthlyMm[0];?></strong>  <em>Registered User This Month</em>
                </div>
                <div class="breaks"><span></span>
                </div>
                <div class="shoutcutBox"> <span class="fa fa-university fa-2x" style="color: green"></span>  <strong><?php echo $corp[0]; ?></strong>  <em>Corporate Users</em>
                </div>
                <div class="shoutcutBox"> <span class="fa fa-motorcycle fa-2x" style="color: green"></span>  <strong><?php echo $orderUps[0];?></strong>  <em>Today's Order</em>
                </div>
            </div>
            <div class="grid3">
                <div style="width:100%;height:415px; margin-left:25px">
                    <div class="onecolumn">
                        <div class="header"><span><span class="ico gray notepad"></span> Latest Updates</span></div>
                        <br class="clear" />
                        <div class="content tableName">
                            <table class="display data_table">
                                <thead>
                                <tr>
                                    <th width="224">
                                        <div style="text-align:left; margin-left:10px">Updates</div>
                                    </th>

                                    <th width="195">
                                        <div style="text-align:right; ">Date</div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="msg">
                                            <div class="msg_icon new"></div>
                                            <div class="msg_topic" style="color: orangered"> New User:

                                                <?php
                                            // Today's Users
                                            $userUps = $obj->query_db("SELECT `user_screen_name`,`user_email`,`user_phoneno`,`user_city`,`user_post_code`,`user_verified` FROM `user` WHERE `user_date_added` BETWEEN CONCAT(CURDATE(), ' ', '00:00:00') AND CONCAT(CURDATE(), ' ', '23:59:59')");
                                            while($result = $obj->fetch_db_array($userUps)) {
                                                foreach ($result as $key => $val) {
                                                    echo $val;


                                                }
                                                    ?>
                                                    </span>
                                                <?php
                                            }
                                            ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="msg_date">a few seconds ago <span><?php echo date('Y M D');?> </span>
                                        </div>
                                    </td>
                                </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <!-- // End onecolumn -->
    <!--// two column window -->
    <div class="clear"></div>
    <?php include('templates/footer.php');?>
</div>
<!--// End inner -->
</div>
<!--// End content -->
</body>
</html>