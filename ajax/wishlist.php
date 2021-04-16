<?php
session_start();
require_once "../config/conexion.php";

$pro_id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$wish_id = isset($_POST["wish_id"]) ? limpiarCadena($_POST["wish_id"]) : "";
//Variable de la bbdd
global $con;

switch ($_GET["op"]) {
    case 'addlist':
        //Usuario no registrado
        if (!isset($_SESSION['email'])) {
            echo "1";
        } else {

            $session_id = $_SESSION['id'];

            $get_customer = "SELECT c.customer_id AS customer_id FROM customers AS c 
                             INNER JOIN person AS p 
                             ON p.person_id = c.fk_person
                             WHERE p.person_id ='$session_id'";

            $run_customer = mysqli_query($con, $get_customer);
            $row_customer = mysqli_fetch_array($run_customer);
            $customer_id = $row_customer['customer_id'];

            $select_wishlist = "SELECT * FROM wishlist WHERE fk_customer='$customer_id' AND fk_product='$pro_id'";
            $run_wishlist = mysqli_query($con, $select_wishlist);
            $check_wishlist = mysqli_num_rows($run_wishlist);

            //Existencia de ese producto en la lista
            if ($check_wishlist > 0 ) {
                echo "2";
            } else {

                //Agregar el producto
                $insert_wishlist = "INSERT into wishlist (fk_customer,fk_product) VALUES ('$customer_id','$pro_id')";
                $run_wishlist = mysqli_query($con, $insert_wishlist);

                if ($run_wishlist) {
                    echo '3';
                }
            }
        }
        break;

    case 'deletewish':

        $delete_wishlist = "DELETE FROM wishlist WHERE wishlist_id='$wish_id'";
        $run_delete = mysqli_query($con, $delete_wishlist);

        //Producto elimiado de la lista de deseos
        if ($run_delete) {
            echo "1";
        }

        break;
}
