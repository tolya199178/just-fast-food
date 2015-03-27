<?php
session_start();
require_once ('include/auth.php');

include ("../include/functions.php");

include_once ('../include/order-movement.php');

$PID = "";
if (isset($_SESSION['ADMIN_PARTNER']))
{
  echo '<div style="text-align: center">Admin Partner is available</div>';
  $PID = getPId($_SESSION['ADMIN_PARTNER']);
}

if ($PID != $_GET['id'] && $PID != "")
{
  header('location:orders?id=' . $PID);
  die();
}

$INSERT = 'false';
$ERROR_UPDATE = false;
$update = false;
$successUpdateMsg = "";

$ARRAY = array(
  'staff_order_staff_id',
  'staff_order_order_id',
  'staff_order_status'
);

$TABLE_NAME = "orders";
$TABLE_ID = "order_id";

if (isset($_POST['add']))
{
  $value = "NULL, ";
  foreach($ARRAY as $values)
  {
    $value.= "'" . mysql_real_escape_string($_POST[$values]) . "',";
  }

  $value.= "NULL";
  $result = INSERT($value, 'staff_order', false, '');
  $INSERT = 'true';
  $obj->query_db('UPDATE `orders` SET `order_status` = "assign" WHERE `order_id` = "' . $_POST['staff_order_order_id'] . '"');
}

if (isset($_POST['setting_update']))
{
  if (isset($_POST['setting']) && $_POST['setting'] == 'on')
  {
    $query = $obj->query_db("SELECT `order_id`,`order_postcode` FROM `orders` WHERE `order_status` = 'pending'");
    while ($res = $obj->fetch_db_array($query))
    {
      $tempAr = json_decode($res['order_postcode'], true);
      $value = "NULL, ";
      $value.= "'" . toStaffId($tempAr, key($tempAr)) . "',";
      $value.= "'" . $res['order_id'] . "',";
      $value.= "'assign',";
      $value.= "NULL";
      $result = INSERT($value, 'staff_order', false, '');
      $INSERT = 'true';
      $obj->query_db('UPDATE `orders` SET `order_status` = "assign" WHERE `order_id` = "' . $res['order_id'] . '"');
    }

    $obj->query_db('UPDATE `setting` SET `setting_auto_order` = "on"');
  }
  else
  {
    $obj->query_db('UPDATE `setting` SET `setting_auto_order` = "off"');
  }
}

if (isset($_POST['CHANGE_ORDER_STATUS']))
{
  $newstatus = ($_POST['order_status'] == 'yes') ? 'assign' : 'cancel';
  confirmFastFoodOrder($_POST['order_id'], $newstatus);
} ?>


<!DOCTYPE html>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="description" content="Admin" />

<meta name="keywords" content="Admin,Just-FastFood" />

<title>
  Just-FastFood - Admin
</title>

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

<!--[if lte IE 8]>
<script language="javascript" type="text/javascript" src="components/flot/excanvas.min.js"></script>
<![endif]-->

<script type="text/javascript" src="js/jquery.min.js">
</script>

<script type="text/javascript" src="components/ui/jquery.ui.min.js">
</script>

<script type="text/javascript" src="components/ui/jquery.autotab.js">
</script>

<script type="text/javascript" src="components/ui/timepicker.js">
</script>

<script type="text/javascript" src="components/colorpicker/js/colorpicker.js">
</script>

<script type="text/javascript" src="components/checkboxes/iphone.check.js">
</script>

<script type="text/javascript" src="components/elfinder/js/elfinder.full.js">
</script>

<script type="text/javascript" src="components/datatables/dataTables.min.js">
</script>

<script type="text/javascript" src="components/scrolltop/scrolltopcontrol.js">
</script>

<script type="text/javascript" src="components/fancybox/jquery.fancybox.js">
</script>

<script type="text/javascript" src="components/jscrollpane/mousewheel.js">
</script>

<script type="text/javascript" src="components/jscrollpane/mwheelIntent.js">
</script>

<script type="text/javascript" src="components/jscrollpane/jscrollpane.min.js">
</script>

<script type="text/javascript" src="components/spinner/ui.spinner.js">
</script>

<script type="text/javascript" src="components/tipsy/jquery.tipsy.js">
</script>

<script type="text/javascript" src="components/editor/jquery.cleditor.js">
</script>

<script type="text/javascript" src="components/chosen/chosen.js">
</script>

<script type="text/javascript" src="components/confirm/jquery.confirm.js">
</script>

<script type="text/javascript" src="components/validationEngine/jquery.validationEngine.js" >
</script>

