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
						<div class="<?php echo ($iii %2 == 0) ? 'erow' : 'orow'?>" style="margin-top: 10px">
							<span class="detail"><?php echo $value['QTY']; ?> x <?php echo $value['NAME']; ?></span>
							<span class="fl-right b"><a class="del" href="javascript:;" title="Delete" rel="id<?php echo $value['ID']; ?>" data-item-name="<?php echo $value['NAME']; ?>"><i class="fa fa-trash-o btn btn-danger"></i></a></span>
							<span class="p">&pound; <?php echo number_format($value['TOTAL'],2); ?></span>
						</div>
					</li>
			<?php
					$iii ++;
				}
			}
			echo "</ul>";
			?>
      <style type="text/css">
        .alert-cart {

          color: rgb(128, 46, 62);
          background-color: rgb(252, 227, 227);
          border-color: rgb(233, 198, 205);

        }
      </style>
			<div class="total b" style="margin-right: 20px;">
			    <div class="cart-hr first"></div>
				<span class="charges b">Total : &nbsp;&nbsp; &pound; <?php echo number_format($_SESSION['CART']['TOTAL'], 2); ?></span>
				</span><div class="clr"></div>
				<?php
					$chareged = 0;
					$save = "";
					if(isset($_SESSION['DELIVERY_CHARGES'])) {
						if($_SESSION['DELIVERY_CHARGES'] == '0'  && $_SESSION['delivery_type']['type'] == 'delivery') {
							$charges = "Free Shipping";
							$_SESSION['CART_SUBTOTAL'] = $_SESSION['CART']['TOTAL'];
						} else {
							//$chareged = round($_SESSION['DELIVERY_CHARGES'] * delivery_charges($_SESSION['DELIVERY_REST_ID']),2);

              $pcode = $_SESSION['CURRENT_POSTCODE'];


              /*if($pcode[0] == 'S' || $pcode[0] == 'W' || $pcode[0] == 'E' || $pcode[0] == 'N'){
                $charges = ' &pound;' . ($_SESSION['DELIVERY_CHARGES'] + 1);
                 $_SESSION['CART_SUBTOTAL'] = ($_SESSION['DELIVERY_CHARGES'] + 1) + $_SESSION['CART']['TOTAL'];
                } else {
                $charges = ' &pound;'.number_format($_SESSION['DELIVERY_CHARGES'], 2);
                $_SESSION['CART_SUBTOTAL'] = $_SESSION['DELIVERY_CHARGES'] + $_SESSION['CART']['TOTAL'];

              } */
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
                <div class="cart-hr"></div>
                <span class="charges b" style="width: 100%; text-align: right;">Delivery Fee : <?php echo $charges; ?></span>
                <div class="clr"></div>
				<?php echo $save; ?>
				<div class="cart-hr"></div>
				<span class="charges b alert alert-cart">Sub Total :  <?php echo '&pound; '.(number_format($_SESSION['CART_SUBTOTAL'], 2)) ?></span>
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