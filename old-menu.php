<?php
session_start();
$cat = "";
$error = false;
include_once('include/functions.php');

if(!isset($_GET['category']) || !isset($_GET['catID']) || !isset($_GET['Postcode']) || !isset($_SESSION['DISTENCE'])) {
    header('location:index.php?er=first');
    die();
} else {

    $cat = str_replace('-',' ', $_GET['category']);
    $select = "*";
    $from = '`categories`,`menu_type`';
    //$where = "categories.type_id = ".$_GET['catID']." AND menu_type.type_id = ".$_GET['catID']." AND menu_type.type_name = '".$cat."' ORDER BY categories.category_name ASC";
    $where = "categories.type_id = ".$_GET['catID']." AND menu_type.type_id = ".$_GET['catID']."  ORDER BY categories.category_order ASC";
    $query = 'SELECT '.$select.' FROM '.$from.' WHERE '.$where.'';
    //echo $query;
    $catvalue = $obj->query_db($query);

    if($obj-> num_rows($catvalue) < 1) {
        $error = true;
        //print_r($_GET);
        header('location:index.php?er=2nd');
        die();
    } else {
        while($r = $obj->fetch_db_assoc($catvalue)) {
            $CATTEMP['category_name'] = $r['category_name'];
            $CATTEMP['category_id'] = $r['category_id'];
            $CATTEMP['category_img'] = $r['type_picture'];
            $CATTEMP['type_steps'] = $r['type_steps'];
            $CATTEMP['category_detail'] = $r['category_detail'];
            $CATTEMP['type_category'] = $r['type_category'];
            $_SESSION['type_min_order'] = $r['type_min_order'];
            $oph = json_decode($r['type_opening_hours'] ,true);
            $type_special_offer = json_decode($r['type_special_offer'] ,true);
            $CATARRAY[] = $CATTEMP;
        }
    }
}

if(!isset($_SESSION['delivery_type']['type'])) {
    $_SESSION['delivery_type'] = array();
    $_SESSION['delivery_type']['type'] = 'delivery';
    $_SESSION['delivery_type']['time']  = 'ASAP';
}

if(count($_POST)) {
    if(isset($_POST['delivery_type'])) {
        if($_SESSION['delivery_type']['type'] != $_POST['delivery_type']) {
            $_SESSION['delivery_type']['time'] = 'ASAP';
        } else {
            $_SESSION['delivery_type']['time'] = $_POST['delivery_best_time'];
        }
        $_SESSION['delivery_type']['type'] = $_POST['delivery_type'];

    }
}
$_SESSION['DELIVERY_CHARGES'] = $_SESSION['DISTENCE'][$_GET['catID']];
$_SESSION['DELIVERY_REST_ID'] = $_GET['catID'];

if(isset($_SESSION['DELIVERY_REST_ID_PREV']) && ($_SESSION['DELIVERY_REST_ID_PREV'] != $_SESSION['DELIVERY_REST_ID'])) {
    unset($_SESSION['CART']);
    unset($_SESSION['SPECIAL_OFFER']);
    $_SESSION['delivery_type']['type'] = 'delivery';
    $_SESSION['delivery_type']['time']  = 'ASAP';

}
$_SESSION['DELIVERY_CHARGES'] = getTotalDeliveryCharges($CATTEMP['type_steps'] ,$_SESSION['DELIVERY_REST_ID'] ,$_SESSION['DELIVERY_CHARGES']);
$_SESSION['DELIVERY_REST_ID_PREV'] = $_SESSION['DELIVERY_REST_ID'];
$_SESSION['CURRENT_MENU'] = str_replace(' ', '-', 'menu-'.$cat.'-'.$_SESSION['DELIVERY_REST_ID'].'-'.$_GET['Postcode']);
$_SESSION['RESTAURANT_TYPE_CATEGORY'] = $CATTEMP['type_category'];
unset($_SESSION['ALREADY_ADDED_PROCESS_FEE']);

if($_SESSION['delivery_type']['type'] != 'delivery') {
    $_SESSION['DELIVERY_CHARGES'] = 0;
}

?>

