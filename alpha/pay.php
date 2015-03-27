<?php
session_start();

/* if($_POST['access'] != $_SESSION['access_key']){
    header('Location:index.php');
    die();
} */

// CARD POCESSING
if(isset($_POST['stripeToken'])) {
    $_SESSION['CARD_PROCESSING'] = $_POST;
    if(!empty($_POST['N_Addr'])) {
        $_SESSION['CARD_PROCESSING']['address'] = $_POST['N_Addr'];
        $_SESSION['CARD_PROCESSING']['postcode'] = $_POST['N_Postcode'];
    }
    header('Location:include/card/process.php');
    die();
}

include('include/functions.php');
$s = false;
$SET = array($_SESSION['access_key'] , $_SESSION['CART'] , $_SESSION['CURRENT_POSTCODE'], $_SESSION['type_min_order'], $_SESSION['CURRENT_MENU']);

$ERROR = false;
foreach($SET as $val) {
    if(!isset($val)) {
        $ERROR = true;
        break;
    }
}
if($ERROR){
    $_SESSION['error'] = "Session Key Expire. Please Try Again";
    header('Location:order-details.php');
    die();
}

if($_SESSION['CART_SUBTOTAL'] < $_SESSION['type_min_order']) {
    $_SESSION['error'] = "Minimum Order Amount Should Be &pound;".$_SESSION['type_min_order'];
    header('Location:'.$_SESSION['CURRENT_MENU']);
    die();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$_SESSION['PAY_POST_VALUE'] = $_POST;
}

if(!isset($_SESSION['user']) && !isset($_SESSION['userId'])){
    $ARRAY = array('user_name', 'user_password', 'user_email', 'user_phoneno', 'user_address', 'user_address_1', 'user_city', 'user_dob', 'user_hear', 'user_status');

    $json_post = getEandN($_SESSION['CURRENT_POSTCODE']);
    if($json_post) {

        $value = "NULL, ";
        foreach($ARRAY as $values) {
            if($values == "user_password") {
                $value .= "'".md5(mysql_real_escape_string($_POST[$values]))."', ";
            } else {
                $value .= "'".mysql_real_escape_string($_POST[$values])."', ";
            }
        }
        $value .= "NULL";
        $extra = "`user_email` = '".$_POST['user_email']."'";
        $result = INSERT($value ,'user' ,'unique' ,$extra);
        if(!$result) {
            $_SESSION['error'] = "Email Address Already Exist!";
            header('Location:order-details.php');
            die();
        } else {
            $select = "`id`,`user_email`,`user_password`,`user_name`";
            $where = "`user_email` = '".$_POST['user_email']."' AND `user_password` = '".md5($_POST['user_password'])."' AND `user_status` = 'active'";

            $result = SELECT($select ,$where, 'user', 'array');
            if($result) {
                $_SESSION['user'] = $result['user_name'];
                $_SESSION['userId'] = $result['id'];
            }
        }
    } else {
        $_SESSION['error']  = "ERROR!! Invalid Post Code. <span style='font-size:13px'>( Please enter only full UK postode)</span>";
        header('Location:order-details.php');
        die();
    }
}
//$_SESSION['CART_SUBTOTAL'] = $_SESSION['CART_SUBTOTAL'] + process_fee();
$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());

?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="images/favicon.ico">
    <title>Pay Order - Just-FastFood</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script type="text/javascript" src="js/validate.js"></script>
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">

        $(document).ready(function(){
			var Addr = '<?php echo $_SESSION['PAY_POST_VALUE']['user_address'] ?>';
			var Zip = '<?php echo $_SESSION['CURRENT_POSTCODE'] ?>';
            $("#pay-by-cradit-card").validate({
				submitHandler: function(form) {
					$('#submitBtn-card').attr("disabled", "disabled");
					$('#submitBtn-card').val('Sending ...');

					var ccNum = $('#card_no').val(), cvcNum = $('#csc').val(), expMonth = $('#MM').val(), expYear = $('#YYYY').val(), Name = $('#full_name').val();

					if($('#N_Addr').val() != ''){
						Addr = $('#N_Addr').val();
					}
					if($('#N_Postcode').val() != ''){
						Zip = $('#N_Postcode').val();
					}

					Stripe.setPublishableKey("pk_live_ilF5EvWx76sIw49zdNB8KNsG");
					Stripe.createToken({
						number: ccNum,
						cvc: cvcNum,
						exp_month: expMonth,
						exp_year: expYear,
						name : Name,
						address_line1 : Addr,
						address_zip : Zip
					}, stripeResponseHandler);

					//return false;
				}
			});
            $('#same_adrress').live('click',function() {
                if(!$(this).is(':checked')) {
                    $('p.notsameaddress').slideDown();
                } else {
                    $('p.notsameaddress').slideUp();
                }
            });
        });

		function stripeResponseHandler(status, response) {
			// Check for an error:
			if (response.error) {
				alert(response.error.message);
			} else { // No errors, submit the form:
			  var f = $("#pay-by-cradit-card");
			  // Token contains id, last4, and card type:
			  var token = response['id'];
			  // Insert the token into the form so it gets submitted to the server
			  f.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
			  // Submit the form:
			  f.get(0).submit();
			}
		}
    </script>
    <style type="text/css">
        p.notsameaddress{
            display:none;
        }
		.pay-by-cradit-card{
			display:block;
		}
		.pay-by-cradit-card .select{
			width:90px;
		}
    </style>
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
        <li><a href="<?php echo $_SESSION['CURRENT_MENU']?>"><?php echo $_SESSION['CURRENT_MENU']?></a></li>
        <li class="u">Confirm Payment</li>
        <!--   <li><a href="">Cancel This Order</a></li>-->
    </ul>
