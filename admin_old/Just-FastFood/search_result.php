<?php session_start();
include('../../include/functions.php');

$_postcode = "";

if(isset($_GET['postcode'])){

    $res_full_address = "";
    $_postcode = str_replace('-',' ',$_GET['postcode']);
    $FULL_ADDRESS = $_postcode;

    $patt = '/^([A-PR-UWYZ0-9][A-HK-Y0-9][AEHMNPRTVXY0-9]?[ABEHMNPRVWXY0-9]? {1,2}[0-9][ABD-HJLN-UW-Z]{2}|GIR 0AA)$/i';
    unset($_SESSION['min_rest_Array']);

    if(preg_match($patt, $_postcode)) {

        $json_post = getEandN($_postcode);
        if($json_post) {
            $_SESSION['CURRENT_POSTCODE'] = strtoupper($_postcode);

            $restArray = getCloserRest($json_post, str_replace(' ','' ,$_postcode));

            if(count($restArray['array'])){
                foreach ($restArray['array'] as $val) { $_SESSION['DELIVERY_CHARGES'] = $val ; break; }
                $_SESSION['min_rest_Array'] = $restArray['array'];
                if(array_key_exists('address' ,$restArray)) {
                    $res_full_address = $restArray['address'];
                    $FULL_ADDRESS = "FastFood & Takeaways in ".$res_full_address;
                }
            } else {
                $_SESSION['error'] = "We're yet to start full operation in your area. Please bear with us!";
            }

            setC('postcode',$_SESSION['CURRENT_POSTCODE']);
        } else {
            $_SESSION['error'] = "Post code not valid  ";
        }
    } else {
        $_SESSION['error'] = "Post code not valid ";
    }
} else {
    $_SESSION['error'] = "Post code not valid ";
}

?>

<!DOCTYPE html>

<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Just Fast Food</title>

<!--CSS INCLUDES-->
<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,900' rel='stylesheet' type='text/css'>

<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>



<link href="css/archivist.css" rel="stylesheet">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/responsivemobilemenu.css" type="text/css"/>
<link href="css/media.css" rel="stylesheet">
<link href="css/flexslider.css" rel="stylesheet">

<link href="css/owl.carousel.css" rel="stylesheet">
<link href="css/owl.theme.css" rel="stylesheet">

<script src="http://code.jquery.com/jquery-1.9.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.flexslider.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/responsivemobilemenu.js"></script>

</head>

<body>
<div class="wrapper">
<?php include("template/header.php");?>
<div class="page_header">
<div class="inner_title"><h2 class="text-center white">FastFood & Takeaways in <span><?php echo $FULL_ADDRESS;?></span></h2></div>


