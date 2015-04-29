<?php
session_start();
//ob_start("ob_gzhandler");


//if(isset($_POST['stripeToken'])) {
  $_SESSION['CARD_PROCESSING'] = $_POST;
   print_r($_POST);
  if(!empty($_POST['N_Addr'])) {
    //$_SESSION['CARD_PROCESSING']['address'] = $_POST['N_Addr'];
    $_SESSION['CARD_PROCESSING']['postcode'] = $_POST['N_Postcode'];
  //}
  header('Location:include/card/charge.php');
  die();
}
include('include/functions.php');

$s = false;
$SET = array($_SESSION['access_key'] , $_SESSION['CART'] , $_SESSION['CURRENT_POSTCODE'], $_SESSION['type_min_order'], $_SESSION['CURRENT_MENU']);
$ERROR = false;
foreach($SET as $val) {

  if(!isset($val)) {

    $ERROR = true;
    break;

  }

}

if($ERROR){

  $_SESSION['error'] = "User Session has expired. Please login and try again.";
  header('Location:order-details.php');
  die();

}

if($_SESSION['CART_SUBTOTAL'] < $_SESSION['type_min_order']) {

  $_SESSION['error'] = "Minimum Order Amount Should Be &pound;".$_SESSION['type_min_order'];
  header('Location:'.$_SESSION['CURRENT_MENU']);
  die();

}

if($_SERVER['REQUEST_METHOD'] == 'POST') {

  $_SESSION['PAY_POST_VALUE'] = $_POST;

}

if(!isset($_SESSION['user']) && (!isset($_SESSION['userId']))) {

  $ARRAY = array('user_name', 'user_password', 'user_email', 'user_phoneno', 'user_address', 'user_address_1', 'user_city', 'user_dob', 'user_hear', 'user_status');

  $json_post = getEandN($_SESSION['CURRENT_POSTCODE']);

  if($json_post) {

    $value = "NULL, ";

    foreach($ARRAY as $values) {

      if($values == "user_password") {

        $value .= "'".md5(mysql_real_escape_string($_POST[$values]))."', ";

      } else {

        $value .= "'".mysql_real_escape_string($_POST[$values])."', ";

      }

    }

    $value .= "NULL";
    $extra = "`user_email` = '".$_POST['user_email']."'";
    $result = INSERT($value ,'user' ,'unique' ,$extra);

    if(!$result) {

      $_SESSION['error'] = "Email Address Already Exist!";
      header('Location:order-details.php');
      die();

    } else {

      $select = "`id`,`user_email`,`user_password`,`user_name`";
      $where = "`user_email` = '".$_POST['user_email']."' AND `user_password` = '".md5($_POST['user_password'])."' AND `user_status` = 'active'";
      $result = SELECT($select ,$where, 'user', 'array');

      if($result) {

        $_SESSION['user'] = $result['user_name'];
        $_SESSION['userId'] = $result['id'];

      }

    }

  } else {

    $_SESSION['error']  = "ERROR!! Invalid Post Code. <span style='font-size:13px'>( Please enter only full UK postcode)</span>";
    header('Location:order-details.php');
    die();

  }

}

//$_SESSION['CART_SUBTOTAL'] = $_SESSION['CART_SUBTOTAL'] + process_fee();