<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Just-FastFood - Burger King - KFC- - Order Food Online - Fast Food Online">
    <meta name="keywords" content="Account Creation!, <?= getDataFromTable('setting','keywords'); ?>">
    <meta name="author" content="Just-FastFood">

    <title>Menu <?php echo $cat;?> - Just-FastFood</title>

    <!--CSS INCLUDES-->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,900' rel='stylesheet' type='text/css'>

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

    <link href="css/archivist.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/responsivemobilemenu.css" type="text/css"/>
    <link href="css/media.css" rel="stylesheet">
    <link href="css/flexslider.css" rel="stylesheet">
    <link rel="stylesheet" href="css/square/blue.css" />
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.theme.css" rel="stylesheet">
    <style>
    .categories ul li:hover {
            -moz-box-shadow: 0 0 5px rgba(0,0,0,0.5);
            -webkit-box-shadow: 0 0 5px rgba(0,0,0,0.5);
            box-shadow: 0 0 5px rgba(0,0,0,0.5);
    }
    .categories ul li:nth-child(2+1) {
            background-color: #F0EEDF;
    }
    </style>
    <script type="text/javascript">
        <?php
            if(!$error) {
                $c = "";
                foreach($CATARRAY as $result) {
                    $c .=  '"'.str_replace(' ', '_',$result['category_name']).$result['category_id'].'" ,';
                }
                $c = substr($c, 0, -1);
                echo 'var category = ['.$c.'];';
            }
        ?>
    </script>

</head>


