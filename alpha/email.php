<?php
	if(isset($_POST['valid_recommend'])) {

		$emails = $_POST['email'];
		foreach($emails as $to) {
			$message = "Hello, <br><br><strong>".$_POST['first_name']." Invite you to join Just-FastFood.com</strong>";
			$message .= "<br><br>Regards<br>Muhammad Awais";
			$subject = $_POST['first_name']." Invite you to join";
			$headers = "From:Just-FastFood <info@just-fastfood.com>\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			mail($to, $subject, $message, $headers);
		}
	}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<script type="text/javascript" src="js/jquery.js"></script>

	<script type="text/javascript">
        $(document).ready(function() {
			//$("#recommend_form").validate();
			var no = 4;
            $('#addAnotherEmail').live('click',function() {
				var append = '<p><span class="label"><label>Email '+no+' : </label></span><span class="field"><input type="text" class="text required email" name="email[]" size="25" maxlength="50" value=""></span></p>';
				$(this).before(append);
				no ++;
			});
		});
	</script>
	<style type="text/css">
		.recommended{
			border:1px solid #000;
			width:50%;
			margin:0px auto;
			padding:15px;
			font-family:verdana;
			font-size:13px;
		}
		.recommended .text{
			width:250px;
			border:1px solid #000;
		}
		.recommended .label{
			display:inline-block;
			width:150px;
		}
	</style>
</head>
<body>
	<div class="recommended">
		<form action="" method="post" class="sign" name="recommend_form" id="recommend_form">
			<p>
				<span class="label"><label>Your username : </label></span>
				<span class="field"><input type="text" class="text" name="first_name" size="25" maxlength="50" value=""></span>
			</p>
			<p>
				<span class="label"><label>Your email : </label></span>
				<span class="field"><input type="text" class="text" name="email" size="25" maxlength="50" value=""></span>
			</p>
			<p class="info">Enter the email(s) or your friends :</p>
			<p>
				<span class="label"><label>Email 1 : </label></span>
				<span class="field"><input type="text" class="text" name="email[]" size="25" maxlength="50" value=""></span>
			</p>
			<p>
				<span class="label"><label>Email 2 : </label></span>
				<span class="field"><input type="text" class="text" name="email[]" size="25" maxlength="50" value=""></span>
			</p>
			<p>
				<span class="label"><label>Email 3 : </label></span>
				<span class="field"><input type="text" class="text" name="email[]" size="25" maxlength="50" value=""></span>
			</p>
			<a href="javascript:;" id="addAnotherEmail">Add Another Email</a></br>
			<input  type="submit" name="valid_recommend" value="SEND">
		</form>
	</div>

</body>
</html>