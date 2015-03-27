<?php

session_start();
include('functions.php');
?>
<style>
.cart-list .price {
    margin-right: 10px;
}
.cart-list .del {
    margin: -4px;
    padding: 2px;
}
.cart-list li {
    overflow: hidden;
    border-top: 1px solid #EBEBEB;
    position: relative;
    display: block;
    padding: 20px 8px 5px;
}
.cart-list li:first-child {
    border-top: none;
}
.cart-list li > .item-meta,
.cart-list li > .item-view-cart {
   float: left;
}
.cart-list li > .item-meta {
    width: 70%;
}
.cart-list li > .item-view-cart {
    width: 30%;
}
.cart-list li .dish-name,
.cart-list li .qty-price {
    display: block;
    width: 90%;
    font-family: 'Lato';
    font-size: 12px;
}
.cart-list .view--cart {
    background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #5cbf2a), color-stop(1, #5cbf2a));
    background:-moz-linear-gradient(top, #5cbf2a 5%, #5cbf2a 100%);
    background:-webkit-linear-gradient(top, #5cbf2a 5%, #5cbf2a 100%);
    background:-o-linear-gradient(top, #5cbf2a 5%, #5cbf2a 100%);
    background:-ms-linear-gradient(top, #5cbf2a 5%, #5cbf2a 100%);
    background:linear-gradient(to bottom, #5cbf2a 5%, #5cbf2a 100%);
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#5cbf2a', endColorstr='#5cbf2a',GradientType=0);
    background-color:#5cbf2a;
    -moz-border-radius:4px;
    -webkit-border-radius:4px;
    border-radius:4px;
    border:1px solid #5cbf2a;
    display:inline-block;
    cursor:pointer;
    color:#ffffff;
    font-family:inherit;
    font-size:14px;
    padding:6px 12px;
    text-decoration:none;
    text-shadow:0px 1px 0px #2f6627;
}
.cart-list .view--cart:hover {
    background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #5cbf2a), color-stop(1, #5cbf2a));
    background:-moz-linear-gradient(top, #5cbf2a 5%, #5cbf2a 100%);
    background:-webkit-linear-gradient(top, #5cbf2a 5%, #5cbf2a 100%);
    background:-o-linear-gradient(top, #5cbf2a 5%, #5cbf2a 100%);
    background:-ms-linear-gradient(top, #5cbf2a 5%, #5cbf2a 100%);
    background:linear-gradient(to bottom, #5cbf2a 5%, #5cbf2a 100%);
    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#5cbf2a', endColorstr='#5cbf2a',GradientType=0);
    background-color:#5cbf2a;
}
.cart-list .view--cart:active {
    position:relative;
    top:1px;
}

</style>
<div>
    <?php
    if(isset($_SESSION['CART'])) {
        if($_SESSION['CART']['TOTAL'] > 0) {
            $str = '<ul class="list-group cart-list">';
            foreach($_SESSION['CART'] as $key => $value) {
                if($key != 'TOTAL') {
                    $str .= '<li>
                                  <div class="item-meta">
                                       <span class="dish-name">'.$value['NAME'].'</span>
                                       <span class="qty-price" style="color: #000000">'.$value['QTY'].' for &pound;'.number_format($value['TOTAL'],2).'</span>
                                  </div>
                                  <div class="item-view-cart">
                                       <a type="button" href="order-details.php" class="view--cart">View Cart</a>
                                  </div>

                                  <div class="clr"></div>';
                    $str .= '</li>';
                }
            }
            $str .= '</ul>';
            echo $str;
        } else {
            echo "Cart is empty";
        }
    } else {
        echo "Cart is empty";
    }
    ?>
</div>