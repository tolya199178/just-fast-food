<?php
	session_start();

	include("include/functions.php");

	if(!isset($_SESSION['CURRENT_POSTCODE']) || !isset($_SESSION['CURRENT_MENU'])) {
		header('Location:index.php');
		die();
	}

	if($_SESSION['CART']['TOTAL'] < $_SESSION['type_min_order']) {
		$_SESSION['error'] = "Minimum Order Amount Should Be &pound;".$_SESSION['type_min_order'];
		header('Location:'.$_SESSION['CURRENT_MENU']);
		die();
	}

	$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());

	$ARRAY = array('user_name', 'user_password', 'user_email', 'user_phoneno', 'user_address', 'user_address_1', 'user_city', 'user_dob', 'user_hear','user_verified' ,'user_status');

	foreach($ARRAY as $v) {
		$ARRAYTEMP[$v] = '';
	}

	$user = false;
	if(isset($_SESSION['user'])) {
		$select = "*";
		$where = "`id` = '".$_SESSION['userId']."'";

		$result = SELECT($select ,$where, 'user', 'array');
		foreach($ARRAY as $v) {
			$ARRAYTEMP[$v] = $result[$v];
		}
		$user = true;
	} else if(isset($_SESSION['PAY_POST_VALUE'])) {
		foreach($ARRAY as $v) {
			$ARRAYTEMP[$v] = $_SESSION['PAY_POST_VALUE'][$v];
		}
	}
	$RETURN = isShopOpen($_SESSION['DELIVERY_REST_ID']);
	$RETURN = true;
	if($RETURN['if'] == 'false') {
		$_SESSION['error'] = "Sorry! We are not taking orders now. Opens At ".$RETURN['time']. "am. We apologize for the inconvenience!";
		$_SESSION['Staff_Not_Avialable'] = 'true';
	} else if(true){
		if($_SESSION['RESTAURANT_TYPE_CATEGORY'] == 'fastfood' && $_SESSION['delivery_type']['type'] == 'delivery') {
			$_SESSION['TO_STAFF_ID'] = toStaffId(getEandN($_SESSION['CURRENT_POSTCODE']), $_SESSION['CURRENT_POSTCODE']);
			if($_SESSION['TO_STAFF_ID']  == 'false') {
				$_SESSION['error'] = "Sorry! We are not able to process your order at this time. Our delivery drivers are currently busy fulfilling orders. We apologize for the inconvenience!";
				$_SESSION['Staff_Not_Avialable'] = 'true';
			} else {
				unset($_SESSION['Staff_Not_Avialable']);
			}
		} else {
				unset($_SESSION['Staff_Not_Avialable']);
		}
	} else {
		unset($_SESSION['Staff_Not_Avialable']);
	}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="Order Details, <?= getDataFromTable('setting','meta'); ?>">
	<meta name="keywords" content="Order Details, <?= getDataFromTable('setting','keywords'); ?>">
	<meta name="author" content="M Awais">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="apple-touch-icon" href="items-pictures/default_rest_img.png">

	<link rel="shortcut icon" href="images/favicon.ico">
	<title>Order Details - Just-FastFood</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/fancybox/jquery.fancybox.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />

	<link href="css/iphone.css" rel="stylesheet" type="text/css" media="only screen and (min-width: 0px) and (max-width: 320px)" >
	<link href="css/ipad.css" rel="stylesheet" type="text/css"  media="only screen and (min-width: 321px) and (max-width: 768px)" >

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/validate.js"></script>

	<script type="text/javascript" src="css/fancybox/jquery.fancybox.js"></script>
	<script type="text/javascript" src="js/mobileMenu.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#loginForm").validate();
			$("#signupForm").validate({
				rules:{
					cuser_password:{
						 equalTo: "#user_password"
					 },

                    user_email:{email: true},
                    user_screen_name   : {minlength:5},
                    user_password: {minlength:6},
                 //   user_phone : {minlength:11},
                    user_phone : {digits:true},
                   // user_name : {minlength: 7},
                    user_address: {minlength:8}
				},
                messages : {
                    user_email : "Please enter a valid email",
                    user_password : "Please fill in password",
                  //  user_name : "Please enter your full name",
                    user_address : "Please enter an address",
                    user_screen_name: "Please enter your screen name",
                    user_city : "Please enter your city",
                    user_postcode : "Please enter your postcode",
                    user_phone : "Please enter a valid phone number"
                },
				errorPlacement: function ($error, $element) {
					if ($element.attr("name") == "accept") {
						$error.insertAfter($element.next());
					} else {
						$error.insertAfter($element);
					}
				}
			});
			$(".pop_box").fancybox();

			$('.small .why-signup').hover(function() {
				$('.why-signup-text').show();
			}, function(){
				$('.why-signup-text').hide();
			});
			$('#main-nav').mobileMenu();
		});
	</script>
	<style type="text/css">
		.why-signup-text{
			position:absolute;
			top:18px;
			left:0px;
			background:#fff;
			padding:5px;
			display:none;
			border:1px solid #ddd;
			border-radius:3px;
			-moz-border-radius:3px;
			-webkit-border-radius:3px;

			-webkit-box-shadow: rgba(0, 0, 0, 0.5) 0 1px 3px 0;
			-moz-box-shadow: rgba(0, 0, 0, 0.5) 0 1px 3px 0;
			box-shadow: rgba(0, 0, 0, 0.5) 0 1px 3px 0;
		}
        .box-wrap {
            font-family: segoe ui;
            border-bottom-color: #00063f;

        }


        .shadow {
            -moz-box-shadow: 0 0 5px rgba(0,0,0,0.5);
            -webkit-box-shadow: 0 0 5px rgba(0,0,0,0.5);
            box-shadow: 0 0 5px rgba(0,0,0,0.5);
        }
	</style>
    <script type="text/javascript">
     $(document).ready(function(){
         $('.box-wrap').each(function(){
             $(this).hover(function(){
                 $(this).toggleClass('shadow')
             });
         });
     });
    </script>
