<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Kunle
 * Date: 23/03/13
 * Time: 14:00
 * To change this template use File | Settings | File Templates.
 */

require "include/facebook/facebook.php";

//Create an application instance
//Replace this with your appID and secret


$facebook = new Facebook(  array(
'appId' => '445882318854564',
'secret' => 'b6a54a3b79624a8695ec779c8ec935f8',
 'cookie' => true
));
//Get User ID

$user = $facebook->getUser();

// We may or may not have this data based on whether
// the user s logged in. If we have a user id here, it means
// we know the user is logged into Facebook. An access token
// is invalid if the user logged out of Facebook.

if($user)
{
    try {

         // Proceed knowing we have a logged in user who's authenticated.
       $login_Url_params = (array(
               'scope' => 'publish_stream,read_stream,offline_access,manage_pages',
               'fbconnect' => 1,
               'redirect_uri' => 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));

        $login_Url = $facebook->getLoginUrl($login_Url_params);
        //redirect to the login URL on facebook
        header("Location: {$login_Url}");
        exit();

      //  echo '<sp><a href="', $loginUrl, '" target="_top>login</a></p>';
       // $user_profile = $facebook->api('/me');
    } catch (FacebookApiException $e)
    {   error_log($e);
       // $user = null;

    }

}

// Login or Logout URL's needed depending on current user state.


?>

<!doctype html>
    <html xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <title>
            Facebook Login Page
        </title>
        <style>
            body {
                font-family: lucida 'Lucida Grande' Verdana, RockwellRegular, sans-serif;

            }
            h1 a {
                text-decoration: none;
                color: #3b5998;
            }
            h1 a:hover {
                text-decoration: underline;

            }
        </style>
    </head>
<body>
    <h1> Facebook Login Page </h1>
<?php if ($user): ?>
<a href="<?php echo $logoutUrl; ?>">Logout</a>
<?php endif ?>

<h3>
    PHP Session
</h3>
<pre> <?php print_r($_SESSION); ?></pre>
<!--<?php if($user): ?>-->
<h3> You </h3>
<img src="https://graph.facebook.com/<?php echo $user; ?>">
<h3> Your User Object (/me)</h3>
<pre><?php print_r($user_profile); ?> </pre>

</body>
</html>
<?php endif?>