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
<!DOCTYPE HTML>
<html lang="en-US" xmlns="http://www.w3.org/1999/html">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="Menu <?= $cat.getDataFromTable('setting','meta'); ?>">
	<meta name="keywords" content="Menu <?= $cat.', '.getDataFromTable('items','keywords'); ?>">
	<meta name="author" content="Ade">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="apple-touch-icon" href="items-pictures/default_rest_img.png">

	<link rel="shortcut icon" href="images/favicon.ico">
	<title>Menu <?php echo $cat;?> - Just-FastFood</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />

	<link href="css/iphone.css" rel="stylesheet" type="text/css" media="only screen and (min-width: 0px) and (max-width: 320px)" >
	<link href="css/ipad.css" rel="stylesheet" type="text/css"  media="only screen and (min-width: 321px) and (max-width: 768px)" >

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/validate.js"></script>
	<script type="text/javascript" src="js/mobileMenu.js"></script>



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
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/jquery.stickyscroll.js"></script>

    <script type="text/javascript">

    $(document).ready(function() {
        $("#wrap-menu").hover(function(){
           $(this).toggleClass('shadow')

           // alert("In here")
        });
    })
    </script>


	<script type="text/javascript">
		$(document).ready(function(){
			$('.outercart-wrapper').stickyScroll({ container: '.explor .all-menu-items' });
			$('.showsubmenuItems').live("click",function() {
				$(this).parents('.hasSubMenu').find('.submenuItems').slideToggle();
			});
			 $('#main-nav').mobileMenu;

			$('.odd').each(function(){
				$(this).hover(function(){
				   $(this).toggleClass('shadow');
				});
			});
		})
	</script>
	<style type="text/css">
		.submenuItems{
			display:none;
		}
		.MENU .delivery-type select option{
			background-color: #8d41fa;
			color: white;
		}
        .content {
            width:71%;
            margin: 0 auto;
            padding: 14px;
            background-color: #fff;
            border: 1px solid #ccc;
        }
        .highlighted {
            background-color: #ffebe8;
        }
        .shadow {
            -moz-box-shadow: 0 0 5px rgba(0,0,0,0.5);
            -webkit-box-shadow: 0 0 5px rgba(0,0,0,0.5);
            box-shadow: 0 0 5px rgba(0,0,0,0.5);
        }
	</style>
