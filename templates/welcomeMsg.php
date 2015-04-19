<style>
    .button {
        background:none repeat scroll 0 0 #ff6161;
        border-radius:2em;
        box-shadow:0 0 0 rgba(0,0,0,0.4);
        color:#FFF;
        font-size:1.125em;
        font-weight:700;
        letter-spacing:.07em;
        line-height:1.5em;
        text-transform:none;
        text-align:center;
        transition:all .3s linear 0;
        vertical-align:middle;
        display:inline-block;
        border:medium none;
        padding:15px 1.5em;
        font-font: 'Lato', "Open Sans";

    }
</style>
<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Kunle
 * Date: 07/10/13
 * Time: 20:15
 * To change this template use File | Settings | File Templates.
 */



if(isset($_GET['verify_email'])) {

    $_CODE = $_GET['verify_email'];

if(strlen($_CODE) > 30) {

    ?>
    <div class="modal fade" id="account-verfication-modal" tabindex="-1" role="dialog" aria-labelledby="account-verfication-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Account Verification</h4>
                </div>
                <div class="modal-body">
    <?php

    $QQ = $obj->query_db('SELECT `verify_email_email` FROM `verify_email` WHERE `verify_email_code` = "'. $_CODE .'"');

    if($obj -> num_rows($QQ) > 0) {

        $ROW_RESULT = $obj->fetch_db_assoc($QQ);

        $obj->query_db("UPDATE  `user` SET  `user_status` =  'active' WHERE `user_email` = '". $ROW_RESULT['verify_email_email'] ."' ");

        $obj->query_db("DELETE FROM `verify_email` WHERE `verify_email_code` = '".$_CODE."' ");

        ?>

        <p>Welcome <?php $_SESSION['user']?> ! Your Account is NOW activated. Please enter your Postcode to proceed with your order!</p>
        
    <?php

    } else {

       ?>

        <p>Invalid Email Verification Code!</p>

    <?php

    }

    ?>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="button" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    <script>
        $(document).ready(function(){
            setTimeout(function(){
                $('#account-verfication-modal').modal();
            }, 500);
            
            setTimeout(function(){
                $(location).attr('href', '/');
            }, 5000);
        });
    </script>

  <!--<script type="text/javascript">

    var notification = new NotificationFx({

      wrapper: document.body,
      message: $('.p').text(),
      layout: 'growl',
      effect: 'slide',
      type: 'error',
      tt: 6000,

      onClose: function() { return false; },
      onOpen: function() { return false; }
    });

    notification.show();

  </script>-->
<?php

}

}

?>