?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>


  <meta charset="UTF-8">
  <title>Order Payment - Just-FastFood</title>
  <link rel="shortcut icon" type="image/png" href="favicon.png" />

  <!--CSS INCLUDES-->
  <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,900' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
  <link href="css/archivist.css?v=1.1.0" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/responsivemobilemenu.css" type="text/css"/>
  <link href="css/media.css" rel="stylesheet">
  <link href="css/flexslider.css" rel="stylesheet">
  <link rel="stylesheet" href="css/square/blue.css" />
  <link href="css/owl.carousel.css" rel="stylesheet">
  <link href="css/owl.theme.css" rel="stylesheet">
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/script.js"></script>
  <script type="text/javascript" src="js/validate.js"></script>
  <script type="text/javascript" src="css/fancybox/jquery.fancybox.js"></script>
  <script type="text/javascript" src="js/mobileMenu.js"></script>
  <!--<script type="text/javascript" src="https://js.stripe.com/v2/"></script>-->

  <script type="text/javascript" src="js/braintree.js"></script>

  <script>
    $(document).ready(function(){
      var Addr = '<?php echo $_SESSION['PAY_POST_VALUE']['user_address'] ?>';

      var Zip = '<?php echo $_SESSION['CURRENT_POSTCODE'] ?>';
      $("#pay-by-cradit-card").bootstrapValidator({

        message: 'This value is not valid',

        feedbackIcons: {
          valid: 'fa fa-check-circle-o fa-lg',
          invalid: 'glyphicon glyphicon-remove',
          validating: 'glyphicon glyphicon-refresh'
        },


        fields: {

          card_no: {
            validators: {
              creditCard: {
                message: 'The card number entered is not valid.'
              },
              notEmpty: {
                message: '16 digits card number is required.'
              }
            }
          },

          full_name: {
            validators: {
              notEmpty: {
                message: 'Your full name is required'
              }
            }
          },

          csc: {
            validators: {
              notEmpty: {
                message: 'Last 3 digits at the back of your card.'
              }
            }
          },

          N_Postcode: {
            validators: {
              notEmpty: {
                message: 'Post code is required to validate your card.'
              }
            }
          },

          MM: {
            validators: {
              notEmpty: {
                message: 'Expiry month required.'
              }
            }
          },
          YYYY: {
            validators: {
              notEmpty: {
                message: 'Expiry year required.'
              }
            }
          }
        },



        submitHandler: function(form) {

          // TODO: Check this and compare to Pay With Cash button - We need to disable this also onClick.


            $('#submitBtn-card').attr("disabled", "disabled");

            $('#submitBtn-card').val('Sending...Please Do NOT Refresh...');

            var ccNum = $('#card_no').val(), cvcNum = $('#csc').val(), expMonth = $('#MM').val(), expYear = $('#YYYY').val(), Name = $('#full_name').val();

            if($('#N_Addr').val() != ''){

              Addr = $('#N_Addr').val();
            }

            if($('#N_Postcode').val() != ''){
              Zip = $('#N_Postcode').val();
            }

            alert('just submitted '+ ccNum);
            // Setup braintree token


            var braintree = Braintree.create('MIIBCgKCAQEA1QYEnnts3jaljycYt0HjkLP7/FsVzIjofMYtolq2TtNfsCbXB/Mx3faLitmCMY/MscZwscZiw5Lsj1YCDMDmGYqMkjPpu/jkxxTAfY3oErpobuGlwxA7LK7+Gh9lMdcAEdkwW3pVp8bNnM17dvFemB1aKpIJCzt7MGBFh5WX3rdw9xb8gT/RkTsboxaoS5iDmKXBJvV+liZFiym3hHpfChLcr5xxHXB9StExUh5eG+2J0CEUXvLElCAR0Y+vdgkMyodub3OvV+zj4l+4wqeINBcDiwlWea2vBQtv+cya+SECw8eeN6dROXpu5oQIClwnXU/rd+JYJvp9bGCwhO6/kwIDAQAB');
            braintree.onSubmitEncryptForm('#submitBtn-card');
            //return false;
          }



      });

    });


    function stripeResponseHandler(status, response) {
        // Check for an error:
        if (response.error) {
            alert(response.error.message);
        } else { // No errors, submit the form:
            var f = $("#pay-by-cradit-card");
            // Token contains id, last4, and card type:
            var token = response['id'];
            // Insert the token into the form so it gets submitted to the server
            f.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
            // Submit the form:
            f.get(0).submit();
        }
    }

  </script>

</head>
<body>
<div class="wrapper">

<?php include('templates/header2.php'); ?>

<div class="page_header">
  <div class="inner_title"><h2 class="text-center white">Ready to pay for your <span>Order</span></h2></div>

  <div class="custom_button yellow_btn small_but text-center ">
    <ul><li><a href="#" onclick="return SnapEngage.startLink();">Need help? We are online</a></li></ul>
  </div>
