var FIRST_TIME_CHAT_START = true;
$(document).ready(function(){

		$('.find input[type=checkbox]').live('click',function(){

			if($(this).is(':checked')) {
				if($(this).attr('name') != 'all') {
					$('.find input[name=all]').prop('checked',false);
					$('.find input[name=all]').parent().removeClass('active');
				}
				for(var i = 0; i < category.length; i ++) {
					if($('.find input[name='+category[i]+']').is(':checked')) {
						$('#'+category[i]).hide().fadeIn();
					} else {
						$('#'+category[i]).hide();
					}
				}

				$('#'+$(this).attr('name')).fadeIn('slow');
				$(this).parent().addClass('active');
			} else {

				$(this).parent().removeClass('active');
				$('#'+$(this).attr('name')).fadeOut();

				var count = 0;
				for(var i = 0; i < category.length; i ++) {
					if($('.find input[name='+category[i]+']').is(':checked')) {
						count ++;
					}
				}
				if(count == 0) {
					for(var i = 0; i < category.length; i ++) {
						$('#'+category[i]).hide().fadeIn('slow');
					}
					$('.find input[name=all]').prop('checked',true);
				}
			}

			if($(this).attr('name') == 'all') {
				for(var i = 0; i < category.length; i ++) {
					$('#'+category[i]).hide().fadeIn('slow');
					$('.find input[name='+category[i]+']').prop('checked',false);
					$('.find input[name='+category[i]+']').parent().removeClass('active');
				}
				$(this).prop('checked',true);
				$(this).parent().addClass('active');
			}

		});

		$('.all-menu-items .categories ul li:even').addClass('odd');

		 $('.nav ul li').hover(
			function () {
				//show its submenu
				$('.submenu', this).hide().show();
				$(this).find(':first').addClass('active');
			},
			function () {
				//hide its submenu
				$('.submenu', this).hide();
				$(this).find(':first').removeClass('active');
			}
		);


		$('.order-button').live('click',function() {
			$.ajax({
				  type: "GET",
				  url: 'include/cart.php',
				  data: { ID : $(this).attr('id'), action : 'add'},
				  success: function(data) {
					$('.outercart-wrapper').load('include/outer-cart.php',function() {
						$('.shopping-cart .container').show();
					});
				  }
			});

			$(this).ajaxStart(function () {
				$('.shopping-cart .container .loading-cart').show();
			}).ajaxStop(function () {
				$('.shopping-cart .container .loading-cart').hide();
			});
		});

		$('.categories ul li div.text .addtoo').live('click',function() {
			$.ajax({
				  type: "GET",
				  url: 'include/cart.php',
				  data: { ID : $(this).attr('rel'), action : 'update_sub'},
				  success: function(data) {
					$('.outercart-wrapper').load('include/outer-cart.php',function() {
						$('.shopping-cart .container').show();
						if(data == 'true') {
							$('.categories ul li div.text .addtoo').html('Delete').addClass('addtoo1').removeClass('addtoo');
						}
					});
				  }
			});
			$(this).ajaxStart(function () {
				$('.shopping-cart .container .loading-cart').show();
			}).ajaxStop(function () {
				$('.shopping-cart .container .loading-cart').hide();
			});
		});

		$('.outercart-wrapper').load('include/outer-cart.php');
		$('.order-cart-wrapper').load('include/order-cart.php');

		$('.Checkout-Button').live('click',function(){
			window.location = 'order-details.php';
		});

		$('.buttonCART').live('click',function(){
			//alert('s');
			$(this).next().slideToggle();
		});

		$('.search-wrap form').attr('action','javascript:;');
		$('.search-wrap form input[type=button]').live('click',function(){
			if((/^[0-9a-zA-Z-\ \']+$/).test($(this).prev().val())) {
				window.location.href = 'search-'+ ($(this).prev().val()).replace(' ', '-');
			}
		});

		$('.order-cart-wrapper form .del a ,.shopping-cart ul li .del').live('click',function(){

			if(confirm("Confirm Delete From Your Cart")) {
				$.ajax({
					  type: "GET",
					  url: 'include/cart.php',
					  data: { ID : $(this).attr('rel'), action : 'delete'},
					  success: function(data) {
						if(data != 'true'){
							$('.categories ul li .whole-wrap .span a[rel=' + data +']').html('Add too').addClass('addtoo').removeClass('addtoo1');
						}
						$('.order-cart-wrapper').load('include/order-cart.php' ,function(d){
							if(d == 'true') {
								window.location = $('.breadcrum ul li:last-child a').attr('href');
							}
						});
						$('.outercart-wrapper').load('include/outer-cart.php',function() {
							$('.shopping-cart .container').show();
						});
					  }
				});

				$(this).ajaxStart(function () {
					$('.shopping-cart .container .loading-cart').show();
				}).ajaxStop(function () {
					$('.shopping-cart .container .loading-cart').hide();
				});
			}
		});

		$('.categories ul li div.text .addtoo1').live('click',function(){

			$.ajax({
				  type: "GET",
				  url: 'include/cart.php',
				  data: { ID : $(this).attr('rel'), action : 'sub_delete'},
				  success: function(data) {
					if(data != 'true'){
						$('.categories ul li .whole-wrap .span a[rel=' + data +']').html('Add too').addClass('addtoo').removeClass('addtoo1');
					}
					$('.order-cart-wrapper').load('include/order-cart.php');
					$('.outercart-wrapper').load('include/outer-cart.php',function() {
						$('.shopping-cart .container').show();
					});
				  }
			});

			$(this).ajaxStart(function () {
				$('.shopping-cart .container .loading-cart').show();
			}).ajaxStop(function () {
				$('.shopping-cart .container .loading-cart').hide();
			});
		});

		$.validator.addMethod("postcode", function(value, element) {
			return this.optional(element) || /^([A-PR-UWYZ0-9][A-HK-Y0-9][AEHMNPRTVXY0-9]?[ABEHMNPRVWXY0-9]? {1,2}[0-9][ABD-HJLN-UW-Z]{2}|GIR 0AA)$/i.test(value);
		}, "Enter only Full UK Post Code");

		var PREVIOUS_SLIDE = "";
		$('.slideupdown').live('click' ,function(){
			if(PREVIOUS_SLIDE != ""){
				//PREVIOUS_SLIDE.trigger('click');
			}
			$(this).parent().next().slideToggle();
			PREVIOUS_SLIDE = $(this);
		});

		$('.myrating .rate-now').live('click' ,function(){
			$(this).next().slideToggle();
		});

		/*$('#news_feed').vTicker({
			speed: 500,
			pause: 3000,
			animation: 'fade',
			mousePause: true,
			showItems: 1
		});

		$('#news_feed1').vTicker({
			speed: 500,
			pause: 3000,
			animation: 'fade',
			mousePause: true,
			showItems: 1
		});*/

		$('.right-comment .box-wrap .news_feed  .feed').each(function(){
			if($(this).text().length > 200) {
				$(this).text($(this).text().substring(0,200)+" ...");
			}
		 });

		$('.chat-wrap').live('click', function(){
			window.open( '../chat/client.php','popUpWindow','height=650,width=600,position=absolute,right=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');
		});

});


var CID = "";
function makeFirstTime(){
	$.ajax({
			type: "POST",
			url: 'include/makechat.php',
			success: function(data) {
				if(data == 'false') {
					$('.chat-room .chat .welcometext').html('Sorry All Members are  busy This Time.');
					$('.chat-room .chat ul').html('');
					FIRST_TIME_CHAT_START = true;
				} else {
					FIRST_TIME_CHAT_START = false;
					CID = data;
					setTimeout(doAjax(''), 1000);
					Get();
				}
			}
	});
}

function refreshPage(interval ,page) {
	setTimeout(function(){ window.location.href = page},interval);
}


(function($) {
$.fn.ibox = function() {

	// set zoom ratio //
	resize = 0;
	////////////////////
	var img = this;
	img.parent().append('<div class="ibox" />');
	var ibox = $('.ibox');
	var elX = 0;
	var elY = 0;

	img.each(function() {
		var el = $(this);

		el.mouseenter(function() {
			ibox.html('');
			var elH = el.height();
			elX = el.position().left-20; // 6 = CSS#ibox padding+border
			elY = el.position().top-20;
			var h = el.height();
			var w = el.width();
			var wh;
			checkwh = (h < w) ? (wh = (w / h * resize) / 2) : (wh = (w * resize / h) / 2);

			$(this).clone().prependTo(ibox);
			ibox.css({
				top: elY + 'px',
				left: elX + 'px'
			});

			ibox.stop().fadeTo(900, 1, function() {
				$(this).animate({top: '-='+(resize/2), left:'-='+wh},400).children('img').animate({height:'+='+resize},400);
			});
		});
	});
	ibox.mouseleave(function() {
		ibox.html('').hide();
	});
};
})(jQuery);


setInterval(function(){$('.chat-wrap').hide().fadeIn('slow');},3000);