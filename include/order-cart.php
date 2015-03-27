<?php
	@session_start();
	include('functions.php');

	if(isset($_SESSION['CART'])) {
		if($_SESSION['CART']['TOTAL'] > 0) {
			echo '<ul>';
			$iii = 0;
			foreach($_SESSION['CART'] as $key => $value) {
				if($key != 'TOTAL') {
?>
					<li>
						<div class="<?php echo ($iii %2 == 0) ? 'erow' : 'orow'?>">
							<span class="detail"><?php echo $value['QTY']; ?>x  <?php echo $value['NAME']; ?></span>
							<span>&pound; </span>
							<span class="p"><?php echo number_format($value['TOTAL'],2); ?></span>
							<span class="del fl-right b"><a href="javascript:;" title="Delete" rel="id<?php echo $value['ID']; ?>"><img src="images/button-minus.gif" alt="" /></a></span>
						</div>
					</li>
			<?php
					$iii ++;
				}
			}
			echo "</ul>";
			?>
			<div class="total b">
				<p class="fl-right">
					<span class="">Total : &nbsp;&nbsp;</span>
					<span> &pound; </span><span class="p"><?php echo number_format($_SESSION['CART']['TOTAL'], 2); ?></span>
				</p>
				<div class="clr"></div>
				<?php
					$chareged = 0;
					$save = "";
					if(isset($_SESSION['DELIVERY_CHARGES'])) {
						if($_SESSION['DELIVERY_CHARGES'] == '0'  && $_SESSION['delivery_type']['type'] == 'delivery') {
							$charges = "Free Shipping";
							$_SESSION['CART_SUBTOTAL'] = $_SESSION['CART']['TOTAL'];
						} else {
							//$chareged = round($_SESSION['DELIVERY_CHARGES'] * delivery_charges($_SESSION['DELIVERY_REST_ID']),2);
							$charges = ' &pound; '.number_format($_SESSION['DELIVERY_CHARGES'], 2);
							$_SESSION['CART_SUBTOTAL'] = $_SESSION['DELIVERY_CHARGES']+$_SESSION['CART']['TOTAL'];
							$_SESSION['SPECIAL_DISCOUNT'] = 0;

							if(isset($_SESSION['SPECIAL_OFFER'])){
								if($_SESSION['CART_SUBTOTAL'] >= $_SESSION['SPECIAL_OFFER']['pound']){
									$CART_SUBTOTAL = round(($_SESSION['CART_SUBTOTAL'] * $_SESSION['SPECIAL_OFFER']['off']) / 100, 2);
									$save = '<div class="shopping-cart"><div class="special-offer"><strong>You save &pound; '.($CART_SUBTOTAL).'</strong></div></div>';
									$_SESSION['CART_SUBTOTAL'] = $_SESSION['CART_SUBTOTAL'] - $CART_SUBTOTAL;

									$_SESSION['SPECIAL_DISCOUNT'] = $CART_SUBTOTAL;
								}
							}
						}
					}
				?>
				<p class="fl-right">
					<span class="">Delivery Charges : &nbsp;&nbsp;</span>
					<span class="p"><?php echo $charges; ?></span>
				</p>
				<div class="clr"></div>
				<?php echo $save?>
				<p class="fl-right">
					<span class="">Sub Total : &nbsp;&nbsp;</span>
					<span class="p"><?php echo '&pound; '.(number_format($_SESSION['CART_SUBTOTAL'], 2)) ?></span>
				</p>
				<div class="clr"></div>
			</div>
<?php

		} else {
			echo "true";
		}
	} else {
		echo "<span class='b'>Cart is Empty</span>";
	}

?>