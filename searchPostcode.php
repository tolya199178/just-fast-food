<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="images/favicon.ico">
	<title>Just-FastFood | Terms and Condition</title>
	<link rel="stylesheet" href="css/style1.css" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/validate.js"></script>
	
	<script type="text/javascript">

		$(document).ready(function(){

			$("#order-search").validate({
				submitHandler: function(form) {
					var val = document.post.ukpostcode.value;
					val = val.replace(' ','-');
					
					parent.eval('$.prettyPhoto.close()');
					window.location.href = 'Postcode-'+val;
					return false;
				},
				rules: {
				 ukpostcode	: "required"
			   },
				messages: {
				 ukpostcode: "UK Post code Not Valid",
				},
				errorPlacement: function ($error, $element) {
					if ($element.attr("name") == "ukpostcode") {
						$error.insertAfter($element.next().next());
					} else {
						$error.insertAfter($element);
					}
				}
			});
			$('input#postcode').focus();
		});
	</script>
	
	<style type="text/css">
		.box-wrap{
			font-size:13px;
			font-family: segoe ui, arial, helvetica, sans-serif;
			color: #222;
		}
		.box-wrap h3{
			margin:5px 0px 10px 0px;
		}
		.box-wrap strong{
			font-size:12px;
		}
		.box-wrap a{
			text-decoration:underline;
			color:#D62725;
		}
	</style>

</head>
<body>
	<div class=" box-wrap" style="margin:20px; ">
		<div class="postcodeSearch">
			<form action="" method="post" id="order-search" name="post"  style="padding:17px;">
				<label for="postcode">Enter Your Post Code :<br></label>
				<input type="text" name="ukpostcode" id="postcode" class="text required postcode" placeholder=""/>
				<input type="submit" value="Search" name="submit" class="sbtn"/>
				<div class="clr"></div>
			</form>
		</div>
	</div>
</body>
</html>