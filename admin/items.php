<?php
session_start();
require_once('include/auth.php');
include("../include/functions.php");
$INSERT = 'false';
$errorMSG = "";
$ERROR_UPDATE = false;
$update = false;
$successUpdateMsg = "";
$ARRAY = array('type_id', 'category_id', 'item_meal', 'item_name', 'item_price' , 'item_actual_price', 'item_in_stock', 'item_details', 'item_subitem_price' ,'item_status');

foreach($ARRAY as $v) {
  $ARRAYTEMP[$v] = '';
}

$WHERE_CLAUSE = "";
$WHERE_CLAUSE1 = "";
$PARTNER ="";
if(isset($_SESSION['ADMIN_PARTNER'])){
  $PARTNER = "true";

  $PID = getPId($_SESSION['ADMIN_PARTNER']);

  $WHERE_CLAUSE = " WHERE `type_id` = '".$PID."'";
  $WHERE_CLAUSE1 = ' AND  categories.type_id= "'.$PID.'"';

}

if(isset($_POST['add'])) {

  if(count($_FILES)  && $_FILES['item_picture']['name'] != "") {
    $upload = singleFileUpload($_FILES, 'item_picture');
  } else {
    $upload['error'] = '0';
  }

  if(isset($_POST['update'])) {
    $val = "";
    foreach($ARRAY as $values) {
      if($values == "item_picture") {
        $val .= "`".$values."` = '".$upload['img_name']."',";
      } else {
        $val .= "`".$values."` = '".mysql_real_escape_string($_POST[$values])."',";
      }
    }
    $val = substr($val ,0 ,-1);
    $query = "UPDATE  `items` SET ".$val."  WHERE `item_id` = '".$_POST['item_id']."'";
    //echo $query;
    $obj -> query_db($query) or die(mysql_error());
    $INSERT = 'true';
    $result = 'true';
    $successUpdateMsg = "Successfully Updated";
  } else {
    if($upload['error'] == 0){
      $value = "NULL, ";
      foreach($ARRAY as $values) {
        if($values == "item_picture") {
          $value .= "'".mysql_real_escape_string($upload['img_name'])."',";
        } else {
          $value .= "'".mysql_real_escape_string($_POST[$values])."',";
        }
      }
      $value .= " NULL";
      $result = INSERT($value ,'items' ,false ,'');
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
    $message .= "Item add or updated by partner Email : ".$_SESSION['ADMIN_PARTNER'];

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
  $where = "`item_id` = '".$_GET['id']."'";
  $result = SELECT($select ,$where, 'items', 'array');
  if($result == false) {
    $ERROR_UPDATE = "ERROR!! Data Not Exist";
  } else {
    foreach($ARRAY as $v) {
      $ARRAYTEMP[$v] = $result[$v];
    }
    $ARRAYTEMP['item_id'] = $_GET['id'];
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
  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.6/fullcalendar.print.css" />
  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.6/fullcalendar.min.css" />
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
  <script type="text/javascript" src="components/moment/moment.min.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.6/fullcalendar.min.js"></script>
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
    <div class="header"><span><span class="ico  gray connect"></span>Items</span>
    </div>
    <!-- End header -->
    <div class="clear"></div>
    <div class="content">
      <div id="uploadTab">
        <ul class="tabs">
          <li><a href="#tab1" id="2">  Add New Item  </a>

          </li>
          <li><a href="#tab2" id="3"> Browse Items<img src="images/icon/new.gif" width="20" height="9" /></a>

          </li>
        </ul>
        <div class="tab_container">
          <div id="tab1" class="tab_content">
            <div class="load_page">
              <div class="formEl_b">
                <form id="validation" method="post" action="items" enctype="multipart/form-data">
                  <fieldset>
                    <legend>Items</legend>
                    <div class="section last">
                      <label>item Name</label>
                      <div>
                        <input type="text" class="validate[required] large" name="item_name" id="item_name"  value="<?php echo $ARRAYTEMP['item_name']; ?>">
                      </div>
                    </div>
                    <div class="section last">
                      <label>Is Meal?</label>
                    <div>
                      <select name="item_meal" id="item_meal">
                        <option value="0">No</option>
                        <option value="1" <?php echo ($ARRAYTEMP['item_meal'] == 1) ? 'selected' : '' ?>>Yes</option>
                      </select>
                    </div>
                    </div>
                    <div class="section last">
                      <label>item Actual Price</label>
                      <div>
                        <input type="text" class="validate[required] sDec" name="item_actual_price" id="item_actual_price" value="<?php echo $ARRAYTEMP['item_actual_price'];?>">

                      </div>
                    </div>
                    <div class="section last">
                      <label>JFF Price</label>
                      <div>
                        <input type="text" class="validate[required] sDec" name="item_price" id="item_price" value="<?php echo $ARRAYTEMP['item_price']; ?>">
                      </div>
                    </div>
                    <div class="section last">
                      <label>item In Stock</label>
                      <div>
                        <input type="text" class="validate[required,custom[onlyNumberSp]] xxsmall" name="item_in_stock" id="item_in_stock" value="<?php echo $ARRAYTEMP['item_in_stock']; ?>">
                      </div>
                    </div>
                    <div class="section last">
                      <label>item Details</label>
                      <div>
                        <textarea name="item_details" id="editor" class="editor" cols="" rows=""><?php echo $ARRAYTEMP['item_details']; ?></textarea>
                      </div>
                    </div>

                    <div class="section last">
                      <label>Subitem Price</label>
                      <div>
                        <input type="text" class="validate[required] sDec" name="item_subitem_price" id="item_subitem_price" value="<?php echo $ARRAYTEMP['item_subitem_price']; ?>">
                      </div>
                    </div>
                    <div class="section last">
                      <label>Menu Type</label>
                      <div>

                        <select name="type_id" id="type_id">
                          <?php
                          $query = "SELECT * FROM `menu_type` ".$WHERE_CLAUSE."";
                          $valueOBJ = $obj->query_db($query);
                          while($res = $obj->fetch_db_array($valueOBJ)) {
                            ($ARRAYTEMP['type_id'] == $res['type_id']) ? $sel = 'selected' : $sel = '';
                            ?>
                            <option value="<?php echo $res['type_id']?>" <?php echo $sel; ?>><?php echo $res['type_name']?></option>
                          <?php
                          }
                          ?>
                        </select>

                      </div>
                    </div>
                    <div class="section last">
                      <label>Category Name</label>
                      
                      <div>
                    
                        <select name="category_id" id="category_id">
                          <?php
                          $query = "SELECT * FROM `categories` ".$WHERE_CLAUSE."";
                          $valueOBJ = $obj->query_db($query);
                          while($res = $obj->fetch_db_array($valueOBJ)) {
                            ($ARRAYTEMP['category_id'] == $res['category_id']) ? $sel = 'selected' : $sel = '';

                            ?>

                            <option value="<?php echo $res['category_id']?>" <?php echo $sel; ?>><?php echo $res['category_name']?></option>
                          <?php
                          }
                          ?>
                        </select>

                      </div>
                    </div>
                    <div class="section last">
                      <label>Status</label>
                      <div>
                        <select name="item_status" id="">
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
                        echo '<input type="hidden" name="item_id" value="'.$ARRAYTEMP['item_id'].'"/>';
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
                <h3>All Categories</h3>
                <script type="text/javascript">
                  var dataSend = [{'item_id': 'Item ID','type_name':'Type Name', 'category_name': 'Category Name' ,'item_name':'Item Name', 'item_price':'Price' , 'item_actual_price': 'Actual Price', 'item_in_stock' : 'Stock' , 'item_status':'Status'}];
                  $.ajax({
                    type: "POST",
                    url: 'include/browse-table.php',
                    data: { col : dataSend, table : '`categories`,`menu_type`,`items`', status : 'item_status' , editURL : 'items?edit=true&id=', delColumn : 'item_id' , where : 'WHERE items.type_id=menu_type.type_id AND items.category_id=categories.category_id  <?php echo $WHERE_CLAUSE1?>', actualTable : 'items'},
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
</body>`
</html>

<script type="text/javascript">
  $(document).ready(function(){

    $('#item_actual_price').on('change', function () {
      var initial = $('#item_actual_price').val();
      var val = parseFloat($(this).val() * 0.20);
      $('#item_price').val((val + parseFloat(initial)).toFixed(2));
    })
  });
</script>