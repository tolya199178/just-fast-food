<?php



/**



 * Created by JetBrains PhpStorm.



 * User: Kunle



 * Date: 25/05/14



 * Time: 18:20



 * To change this template use File | Settings | File Templates.



 */

function youAreHere($url) {



  $request_url = $_SERVER['PHP_SELF'];

  if ( $request_url== '/index.php' && $url == 'index.php' ) {

    echo 'class="active"';

  }

  else if ( strpos($request_url,'career') !== false && $url == 'career' )

  {

    echo 'class="active"';

  }

  else if ( strpos($request_url,'contact') !== false && $url == 'contact' )

  {

    echo 'class="active"';

  }

  else if ( strpos($request_url,'what-we-do') !== false && $url == 'what-we-do' )

  {

    echo 'class="active"';

  }

  else if ( strpos($request_url,'how-it-works') !== false && $url == 'how-it-works' )

  {

    echo 'class="active"';

  }

  else if (strpos($request_url, 'faq') !== false && $url == 'faq')
  {
    echo 'class="active"';
  }


}

?>

<style>

  .button {
    background-color: #E56C15;
    color: white;
    padding: 5px 7px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    -moz-background-clip: padding;
    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    cursor: pointer;
  }

  li .cart-items {
    font-size: 11px;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    background: rgb(91, 192, 91);
    border-radius: 2px;
    color: rgb(255, 255, 255);
    display: inline-block;
    font-weight: 600;
    height: 16px;
    line-height: 16px;
    min-width: 16px;
    padding: 0 5px;
    position: relative;
    right: 8px;
    top: -17px;
    cursor: pointer;
  }

  .logins ul li a.btnClass {
    text-decoration:none;
    font-size: 12px;
    color: #fff;
    font-width: 400;
    border-radius: 999em;
  }

  @media only screen and (max-width: 480px) {
    .btnClass {
      display: none;
    }
  }

  @media only screen and (max-width: 480px) {
    li.basket-counter {
      display: none;
    }
  }




</style>
<div class="header">



  <div class="container">



    <div class="logins">



      <ul>



        <?php



        if(isset($_SESSION['user'])) {



          if(isset($_SESSION['user_type'])){



            if($_SESSION['user_type'] == 'takeaway'){



              echo '<li><a href="takeaway-profile.php" title="Go to My Profile (takeaway)"><i class="fa fa-user"></i> '.$_SESSION['user'].'</a></li>';



            } else {



              echo '<li><a href="staff-profile.php" title="Go to My Profile (staff)"><i class="fa fa-user"></i> '.$_SESSION['user'].'</a></li>';

            }

          } else {

            echo '<li><a href="my-profile.php" title="Go to My Profile"><i class="fa fa-user"></i> '.$_SESSION['user'].'</a></li>';
          }

          echo '<li><a href="include/signout.php" title="Signout from your current session"><i class="fa fa-unlock-alt"></i> Signout</a></li>';
          echo '<li><a href="#" onclick="return SnapEngage.startLink();"><i class="fa fa-weixin"></i> Live Chat</a> ';

        } else {

          ?>
          <!--<li><img src="images/login.png" alt="any food delivery"><a href="#" onclick="return SnapEngage.startLink()";>Live Chat</a></li>
          <li><img src="images/register.png" alt="delivery mcdonalds uk"><a href="signup.php">Signup</a></li>-->

          <li><a href="login.php"><i class="fa fa-user"></i> Sign In</a></li>
          <li><a href="restaurant-owner.php"><i class="fa fa-cutlery"></i> Restaurant Owner?</a></li>
          <li><a href="../driver-apply.php" class="button btnClass" id="hiring">We're hiring!</a></li>
        <?php } ?>

      </ul>
    </div>

    <style>

    .Social_counters {
        position: relative;
    }
    section[data-content="modal-cart"] {
        display: none;
        position: absolute;
        z-index: 999999;
        width: 340px;
        background-color: #ffffff;
        left: 10px;
        border-radius: 5px; 
        padding: 10px;
        border: 2px solid #ddd;      
    }
    </style>
    <div class="Social_counters">
      <ul>
        <?php

        if(isset($_SESSION['user'])) {

          ?>
          <li class="basket-counter" data-action="show-hide-modal-cart"><a href="#"><i class="glyphicon glyphicon-shopping-cart icon-flipped" style="top: -1px"></i></a> <span class="cart-items" id="header-cart-items" data-show="0">0</span></li> 
        <?php

        }
        ?>
        <li><iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FJustFastFoods&amp;width81&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:81px; height:21px;" allowTransparency="true"></iframe></li>


        <li class="twitter-button"><a href="https://twitter.com/JustFastFood" class="twitter-follow-button" data-width="85px" data-show-count="true" data-lang="en" data-show-screen-name="false">Follow</a></li>

        <script src="js/jquery-1.10.0.min.js" type="text/javascript"></script>
      </ul>
      <section data-content="modal-cart"></section>
    </div>
    <div class="clearfix"></div>



    <div class="logo col-lg-4 col-sm-12 col-md-4"><a href="../index.php"><img src="images/logo2.png" class="img-responsive" alt="food delivery" ></a></div>



    <div class="rmm col-lg-8 col-md-8 col-sm-12 col-xs-12">



      <ul class="nav-list">

        <li><a <?php youAreHere('index.php'); ?> href="index.php">Home</a></li>

        <li><a <?php youAreHere('what-we-do'); ?> href="what-we-do.php">What we do</a></li>

        <li><a <?php youAreHere('how-it-works'); ?> href='how-it-works.php'>How it works</a></li>

        <li><a href="javascript:;" id="res-menu-modal-init">Restaurants</a></li>

        <li><a <?php youAreHere('contact'); ?> href="contact.php">Contact</a></li>

        <li><a <?php youAreHere('faq'); ?> href="faq.php">FAQ</a></li>

      </ul>

    </div>

  </div>