<script type="text/javascript" src="components/validationEngine/jquery.validationEngine-en.js" >
</script>

<script type="text/javascript" src="components/vticker/jquery.vticker-min.js">
</script>

<script type="text/javascript" src="components/sourcerer/sourcerer.js">
</script>
<script type="text/javascript" src="components/moment/moment.min.js"></script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.6/fullcalendar.min.js"></script>


<script type="text/javascript" src="components/flot/flot.js">
</script>

<script type="text/javascript" src="components/flot/flot.pie.min.js">
</script>

<script type="text/javascript" src="components/flot/flot.resize.min.js">
</script>

<script type="text/javascript" src="components/flot/graphtable.js">
</script>

<script type="text/javascript" src="components/uploadify/swfobject.js">
</script>

<script type="text/javascript" src="components/uploadify/uploadify.js">
</script>

<script type="text/javascript" src="components/checkboxes/customInput.jquery.js">
</script>

<script type="text/javascript" src="components/effect/jquery-jrumble.js">
</script>

<script type="text/javascript" src="components/filestyle/jquery.filestyle.js" >
</script>

<script type="text/javascript" src="components/placeholder/jquery.placeholder.js" >
</script>

<script type="text/javascript" src="components/Jcrop/jquery.Jcrop.js" >
</script>

<script type="text/javascript" src="components/imgTransform/jquery.transform.js" >
</script>

<script type="text/javascript" src="components/webcam/webcam.js" >
</script>

<script type="text/javascript" src="components/rating_star/rating_star.js">
</script>

<script type="text/javascript" src="components/dualListBox/dualListBox.js"  >
</script>

<script type="text/javascript" src="components/smartWizard/jquery.smartWizard.min.js">
</script>

<script type="text/javascript" src="js/jquery.cookie.js">
</script>

<script type="text/javascript" src="js/zice.custom.js">
</script>

<script type="text/javascript">
  $(document).ready(function(){
      $('.order_status_form .select').change(function(){
          $(this).parents('form').submit();
        }
      );
    }
  );

</script>

<?php
if($INSERT == 'true') {

  if($result) {
    if($successUpdateMsg != "") {
      echo '<script type="text/javascript">window.onload = function() {showSuccess("'.$successUpdateMsg.'",5000);}</script>';
    } else {
      echo '<script type="text/javascript">window.onload = function() { showSuccess("Success",5000);} </script>';
    }
  } else {
    echo '<script type="text/javascript">window.onload = function() {showError("Error in Inserting",2000);}</script>';
  }
}

if($ERROR_UPDATE != false) {
  echo '<script type="text/javascript">window.onload = function() {showError("'.$ERROR_UPDATE.'",7000);}</script>';
}		?>

</head>

<body class="dashborad">

<?php include('templates/header.php');?>

<div id="content">

<div class="inner">

  <div class="topcolumn">

    <div class="logo">
    </div>

    <ul id="shortcut">

      <li>

        <a href="dashbord" title="Back To home">

          <img src="images/icon/shortcut/home.png" alt="home"/>
          <strong>
            Home
          </strong>

        </a>
      </li>

      <li>

        <a href="setting" title="Setting">

          <img src="images/icon/shortcut/setting.png" alt="setting" />
          <strong>
            Setting
          </strong>
        </a>
      </li>

    </ul>

  </div>

</div>

<div class="clear">
</div>

<div class="onecolumn">

  <div class="header">
          <span>
            <span class="ico  gray connect">
            </span>
            Setting
          </span>

  </div>

  <!-- End header -->

  <div class="clear">
  </div>

  <div class="content">

    <form action="orders?type=complete" method="post">

      <div class="section last">

        <label for="">
          Set Auto Order Confirmation to Delivery Guy
        </label>

        <div>

          <?php
          $auto = '';
          $query1 = $obj->query_db("SELECT `setting_auto_order` FROM `setting`");
          $res1 = $obj->fetch_db_array($query1);
          if ($res1['setting_auto_order'] == 'on')
          {
            $auto = 'checked="checked"';												}											?>

          <input type="checkbox"  name="setting" class="on_off_checkbox"  value="on"
            <?php echo $auto; ?>
            />

        </div>

      </div>

      <div class="section last">

        <input type="hidden" name="setting_update" value="auto"/>

        <input type="submit" value="Update" class="uibutton"/>

      </div>

    </form>

  </div>

</div>

