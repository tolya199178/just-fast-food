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
                <div class="modal-body" style="font-weight: 300">
    <?php

    $QQ = $obj->query_db('SELECT `verify_email_email` FROM `verify_email` WHERE `verify_email_code` = "'. $_CODE .'"');

    if($obj -> num_rows($QQ) > 0) {

        $ROW_RESULT = $obj->fetch_db_assoc($QQ);

        $obj->query_db("UPDATE  `user` SET  `user_status` =  'active' WHERE `user_email` = '". $ROW_RESULT['verify_email_email'] ."' ");

        $obj->query_db("DELETE FROM `verify_email` WHERE `verify_email_code` = '".$_CODE."' ");

        ?>
        <p>Thanks <?php echo substr($_SESSION["PAY_POST_VALUE"]["user_name"], 0, strpos($_SESSION["PAY_POST_VALUE"]["user_name"], ' '));?>! Your Account verification is now complete. Please proceed to complete your order!</p>
        
                    <?php

                    } else {

                       ?>

                        <p>Invalid Email Verification Code!</p>

                    <?php

                    }

                    ?>

                </div>
                <div class="modal-footer">
                    <!--<button type="button" class="btn-lg btn-primary" data-dismiss="modal">Close</button>-->
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
                $(location).attr('href', 'order-details.php');
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