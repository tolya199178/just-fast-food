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
  header('location:meal-items?edit=true&id='.$PID);
  die();
}

$INSERT = 'false';
$ERROR_UPDATE = false;
$update = false;
$successUpdateMsg = "";
$ARRAY = array('item_id' ,'meal_name', 'meal_price','meal_type', 'meal_status');
foreach($ARRAY as $v) {
  $ARRAYTEMP[$v] = '';
}

if(isset($_POST['add'])) {

  if(isset($_POST['update'])) {
    $val = "";
    foreach($ARRAY as $values) {
      $val .= "`".$values."` = '".$_POST[$values]."',";
    }
    $val = substr($val ,0 ,-1);
    $query = "UPDATE  `items_meals` SET ".$val."  WHERE `meal_id` = '".$_POST['meal_id']."'";
    $obj -> query_db($query) or die(mysql_error());
    $INSERT = 'true';
    $result = 'true';
    $successUpdateMsg = "Successfully Updated";
  } else {
    if($upload['error'] == 0){
      $value = "NULL, ";
      foreach($ARRAY as $values) {
        $value .= "'".mysql_real_escape_string($_POST[$values])."',";
      }
      $value .= "NULL";
      $result = INSERT($value ,'items_meals' ,false ,'');
      $INSERT = 'true';
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
    $subject = "Add/Update Meal Item By Partner";
    $headers = "From:Just-FastFood <admin@just-fastfood.com>\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    mail($to, $subject, $message, $headers);
  }

}

if(isset($_GET['edit']) && isset($_GET['id'])) {
  $select = "*";
  $where = "`meal_id` = '".$_GET['id']."'";
  $result = SELECT($select ,$where, 'items_meals', 'array');
  if($result == false) {
    $ERROR_UPDATE = "ERROR!! Data Not Exist";
  } else {
    foreach($ARRAY as $v) {
      $ARRAYTEMP[$v] = $result[$v];
    }
    $ARRAYTEMP['meal_id'] = $_GET['id'];
  }
  $update = true;
}

if($PARTNER != "" && $update == false && $PID != $_GET['id']){
  header('location:meal-items?edit=true&id='.$PID);
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
  <meta name="keywords" content="Admin,Just-FastFood, Meal Items add/update/delete" />

  <title>Meal Items - Just-FastFood - Admin</title>
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
        echo '<script type="text/javascript">window.onload = function() {showSuccess("Successfully Inserted Data",5000);}</script>';
      }
    } else {
      echo '<script type="text/javascript">window.onload = function() {showError("Error in Inserting Data",2000);}</script>';
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
    <div class="header"><span><span class="ico  gray connect"></span>Meal Items</span>
    </div>
    <!-- End header -->
    <div class="clear"></div>
    <div class="content">
      <div id="uploadTab">
        <ul class="tabs">
          <li><a href="#tab1" id="2">  Add Meal Item</a>

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
                  <form id="validation" method="post" action="meal-items"  enctype="multipart/form-data">
                    <fieldset>
                      <legend>Meal Item</legend>
                      <div class="section last">
                        <label>Name<small>(i:e Large/Regular)</small></label>
                        <div>
                          <input type="text" class="validate[required] large" name="meal_name" id="meal_name" value="<?php echo $ARRAYTEMP['meal_name']?>">
                        </div>
                      </div>
                      <div class="section last">
                        <label>Price</label>
                        <div>
                          <input type="text" class="validate[required] sDec" name="meal_price" id="meal_price" value="<?php echo $ARRAYTEMP['meal_price']?>">
                        </div>
                      </div>
                      <div class="section last">
                        <label>Meal Item of?</label>
                        <div>
                          <select name="item_id" id="item_id" data-placeholder="Choose a Parent item..." class="chzn-select">
                            <?php
                            $query = "SELECT * FROM `items` WHERE `item_meal` = '1'";
                            $valueOBJ = $obj->query_db($query);
                            while($res = $obj->fetch_db_array($valueOBJ)) {
                              ($ARRAYTEMP['item_id'] == $res['item_id']) ? $sel = 'selected' : $sel = '';
                              ?>
                              <option value="<?php echo $res['item_id']?>" <?php echo $sel; ?>><?= $res['item_id'].'- '.$res['item_name'].' ('.$res['item_details'].')' ?></option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="section last">
                        <label>Mela Type</label>
                        <div>
                          <select name="meal_type" id="">
                            <option value="size">Size</option>
                            <option value="drink">Drink</option>
                            <option value="sides">Sides</option>
                          </select>
                        </div>
                      </div>
                      <div class="section last">
                        <label>Status</label>
                        <div>
                          <select name="meal_status" id="">
                            <option value="active">Active</option>
                            <option value="non-active">Non Actie</option>
                          </select>
                        </div>
                      </div>

                    </fieldset>
                    <div class="section last">
                      <input type="hidden" name="add" value="add"/>
                      <?php
                      if($update) {
                        echo '<input type="hidden" name="update" value="true"/>';
                        echo '<input type="hidden" name="meal_id" value="'.$ARRAYTEMP['meal_id'].'"/>';
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
          <div id="tab2" class="tab_content">
            <div class="load_page">
              <form class="tableName toolbar">
                <h3>All Meal Items</h3>
                <script type="text/javascript">
                  var dataSend = [{'meal_id':'ID','item_id':'Subitem Parent Id', 'meal_name':'Meal Item Name','meal_type':'Meal Type', 'meal_price':'Price'}];
                  $.ajax({
                    type: "POST",
                    url: 'include/browse-table.php',
                    data: { col : dataSend, table : 'items_meals', status : 'meal_status' , editURL : 'meal-items?edit=true&id=', delColumn : 'meal_id', where : '' , actualTable : 'items_meals'},
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