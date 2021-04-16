<?php
require_once "../config/conexion.php";

$pro_id = isset($_POST["pro_id"]) ? limpiarCadena($_POST["pro_id"]) : "";
$size = isset($_POST["size"]) ? limpiarCadena($_POST["size"]) : "";
$amount = isset($_POST["product_qty"]) ? limpiarCadena($_POST["product_qty"]) : "";
$cart_id = isset($_POST["cart_id"]) ? limpiarCadena($_POST["cart_id"]) : "";
$product_id = isset($_POST["product_id"]) ? limpiarCadena($_POST["product_id"]) : "";
$qty = isset($_POST["qty"]) ? limpiarCadena($_POST["qty"]) : "";


//Obtencion de ip del usuario
$ip_add = getRealUserIp();

//Variable de la bbdd
global $con;

switch ($_GET["op"]) {
        //Agregar producto al carrito
    case 'addcart':

        $select_cart = "SELECT * FROM cart WHERE ip_add='$ip_add' AND fk_product ='$pro_id' AND cart_size='$size' AND cart_status = 0";
        $run_cart = mysqli_query($con, $select_cart);

        //Producto ya registrado en el carrito
        if (mysqli_num_rows($run_cart) > 0) {
            echo "ya agregado";

            //Producto nuevo al carrito
        } else {

            $select_price = "SELECT * FROM products WHERE product_id='$pro_id'";
            $run_price = mysqli_query($con, $select_price);
            $row_price = mysqli_fetch_array($run_price);

            //Datos del producto
            $pro_price = $row_price['product_price'];
            $pro_price_new = $row_price['product_price_new'];

            //Precio del producto
            if ($pro_price_new == 0) {
                $product_price = $pro_price;
            } else {
                $product_price = $pro_price_new;
            }

            //Validacion de la cantidad de maxima de la talla

            //Cantidad variacion
            $amount_size = "SELECT * FROM product_variations AS p
            INNER JOIN size AS s
            ON s.size_id = p.fk_size 
            WHERE fk_product = '$pro_id' AND size = '$size'";

            $run_amount = $con->query($amount_size);
            $row_amount = $run_amount->fetch_assoc();
            $variation_amount = $row_amount["variation_amount"];

            if ($amount <= $variation_amount) {
                $query = "INSERT INTO cart(fk_product,ip_add,cart_amount,cart_size) VALUES ('$pro_id','$ip_add','$amount','$size')";
                $run_query = mysqli_query($con, $query);
                echo "agregado";
            } else {
                echo $variation_amount;
            }
        }
        break;

        //Conteo de los productos del carrito
    case 'itemscart':
        $count_items = 0;

        $get_items = "SELECT SUM(cart_amount) AS amount FROM cart WHERE ip_add='$ip_add' AND cart_status = 0";
        $run_items = mysqli_query($con, $get_items);
        $row_items = mysqli_fetch_array($run_items);
        $count_items = $row_items['amount'];

        if ($count_items == null) {
            $count_items = 0;
        } else {
            $count_items;
        }

        echo $count_items;

        break;

    case 'updatecart';

        $change_qty = "UPDATE cart SET cart_amount='$qty' WHERE cart_id='$cart_id' AND cart_status = 0";

        $run_qty = mysqli_query($con, $change_qty);

        //Cantidad variacion
        if ($run_qty) {

            $total = 0;

            $select_cart = "SELECT * FROM cart WHERE ip_add='$ip_add' AND cart_status = 0";
            $run_cart = mysqli_query($con, $select_cart);

            while ($record = mysqli_fetch_array($run_cart)) {

                $pro_id = $record['fk_product'];

                $pro_qty = $record['cart_amount'];

                $amount_size = "SELECT * FROM products WHERE product_id ='$pro_id'";
                $run_amount = $con->query($amount_size);
                $row_amount = $run_amount->fetch_assoc();
                $pro_price = $row_amount['product_price'];
                $pro_price_new = $row_amount['product_price_new'];
                $pro_color = $row_amount['product_color'];

                //Precio del producto
                if ($pro_price_new == 0) {
                    $pro_price = $pro_price;
                } else {
                    $pro_price = $pro_price_new;
                }

                //Total
                $cart_subtotal =  $pro_qty * $pro_price;
                $total += $cart_subtotal;
            }
            echo $total;
        }
        break;

    case 'deletecart':
        $delete_product = "DELETE FROM cart WHERE cart_id='$cart_id'";
        $run_delete = mysqli_query($con, $delete_product);
        if ($run_delete) {
            echo '1';
        } else {
            echo '2';
        }
        break;
}