</div>
<?php include('include/notification.php');?>
<div class="fl-left">
    <div class="box-wrap">
        <div class="order-details-wrap">
            <div class="txt-center b">Order Details</div>
            <hr class="hr" />
            <div class="order pay">
                <ul>
                    <?php
                    $iii = 0;
                    foreach($_SESSION['CART'] as $key => $value) {
                        if($key != 'TOTAL') {
                            ?>
                            <li>
                                <div class="<?php echo ($iii %2 == 0) ? 'erow' : 'orow'?>">
                                    <span class="detail fl-left"><?php echo $value['QTY']; ?> x <?php echo $value['NAME']; ?></span>
                                    <div class="fl-right">
                                        <span>&pound; </span>
                                        <span class="p"><?php echo number_format($value['TOTAL'], 2); ?></span>
                                    </div>
                                    <div class="clr"></div>
                                </div>
                            </li>
                            <?php
                            $iii ++;
                        }
                    }
                    ?>
                </ul>
                <div class="txt-right total b">
                    <span>Total</span>
                    <span>&pound; <?php echo number_format($_SESSION['CART']['TOTAL'], 2); ?></span>
                </div>
                <div class="txt-right total">
                    <div class="row">
                        <span class="span">Delivery Charges : </span>
                        <span class="b">&pound; <?php echo number_format($_SESSION['DELIVERY_CHARGES'],2)?></span>
                    </div>
                    <div class="row">
                        <span class="span">Processing Fee : </span>
                        <span class="b">&pound; <?php echo process_fee()?></span>
                    </div>
                    <div class="row">
                        <span class="span">Discount : </span>
                        <span class="b">&pound; <?php echo number_format($_SESSION['SPECIAL_DISCOUNT'],2);?></span>
                    </div>
                </div>

                <div class="totalpay b">
                    <p class="fl-right">
                        <span class="">Sub Total : &nbsp;&nbsp;</span>
                        <span> &pound; </span><span class="p"><?php echo number_format(($_SESSION['CART_SUBTOTAL']+process_fee()),2);?></span>
                    </p>
                    <div class="clr"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="order-address box-wrap">
        <h3>Delivery Address</h3>
        <div class="txt-right u"><a href="order-details.php">Edit</a></div>
        <hr class="hr" />
        <p>
            <span class="b"><?php echo $_SESSION['PAY_POST_VALUE']['user_address'].' , '.$_POST['user_city']?></span>
        </p>
        <p>
            <span class="b"><?php echo $_SESSION['CURRENT_POSTCODE']?></span>
        </p>
        <p>
            <span>Phone No: </span><span class="b"><?php echo $_SESSION['PAY_POST_VALUE']['user_phoneno']?></span>
        </p>
        <div>
            <span>Order/Delivery Note :</span> <br/>
            <p class="i b"><?php echo $_SESSION['PAY_POST_VALUE']['order_note']?></p>
        </div>
    </div>
