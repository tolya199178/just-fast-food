<?php
	session_start();
	include('include/functions.php');
	/* foreach($_SESSION as $k => $v){
		unset($_SESSION[$k]);
	} */

?>
<!DOCTYPE HTML>
<html lang="en-US" class="no-js">
<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="images/favicon.ico">
	<title>Order - McDonalds : KFC : Nandos : Burger King, African, Chinsese and other Takeaways Online...</title>
	<link rel="stylesheet" href="css/style1.css" />
	<link rel="stylesheet" href="css/ticker-style.css" />
	<link rel="stylesheet" href="css/fancybox/jquery.fancybox.css" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.cycle.all.min.js"></script>
	<script type="text/javascript" src="js/validate.js"></script>
	<script type="text/javascript" src="js/script1.js"></script>
	<script type="text/javascript" src="js/modernizr.js"></script>
	<script type="text/javascript" src="css/fancybox/jquery.fancybox.js"></script>

	<script type="text/javascript" src="js/jquery.vticker-min.js"></script>
	<script type="text/javascript" src="js/jquery.ticker.js"></script>
	<script type="text/javascript" src="js/jcarousellite_1.0.1.pack.js"></script>

	<script type="text/javascript" src="js/mawais/rev.js"></script>

	<script type="text/javascript">

		$(document).ready(function(){

			$(".home-search-box").validate({
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
				 ukpostcode: "UK Post code Not Valid",
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

			var C_POSTCODE = "<?= showC('postcode')?>";

			$('.show_cookie_box #c_OK').live('click',function(){
				$('.postcodeSearch .text').val(C_POSTCODE).focus();
				$('.text-cookie').fadeIn('slow');
				$('.show_cookie_box_p').hide();
			});

			$('.show_cookie_box #c_cancl').live('click',function(){
				$('.show_cookie_box_p').slideUp();
			});
		});

		window.onload = function() {
			$('.show_cookie_box_p').slideDown();
			window.setTimeout('hideCookieBox()',10000);
		}
		function hideCookieBox() {
			$('.show_cookie_box_p').slideUp();
		}



	</script>
	<style type="text/css">
		.marque{
			padding:2px 2px 2px 2px;
			color:#D62725;
			font-size:12px;
			font-weight:bold;
		}
		.marque ul{
			list-style-type:none;
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
		<div class="wrapper">
			<marquee direction="left"  class="marque" width="623px">
				We currently cover the following cities: Portsmouth, Cosham, Havant, Fareham & Southampton ...
			</marquee>
			<div class="fl-left">
				<div class="borderLight " style="padding:5px">
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
				<div class="fl-left">
					<div class="borderLight"  style="margin-top:10px;">
						<div class="takeaddedToday box">
							<h2>Takeaways & Fastfood added today</h2>
							<div class="con fl-left">
								<ul style="border-right:1px solid #ddd">
									<li>McDonalds<div>In Fratton PO5 </div></li>
									<li>Burger King<div>In Commercial Rd PO4</div></li>
									<li>Nandos<div>In Gunwarf PO3</div></li>
									<li>KFC<div>In Commercial Rd PO4</div></li>
								</ul>
							</div>
							<div class="con fl-left">
								<ul style="padding-left:10px;">
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
					<div class="borderLight"  style="margin-top:10px; margin-left:10px;">
						<div class="box slider-ww takeaddedToday">
							<h2>4 Easy Steps</h2>
							<div class="cont">
								<ul>
									<li>
										<div class="no">1</div>
										<div class="text">Enter your postcode</div>
									</li>
									<li>
										<div class="no">2</div>
										<div class="text">Pick a fastfood or takeaway</div>
									</li>
									<li>
										<div class="no">3</div>
										<div class="text">Order and Pay</div>
									</li>
									<li>
										<div class="no">4</div>
										<div class="text">Your food on its way!</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					</div>
				<div class="clr"></div>
			</div>
			<div class="fl-left">
				<div class="postcodeSearch">
					<form action="" method="post" id="order-search" class="home-search-box" name="post"  style="padding:17px;">
						<label for="postcode">Fastfood & Takeaway in your area<br><span>Enter your postcode e.g PO5 4LN</span></label>
						<input type="text" name="ukpostcode" id="postcode" class="text required postcode" value="" placeholder="Enter Your Post Code Here"/>
						<input type="submit" value="Search" name="submit" class="sbtn"/>
						<div class="clr"></div>
					</form>
				</div>
				<div class="borderLight" style="margin-top:10px; margin-left:20px; padding: 2px;">
					<div class="box noCash-w" id="news_feed">
						<ul>
							<li>
								<div class="nocash" style="padding-top:25px;">NO CASH?<br> NO PROBLEM!<br><b>PAY BY CARD</b><br/></div>
								<img src="images/visadb.bmp" alt="" style="width:60px; height:40px; padding-right:7px; padding-left: 20px;"/><img src="images/38.gif" alt="" />
							</li>
							<li>
								<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
								<a class="twitter-timeline"  href="https://twitter.com/JustFastFood" data-widget-id="274119642040115200"></a>
							</li>
							<li>
								<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FJust-FastFood%2F475488035817059&amp;width=314%&amp;height=245&amp;colorscheme=light&amp;show_faces=true&amp;border_color=%23fff&amp;stream=false&amp;header=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:314px; height:245px" allowTransparency="true"></iframe>
							</li>
							<li>
								<div id="fb-root"></div>
								<script>(function(d, s, id) {
								  var js, fjs = d.getElementsByTagName(s)[0];
								  if (d.getElementById(id)) return;
								  js = d.createElement(s); js.id = id;
								  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
								  fjs.parentNode.insertBefore(js, fjs);
								}(document, 'script', 'facebook-jssdk'));</script>
								<div class="fb-comments" data-href="http://just-fastfood.com/beta" data-num-posts="2" data-width="314" style="height:245px; border:none; overflow:hidden;"></div>
							</li>
						</ul>
					</div>
				</div>
				<div class="borderLight" style="margin-top:10px; margin-left:20px; padding:0px; height:260px">
					<div class="box right-comment">
						<div class="cart box-wrap box-radius" style="margin:0px; border:none;">
							<div class="header-wrp" style="">Latest Orders &amp; Updates</div>
							<div class="news_feed">
							<div id="news_feed1" >
								<ul>
									<?php
										$query = "SELECT `user_screen_name`,`order_total`,`order_details`,`order_date_added` FROM `orders`,`user` WHERE orders.order_status = 'complete' AND orders.order_user_id = user.id  ORDER BY orders.order_date_added DESC LIMIT 0 , 6";
										$valueOBJ = $obj->query_db($query);
										$odd = 0;
										while($res = $obj->fetch_db_array($valueOBJ)) {

									?>
									<li class="<?php echo($odd%2) ? 'odd':'even' ?>">
										<div>
											<div class="feed order-feed">
											<span class="i"><?php echo ($res['user_screen_name'] != '') ?  $res['user_screen_name'] : 'Customer '?> Ordered</span>
											<?php
												$Array = json_decode($res['order_details'] ,true);
												echo '<div class="list-details">';
												foreach($Array as $key => $val) {

													if($key != 'TOTAL') {

														echo $val['QTY'] . ' '.$val['NAME'] .',';
													}

												}
												echo ' at '. date('g:i a M,Y', strtotime($res['order_date_added']));
												echo '</div>';
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
			<div class="clr"></div>
		</div>
	</div>
	<div class="footer">
		<?php require('templates/footer.php');?>
	</div>
</body>
</html>