</div>
<div class="breadcrum">
  <ul>
    <li><a href="index.php">Begin Search</a></li>
    <li><a href="Postcode-<?php echo str_replace(' ','-',$_SESSION['CURRENT_POSTCODE']); ?>">Postcode-<?php echo $_SESSION['CURRENT_POSTCODE']; ?></a></li>
    <li><a href="<?php echo $_SESSION['CURRENT_MENU']?>"><?php echo $_SESSION['CURRENT_MENU']?></a></li>
    <li class="u">Confirm Payment</li>
  </ul>
</div>
<div class="section_inner">
<div class="container">
<hr class="hr">
<div class="col-md-12 explor">
  <!-- ORDER -->

  <div class="col-md-5">
    <div class="box-wrap order-details-wrap">
      <h3 class="order-header" style="font-weight: 300">Your Order</h3>
      <div class="hr" /></div>
    <div class="order">
      <div class="order-cart-wrap">
        <ul class="list-group cart-list">
          <?php
          $iii = 0;
          foreach($_SESSION['CART'] as $key => $value) {
            if($key != 'TOTAL') {
              ?>
              <li>
                <div class="<?php echo ($iii %2 == 0) ? 'erow' : 'orow'?>">
                  <span class="detail"><?php echo $value['QTY']; ?> x <?php echo $value['NAME']; ?></span>
                  <span class="p">&pound; <?php echo number_format($value['TOTAL'],2); ?></span>
                </div>
              </li>
              <?php
              $iii ++;
            }
          }
          ?>
        </ul>

        <div class="hr first"></div>
        <span class="charges b">Total : &pound; <?php echo number_format($_SESSION['CART']['TOTAL'], 2); ?></span>
        <div class="clr"></div>

        <div class="hr"></div>
        <span class="charges b">Delivery fee : &pound; <?php echo number_format($_SESSION['DELIVERY_CHARGES'],2)?></span>
        <div class="clr"></div>

        <div class="hr"></div>
        <!--<span class="charges b">Processing Fee : &pound; <?php echo process_fee()?></span>-->
        <div class="clr"></div>

        <div class="hr"></div>
        <span class="charges b">Discount : &pound; <?php echo number_format($_SESSION['SPECIAL_DISCOUNT'],2);?></span><div class="clr"></div>
        <div class="clr"></div>

        <div class="hr"></div>
        <span class="charges b alert alert-jff">Sub Total :  &pound;<?php echo number_format($_SESSION['CART_SUBTOTAL'],2); ?></span><div class="clr"></div>
        <div class="clr"></div>

      </div>
    </div>
  </div>
  <hr class="hr">
  <!-- / ORDER -->
  <!-- DELIVERY ADDRESS -->
  <div class="order-address box-wrap">
    <h3 style="font-weight: 300">Delivery Address</h3>
    <div class="txt-right u last-a"><a href="order-details.php">Edit</a></div>
    <p class="last-a"><?php echo $_SESSION['PAY_POST_VALUE']['user_address'].' , '.$_POST['user_city']?></p>
    <p class="last-a"><?php echo $_SESSION['CURRENT_POSTCODE']?></p>
    <p class="last-a">Phone No: <?php echo $_SESSION['PAY_POST_VALUE']['user_phoneno']?></p>
    <div>
      <span class="last-a">Order/Delivery Note:</span><br/>
      <p class="i b last-a"><?php echo $_SESSION['PAY_POST_VALUE']['order_note']?></p>
    </div>
  </div>
  <hr class="hr">
  <!--/ DELIVERY ADDRESS -->
</div>
<!-- ================
         PAYMENT
    ================= -->