</div>
<div class="fl-left pay-detail">

    <div class=" login-wrap">
        <div class="inner-border">
            <div class="red-wrap" style="padding: 6px;">
                <h2 style="font-size: 18px;">How would you like to pay?</h2>
            </div>
            <!--<hr class="hr" />-->
            <?php include('include/notification.php');?>
				<div class="wrapper-pay-sel">
                        <div class="by-card b"><a href="javascript:;" class="slideupdown">Pay By Card *</a></div>
                        <form action="" class="pay-by-cradit-card" method="post" id="pay-by-cradit-card">
                            <p class="row txt-center">
                                <!--<label for="" >Card Type:</label>
                                <select name="" id="" class="select">
                                    <option value="">Visa	</option>
                                    <option value="">Mastercard </option>
                                    <option value="">Visa Debit </option>
                                    <option value="">Discover </option>
                                    <option value="">American Express </option>
                                </select>-->
                                <img src="images/c_card.png" alt="We process" />
                            </p>
                            <p class="row">
                                <label for="" >Card Number:</label>
                                <input type="text" name="card_no" id="card_no" class="input required creditcard" autocomplete="off" maxlength="20"/>
                            </p>
                            <div class="">
                                <label for="" >Expiry Date:</label>
                            </div>
                            <div class="fl-left" >
                                <select name="MM" id="MM" class="select required" style="margin-right:10px">
                                    <option value="">MM</option>
                                    <?php
                                    $month = array('01'=>'Jan', '02'=>'Feb' , '03'=>'Mar' ,'04'=>'Apr' ,'05'=>'May' , '06'=>'Jun' , '07'=>'Jul' , '08'=>'Aug' , '09'=>'Sep' , '10'=>'Oct' , '11'=>'Nov' ,'12'=>'Dec');
                                    foreach($month as $k => $m) {
                                        echo '<option value="'.$k.'">'.$k.' ('.$m.') </option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="fl-left">
                                <select name="YYYY" id="YYYY" class="select required">
                                    <option value="">YYYY</option>
                                    <?php
                                    $now = date('Y');
                                    for($i = $now ; $i < $now + 11 ; $i ++) {
                                        $y = substr($i, strlen($i)-2, 2);
                                        echo '<option value="'.$y.'">'.$i.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="clr"></div>
                            <p class="row">&nbsp;</p>
                            <div class="">
                                <label for="">Security number(CSC):</label>
                            </div>
                            <div class="fl-left">
                                <input type="text" name="csc" id="csc" class="input required number" autocomplete="off" maxlength="4"/>
                            </div>
                            <div class="fl-left">
                                <img src="images/card-last3digits.png" alt="" />
                                <span class="small">Last 3 digits of the number on the back of your card</span>
                            </div>
                            <div class="clr"></div>
                            <p class="row">&nbsp;</p>
                            <p class="row">
                                <label for="" >Name on Card:</label>
                                <input type="text" name="full_name" id="full_name" class="input full_name required" value="<?php echo $_SESSION['PAY_POST_VALUE']['user_name']?>"/>
                            </p>
                            <p class="row">
                                <input type="checkbox" name="same_adrress" checked="true" id="same_adrress"/><label for="" style="display:inline-block; width:auto;">Billing address the same as delivery address:</label>
                            </p>
                            <p class="row notsameaddress">
                                <label for="" >Address:</label>
                                <input type="text" name="N_Addr" id="N_Addr" class="input required"/>
                            </p>
                            <p class="row notsameaddress">
                                <label for="" >Postcode:</label>
                                <input type="text" name="N_Postcode" id="N_Postcode" class="input required" />
                            </p>
                            <p class="row txt-center">
                                <label for="" ></label>
                                <input type="submit" name="bycard" id="submitBtn-card" class="btn" value="Place my Order"/>
                                <input type="hidden" name="address" value="<?php echo $_SESSION['PAY_POST_VALUE']['user_address'].', '.$_SESSION['CURRENT_POSTCODE']?>"/>
                                <input type="hidden" name="postcode" value="<?php echo $_SESSION['CURRENT_POSTCODE']?>"/>
                                <input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
                            </p>
                            <div class="row" style="font-size:12px; padding-left:20px">
                                <span>* Card Processing Fee : <b>&pound; <?php echo process_fee()?></b></span>
                            </div>
                        </form>
                    </div>
           <div class="wrapper-pay-sel" style="display:block">
                <!--<div class="by-card b"><a href="javascript:;" class="slideupdown">Pay Cash On Delivery</a></div>
                <form action="include/cash-payment.php" method="post">
                    <p class="row">
                        <?php
                        if(is_user_cash_verified($_SESSION['userId']) == 'true') {
                            ?>
                            <input type='submit' name='submit' class="btn"  value="Pay by Cash"/>
                            <input type="hidden" name="user_address" value="<?php echo $_SESSION['PAY_POST_VALUE']['user_address'].', '.$_SESSION['CURRENT_POSTCODE']?>"/>
                            <input type="hidden" name="order_note" value="<?php echo $_SESSION['PAY_POST_VALUE']['order_note']?>"/>
                            <input type="hidden" name="user_phoneno" value="<?php echo $_SESSION['PAY_POST_VALUE']['user_phoneno']?>"/>
                        <?php } else {?>
                            *Cash Payment on Delivery Not Verified. <br/>  <br/>

                            <a href="cash-verify.php" class="btn">Verify Now</a>
                        <?php }?>
                    </p>
                </form>
            </div>
        </div>-->


        <div class="wrapper-pay-sel">
            <div class="by-card b bypaypal">
                <form action="include/paypal/process.php" method="post">
                    <input type='image' name='submit' src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif' border='0' align='top' alt='Check out with PayPal'/>
                    <input type="hidden" name="user_address" value="<?php echo $_SESSION['PAY_POST_VALUE']['user_address'].', '.$_SESSION['CURRENT_POSTCODE']?>"/>
                    <input type="hidden" name="order_note" value="<?php echo $_SESSION['PAY_POST_VALUE']['order_note']?>"/>
                    <input type="hidden" name="user_phoneno" value="<?php echo $_SESSION['PAY_POST_VALUE']['user_phoneno']?>"/>
                </form>
            </div>
        </div>
    </div>
            </div>

</div>
<div class="row" style="font-size:12px; padding-left:20px; padding-top:20px">
    <span>* Processing Fee  : <b>&pound; <?php echo process_fee()?></b></span><br>
</div>
</div>
<div class="clr"></div>
</div>
</div>
<div class="footer">
    <?php require('templates/footer.php');?>
</div>


<!-- www.SessionCam.com Client Integration v5.5 -->
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
<!-- SessionCam -->
</body>
</html>