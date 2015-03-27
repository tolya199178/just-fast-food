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
                    <li><a href="">Portsmouth</a></li>
                    <li><a href="">Cosham</a></li>
                    <li><a href="">Southampton</a></li>
                    <li><a href="">Fareham</a></li>
                    <li><a href="">Havant</a></li>
                    <li><a href="">Gosport</a></li>
                </ul>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="f_title"><h3 class="white">Latest Tweets</h3></div>
            <div class="f_list">
                <ul>
                   <li>
                        <a class="twitter-timeline"  href="https://twitter.com/JustFastFood" data-widget-id="274119642040115200"></a></li>
                </ul>
            </div>

        </div>

        <div class="b_links col-lg-12">
            <ul>
                <li><a href="">Home </a></li>

                <li><a href="">What We Do </a> </li>
                <li><a href="">How It Works </a> </li>
                <li> <a href="">Restaurants </a> </li>
                <li><a href="">Careers  </a></li>
                <li><a href="">Privacy Policy </a> </li>
                <li><a href="">Terms & Conditions </a> </li>
                <li><a href="">Contact  </a></li>
            </ul>
        </div>


    </div>

</div>

</div>

<script src="js/jquery.newsTicker.js"></script>
<script>

    var nt_example1 = $('#nt-example1').newsTicker({
        row_height: 90,
        max_rows: 5,
        duration: 2000,
        autostart:1,
        prevButton: $('#nt-example1-prev'),
        nextButton: $('#nt-example1-next')
    });

</script>
<script src="https://maps.google.com/maps?file=api&amp;v=2&amp;key=AIzaSyBReUANbeQ7hbO-ewBbT9PE6GWf0PsGxiE&sensor=false" type="text/javascript"></script>
<script src="https://www.google.com/uds/api?file=uds.js&v=1.0&key=AIzaSyBReUANbeQ7hbO-ewBbT9PE6GWf0PsGxiE&sensor=false" type="text/javascript"></script>
<script type="text/javascript" src="../../../js/validate.js"></script>
<script src="https://code.jquery.com/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="js/bootstrapValidator.min.js"></script>


<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.flexslider.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/responsivemobilemenu.js"></script>

<script type="text/javascript">
    var map;
    var localSearch = new GlocalSearch();

    function usePointFromPostcode(postcode, callbackFunction)
    {
        localSearch.setSearchCompleteCallback(null,
            function() {
                if(localSearch.result[0]) {
                    var resultLat = localSearch.result[0].latitude;
                    var resultLng = localSearch.result[0].longitude;
                    var point = new GLatLng(resultLat,resultLng);
                    callbackFunction(point);
                }else {
                    alert("Postcode not found!");
                }
            });
        localSearch.execute(postcode + ", UK")
    }
</script>


<script type="text/javascript">
    $(document).ready(function(){
        $(".even, .odd, .text, .no").each(function(){
            $(this).hover(function(){
                $(this).toggleClass('shadow');
                $(this).animate({
                    transform: 'translateX(6px)'
                });
            });
        })
    });
</script>


<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>