<div class="custom_button yellow_btn small_but text-center">
<ul><li><a href="index.php">Change Location</a></li></ul>
</div>
</div>
<?php include('../../include/notification.php');?>
<?php if(isset($_SESSION['min_rest_Array'])) {?>
<div class="leftColumn">
<h1 class="heading i"><?php echo $FULL_ADDRESS; ?></h1>
<div class="clr"></div>

<div class="explor selectMenu" id="selectMenu">
    <ul>
        <?php

        $_SESSION['min_rest_Array'] = array_reverse($_SESSION['min_rest_Array'], true);
        /* $current_to_staff_id = toStaffId(getEandN($_SESSION['CURRENT_POSTCODE']), $_SESSION['CURRENT_POSTCODE']);
        $select_s = "`staff_postcode`";
        $where_s = "`staff_id` = '".$current_to_staff_id."'";

        $to_staff_postcode = SELECT($select_s ,$where_s, 'staff', 'array');
*/
        foreach($_SESSION['min_rest_Array'] as $restName => $dist) {
            $ar = explode('-' , $restName);
            $restNam[$ar[0]] = $dist;
            $post_arr[$ar[0]] = $ar[1];
        }

        asort($restNam);
        foreach($restNam as $id => $distence) {

            $distence = number_format($distence, 2);
            $_SESSION['DISTENCE'][$id] = $distence;

            $restaurant_postcode = str_replace(' ','-' ,$post_arr[$id]);

            $query = "SELECT * FROM `menu_type` WHERE `type_id` = '".$id."'";
            $menu = $obj -> query_db($query);
            while($res = $obj->fetch_db_assoc($menu)) {

                $T_RATINGS = 0;
                $t_rating = 0;

                $nowTime = strtotime(date('H:i'));
                $oph = json_decode(stripslashes($res['type_opening_hours']) ,true);

                $oph_from = strtotime($oph[date('l')]['From']);
                $oph_to = strtotime($oph[date('l')]['To']);

                $isAvailable = false;
                if($nowTime > $oph_from && $nowTime < $oph_to) {
                    $isAvailable = true;
                }

                $chareged = getTotalDeliveryCharges($res['type_steps'] ,$res['type_id'] ,$distence);
                //$chareged = round($distence * delivery_charges($res['type_id']),2);
                ?>
                <li class="list-resaurant" id ="list-restaurant">
                    <div class="fl-left">
                        <img src="items-pictures/<?php echo $res['type_picture'];?>" alt="" />
                    </div>
                    <div class="fl-left">
                        <a href="restaurant-<?php echo str_replace(' ', '-', $res['type_name']).'-'.str_replace(' ', '', $res['type_category']).'-'.$res['type_id'].'-'.$restaurant_postcode; ?>" class="menutype"><?php echo $res['type_name']?></a>
                        <div class="style" style="color:#1b0817; font-family: segoe ui; font-weight: lighter">
                            <span style="color:#1b0817">Approximate distance, delivery time and charges.</span> <br/>
                            Distance: <strong><?php echo $distence;?></strong> miles <br/>
                            Delivery Est.: <strong><?php echo $res['type_time']; ?></strong> minutes  (approx)<br/>
                            <?php
                            /* $query__res = "SELECT `location_city` FROM `location` WHERE `location_postcode` = '".json_encode(array(str_replace('-',' ',$restaurant_postcode) => getEandN(str_replace('-',' ',$restaurant_postcode))))."'";
                            $menu___res = $obj -> query_db($query__res);
                            $Location_add = $obj->fetch_db_assoc($menu___res); */
                            ?>
                            <!--Location: <strong><?= $Location_add['location_city'].', '. str_replace('-',' ',$restaurant_postcode); ?></strong><br/><br/>-->
                            Delivery Charges: <strong><?php echo ($chareged == 0) ? 'Free Shipping' : '&pound; '.number_format($chareged, 2);?></strong><br/>
                        </div>
                    </div>
                    <?php
                    if($res['type_special_offer'] != "") {
                        $type_special_offer = json_decode($res['type_special_offer'] ,true);
                        echo '<div class="special-offer"><strong>';
                        echo $type_special_offer['off']. ' % off today on orders over &pound; '.number_format($type_special_offer['pound'], 2);
                        echo '</strong></div>';
                    }
                    ?>
                    <div class="fl-left note i b" style="color: orange">
                        <?php echo $res['type_notes'];?>
                    </div>
                    <div class="fl-right">
                        <div class="review-Details" style="padding:0px; color: orangered">
                            <?php

                            $Quality = 0;
                            $Service = 0;
                            $Value = 0;
                            $Delivery = 0;

                            $T_RATINGS = 0;
                            $t_rating = 0;

                            $query2 = "SELECT * FROM `rating` WHERE `r_rest_id` = '".$res['type_id']."'";
                            $r1 = $obj -> query_db($query2);

                            while($rating = $obj->fetch_db_assoc($r1)){
                                $ratArr = json_decode($rating['r_details'], true);

                                $Quality += $ratArr['Quality'];
                                $Service += $ratArr['Service'];
                                $Value += $ratArr['Value'];
                                $Delivery += $ratArr['Delivery'];

                                $T_RATINGS ++;
                            }
                            if($T_RATINGS != 0) {
                                $Quality = round($Quality / $T_RATINGS);
                                $Service = round($Service / $T_RATINGS);
                                $Value = round($Value / $T_RATINGS);
                                $Delivery = round($Delivery / $T_RATINGS);
                            }

                            if($T_RATINGS == 0) {

                                $rat_str = '
												<div class="r-5_0"></div>
												<div class="r-5_0"></div>
												<div class="r-5_0"></div>
												<div class="r-5_0"></div>
											';
                            } else {

                                $t_rating = round(($Quality + $Service + $Value + $Delivery) / 4);

                                $rat_str = '<div class="r-5_'.$Quality.'" title="Quality ('.$Quality.'/10)"></div>';
                                $rat_str .= '<div class="r-5_'.$Service.'" title="Service ('.$Service.'/10)"></div>';
                                $rat_str .= '<div class="r-5_'.$Value.'" title="Value ('.$Value.'/10)"></div>';
                                $rat_str .= '<div class="r-5_'.$Delivery.'" title="Delivery ('.$Delivery.'/10)"></div>';

                            }
                            ?>
                            <div class="cbox-wrap" style="margin-bottom:2px">
                                <?php
                                echo ($t_rating == 0) ? '' : '<div class="fl-left" style="padding-top:3px;">Overall:&nbsp;</div><div class="rating fl-left"><div class="r-5_'.$t_rating.'" title="Overall Rating ('.$t_rating.'/10)"></div></div><div class="fl-left"  style="padding-top:3px;"></div>';
                                ?>
                                <div class="clr"></div>
                            </div>
                            <div class="cbox-wrap">
                                <div class="fl-left">
                                    <div style="padding-top:1px;">Quality:</div>
                                    <div style="padding-top:1px;">Service:</div>
                                    <div style="padding-top:1px;">Value:</div>
                                    <div style="padding-top:1px;">Delivery:</div>
                                </div>
                                <div class="fl-left">
                                    <div class="rating">
                                        <?php echo $rat_str; ?>
                                    </div>
                                </div>
                                <div class="clr"></div>
                                <br />
                                <?php
                                echo ($T_RATINGS == 0) ? 'No Reviews Yet' : '<a href="reviews.php?id='.$res['type_id'].'/?iframe=true&amp;width=400&amp;height=500" rel="prettyPhoto" class="u">'.($T_RATINGS).' Reviews</a> ('.$t_rating.' Ratings)<br>';
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="clr"></div>
                    <div class="btn-wrap">
                        <?php
                        $shopClosed = '';
                        $LINK = 'menu-'.str_replace(' ', '-', $res['type_name']).'-'.$res['type_id'].'-'.$restaurant_postcode.'';
                        $closed = false;

                        if($isAvailable){
                            echo '<div><a class="btn" title="Accepting & Processing Orders" href="'.$LINK.'">View Menu and Order</a></div>';
                            $shopClosed = 'Accepting & Processing Orders';
                        } else {
                            echo '<div><a class="redbtn" title="Opening Soon - Check back later" href="'.$LINK.'">View Menu</a></div>';
                            $shopClosed = 'Not Accepting Orders At This Time';
                            $closed = true;
                        }
                        ?>
                        <br><span class="i">(<?php echo $shopClosed; ?>)</span>
                        <?php if ($closed) {?>
                            <br><span class="b">Opens At: <?= $oph[date('l')]['From']; ?></span>
                        <?php } ?>
                    </div>
                </li>
            <?php
            }
        }
        ?>
    </ul>
</div>
<hr class="hr"/><br>
<?php } ?>