</head>
<body>
	<div class="header">
		<?php require('templates/header.php');?>
	</div>
	<div class="content">
		<div class="wrapper">
			<div class="breadcrum">
				<ul>
					<li><a href="index.php">Begin Search</a></li>
					<li><a href="Postcode-<?php echo str_replace(' ','-',$_SESSION['CURRENT_POSTCODE']); ?>">Postcode-<?php echo $_SESSION['CURRENT_POSTCODE']; ?></a></li>
					<li class="u">Menu <?php echo $cat;?></li>
				</ul>
			</div>
			<?php include('include/notification.php');?>
			<!--<h1 class="heading">Menu <?php echo $cat;?></h1>-->
			<div class="MENU">
				<?php
					$query_location = $obj -> query_db("SELECT * FROM `location` WHERE `location_menu_id` = '".$_SESSION['DELIVERY_REST_ID']."'");
					$locationObj = $obj -> fetch_db_array($query_location);
				?>
				<div class="todayTime txt-right"><?php echo date("l, j F Y, h:i A")?></div>
				<div class="box-wrap menu-details" id="wrap-menu">
					<div class="fl-left img">
						<img src="items-pictures/<?php echo $CATTEMP['category_img'];?>" alt=""/>
					</div>
					<div class="fl-left details">
						<h1><?php echo $cat;?> <span><?php echo $locationObj['location_city'];?></span></h1>
						<strong>Opening hours</strong><br>
						<ul>
							<li class="i"><label for=""><?php echo date('l');?>:</label><?php echo  $oph[date('l')]['From'] . ' - ' .$oph[date('l')]['To']?></li>
							<li style="color:#ffebe8"><label for=""><?php echo date('l', time()+86400)?>:</label><?php echo  $oph[date('l', time()+86400)]['From'] . ' - ' .$oph[date('l')]['To']?></li>
						</ul>
						<a href="oph.php?id=<?php echo $_SESSION['DELIVERY_REST_ID']?>/?iframe=true&amp;width=300&amp;height=300" rel="prettyPhoto" class="showMore u"> View all opening times</a>
					</div>
					<div class="fl-right delivery-type">
						<form action="" method="post">
							<h2>Delivery Options</h2>
							<select name="delivery_type" id="delivery_type">
								<option value="delivery">Delivery</option>
								<?php
									if($_SESSION['RESTAURANT_TYPE_CATEGORY'] != "fastfood") {
								?>
								<option value="collection" <?php echo  ($_SESSION['delivery_type']['type'] == 'collection') ? 'selected' : '' ?>>Collection</option>
								<?php
									}
								?>
							</select>

							<select name="delivery_best_time" id="delivery_best_time">
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

							<h4>Delivery Charges<span>&pound; <?php echo number_format($_SESSION['DELIVERY_CHARGES'],2);?></span></h4>
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
									
									$('.categories ul li').hover(function(){
										$(this).find('.isMealClass').show();
									},function(){
										$(this).find('.isMealClass').hide();
									});
								});
							</script>
						</form>
						<?php
							if($_SESSION['type_min_order'] > 0) {
						?>
							<span>Minimum Order Amount: &pound;<?php echo $_SESSION['type_min_order'];?></span></h4>
						<?php } ?>
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
			</div>
			<hr class="hr"/>
			<div class="explor">
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
				<div class="fl-left all-menu-items">
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
											<a href="javascript:;" class="btn showsubmenuItems" id="btn showsubmenuItems" title="Click here to view Extra menus" style="padding:1px 5px; margin:0px 0px 0px 10px;"> Please click here to choose your drinks </a>
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
										<div class="text fl-left b" style="font-family: segoe ui; font-weight: bold; font-size: 14px"><?php echo $resultItems['item_name']?>
											<div class="span"><?php echo $resultItems['item_details']?>
												<?php if($resultItems['item_subitem_price'] > 0) {?>
													(<a href="javascript:;" rel="id<?php echo $resultItems['item_id']?>" class="addtoo u">Add To Cart</a>)
												<?php } ?>
											</div>
										</div>
										<span class="price b fl-left" style="font-family: segoe ui; font-weight: bold; font-size: 11px">&pound; <?php echo $Item_Price?></span>
									</div>
									<div class="adtocart fl-right">
										<form action="javascript:;">
											<input type="submit" value=" Add " title="Add <?= $resultItems['item_name'] .' To Cart'?>" class="btn order-button" id="id<?php echo $resultItems['item_id']?>"/>
										</form>
									</div>
										<?php if($isMeal) {?>
											<div class="clr meal-items isMealClass">
												<input type="hidden" name="size" value="<?= $MEAL_ITEMS['size'][0]['meal_price']?>"/>
												<input type="hidden" name="drink" value="<?= $MEAL_ITEMS['drink'][0]['meal_price']?>"/>
												<input type="hidden" name="sides" value="<?= $MEAL_ITEMS['sides'][0]['meal_price']?>"/>
												<input type="hidden" name="Item_Orig" value="<?= $Item_Price_Orig?>"/>
												<div class="fl-left">
													<h4>Size</h4>
													<select name="_Size">
														<?php foreach($MEAL_ITEMS['size'] as $_meal) {?>
															<option value="<?= $_meal['meal_id'].'_'.$_meal['meal_price'] ?>"><?= $_meal['meal_name'].' (&pound;'.$_meal['meal_price'].')'?></option>
														<?php }?>
													</select>
												</div>
												<div class="fl-left">
													<h4>Drinks</h4>
													<select name="_Drinks">
														<?php foreach($MEAL_ITEMS['drink'] as $_meal) {?>
															<option value="<?= $_meal['meal_id'].'_'.$_meal['meal_price'] ?>"><?= $_meal['meal_name'].' (&pound;'.$_meal['meal_price'].')'?></option>
														<?php }?>
													</select>
												</div>
												<div class="fl-left">
													<h4>Sides</h4>
													<select name="_Sides">
														<?php foreach($MEAL_ITEMS['sides'] as $_meal) {?>
															<option value="<?= $_meal['meal_id'].'_'.$_meal['meal_price'] ?>"><?= $_meal['meal_name'].' (&pound;'.$_meal['meal_price'].')'?></option>
														<?php }?>
													</select>
												</div>
												<div class="clr"></div>
											</div>
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
					} else {
						echo "Items NOT available at this time";
					}
					?>
				</div>
				<div class="fl-right">
					<div class="outercart-wrapper" style="position:relative"></div>
				</div>
				<div class="clr"></div>
			</div>

		</div>
	</div>
	<div class="footer">
		<?php require('templates/footer.php');?>
	</div>
    <script type="text/javascript">
        //<![CDATA[
        var ServiceTickDetection  = function(){var version='5.5';var reqflashversion='9.0.0';var recorder=window.location.protocol+'//d2oh4tlt9mrke9.cloudfront.net/Record/js/sessioncam.recorder.js';var swf=window.location.protocol+'//d2oh4tlt9mrke9.cloudfront.net/Record/swfhttprequest.swf';var swfobject=function(){var UNDEF="undefined",OBJECT="object",SHOCKWAVE_FLASH="Shockwave Flash",SHOCKWAVE_FLASH_AX="ShockwaveFlash.ShockwaveFlash",FLASH_MIME_TYPE="application/x-shockwave-flash",ON_READY_STATE_CHANGE="onreadystatechange",win=window,doc=document,nav=navigator,plugin=false,domLoadFnArr=[main],regObjArr=[],objIdArr=[],listenersArr=[],storedAltContent,storedAltContentId,storedCallbackFn,storedCallbackObj,isDomLoaded=false,isExpressInstallActive=false,dynamicStylesheet,dynamicStylesheetMedia,autoHideShow=true,ua=function(){var w3cdom=typeof doc.getElementById!=UNDEF&&typeof doc.getElementsByTagName!=UNDEF&&typeof doc.createElement!=UNDEF,u=nav.userAgent.toLowerCase(),p=nav.platform.toLowerCase(),windows=p?/win/.test(p):/win/.test(u),mac=p?/mac/.test(p):/mac/.test(u),webkit=/webkit/.test(u)?parseFloat(u.replace(/^.*webkit\/(\d+(\.\d+)?).*$/,"$1")):false,ie=!+"\v1",playerVersion=[0,0,0],d=null;if(typeof nav.plugins!=UNDEF&&typeof nav.plugins[SHOCKWAVE_FLASH]==OBJECT){d=nav.plugins[SHOCKWAVE_FLASH].description;if(d&&!(typeof nav.mimeTypes!=UNDEF&&nav.mimeTypes[FLASH_MIME_TYPE]&&!nav.mimeTypes[FLASH_MIME_TYPE].enabledPlugin)){plugin=true;ie=false;d=d.replace(/^.*\s+(\S+\s+\S+$)/,"$1");playerVersion[0]=parseInt(d.replace(/^(.*)\..*$/,"$1"),10);playerVersion[1]=parseInt(d.replace(/^.*\.(.*)\s.*$/,"$1"),10);playerVersion[2]=/[a-zA-Z]/.test(d)?parseInt(d.replace(/^.*[a-zA-Z]+(.*)$/,"$1"),10):0;}}
        else if(typeof win.ActiveXObject!=UNDEF){try{var a=new ActiveXObject(SHOCKWAVE_FLASH_AX);if(a){d=a.GetVariable("$version");if(d){ie=true;d=d.split(" ")[1].split(",");playerVersion=[parseInt(d[0],10),parseInt(d[1],10),parseInt(d[2],10)];}}}
        catch(e){}}
            return{w3:w3cdom,pv:playerVersion,wk:webkit,ie:ie,win:windows,mac:mac};}(),onDomLoad=function(){if(!ua.w3){return;}
            if((typeof doc.readyState!=UNDEF&&doc.readyState=="complete")||(typeof doc.readyState==UNDEF&&(doc.getElementsByTagName("body")[0]||doc.body))){callDomLoadFunctions();}
            if(!isDomLoaded){if(typeof doc.addEventListener!=UNDEF){doc.addEventListener("DOMContentLoaded",callDomLoadFunctions,false);}
                if(ua.ie&&ua.win){doc.attachEvent(ON_READY_STATE_CHANGE,function(){if(doc.readyState=="complete"){doc.detachEvent(ON_READY_STATE_CHANGE,arguments.callee);callDomLoadFunctions();}});if(win==top){(function(){if(isDomLoaded){return;}
                    try{doc.documentElement.doScroll("left");}
                    catch(e){setTimeout(arguments.callee,0);return;}
                    callDomLoadFunctions();})();}}
                if(ua.wk){(function(){if(isDomLoaded){return;}
                    if(!/loaded|complete/.test(doc.readyState)){setTimeout(arguments.callee,0);return;}
                    callDomLoadFunctions();})();}
                addLoadEvent(callDomLoadFunctions);}}();function callDomLoadFunctions(){if(isDomLoaded){return;}
            try{var t=doc.getElementsByTagName("body")[0].appendChild(createElement("span"));t.parentNode.removeChild(t);}
            catch(e){return;}
            isDomLoaded=true;var dl=domLoadFnArr.length;for(var i=0;i<dl;i++){domLoadFnArr[i]();}}
            function addDomLoadEvent(fn){if(isDomLoaded){fn();}
            else{domLoadFnArr[domLoadFnArr.length]=fn;}}
            function addLoadEvent(fn){if(typeof win.addEventListener!=UNDEF){win.addEventListener("load",fn,false);}
            else if(typeof doc.addEventListener!=UNDEF){doc.addEventListener("load",fn,false);}
            else if(typeof win.attachEvent!=UNDEF){addListener(win,"onload",fn);}
            else if(typeof win.onload=="function"){var fnOld=win.onload;win.onload=function(){fnOld();fn();};}
            else{win.onload=fn;}}
            function main(){if(plugin){testPlayerVersion();}
            else{matchVersions();}}
            function testPlayerVersion(){var b=doc.getElementsByTagName("body")[0];var o=createElement(OBJECT);o.setAttribute("type",FLASH_MIME_TYPE);var t=b.appendChild(o);if(t){var counter=0;(function(){if(typeof t.GetVariable!=UNDEF){var d=t.GetVariable("$version");if(d){d=d.split(" ")[1].split(",");ua.pv=[parseInt(d[0],10),parseInt(d[1],10),parseInt(d[2],10)];}}
            else if(counter<10){counter++;setTimeout(arguments.callee,10);return;}
                b.removeChild(o);t=null;matchVersions();})();}
            else{matchVersions();}}
            function matchVersions(){var rl=regObjArr.length;if(rl>0){for(var i=0;i<rl;i++){var id=regObjArr[i].id;var cb=regObjArr[i].callbackFn;var cbObj={success:false,id:id};if(ua.pv[0]>0){var obj=getElementById(id);if(obj){if(hasPlayerVersion(regObjArr[i].swfVersion)&&!(ua.wk&&ua.wk<312)){setVisibility(id,true);if(cb){cbObj.success=true;cbObj.ref=getObjectById(id);cb(cbObj);}}
            else{displayAltContent(obj);if(cb){cb(cbObj);}}}}
            else{setVisibility(id,true);if(cb){var o=getObjectById(id);if(o&&typeof o.SetVariable!=UNDEF){cbObj.success=true;cbObj.ref=o;}
                cb(cbObj);}}}}}
            function getObjectById(objectIdStr){var r=null;var o=getElementById(objectIdStr);if(o&&o.nodeName=="OBJECT"){if(typeof o.SetVariable!=UNDEF){r=o;}
            else{var n=o.getElementsByTagName(OBJECT)[0];if(n){r=n;}}}
                return r;}
            function displayAltContent(obj){if(ua.ie&&ua.win&&obj.readyState!=4){var el=createElement("div");obj.parentNode.insertBefore(el,obj);el.parentNode.replaceChild(abstractAltContent(obj),el);obj.style.display="none";(function(){if(obj.readyState==4){obj.parentNode.removeChild(obj);}
            else{setTimeout(arguments.callee,10);}})();}
            else{obj.parentNode.replaceChild(abstractAltContent(obj),obj);}}
            function abstractAltContent(obj){var ac=createElement("div");if(ua.win&&ua.ie){ac.innerHTML=obj.innerHTML;}
            else{var nestedObj=obj.getElementsByTagName(OBJECT)[0];if(nestedObj){var c=nestedObj.childNodes;if(c){var cl=c.length;for(var i=0;i<cl;i++){if(!(c[i].nodeType==1&&c[i].nodeName=="PARAM")&&!(c[i].nodeType==8)){ac.appendChild(c[i].cloneNode(true));}}}}}
                return ac;}
            function createSWF(attObj,parObj,id){var r,el=getElementById(id);if(ua.wk&&ua.wk<312){return r;}
                if(el){if(typeof attObj.id==UNDEF){attObj.id=id;}
                    if(ua.ie&&ua.win){var att="";for(var i in attObj){if(attObj[i]!=Object.prototype[i]){if(i.toLowerCase()=="data"){parObj.movie=attObj[i];}
                    else if(i.toLowerCase()=="styleclass"){att+=' class="'+attObj[i]+'"';}
                    else if(i.toLowerCase()!="classid"){att+=' '+i+'="'+attObj[i]+'"';}}}
                        var par="";for(var j in parObj){if(parObj[j]!=Object.prototype[j]){par+='<param name="'+j+'" value="'+parObj[j]+'" />';}}
                        el.outerHTML='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"'+att+'>'+par+'</object>';objIdArr[objIdArr.length]=attObj.id;r=getElementById(attObj.id);}
                    else{var o=createElement(OBJECT);o.setAttribute("type",FLASH_MIME_TYPE);for(var m in attObj){if(attObj[m]!=Object.prototype[m]){if(m.toLowerCase()=="styleclass"){o.setAttribute("class",attObj[m]);}
                    else if(m.toLowerCase()!="classid"){o.setAttribute(m,attObj[m]);}}}
                        for(var n in parObj){if(parObj[n]!=Object.prototype[n]&&n.toLowerCase()!="movie"){createObjParam(o,n,parObj[n]);}}
                        el.parentNode.replaceChild(o,el);r=o;}}
                return r;}
            function createObjParam(el,pName,pValue){var p=createElement("param");p.setAttribute("name",pName);p.setAttribute("value",pValue);el.appendChild(p);}
            function removeSWF(id){var obj=getElementById(id);if(obj&&obj.nodeName=="OBJECT"){if(ua.ie&&ua.win){obj.style.display="none";(function(){if(obj.readyState==4){removeObjectInIE(id);}
            else{setTimeout(arguments.callee,10);}})();}
            else{obj.parentNode.removeChild(obj);}}}
            function removeObjectInIE(id){var obj=getElementById(id);if(obj){for(var i in obj){if(typeof obj[i]=="function"){obj[i]=null;}}
                obj.parentNode.removeChild(obj);}}
            function getElementById(id){var el=null;try{el=doc.getElementById(id);}
            catch(e){}
                return el;}
            function createElement(el){return doc.createElement(el);}
            function addListener(target,eventType,fn){target.attachEvent(eventType,fn);listenersArr[listenersArr.length]=[target,eventType,fn];}
            function hasPlayerVersion(rv){var pv=ua.pv,v=rv.split(".");v[0]=parseInt(v[0],10);v[1]=parseInt(v[1],10)||0;v[2]=parseInt(v[2],10)||0;return(pv[0]>v[0]||(pv[0]==v[0]&&pv[1]>v[1])||(pv[0]==v[0]&&pv[1]==v[1]&&pv[2]>=v[2]))?true:false;}
            function createCSS(sel,decl,media,newStyle){if(ua.ie&&ua.mac){return;}
                var h=doc.getElementsByTagName("head")[0];if(!h){return;}
                var m=(media&&typeof media=="string")?media:"screen";if(newStyle){dynamicStylesheet=null;dynamicStylesheetMedia=null;}
                if(!dynamicStylesheet||dynamicStylesheetMedia!=m){var s=createElement("style");s.setAttribute("type","text/css");s.setAttribute("media",m);dynamicStylesheet=h.appendChild(s);if(ua.ie&&ua.win&&typeof doc.styleSheets!=UNDEF&&doc.styleSheets.length>0){dynamicStylesheet=doc.styleSheets[doc.styleSheets.length-1];}
                    dynamicStylesheetMedia=m;}
                if(ua.ie&&ua.win){if(dynamicStylesheet&&typeof dynamicStylesheet.addRule==OBJECT){dynamicStylesheet.addRule(sel,decl);}}
                else{if(dynamicStylesheet&&typeof doc.createTextNode!=UNDEF){dynamicStylesheet.appendChild(doc.createTextNode(sel+" {"+decl+"}"));}}}
            function setVisibility(id,isVisible){if(!autoHideShow){return;}
                var v=isVisible?"visible":"hidden";if(isDomLoaded&&getElementById(id)){getElementById(id).style.visibility=v;}
                else{createCSS("#"+id,"visibility:"+v);}}
            function urlEncodeIfNecessary(s){var regex=/[\\\"<>\.;]/;var hasBadChars=regex.exec(s)!=null;return hasBadChars&&typeof encodeURIComponent!=UNDEF?encodeURIComponent(s):s;}
            return{registerObject:function(objectIdStr,swfVersionStr,xiSwfUrlStr,callbackFn){if(ua.w3&&objectIdStr&&swfVersionStr){var regObj={};regObj.id=objectIdStr;regObj.swfVersion=swfVersionStr;regObj.expressInstall=xiSwfUrlStr;regObj.callbackFn=callbackFn;regObjArr[regObjArr.length]=regObj;setVisibility(objectIdStr,false);}
            else if(callbackFn){callbackFn({success:false,id:objectIdStr});}},getObjectById:function(objectIdStr){if(ua.w3){return getObjectById(objectIdStr);}},embedSWF:function(swfUrlStr,replaceElemIdStr,widthStr,heightStr,swfVersionStr,xiSwfUrlStr,flashvarsObj,parObj,attObj,callbackFn){var callbackObj={success:false,id:replaceElemIdStr};if(ua.w3&&!(ua.wk&&ua.wk<312)&&swfUrlStr&&replaceElemIdStr&&widthStr&&heightStr&&swfVersionStr){setVisibility(replaceElemIdStr,false);addDomLoadEvent(function(){widthStr+="";heightStr+="";var att={};if(attObj&&typeof attObj===OBJECT){for(var i in attObj){att[i]=attObj[i];}}
                att.data=swfUrlStr;att.width=widthStr;att.height=heightStr;var par={};if(parObj&&typeof parObj===OBJECT){for(var j in parObj){par[j]=parObj[j];}}
                if(flashvarsObj&&typeof flashvarsObj===OBJECT){for(var k in flashvarsObj){if(typeof par.flashvars!=UNDEF){par.flashvars+="&"+k+"="+flashvarsObj[k];}
                else{par.flashvars=k+"="+flashvarsObj[k];}}}
                if(hasPlayerVersion(swfVersionStr)){var obj=createSWF(att,par,replaceElemIdStr);if(att.id==replaceElemIdStr){setVisibility(replaceElemIdStr,true);}
                    callbackObj.success=true;callbackObj.ref=obj;}
                else{setVisibility(replaceElemIdStr,true);}
                if(callbackFn){callbackFn(callbackObj);}});}
            else if(callbackFn){callbackFn(callbackObj);}},switchOffAutoHideShow:function(){autoHideShow=false;},ua:ua,getFlashPlayerVersion:function(){return{major:ua.pv[0],minor:ua.pv[1],release:ua.pv[2]};},hasFlashPlayerVersion:hasPlayerVersion,createSWF:function(attObj,parObj,replaceElemIdStr){if(ua.w3){return createSWF(attObj,parObj,replaceElemIdStr);}
            else{return undefined;}},removeSWF:function(objElemIdStr){if(ua.w3){removeSWF(objElemIdStr);}},createCSS:function(selStr,declStr,mediaStr,newStyleBoolean){if(ua.w3){createCSS(selStr,declStr,mediaStr,newStyleBoolean);}},addDomLoadEvent:addDomLoadEvent,addLoadEvent:addLoadEvent,getQueryParamValue:function(param){var q=doc.location.search||doc.location.hash;if(q){if(/\?/.test(q)){q=q.split("?")[1];}
                if(param==null){return urlEncodeIfNecessary(q);}
                var pairs=q.split("&");for(var i=0;i<pairs.length;i++){if(pairs[i].substring(0,pairs[i].indexOf("="))==param){return urlEncodeIfNecessary(pairs[i].substring((pairs[i].indexOf("=")+1)));}}}
                return"";}};}();var removeServiceTickFlash=function(swfobject){try {var container=document.getElementById('stflashobContainer');if(container){for(var p in container){try {container[p] = '';}catch(e1){}}}swfobject.removeSWF();}catch(e){}};var addServiceTickCode=function(){var rec,headID,scriptBaseURL,newScript;rec=document.createElement('script');rec.type='text/javascript';rec.src=recorder;document.getElementsByTagName('head')[0].appendChild(rec);};var addServiceTickFlash=function(){var stflashobContainer=document.createElement('DIV');stflashobContainer.setAttribute('id','stflashobContainer');stflashobContainer.setAttribute('class','ServiceTickHidden');stflashobContainer.setAttribute('style','width:1;height:1;display:inline;position:absolute;left:-1000px;top:-1000px;');document.getElementsByTagName('BODY')[0].appendChild(stflashobContainer);var attributes={id:'stflashobContainer',style:'display:inline;position:absolute;left:-1000px;top:-1000px;',styleclass:'ServiceTickHidden'};var params={menu:'false',allowScriptAccess:'always'};swfobject.embedSWF(swf,'stflashobContainer','1','1',reqflashversion,false,false,params,attributes,addServiceTickCode);if(navigator.appVersion.indexOf("MSIE")!=-1){var ver=0;try{ver = parseInt(navigator.userAgent.substring(navigator.userAgent.indexOf('MSIE')+4));}catch(err){}if(ver>=10)window.attachEvent('onbeforeunload',removeServiceTickFlash);else window.attachEvent('onunload',removeServiceTickFlash);}};return{AddServiceTick:function(){try{addServiceTickFlash();}catch(err){if(window.attachEvent)window.attachEvent('onload',addServiceTickFlash);else if(window.addEventListener)window.addEventListener('load',addServiceTickFlash,false);}},Version:function(){return version;}}}();ServiceTickDetection.AddServiceTick();
        //]]>
    </script>
</body>
</html>