<?php
session_start();
//unset($_SESSION['CART']);
include('functions.php');
?>
<div>
<style>
.button-cart, .loading-cart, .min-order { 
    width: 100%; 
    display: inline-block; 
    text-align: center;
    margin-top: 4px;
    }
.sticky-active {
    margin-top: 20px;
}
.min-order {
    background: #E67E22;
    padding: 10px;
    float: left;
    border-radius: 15px;
    font-size: 13px;
    margin-top: 10px;
    margin-bottom: 10px;
}
.cart-header, .order-header {
    display:block;
    text-transform: uppercase;
    padding: 10px 40px;
    background: #e74c3c;
    color:#fff;
    text-align: center;
    width:100%;
    margin-top:-4px;
    border-radius: 5px;
}
.cart-list .price {
    margin-right: 10px;
}
.cart-list .del {
    margin: -4px;
    padding: 1px;
}
</style>
        <h3 class="cart-header">Cart</h3>
        <?php
        if(isset($_SESSION['CART'])) {
            if($_SESSION['CART']['TOTAL'] > 0) {
                $str = '<ul class="list-group cart-list" >  <hr class="hr">';
                foreach($_SESSION['CART'] as $key => $value) {
                    if($key != 'TOTAL') {
                        $str .= '<div style="margin-top: 10px"><span class="qty ">'.$value['QTY'].' x </span>
                                      <span class="name" style="color: #000000">'.preg_replace('/[^0-9a-zA-Z ]/', '', $value['NAME']).'</span>
                                      <a class="del fl-right btn btn-danger" style="color: #fefefe" href="javascript:;" rel="id'.$key.'" data-item-name="'. $value['NAME'] .'"><i class="fa fa-trash-o"></i></a>
                                      <sapn class="price b" style="color: #000000; font-size: smaller "> &pound;'.number_format($value['TOTAL'],2).'</sapn></div><div class="clr"></div>';
                        $str .= '</li>';


                    }
                }
                $str .= '<hr class="hr">';
                $str .= '</ul>';
                echo $str;
                $save = "";
               /* echo '<span class="txt-center discountCode">First time user? <span class="small">Click <a href="#">here</a> get 10% off your order</span></span>';
                echo '<form method="post" id="discountForm"><input type="hidden" name="discount" placeholder="Enter discount code" class="form-control"/><input type="button" value="Go" class="btn" onclick="msg()" /> </form>'
                ?>
                <script type="text/javascript">
                    $(document).ready(function(){
                        var inputField = $('#discountForm input[name="discount"]');
                        var btnField = $('#discountForm input[type="button"]');
                        inputField.hide();
                        btnField.hide();
                        $('.discountCode').click(function(e){
                            e.preventDefault();
                            inputField.show();

                        });
                    });
                </script>*/


                echo '<div class="cart-hr first" style="color: #000000"></div><span class="charges b" style="color: #000000">Total :  &nbsp;&nbsp;&pound;'.number_format($_SESSION['CART']['TOTAL'],2).'</span><div class="clr"></div>';
                $chareged = 0.0;
                if(isset($_SESSION['DELIVERY_CHARGES'])) {
                    if($_SESSION['DELIVERY_CHARGES'] == '0' && $_SESSION['delivery_type']['type'] == 'delivery') {
                        $charges = "Free Shipping";
                        $_SESSION['CART_SUBTOTAL'] = $_SESSION['CART']['TOTAL'];
                    } else {
                        //$chareged = round($_SESSION['DELIVERY_CHARGES'] * delivery_charges($_SESSION['DELIVERY_REST_ID']),2);


                        /* Calculate delivery charges based on location */

                        $pcode = $_SESSION['CURRENT_POSTCODE'];


                        //if($pcode[0] == 'S' || $pcode[0] == 'W' || $pcode[0] == 'E' || $pcode[0] == 'N'){
                         // $charges = ' &pound;' . ($_SESSION['DELIVERY_CHARGES'] + 1);
                          //$_SESSION['CART_SUBTOTAL'] = ($_SESSION['DELIVERY_CHARGES'] + 1) + $_SESSION['CART']['TOTAL'];
                        //} else {
                          $charges = ' &pound;'.number_format($_SESSION['DELIVERY_CHARGES'], 2);
                          $_SESSION['CART_SUBTOTAL'] = $_SESSION['DELIVERY_CHARGES'] + $_SESSION['CART']['TOTAL'];

                        //}


                        if(isset($_SESSION['SPECIAL_OFFER'])){
                            if($_SESSION['CART_SUBTOTAL'] >= $_SESSION['SPECIAL_OFFER']['pound']){
                                $CART_SUBTOTAL = round(($_SESSION['CART_SUBTOTAL'] * $_SESSION['SPECIAL_OFFER']['off']) / 100, 2);
                                $save = '<div class="special-offer"><strong>You save &pound; '.($CART_SUBTOTAL).'</strong></div>';
                                $_SESSION['CART_SUBTOTAL'] = $_SESSION['CART_SUBTOTAL'] - $CART_SUBTOTAL;
                            }
                        }
                    }
                    echo '<div class="cart-hr"></div><span class="charges" style="color: #000000">Delivery Fee :  &nbsp;'.$charges.'</span><div class="clr"></div>';
                }

                $subTola = $_SESSION['CART']['TOTAL'];
                if( $subTola < 10 ) {
                    $minOrder = true;
                } else {
                    $minOrder = false;
                }
                echo '<div class="cart-hr"></div><span class="charges b">Sub Total :  &nbsp;&nbsp; &pound;'.(number_format($_SESSION['CART_SUBTOTAL'],2)).'</span><div class="clr"></div><div class="cart-hr last"></div>'.$save;
                if ($minOrder) {
                     echo '<div class="min-order">Min. Order Amount: £10.00</div>';
                     echo '<div class="button-cart"><button type="button" class="btn btn-lg btn-primary btn-block Checkout-Button" disabled>Check Out</button></div>';
                } else {
                   //echo '<textarea class="form-control" id="order_note" placeholder="Enter choice of drinks, sauces & dietary requirements for the driver." style="width: 100%; height: 60px; resize: vertical" rows="8" cols="49" name="order_note"></textarea> ';
                  if($_SESSION['order_delivery_time'] == 'ASAP'){
                    $result = 'ASAP';
                  } else {
                    $result = date('g:i a', strtotime($_SESSION['order_delivery_time']));
                  }
                   echo '<div class="alert alert-info"><i class="fa fa-clock-o"> Arrival Time: <strong>'.$result.'</strong></i></div>';
                    echo '<div class="button-cart"><button type="button" class="btn btn-lg btn-primary btn-block Checkout-Button" >Check Out</button></div>';
                }
                echo '<div class="loading-cart" style="display:none;"><img src="images/loader.gif" alt="" /></div>';
            } else {
                echo "Cart is Empty";
            }
        } else {
            echo "Cart is Empty";
        }
        ?>
</div>