<?phpsession_start();//ob_start("ob_gzhandler");include('include/functions.php');$_postcode = "";if(isset($_GET['postcode'])){    $res_full_address = "";    $_postcode = str_replace('-',' ',$_GET['postcode']);    $FULL_ADDRESS = $_postcode;    $patt = '/^([A-PR-UWYZ0-9][A-HK-Y0-9][AEHMNPRTVXY0-9]?[ABEHMNPRVWXY0-9]? {1,2}[0-9][ABD-HJLN-UW-Z]{2}|GIR 0AA)$/i';    unset($_SESSION['min_rest_Array']);    if(preg_match($patt, $_postcode)) {        $json_post = getEandN($_postcode);        if($json_post) {            $_SESSION['CURRENT_POSTCODE'] = strtoupper($_postcode);            $restArray = getCloserRest($json_post, str_replace(' ','' ,$_postcode));            if(count($restArray['array']))            {                foreach ($restArray['array'] as $val) {                    $_SESSION['DELIVERY_CHARGES'] = $val ;                    break;                  }                $_SESSION['min_rest_Array'] = $restArray['array'];                                if(array_key_exists('address' ,$restArray)) {                    $res_full_address = $restArray['address'];                    $FULL_ADDRESS = "FastFood & Takeaways in ".$res_full_address;                }            } else {                $_SESSION['error'] = "We're yet to start full operation in your area. Please bear with us!";            }          //TODO: Add support for opening times and display in modal.          $_SESSION['TO_STAFF_ID'] = toStaffId(getEandN($_SESSION['CURRENT_POSTCODE']), $_SESSION['CURRENT_POSTCODE']);          $id = $_SESSION['TO_STAFF_ID'];          if (strpos($id, 'Early') !==  false) {            $dt = substr($id, 5);            $_SESSION['error'] = 'We start taking orders on '.date("D, M jS",$dt). ' from '.date("h:i A", $dt).'.' ;          } else if($id == "false") {            $_SESSION['error'] = "We don't have any active driver in your area at the moment. Please try again in a little while.";            $_SESSION['Staff_Not_Avialable'] = 'true';          } else if (strpos($id, 'Late') !== false){            $time = substr($id, 4);            $_SESSION['error'] = "We've stopped taking orders since ".date('h:i A', $time).". Please check back in the morning. ";          } else {            $_SESSION['error'] = "We are coming to your area pretty soon Please bear with us. In the meantime, email us any questions or feedback info@just-fastfood.com";            $_SESSION['Staff_Not_Avialable'] = 'true';          }          //$staffs_order = count(getStaffOrder($id));            setC('postcode',$_SESSION['CURRENT_POSTCODE']);        } else {            $_SESSION['error'] = "Post code not valid";        }    } else {        $_SESSION['error'] = "Post code not valid";    }} else {    $_SESSION['error'] = "Post code not valid";}?><!DOCTYPE html><html><head>    <meta charset="UTF-8">    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9">    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">    <meta name="description" content="<?= $FULL_ADDRESS.', '.getDataFromTable('setting','meta'); ?>">    <meta name="keywords" content="<?= $FULL_ADDRESS.', '.getDataFromTable('setting','keywords'); ?>">    <title><?php echo 'FastFood & Takeaways IN '. $FULL_ADDRESS; ?> - Just Fast Food</title>    <!--CSS INCLUDES-->    <link rel="shortcut icon" type="image/png" href="favicon.png" />    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,900' rel='stylesheet' type='text/css'>    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>    <link href="css/archivist.css" rel="stylesheet">    <link href="css/bootstrap.min.css" rel="stylesheet">    <link rel="stylesheet" href="css/responsivemobilemenu.css" type="text/css"/>    <link href="css/media.css" rel="stylesheet">    <link href="css/flexslider.css" rel="stylesheet">    <link href="css/owl.carousel.css" rel="stylesheet">    <link href="css/owl.theme.css" rel="stylesheet">    <link href="css/star-rating.min.css" rel="stylesheet" >    <link href="css/font-awesome.min.css" rel="stylesheet">    <script src="https://code.jquery.com/jquery-1.9.0.min.js"></script>    <script src="js/responsivemobilemenu.js"></script>    <script src="js/star-rating.min.js"></script>    <style type="text/css">        .star-rating .caption,        .star-rating .clear-rating  {            display: none !important;        }        .star-rating.rating-disabled {            pointer-events: none !important;            cursor: unset !important;        }        .rating-xs {            font-size: 14px !important;            float: right;        }        li.resturant {            -moz-box-shadow:    3px 3px 6px 1px rgb(119, 129, 107);            -webkit-box-shadow: 3px 3px 6px 1px rgb(119, 129, 107);            box-shadow:         3px 3px 6px 1px rgb(119, 129, 107);        }    </style></head><body><div class="wrapper"><?php include ("templates/header2.php");?><div class="page_header">    <div class="inner_title"><h2 class="text-center white">FastFood & Takeaways in <span><?php echo $FULL_ADDRESS;?></span></h2></div>    <div class="custom_button yellow_btn small_but text-center ">        <ul><li><a href="index.php">Change Location</a></li></ul>    </div></div><div class="breadcrum">    <ul>        <li><a href="index.php">Begin Search</a></li>        <li><a href="Postcode-<?php echo str_replace(' ','-',$_postcode); ?>" class="u">Postcode-<?php echo $_postcode; ?></a></li>    </ul></div><div class="alert alert-info alert-dismissable" style="width: 60%; margin: auto; display: inherit">Please let <a href="#" onclick="return SnapEngage.startLink();">Debra</a> or <a href="#" onclick="return SnapEngage.startLink();">Brian</a> know if there's something you need that's not available yet. We'll try to get it on ASAP! </div><div class="section_inner"><div class="container"><?php if( $_SESSION['error'] == "We're yet to start full operation in your area. Please bear with us!" || $_SESSION['error'] == "Post code not valid" || $_SESSION['error'] == "Driver Not Available") { ?>        <div class="modal fade" style="z-index:999999999; overflow: hidden;" id="error-modal" tabindex="-1" role="dialog" aria-labelledby="error-modal" aria-hidden="true">            <div class="modal-dialog">                <div class="modal-content">                    <div class="modal-header" style="overflow: hidden;">                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                        <h4 class="modal-title">                            <?php if( $_SESSION['error'] == "We're yet to start full operation in your area. Please bear with us!") {                                echo 'Area Not Covered';                            } else if ($_SESSION['error'] == "Post code not valid" ) {                                echo 'INVALID POSTCODE';                            } else if($_SESSION['error'] == "Driver Not Available") {                                echo 'Driver Not Available Presently';                            }                            ?>                        </h4>                    </div>                    <div class="modal-body" style="font-weight: 300;">                        <p><?php echo $_SESSION['error']; ?></p>                    </div>                    <div class="modal-footer">                        <button id="index-go" type="button" class="btn" data-dismiss="modal">OK</button>                    </div>                </div><!-- /.modal-content -->            </div><!-- /.modal-dialog -->        </div><!-- /.modal -->        <script>            $(document).ready(function(){                setTimeout(function(){                    $('#error-modal').modal({ backdrop: 'static', keyboard: false })                }, 700);                $('#index-go').click(function(){                    window.location.href = '/';                });            });        </script>    <?php } ?><?php if( ($_SESSION['TO_STAFF_ID'] == "false") || ($_SESSION['TO_STAFF_ID'] == 'Not_Active') || (strpos($_SESSION['TO_STAFF_ID'], 'Early') !==  false) || strpos($_SESSION['TO_STAFF_ID'], 'Late') !==  false) { ?>  <div class="modal fade" style="z-index:999999999; overflow: hidden;" id="error-modal" tabindex="-1" role="dialog" aria-labelledby="error-modal" aria-hidden="true">    <div class="modal-dialog">      <div class="modal-content">        <div class="modal-header" style="overflow: hidden;">          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>          <h4 class="modal-title" style="font-weight: normal; font-size: 20px">            <?php              echo 'Apologies! ';            ?>          </h4>        </div>        <div class="modal-body" style="font-weight: 300;">          <?php echo $_SESSION['error']; ?>        </div>        <div class="modal-footer">          <button id="index-go" type="button" class="btn" data-dismiss="modal">OK</button>        </div>      </div><!-- /.modal-content -->    </div><!-- /.modal-dialog -->  </div><!-- /.modal -->  <script>    $(document).ready(function(){      setTimeout(function(){        $('#error-modal').modal({ backdrop: 'static', keyboard: false })      }, 700);      $('#index-go').click(function(){        window.location.href = '/';      });    });  </script><?php } ?>    <div class="checks">        <ul id="filter-food-type">            <li><a onclick="" href="javascript:;" data-food-type="all" class="active" >All</a></li>            <li><a onclick="" href="javascript:;" data-food-type="American" >American</a></li>            <li><a onclick="" href="javascript:;" data-food-type="American" >FastFood</a></li>            <li><a onclick="" href="javascript:;" data-food-type="Chinese" >Chinese</a></li>            <li><a onclick="" href="javascript:;" data-food-type="Indian" >Indian</a></li>            <li><a onclick="" href="javascript:;" data-food-type="Thai Cuisine" >Thai Cuisine</a></li>        </ul>    </div>    <?php include('include/notification.php');?>    <?php    if(isset($_SESSION['min_rest_Array'])) {?>    <div class="clr"></div>    <ul class="restuarant-lists">        <?php        $_SESSION['min_rest_Array'] = array_reverse($_SESSION['min_rest_Array'], true);        foreach($_SESSION['min_rest_Array'] as $restName => $dist) {            $ar = explode('-' , $restName);            $restNam[$ar[0]] = $dist;            $post_arr[$ar[0]] = $ar[1];        }        asort($restNam);        foreach($restNam as $id => $distence) {            $distence = number_format($distence, 2);            $_SESSION['DISTENCE'][$id] = $distence;            $restaurant_postcode = str_replace(' ','-' ,$post_arr[$id]);            $query = "SELECT * FROM `menu_type` WHERE `type_id` = '".$id."'";            $menu = $obj -> query_db($query);            while($res = $obj->fetch_db_assoc($menu)) {                $T_RATINGS = 0;                $t_rating = 0;                $nowTime = strtotime(date('H:i'));                $oph = json_decode(stripslashes($res['type_opening_hours']) ,true);                $oph_from = strtotime($oph[date('l')]['From']);                $oph_to = strtotime($oph[date('l')]['To']);                $isAvailable = false;                if($nowTime > $oph_from && $nowTime < $oph_to) {                    $isAvailable = true;                }                    $charged = getTotalDeliveryCharges($res['type_steps'], $res['type_id'], $distence);                   /* $pcode = $_SESSION['CURRENT_POSTCODE'];                    if($pcode[0] == 'S' || $pcode[0] == 'W' || $pcode[0] == 'E' || $pcode[0] == 'N'){                      $charged += 1;                    }*/                ?>                <li class="resturant" data-food-type="<?php echo $res['food_type']; ?>" >                    <div class="sec_1 col-lg-5 col-md-5 col-sm-12 col-xs-12 ">                        <ul>                            <li class="res_image">                                <img src="items-pictures/<?php echo $res['type_picture'];?>" alt=""/>                            </li>                            <li class="res_title" style="font-family: 'Lato'; color: darkred"><?php echo str_replace(' ', '-', $res['type_name']);?></li>                            <?php                            $resClosed = '';                            $LINK = 'menu-'.str_replace(' ', '-', $res['type_name']).'-'.$res['type_id'].'-'.$restaurant_postcode.'';                            $closed = false;                            if( $shopClosed ) {                                ?>                                <br><span class="i">(<?php echo $shopClosed?>)</span>                            <?php }                            if(!$isAvailable) {                               // $closed = true;                                ?>                              <!--  <br><span class="i">Not Accepting Orders At This Time</span>-->                            <?php  } ?>                            <?php if ($closed) {?>                                <br><span class="last">Opens At: <?php echo $oph[date('l')]['From']; ?></span>                            <?php } ?>                        </ul>                        <?php                        if($res['type_special_offer'] != "") {                            $type_special_offer = json_decode($res['type_special_offer'] ,true);                            echo '<div class="custom_but small_but green_btn"><strong>';                            echo $type_special_offer['off']. ' % off today on orders over &pound; '.number_format($type_special_offer['pound'], 2);                            echo '</strong></div>';                        }                        ?>                    </div>                    <div class="sec_2 col-lg-5 col-md-4 col-sm-12 col-xs-12">                        <ul>                            <li class="sub_title">Approximate distance, delivery time and charges.</li>                            <li><span class="glyphicon glyphicon-map-marker"> </span> <strong><?php echo $distence;?></strong> miles </li>                            <li><span class="glyphicon glyphicon-time"> </span> <strong><?php echo $res['type_time']; ?></strong> minutes (approx)</li>                            <li><i><span class="fa fa-car" title="Delivery Fee"> </span></i> <strong> <?php echo ($charged ==0) ? 'Free Shipping' : '&pound; '.number_format($charged, 2);?></strong><br/></li>                        </ul>                        <?php                        if($isAvailable) {                            echo '<div class="custom_button small_but yellow_btn"><ul><li><a href="'.$LINK.'">View Menu and Order</a></li></ul></div>';                            $resClosed = 'Accepting and Processing Orders';                        } else {                            echo '<div class="custom_button small_but red_btn"><ul><li><a href="'.$LINK.'" title="The Restaurant is closed">Pre-Order</a></li></ul></div>';                            $resClosed = 'Not Accepting Orders At This Time';                            $closed = true;                        }                        ?>                    </div>                    <?php                    if($res['type_special_offer'] != "") {                        $type_special_offer = json_decode($res['type_special_offer'], true);                        echo '<div class="custom_button small_but green_btn">';                        echo '<ul><li><a href=""><?php echo $type_special_offer;?></a></li></ul>';                        echo '</div>';                    }                    ?>                    <?php                    $Quality = 0;                    $Service = 0;                    $Value = 0;                    $Delivery = 0;                    $T_RATINGS = 0;                    $t_rating = 0;                    $query2 = "SELECT * FROM `rating` WHERE `r_rest_id` = '".$res['type_id']."'";                    $r1 = $obj -> query_db($query2);                    while($rating = $obj->fetch_db_assoc($r1)){                        $ratArr = json_decode($rating['r_details'], true);                        $Quality += $ratArr['Quality'];                        $Service += $ratArr['Service'];                        $Value += $ratArr['Value'];                        $Delivery += $ratArr['Delivery'];                        $T_RATINGS ++;                    }                    if($T_RATINGS != 0) {                        $Quality = round($Quality / $T_RATINGS);                        $Service = round($Service / $T_RATINGS);                        $Value = round($Value / $T_RATINGS);                        $Delivery = round($Delivery / $T_RATINGS);                    }                    if($T_RATINGS == 0) {                        $rat_str = '                                    <div class="r-5_0"></div>                                    <div class="r-5_0"></div>                                    <div class="r-5_0"></div>                                    <div class="r-5_0"></div>                                ';                    } else {                        $t_rating = round(($Quality + $Service + $Value + $Delivery) / 4);                        $rat_str = '<li class="list-group-item">Quality: <input class="rating" type="number" min="1" max="10" step="'.$Quality.'" value="'.$Quality.'" data-size="xs" data-readonly="1" /></li>';                        $rat_str .= '<li class="list-group-item">Service: <input class="rating" type="number" min="1" max="10" step="'.$Service.'" value="'.$Service.'" data-size="xs" data-readonly="1" /></li>';                        $rat_str .= '<li class="list-group-item">Value: <input class="rating" type="number" min="1" max="10" step="'.$Value.'" value="'.$Value.'" data-size="xs" data-readonly="1" /></li>';                        $rat_str .= '<li class="list-group-item">Delivery: <input class="rating" type="number" min="1" max="10" step="'.$Delivery.'" value="'.$Delivery.'" data-size="xs" data-readonly="1" /></li>';                    }                    ?>                    <div class="sec_3 col-lg-2 col-md-3 col-sm-12 col-xs-12">                        <ul class="list-group">                            <?php echo $rat_str; ?>                        </ul>                    </div>                    <div class="clr"></div>                </li>            <?php            }        }        ?></div><?php }?><script>    $(document).ready(function(){        $('#filter-food-type a').bind('click touchstart', function(){            var foodType = $(this).attr('data-food-type');            if ( foodType == 'all' ) {                $('#filter-food-type a').removeClass('active');                $(this).addClass('active');                $('ul.restuarant-lists .resturant').fadeIn();            } else {                if ( $('ul.restuarant-lists').find('.resturant[data-food-type="'+ foodType +'"]').length > 0 ) {                    $('#filter-food-type a').removeClass('active');                    $(this).addClass('active');                    $('ul.restuarant-lists .resturant').fadeOut( function(){                        $('ul.restuarant-lists').find('.resturant[data-food-type="'+ foodType +'"]').fadeIn();                    });                } else {                    $('#no-food-type').modal();                }            }        });    });</script></div></div><div class="modal fade" style="z-index:999999999; overflow: hidden;" id="no-food-type" tabindex="-1" role="dialog" aria-labelledby="no-food-type" aria-hidden="true">    <div class="modal-dialog">        <div class="modal-content">            <div class="modal-header" style="overflow: hidden;">                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                <h4 class="modal-title">Dish Is Not Available</h4>            </div>            <div class="modal-body">                <p>We are working on bringing your favourite dishes</p>            </div>            <div class="modal-footer">                <button type="button" class="btn" data-dismiss="modal">Ok</button>            </div>        </div><!-- /.modal-content -->    </div><!-- /.modal-dialog --></div><!-- /.modal --><?php include "templates/footer2.php";?></body></html>