<div class="section_inner">
<div class="container">

<div class="checks">

<ul>
<li><a href="" class="active">All</a></li>
<li><a href="">FastFood</a></li>
<li><a href="">Takeaway</a></li>
</ul>



</div>
<div class="resturant">

<div class="sec_1 col-lg-5 col-md-5 col-sm-12 col-xs-12">
<ul>
<li class="res_image"><img src="images/JFF.png"></li>
<li class="res_title">Exotic Nigerian Cusine</li>
<li><span>(Accepting & Processing Orders)</span></li>


</ul>

<div class="custom_button small_but green_btn">
<ul><li><a href="">20% off</a></li></ul>
</div>
</div>
<div class="sec_2 col-lg-5 col-md-4 col-sm-12 col-xs-12">
<ul>
<li class="sub_title">Approximate distance, delivery time and charges.</li>
<li><span>Distance:</span> 0.20 miles </li>
<li><span>Delivery Est</span>: 90 minutes (approx)</li>
<li><span>Delivery Charges:</span> £ 3.99</li>

</ul>
<div class="custom_button small_but red_btn">
<ul><li><a href="">View Menu</a></li></ul>
</div>
</div>


<div class="sec_3 col-lg-2 col-md-3 col-sm-12 col-xs-12">

<ul>
<li>Overall:<span><img src="images/rating.png"></span></li>
<li class="sep"></li>
<li>Quality:<span><img src="images/rating.png"></span></li>
<li>Service:<span><img src="images/rating.png"></span></li>
<li>Value:<span><img src="images/rating.png"></span></li>
<li>Delivery:<span><img src="images/rating.png"></span></li>
<li class="sep"></li>
<li>3 Reviews (10 Ratings)</li>

