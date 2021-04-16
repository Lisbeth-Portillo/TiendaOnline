<?php

session_start();

include('config/conexion.php');
include('functions/general.php');

$select_settings = "SELECT * FROM general_settings";
$run_settings = mysqli_query($con, $select_settings);
$row_settings = mysqli_fetch_array($run_settings);

//Datos del sitio 
$site_title = $row_settings["site_title"];
$meta_author = $row_settings["meta_author"];
$meta_description = $row_settings["meta_description"];
$meta_keywords = $row_settings["meta_keywords"];
$site_img = $row_settings["site_img"];

$site_direction = $row_settings["site_direction"];
$site_direction2 = $row_settings["site_direction2"];
$site_gmail = $row_settings["site_gmail"];
$site_number = $row_settings["site_number"];

?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $site_title; ?></title>
    <meta name="description" content="<?php echo $meta_description; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="<?php echo $meta_keywords; ?>">
    <meta name="author" content="<?php echo $meta_author; ?>">
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/<?php echo $site_img; ?>" />
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="../assets/css/plugins.css">
    <!-- Bootstap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/plugins.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!-- Alertify-->
    <link rel="stylesheet" href="../assets/alertify/css/alertify.css">
</head>

<body class="body home9-parallax">
    <!-- Buscador-->
    <div class="search">
        <div class="search__form">
            <form class="search-bar__form" method="get" action="results.php">
                <button class="go-btn search__button" type="submit"><i class="icon anm anm-search-l"></i></button>
                <input class="search__input" type="search" name="user_query" value="" placeholder="Búsqueda de productos, marcas, categorías ..." aria-label="Search" autocomplete="off">
                <button type="button" name="search" class="search-trigger close-btn"><i class="anm anm-times-l"></i></button>
            </form>
        </div>
    </div>
    <!-- /Buscador -->
    <!--Top Header-->
    <div class="top-header">
        <!-- Container -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-10 col-sm-8 col-md-5 col-lg-4">
                    <p class="phone-no"><i class="anm anm-phone-s"></i> +(502) <?php echo $site_number; ?></p>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 d-none d-lg-none d-md-block d-lg-block">
                    <div class="text-center">
                        <p class="top-header_middle-text"> <?php echo $site_title; ?></p>
                    </div>
                </div>
                <div class="col-2 col-sm-4 col-md-3 col-lg-4 text-right">
                    <!-- Icono de usuario mobile -->
                    <span class="user-menu d-block d-lg-none"><i class="anm anm-user-al" aria-hidden="true"></i></span>
                    <!-- /Icono de usuario mobile -->
                    <ul class="customer-links list-inline">
                        <?php
                        if (!isset($_SESSION['email'])) { ?>
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.php">Registro</a></li>
                        <?php } else { ?>
                            <li><a href="ajax/user.php?op=salir">Cerrar sesion</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Container -->
    </div>
    <!-- /Top Header-->
    <!--Header-->
    <div class="header-wrap animated d-flex <?php if ($first_part == "index.php") {
                                                echo "classicHeader";
                                            }  ?>">
        <!-- Container -->
        <div class="container-fluid">
            <div class="row align-items-center">
                <!-- Logo escritorio-->
                <div class="logo col-md-2 col-lg-2 d-none d-lg-block">
                    <a href="index.html">
                        <img src="images/<?php echo $site_img; ?>" alt="Belle Multipurpose Html Template" title="Belle Multipurpose Html Template" />
                    </a>
                </div>
                <!-- /Logo escritorio-->
                <div class="col-2 col-sm-3 col-md-3 col-lg-8">
                    <div class="d-block d-lg-none">
                        <!-- Button menu desplegable -->
                        <button type="button" class="btn--link site-header__menu js-mobile-nav-toggle mobile-nav--open">
                            <i class="icon anm anm-times-l"></i>
                            <i class="anm anm-bars-r " style="color:black"></i>
                        </button>
                        <!-- /Button menu desplegable -->
                    </div>
                    <!-- Menu-->
                    <nav class="grid__item pl-0">
                        <ul id="siteNav" class="site-nav medium center hidearrow">
                            <li class="lvl1"><a href="index.php">Inicio <i class="anm anm-angle-down-l"></i></a>
                            </li>
                            <li class="lvl1"><a href="shop.php">Tienda <i class="anm anm-angle-down-l"></i></a>
                            </li>
                            <li class="lvl1"><a href="about.php">Nosotros <i class="anm anm-angle-down-l"></i></a>
                            </li>
                            <li class="lvl1"><a href="contact.php">Contáctanos <i class="anm anm-angle-down-l"></i></a>
                            </li>
                            <?php if (isset($_SESSION['email'])) {
                                echo "<li class='lvl1'><a href='account.php'>Mi cuenta <i class='anm anm-angle-down-l'></i></a></li>";
                            } ?>

                        </ul>
                    </nav>
                    <!-- /Menu-->
                </div>
                <!--Mobile Logo-->
                <div class="col-6 col-sm-6 col-md-6 col-lg-2 d-block d-lg-none mobile-logo">
                    <div class="logo">
                        <a href="index.php">
                            <img src="images/<?php echo $site_img; ?>" alt="Belle Multipurpose Html Template" title="Belle Multipurpose Html Template" />
                        </a>
                    </div>
                </div>
                <!-- /Mobile Logo-->
                <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                    <div class="site-cart">
                        <!-- Cart -->
                        <a href="cart.php" class="site-header__cart" title="Cart">
                            <i class="icon anm anm-bag-l"></i>
                            <span id="CartItems" class="site-header__cart-count" data-cart-render="item_count"></span>
                        </a>
                    </div>
                    <div class="site-header__search">
                        <button type="button" class="search-trigger"><i class="icon anm anm-search-l"></i></button>
                    </div>

                </div>
            </div>
        </div>
        <!-- /Container -->
    </div>
    <!-- /Header-->
    <!--Mobile Menu-->
    <div class="mobile-nav-wrapper" role="navigation">
        <div class="closemobileMenu"><i class="icon anm anm-times-l pull-right"></i> Cerrar Menu</div>
        <ul id="MobileNav" class="mobile-nav">
            <li class="lvl1 "><a href="index.php">Inicio </a> </li>
            <li class="lvl1"><a href="shop.php">Tienda</a> </li>
            <li class="lvl1"><a href="about.php">Nosotros </i></a> </li>
            <li class="lvl1"><a href="contact.php">Contáctanos</a>
            </li>
            <?php if (isset($_SESSION['email'])) {
                echo "<li class='lvl1'><a href='account.php'>Mi cuenta</a>";
            } ?>
            </li>
        </ul>
    </div>
    <!-- /Mobile menu -->