<style>
  .payment-tabs-selectors {
    width: 100%;
    display: block;
    margin: 0px auto;
    text-align: center;
  }
  .payment-tabs-selectors {
    width: 100%;
    display: block;
    margin: 10px auto;
    text-align: center;
    overflow: hidden;
  }

  label {
    font-weight: 300;
  }

 .alert-jff {

    color: rgb(128, 46, 62);
    background-color: rgb(252, 227, 227);
    border-color: rgb(233, 198, 205);
  }

  .payment-tabs-selectors li {
    float: left;
    display: inline-block;
    text-align: center;
    width: 33.334%;
  }

  .order-sending .display {
    display: none;
  }
  .payment-tabs-selectors li > a {
    border: 1px solid #E74C3C;
    color: #FFF;
    height: 60px;
    line-height: 60px;
    width: 100%;
    text-align: left;
    padding: 0px 2.8em 0px 4.6em;
    background: none repeat scroll 0% 0% #E74C3C;
    text-transform: none;
    display: inline-block;
  }
  .payment-tabs-selectors li > a.selected {
    pointer-events:none;
    background-color: #fff;
    color:#000;
  }
  .payment-tabs-selectors a.tab-1st {
    border-radius: 5px 0px 0px 5px;
    border-right-color: white;
  }
  .payment-tabs-selectors a.tab-3rd {
    border-radius: 0px 5px 5px 0px;
  }

  .payment-tabs-selectors a.tab-2nd {
    border-right-color: white;
  }
  .wrapper-pay-sel {
    display: none;
  }
  .wrapper-pay-sel.selected {
    display: block;
  }
