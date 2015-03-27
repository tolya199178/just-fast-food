

<div class="chat-wrap">
	<div class="header-wrap">CHAT ONLINE</div>
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
				
				<div class="fl-left"><a href="feedback.php?iframe=true&amp;width=600&amp;height=550" rel="prettyPhoto" class="needhelp">Feedback</a>
					<div class="textneed">Send us your feedback</div>
				</div>
				<div class="clr"></div>
			</div>
			<div class="fl-left top-navigation">
				<?php
					if(isset($_SESSION['user'])) {
						echo 'Welcome: <a href="my-profile.php" class="my-profile" title="Go to My Profile">'.$_SESSION['user'].'</a></span> ';
					}
				?>
			</div>
			<div class="clr"></div>
		</div>
	</div>
	<div class="clr"></div>
	<div class="navmenue">
	<div class="nav" style="display:block">
		<div class="fl-right ">
				<ul>
					<?php
						if(isset($_SESSION['user'])) {
							echo '<li class="menu"><a href="include/signout.php" class="signout mlink" title="Sign Out">Signout</a></li>';
						} else {
					?>
					<li  class="menu"><a href="login.php" class="mlink" title="Login" style="border-top-left-radius:0px;">Login</a>
						<div class="wrapp" style="display:none">
							<form action="login.php" method="post" id="loginForm" class="login-wrap" style="width:100%">
								<div class="row">
									<h2>Login</h2>
								</div>
								<div class="row">
									<label for="user_email0" class="">Email Address</label><input type="text" name="user_email" id="user_email0" class="input required email"  value=""/>
								</div>
								<div class="row">
									<label for="user_password"  class="">Password</label><input type="password" name="user_password" id="user_password0" class="input required"/>
								</div>
								<div class="row txt-right">
									<input type="submit" value="Login" name="LOGIN" class="btn"/>
									<input type="hidden" name="backURL" value="<?php if(isset($_SERVER['HTTP_REFERER'])) { echo htmlspecialchars($_SERVER['HTTP_REFERER']); } else { echo 'index.php';}?>"/>
									<input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
								</div>
								<div class="row can-not">
									<a href="forgot-password.php">Can't access your account</a>
								</div>
							</form>
							<script type="text/javascript">
								$(document).ready(function(){
									$("#loginForm").validate();
								});
							</script>							
							<link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />							<script src="js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>							<script type="text/javascript">								$(document).ready(function(){									$("a[rel^='prettyPhoto']").prettyPhoto();								});							</script>
						</div>
					</li>
					<li class="menu"><a href="signup.php?iframe=true&width=600&height=550" class=" mlink" rel="prettyPhoto" title="Signup">Signup</a></li>
					<?php
						}
					?>
				</ul>
			</div>
		<ul>
			<li class="menu"><a href="" class="mlink">Food</a>
				<div class="submenu">
					<div class="fl-left col">
						<h3>Menu</h3>
						<ul>
							<li><a href="">Menu</a></li>
							<li><a href="">Burger</a></li>
							<li><a href="">Menu</a></li>
							<li><a href="">Menu</a></li>
							<li><a href="">Menu</a></li>
							<li><a href="">Menu</a></li>
						</ul>
					</div>
					<div class="fl-left col">
						<h3>Meal Bundles</h3>
						<ul>
							<li><a href="">Menu</a></li>
							<li><a href="">Burger</a></li>
							<li><a href="">Menu</a></li>
							<li><a href="">Menu</a></li>
							<li><a href="">Menu</a></li>
							<li><a href="">Menu</a></li>
						</ul>
					</div>
					<div class="fl-left col" style="border:none;">
						<h3>Food Quality</h3>
						<ul>
							<li><a href="">Menu</a></li>
							<li><a href="">Burger</a></li>
							<li><a href="">Menu</a></li>
							<li><a href="">Menu</a></li>
							<li><a href="">Menu</a></li>
							<li><a href="">Menu</a></li>
						</ul>
					</div>
					<div class="clr"></div>
				</div>
			</li>
			<li  class="menu"><a href=""  class="mlink">What We Do</a>
				<div class="submenu">
					<div class="fl-left col">
						<h3>Menu</h3>
						<ul>
							<li><a href="">Menu</a></li>
							<li><a href="">Burger</a></li>
							<li><a href="">Menu</a></li>
							<li><a href="">Menu</a></li>
							<li><a href="">Menu</a></li>
							<li><a href="">Menu</a></li>
						</ul>
					</div>
					<div class="fl-left col">
						<h3>Meal Bundles</h3>
						<ul>
							<li><a href="">Menu</a></li>
							<li><a href="">Burger</a></li>
							<li><a href="">Menu</a></li>
							<li><a href="">Menu</a></li>
							<li><a href="">Menu</a></li>
							<li><a href="">Menu</a></li>
						</ul>
					</div>
					<div class="fl-left col" style="border:none;">
						<h3>Food Quality</h3>
						<ul>
							<li><a href="">Menu</a></li>
							<li><a href="">Burger</a></li>
							<li><a href="">Menu</a></li>
							<li><a href="">Menu</a></li>
							<li><a href="">Menu</a></li>
							<li><a href="">Menu</a></li>
						</ul>
					</div>
					<div class="clr"></div>
				</div>
			</li>
			<li  class="menu"><a href=""  class="mlink">How It Works</a></li>
			<li  class="menu"><a href=""  class="mlink">Restaurants</a></li>
			<li  class="menu"><a href=""  class="mlink">Contat Us</a></li>
		</ul>
	</div>
	<div class="showNavigation" style="font-size: 11px; text-align: right;"><a href="javascript:;" style="cursor:pointer; ">&nbsp;</a></div>
	</div>
</div>