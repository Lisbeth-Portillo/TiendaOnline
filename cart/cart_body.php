<?php

include("../config/conexion.php");
include("../functions/functions.php");

//Carga de productos del carrito

$ip_add = getRealUserIp();

$total = 0;

$physical_products = array();

$select_cart = "SELECT * FROM cart AS c
                INNER JOIN products AS p
                ON c.fk_product = p.product_id 
                INNER JOIN manufacturers AS m
                ON m.manufacturer_id = p.fk_manufacturer
                WHERE ip_add='$ip_add' AND c.cart_status = 0";

$run_cart = mysqli_query($con, $select_cart);

$num_rows = mysqli_num_rows($run_cart);
while ($row_cart = mysqli_fetch_array($run_cart)) {

    //Datos del carrito
    $cart_id = $row_cart['cart_id'];
    $pro_id = $row_cart['fk_product'];
    $cart_amount = $row_cart['cart_amount'];
    $cart_size = $row_cart['cart_size'];

    //Datos del producto
    $pro_url = $row_cart['product_url'];
    $pro_name = $row_cart['product_name'];
    $pro_price = $row_cart['product_price'];
    $pro_price_new = $row_cart['product_price_new'];
    $pro_color = $row_cart['product_color'];

    //Precio del producto
    if ($pro_price_new == 0) {
        $pro_price = $pro_price;
    } else {
        $pro_price = $pro_price_new;
    }

    //Img products
    $pro_img1 = "SELECT product_img FROM products_img WHERE fk_product = '$pro_id' AND position_img = 1";
    $run_img1 = $con->query($pro_img1);
    $row_img1 = $run_img1->fetch_assoc();
    $pro_img = $row_img1["product_img"];

    //Marca
    $pro_manu = $row_cart['manufacturer_name'];

    //Cantidad variacion
    $amount_size = "SELECT * FROM product_variations AS p
                    INNER JOIN size AS s
                    ON s.size_id = p.fk_size 
                    WHERE fk_product = '$pro_id' AND size = '$cart_size'";

    $run_amount = $con->query($amount_size);
    $row_amount = $run_amount->fetch_assoc();
    $variation_amount = $row_amount["variation_amount"];
    $variation_id = $row_amount["product_variation_id"];

    //Total
    $cart_subtotal =  $cart_amount * $pro_price;
    $total += $cart_subtotal;

    echo "
    <!-- Producto -->
    <tr class='cart__row border-bottom line1 cart-flex border-top'>
        <!-- Img -->
        <td class='cart__image-wrapper cart-flex-item'>
            <a href='details.php?pro_id=$pro_url'><img class='cart__image' src='images/product-images/$pro_img'></a>
        </td>
        <!-- /Img -->
        <!-- Nombre -->
        <td class='cart__meta small--text-left cart-flex-item'>
            <div class='list-view-item__title'>
                <a href='#'>$pro_name</a>
            </div>
            <div class='cart__meta-text'>
                Marca: $pro_manu<br>
                Size: $cart_size, Color: $pro_color
            </div>
        </td>
        <!-- /Nombre -->
        <!-- Precio -->
        <td class='cart__price-wrapper cart-flex-item'>
            <span class='money'>Q$pro_price</span>
        </td>
        <!-- /Precio -->
        <!-- Cantidad -->
        <td class='cart__update-wrapper cart-flex-item text-right'>
            <div class='cart__qty text-center'>
                <div class='qtyField'> 
                    <input class='cart__qty-input qty' type='number' name='qty' autocomplete='off' onkeyup='Amount($cart_id)' onchange='Amount($cart_id)' id='$cart_id' value='$cart_amount' data-cart_id='$cart_id' min='1' data-product_id='$pro_id' max='$variation_amount' >
                </div>
            </div>
        </td>
        <!-- /Cantidad -->
        <!-- Subtotal -->
        <td class='text-right small--hide cart-price'>
            <div><span class='money'>$cart_subtotal</span></div>
        </td>
        <!-- /Subtotal -->
        <!-- Boton quitar -->
        <td class='text-center small--hide'><a href='#' class='btn btn--secondary cart__remove' onclick='Remove($cart_id)'><i class='icon icon anm anm-times-l'></i></a></td>
        <!-- /Boton quitar -->
    </tr>
    <!-- /Producto -->
 ";
}
if ($num_rows == 0) {
    echo "<tr class='text-center'>
            <td colspan='5'>No tiene productos en su carrito</td>
          </tr>";
}