</style>
<div class="red-wrap box-wrap pay-wrap">
  <h3 style="font-weight: 300">How would you like to pay?</h3>
 <div class="col-xs-12 col-sm-8 col-lg-12">
   <nav>
     <ul class="payment-tabs-selectors">
       <li><a data-content="paypal" class="tab-1st selected" style="font-weight: 300"><i class="fa fa-paypal"></i> PayPal</a></li>
       <li><a data-content="credit-card"  class="tab-2nd selected" style="font-weight: 300"><i class="fa fa-cc-visa"></i> Card</a></li>
       <li><a data-content="cash-on-delivery" class="tab-3rd" style="font-weight: 300"><i class="fa fa-money"></i> Cash</a></li>
     </ul>
   </nav>
 </div>
  <?php include('include/notification.php');?>
  <section class="payments-tabs-content">
    <section data-content="paypal" class="wrapper-pay-sel col-md-6 selected">
      <div class="by-card b bypaypal">
        <form action="include/paypal/process.php" method="post">
          <input type='image' name='submit' src='https://www.paypalobjects.com/webstatic/mktg/Logo/AM_SbyPP_mc_vs_ms_ae_UK.png' border='0' align='top' width="200" height="75" alt='Check out with PayPal'/><br/>
          <input type='submit' name='submit' class="btn" id="pay-with-paypal" value="Place my Order"/>

          <input type="hidden" name="user_address" value="<?php echo $_SESSION['PAY_POST_VALUE']['user_address'].', '.$_SESSION['CURRENT_POSTCODE']?>"/>
          <input type="hidden" name="order_note" value="<?php echo $_SESSION['PAY_POST_VALUE']['order_note']?>"/>
          <input type="hidden" name="user_phoneno" value="<?php echo $_SESSION['PAY_POST_VALUE']['user_phoneno']?>"/>
        </form>
      </div>
      <div class="row" style="font-size:12px; padding-left:20px; margin-top:25px">
        <!--<span>* Processing Fee  : <b>&pound; <?php echo process_fee()?></b></span><br>-->
      </div>
    </section>
    <section data-content="credit-card" class="wrapper-pay-sel col-md-10 col-xs-10">
        <form action="" class="pay-by-cradit-card form-horizontal" method="post" id="pay-by-cradit-card">
          <div class="row">
            <div class="form-group has-feedback">
              <label for="" class="col-lg-3 control-label" >Card Type:</label>
              <div class="col-lg-7">
                <select name="" id="" class="select form-control">
                  <option value="">Visa </option>
                  <option value="">Mastercard </option>
                  <option value="">Visa Debit </option>
                  <option value="">Discover </option>
                  <option value="">AMEX </option>
                </select><br/>
                <img src="images/c_card.png" alt="We process" />
              </div>

            </div>
          </div>
          <div class="form-group has-feedback">
            <label class="col-lg-3 control-label" for="card_no">Card Number:<span class="required">*</span></label>
            <div class="col-lg-7">
              <input data-braintree-name="number" type="text" name="card_no" id="card_no" class="input required creditcard form-control" autocomplete="off" maxlength="20"/>
            </div>
          </div>
          <div class="form-group has-feedback">
            <label class="col-lg-3 control-label">Expiry Date:<span class="required">*</span></label>
            <div class="col-lg-7">
            <select data-braintree-name="expiration_month" name="MM" id="MM" class="col-lg-5 select required form-control" style="margin-right:10px">
                <option value="">MM</option>
                <?php
                $month = array('01'=>'Jan', '02'=>'Feb' , '03'=>'Mar' ,'04'=>'Apr' ,'05'=>'May' , '06'=>'Jun' , '07'=>'Jul' , '08'=>'Aug' , '09'=>'Sep' , '10'=>'Oct' , '11'=>'Nov' ,'12'=>'Dec');
                foreach($month as $k => $m) {
                  echo '<option value="'.$k.'">'.$k.' ('.$m.') </option>';
                }
                ?>
              </select>

          <div class="form-group has-feedback col-lg-7">
            <select data-braintree-name="expiration_year" name="YYYY" id="YYYY" class="select required form-control">
              <option value="">YYYY</option>
              <?php
              $now = date('Y');
              for($i = $now ; $i < $now + 11 ; $i ++) {
                $y = substr($i, strlen($i)-2, 2);
                echo '<option value="'.$y.'">'.$i.'</option>';
              }
              ?>
            </select>
          </div>
          </div>
         </div>
          <div class="form-group has-feedback">
            <label for="" class="col-lg-3 control-label">CVV:</label>
            <div class="col-lg-3">
              <input type="text" name="csc" id="csc" class="input required number form-control" autocomplete="off" maxlength="4"/>

            </div>
            <img src="images/card-last3digits.png" alt="" />
           <!-- <span class="last-a" style="color: orangered">Last 3 digits of the number on the back of your card</span>-->
          </div>
          <div class="form-group has-feedback">
            <label for="" class="col-lg-3 control-label">Name on Card:</label>
            <div class="col-xs-7">
              <input type="text" name="full_name" id="full_name" class="input full_name required form-control" value="<?php echo $_SESSION['PAY_POST_VALUE']['user_name']?>"/>
            </div>
          </div>
          <div class="form-group has-feedback">
            <input type="checkbox" name="same_adrress" checked="true" id="same_adrress"/><label for="" style="display:inline-block; width:auto;">Billing address the same as delivery address:</label>
          </div>
          <div class="form-group has-feedback">
            <label for="" class="col-lg-3 control-label">Address:</label>
           <div class="col-lg-7">
            <input type="text" name="N_Addr" id="N_Addr" class="input required form-control"/>
           </div>
          </div>
          <div class="form-group has-feedback">
            <label for="" class="col-lg-3 control-label" >Postcode:</label>
            <div class="col-lg-5">
              <input type="text" name="N_Postcode" id="N_Postcode" class="input required form-control" />
            </div>
          </div>
          <div class="form-group">
            <label for="" class="col-lg-3 control-label" ></label>
            <input type="submit" name="bycard" id="submitBtn-card" class="btn btn-6 btn-6a apply col-sm-push-2" value="Place my Order"/>
            <input type="hidden" name="address" value="<?php echo $_SESSION['PAY_POST_VALUE']['user_address'].', '.$_SESSION['CURRENT_POSTCODE']?>"/>
            <input type="hidden" name="postcode" value="<?php echo $_SESSION['CURRENT_POSTCODE']?>"/>
            <input type="hidden" name="access" value="<?php echo $_SESSION['access_key'];?>"/>
          </div>
         <span class="small"><?php echo $_SESSION['error'];?></span>
        </form>
      </section>
    <section data-content="cash-on-delivery" class="wrapper-pay-sel col-md-6">
      <?php
      if( is_user_corporate($_SESSION['userId']) == 'true') {
        ?>
        <div class="by-card b" style="margin-top: 24px;"><a href="javascript:;" class="slideupdown">Pay Cash On Delivery</a></div>
        <form action="include/cash-payment.php" method="post" style="margin-top: 10px;">
          <p class="small last-a">*We are currently trialing this approach. Please have cash ready for the driver.</p><br/>
          <input type='submit' name='submit' class="btn" id="pay-with-cash" value="Pay by Cash"/>
          <input type="hidden" name="user_address" value="<?php echo $_SESSION['PAY_POST_VALUE']['user_address'].', '.$_SESSION['CURRENT_POSTCODE']?>"/>
          <input type="hidden" name="order_note" value="<?php echo $_SESSION['PAY_POST_VALUE']['order_note']?>"/>
          <input type="hidden" name="user_phoneno" value="<?php echo $_SESSION['PAY_POST_VALUE']['user_phoneno']?>"/>
        </form>
      <?php } else { ?>
        <div class="by-card b" style="margin-top: 24px;"><a href="javascript:;" class="slideupdown">Pay Cash On Delivery</a></div>
        <form action="include/cash-payment.php" method="post" style="margin-top: 10px;">
          <p class="small last-a">*We are currently trialing this approach. Please have cash ready for the driver.</p><br/>
          <input type='submit' name='submit' class="btn" id="pay-with-cash" value="Place my Order"/>

          <input type="hidden" name="user_address" value="<?php echo $_SESSION['PAY_POST_VALUE']['user_address'].', '.$_SESSION['CURRENT_POSTCODE']?>"/>
          <input type="hidden" name="order_note" value="<?php echo $_SESSION['PAY_POST_VALUE']['order_note']?>"/>
          <input type="hidden" name="user_phoneno" value="<?php echo $_SESSION['PAY_POST_VALUE']['user_phoneno']?>"/>
        </form>
        <div>
              <p class="order-sending last-a"><i class="display fa fa-cog fa-spin"></i></p>
        </div>
      <?php } ?>
    </section>
