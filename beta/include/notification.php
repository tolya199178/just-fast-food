<?php

if(isset($_SESSION['success'])) {
?>
	<div class="notification success">
		<img src="images/check.png" alt="" />
		<span><?php echo $_SESSION['success'];?></span>
	</div>
<?php
unset($_SESSION['success']);
}
if(isset($_SESSION['error'])) {
?>
	<div class="notification error">
		<img src="images/cross.png" alt="" />
		<span><?php echo $_SESSION['error'];?></span>
	</div>
	
<?php
unset($_SESSION['error']);
}
?>