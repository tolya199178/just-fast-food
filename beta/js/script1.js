
$(document).ready(function(){

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

		$('.search-wrap form').attr('action','javascript:;');
		$('.search-wrap form input[type=button]').live('click',function(){
			if((/^[0-9a-zA-Z-\ \']+$/).test($(this).prev().val())) {
				window.location.href = 'search-'+ ($(this).prev().val()).replace(' ', '-');
			}
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

		/* $('#news_feed').vTicker({
			speed: 700,
			pause: 4000,
			animation: 'fade',
			mousePause: true,
			showItems: 1
		}); */

		/* $("div#news_feed").jContent({orientation: 'vertical',
						width: 314,
						height: 245,
                        duration: 500,
                        auto: true,
                        direction: 'next', //or 'prev'
                        pause: 1800,
                        pause_on_hover: true}); */

		$('#news_feed1').vTicker({
			speed: 700,
			pause: 5000,
			animation: 'fade',
			mousePause: true,
			showItems: 5,

		});

		$('.right-comment .box-wrap .news_feed  .feed').each(function(){
			if($(this).text().length > 200) {
				$(this).text($(this).text().substring(0,200)+" ...");
			}
		 });

		$('.chat-wrap').live('click', function(){
			window.open( '../chat/client.php','popUpWindow','height=650,width=600,position=absolute,right=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');
		});

		/* $(".showNavigation a").toggle(function (){
			$(this).text("Hide Menu");
			$('.nav').slideDown();
		}, function(){
			$(this).text("Show Menu");
			$('.nav').slideUp();
		}); */


});
$(function() {
	$("#news_feed").jCarouselLite({
		vertical: true,
		hoverPause:true,
		visible: 1,
		auto:4000,
		speed:1000,
		pauseOnHover: true
	})
});

setInterval(function(){$('.chat-wrap').hide().fadeIn('slow');},3000);