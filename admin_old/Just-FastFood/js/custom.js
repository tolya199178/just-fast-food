$(window).load(function() {

  $('.flexslider').flexslider({
    animation: "slide", 
    animationLoop: true,
	pauseOnHover: true,
	initDelay: 0,
	startAt: 0,
	
	touch: true,
    itemWidth: 500,
    itemMargin: 0,
    minItems: 1,
    maxItems: 1
	
  });
});
	
 jQuery(document).ready(function() {

      var owl = $("#owl-demo");
     
 owl.owlCarousel({
      items : 3, 
	  autoPlay: true,
	 	pagination : true,
    	paginationNumbers: false,
		 itemsDesktop : [1199,3],
    itemsDesktopSmall : [980,3],
    itemsTablet: [768,2],
    itemsMobile : [479,1]
     
  });
      $(".next").click(function(){
        owl.trigger('owl.next');
      })
      $(".prev").click(function(){
        owl.trigger('owl.prev');
      })
      $(".play").click(function(){
        owl.trigger('owl.play',1000);
      })
      $(".stop").click(function(){
        owl.trigger('owl.stop');
      });

    });

$(document).ready(function(){
    $(".order-feed").each(function(){

        if($(this).text().length > 200) {
            $(this).text($(this).text().substring(0, 200) + " ...")
        }
    }) ;
});


$(document).ready(function(){
    $(".text-center").on('keyup', function(event){
        $(this).val($(this).val().toUpperCase());

    });
});



$(document).ready(function(){
    $('.order-list').each(function(){
        if ($(this).text().length > 200) {
            $(this).text($(this).text().substring(0, 200) + " ...")
        }
    });
});


jQuery(document).ready(function(){
    $("#order-search").bootstrapValidator({

        submitHandler: function(form) {
            var val = $("#postcodeuk").val();

            var first3 = val.substr(0, 3);
            var lastPart = val.substr(3, val.length);
            val = first3+'-'+lastPart;
            if (val.indexOf(' ') >= 0) {
                val = val.replace(' ','-');
            }
            window.location.href = 'Postcode-'+val;
            //console.log(val);
            return false;
        },

        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            ukpostcode: {
                validators: {
                    zipCode: {
                        country: 'GB',
                        message: 'The value is not a valid UK postcode'
                    }
                }
            }
        }
    }) ;
});