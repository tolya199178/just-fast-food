<div class="wrapper show_cookie_box_p">
	<div class="show_cookie_box">
		Do you want to show cookie information?
		<a href="javascript:;" id="c_OK">OK</a>
		<a href="javascript:;" id="c_cancl">Close</a>
	</div>
</div>
<div class="chat-wrap">
	<div class="header-wrap borderradius">CHAT ONLINE</div>
</div>
<div class="wrapper">
	<div class="fl-left" >
		<div class="logo">
			<h1>
				<!--<img src="images/logo3.png" class="fl-left">-->
				<a href="index.php" style="">
					Just-FastFood
					<span>Order Your Favourite Fast Food &amp; Takeaways Online</span>
				</a>
			</h1>
		</div>
	</div>
	<div class="fl-right">
		<div class="navigation">
			<?php
				if(isset($_SESSION['user'])) {
					//echo 'Welcome: <a href="my-profile.php" class="my-profile" title="Go to My Profile">'.$_SESSION['user'].'</a></span> ';
				}
			?>
			<div class="fl-right need-help-wrap">
				<div class="fl-left">
					<a href="own-restaurant.php" class="needhelp">Do You Own a Restaurant?</a>
					<div class="textneed">Join us NOW<span> Get more business...</span></div>
				</div>

				<div class="fl-left"><a href="feedback.php?iframe=true&amp;width=600&amp;height=550" class="needhelp" rel="prettyPhoto">Feedback</a>
					<div class="textneed">Send us your feedback</div>
				</div>
				<div class="clr"></div>
			</div>
			<div class="fl-left top-navigation">
				<?php
					if(isset($_SESSION['user'])) {
						if(isset($_SESSION['user_type'])){
							echo 'Welcome: <a href="staff-profile.php" class="my-profile" title="Go to My Profile (staff)">'.$_SESSION['user'].'</a></span> ';
						} else {
							echo 'Welcome: <a href="my-profile.php" class="my-profile" title="Go to My Profile">'.$_SESSION['user'].'</a></span> ';
						}
					}
				?>
			</div>
			<div class="clr"></div>
		</div>
	</div>
	<div class="clr"></div>
	<div class="navmenue">
	<div class="text-cookie">
		<?php
			if(showC('user') && !isset($_SESSION['user'])) {
				echo 'Welcome : <b>'.showC('user').'</b>';
			}
		?>
	</div>
	<div class="nav" style="display:block">
		<div class="fl-right ">
				<ul>
					<?php
						if(isset($_SESSION['user'])) {
							echo '<li class="menu"><a href="include/signout.php" class="signout mlink" title="Sign Out">Signout</a></li>';
						} else {
					?>
					<li  class="menu"><a href="login.php" class="mlink" title="Login" style="border-top-left-radius:0px;">Login</a>
						<div class="submenu" style="right: -84px; width: 296px; min-width: 0px;">
							<form action="login.php" method="post" id="loginForm" class="login-wrap" style="width:100%">
								<div class="row">
									<h2 class="txt-center" style="font-size:18px">Login</h2>
								</div>
								<div class="row">
									<label for="user_email0" class="">Email Address</label><input type="text" name="user_email" id="user_email0" class="input required email"  value="" style="width:97%"/>
								</div>
								<div class="row">
									<label for="user_password"  class="">Password</label><input type="password" name="user_password" id="user_password0" class="input required"  style="width:97%"/>
								</div>
								<div class="row txt-right">
									<input type="submit" value="Login" name="LOGIN" class="btn"/>
									<input type="hidden" name="backURL" value="<?php if(isset($_SERVER['HTTP_REFERER'])) { echo htmlspecialchars($_SERVER['HTTP_REFERER']); } else { echo 'index.php';}?>"/>
									<input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
								</div>
								<div class="row can-not">
									<a href="forgot-password.php?iframe=true&amp;width=600&amp;height=550" class=""  rel="prettyPhoto">Can't access your account</a>
								</div>
							</form>
							<script type="text/javascript">
								$(document).ready(function(){
									$("#loginForm").validate();
								});
							</script>
						</div>
					</li>
					<li class="menu"><a href="signup.php?iframe=true&amp;width=600&amp;height=550"  rel="prettyPhoto" class=" mlink" title="Signup">Signup</a></li>
					<?php
						}
					?>
				</ul>
			</div>
		<ul>
			<li class="menu"><a href="index.php" class="mlink">Home</a></li>
			<li  class="menu"><a href="what-we-do.php"  class="mlink">What We Do</a></li>
			<li  class="menu"><a href="how-it-works.php"  class="mlink">How It Works</a></li>
			<li  class="menu"><a href="#" class="mlink">Restaurants</a>
				<div class="submenu" style="width: 402px; min-width: 0px; font-size:13px;">
					<div class="fl-left col" style="width:200px;">
						<h4>Fastfood</h4>
						<ul>
						<?php
							$query = "SELECT `type_id`,`type_name`,`type_category` FROM `menu_type` WHERE `type_category`= 'fastfood'";
							$valueOBJ = $obj->query_db($query);
							while($res = $obj->fetch_db_assoc($valueOBJ)) {
								echo '<li><a href="#?custom=true&amp;width=425&amp;height=150" rel="'.$res['type_id'].'|'.$res['type_category'].'">'.$res['type_name'].'</a></li>';
							}
						?>
						</ul>
					</div>
					<div class="fl-left col" style="width:200px; border-right:none">
						<h4>Takeaways</h4>
						<ul>
						<?php
							$query = "SELECT `type_id`,`type_name`,`type_category` FROM `menu_type` WHERE `type_category`= 'takeaway'";
							$valueOBJ = $obj->query_db($query);
							while($res = $obj->fetch_db_assoc($valueOBJ)) {
								echo '<li><a href="#?custom=true&amp;width=425&amp;height=150" rel="'.$res['type_id'].'|'.$res['type_category'].'">'.$res['type_name'].'</a></li>';
							}
						?>
						</ul>
					</div>
					<div class="clr"></div>
				</div>
			</li>
			<li  class="menu"><a href="contact-us.php" class="mlink">Contat Us</a></li>
		</ul>
	</div>
	<div class="showNavigation" style="font-size: 11px; text-align: right;"><a href="javascript:;" style="cursor:pointer; ">&nbsp;</a></div>
	</div>

