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


/*$(document).ready(function () {
    $('.box-wrap').each(function () {

        $(this).toggleClass('shadow')

    });
});*/

$(document).ready(function(){

    $(".text-center, #postcodeuk").on('keyup', function(event){

        $(this).val($(this).val().toUpperCase());



    });

});

$(document).ready(function () {
    $('.small .why-signup').hover(function () {
        $('.why-signup-text').show();
    }, function () {
        $('.why-signup-text').hide();
    });
});


$(document).ready(function(){

    $('.order-list').each(function(){

        if ($(this).text().length > 200) {

            $(this).text($(this).text().substring(0, 200) + " ...")

        }

    });

});




$(document).ready(function() {

    $("#home-search-box").bootstrapValidator({

        submitHandler: function(form) {

            var val = $(".postcode").val();

            if (val.length == 6) {

                var first3 = val.substr(0, 3);

                var lastPart = val.substr(3, val.length);

                val = first3 + '-' + lastPart;

            } else {

                var first4 = val.substr(0, 4);

                var last4 = val.substr(4, val.length);

                val = first4 + '-' + last4;

            }


            if (val.indexOf(' ') >= 0) {

                val = val.replace(' ', '');

            }

            window.location.href = 'Postcode-'+ val;
            return false;
        },
        message: 'Please enter your postcode.',
        feedbackIcons: {
            valid: 'fa fa-check-circle-o fa-2x move-up',
            invalid: 'glyphicon glyphicon-remove move-up',
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

$(document).ready(function() {

    // IF user is logged in
    $('#order-confirm-delivery').bootstrapValidator({

        message: 'This value is not valid',

        feedbackIcons: {
            valid: 'fa fa-check-circle-o fa-lg',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {

            user_email: {
                validators: {
                    notEmpty: {
                        message: 'The email is required and cannot be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            user_name: {
                message: 'Please enter your full name',
                validators: {
                    notEmpty: {
                        message: 'Your full name is required'
                    }
                }
            },
            user_screen_name: {
                message: 'Please enter your full name',
                validators: {
                    notEmpty: {
                        message: 'The name field is required and cannot be empty'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'Full name must be more than 6 and less than 30 characters long.'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'Full name can only consist of alphabetical, number and underscore'
                    }
                }
            },
            user_phoneno: {
                message: 'Please enter your mobile number',
                validators: {
                    notEmpty: {
                        message: 'We need your phone number to contact you should there be any question regarding your order'
                    },
                    numeric: {
                        message: 'A phone number can\'t contain alphabetical characters'
                    }
                }
            },
            user_address: {
                message: 'Please enter your delivery address',
                validators: {
                    notEmpty: {
                        message: 'The delivery address cannot be empty'
                    }
                }
            },
            user_city: {
                message: 'Please enter your city',
                validators: {
                    notEmpty: {
                        message: 'Your current city is required'
                    }
                }
            },
            user_post_code: {
                message: 'Please enter post code',
                validators: {
                    notEmpty: {
                        message: 'Post code is required in order to deliver the order'
                    }
                }
            },
            accept: {

                validators: {

                    message: 'Please accept the terms and condition to proceed'
                }

            }
        }
    });

    $('.driver-apply-form').bootstrapValidator({
        message : 'This value is not valid',

        feedbackIcons: {
            valid: 'fa fa-check-circle-o fa-lg',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },

        submitHandler: function (validator, form, submitButton){

            $.post('driver-apply.php', form.serialize(), function (result) {

                if (result.status == 'email_sent') {

                    $('.driver-apply-form').hide();
                    $('#feedback').show();

                } else {
                    alert('Cannot send email. Please review the form information and try again.'+ result.status);

                }

            }, 'json');
        },

        fields: {

            drv_name: {
                message: 'Please enter your full name',
                validators: {
                    notEmpty: {
                        message: 'Your full name is required'
                    }
                }
            },

            drv_email: {
                validators: {
                    notEmpty: {
                        message: 'The email is required and cannot be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },

            drv_no: {
                message: 'Please enter your mobile number',
                validators: {
                    notEmpty: {
                        message: 'We need your phone number to schedule an interview.'
                    },
                    numeric: {
                        message: 'A phone number can\'t contain alphabetical characters'
                    }
                }
            },

            drv_location: {
                validators: {
                    notEmpty: {
                        message: 'Please select your location.'
                    }
                }
            },

            drv_vehicle: {
                validators: {
                    notEmpty: {
                        message: 'Please select type of vehicle.'
                    }
                }
            },

            drv_details: {
                validators: {
                    notEmpty: {
                        message: 'Provide additional information in support of your application. e.g Availability, Post codes to cover.'
                    },

                    stringLength: {
                        min: 50,

                        message: 'Must be at least 100 characters long.'
                    }


                }
            }
        }
    });

    // if the user is not logged in on order-details.php
    $('#signup-form, .signup-form, #order-sign-up-form').bootstrapValidator({

        message: 'This value is not valid',

        feedbackIcons: {
            valid: 'fa fa-check-circle-o fa-lg',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        submitHandler: function (validator, form, submitButton) {

            $.post('signup.php', form.serialize(), function (result) {
                if (result.status == 'account_created') {
                    // You can reload the current location
                    $('#signup-modal .modal-title').text('Thanks for joining us!');
                    $('#signup-modal .modal-body').text(result.message);
                    $('#signup-modal .btn').hide();
                    $('#signup-modal').modal();
                    setTimeout(function () {
                        $(location).attr('href', '/')
                    }, 7000);


                } else if (result.status == 'account_exist') {
                    $('#signup-modal .modal-title').text('Account Exists');
                    $('#signup-modal .modal-body').text(result.message);
                    $('#signup-modal').modal();
                    $('#loginForm').bootstrapValidator('disableSubmitButtons', false);

                } else if (result.status == 'zip_code') {

                    $('#signup-modal .modal-title').text('Invalid Post Code');
                    $('#signup-modal .modal-body').text(result.message);
                    $('#signup-modal').modal();
                    $('#loginForm').bootstrapValidator('disableSubmitButtons', false);

                } else {
                    $('#signup-modal .modal-title').text('Something Went Wrong');
                    $('#signup-modal .modal-body').text('Looks like you\'ve not activated your account. Please check your email including spam folder for activation link.');
                    $('#signup-modal').modal();
                    $('#loginForm').bootstrapValidator('disableSubmitButtons', false);
                    $('#loginForm').bootstrapValidator('disableSubmitButtons', false);
                }
            }, 'json');
        },

        fields: {

            user_email: {
                validators: {
                    notEmpty: {
                        message: 'The email is required and cannot be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },


            user_name: {
                message: 'Please enter your full name',
                validators: {
                    notEmpty: {
                        message: 'The name field is required and cannot be empty'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'Full name must be more than 6 and less than 30 characters long.'
                    }

                }
            },

            user_fullname: {
                message: 'Please enter your full name',
                validators: {
                    notEmpty: {
                        message: 'Your full name is required'
                    }
                }
            },

            user_password: {
                message: 'Password is not valid',
                validators: {
                    notEmpty: {
                        message: 'The username is required and cannot be empty'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The password must be more than 6 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'The username can only consist of alphabetical, number and underscore'
                    }
                }
            },
            cuser_password: {
                message: 'Please re-enter your password',
                validators: {
                    notEmpty: {
                        message: 'Please ensure password entered is the same as the one entered above'
                    },
                    identical: {
                        field: 'user_password',
                        message: 'The password and its confirm must be the same'
                    }
                }
            },
            user_phoneno: {
                message: 'Please enter your mobile number',
                validators: {
                    notEmpty: {
                        message: 'We need your phone number to contact you should there be any question regarding your order'
                    },
                    numeric: {
                        message: 'A phone number can\'t contain alphabetical characters'
                    }
                }
            },
            user_address: {
                message: 'Please enter your delivery address',
                validators: {
                    notEmpty: {
                        message: 'The delivery address cannot be empty'
                    }
                }
            },
            user_city: {
                message: 'Please enter your city',
                validators: {
                    notEmpty: {
                        message: 'Your current city is required'
                    }
                }
            },
            user_post_code: {
                message: 'Please enter post code',
                validators: {
                    notEmpty: {
                        message: 'Post code is required in order to deliver the order'
                    }
                }
            }
        }
    });


    // Order login form validation

    $('#order-login-form').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'fa fa-check-circle-o fa-lg',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        submitHandler: function (validator, form, submitButton) {

            $.post('login.php', form.serialize(), function (result) {

                if (result.status == 'logged_in') {
                    // You can reload the current location
                    $('#user-signin-modal .modal-title').text('Logging In');
                    $('#user-signin-modal .modal-body').text(result.message);
                    $('#user-signin-modal .btn').addClass('hidden');
                    setTimeout(function () {
                        if (result.redirect_uri !== '') {
                            $(location).attr('href', result.redirect_uri);
                        } else {
                            $(location).attr('href', '/');
                        }
                    }, 2000);

                } else if (result.status == 'incorrect_data') {

                    $('#user-signin-modal .modal-title').text('OOPS! Login Error');
                    $('#user-signin-modal .modal-body').text(result.message);
                    $('#user-signin-modal').modal();
                    $('#user-login-form').bootstrapValidator('disableSubmitButtons', false);

                } else if ( result.status == 'not_verified'){
                    $('#user-signin-modal .modal-title').text("OOPS! Looks like you've not activated your account.");
                    $('#user-signin-modal .modal-body').text(result.message);
                    $('#user-signing-modal').modal();
                    $('#user-login-form').bootstrapValidator('disableSubmitButtons, false');
                } else {

                    $('#user-signin-modal .modal-title').text('Something Went Wrong');
                    $('#user-signin-modal .modal-body').text('Looks like your account is yet to be activated. Please check the verification email sent to you.');
                    $('#user-signin-modal').modal();
                    $('#user-login-form').bootstrapValidator('disableSubmitButtons', false);
                }
            }, 'json');
        },

        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'Email is required'
                    },
                    emailAddress: {
                        message: 'Input is not a valid email address'
                    }
                }
            },
            password: {
                message: 'Password is not valid',
                validators: {
                    notEmpty: {
                        message: 'Password is required'
                    }
                    /**stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The password must be more than 6 and less than 30 characters long'
                    },
                     regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'The username can only consist of alphabetical, number and underscore'
                    }*/
                }
            }
        }
    });

    // User login form validation

    $('#user-login-form').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'fa fa-check-circle-o fa-lg',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        submitHandler: function (validator, form, submitButton) {

            $.post(form.attr('action'), form.serialize(), function (result) {

                if (result.status == 'logged_in') {
                    // You can reload the current location
                    $('#user-signin-modal .modal-title').text('Logging In');
                    $('#user-signin-modal .modal-body').text(result.message);
                    $('#user-signin-modal .btn').addClass('hidden');

                    setTimeout(function () {
                        if (result.redirect_uri !== '') {
                            $(location).attr('href', result.redirect_uri);
                        } else {
                            $(location).attr('href', '/');
                        }
                    }, 2000);

                } else if (result.status == 'incorrect_data') {

                    $('#user-signin-modal .modal-title').text('Wrong Email or Password');
                    $('#user-signin-modal .modal-body').text(result.message);
                    $('#user-signin-modal').modal();
                    $('#user-login-form').bootstrapValidator('disableSubmitButtons', false);

                } else {

                    $('#user-signin-modal .modal-title').text('Something Went Wrong');
                    $('#user-signin-modal .modal-body').text('Looks like your account hasn\'t been activated. Please check your email including Spam folder for activation link.');
                    $('#user-signin-modal').modal();
                    $('#user-login-form').bootstrapValidator('disableSubmitButtons', false);
                }
            }, 'json');
        },

        fields: {

            email: {
                validators: {
                    notEmpty: {
                        message: 'Email is required and cannot be empty'
                    },
                    emailAddress: {
                        message: 'Input is not a valid email address'
                    }
                }
            },
            password: {
                message: 'Password is not valid',
                validators: {
                    notEmpty: {
                        message: 'Password is required and cannot be empty'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'Password must be more than 6 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'Password can only consist of alphabetical, number and underscore'
                    }
                }
            }
        }
    });

    // Restaurant signup form validation

    $("#restaurant-signup-form").bootstrapValidator({


        message: 'This value is not valid',

        feedbackIcons: {

            valid: 'fa fa-check-circle-o fa-lg',

            invalid: 'glyphicon glyphicon-remove',

            validating: 'glyphicon glyphicon-refresh'

        },

        submitHandler: function (validator, form, submitButton) {
            var request;
            var serializedData = form.serialize();
            request = $.ajax({
               url: form.attr('action'),
                type: 'POST',
                data: serializedData
            });

            request.done(function (response) {
                if(response.status === 'dispatched') {
                    console.log('im here 1' + response.message);
                    $('#restaurant-signup-modal .modal-title').text('Email Sent');
                    $('#restaurant-signup-modal .modal-body').text(response.message);
                    $('#restaurant-signup-modal .btn').hide();
                    $('#restaurant-signup-modal').modal();

                    setTimeout(function () {
                        $(location).attr('href', '/');
                    }, 5000);
                } else if (response.status === 'account_exist') {
                    console.log('im here 2' + response.message);
                    $('#restaurant-signup-modal .modal-title').text('Thanks!');
                    $('#restaurant-signup-modal .modal-body').text(response.message);
                    $('#restaurant-signup-modal').modal();
                    $('#restaurant-signup-form').bootstrapValidator('disableSubmitButtons', false);
                } else {
                    $('#restaurant-signup-modal .modal-title').text('OOPS!');
                    $('#restaurant-signup-modal .modal-body').text('Looks like something went wrong, please give it another try or email us for assistance');
                    $('#restaurant-signup-modal .modal-body').css("font-weight", 300);
                    $('#restaurant-signup-modal').modal();
                    $('#restaurant-signup-form').bootstrapValidator('disableSubmitButtons', false);

                }
            });

            request.fail(function (response) {
                console.log(response);
            })

        },

        fields: {

            firstName: {

                validators: {

                    notEmpty: {

                        message: 'The full name is required'

                    }

                }

            },


            j_email: {

                validators: {

                    notEmpty: {

                        message: 'The email is required and cannot be empty'

                    },

                    emailAddress: {

                        message: 'The input is not a valid email address'

                    }

                }

            },

            j_phoneno: {
                message: 'This field cannot be empty.',

                validators: {

                    notEmpty: {
                        message: 'Phone no is required and cannot be empty'
                    }

                }
            },

            j_postcode: {
                validators: {
                    notEmpty: {
                        message: 'Post code is required and cannot be empty'
                    }
                }
            },


            managerName: {

                validators: {

                    notEmpty: {

                        message: "Manager's name is required"

                    }

                }

            },


            j_rest_name: {

                validators: {

                    notEmpty: {

                        message: "Restaurant name is required"

                    }

                }

            },


            j_city: {

                validators: {

                    notEmpty: {

                        message: "City is required"

                    }

                }

            },

            j_rest_delivery: {
                message: 'This is a required field',
                validators: {

                    notEmpty: {

                        message: "Please let us know if you have in-house delivery staffs"

                    }

                }

            },

            j_rest_type: {
                message: 'This is a required field',
                validators: {

                    notEmpty: {

                        message: "Please select your type of Cuisine"

                    }

                }

            }

        }

    });


});




$(document).ready(function() {
    var owl = $("#restaurants");

    owl.owlCarousel({
        items: 5,
        autoPlay: false,
        navigation: true,
        pagination: false,
        paginationNumbers: false,
        itemsDesktop: [1199,5],
        itemsDesktopSmall: [1024,4],
        itemsTablet: [768,3],
        itemsMobile: [479,2],

        navigationText: [
            "<i class='fa fa-chevron-left'></i>",
            "<i class='fa fa-chevron-right'></i>"
        ]
    });

    var owl = $("#cities");

    owl.owlCarousel({
        items: 5,
        autoPlay: false,
        paginationNumbers: false,
        itemsDesktop: [1199,5],
        itemsDesktopSmall: [1024,4],
        itemsTablet: [768,3],
        itemsMobile: [479,2],

        navigationText: [
            "<i class='fa fa-chevron-left'></i>",
            "<i class='fa fa-chevron-right'></i>"
        ]
    });

    var owl = $("#testimonials");


    owl.owlCarousel({
        items : 3, //10 items above 1000px browser width
        autoPlay: false,
        navigation: true,
        pagination :true,
        paginationNumbers: false,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [1024,3],
        itemsTablet: [768,2],
        itemsMobile : [479,1],




    });

});