</section>
</div>
</div>
</div>
</div>
<div class="clr"></div>
<?php require('templates/footer2.php');?>
<?php include_once('include/notification.php');?>

<script type="text/javascript">
  $(document).ready(function() {

    $('#pay-with-cash').on('click', function(){
     // e.preventDefault();

     // $('input:submit').attr("disabled", true);
      $('.order-sending').text('Sending your order, please wait...').addClass('alert alert-info');
    });
  });
</script>
<script>
  jQuery(document).ready(function($){
    var tabItems = $('.payment-tabs-selectors a'),
      tabContentWrapper = $('.payments-tabs-content');

    tabItems.on('click', function(event){
      event.preventDefault();
      var selectedItem = $(this);
      if( !selectedItem.hasClass('selected') ) {
        var selectedTab = selectedItem.data('content'),
          selectedContent = tabContentWrapper.find('section[data-content="'+selectedTab+'"]'),
          slectedContentHeight = selectedContent.innerHeight();

        tabItems.removeClass('selected');
        selectedItem.addClass('selected');
        selectedContent.addClass('selected').siblings('section').removeClass('selected');
        //animate tabContentWrapper height when content changes
        tabContentWrapper.animate({
          'height': slectedContentHeight
        }, 200);
      }
    });

    //hide the .cd-tabs::after element when tabbed navigation has scrolled to the end (mobile version)
    checkScrolling($('.cd-tabs nav'));
    $(window).on('resize', function(){
      checkScrolling($('.cd-tabs nav'));
      tabContentWrapper.css('height', 'auto');
    });
    $('.cd-tabs nav').on('scroll', function(){
      checkScrolling($(this));
    });

    function checkScrolling(tabs){
      var totalTabWidth = parseInt(tabs.children('.payment-tabs-selectors').width()),
        tabsViewport = parseInt(tabs.width());
      if( tabs.scrollLeft() >= totalTabWidth - tabsViewport) {
        tabs.parent('.cd-tabs').addClass('is-ended');
      } else {
        tabs.parent('.cd-tabs').removeClass('is-ended');
      }
    }
  });
</script>
</body>
</html>