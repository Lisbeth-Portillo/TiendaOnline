<?php include('includes/header.php') ?>
<!-- Contenido-->
<div id="page-content">
    <!--Slider-->
    <div class="slideshow slideshow-wrapper pb-section sliderFull">
        <div class="home-slideshow">
            <?php getSlider(); ?>
        </div>
    </div>
    <!--/Slider-->
    <!--Categorias slider -->
    <div class="tab-slider-product section mb-4">
        <!-- Container-->
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <!-- Separador categorias-->
                    <div class="section-header text-center">
                        <h2 class="h2">Nuevos productos</h2>
                        <p>Explore la gran variedad de nuestros productos</p>
                    </div>
                    <!-- /Separador categorias-->
                    <div class="tabs-listing">
                        <ul class="tabs clearfix">
                            <!-- Categorias -->
                            <?php getCatSlider(); ?>
                            <li rel='tab3'>Descuentos</li>
                            <!-- /Categorias -->
                        </ul>
                        <div class="tab_container">
                            <!-- Categoria #1 producto -->
                            <div id='tab1' class='tab_content grid-products'>
                                <div class='productSlider'>
                                    <?php getPro(1); ?>
                                </div>
                            </div>
                            <!-- /Categoria #1 producto -->
                            <!-- Categoria #2 producto -->
                            <div id='tab2' class='tab_content grid-products'>
                                <div class='productSlider'>
                                    <?php getPro(2); ?>
                                </div>
                            </div>
                            <!-- /Categoria #2 producto -->
                            <!-- Categoria producto con descuentos -->
                            <div id='tab3' class='tab_content grid-products'>
                                <div class='productSlider'>
                                    <?php getProDesc(); ?>
                                </div>
                            </div>
                            <!-- /Productos -->
                            <!-- /Categoria producto -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/Container-->
    </div>
    <!-- /Categorias slider -->

    <!-- Slider caja de colecciones -->
    <div class="collection-box section">
        <!-- Container-fluid -->
        <div class="container-fluid">
            <div class="collection-grid">

                <!-- Categorias img -->
                <?php getColCategory(); ?>
                <!-- /Categorias img -->
            </div>
        </div>
        <!-- /Container-fluid -->
    </div>
    <!-- /Slider caja de colecciones -->
    <!--Hero Parallax -->
    <div class="section">
        <div class="hero hero--large hero__overlay bg-size">
            <!-- Img parallax -->
            <img class="bg-img" src="images/banner.jpg" alt="" />
            <!-- /Img parallax -->
            <div class="hero__inner">
                <!-- Container -->
                <div class="container">
                    <div class="wrap-text  left text-large font-bold">
                        <!-- Titulo -->
                        <h2 class="h2 mega-title">Rebajas de media temporada. <br> HASTA 50% DE DESCUENTO</h2>
                        <!-- Subtitulo -->
                        <div class="rte-setting mega-subtitle">Vive la vida cómodamente. <br>¡Disfrutamos de tu estilo único! <p> <b> ENVÍO GRATIS en todos los pedidos</b></p>
                        </div>
                        <!-- Boton -->
                        <a href="shop.php" class="btn">Compra Ahora</a>
                    </div>
                </div>
                <!-- /Container -->
            </div>
        </div>
    </div>
    <!-- /Hero Parallax -->
    <!--Store Feature-->
    <div class="store-feature section pt-4 pb-4">
        <!-- Container -->
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="display-table store-info">
                        <li class="display-table-cell">
                            <!-- Icono -->
                            <i class="icon anm anm-truck-l"></i>
                            <!-- Nombre -->
                            <h5>Envio y devolución &amp; Gratis</h5>
                            <!-- Texto -->
                            <span class="sub-text">Envío gratis en todos los pedidos</span>
                        </li>
                        <li class="display-table-cell">
                            <i class="icon anm anm-dollar-sign-r"></i>
                            <h5>Garantía de dinero</h5>
                            <span class="sub-text">30 días de garantía de devolución de dinero</span>
                        </li>
                        <li class="display-table-cell">
                            <i class="icon anm anm-comments-l"></i>
                            <h5>Soporte en línea</h5>
                            <span class="sub-text">Brindamos soporte en línea las 24/7 días de la semana</span>
                        </li>
                        <li class="display-table-cell">
                            <i class="icon anm anm-credit-card-front-r"></i>
                            <h5>Pagos seguros</h5>
                            <span class="sub-text">Todos los pagos están asegurados y son confiables.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Container -->
    </div>
    <!--End Store Feature-->
</div>
<!--/Contenido-->
<?php include('includes/footer.php') ?>