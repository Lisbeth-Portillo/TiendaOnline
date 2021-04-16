<?php
require_once "../config/conexion.php";

$name = isset($_POST["name"]) ? limpiarCadena($_POST["name"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$phone = isset($_POST["phone"]) ? limpiarCadena($_POST["phone"]) : "";
$subject = isset($_POST["subject"]) ? limpiarCadena($_POST["subject"]) : "";
$message = isset($_POST["message"]) ? limpiarCadena($_POST["message"]) : "";


//Obtencion de ip del usuario
$ip_add = getRealUserIp();

//Variable de la bbdd
global $con;

switch ($_GET["op"]) {
    case 'contactForm':

        /*$get_contact_us = "select * from contact_us";
        $run_conatct_us = mysqli_query($con, $get_contact_us);
        $row_conatct_us = mysqli_fetch_array($run_conatct_us);*/

        //Datos de la empresa
       /* $contact_heading = $row_conatct_us['contact_heading'];
        $contact_desc = $row_conatct_us['contact_desc'];
        $contact_email = $row_conatct_us['contact_email'];*/

        $message_shop =
            " <h1>Mnesaje enviado por $name </h1>
                <p><b> Correo electrónico del remitente: </b>$email </p>
                <p><b> Asunto del remitente : </b>$subject </p>
                <p><b> Mensaje del remitente : </b>$message </p>
                <p><b> Contacto del remitente : </b>$phone </p>
            ";
        $headers = "From: $email";

        /* Envio de la informacion al correo de la empresa
           to, subject, message*/
        mail("lisbethportillo5574@gmail.com", $subject, $message);

        $subject = "Gracias por contactar con Variedades Addyson";
        $msg = "Te responderemos pronto, gracias por contactarnos";
        $from = "lisbethportillo5574@gmail.com";
        $header = "From: lisbethportillo5574@gmail.com";

        //Envio de recibido al cliente
        mail($from, $subject, $msg);

        echo '1';
}
