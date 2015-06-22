<?php
	@session_start();
	//unset($_SESSION['CART']);
	include('functions.php');
?>
<div class="shopping-cart">
	<button type="button" class="buttonCART redbtn">CART</button>
	<div class="container">
		<?php
			if(isset($_SESSION['CART'])) {
				if($_SESSION['CART']['TOTAL'] > 0) {
					$str = '<ul>';
					foreach($_SESSION['CART'] as $key => $value) {
						if($key != 'TOTAL') {
							$str .= '<li>';
							$str .= '<div><span class="qty">'.$value['QTY'].' x </span>   <span class="name">'.$value['NAME'].'</span><a class="del fl-right" href="javascript:;" rel="id'.$key.'" ><img src="images/button-.gif" alt="" /></a><sapn class="price b fl-right"> &pound; '.number_format($value['TOTAL'],2).'</sapn></div><div class="clr"></div>';
							$str .= '</li>';
						}
					}
					$str .= '</ul>';
					echo $str;
					$save = "";
					echo '<span class="fl-right b">Total :  &nbsp;&nbsp;&pound; '.number_format($_SESSION['CART']['TOTAL'],2).'</span><div class="clr"></div>';
					$chareged = 0.0;
                    echo 'A'. $_SESSION['DELIVERY_COST'];
					if(isset($_SESSION['DELIVERY_COST'])) {
						if($_SESSION['DELIVERY_COST'] == '0' && $_SESSION['delivery_type']['type'] == 'delivery') {
							$charges = "Free Shipping";
							$_SESSION['CART_SUBTOTAL'] = $_SESSION['CART']['TOTAL'];
						} else {
							//$chareged = round($_SESSION['DELIVERY_CHARGES'] * delivery_charges($_SESSION['DELIVERY_REST_ID']),2);
							$charges = ' &pound; '.number_format($_SESSION['DELIVERY_COST'], 2);

							$_SESSION['CART_SUBTOTAL'] = $_SESSION['DELIVERY_COST']+$_SESSION['CART']['TOTAL'];
							if(isset($_SESSION['SPECIAL_OFFER'])){
								if($_SESSION['CART_SUBTOTAL'] >= $_SESSION['SPECIAL_OFFER']['pound']){
									$CART_SUBTOTAL = round(($_SESSION['CART_SUBTOTAL'] * $_SESSION['SPECIAL_OFFER']['off']) / 100, 2);
									$save = '<div class="special-offer"><strong>You save &pound; '.($CART_SUBTOTAL).'</strong></div>';
									$_SESSION['CART_SUBTOTAL'] = $_SESSION['CART_SUBTOTAL'] - $CART_SUBTOTAL;
								}
							}
						}
                        $postcodeValue = substr($_GET['postcode'], -7, 2);
                        echo '<span class="fl-right b">Postcode: '.$postcodeValue.'</span><div class = "clr"></div>';
						echo '<span class="fl-right b">Delivery Charges :  &nbsp;'.$charges.'</span><div class="clr"></div>';
					}
					echo '<hr class="hr" /><span class="fl-right b">Sub Total :  &nbsp;&nbsp; &pound;'.(number_format($_SESSION['CART_SUBTOTAL'],2)).'</span><div class="clr"></div>'.$save;
					echo '<hr class="hr" /><div class="button-cart"><button type="button" class="btn btn-lg btn-primary btn-block Checkout-Button">Check Out</button></div>';
					echo '<div class="loading-cart"><img src="images/loader.gif" alt="" /></div>';
				} else {
					echo "Cart is Empty";
				}
			} else {
				echo "Cart is Empty";
			}
		?>
	</div>
</div>