<body>
<div class="wrapper">
    <?php include('templates/header2.php'); ?>

    <div class="page_header">
    <div class="inner_title"><h2 class="text-center white">Select your <span>menu</span> below</h2></div>


    <div class="custom_button yellow_btn small_but text-center ">
        <ul><li><a href="Postcode-<?php echo str_replace(' ','-',$_SESSION['CURRENT_POSTCODE']); ?>">Change Restaurant</a></li></ul>
    </div>
    </div>
    <div class="breadcrum">
        <ul>
            <li><a href="index.php">Begin Search</a></li>
            <li><a href="Postcode-<?php echo str_replace(' ','-',$_SESSION['CURRENT_POSTCODE']); ?>">Postcode-<?php echo $_SESSION['CURRENT_POSTCODE']; ?></a></li>
            <li class="u">Menu <?php echo $cat;?></li>
        </ul>
    </div>

    <?php include('include/notification.php');?>

  <div class="section_inner">
  
   <div class="container">

        <div class="sec_1 shadow col-lg-12 col-md-12 col-sm-12 col-xs-12" style ="border-radius : 5px; margin-bottom : 25px">
            <?php
            $query_location = $obj -> query_db("SELECT * FROM `location` WHERE `location_menu_id` = '".$_SESSION['DELIVERY_REST_ID']."'");
            $locationObj = $obj -> fetch_db_array($query_location);
            ?>
        <div class="todayTime text-right">
            <?php echo date("l, j F Y, h:i A");?>
        </div>

            <ul>
                <li class="res_image">
                    <img src="items-pictures/<?php echo $CATTEMP['category_img'];?>" alt=""/>
                </li>
                <li class="res_title"><?php echo str_replace(' ', '-', $res['type_name']);?></li>

            <div class="fl-left details">
                <h1 style="font-size: 20px; margin-top: 0"><?php echo $cat;?> <span><?php echo $locationObj['location_city'];?></span></h1>
                <strong>Opening hours</strong><br>
                <ul>
                    <li class="i"><label for=""><?php echo date('l');?>:</label><?php echo  $oph[date('l')]['From'] . ' - ' .$oph[date('l')]['To']?></li>
                    <li style="color:#ffebe8"><label for=""><?php echo date('l', time()+86400)?>:</label><?php echo  $oph[date('l', time()+86400)]['From'] . ' - ' .$oph[date('l')]['To']?></li>
                </ul>
                <a href="oph.php?id=<?php echo $_SESSION['DELIVERY_REST_ID']?>/?iframe=true&amp;width=300&amp;height=300" rel="prettyPhoto" class="showMore u"> View all opening times</a>
            </div>

            <div class="fl-right delivery-type">
                <form action="" method="post">
                    <h2 style="font-size: 15px; margin-top: -18px">Delivery Options</h2>
                    <select name="delivery_type" id="delivery_type" class="form-control" style="margin-bottom: 15px">
                        <option value="delivery">Delivery</option>
                        <?php
                        if($_SESSION['RESTAURANT_TYPE_CATEGORY'] != "fastfood") {
                            ?>
                            <option value="collection" <?php echo  ($_SESSION['delivery_type']['type'] == 'collection') ? 'selected' : '' ?>>Collection</option>
                        <?php
                        }
                        ?>
                    </select>

                    <select name="delivery_best_time" id="delivery_best_time" class="form-control">
                        <option value="<?php echo $_SESSION['delivery_type']['time']?>"><?php echo $_SESSION['delivery_type']['time']?></option>
                        <option value="ASAP">ASAP</option>
                        <?php
                        for($i = 2 ; $i < 24 ; $i ++) {
                            if(strtotime(date('H:i', strtotime(date('H:i').'+ '.($i*30).' minutes'))) <= strtotime($oph[date('l')]['To'])) {
                                ?>
                                <option value="<?php echo date('H:i', strtotime(date('H:i').'+ '.($i*30).' minutes'));?>"><?php echo date('H:i', strtotime(date('H:i').'+ '.($i*30).' minutes'));?></option>
                            <?php }
                        }
                        ?>
                    </select>

                    <h4 style="font-size: 12px; font-weight: 600">Delivery Charges: <span>&pound; <?php echo number_format($_SESSION['DELIVERY_CHARGES'],2);?></span></h4>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $('#delivery_type , #delivery_best_time').change(function(){
                                $(this).parents('form').submit();
                            });

                            $('.meal-items select').on('change', function() {
                                var newprice_ = $(this).val().split('_');
                                var newprice = newprice_[1];
                                var This = $(this);

                                switch($(this).attr('name')){
                                    case '_Size':
                                        This.parents('.meal-items').find('input[name=size]').val(newprice);
                                        break;
                                    case '_Drinks':
                                        This.parents('.meal-items').find('input[name=drink]').val(newprice);
                                        break;
                                    case '_Sides':
                                        This.parents('.meal-items').find('input[name=sides]').val(newprice);
                                        break;
                                }

                                var Now_Price = 0;
                                $(this).parents('.meal-items').find('input[type=hidden]').each(function(){
                                    Now_Price = Now_Price + parseFloat($(this).val());
                                });

                                This.parents('.whole-wrap').find('span.price').text('£ '+Now_Price);
                            });

                        });
                    </script>
                    <?php
                    if($_SESSION['type_min_order'] > 0) {
                        ?>
                        <span>Minimum Order Amount: &pound;<?php echo $_SESSION['type_min_order'];?></span></h4>
                    <?php } ?>
                </form>

            </div>
            <div class="clr"></div>
            <?php
            if($type_special_offer != "") {
                echo '<div class="special-offer"><strong>';
                echo $type_special_offer['off']. ' % off today on orders over &pound; '.$type_special_offer['pound'];
                echo '</strong></div>';
                $_SESSION['SPECIAL_OFFER'] = $type_special_offer;
            }
            ?>



        </div>

        <div class="col-md-12 explor">
            <?php
                if(!$error) {
                   ?>
                    <div class="find">
                        <div class="fl-left">
                            <span style="font-weight: bolder">Categories:</span>
                            <span class="active"><input type="checkbox" name="all" checked="true"/>All</span> |
                        </div>
                        <div class="fl-left categoryListM"  style="width: 750px; margin-left: 3px; font-weight: bolder">
                            <?php
                            foreach($CATARRAY as $result) {
                                echo '<span><input type="checkbox" name="'.str_replace(' ', '_',$result['category_name']).$result['category_id'].'"  />'.$result['category_name'].'</span>';
                            }
                            ?>
                        </div>
                        <div class="clr"></div>
                    </div>

                    <div class="fl-left all-menu-items" style="width:69%">
                        <?php
                          foreach($CATARRAY as $res) {
                              $query = "SELECT * FROM `items` WHERE `category_id` = '".$res['category_id']."'";
                              $itemsvalue = $obj->query_db($query);
                              ?>
							  
                            <div class="categories" id="<?php echo str_replace(' ', '_',$res['category_name']).$res['category_id']; ?>">
                                <h2 class="subheading"><?php echo $res['category_name']; ?></h2>
                                    <?php
                                     if($res['category_detail'] != "") {
                                         ?>
                                         <div style="padding: 0px 10px 10px 10px"><?php echo $res['category_detail'];?></div>
                                        <?php
                                         }
                                    ?>
                                <ul>
								<hr class="hr" />
                                    <?php
                                    while($resultItems = $obj->fetch_db_assoc($itemsvalue)) {
                                        ?>
                                        <li>
                                            <div class="whole-wrap">
                                                <?php
                                                $query_subitem = "SELECT * FROM `subitems` WHERE `subitem_pid` = '".$resultItems['item_id']."'";
                                                $valueOBJ_subitem = $obj->query_db($query_subitem);
                                                if($obj -> num_rows($valueOBJ_subitem) > 0) {
                                                    ?>
                                                    <div class="fl-left hasSubMenu" style="width:100%">
                                                        <div class="fl-left" >
                                                            <div class="text fl-left b"><?php echo $resultItems['item_name']?>
                                                                <!--	<a href="javascript:;" class="btn showsubmenuItems" id="btn showsubmenuItems" title="Click here to view Extra menus" style="padding:1px 5px; margin:0px 0px 0px 10px;"> Please click here to choose your drinks </a>-->
                                                                <div class="span" style="margin-top:5px"><?php echo $resultItems['item_details']?>
                                                                    <?php if($resultItems['item_subitem_price'] > 0) {?>
                                                                        (<a href="javascript:;" rel="id<?php echo $resultItems['item_id']?>" class="addtoo u">Add To Cart</a>)

                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <span class="price b fl-left">&pound; <?php echo $resultItems['item_price']?></span>
                                                        </div>
                                                        <div class="adtocart fl-right">
                                                            <form action="javascript:;">
                                                                <input type="submit" value=" Add " title=" <?= $resultItems['item_name'] .' '?>" class="btn order-button" id="id<?php echo $resultItems['item_id']?>"/>
                                                            </form>
                                                        </div>
                                                        <div class="clr"></div>
                                                        <div class="fl-left submenuItems" style="margin-top:5px">
                                                            <?php while($res_subitem = $obj->fetch_db_assoc($valueOBJ_subitem)) {?>
                                                                <div class="nextrow">
                                                                    <div class="text fl-left" style="width:auto">
                                                                        <span class="" style="display: inline-block; width:183px; background: url('../images/arrow-point.png') no-repeat left center;padding-left: 7px;"><?php echo $res_subitem['subitem_name']?></span>
                                                                        <span class="price b" style="font-size: 9px; color: #929292; width:57px">&pound; <?php echo $res_subitem['subitem_price']?></span>
                                                                    </div>
                                                                    <div class="adtocart fl-right">
                                                                        <form action="javascript:;">
                                                                            <input type="submit" value=" Add " class="btn order-button" id="id<?php echo $resultItems['item_id'].'|'.$res_subitem['subitem_id']?>"/>
                                                                        </form>
                                                                    </div>
                                                                    <div class="clr"></div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                <?php
                                                } else {
                                                    $isMeal = false;
                                                    $Item_Price = $resultItems['item_price'];

                                                    if($resultItems['item_meal'] == 1) {
                                                        $isMeal = true;
                                                        $MEAL_ITEMS = getMealItem($resultItems['item_id']);
                                                        $Meal_item_price = $MEAL_ITEMS['size'][0]['meal_price'] + $MEAL_ITEMS['drink'][0]['meal_price'] + $MEAL_ITEMS['sides'][0]['meal_price'];
                                                        $Item_Price_Orig = $Item_Price;
                                                        $Item_Price = $Meal_item_price + $Item_Price;
                                                    }
                                                    ?>
                                                    <div class="fl-left">
                                                        <div class="text fl-left b" style="font-family: Roboto; font-weight: bold; font-size: 14px"><?php echo $resultItems['item_name']?>
                                                            <div class="span"><?php echo $resultItems['item_details']?>
                                                                <?php if($resultItems['item_subitem_price'] > 0) {?>
                                                                    (<a href="javascript:;" rel="id<?php echo $resultItems['item_id']?>" class="addtoo u">Add To Cart</a>)
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <span class="price b fl-left" style="font-family: Roboto; font-weight: bold; font-size: 12px">&pound; <?php echo $Item_Price?></span>
                                                    </div>
                                                    <div class="adtocart fl-right">
                                                        <form action="javascript:;">
                                                            <input type="submit" value=" Add " title="Add <?= $resultItems['item_name'] .' To Cart'?>" class="btn order-button" id="id<?php echo $resultItems['item_id']?>"/>
                                                        </form>
                                                    </div>                                           
                                                    <?php if($isMeal) {?>
                                     <div class="modal fade" id="meal-modal" tabindex="-1" role="dialog" aria-labelledby="meal-modal" aria-hidden="true">
                                       <div class="modal-dialog">
                                         <div class="modal-content">
                                           <div class="modal-header">
                                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                             <h4 class="modal-title">Select your Sides for the meal - <?php echo $resultItems['item_name']?></h4>
                                           </div>
                                           <div class="modal-body">                                                     
                                                        <div class="clr meal-items isMealClass">
                                                            <input type="hidden" name="size" value="<?= $MEAL_ITEMS['size'][0]['meal_price']?>"/>
                                                            <input type="hidden" name="drink" value="<?= $MEAL_ITEMS['drink'][0]['meal_price']?>"/>
                                                            <input type="hidden" name="sides" value="<?= $MEAL_ITEMS['sides'][0]['meal_price']?>"/>
                                                            <input type="hidden" name="Item_Orig" value="<?= $Item_Price_Orig?>"/>
                                                            <div class="fl-left meal-select">
                                                                <h4>Size</h4>
                                                                <select name="_Size">
                                                                    <?php foreach($MEAL_ITEMS['size'] as $_meal) {?>
                                                                        <option value="<?= $_meal['meal_id'].'_'.$_meal['meal_price'] ?>"><?= $_meal['meal_name'].' (&pound;'.$_meal['meal_price'].')'?></option>
                                                                    <?php }?>
                                                                </select>
                                                            </div>
                                                            <div class="fl-left meal-select">
                                                                <h4>Drinks</h4>
                                                                <select name="_Drinks">
                                                                    <?php foreach($MEAL_ITEMS['drink'] as $_meal) {?>
                                                                        <option value="<?= $_meal['meal_id'].'_'.$_meal['meal_price'] ?>"><?= $_meal['meal_name'].' (&pound;'.$_meal['meal_price'].')'?></option>
                                                                    <?php }?>
                                                                </select>
                                                            </div>
                                                            <div class="fl-left meal-select">
                                                                <h4>Sides</h4>
                                                                <select name="_Sides">
                                                                    <?php foreach($MEAL_ITEMS['sides'] as $_meal) {?>
                                                                        <option value="<?= $_meal['meal_id'].'_'.$_meal['meal_price'] ?>"><?= $_meal['meal_name'].' (&pound;'.$_meal['meal_price'].')'?></option>
                                                                    <?php }?>
                                                                </select>
                                                            </div>
                                                            <div class="clr"></div>
                                                        </div>
                                                       </div><!-- /.modaly-body -->
                                                        <div class="modal-footer">
                                                         <button id="meal-item-add" type="button" class="btn">Add</button>
                                                       </div>
                                                      </div><!-- /.modal-content -->
                                                     </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                    <?php } ?>
                                                <?php } ?>
                                                <div class="clr"></div>
                                            </div>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                              <?php
                          }

                        ?>


            <?php
                }
            ?>
    </div>
    <style>
    .outercart-wrapper {
        padding: 10px;
        border-radius: 5px;
        margin-top: 40px;
    }
    .cart-wrapper {
        width: 300px;
    }
    .cart-wrapper.fixed {
        position: fixed;
        right: 119px;
        top: 40px;
    }
    .outercart-wrapper {
        z-index: 1000;
        background: #fff;
    }
    .modal-body {
        overflow: hidden;
    }
    .modal {
        color: #E74C3C;
    }
    .modal h4.modal-title, 
    .modal h4 {
	  color: #420300;
      font-family: Roboto;
      font-size: 18px;
      font-weight: 600;
    }
    .meal-select {
        margin-left: 10px;
    }
    .btn-danger-custom { 
        background: #e74c3c;
    }
    </style>
    <script>
        $(document).scroll(function() {
          if ($(document).scrollTop() >= 700) {
              $('.cart-wrapper').addClass('fixed');    
          } else if ($(document).scrollTop() >= 7150) {
              alert('you can\'t scroll more');
          } else {
             $('.cart-wrapper').removeClass('fixed'); 
          }
        });
    </script>
                <div class="fl-right cart-wrapper">
                    <div class="outercart-wrapper shadow" style="position:relative"></div>
                </div>
                <div class="clr"></div>
<!-- ======================
     MODAL 
     ====================== -->               
<div class="modal fade" id="item-modal" tabindex="-1" role="dialog" aria-labelledby="item-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Remove from Cart</h4>
      </div>
      <div class="modal-body">
        <p></p>
      </div>
      <div class="modal-footer">
        <button id="item-keep" type="button" class="btn" data-dismiss="modal">No, keep</button>
        <button id="item-remove" type="button" class="btn btn-danger-custom">Yes, remove</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</div>
   </div>
    </div>

<?php include ('templates/footer2.php');?>
</body>
</html>