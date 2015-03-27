<?php
	session_start();
	include('include/functions.php');

	$_postcode = "";

	if(isset($_GET['postcode'])){

		$res_full_address = "";
		$_postcode = str_replace('-',' ',$_GET['postcode']);
		$FULL_ADDRESS = "FastFood & Takeaways in ".$_postcode;

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
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="<?= $FULL_ADDRESS.', '.getDataFromTable('setting','meta'); ?>">
	<meta name="keywords" content="<?= $FULL_ADDRESS.', '.getDataFromTable('setting','keywords'); ?>">
	<meta name="author" content="Ade">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="apple-touch-icon" href="items-pictures/default_rest_img.png">

	<link rel="shortcut icon" href="images/favicon.ico">
	<title><?php echo $FULL_ADDRESS; ?> - Just-FastFood</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />

	<link href="css/iphone.css" rel="stylesheet" type="text/css" media="only screen and (min-width: 0px) and (max-width: 320px)" >
	<link href="css/ipad.css" rel="stylesheet" type="text/css"  media="only screen and (min-width: 321px) and (max-width: 768px)" >

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/validate.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<link rel="stylesheet" href="css/fancybox/jquery.fancybox.css" />
	<script type="text/javascript" src="css/fancybox/jquery.fancybox.js"></script>
	<script type="text/javascript" src="js/mobileMenu.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $(".list-resaurant").hover(function(){
                $(this).toggleClass("shadow");
            });

            });

    </script>

	<script type="text/javascript">
		$(document).ready(function(){

			$("#order-search").validate({
				submitHandler: function(form) {
					var val = document.post.ukpostcode.value;
					val = val.replace(' ','-');
					window.location.href = 'Postcode-'+val;
					return false;
			   },
				rules: {
				 ukpostcode	: "required"
			   },
				messages: {
				 ukpostcode: "Post code Not Valid"
				},
				errorPlacement: function ($error, $element) {
					if ($element.attr("name") == "ukpostcode") {
						$error.insertAfter($element.next().next());
					} else {
						$error.insertAfter($element);
					}
				}
			});
			$(".pop_box").fancybox();
			 //$('.header .chat-wrap').css({'bottom':'auto', 'top':'3px','right':'3px','left':'auto'});

			 $('#main-nav').mobileMenu();
		});
	</script>
	<style type="text/css">
		.menu-explorer .header .outercart-wrapper {
			display:none;
		}
		h1.heading{
			font-size: 1.3em;
			text-align:center;
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
<body class="menu-explorer">
	<div class="header">
		<?php require('templates/header.php');?>
	</div>
	<div class="content">
		<div class="wrapper ">
			<div class="breadcrum">
				<ul>
					<li><a href="index.php">Begin Search</a></li>
					<li><a href="Postcode-<?php echo str_replace(' ','-',$_postcode); ?>" class="u">Postcode-<?php echo $_postcode; ?></a></li>
				</ul>
			</div>
			<?php include('include/notification.php');?>
				<!--<div class=" order-wrap">
					<div class="macky">
						<form action="" method="post" id="order-search" name="post">
							<label for="postcode">Your Post Code:</label>
							<input type="text" name="ukpostcode" id="postcode" class="text required postcode b" value="<?php echo $_postcode; ?>" placeholder="UK Post Code"/>
							<input type="submit" value="Go" name="submit" class="btn"/>
						</form>
					</div>
				</div>-->
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

							$distence = number_format($distence,2);
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
			</div>
			<div class="clr"></div>
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