<div class="onecolumn">

  <div class="header">
          <span>
            <span class="ico  gray connect">
            </span>
            New Orders
          </span>
  </div>

  <div class="clear">
  </div>

  <div class="content">

    <?php
    $NEW_ORDER = false;

    $query = "SELECT * FROM `orders` WHERE  `order_status` = 'to_confirm'  ORDER BY `order_date_added` ASC";
    $toconfirm_obj = $obj->query_db($query);

    if ($obj->num_rows($toconfirm_obj) > 0) {
      $NEW_ORDER = true;
    }

    if ($NEW_ORDER)
    { ?>

      <div class="explor box-wrap" style="margin-bottom:10px">

        <h3 class="">
          New Order(s)
        </h3>

        <?php while($new_order = $obj->fetch_db_assoc($toconfirm_obj)) {?>
          <div class="myorderslist">

            <div class="b id">
              Order ID :
              <?php echo $new_order['order_id']?>
            </div>

            <div class="txt-right b">
              Restaurant :

              <?php
              $select1                = "`type_name`";
              $where1                 = "`type_id` = '" . $new_order['order_rest_id'] . "'";
              $result_restaurant_name = SELECT($select1, $where1, 'menu_type', 'array');
              echo $result_restaurant_name['type_name'];
              ?>

            </div>

            <?php
            $Array = json_decode($new_order['order_details'], true);
            echo '<div class="txt-right b">Total : &pound; ' . $Array['TOTAL'] . '</div>';

            foreach ($Array as $key => $val) {
              if ($key != 'TOTAL') {
                echo '<div class="details">';
                foreach ($val as $k => $v) {
                  if ($k == 'TOTAL') {
                    echo '<span>' . $k . ':  &pound; ' . $v . '</span>';
                  } else {
                    echo '<span>' . $k . ' :  ' . $v . '</span>';
                  }
                }
                echo '</div>';
              }
            }
            echo '<div class="txt-right b" style="background-color: #8AD78A; width: 10%"> Profit: &pound; ' . ($new_order['order_total'] - $Array['TOTAL']) . '</div>';
            ?>

            <div class="txt-right b">
              Payment Type:

              <?php echo $new_order['order_payment_type'] ;?>
            </div>
            <div class="txt-right b">
              Transaction ID:
              <?php echo $new_order['order_transaction_id'];?>
            </div>


            <div class="txt-right b">
              Phone No :
              <?php echo $new_order['order_phoneno']?>
            </div>

            <div class="txt-right b">
              Address :
              <?php echo $new_order['order_address']; ?>
            </div>

            <div class="txt-right b">
              Order Note:
                <?php echo $new_order['order_note']; ?>
            </div>

            <div class=" b">

              <form action="" method="post" class="order_status_form">
                Are you available to Deliver?
                <select class="select" name="order_status">

                  <option value="">
                    Please Select
                  </option>

                  <option value="yes">
                    Yes
                  </option>

                  <option value="no">
                    No
                  </option>

                </select>

                <input type="hidden" name="CHANGE_ORDER_STATUS" />

                <input type="hidden" name="order_id" value="<?php echo $new_order['order_id']?>"/>

              </form>

            </div>

          </div>

        <?php }

        ?>

      </div>

    <?php } else {
      echo '<div style="text-align:center">No New Orders</div>';
    }?>

  </div>

</div>

<div class="onecolumn">

<div class="header">
          <span>
            <span class="ico  gray connect">
            </span>
            Orders
          </span>

</div>

<!-- End header -->

<div class="clear">
</div>

<div class="content">

<div id="uploadTab">

<ul class="tabs">

  <li>
    <a href="#tab2" id="3">
      Browse All
      <img src="images/icon/new.gif" width="20" height="9" />
    </a>
  </li>

</ul>

