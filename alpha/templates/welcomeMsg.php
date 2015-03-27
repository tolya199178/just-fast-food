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
    $QQ = $obj->query_db('SELECT `verify_email_email` FROM `verify_email` WHERE `verify_email_code` = "'. $_CODE .'"');
    if($obj -> num_rows($QQ) > 0) {
        $ROW_RESULT = $obj->fetch_db_assoc($QQ);
        $obj->query_db("UPDATE  `user` SET  `user_status` =  'active' WHERE `user_email` = '". $ROW_RESULT['verify_email_email'] ."' ");
        $obj->query_db("DELETE FROM `verify_email` WHERE `verify_email_code` = '".$_CODE."' ");
        ?>
        <div class="welcomeMsg success">
            <div class="close"></div>
            <div class="msg">
                Welcome ! Your Account is NOW activated. Please enter your Postcode to proceed with your order!
            </div>
        </div>
    <?php
    } else {
        ?>
        <div class="welcomeMsg error">
            <div class="close"></div>
            <div class="msg">
                Invalid Email Verification Code!
            </div>
        </div>
    <?php
    }
    ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.welcomeMsg .close').click(function(){
                $(this).parent().slideUp();
            });
        });
    </script>
<?php
}
}
?>