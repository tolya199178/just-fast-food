/**
 * Created with JetBrains PhpStorm.
 * User: Kunle
 * Date: 13/10/13
 * Time: 16:38
 * To change this template use File | Settings | File Templates.
 */


function showErrorDialogWithMessage(message)
{
    //
    alert(message);
}

$(document).ready(function(){
$('#pay-by-cradit-card').attr(function(event){
$('#btnSubmitCard').attr("disabled", "disabled");
    });
 var fName   = $('#first_name').val();
 var lName   = $('#last_name').val();
 var email   = $('#email').val();
 var cardNumer = $('#card_no').val();
 var cardCVC = $('#csc').val();

    if(fName === "") {
        showErrorDialogWithMessage("Please enter your first name");
        return;
    }
    if (lName === "") {
        showErrorDialogWithMessage("Please enter your last name");
        return;
    }

    Stripe.createToken({
        number: cardNumer,
        cvc : cardCVC,
        exp_month : $('#MM').val(),
        exp_year : $('#YYYY').val()
    }, stripeResponseHandler)
    return false;
})

function stripeResponseHandler(status, response){
    if(response.error) {
        alert(response.error.message)
    } else {
        var token = response.id;
        var firstName = $('#first_name').val();
        var lastName  = $('#last_name').val();
        var email     = $('#email').val();

        var request = $.ajax({
            type: "POST",
            url: "pay.php",
            dataType:"json",
            data: {
                "stripeToken" : token,
                "firstName" : firstName,
                "lastName" : lastName,
                "email" : email,
                "price" : '<?php echo number_format($Total, 2) ?>'
            }
        });
        request.done(function(msg){
            if (msg === 0) {
                alert("Your card was successfully charged");
            } else {
                alert("Credit card failed");
            }
        });
            request.fail(function(jqXHR, textStatus){
                alert("Error: failed to call pay.php to process the transaction.");
            })
    }
}

