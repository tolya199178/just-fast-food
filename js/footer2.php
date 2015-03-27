<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Kunle
 * Date: 25/05/14
 * Time: 19:52
 * To change this template use File | Settings | File Templates.
 */
?>
<div class="footer">
    <div class="container">
        <div class="col-lg-4">
            <div class="f_title"><h3 class="white">Contact Us</h3></div>
            <div class="f_list">
                <ul>
                    <li>45-157 ST JOHN STREET <br>
                        LONDON, ENGLAND<br>
                        EC1V 4PW</li>
                    <li>info@just-fastfood.com</li>
                    <li>
                        <div class="social_links">
                            <ul>
                                <li><a href=""><img src="images/f.png"></a></li>
                                <li><a href=""><img src="images/t.png"></a></li>
                                <li><a href=""><img src="images/g.png"></a></li>
                                <li><a href=""><img src="images/in.png"></a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="f_title"><h3 class="white">We're currently covering</h3></div>
            <div class="f_list">
                <ul>
                    <li><a href="#">Central London</a></li>
                    <li><a href="#">South London</a></li>
                    <li><a href="#">North London</a></li>
                    <li><a href="#">West London</a></li>
                    <li><a href="#">Birmingham</a></li>
                    <li><a href="#">Portsmouth</a></li>
                    <li><a href="#">Manchester</a></li>
                    <li><a href="#">Leeds</a></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="f_title"><h3 class="white">Latest Tweets</h3></div>
        
            <div id="tweets">
            </div>
        </div>
        <div class="b_links col-lg-12">
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../what-we-do.php">What We Do</a></li>
                <li><a href="../how-it-works.php">How It Works</a></li>
                <li><a href="javascript:;" id="res-menu-modal-init">Restaurants</a></li>
                <li><a href="../career.php">Careers</a></li>
                <li><a href="../privacy.php">Privacy</a></li>
                <li><a href="../terms.php">Terms</a></li>
                <li><a href="../contact.php">Contact</a></li>
            </ul>
        </div>
    </div>
</div>
</div>
<script src="js/jquery.newsTicker.js"></script>
<script src="js/validate.js"></script>
<script src="js/bootstrapValidator.min.js"></script>
<script src="js/bootstrap-dialog.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.flexslider.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/responsivemobilemenu.js"></script>
<script src="js/iCheck.min.js"></script>
<script src="js/jquery.stickyscroll.js"></script>
<script src="js/script.js"></script>
<script src="js/twitterFetcher.min.js"></script>
<script>
    var nt_example1 = $('#nt-example1').newsTicker({
        row_height: 90,
        max_rows: 5,
        duration: 2000,
        autostart:1,
        prevButton: $('#nt-example1-prev'),
        nextButton: $('#nt-example1-next')
    });
    $(document).ready(function() {
        twitterFetcher.fetch('483729890701631488', 'tweets', 3, true, true, true, '', false, handleTweets, false);

        function handleTweets(tweets){
            var x = tweets.length;
            var n = 0;
            var element = document.getElementById('tweets');
            var html = '<ul class="list-group">';
            while(n < x) {
              html += '<li class="list-group-item">' + tweets[n] + '</li>';
              n++;
            }
            html += '</ul>';
            element.innerHTML = html;
        }
    });
</script>
<!-- begin SnapEngage code -->
<script>
    (function() {
        var se = document.createElement('script'); se.type = 'text/javascript'; se.async = true;
        se.src = '//commondatastorage.googleapis.com/code.snapengage.com/js/50c34b0c-cee6-4805-a20a-f5f056273194.js';
        var done = false;
        se.onload = se.onreadystatechange = function() {
            if (!done&&(!this.readyState||this.readyState==='loaded'||this.readyState==='complete')) {
                done = true;
                /* Place your SnapEngage JS API code below */
                /* SnapEngage.allowChatSound(true); Example JS API: Enable sounds for Visitors. */
            }
        };
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(se, s);
    })();
</script>
<!-- end SnapEngage code -->
<!-- SessionCam Client Integration v6.0 -->
<script>
//<![CDATA[
var scRec=document.createElement('SCRIPT');
scRec.type='text/javascript';
scRec.src="//d2oh4tlt9mrke9.cloudfront.net/Record/js/sessioncam.recorder.js";
document.getElementsByTagName('head')[0].appendChild(scRec);
//]]>
</script>
<!-- End SessionCam -->
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>