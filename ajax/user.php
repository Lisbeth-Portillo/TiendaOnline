<?php
session_start();
require_once "../config/conexion.php";

$name = isset($_POST["name"]) ? limpiarCadena($_POST["name"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$pass = isset($_POST["passr"]) ? limpiarCadena($_POST["passr"]) : "";
$contact = isset($_POST["contact"]) ? limpiarCadena($_POST["contact"]) : "";
$passw = isset($_POST["pass"]) ? limpiarCadena($_POST["pass"]) : "";
$confirmpass = isset($_POST["confirmpass"]) ? limpiarCadena($_POST["confirmpass"]) : "";

//Datos de la direccion
$lastname = isset($_POST["lastname"]) ? limpiarCadena($_POST["lastname"]) : "";
$address1 = isset($_POST["address1"]) ? limpiarCadena($_POST["address1"]) : "";
$address2 = isset($_POST["address2"]) ? limpiarCadena($_POST["address2"]) : "";
$depart = isset($_POST["depart"]) ? limpiarCadena($_POST["depart"]) : "";
$munic = isset($_POST["munic"]) ? limpiarCadena($_POST["munic"]) : "";

//Datos de cambio de contraseña
$old_pass = isset($_POST["old_pass"]) ? limpiarCadena($_POST["old_pass"]) : "";
$new_pass = isset($_POST["new_pass"]) ? limpiarCadena($_POST["new_pass"]) : "";
$new_pass_again = isset($_POST["new_pass_again"]) ? limpiarCadena($_POST["new_pass_again"]) : "";

//Variable de la bbdd
global $con;

switch ($_GET["op"]) {
    case 'register':

        $encrypted_password = hash("SHA256", $pass);

        //Validación del correo
        $get_email = "SELECT * FROM person WHERE person_email = '$email'";
        $run_email = mysqli_query($con, $get_email);
        $check_email = mysqli_num_rows($run_email);

        if ($confirmpass != $pass) {
            echo '3';
        } else if ($check_email == 1) {
            echo "1";
        } else {

            //Insersión del customer
            $insert_person = "INSERT INTO person (person_name,person_email,person_pass) VALUES('$name','$email','$encrypted_password')";
            $run_person = mysqli_query($con, $insert_person);

            //Id retornado del customer
            $id = mysqli_insert_id($con);

            $insert_customer = "INSERT INTO customers (fk_person) VALUES('$id')";
            $run_customer = mysqli_query($con, $insert_customer);

            if ($run_person) {
                echo '2';

                //Id de la persona
                $_SESSION['id'] = $id;
                $_SESSION['email'] = $email;
            }
        }

        break;

    case 'login':

        $encrypted_password = hash("SHA256", $passw);

        $select_customer = "SELECT * FROM person WHERE person_email = '$email' AND person_pass = '$encrypted_password' AND person_status ='Activo' ";
        $run_customer = mysqli_query($con, $select_customer);
        $row_customer = mysqli_fetch_array($run_customer);

        $check_customer = mysqli_num_rows($run_customer);
        if ($check_customer == 1) {
            $id = $row_customer['person_id'];
            echo '2';
            $_SESSION['id'] = $id;
            $_SESSION['email'] = $email;
        } else {
            echo '1';
        }
        break;

    case 'login_admin':

        $encrypted_password = hash("SHA256", $passw);

        $select_customer = "SELECT * FROM admins AS a
                            INNER JOIN person AS p ON p.person_id = a.fk_person
                            WHERE p.person_email = '$email' AND p.person_pass = '$encrypted_password' ";
        $run_customer = mysqli_query($con, $select_customer);
        $row_customer = mysqli_fetch_array($run_customer);
        $admin_id = $row_customer['admin_id'];
        $check_customer = mysqli_num_rows($run_customer);

        if ($check_customer == 1) {
            echo '2';
            $_SESSION['admin_email'] = $email;
            $_SESSION['admin_id'] = $admin_id;
        } else {
            echo '1';
        }
        break;

    case 'edit':
        $person_email = $_SESSION['email'];
        $person_id = $_SESSION['id'];

        if ($email != $person_email) {
            //Verificar duplicidad en el correo
            $update_email = "SELECT * FROM person WHERE person_email='$email'";
            $run_email = mysqli_query($con, $update_email);
            $rows_email = mysqli_num_rows($run_email);

            if ($rows_email != 0) {
                echo "2";
            } else {
                //Actualizar datos del usuario si el correo no esta duplicado
                $update_customer = "UPDATE person set person_name='$name',person_email='$email',person_contact='$contact' WHERE person_id='$person_id'";
                $run_customer = mysqli_query($con, $update_customer);

                if ($run_customer) {
                    echo "1";
                    $_SESSION['email'] = $email;
                }
            }
        } else {
            //Actualizar datos del usuario si es el mismo correo
            $update_customer = "UPDATE person set person_name='$name',person_email='$email',person_contact='$contact' WHERE person_id='$person_id'";
            $run_customer = mysqli_query($con, $update_customer);

            if ($run_customer) {
                echo "1";
                $_SESSION['email'] = $email;
            }
        }
        break;

    case 'address':
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

        if ($run_update_customer) {
            echo '1';
        }
        break;

    case 'changepass':

        $email = $_SESSION['email'];

        //Encriptacion de la contraseña
        $encrypted_password = hash("SHA256", $old_pass);
        $select_customer = "SELECT * FROM person WHERE person_email='$email'";
        $run_customer = mysqli_query($con, $select_customer);
        $check_customer = mysqli_num_rows($run_customer);
        $row_customer = mysqli_fetch_array($run_customer);
        //Contraseña actual
        $hash_password = $row_customer["person_pass"];

        if ($encrypted_password != $hash_password) {
            //La contraseña actual no es válida
            echo "2";
        } else {
            //Encriptacion nueva contraseña
            $encrypted_password_new = hash("SHA256", $new_pass);
            $update_pass = "UPDATE person set person_pass='$encrypted_password_new' WHERE person_email='$email'";
            $run_pass = mysqli_query($con, $update_pass);

            if ($run_pass) {
                //Contraseña cambiada
                echo "1";
            }
        }
        break;

    case 'salir':

        //Limpiamos la variables de la sesion
        session_unset();
        //Se destruye la sesion
        session_destroy();
        //Redireción a la página principal
        header("Location: ../index.php");

        break;
    case 'salir_admin':

        session_unset();
        session_destroy();
        header("Location: ../admin_area/login.php");

        break;
}
