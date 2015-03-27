<?php
	session_start();
	
	include("../include/functions.php");

	$_SESSION['access_key'] = md5(getRealIpAddr().rand().rand());
	
	$type = "";
	$p = "Admin Panel";
	$titlename = "Admin Username";
	if(isset($_GET['type']) && $_GET['type'] == 'partner') {
		$type = "partner";
		$titlename = "Partner Email Address";
		$p = "Partner Admin Panel";
	}
	
?>
<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8" />
		<link rel="shortcut icon" href="images/favicon.ico">
        <title>Just-FastFood - Admin</title>
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link href="css/zice.style.css" rel="stylesheet" type="text/css" />
        <link href="css/icon.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="components/tipsy/tipsy.css"
        media="all" />
        <style type="text/css">
            html {
                background-image: none;
            }
            #versionBar {
                background-color:#212121;
                position:fixed;
                width:100%;
                height:35px;
                bottom:0;
                left:0;
                text-align:center;
                line-height:35px;
            }
            .copyright {
                text-align:center;
                font-size:10px;
                color:#CCC;
            }
            .copyright a {
                color:#A31F1A;
                text-decoration:none
            }
        </style>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister"
        />
    </head>
    
    <body>
        <div id="alertMessage" class="error"></div>
        <div id="successLogin"></div>
        <div class="text_success">
            <img src="images/loadder/loader_green.gif" alt="ziceAdmin" /><span>Please wait</span>
        </div>
		<h1>(<?php echo $p; ?>)</h1>
        <div id="login">
            <div class="inner">
                <div class="logo">
                    <h1>Just-FastFood</h1>
                </div>
                <div class="userbox"></div>
                <div class="formLogin">
                    <form name="formLogin" id="formLogin" action="">
                        <div class="tip">
                            <input name="username" type="text" id="username_id" title="<?php echo $titlename; ?>" />
                        </div>
                        <div class="tip">
                            <input name="password" type="password" id="password" title="Password" />
                        </div>
                        <div style="padding:20px 0px 0px 0px ;">
                            <div style="float:right;padding:2px 0px ;">
                                <div>
                                    <ul class="uibutton-group">
                                        <li><a class="uibutton normal" href="javascript:;" id="but_login">Login</a>
											<input type="hidden" name="access" value="<?php echo $_SESSION['access_key']; ?>"/>
											<input type="hidden" name="type" value="<?php echo $type; ?>"/>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="clear"></div>
            <div class="shadow"></div>
        </div>
        <!--Login div-->
        <div class="clear"></div>
        <div id="versionBar">
            <div class="copyright">&copy; Copyright 2012 All Rights Reserved <span class="tip"><a  href="#" title="Just-FastFood Admin" >Just-FastFood</a> </span> 
            </div>
            <!-- // copyright-->
        </div>
        <!-- Link JScript-->
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="components/effect/jquery-jrumble.js"></script>
        <script type="text/javascript" src="components/ui/jquery.ui.min.js"></script>
        <script type="text/javascript" src="components/tipsy/jquery.tipsy.js"></script>
        <script type="text/javascript" src="js/login.js"></script>
    <script type="text/javascript">
adroll_adv_id = "JQVQA2EPTFBIVFRG4SDKBR";
adroll_pix_id = "O56HCPIZBJDYXNIE4XFZX2";
(function () {
var oldonload = window.onload;
window.onload = function(){
   __adroll_loaded=true;
   var scr = document.createElement("script");
   var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
   scr.setAttribute('async', 'true');
   scr.type = "text/javascript";
   scr.src = host + "/j/roundtrip.js";
   ((document.getElementsByTagName('head') || [null])[0] ||
    document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
   if(oldonload){oldonload()}};
}());
</script>

</body>

</html>