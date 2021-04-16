<?php
session_start();

include('../config/conexion.php');

function getAccount()
{
    global $con;

    $email = $_SESSION['email'];
    $select_customer = "SELECT * FROM person WHERE person_email = '$email'";
    $run_customer = mysqli_query($con, $select_customer);
    $row_customer = mysqli_fetch_array($run_customer);
    $name = $row_customer['person_name'];

    echo " 
        <h2>Mi perfil</h2>
        <hr>
        <h6 class='mt-2 text-capitalize'>$name</h6>
        <h6 class='text-lowercase'>$email</h6>
    ";
}

switch ($_GET["op"]) {
    case 'updateAccount':
        echo getAccount();
        break;
}
