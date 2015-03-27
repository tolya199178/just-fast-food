<?php
session_start();
ob_start("ob_gzhandler");
include("include/functions.php");
?>
<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Just Fast Food - Privacy">
    <meta name="keywords" content="Account Creation!, <?= getDataFromTable('setting','keywords'); ?>">
    <meta name="author" content="Just-FastFood">

    <title>Just-FastFood - Privacy</title>

    <!--CSS INCLUDES-->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,900' rel='stylesheet' type='text/css'>

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>



    <link href="css/archivist.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/responsivemobilemenu.css" type="text/css"/>
    <link href="css/media.css" rel="stylesheet">
    <link href="css/flexslider.css" rel="stylesheet">
    <link rel="stylesheet" href="css/square/blue.css" />


    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.theme.css" rel="stylesheet">


</head>

<body>
<div class="wrapper">
    <?php include('templates/header2.php');?>
    <div class="metahead what-we-do" style="padding: 20px 0">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1 style="text-transform: none">Privacy</h1>
                </div>
            </div>

        </div>
    </div>

    <div class="section_inner">
        <div class="container">
            <div class="row">
                <div class="span1">
                    <h3 class="nocaps">Overview</h3>
                    <p class="last">This Privacy Policy governs the manner in which Just-Fast Food.com collects, uses, maintains and discloses information collected from users (each, a "User") of the https://just-fastfood.com website ("Site"). This privacy policy applies to the Site and all products and services offered by Just-Fast Food.com.</p>
                    <h3>What information we collect?</h3>
                    <p class="last">We collect information from Users in a variety of ways, including, but not limited to, when Users visit our site, register on the site, place an order, fill out a form, and in connection with other activities, services, features or resources we make available on our Site. Users may be asked for, as appropriate, name, email address, mailing address, phone number, credit card information. We will collect personal information from Users only if they voluntarily submit such information to us. Users can always refuse to supply personal information, except that it may prevent them from engaging in certain Site related activities.</p>
                    <h3 class="nocaps">Non-personal information</h3>
                    <p class="last">We may collect non-personal identification information about Users whenever they interact with our Site. Non-personal identification information may include the browser name, the type of computer and technical information about Users means of connection to our Site, such as the operating system and the Internet service providers utilized and other similar information.</p>
                    <h3 class="nocaps">Do we use cookies?</h3>
                    <p class="last">Yes (Cookies are small files that a site or its service provider transfers to your computers hard drive through your Web browser (if you allow) that enables the sites or service providers systems to recognize your browser and capture and remember certain information.

                        Do we disclose any information to outside parties?

                        We do not sell, trade, or otherwise transfer to outside parties your personally identifiable information. This does not include trusted third parties who assist us in operating our website, conducting our business, or servicing you, so long as those parties agree to keep this information confidential. We may also release your information when we believe release is appropriate to comply with the law, enforce our site policies, or protect ours or others rights, property, or safety. However, non-personally identifiable visitor information may be provided to other parties for marketing, advertising, or other uses.</p>
                    <h3 class="nocaps">What do we use your information for?</h3>
                    <p class="last">Any of the information we collect from you may be used in one of the following ways:</p>
                    <ul class="last">
                        <li>To personalize your experience (your information helps us to better respond to your individual needs)</li>
                        <li>To improve our website (we continually strive to improve our website offerings based on the information and feedback we receive from you)</li>
                        <li>To improve customer service (your information helps us to more effectively respond to your customer service requests and support needs)</li>
                        <li>To process transactions Your information, whether public or private, will not be sold, exchanged, transferred, or given to any other company for any reason whatsoever, without your consent, other than for the express purpose of delivering the purchased product or service requested.</li>
                        <li>To send periodic emails (The email address you provide for order processing, will only be used to send you information and updates pertaining to your order.)</li>
                    </ul>
                    <h3 class="nocaps">Third party websites</h3>
                    <p class="last">Users may find advertising or other content on our Site that link to the sites and services of our partners, suppliers, advertisers, sponsors, licensors and other third parties. We do not control the content or links that appear on these sites and are not responsible for the practices employed by websites linked to or from our Site. In addition, these sites or services, including their content and links, may be constantly changing. These sites and services may have their own privacy policies and customer service policies. Browsing and interaction on any other website, including websites which have a link to our Site, is subject to that website's own terms and policies.</p>
                    <h3 class="nocaps">How we protect your information</h3>
                    <p class="last">We adopt appropriate data collection, storage and processing practices and security measures to protect against unauthorized access, alteration, disclosure or destruction of your personal information, username, password, transaction information and data stored on our Site.</p>
                    <h3 class="nocaps">Sharing your personal information</h3>
                    <p class="last">We do not sell, trade, or rent Users personal identification information to others. We may share generic aggregated demographic information not linked to any personal identification information regarding visitors and users with our business partners, trusted affiliates and advertisers for the purposes outlined above.</p>
                    <h3 class="nocaps">Changes to this privacy policy</h3>
                    <p class="last">Just-Fast Food.com has the discretion to update this privacy policy at any time. When we do, we will revise the updated date at the bottom of this page. We encourage Users to frequently check this page for any changes to stay informed about how we are helping to protect the personal information we collect. You acknowledge and agree that it is your responsibility to review this privacy policy periodically and become aware of modifications.</p>
                    <h3 class="nocaps">Your acceptance of these terms</h3>
                    <p class="last">By using this Site, you signify your acceptance of this policy. If you do not agree to this policy, please do not use our Site. Your continued use of the Site following the posting of changes to this policy will be deemed your acceptance of those changes.</p>
                    <h3 class="nocaps">Contacting us</h3>
                    <p class="last">If you have any questions about this Privacy Policy, the practices of this site, or your dealings with this site, please contact us at <a href="mailto:info@just-fastfood.com">info@just-fastfood.com</a><br></p>

                </div>
                </div>
            </div>
        </div>
    <?php include('templates/user-signup.php');?>

</div>
<?php include("templates/footer2.php");?>
</body>
</html>