</head>
<body>
	<div class="header">
		<?php require('templates/header.php');?>
	</div>
	<div class="content">
		<div class="wrapper ">
			<div class="breadcrum">
				<ul>
					<li><a href="index.php">Begin Search</a></li>
					<li><a href="Postcode-<?php echo str_replace(' ','-',$_SESSION['CURRENT_POSTCODE']); ?>">Postcode-<?php echo $_SESSION['CURRENT_POSTCODE']; ?></a></li>
					<li><a href="<?php echo $_SESSION['CURRENT_MENU']?>" class="u b">Add More</a></li>
				</ul>
			</div>
			<?php include('include/notification.php');?>
			<div class="fl-left login-wrap">
				<div class="box-wrap">
					<div class="order-details-wrap">
						<h4 class="title red txt-center" style="font-family: rockwellregular; text-underline-position: below">Your Order</h4>
						<hr class="hr" />
						<div class="order">
							<div class="order-cart-wrapper" style="font-family: rockwellregular; font-size: 13px"></div>
						</div>
					</div>
				</div>
				<?php
					if(!isset($_SESSION['user'])) {
				?>
				<div class="cbox-wrap margin-top">
					<form action="login.php" method="post" id="loginForm">
						<div class="row">
							<h2 style="font-family: rockwellregular">Login <img src="images/lock.png" alt="" /></h2>
							<p style="font-family: rockwellregular">Please enter your email address and password to sign in</p>
						</div>
						<div class="row">
							<label for="user_email0" class="b" style="font-family: rockwellregular">Email Address</label><input type="text" name="user_email" id="user_email0" class="input required email"/>
						</div>
						<div class="row">
							<label for="user_password1"  class="b" style="font-family: rockwellregular">Password</label><input type="password" name="user_password" id="user_password1" class="input required"/>
						</div>
						<div class="row txt-right">
							<input type="submit" value="Login" name="LOGIN" class="btn"/>
							<input type="hidden" name="backURL" value="order-details.php"/>
							<input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
						</div>
                        <div class="row can-not">
                            <a href="forgot-password.php?iframe=true&amp;width=600&amp;height=400" rel="prettyPhoto">Can't access your account</a>
                        </div>


					</form>
				</div>
				<?php } ?>
			</div>
			<div class="fl-left sign-up-wrap" style="">
				<div class="box-wrap">
					<form action="pay.php" method="post" id="signupForm">

						<?php
							if(!$user) {
						?>
						<div class="row">
							<div class="red-wrap"><h2 style="font-family: rockwellregular">No account?</h2></div>
							<p>Don't worry you can create one now before anyone notices</p>
							<p class="small txt-right" style="color:#D62725">Please note: input fields marked with a * are required fields.</p>
							<p class="small" style="position: relative;"><a href="javascript:;" class="why-signup"><span class="b red">Why Signup?</span></a><span class="why-signup-text">Get local offers by email every week, re-order saved meals in a few clicks, store your delivery address and build a list of your favourite local takeaways.</span></p>
						</div>
						<div class="row">
							<label for="user_email">Email Address<span>*</span></label><input type="text" name="user_email" id="user_email" class="input required email" value="<?php echo $ARRAYTEMP['user_email'];?>"/>
						</div>
						<div class="row">
							<label for="user_screen_name">Screen Name<span>*</span></label><input type="text" name="user_screen_name" id="user_screen_name" class="input valid" value="">
						</div>
						<div class="row">
							<label for="user_password">Password<span>*</span></label><input type="password" name="user_password" id="user_password" class="input required" />
						</div>
						<div class="row">
							<label for="cuser_password">Confirm Password<span>*</span></label><input type="password" name="cuser_password" id="cuser_password" class="input required"/>
							<input type="hidden" name="first_time" value="true"/>
						</div>
						<?php } else {?>
						<div class="row">
							<div class="red-wrap"><h2>Confirm?</h2></div>
							<p class="small txt-right" style="color:#D62725">Please note: input fields marked with a * are required fields.</p>
						</div>

						<?php
							}

						?>

						<div class="row">
							<label for="user_name">Full Name<span>*</span></label><input type="text" name="user_name" id="user_name" class="input required" value="<?php echo $ARRAYTEMP['user_name'];?>"/>
						</div>
						<div class="row">
							<label for="user_phone">Phone No<span>*</span></label><input type="text" name="user_phoneno" id="user_phoneno" class="input required" value="<?php echo $ARRAYTEMP['user_phoneno'];?>"/>
						</div>
						<!--<hr class="hr"/>
						<p class="small txt-center">Delivery address:</p>-->
						<div class="row">
							<label for="user_address">Address<span>*</span></label><input type="text" name="user_address" id="user_address" class="input required" value="<?php echo $ARRAYTEMP['user_address'];?>"/>
						</div>
						<div class="row">
							<label for="user_address_1">Address 1</label><input type="text" name="user_address_1" id="user_address_1" class="input" value="<?php echo $ARRAYTEMP['user_address_1'];?>"/>
						</div>
						<div class="row">
							<label for="user_city">City<span>*</span></label><input type="text" name="user_city" id="user_city" class="input required" value="<?php echo $ARRAYTEMP['user_city'];?>"/>
						</div>
						<div class="row">
							<label for="user_postcode">Post Code</label><?php echo $_SESSION['CURRENT_POSTCODE'];?>
						</div>
						<br/>
						<div class="row additional">
							<p>
								<span class="b red">Leave a note for the restaurant</span><br/> If you have any allergies or dietary requirements please specify this in the comments box. Also use the comments box if you want to leave a note about delivery for the delivery driver.
							</p>
							<textarea name="order_note" id="order_note" cols="49" rows="3" style="width:97%"></textarea>
						</div>
						<div class="row">
							<input type="hidden" name="user_dob" value=""/>
							<input type="hidden" name="user_status" value="active"/>
							<input type="hidden" name="user_hear" value=""/>
							<input type="hidden" name="user_verified" value=""/>
							<input type="hidden" name="order_notes" id="order_notes" value=""/>
							<input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
						</div>
						<div class="row">
							<input type="checkbox" name="accept" id="" class="required"/>
							<p class="" style="display:inline">I accept the <a href="terms.php" class="u pop_box red">terms and conditions</a> &amp; <a href="privacy.php" class="u pop_box red">privacy policy</a></p>
						</div>
						<div class="row txt-right">
							<input type="submit" value="Proceed" class="btn" name="PROCEED"/>
						</div>
					</form>
				</div>
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