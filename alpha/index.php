<?php
session_start();
include('include/functions.php');
/* foreach($_SESSION as $k => $v){
    unset($_SESSION[$k]);
} */

if(isset($_GET['c'])) {
    ($_GET['c'] == 'y') ?  $_SESSION['cokiee_enabled'] = 'true' : $_SESSION['cokiee_enabled'] = 'false';
    header('location:/');
    die();
}



?>


<!DOCTYPE HTML>
<html lang="en-GB" class="no-js" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="content-language" content="en-GB">
    <meta name="author" content="Just-FastFood">
    <meta name="description" content="<?= getDataFromTable('setting','meta'); ?>">
    <meta name="keywords" content="<?= getDataFromTable('items','keywords'); ?>">
    <meta name="robots" content="index,follow">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="apple-touch-icon" href="items-pictures/default_rest_img.png">

    <link rel="shortcut icon" href="images/favicon.ico">
    <title>
        Order FastFood Online - Food Delivered In Minutes - Takeaway</title>
    <link rel="stylesheet" href="css/style1.css" />
    <link rel="stylesheet" href="css/ticker-style.css" />
    <link rel="stylesheet" href="css/fancybox/jquery.fancybox.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />

    <link href="css/iphone.css" rel="stylesheet" type="text/css" media="only screen and (min-width: 0px) and (max-width: 320px)" >
    <link href="css/ipad.css" rel="stylesheet" type="text/css"  media="only screen and (min-width: 321px) and (max-width: 768px)" >

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.cycle.all.min.js"></script>
    <script type="text/javascript" src="js/validate.js"></script>
    <script type="text/javascript" src="js/script1.js"></script>
    <script type="text/javascript" src="js/modernizr.js"></script>
    <script type="text/javascript" src="css/fancybox/jquery.fancybox.js"></script>

    <script type="text/javascript" src="js/jquery.vticker-min.js"></script>
    <script type="text/javascript" src="js/jquery.ticker.js"></script>
    <script type="text/javascript" src="js/jcarousellite_1.0.1.pack.js"></script>
    <script type="text/javascript" src="js/mobileMenu.js"></script>

    <script type="text/javascript">
        $(function() {

            $("#postcode.text").bind("mouseover", highlight);
            $("#postcode.text").bind("mouseleave", highlight);
        });
        function highlight(evt) {
            $("#postcode.text").toggleClass("highlighted");

        }
    </script>




    <script type="text/javascript">
        $(document).ready(function(){

            //  initialize();

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            var newVal = document.getElementById('')
        })
    </script>

    <script type="text/javascript">

        $(document).ready(function(){

            $(".home-search-box").validate({

                submitHandler: function(form) {
                    var val = document.post.ukpostcode.value;
                    /* var first3 = val.substr(0,3);
                     var lastPartx = val.substr(3,val.length);
                     val = first3+'-'+lastPartx; */
                    val = val.replace(' ','-');
                    window.location.href = 'Postcode-'+val;
                    //console.log(val);
                    return false;
                },



                rules: {
                    ukpostcode	: "required"
                },
                messages: {
                    ukpostcode: "Post Code Entered Not Valid"
                },


                errorPlacement: function ($error, $element) {
                    if ($element.attr("name") == "ukpostcode") {
                        $error.insertAfter($element.next().next());
                    } else {
                        $error.insertAfter($element);
                    }
                }
            });

            $('.slider').cycle({
                fx:     'fade',
                speed:  1500,
                timeout: 4000,
                pause:  1
            });


            $('input#postcode').focus();
            $(".pop_box").fancybox();
            /* $('.marque').ticker(); */

            <?php if(isset($_SESSION['cokiee_enabled']) && $_SESSION['cokiee_enabled'] == 'true'){ ?>
            var C_POSTCODE = "<?= showC('postcode')?>";
            $('.postcodeSearch .text').val(C_POSTCODE).focus();
            $('.text-cookie').fadeIn('slow');
            <?php } ?>

            <?php if(!isset($_SESSION['cokiee_enabled'])){ ?>
            /* $('.show_cookie_box #c_OK').live('click',function(){
             window.location = 'index.php?c=y';
             });

             $('.show_cookie_box #c_cancl').live('click',function(){
             window.location = 'index.php?c=n';
             }); */
            <?php } ?>

            $('#main-nav').mobileMenu();
        })

        <?php if(!isset($_SESSION['cokiee_enabled'])){ ?>
        /* window.onload = function() {
         $('.show_cookie_box_p').slideDown();
         window.setTimeout('hideCookieBox()',10000);
         } */
        <?php } ?>

        function hideCookieBox() {
            $('.show_cookie_box_p').slideUp();
        }

    </script>
    <style type="text/css">
        .marque{
            padding:2px 2px 2px 2px;
            color:#D62725;
            font-size:14px;
            font-weight:lighter;
            font-family: "segoe ui";
        }
        .marque ul{
            list-style-type:none;
        }
        .highlighted {
            background-color: #f8fa84;
        }
        .shadow {
            -moz-box-shadow: 0 0 5px rgba(0,0,0,0.5);
            -webkit-box-shadow: 0 0 5px rgba(0,0,0,0.5);
            box-shadow: 0 0 5px rgba(0,0,0,0.5);
        }
        .postcodeSearch .text {
            font-family: segoe ui;
            font-weight: lighter;
            font-size: 35px;
        }
        .welcomeMsg{
            padding: 25px;
            font-size: 17px;
            position: relative;
            font-family: segoe ui;
            font-weight: lighter;
            margin-bottom: 20px;
        }
        .welcomeMsg .close{
            background:url('images/cross.png') no-repeat top right;
            width:18px;
            height:18px;
            float:right;
            cursor:pointer;
        }
    </style>
    <!--[if IE 8]>
    <style type="text/css">
        .box-radius{
            behavior: url(ie-css3.htc);
        }
    </style>
    <![endif]-->
