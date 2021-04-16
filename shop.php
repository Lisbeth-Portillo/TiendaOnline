<?php include('includes/header.php') ?>
<!-- Contenido -->
<div id="page-content">
    <!-- Collection Banner -->
    <div class="collection-header">
        <div class="collection-hero">
            <!-- Img -->
            <div class="collection-hero__image"><img class="blur-up lazyload" data-src="images/category.jpg" src="images/cat-women.jpg" alt="Women" title="Women" /></div>
            <!-- Titulo -->
            <div class="collection-hero__title-wrapper">
                <h1 class="collection-hero__title page-width">Los mejores productos al mejor precio</h1>
            </div>
        </div>
    </div>
    <!-- /Collection Banner -->
    <!-- Container -->
    <div class="container pt-5">
        <div class="row">
            <!-- Sidebar - filtracion producto -->
            <div class="col-12 col-sm-12 col-md-3 col-lg-3 sidebar filterbar">
                <!-- Boton cerrar sidebar -->
                <div class="closeFilter d-block d-md-none d-lg-none"><i class="icon icon anm anm-times-l"></i></div>
                <div class="sidebar_tags">
                    <!-- Categorias -->
                    <div class="sidebar_widget filterBox categories filter-widget">
                        <!-- Titulo categorias -->
                        <div class="widget-title">
                            <h2>Categorías</h2>
                        </div>
                        <!-- /Titulo categorias -->
                        <div class="widget-content filterBox">
                            <ul class="sidebar_categories">
                                <?php getSubCategory(); ?>
                            </ul>
                        </div>
                    </div>
                    <!-- Categorias -->
                </div>
            </div>
            <!-- /Sidebar - filtracion producto -->
            <!-- Contenido principal -->
            <div class="col-12 col-sm-12 col-md-9 col-lg-9 main-col">
                <!-- Descripcion categoria -->
                <div class="category-description text-justify">
                    <h1>Tienda</h1>
                    <p>Te ofrecemos una amplia variedad de productos con la mejor calidad del mercado, de las mejores marcas al mejor precio. También te ofrecemos descuentos de temporada, con la cual estamos seguros que lucirás increíble. Estamos seguros que encontraras lo que buscas, porque con nosotros siempre estarás a la moda </p>
                </div>
                <!-- Descripcion categoria -->
                <hr>
                <div class="productList product-load-more">
                    <!-- Barra de herramientas -->
                    <button type="button" class="btn btn-filter d-block d-md-none d-lg-none"> Filtrar productos</button>
                    <!-- /Barra de herramientas -->
                    <div class="grid-products grid--view-items text-center">
                        <?php

                        if (isset($_GET['p_cat'])) {
                            $id = $_GET['p_cat'];
                            $get_pro_cat = "SELECT * FROM product_categories WHERE product_cat_id = $id";
                            $run_pro_cat = mysqli_query($con, $get_pro_cat);
                            $row_cat = mysqli_fetch_array($run_pro_cat);
                            $p_cat_name = $row_cat['product_cat_name'];
                        } else {
                            $p_cat_name = '';
                        }

                        if (isset($_GET['p_subcat'])) {
                            $id = $_GET['p_subcat'];
                            $get_pro_subcat = "SELECT * FROM product_subcategories WHERE product_subcat_id = $id";
                            $run_pro_subcat = mysqli_query($con, $get_pro_subcat);
                            $row_subcat = mysqli_fetch_array($run_pro_subcat);
                            $p_subcat_name = $row_subcat['product_subcat_name'];
                        } else {
                            $p_subcat_name = '';
                        }

                        if (isset($_GET['p_cat']) || isset($_GET['p_subcat'])) {
                            echo "<h1 class='btn btn-lg'>$p_subcat_name  $p_cat_name</h1>";
                        }


                        ?>

                        <div class="row">
                            <!-- Productos -->
                            <?php
                            if (isset($_GET['p_cat'])) {
                                getProducts($_GET['p_cat'], "fk_product_cat");
                            } else if (isset($_GET['p_subcat'])) {
                                getProducts($_GET['p_subcat'], "fk_product_subcat");
                            } else {
                                getProducts(' ', ' ');
                            }
                            ?>
                            <!-- /Productos -->
                        </div>
                    </div>
                </div>
                <!-- Separador -->
                <hr class="clear">
                <!-- Paginador -->
                <div class="pagination mb-4">
                    <ul>
                        <?php getPaginator(); ?>
                    </ul>
                </div>
                <!-- /Paginador -->
            </div>
            <!-- /Contenido principal -->
        </div>
    </div>
    <!-- /Container -->
</div>
<!-- /Contenido -->
<?php include('includes/footer.php') ?>