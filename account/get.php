<?php
session_start();

include('../config/conexion.php');
include('../functions/wishlist.php');

switch ($_GET["op"]) {
        //Agregar producto al carrito
    case 'wishlist':
       
        echo getWishlist();
        break;

   /* case 'updateAccount':
        echo getAccount();
        break;*/
}
