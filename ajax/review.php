<?php
session_start();
require_once "../config/conexion.php";

$estrellas = isset($_POST["estrellas"]) ? limpiarCadena($_POST["estrellas"]) : "";
$review_titulo = isset($_POST["review_titulo"]) ? limpiarCadena($_POST["review_titulo"]) : "";
$review_body = isset($_POST["review_body"]) ? limpiarCadena($_POST["review_body"]) : "";
$pro_id = isset($_POST["pro_id"]) ? limpiarCadena($_POST["pro_id"]) : "";

//Variable de la bbdd
global $con;

switch ($_GET["op"]) {
    
    case 'new-review':
        if ($estrellas == ' ' || $review_titulo == ' ' || $review_body == ' ') {
            echo '1';
        } else {
            //Id person logueada
            $email = $_SESSION['email'];

            //Obtencion de la persona logueada
            $get_customer = "SELECT customer_id FROM customers AS c 
                            INNER JOIN person AS p
                            ON p.person_id = c.fk_person
                            WHERE p.person_email ='$email'";

            $run_get_customer = mysqli_query($con, $get_customer);
            $row_customer = mysqli_fetch_array($run_get_customer);
            $customer_id = $row_customer['customer_id'];

            //Insersión de la reseña
            $insert_review = "INSERT INTO reviews (fk_costumer, review_name, review_rating, review_content, fk_product)
                             VALUES('$customer_id','$review_titulo','$estrellas','$review_body','$pro_id')";

            $run_insert_review = mysqli_query($con, $insert_review);

            if($run_insert_review){
                echo '2';
            }
        }
}
