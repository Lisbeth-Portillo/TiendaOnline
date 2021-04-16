<?php
session_start();
require_once "../config/conexion.php";

$name = isset($_POST["name"]) ? limpiarCadena($_POST["name"]) : "";
$lastname = isset($_POST["lastname"]) ? limpiarCadena($_POST["lastname"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$contact = isset($_POST["contact"]) ? limpiarCadena($_POST["contact"]) : "";
$address1 = isset($_POST["address1"]) ? limpiarCadena($_POST["address1"]) : "";
$address2 = isset($_POST["address2"]) ? limpiarCadena($_POST["address2"]) : "";
$depart = isset($_POST["depart"]) ? limpiarCadena($_POST["depart"]) : "";
$munic = isset($_POST["munic"]) ? limpiarCadena($_POST["munic"]) : "";
//Order paypal
$order_id = isset($_POST["order_id"]) ? limpiarCadena($_POST["order_id"]) : "";


//Variable de la bbdd
global $con;

$ip_add = getRealUserIp();

switch ($_GET["op"]) {
    case 'contrapago':
        //Id person logueada
        $person_id = $_SESSION['id'];

        //Actualizacion de la persona - cutomer
        $update_person = "UPDATE person set person_contact='$contact' WHERE person_email='$email'";
        $run_update_person = mysqli_query($con, $update_person);

        //Obtencion de la persona logueada
        $get_customer = "SELECT customer_id FROM customers AS c 
                         INNER JOIN person AS p
                         ON p.person_id = c.fk_person
                         WHERE p.person_email ='$email'";

        $run_get_customer = mysqli_query($con, $get_customer);
        $row_customer = mysqli_fetch_array($run_get_customer);
        $customer_id = $row_customer['customer_id'];

        //Actualizacion de datos de envio del customer
        $update_customer = "UPDATE customers SET billing_name='$name',billing_lastname='$lastname',billing_address1='$address1',billing_address2='$address2', fk_municipality='$munic',fk_person='$person_id',fk_department='$depart' WHERE customer_id='$customer_id'";
        $run_update_customer = mysqli_query($con, $update_customer);

        //Generacion de orden
        $orden_no = rand(10000000000000000, 99999999999999999);
        $order = "INSERT INTO orders (orden_no, payment_method, fk_order_status, fk_customer) 
                  VALUES('$orden_no', '1', '3', '$customer_id')";
        $run_order = mysqli_query($con, $order);

        //Obtencio del id de la orden registrada
        $id = mysqli_insert_id($con);

        //Detalle del la orden
        $select_cart = "SELECT * FROM cart AS c
                        INNER JOIN products AS p
                        ON c.fk_product = p.product_id 
                        WHERE ip_add='$ip_add' AND c.cart_status = 0";

        $run_cart = mysqli_query($con, $select_cart);

        $total = 0;

        while ($row_cart = mysqli_fetch_array($run_cart)) {
            //Datos del carrito
            $cart_id = $row_cart['cart_id'];
            $cart_amount = $row_cart['cart_amount'];
            $pro_id = $row_cart['product_id'];

            //Datos del producto
            $pro_price = $row_cart['product_price'];
            $pro_price_new = $row_cart['product_price_new'];

            //Precio del producto
            if ($pro_price_new == 0) {
                $pro_price = $pro_price;
            } else {
                $pro_price = $pro_price_new;
            }

            //Insersion de detalle de la orden
            $order_details = "INSERT INTO details_order (fk_cart, fk_order, price) 
                              VALUES('$cart_id','$id','$pro_price' )";
            $run_order = mysqli_query($con, $order_details);

            //Actualizacion de la cantidad del producto
            $amount_pro = "UPDATE product_variations SET variation_amount = (variation_amount-$cart_amount)
                           WHERE fk_product = '$pro_id'";
            $run_order = mysqli_query($con, $amount_pro);


            $cart_subtotal =  $cart_amount * $pro_price;
            //Total
            $total += $cart_subtotal;
        }

        //Actualizacion de datos de envio del customer
        $update_customer = "UPDATE orders SET order_total='$total' WHERE order_id='$id'";
        $run_update_customer = mysqli_query($con, $update_customer);
        echo '1';
        break;
    case 'paypal':
        //Id person logueada
        $person_id = $_SESSION['id'];

        //Actualizacion de la persona - cutomer
        $update_person = "UPDATE person set person_contact='$contact' WHERE person_email='$email'";
        $run_update_person = mysqli_query($con, $update_person);

        //Obtencion de la persona logueada
        $get_customer = "SELECT customer_id FROM customers AS c 
                           INNER JOIN person AS p
                           ON p.person_id = c.fk_person
                           WHERE p.person_email ='$email'";

        $run_get_customer = mysqli_query($con, $get_customer);
        $row_customer = mysqli_fetch_array($run_get_customer);
        $customer_id = $row_customer['customer_id'];

        //Actualizacion de datos de envio del customer
        $update_customer = "UPDATE customers SET billing_name='$name',billing_lastname='$lastname',billing_address1='$address1',billing_address2='$address2', fk_municipality='$munic',fk_person='$person_id',fk_department='$depart' WHERE customer_id='$customer_id'";
        $run_update_customer = mysqli_query($con, $update_customer);

        //Generacion de orden
        $order = "INSERT INTO orders (orden_no, payment_method, fk_order_status, fk_customer) 
                    VALUES('$order_id', '2', '3', '$customer_id')";
        $run_order = mysqli_query($con, $order);

        //Obtencio del id de la orden registrada
        $id = mysqli_insert_id($con);

        //Detalle del la orden
        $select_cart = "SELECT * FROM cart AS c
                          INNER JOIN products AS p
                          ON c.fk_product = p.product_id 
                          WHERE ip_add='$ip_add' AND c.cart_status = 0";

        $run_cart = mysqli_query($con, $select_cart);

        $total = 0;

        while ($row_cart = mysqli_fetch_array($run_cart)) {
            //Datos del carrito
            $cart_id = $row_cart['cart_id'];
            $cart_amount = $row_cart['cart_amount'];
            $pro_id = $row_cart['product_id'];

            //Datos del producto
            $pro_price = $row_cart['product_price'];
            $pro_price_new = $row_cart['product_price_new'];

            //Precio del producto
            if ($pro_price_new == 0) {
                $pro_price = $pro_price;
            } else {
                $pro_price = $pro_price_new;
            }

            //Insersion de detalle de la orden
            $order_details = "INSERT INTO details_order (fk_cart, fk_order, price) 
                                VALUES('$cart_id','$id','$pro_price' )";
            $run_order = mysqli_query($con, $order_details);

            //Actualizacion de la cantidad del producto
            $amount_pro = "UPDATE product_variations SET variation_amount = (variation_amount-$cart_amount)
                             WHERE fk_product = '$pro_id'";
            $run_order = mysqli_query($con, $amount_pro);


            $cart_subtotal =  $cart_amount * $pro_price;
            //Total
            $total += $cart_subtotal;
        }

        //Actualizacion de datos de envio del customer
        $update_customer = "UPDATE orders SET order_total='$total' WHERE order_id='$id'";
        $run_update_customer = mysqli_query($con, $update_customer);

        echo '1';

        break;
}
