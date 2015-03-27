<?php
function google_analytics($buffer) {
$ga = <<<END
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-37797313-1'],['_trackPageview'],['b._setAccount', 'UA-37894659-1'],['b._trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
END;

return str_ireplace("</body>", "{$ga}</body>", $buffer);

}
ob_start("google_analytics");

?>