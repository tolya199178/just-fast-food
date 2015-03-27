<?php
	session_start();

	/* echo '<pre>';
	print_r($_SESSION);
	echo '</pre>'; */

	include('include/functions.php');

	if(!isset($_SESSION['CURRENT_ORDER_ID']) && isset($_SESSION['user'])){
		header('location:my-profile.php');
		die();
	}

	if(!isset($_SESSION['CURRENT_ORDER_ID'])){
		header('location:my-profile.php');
		die();
	}

	$select = "`order_status`,`order_date_added`,`order_rest_id`, `order_acceptence_time`";
	$where = "`order_id` = '".$_SESSION['CURRENT_ORDER_ID']."'";
	$result_order = SELECT($select ,$where, 'orders', 'array');

	$select_time = "`type_time`";
	$where_time = "`type_id` = '".$result_order['order_rest_id']."'";
	$estimated_menu_time = SELECT($select_time ,$where_time, 'menu_type', 'array');

	if($result_order['order_status'] == 'assign') {
		$return_status = 'true';
	} else if($result_order['order_status'] == 'cancel') {
		$return_status = 'cancel';
	} else {
		$return_status = 'false';
	}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="Your Order - Confirmation and Response, <?= getDataFromTable('setting','meta'); ?>">
	<meta name="keywords" content="Your Order - Confirmation and Response, <?= getDataFromTable('setting','keywords'); ?>">
	<meta name="author" content="Just-FastFood">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="apple-touch-icon" href="items-pictures/default_rest_img.png">

	<link rel="shortcut icon" href="images/favicon.ico">
	<title>Your Order - Confirmation and Response - Just-FastFood</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />

	<link href="css/iphone.css" rel="stylesheet" type="text/css" media="only screen and (min-width: 0px) and (max-width: 320px)" >
	<link href="css/ipad.css" rel="stylesheet" type="text/css"  media="only screen and (min-width: 321px) and (max-width: 768px)" >


	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/validate.js"></script>
	<script type="text/javascript" src="js/mobileMenu.js"></script>
	<script type="text/javascript" src="js/script.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#main-nav').mobileMenu();
		});
		<?php if($return_status == 'false') {?>
		var time = 1;
		var sec;
		load();

		function load(){
			$.ajax({
				  type: "POST",
				  url: 'include/order-check.php',
				  data: { ID : <?php echo $_SESSION['CURRENT_ORDER_ID']?>},
				  success: function(data) {
					if(data == 'false'){

						if(time == 100) {
							//clearInterval(sec);
							$('.order-complete-wrap  .order-loading img').hide();
							$('.order-complete-wrap  .order-loading .ltext').hide();
							$('.order-complete-wrap  .order-loading .txt-center').append('Restaurant is busy at the moment... You will be notified once your order is accepted');
							//window.setTimeout(function() {window.location.href = 'order-complete.php';},5000);
						} else {
							$('.order-complete-wrap  .order-loading .loading-90 div').css('width', time + '%');
							$('.order-complete-wrap .ltext').text(time+'% Complete');
						}

						sec = window.setTimeout('load()',1000);
						time ++;
					} else {
						time = 100;
						$('.order-complete-wrap .ltext').text('100% Complete');
						window.setTimeout(function() {window.location.href = 'order-complete.php';},800);

					}
				  }
			});
		}
		<?php } ?>
	</script>
	<style type="text/css">
		.order-complete-wrap .current-status div {
			width: auto;
			font-size: 11px;
		}
		.order-complete-wrap .current-status {
			background-position: 40px center;
			padding-left: 122px;
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
					<li><a href="<?php echo $_SESSION['CURRENT_MENU']?>"><?php echo $_SESSION['CURRENT_MENU']?></a></li>
					<li><a href="order-details.php">Delivery Address</a></li>
					<li class="u">Order Complete</li>
				</ul>
			</div>

			<div class="MENU">
				<?php
					$query_location = $obj -> query_db("SELECT * FROM `location`,`menu_type` WHERE location.location_menu_id = '".$_SESSION['DELIVERY_REST_ID']."' AND  menu_type.type_id = '".$_SESSION['DELIVERY_REST_ID']."'");
					$locationObj = $obj -> fetch_db_assoc($query_location);
					$oph = json_decode($locationObj['type_opening_hours'] ,true);
					$type_special_offer = json_decode($locationObj['type_special_offer'] ,true);
				?>
				<div class="todayTime txt-right"><?php echo date("l, j F Y, h:i A")?></div>
				<div class="box-wrap menu-details">
					<div class="fl-left img">
						<img src="items-pictures/<?php echo $locationObj['type_picture'];?>" alt=""/>
					</div>
					<div class="fl-left details">
						<h1><?php echo $locationObj['type_name'];?> <span><?php echo $locationObj['location_city'];?></span></h1>
						<strong>Opening Hours</strong><br>
						<ul>
							<li class="i"><label for=""><?php echo date('l');?>:</label><?php echo  $oph[date('l')]['From'] . ' - ' .$oph[date('l')]['To']?></li>
							<li style="color:gray"><label for=""><?php echo date('l', time()+86400)?>:</label><?php echo  $oph[date('l', time()+86400)]['From'] . ' - ' .$oph[date('l')]['To']?></li>
						</ul>
						<a href="oph.php?id=<?php echo $_SESSION['DELIVERY_REST_ID']?>/?iframe=true&amp;width=300&amp;height=300" rel="prettyPhoto" class="showMore u"> View all opening times</a>
					</div>
					<div class="clr"></div>
					<?php
						if($type_special_offer != "") {
							echo '<div class="special-offer"><strong>';
							echo $type_special_offer['off']. ' % off today on orders over &pound; '.$type_special_offer['pound'];
							echo '</strong></div>';
						}
					?>
				</div>
			</div>

			<div class="box-wrap" style="margin-top:20px;">
				<div class="order-complete-wrap">
					<h5>Your Order is being sent to our drivers</h5><!--<?php echo $locationObj['type_name'];?></h5>-->
					<hr class="hr" />
					<div class="order-comp">
						<p>
							<span >Your Order ID : </span><strong><?php echo $_SESSION['CURRENT_ORDER_ID'];?></strong>
						</p>
						<p>
							<span>Your Transaction ID : </span><strong><?php echo $_SESSION['ORDER_TRANSACTION_DETAILS']['TRANSACTIONID'];?></strong>
						</p>
					</div>
					<hr class="hr" />
					<?php if($return_status == 'true') {?>
					<div>
						<h1 class="subheading txt-center">
							Thank You </span><strong><?php echo $_SESSION['user'];?></strong>!</p> Please check your order status below.
						</h1>
						<div class="cbox-wrap  current-status">
							<div class="fl-left">
								<p><span>Order Status :</span> <strong>Accepted</strong></p>
								<p><span>Time Accepted : </span><strong><?php echo date('l, F t, Y h:i:s A' ,strtotime($result_order['order_acceptence_time']));?></strong></p>
								<?php
									$_SESSION['delivery_type'] = json_decode($_SESSION['delivery_type'] , true);
								?>
								<?php if($_SESSION['delivery_type']['time'] == "ASAP") {?>
								<p>
									<span>Estimated Time Delivery  : </span>
									<strong>
										<?php echo date('h:i A' ,strtotime($result_order['order_acceptence_time']) + $estimated_menu_time['type_time']*60) .' (' .$estimated_menu_time['type_time'] .' minutes aprox)';?>
									</strong>
								</p>
								<?php } ?>
							</div>
							<div class="fl-left">
								<p><span>Order Type : </span><strong style="text-transform: capitalize;"><?php echo $_SESSION['delivery_type']['type'] .'  '.$_SESSION['delivery_type']['time']?></strong></p>
								<p><span>Payment Method : </span><strong style="text-transform: capitalize;"><?php echo ($_SESSION['CHECKOUT_WITH'] == 'By Card') ? 'Card Payment' : $_SESSION['CHECKOUT_WITH'];?></strong></p>
							</div>
							<div class="clr"></div>
							<p style="padding-left:200px;" class="order-its-way">You order is on its way!</p>
						</div>
					</div>
					<?php } else if($return_status == 'cancel'){?>
					<div class="order-loading">
						<div class="cbox-wrap txt-center" style="font-family: rockwellregular">
							<h2>Our Apologies! Your order cannot be processed at this time.<br> Our delivery drivers are currently busy fulfilling orders <br>Please try again in a little while</h2>
							<p>A full refund has been applied to your account.</p>
							<p>For more details please contact us via our Live Chat or email us your Order ID</p>
						</div>
					</div>
					<?php } else {?>
					<div class="order-loading">
						<div class="cbox-wrap txt-center" style="font-family: rockwellregular">
							<h2>We're sending your order . . . <br/> Please wait for confirmation to ensure order acceptance! </h2>
							<!--<div class="loading-90"><div></div></div>-->
							<img src="include/Images/Ajax_Loading.gif" alt="" style="width:110px; "/>
							<div class="ltext"></div>
							<p style="text-center">IMPORTANT: Direct response can take up to 90 seconds</p>
						</div>
					</div>
					<?php } ?>
					<?php
						if($return_status != 'false') {
						$session_user = $_SESSION['user'];
						$session_id = $_SESSION['userId'];
						$cokiee_enabled = $_SESSION['cokiee_enabled'];

						foreach($_SESSION as $k => $v){
							unset($_SESSION[$k]);
						}

						$_SESSION['user'] = $session_user;
						$_SESSION['userId'] = $session_id;
						$_SESSION['cokiee_enabled'] = $cokiee_enabled;
					?>

					<div class="txt-right" style="margin-top:20px;">
						<a href="my-profile.php" class="btn">Continue</a>
					</div>
					<?php } ?>
				</div>
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