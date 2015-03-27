<?php
if(isset($_SESSION['success'])) {
?>	<script type="text/javascript">
        $(document).ready(function(){
            ("<?php echo addslashes($_SESSION['success']);?>",
                {type: "info"});
        });
    </script>
    <?php	unset($_SESSION['success']);
}
if(isset($_SESSION['error'])) {
?>
    <script type="text/javascript">
        $(document).ready(function(){
            ("<?php echo addslashes($_SESSION['error']);?>",{type: "error"});
        });
	</script>
<?php
unset($_SESSION['error']);
}
?>