<div class="tab_container">

  <?php
  $where = "";
  $pending = false;
  $complete = false;
  $specfic_rest = '';
  if(isset($_GET['id'])) {
    $specfic_rest = '  AND `order_rest_id` = "'.$_GET['id'].'"';
  }
  if(isset($_GET['type'])) {
    $where = ' WHERE `order_status` = "'.$_GET['type'].'" '.$specfic_rest.'';
    if($_GET['type'] == 'pending')
      $pending = true;
    if($_GET['type'] == 'complete')
      $complete = true;
  } else if(isset($_GET['id'])){
    $where = ' WHERE `order_rest_id` = "'.$_GET['id'].'"';
  }
  ?>

  <!--tab1-->

  <div id="tab2" class="tab_content">

    <?php if($pending) {?>

      <ul class="uibutton-group">

        <li>
                    <span class="tip">
                      <a class="uibutton icon add on_load"  name="#tab1"  title="Assign Order To Delivery Guy">
                        Assign An Order
                      </a>
                    </span>
        </li>

      </ul>

    <?php }?>

    <div class="load_page">

      <form class="tableName toolbar">

        <h3>
          All
          <?php if(isset($_GET['type']))  echo $_GET['type']; else echo '';?>
          Orders
        </h3>

        <?php
        if($complete) {
          $q = $obj ->query_db('SELECT SUM(`order_total`) AS "SUM" FROM `orders` WHERE `order_status` = "complete" '.$specfic_rest.'');															$SUM = $obj->
        fetch_db_array($q);
          echo '<h3 style="margin-left:300px">Total  : &pound; ' .round($SUM['SUM'],3) .'</h3>';
        }
        ?>

        <script type="text/javascript">
          var dataSend = [

            {             'order_id':'Order ID' ,
                          'order_user_id':'User ID',
                          'order_total': 'Total Amount' ,
                          'order_payment_type': 'Payment Type',
                          'order_transaction_id':'Transaction ID',
                          'order_details':'Order Details',
                          'profit' : 'Net',
                          'order_postcode':'Post Code' ,
                          'order_address': 'Address' ,
                          'order_status':'Status',
                          'order_date_added':'Dated'
            }
          ];
          $.ajax({
              type: "POST",
              url: 'include/browse-table.php',
              data: {
                col : dataSend,
                table : '`<?php echo $TABLE_NAME ?>`',
                status : 'order_status' ,
                editURL : '',
                delColumn : '<?php echo $TABLE_ID ?>' ,
                where : '<?php echo $where;?>  ORDER BY `order_date_added` DESC' ,
                actualTable : '<?php echo $TABLE_NAME ?>'
              }
              ,
              success: function(data) {
                $('.ajax-response1').html(data);
              }
            }
          );

        </script>

        <div class="ajax-response1">

        </div>

      </form>

    </div>

    <?php if($pending) { ?>

      <div class="show_add" style=" display:none">

        <ul class="uibutton-group" >

          <li>
                      <span class="tip">
                        <a class="uibutton icon prev on_prev "  id="on_prev_pro" name="#tab2"  title="Go Back" >
                          Go Back
                        </a>
                      </span>
          </li>

          <li>
                      <span class="tip">
                        <a class="uibutton special"   onClick="ResetForm()" title="Reset  Form"   >
                          Clear Form
                        </a>
                      </span>
          </li>

        </ul>

        <h3>
          Assign An Order
        </h3>

        <div class="formEl_b">

          <form id="validation" method="post" action="orders?type=pending" enctype="multipart/form-data">

            <fieldset>

              <legend>
                Options
              </legend>

              <div class="section last">

                <label>
                  Choose an Order
                </label>

                <div>

                  <select name="staff_order_order_id" data-placeholder="Choose an Order..." class="chzn-select">

                    <?php
                    $query = $obj ->query_db("SELECT * FROM `orders` WHERE `order_status` = 'pending' ORDER BY `order_date_added` DESC");
                    while($res = $obj->fetch_db_array($query)) {
                      ?>

                      <option value="<?php echo $res['order_id'];?>">

                        Order ID:
                        <?php echo $res['order_id']. '  ______ User ID : ' .$res['order_user_id'] .'  ______  Order Total :  ' .$res['order_total'] .'&pound;  [' .$res['order_date_added'].']'; ?>
                      </option>

                    <?php
                    }
                    ?>

                  </select>

                </div>

              </div>

              <div class="section last">

                <label>
                  Choose an Delivery Guy
                </label>

                <div>

                  <select name="staff_order_staff_id" data-placeholder="Choose a Delivery Guy..." class="chzn-select">

                    <?php
                    $query = $obj ->query_db("SELECT * FROM `staff` WHERE `staff_status` = 'active'");
                    while($res = $obj->
                    fetch_db_array($query)) {
                      ?>

                      <option value="<?php echo $res['staff_id'];?>">
                        <?php echo  'ID :' . $res['staff_id'] . ' '. $res['staff_name'];?>
                      </option>

                    <?php
                    }
                    ?>

                  </select>

                </div>

              </div>

              <div class="section last">

                <input type="hidden" name="add" value="add"/>

                <input type="hidden" name="staff_order_status" value="assign"/>

                <div>

                  <a class="uibutton submit_form">
                    GO
                  </a>
                </div>

              </div>

            </fieldset>

          </form>

        </div>

      </div>

    <?php } ?>

  </div>

  <!--tab2-->

</div>

</div>

<!--/END TAB/-->

<div class="clear" />
</div>

</div>

<div class="clear">
</div>

</div>

<?php include('templates/footer.php');?>

<!--// End inner -->

</div>

<!--// End content -->
</body>
</html>