</div>
<div class="home-search-pop" style="display:none">
	<div class=" box-wrap">
		<div class="postcodeSearch">
			<form action="javascript:;" method="post" class="order-search1" name="post1"  style="padding:17px;">
				<label for="postcode">Enter Your Post Code :<br></label>
				<input type="text" name="ukpostcode" id="postcode" class="text required postcode" placeholder=""/>
				<input type="button" value="Search" name="submit" class="sbtn"/>
				<div class="clr"></div>
			</form>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.postcodeSearch .order-search1 .sbtn').live('click',function(){

				var val = $(this).prev().val();
				if(val != "" && (/^([A-PR-UWYZ0-9][A-HK-Y0-9][AEHMNPRTVXY0-9]?[ABEHMNPRVWXY0-9]? {1,2}[0-9][ABD-HJLN-UW-Z]{2}|GIR 0AA)$/i.test(val))) {
					val = val.replace(' ','-');
					window.location.href = 'loadRestaurant.php?id='+CURRRENT_REST_ID+'&postcode='+val+'&name='+NAME+'&cat='+CURRRENT_REST_CAT;
				} else {
					alert('UK postcode not Valid!')
				}
			});
		});
	</script>
</div>
<script type="text/javascript">
		var CURRRENT_REST_ID = "";
		var CURRRENT_REST_CAT = "";
		var CURRRENT_REST = "";
		var NAME = "";
		var STR = "";
		$(document).ready(function(){

			$(".nav .submenu .col ul li a").click(function(){
				CURRRENT_REST = $(this).attr('rel').split('|');
				CURRRENT_REST_ID = CURRRENT_REST[0];
				CURRRENT_REST_CAT = CURRRENT_REST[1];
				NAME = ($(this).text()).replace(' ','-');
			}).prettyPhoto({
				deeplinking : false,
				custom_markup: $('.home-search-pop').html(),
			});

		});
</script>