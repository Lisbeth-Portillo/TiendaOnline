<?php

include("../config/conexion.php");
include("../functions/functions.php");

//Carga del precio total de los productos del carrito
//Obtencion de la IP
$ip_add = getRealUserIp();

//Productos por IP
$select_cart = "SELECT * FROM cart AS c
                 INNER JOIN products AS p
                 ON c.fk_product = p.product_id 
                 INNER JOIN manufacturers AS m
                 ON m.manufacturer_id = p.fk_manufacturer
                 WHERE ip_add='$ip_add' AND c.cart_status = 0";

$run_cart = mysqli_query($con, $select_cart);

$total = 0;
while ($row_cart = mysqli_fetch_array($run_cart)) {

    //Datos del carrito
    $cart_id = $row_cart['cart_id'];
    $pro_id = $row_cart['fk_product'];
    $cart_amount = $row_cart['cart_amount'];
    $cart_size = $row_cart['cart_size'];

    $amount_size = "SELECT * FROM products WHERE product_id ='$pro_id'";
    $run_amount = $con->query($amount_size);
    $row_amount = $run_amount->fetch_assoc();
    $pro_price = $row_amount['product_price'];
    $pro_price_new = $row_amount['product_price_new'];

    //Precio del producto
    if ($pro_price_new == 0) {
        $pro_price = $pro_price;
    } else {
        $pro_price = $pro_price_new;
    }

    //Total
    $cart_subtotal =  $cart_amount * $pro_price;
    $total += $cart_subtotal;
}

?>

<span class="col-12 col-sm-6 cart__subtotal-title">Total:</span>
<span class="col-12 col-sm-6 cart__subtotal-title cart__subtotal text-center" style="font-size: 30px"><span class="money total"><?php echo "Q$total.00" ?></span></span>