</ul>

</div>

</div>

<div class="resturant gray">

<div class="sec_1 col-lg-5 col-md-5 col-sm-12 col-xs-12">
<ul>
<li class="res_image"><img src="images/kfc.jpg"></li>
<li class="res_title">KFC</li>
<li><span>(Accepting & Processing Orders)</span></li>


</ul>

<div class="custom_button small_but green_btn">
<ul><li><a href="">New Menu Added</a></li></ul>
</div>
</div>
<div class="sec_2 col-lg-5 col-md-4 col-sm-12 col-xs-12">
<ul>
<li class="sub_title">Approximate distance, delivery time and charges.</li>
<li><span>Distance:</span> 0.20 miles </li>
<li><span>Delivery Est</span>: 90 minutes (approx)</li>
<li><span>Delivery Charges:</span> £ 3.99</li>

</ul>
<div class="custom_button small_but red_btn">
<ul><li><a href="">View Menu</a></li></ul>
</div>
</div>


<div class="sec_3 col-lg-2 col-md-3 col-sm-12 col-xs-12">

<ul>
<li>Overall:<span><img src="images/rating.png"></span></li>
<li class="sep"></li>
<li>Quality:<span><img src="images/rating.png"></span></li>
<li>Service:<span><img src="images/rating.png"></span></li>
<li>Value:<span><img src="images/rating.png"></span></li>
<li>Delivery:<span><img src="images/rating.png"></span></li>
<li class="sep"></li>
<li>3 Reviews (10 Ratings)</li>

</ul>

</div>

</div>

<div class="resturant">

<div class="sec_1 col-lg-5 col-md-5 col-sm-12 col-xs-12">
<ul>
<li class="res_image"><img src="images/mcdonads.png"></li>
<li class="res_title">McDonals</li>
<li><span>(Accepting & Processing Orders)</span></li>


</ul>

<div class="custom_button small_but green_btn">
<ul><li><a href="">Order over $15=Free Delivery</a></li></ul>
</div>
</div>
<div class="sec_2 col-lg-5 col-md-4 col-sm-12 col-xs-12">
<ul>
<li class="sub_title">Approximate distance, delivery time and charges.</li>
<li><span>Distance:</span> 0.20 miles </li>
<li><span>Delivery Est</span>: 90 minutes (approx)</li>
<li><span>Delivery Charges:</span> £ 3.99</li>

</ul>
<div class="custom_button small_but red_btn">
<ul><li><a href="">View Menu</a></li></ul>
</div>
</div>


<div class="sec_3 col-lg-2 col-md-3 col-sm-12 col-xs-12">

<ul>
<li>Overall:<span><img src="images/rating.png"></span></li>
<li class="sep"></li>
<li>Quality:<span><img src="images/rating.png"></span></li>
<li>Service:<span><img src="images/rating.png"></span></li>
<li>Value:<span><img src="images/rating.png"></span></li>
<li>Delivery:<span><img src="images/rating.png"></span></li>
<li class="sep"></li>
<li>3 Reviews (10 Ratings)</li>

</ul>

</div>

</div>
<div class="resturant">

<div class="sec_1 col-lg-5 col-md-5 col-sm-12 col-xs-12">
<ul>
<li class="res_image"><img src="images/JFF.png"></li>
<li class="res_title">Exotic Nigerian Cusine</li>
<li><span>(Accepting & Processing Orders)</span></li>


</ul>

<div class="custom_button small_but green_btn">
<ul><li><a href="">20% off</a></li></ul>
</div>
</div>
<div class="sec_2 col-lg-5 col-md-4 col-sm-12 col-xs-12">
<ul>
<li class="sub_title">Approximate distance, delivery time and charges.</li>
<li><span>Distance:</span> 0.20 miles </li>
<li><span>Delivery Est</span>: 90 minutes (approx)</li>
<li><span>Delivery Charges:</span> £ 3.99</li>

