/* function makeFirstTime() {    $.ajax({        type: "POST",        url: "include/makechat.php",        success: function (e) {            if (e == "false") {                $(".chat-room .chat .welcometext").html("Sorry All Our Members Are Currently Busy.");                $(".chat-room .chat ul").html("");                FIRST_TIME_CHAT_START = true            } else {                FIRST_TIME_CHAT_START = false;                CID = e;                setTimeout(doAjax(""), 1e3);                Get()            }        }    })} */
function refreshPage(e, t) {
    setTimeout(function () {
        window.location.href = t
    }, e)
}
var FIRST_TIME_CHAT_START = true;
$(document).ready(function () {

// Password reset hanlder

    $('#init-p-form').click( function(event) { 

            event.preventDefault();
            console.log('initiate password form');
            $('#request-p-form').modal();       
            $('#request-p-form .modal-body').load('include/forgot-password-modal.php');
            $('#request-p-form').find('input.btn-danger-custom').unbind('click');


            $('#request-p-form').on('click', 'input.btn-danger-custom', function(event) {
                
                event.preventDefault();
                $.ajax({ 
                    url:  'include/forgot-password-modal.php',
                    type: 'POST',
                    data: { FORGOT: 'Submit', 
                            user_email: $('#request-p-form .modal-body').find('form #user_email0').val(),
                            access: $('#request-p-form .modal-body').find('form input[name="access"]').val()
                          }
                    //success: function() { alert('please check your email'); }

                });

                $(this).unbind('click');

            });


    });
    $(".find input[type=checkbox]").click( function () {

        if ($(this).is(":checked")) {
            if ($(this).attr("name") != "all") {
                $(".find input[name=all]").prop("checked", false);
                $(".find input[name=all]").parent().removeClass("active")
            }
            for (var e = 0; e < category.length; e++) {
                if ($(".find input[name=" + category[e] + "]").is(":checked")) {
                    $("#" + category[e]).hide().fadeIn()
                } else {
                    $("#" + category[e]).hide()
                }
            }
            $("#" + $(this).attr("name")).fadeIn("slow");
            $(this).parent().addClass("active")
        } else {
            $(this).parent().removeClass("active");
            $("#" + $(this).attr("name")).fadeOut();
            var t = 0;
            for (var e = 0; e < category.length; e++) {
                if ($(".find input[name=" + category[e] + "]").is(":checked")) {
                    t++
                }
            }
            if (t == 0) {
                for (var e = 0; e < category.length; e++) {
                    $("#" + category[e]).hide().fadeIn("slow")
                }
                $(".find input[name=all]").prop("checked", true)
            }
        } 
        if ($(this).attr("name") == "all") {
            for (var e = 0; e < category.length; e++) {
                $("#" + category[e]).hide().fadeIn("slow");
                $(".find input[name=" + category[e] + "]").prop("checked", false);
                $(".find input[name=" + category[e] + "]").parent().removeClass("active")
            }
            $(this).prop("checked", true);
            $(this).parent().addClass("active")
        }
    });

    $(".nav ul li").hover(function () {
        $(".submenu", this).hide().show();
        $(this).find(":first").addClass("active")
    }, function () {
        $(".submenu", this).hide();
        $(this).find(":first").removeClass("active")
    });
    $(".order-button").click( function () {
        console.log($(this));
        IsMeal = 'false';
        var MealItems = new Array();
        if ($(this).parents('.whole-wrap').find('.meal-items').hasClass('isMealClass')) {
            // launch the modal
            $(this).parents('.whole-wrap').find('#meal-modal').modal();
            IsMeal = 'true';
            $(this).parents('.whole-wrap').find('#meal-modal').find('.meal-items select option:selected').each(function () {
                MealItems.push($(this).val());
            });

            $(this).parents('.whole-wrap').find('#meal-item-add').click( function() {

                    $.ajax({
                        type: "GET",
                        url: "include/cart.php",
                        data: {
                            ID: $(this).parents('.whole-wrap').find('.order-button').attr("id"),
                            MEAL: IsMeal,
                            MEAL_ARRAY: JSON.stringify(MealItems),
                            action: "add"
                        },
                        success: function (e) {
                            $(".outercart-wrapper").load("include/outer-cart2.php", function () {
                                $(".shopping-cart .container").show()
                            })
                        }
                    });

                    $(this).parents('.whole-wrap').find('#meal-item-add').unbind('click');
                    $(this).parents('.whole-wrap').find('#meal-modal').modal('hide');

            });

        } else {

                    $.ajax({
                        type: "GET",
                        url: "include/cart.php",
                        data: {
                            ID: $(this).attr("id"),
                            MEAL: IsMeal,
                            MEAL_ARRAY: JSON.stringify(MealItems),
                            action: "add"
                        },
                        success: function (e) {
                            $(".outercart-wrapper").load("include/outer-cart2.php", function () {
                                $(".shopping-cart .container").show()
                            })
                        }
                    });

        }

        $(document).ajaxStart(function () {
            $(".cart-wrapper").find(".loading-cart").show()
        }).ajaxStop(function () {
                $(".cart-wrapper").find(".loading-cart").hide()
            })
    });
    $(".categories ul li div.text .addtoo").click( function () {
        $.ajax({
            type: "GET",
            url: "include/cart.php",
            data: {
                ID: $(this).attr("rel"),
                action: "update_sub"
            },
            success: function (e) {
                $(".outercart-wrapper").load("include/outer-cart2.php", function () {
                    $(".shopping-cart .container").show();
                    if (e == "true") {
                        $(".categories ul li div.text .addtoo").html("Delete").addClass("addtoo1").removeClass("addtoo")
                    }
                })
            }
        });
        $(document).ajaxStart(function () {
            $(".cart-wrapper").find(".loading-cart").show()
        }).ajaxStop(function () {
                $(".cart-wrapper").find(".loading-cart").hide()
            })
    });
    $(".outercart-wrapper").load("include/outer-cart2.php");
    $(".order-cart-wrapper").load("include/order-cart2.php");
    $('.cart-wrapper').on('click', 'button.Checkout-Button', function () {
        $(location).attr('href', "order-details.php");
    });
    $(".buttonCART").click( function () {
        $(this).next().slideToggle()
    });
    $(".search-wrap form").attr("action", "javascript:;");
    $(".search-wrap form input[type=button]").click( function () {
        if (/^[0-9a-zA-Z-\ \']+$/.test($(this).prev().val())) {
            window.location.href = "search-" + $(this).prev().val().replace(" ", "-")
        }
    });
    $('.cart-wrapper, .order').on('click', 'a.del', function () {
        // Launch the modal
        console.log( $(this).attr("rel") );
        $('#item-modal #item-remove').attr('data-item-id', $(this).attr("rel"));
        $('#item-modal').modal();
        $('#item-modal .modal-body p').text('Are you sure you want to remove "' + $(this).attr('data-item-name') + '" from your cart?');
        // Remove item from cart
        $('#item-remove').click( function() {
            $('#item-modal').modal('hide');
            $.ajax({
                type: "GET",
                url: "include/cart.php",
                data: {
                    ID: $(this).attr("data-item-id"),
                    action: "delete"
                },
                success: function (e) {
                    if (e != "true") {
                        $(".categories ul li .whole-wrap .span a[rel=" + e + "]").html("Add too").addClass("addtoo").removeClass("addtoo1")
                    }
                    $(".order-cart-wrapper").load("include/order-cart2.php", function (e) {
                        if (e == "true") {
                            window.location = $(".breadcrum ul li:last-child a").attr("href")
                        }
                    });
                    $(".outercart-wrapper").load("include/outer-cart2.php", function () {
                        $(".shopping-cart .container").show()
                    })
                }
            });
            $(document).ajaxStart(function () {
                $(".cart-wrapper").find(".loading-cart").show()
            }).ajaxStop(function () {
                    $(".cart-wrapper").find(".loading-cart").hide()
                })
            $('#item-remove').unbind( "click" );
            return false;
        });
        $('#item-modal #item-keep').click( function() {
            $('#item-modal #item-remove').attr('data-item-id', '');
            $('#item-modal').modal('hide');
            return false;
        });


    });
    $(".categories ul li div.text .addtoo1").click( function () {
        $.ajax({
            type: "GET",
            url: "include/cart.php",
            data: {
                ID: $(this).attr("rel"),
                action: "sub_delete"
            },
            success: function (e) {
                if (e != "true") {
                    $(".categories ul li .whole-wrap .span a[rel=" + e + "]").html("Add too").addClass("addtoo").removeClass("addtoo1")
                }
                $(".order-cart-wrapper").load("include/order-cart2.php");
                $(".outercart-wrapper").load("include/outer-cart2.php", function () {
                    $(".shopping-cart .container").show()
                })
            }
        });
        $(document).ajaxStart(function () {
            $(".cart-wrapper").find(".loading-cart").show();

        }).ajaxStop(function () {
                $(".cart-wrapper").find(".loading-cart").hide()
            })
    });
    $.validator.addMethod("postcode", function (e, t) {
        return this.optional(t) || /^([A-PR-UWYZ0-9][A-HK-Y0-9][AEHMNPRTVXY0-9]?[ABEHMNPRVWXY0-9]? {1,2}[0-9][ABD-HJLN-UW-Z]{2}|GIR 0AA)$/i.test(e)
    }, "Enter only Full UK Post Code");
    var e = "";
    $(".slideupdown").click( function () {
        if (e != "") {}
        $(this).parent().next().slideToggle();
        e = $(this)
    });
    $(".myrating .rate-now").click( function () {
        $(this).next().slideToggle()
    });
    $(".right-comment .box-wrap .news_feed  .feed").each(function () {
        if ($(this).text().length > 200) {
            $(this).text($(this).text().substring(0, 200) + " ...")
        }
    });
    $(".chat-wrap").click( function () {
        window.open("../chat/client.php", "popUpWindow", "height=650,width=600,position=absolute,right=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes")
    });
});
var CID = "";
(function (e) {
    e.fn.ibox = function () {
        resize = 0;
        var t = this;
        t.parent().append('<div class="ibox" />');
        var n = e(".ibox");
        var r = 0;
        var i = 0;
        t.each(function () {
            var t = e(this);
            t.mouseenter(function () {
                n.html("");
                var s = t.height();
                r = t.position().left - 20;
                i = t.position().top - 20;
                var o = t.height();
                var u = t.width();
                var a;
                checkwh = o < u ? a = u / o * resize / 2 : a = u * resize / o / 2;
                e(this).clone().prependTo(n);
                n.css({
                    top: i + "px",
                    left: r + "px"
                });
                n.stop().fadeTo(900, 1, function () {
                    e(this).animate({
                        top: "-=" + resize / 2,
                        left: "-=" + a
                    }, 400).children("img").animate({
                            height: "+=" + resize
                        }, 400)
                })
            })
        });
        n.mouseleave(function () {
            n.html("").hide()
        })
    }
})(jQuery);
setInterval(function () {
    $(".chat-wrap").hide().fadeIn("slow")
}, 3e3)