</head>
<body class="home">
<div class="header">
    <?php require('templates/header.php');?>
</div>

<div class="content">
    <div class="wrapper" style="font-family: segoe ui; font-weight: 300">
        <?php include('templates/welcomeMsg.php'); ?>
        <!--<marquee direction="center"  class="marque" width="623px">
            We currently cover the following cities: Portsmouth | Cosham | Havant | Fareham & Southampton ... Coming to a city near you soon.
        </marquee>-->
        <div class="fl-right" style="width: 340px; overflow: hidden;">
            <div class="postcodeSearch" style="font-family: segoe ui; font-weight: lighter">
                <form action="" method="post" id="order-search" class="home-search-box" name="post"  style="padding:17px;">
                    <label for="postcode" style="font-family: segoe ui; font-weight: 400">FastFood & Takeaways in your area<br><span >Enter your postcode e.g PO5 4LN</span></label>
                    <input type="text" name="ukpostcode" id="postcode" class="text required postcode" style="font-family: segoe ui; font-weight: lighter; font-size: 14px" value="" placeholder="Enter Your Post Code Here"/>
                    <input type="submit" value="Search" name="submit" class="sbtn" style="font-family: rockwellregular"/>
                    <div class="clr"></div>
                </form>
            </div>
            <div class="borderLight noCash-wrap" style="margin-top:10px; margin-left:20px; padding: 2px;">
                <div class="box noCash-w" id="news_feed">
                    <ul>
                        <li>
                            <div class="nocash" style="padding-top:25px; font-family: segoe ui; font-weight: 200">NO CASH?<br> NO PROBLEM!<br><b>PAY BY CARD</b><br> PAYPAL</b><br/></div>
                            <img src="images/visadb.bmp" alt="" style="width:60px; height:40px; padding-right:7px; padding-left: 20px;"/><img src="images/38.gif" alt="" />
                        </li>
                        <li>
                            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                            <a class="twitter-timeline"  href="https://twitter.com/JustFastFood" data-widget-id="274119642040115200"></a>
                        </li>
                        <li>
                            <iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FJust-FastFood%2F475488035817059&amp;width=314&amp;height=290&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;border_color=%23ffffff&amp;header=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:314px; height:290px;" allowTransparency="true"></iframe>
                        </li>
                        <li>
                            <div id="fb-root"></div>
                            <script>(function(d, s, id)
                                {
                                    var js, fjs = d.getElementsByTagName(s)[0];
                                    if (d.getElementById(id)) return;
                                    js = d.createElement(s); js.id = id;
                                    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                                    fjs.parentNode.insertBefore(js, fjs);
                                }
                                    (document, 'script', 'facebook-jssdk'));
                            </script>
                            <div class="fb-comments" data-href="http://just-fastfood.com" data-num-posts="2" data-width="314" style="height:245px; border:none; overflow:hidden;"></div>
                        </li>
                        <li style="height:245px;" class="txt-center"><img src="images/41268133.png" alt="" style="padding-top: 60px;"/></li>
                    </ul>
                </div>
            </div>
            <div class="borderLight right-comment-wrap" style="margin-top:10px; margin-left:20px; padding:5px; height:256px">
                <div class="box right-comment">
                    <div class="cart box-wrap box-radius" style="margin:0px; border:none">
                        <div class="header-wrp" style="font-family: segoe ui; font-weight: 200; font-size: 14px; text-align: center">Latest Orders &amp; Updates</div>
                        <div class="news_feed" >
                            <div id="news_feed1">
                                <ul>
                                    <?php
                                    $query = "SELECT `user_screen_name`,`order_total`,`order_details`,`order_date_added`,`order_acceptence_time` FROM `orders`,`user` WHERE orders.order_status = 'complete' AND orders.order_user_id = user.id  ORDER BY orders.order_date_added DESC LIMIT 0 , 10";
                                    $valueOBJ = $obj->query_db($query);
                                    $odd = 0;
                                    while($res = $obj->fetch_db_array($valueOBJ)) {

                                        ?>
                                        <li class="<?php echo($odd%2) ? 'odd':'even' ?>">
                                            <div>
                                                <div class="feed order-feed" style="font-family: rockwellregular; font-size: 11px; text-decoration-color: #bfddf3">
                                                    <span class="i"><?php echo ($res['user_screen_name'] != '') ?  $res['user_screen_name'] : 'Customer '?> Ordered: </span>
                                                    <?php
                                                    $Array = json_decode($res['order_details'] ,true);
                                                    echo '<span class="list-details" >';
                                                    foreach($Array as $key => $val) {

                                                        if($key != 'TOTAL') {

                                                            echo $val['QTY'] . 'x '.$val['NAME'] .',';
                                                        }

                                                    }
                                                    echo ' at '. date('g:i a D M Y', strtotime($res['order_acceptence_time']));
                                                    echo '</span>';
                                                    ?>
                                                </div>

                                            </div>
                                        </li>
                                        <?php
                                        $odd++;
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fl-left" style="width: 628px; overflow: hidden;">
            <div class="borderLight sliderWrap" style="padding:5px">
                <div class="slider">
                    <?php
                    $query = "SELECT `slider_picture` FROM `slider` WHERE `slider_type` = 'left' AND `slider_status` = 'active'";
                    $valueOBJ = $obj->query_db($query) or die(mysql_error());;
                    while($res = $obj->fetch_db_array($valueOBJ)) {
                        ?>
                        <img src="items-pictures/<?php echo $res['slider_picture']?>" alt="<?php echo $res['slider_picture']?>" class=""/>
                    <?php
                    }
                    ?>
                </div>
            </div>


            <div class="fl-left takeaddedTodayWrap" >
                <div class="borderLight"  style="margin-top:10px;">
                    <div class="takeaddedToday box" style="font-family: segoe ui; font-weight: lighter; font-size: 15px; color: #1b0817">
                        <h2>Takeaways & Fastfood added today</h2>
                        <div class="con fl-left" id="addTakeaway" >
                            <ul style="border-right:1px solid #ddd">
                                <li>McDonalds<div>In Fratton PO5 </div></li>
                                <li>Burger King<div>In Commercial Rd PO4</div></li>
                               <li>McDonalds<div>In London SW3</div></li>
                                <li>KFC<div>In Commercial Rd PO4</div></li>
                            </ul>
                        </div>

                        <div class="con fl-left">
                            <ul style="padding-left:10px; font-family: segoe ui; font-weight: lighter; font-size: 15px; color: #1b0817">
                                <li>Subway<div>In Commercial Rd PO4</div></li>
                                <li>Ocean Swell - Fish & Chips<div>In Copnor Rd PO2</div></li>
                                <li>Alpha Amazing<div>In Southea PO5</div></li>
                                <li>Fortune<div>In Southsea PO5</div></li>
                            </ul>
                        </div>
                        <div class="clr"></div>
                    </div>
                </div>
            </div>
            <div class="fl-left">
                <div class="borderLight"  style="margin-top:10px; margin-left:10px">
                    <div class="box slider-ww takeaddedToday" style="font-family: segoe ui; font-weight: lighter; font-size: 15px">
                        <h2 style="text-align: center">4 Easy Steps</h2>
                        <div class="cont">
                            <ul>
                                <li>
                                    <div class="no">1</div>
                                    <div class="text">Enter Your Postcode</div>
                                </li>
                                <li>
                                    <div class="no">2</div>
                                    <div class="text">Pick a Fastfood or Takeaway</div>
                                </li>
                                <li>
                                    <div class="no">3</div>
                                    <div class="text">Order and Pay</div>
                                </li>
                                <li>
                                    <div class="no">4</div>
                                    <div class="text">Your Food On Its Way!</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clr"></div>
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


<script src="https://maps.google.com/maps?file=api&amp;v=2&amp;key=AIzaSyBReUANbeQ7hbO-ewBbT9PE6GWf0PsGxiE&sensor=false" type="text/javascript"></script>
<script src="https://www.google.com/uds/api?file=uds.js&v=1.0&key=AIzaSyBReUANbeQ7hbO-ewBbT9PE6GWf0PsGxiE&sensor=false" type="text/javascript"></script>
<script type="text/javascript">
    var map;
    var localSearch = new GlocalSearch();

    function usePointFromPostcode(postcode, callbackFunction)
    {
        localSearch.setSearchCompleteCallback(null,
            function() {
                if(localSearch.result[0]) {
                    var resultLat = localSearch.result[0].latitude;
                    var resultLng = localSearch.result[0].longitude;
                    var point = new GLatLng(resultLat,resultLng);
                    callbackFunction(point);
                }else {
                    alert("Postcode not found!");
                }
            });
        localSearch.execute(postcode + ", UK")
    }
</script>


<script type="text/javascript">
    $(document).ready(function(){
        $(".even, .odd, .text, .no").each(function(){
            $(this).hover(function(){
                $(this).toggleClass('shadow');
            });
        })
    });
</script>
<!--<script src="https://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
<script src="js/jquery.geocomplete.js"></script>
<script type="text/javascript">

    $(document).ready(function() {
     $("#postcode.text").geocomplete({
        type : [('cities')],
         componentRestrictions: {country: 'uk'}

     });
        $("#postcode.text").trigger("geocode")
    });
</script>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places&language=en-UK"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var options = {
            types : ['(region)'],
            componentRestrictions: {country: 'uk'
            }
        };
        var autocomplete = new google.map.places.AutoComplete($("#postcode.text")[0], options);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            console.log(place.address_components);
        });
    });

</script> -->