</ul>
<div class="custom_button small_but red_btn">
<ul><li><a href="">View Menu</a></li></ul>
</div>
</div>


<div class="sec_3 col-lg-2 col-md-3 col-sm-12 col-xs-12">

<ul>
<li>Overall:<span><img src="images/rating.png"></span></li>
<li class="sep"></li>
<li>Quality:<span><img src="images/rating.png"></span></li>
<li>Service:<span><img src="images/rating.png"></span></li>
<li>Value:<span><img src="images/rating.png"></span></li>
<li>Delivery:<span><img src="images/rating.png"></span></li>
<li class="sep"></li>
<li>3 Reviews (10 Ratings)</li>

</ul>

</div>

</div>

<div class="resturant gray">

<div class="sec_1 col-lg-5 col-md-5 col-sm-12 col-xs-12">
<ul>
<li class="res_image"><img src="images/kfc.jpg"></li>
<li class="res_title">KFC</li>
<li><span>(Accepting & Processing Orders)</span></li>


</ul>

<div class="custom_button small_but green_btn">
<ul><li><a href="">New Menu Added</a></li></ul>
</div>
</div>
<div class="sec_2 col-lg-5 col-md-4 col-sm-12 col-xs-12">
<ul>
<li class="sub_title">Approximate distance, delivery time and charges.</li>
<li><span>Distance:</span> 0.20 miles </li>
<li><span>Delivery Est</span>: 90 minutes (approx)</li>
<li><span>Delivery Charges:</span> £ 3.99</li>

</ul>
<div class="custom_button small_but red_btn">
<ul><li><a href="">View Menu</a></li></ul>
</div>
</div>


<div class="sec_3 col-lg-2 col-md-3 col-sm-12 col-xs-12">

<ul>
<li>Overall:<span><img src="images/rating.png"></span></li>
<li class="sep"></li>
<li>Quality:<span><img src="images/rating.png"></span></li>
<li>Service:<span><img src="images/rating.png"></span></li>
<li>Value:<span><img src="images/rating.png"></span></li>
<li>Delivery:<span><img src="images/rating.png"></span></li>
<li class="sep"></li>
<li>3 Reviews (10 Ratings)</li>

</ul>

</div>

</div>

<div class="resturant">

<div class="sec_1 col-lg-5 col-md-5 col-sm-12 col-xs-12">
<ul>
<li class="res_image"><img src="images/mcdonads.png"></li>
<li class="res_title">McDonals</li>
<li><span>(Accepting & Processing Orders)</span></li>


</ul>

<div class="custom_button small_but green_btn">
<ul><li><a href="">Order over $15=Free Delivery</a></li></ul>
</div>
</div>
<div class="sec_2 col-lg-5 col-md-4 col-sm-12 col-xs-12">
<ul>
<li class="sub_title">Approximate distance, delivery time and charges.</li>
<li><span>Distance:</span> 0.20 miles </li>
<li><span>Delivery Est</span>: 90 minutes (approx)</li>
<li><span>Delivery Charges:</span> £ 3.99</li>

</ul>
<div class="custom_button small_but red_btn">
<ul><li><a href="">View Menu</a></li></ul>
</div>
</div>


<div class="sec_3 col-lg-2 col-md-3 col-sm-12 col-xs-12">

<ul>
<li>Overall:<span><img src="images/rating.png"></span></li>
<li class="sep"></li>
<li>Quality:<span><img src="images/rating.png"></span></li>
<li>Service:<span><img src="images/rating.png"></span></li>
<li>Value:<span><img src="images/rating.png"></span></li>
<li>Delivery:<span><img src="images/rating.png"></span></li>
<li class="sep"></li>
<li>3 Reviews (10 Ratings)</li>

</ul>

</div>

</div>


</div>









</div>

</div>


<?php include "template/footer.php";?>

</div>

 <script src="js/jquery.newsTicker.js"></script>
 <script>
    		
          var nt_example1 = $('#nt-example1').newsTicker({
                row_height: 90,
                max_rows: 5,
                duration: 2000,
				autostart:1,
                prevButton: $('#nt-example1-prev'),
                nextButton: $('#nt-example1-next')
            }); 
            
        </script>
</body>
</html>