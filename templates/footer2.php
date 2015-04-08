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
    <hr class="hr" style="margin-bottom: 0; margin-top: 0; background-image: -webkit-linear-gradient(left, rgba(0, 0, 0, 0), rgba(169, 149, 149, 0.75), rgba(0, 0, 0, 0))">
    <div class="col-lg-4">
      <div class="f_title fa"><h3 class="white" style="text-transform: none">Contact Us</h3></div>
      <div class="f_list">
        <ul>
          <li>45-157 ST JOHN STREET <br>
            LONDON, ENGLAND<br>
            EC1V 4PW</li>
          <li><a href="mailto:info@just-fastfood.com">info@just-fastfood.com</a></li>
          <li>
            <div class="social_links">
              <ul>
                <li><a href="http://www.facebook.com/JustFastFoods"><i class="fa fa-facebook-square fa-2x"></i></a></li>
                <li><a href="http://www.twitter.com/JustFastFood"><i class="fa fa-twitter-square fa-2x"></i></a></li>
                <li><a href="https://plus.google.com/u/0/b/115653630842872062495/115653630842872062495/posts"><i class="fa fa-google-plus-square fa-2x"></i></a></li>
              </ul>
            </div>
          </li>
        </ul>
      </div>

    </div>

    <div class="col-lg-4">
      <div class="f_title"><h3 class="white" style="text-transform: none">Area Covered</h3></div>
      <div class="f_list">
        <ul>
          <li>London</li>
          <li>Birmingham</li>
          <li>Manchester</li>
          <li>Portsmouth</li>
          <li>Leicester</li>

        </ul>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="f_title"><h3 class="white" style="text-transform: none">Latest Tweets</h3></div>
      <div id="tweets" class="tweets">
      </div>
    </div>
    <div class="b_links col-lg-8">
      <ul>
        <li><a href="../index.php">Home</a></li>
        <li><a href="../what-we-do.php">What We Do</a></li>
        <li><a href="../how-it-works.php">How It Works</a></li>
        <li><a href="javascript:;" id="res-menu-modal-init">Restaurants</a></li>
        <!-- <li><a href="../restaurant-owner.php">Restaurants Owner</a></li>-->
        <li><a href="../driver-apply.php">Become A Courier</a></li>
        <li><a href="../privacy.php">Privacy</a></li>
        <li><a href="../terms.php">Terms</a></li>
        <li><a href="../contact.php">Contact</a></li>
      </ul>
    </div>
  </div>
</div>
<script src="js/jquery.newsTicker.js"></script>
<script src="js/bootstrapValidator.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.flexslider.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/custom.js?v1.1.6"></script>
<script src="js/responsivemobilemenu.js"></script>
<script src="js/iCheck.min.js"></script>
<script src="js/twitterFetcher.min.js"></script>
<script src="//platform.twitter.com/widgets.js"></script>
<script src="js/tweetie.min.js"></script>
<script src="../css/NotificationStyles/js/notificationFx.js"></script>
<script src="../css/NotificationStyles/js/modernizr.custom.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
  $(document).ready(function() {

    /* $('#tweets').twittie({
     username: 'JustFastFood',
     count: 3,
     apiPath: 'include/twitter-api/tweet.php',
     template: '<li class="list-group-item">{{tweet}}</li>'
     }); */

    twitterFetcher.fetch('483729890701631488', '', 2, true, true, true, '', false, handleTweets, false);

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

  var nt_example1 = $('#nt-example1').newsTicker({
    row_height: 90,
    max_rows: 5,
    duration: 2000,
    autostart:1,
    prevButton: $('#nt-example1-prev'),
    nextButton: $('#nt-example1-next')
  });
</script>

<script src="js/script.js?v1.0.6"></script>
<!--Begin Clicky Web Analytics Tracking Code -->



<!-- begin SnapEngage code -->
<script type="text/javascript">
  (function() {
    var se = document.createElement('script'); se.type = 'text/javascript'; se.async = true;
    se.src = '//storage.googleapis.com/code.snapengage.com/js/e9b9d177-05e7-4a00-b194-3aa459f6dc6a.js';
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



<!-- Google Analytics Start -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-37894659-1', 'auto');
  ga('send', 'pageview');

</script>
<!-- Google Analytics End -->