</div>

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,800italic,400,600,700,800' rel='stylesheet' type='text/css'>
<link href="css/NotificationStyles/css/ns-style-growl.css" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,700,700italic,900' rel='stylesheet' type='text/css'>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Lato:100,300,400' rel='stylesheet' type='text/css'>

<script type="text/javascript">
  $(document).ready(function(){
    $('.nav-list li a').click(function(){
      $(this).addClass('active').siblings().removeClass('active');
    });
  });

</script>

<!-- ======================MODAL====================== -->

<div class="modal fade" id="res-menu-modal" tabindex="-1" role="dialog" aria-labelledby="res-menu-modal" aria-hidden="true" style="overflow:hidden; z-index:99999999999999999999;">

  <div class="modal-dialog">

    <div class="modal-content" style="overflow: hidden;">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        <h4 class="modal-title">Choose A Restaurant</h4>

      </div>

      <div class="modal-body col-md-12" style="overflow: hidden;">

        <div class="col-md-6">

          <ul class="list-group">

            <li class="list-group-item m-header" style="font-family: Roboto">Fastfood</li>

            <?php

            $query = "SELECT `type_id`,`type_name`,`type_category` FROM `menu_type` WHERE `type_category`= 'fastfood'";

            $valueOBJ = $obj->query_db($query);

            while($res = $obj->fetch_db_assoc($valueOBJ)) {

              echo '<li class="list-group-item"><a href="#" data-type="'.$res['type_category'].'" rel="'.$res['type_id'].'">'.$res['type_name'].'</a></li>';

            }

            ?>

          </ul>

        </div>

        <div class="col-md-6">



          <ul class="list-group">



            <li class="list-group-item m-header" style="font-family: 'Lato', 'Open Sans'">Takeaways</li>



            <?php



            $query = "SELECT `type_id`,`type_name`,`type_category` FROM `menu_type` WHERE `type_category`= 'takeaway'";



            $valueOBJ = $obj->query_db($query);



            while($res = $obj->fetch_db_assoc($valueOBJ)) {



              echo '<li class="list-group-item"><a href="#" data-type="'.$res['type_category'].'" rel="'.$res['type_id'].'|'.$res['type_category'].'">'.$res['type_name'].'</a></li>';


            }

            ?>
          </ul>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="find-res-pc-modal" tabindex="-1" role="dialog" aria-labelledby="find-res-pc-modal" aria-hidden="true" style="overflow:hidden; z-index:99999999999999999999;">
  <div class="modal-dialog">
    <form id="find-res-pc-modal-form">
      <div class="modal-content" style="overflow: hidden;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Enter Your Postcode</h4>
        </div>
        <div class="modal-body" style="overflow: hidden;">

          <div class="form-group has-feedback">

            <label class="control-label" for="user_phone">Enter your postcode</label>

            <div class="col-lg-6">

              <input type="text" required="" name="ukpostcode" id="postcodeuk" class="form-control" autocomplete="off" placeholder="e.g SW7 5HR"/>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="submit" value="Search" name="submit" class="btn btn-custom"/>
        </div>
      </div>
    </form>
  </div><!-- /.modal-content -->



</div><!-- /.modal-dialog -->



</div><!-- /.modal -->



<script>



$(document).ready( function(){


  $('#res-menu-modal-init').click( function() {



    $('#res-menu-modal').modal();



  });



  $('#res-menu-modal .list-group-item a').click( function() {


    $('#postcodeuk').attr('data-type', $(this).attr('data-type') );



    $('#postcodeuk').attr('data-type-id', $(this).attr('rel') );



    $('#postcodeuk').attr('data-restuarant-name', $(this).text() );



    $('#res-menu-modal').modal('hide');



    $('#find-res-pc-modal').modal();

  });


  $("#find-res-pc-modal-form").bootstrapValidator({



    submitHandler: function(form) {



      var dataPostCode = $('#postcodeuk');



      var val = dataPostCode.val();



      if(val.length == 6) {



        var first3 = val.substr(0, 3);



        var lastPart = val.substr(3, val.length);



        val = first3+'-'+lastPart;



      } else {



        var first4 = val.substr(0, 4);



        var last4  = val.substr(4, val.length);



        val = first4 + '-'+last4;



      }


      if (val.indexOf(' ') >= 0){



        val = val.replace(' ','');



      }



      window.location.href = 'loadRestaurant.php?id=' + $(dataPostCode).attr('data-type-id')



      + '&postcode='+ val



      + '&name='+ $(dataPostCode).attr('data-restuarant-name')



      + '&cat=' + $(dataPostCode).attr('data-type');



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



          notEmpty: {







            message: 'Postcode is required and cannot be empty'







          },



          zipCode: {



            country: 'GB',



            message: 'The value is not a valid UK postcode'



          }



        }



      }



    }



  });







});



</script>