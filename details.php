<?php include('includes/header.php');

//Obtencion de la url del producto
$product_id = $_GET['pro_id'];

$get_product = "SELECT * FROM products  AS p
                INNER JOIN product_categories AS c
                ON c.product_cat_id = p.fk_product_cat
                INNER JOIN product_subcategories AS s
                ON s.product_subcat_id = p.fk_product_subcat
                INNER JOIN manufacturers AS m
                ON m.manufacturer_id = p.fk_manufacturer
                WHERE product_url='$product_id'";

$run_product = mysqli_query($con, $get_product);

//No de filas retornadas
$check_product = mysqli_num_rows($run_product);

//Redireccion sino existe el producto
if ($check_product == 0) {
    echo "<script> window.open('index.php','_self') </script>";
} else {
    $row_product = mysqli_fetch_array($run_product);

    //Datos del producto
    $pro_id = $row_product['product_id'];
    $pro_name = $row_product['product_name'];
    $pro_label = $row_product['product_label'];
    $pro_url = $row_product['product_url'];
    $pro_color = $row_product['product_color'];

    //Stock del producto
    $get_p_stock = "SELECT SUM(variation_amount) AS stock FROM product_variations WHERE fk_product ='$pro_id'";
    $run_stock = mysqli_query($con, $get_p_stock);
    $row_stock = mysqli_fetch_array($run_stock);
    $pro_stock = $row_stock['stock'];

    //Descripcion
    $pro_d1 = $row_product['product_desc1'];
    $pro_d2 = $row_product['product_desc2'];


    //Carcateristicas
    $pro_f1 = $row_product['product_features1'];
    $pro_f2 = $row_product['product_features2'];
    $pro_f3 = $row_product['product_features3'];


    //Precio
    $pro_price = $row_product['product_price'];
    $pro_price_new = $row_product['product_price_new'];

    //Categoria y subcategoria producto
    $pro_cat = $row_product['product_cat_name'];
    $pro_cat_id = $row_product['product_cat_id'];
    $pro_subcat = $row_product['product_subcat_name'];
    $pro_subcat_id = $row_product['product_subcat_id'];

    //Manufacturera o marca
    $pro_man = $row_product['manufacturer_name'];

    //Críticas o revisiones de los productos
    $select_product_reviews = "SELECT * FROM reviews WHERE fk_product='$pro_id' AND review_status = 'Aprobado'";
    $run_product_reviews = mysqli_query($con, $select_product_reviews);
    //Numero de criticas del producto
    $count_product_reviews = mysqli_num_rows($run_product_reviews);

    //Calculo del ranking de criticas por producto
    $product_average_reviews = "SELECT ROUND(AVG(review_rating)) AS average_review FROM reviews WHERE fk_product = '$pro_id' AND review_status = 'Aprobado'";
    $run_product_average = $con->query($product_average_reviews);
    $row_average = $run_product_average->fetch_assoc();

    if ($count_product_reviews != 0) {
        $star_product_rating = $row_average['average_review'];
    } else {
        //Ninguna crítica
        $star_product_rating = 0;
    }

    $product_rating_stars = "";

    for ($product_i = 0; $product_i < $star_product_rating; $product_i++) {
        $product_rating_stars .= "<i class='font-13 fa fa-star'></i>";
    }
    for ($product_i = $star_product_rating; $product_i < 5; $product_i++) {
        $product_rating_stars .= "<i class='font-13 fa fa-star-o'></i>";
    }

    //Etiqueta producto
    if ($pro_label == "") {
        $product_label = "";
    } else {
        $product_label = " <span class='lbl pr-label1'>$pro_label</span>";
    }

    //Precio nuevo - descuento / etiqueta producto con descuento
    if ($pro_price_new == 0) {
        $price = $pro_price;
        //Precio actual
        $product_price = "
    <p class='product-single__price product-single__price-product-template'>
        <span class='product-price__price product-price__price-product-template'>
            <span id='ProductPrice-product-template'><span class='money'>Q$pro_price</span></span>
        </span>
    </p>
    ";
        //Precio de descuento
        $product_price_new = "";
    } else {
        $price = $pro_price_new;
        $product_price = "";
        //Calculo del porcentaje de descuento
        $pro_desc = 100 - (($pro_price_new * 100) / $pro_price);
        $round_pro_desc = ROUND($pro_desc, 2);

        //Cantidad de descuento
        $price_desc = ($pro_price - $pro_price_new);

        //Precio con descuento
        $product_price_new = "
            <p class='product-single__price product-single__price-product-template'>
                <!-- Precio anterior -->
                <s id='ComparePrice-product-template'><span class='money'>$pro_price</span></s>
                <!-- Precio actual -->
                <span class='product-price__price product-price__price-product-template product-price__sale product-price__sale--single'>
                    <span id='ProductPrice-product-template'><span class='money'>$pro_price_new</span></span>
                </span>
                <!-- Descuento -->
                <span class='discount-badge'> <span class='devider'>|</span>&nbsp;
                    <span>Ahorras</span>
                    <span id='SaveAmount-product-template' class='product-single__save-amount'>
                        <span class='money'>$price_desc</span>
                    </span>
                    <span class='off'>(<span>$round_pro_desc</span>%)</span>
                </span>
                <!-- /Descuento -->
            </p>
        ";
    }
?>
    <!-- Contenido -->
    <div id="page-content">
        <div id="MainContent" class="main-content" role="main">
            <!--Breadcrumb-->
            <div class="bredcrumbWrap">
                <div class="container breadcrumbs">
                    <a href="index.php">Inicio</a><span aria-hidden="true">›</span>
                    <a href="shop.php?category=<?php echo $pro_cat_id ?>"><?php echo $pro_cat ?></a><span aria-hidden="true">›</span>
                    <a href="shop.php?subcategory=<?php echo $pro_subcat_id ?>"><?php echo $pro_subcat ?></a><span aria-hidden="true">›</span>
                    <span><?php echo $pro_name ?></span>
                </div>
            </div>
            <!-- /Breadcrumb -->
            <div id="ProductSection-product-template" class="product-template__container prstyle1 container">
                <!-- Producto detalle -->
                <div class="product-single">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <!-- Img producto -->
                            <div class="product-details-img">
                                <!-- Img thumbs -->
                                <div class="product-thumb">
                                    <!-- Slider img -->
                                    <div id="gallery" class="product-dec-slider-2 product-tab-left">
                                        <?php
                                        //Img productos
                                        $get_p_img = "SELECT * FROM products_img WHERE fk_product ='$pro_id' ORDER BY product_img_id";
                                        $run_p_img = mysqli_query($con, $get_p_img);

                                        while ($row_p_img = mysqli_fetch_array($run_p_img)) {
                                            $pro_img_big = $row_p_img['product_img'];
                                            $pro_img_small = $row_p_img['product_img_detail'];
                                            echo "
                                                    <a data-image='images/product-images/$pro_img_big' data-zoom-image='images/product-images/$pro_img_big' class='slick-slide slick-cloned' aria-hidden='true' tabindex='-1'>
                                                        <img class='blur-up lazyload' src='images/product-detail/$pro_img_small' alt='' />
                                                    </a>
                                                 ";
                                        } ?>
                                    </div>
                                    <!-- /Slider img -->
                                </div>
                                <!-- /Img thumbs -->
                                <!-- Img zoom -->
                                <div class="zoompro-wrap product-zoom-right pl-20">
                                    <div class="zoompro-span">
                                        <?php
                                        //Img productos
                                        $get_p_img1 = "SELECT * FROM products_img WHERE fk_product ='$pro_id' ORDER BY product_img_id LIMIT 1";
                                        $run_p_img1 = mysqli_query($con, $get_p_img1);

                                        $row_p_img1 = mysqli_fetch_array($run_p_img1);
                                        $pro_img_big1 = $row_p_img1['product_img'];
                                        $pro_img_small1 = $row_p_img1['product_img_detail'];
                                        echo "
                                            <img class='blur-up lazyload zoompro' data-zoom-image='images/product-images/$pro_img_big1' alt='' src='images/product-images/$pro_img_big1' />
                                        ";
                                        ?>

                                    </div>
                                </div>
                                <!-- /Img zoom -->
                                <!-- Img box small -->
                                <div class="lightboximages">
                                    <?php
                                    //Img productos box
                                    /*$get_img_box = "SELECT * FROM products_img WHERE fk_product ='$pro_id' ORDER BY product_img_id";
                                    $run_img_box = mysqli_query($con, $get_img_box);

                                    while ($row_img_box = mysqli_fetch_array($run_img_box)) {
                                        $pro_img_box_big = $row_img_box['product_img'];
                                        echo "
                                        <a href='images/product-images/$pro_img_box_big' data-size='1462x2048'></a>
                                        ";
                                    } */ ?>
                                </div>
                                <!-- Img box small-->
                            </div>
                            <!-- Img producto -->
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="product-single__meta">
                                <!-- Titulo img -->
                                <h1 class="product-single__title"><?php echo $pro_name ?></h1>
                                <!-- Detalle img -->
                                <div class="prInfoRow">
                                    <!-- Stock producto -->
                                    <div class="product-stock">
                                        <?php
                                        if ($pro_stock > 0) {
                                            echo "<span class='instock'>En exitencias</span>";
                                        } else {
                                            echo "<span class='outstock'>Agotado</span>";
                                        } ?>

                                    </div>
                                    <!-- Stock producto -->
                                    <div class="product-sku">Marca: <span class="variant-sku"><?php echo $pro_man ?></span></div>
                                    <div class="product-review"><a class="reviewLink" href="<?php
                                                                                            if (isset($_SESSION['email'])) {
                                                                                                echo "#tab2";
                                                                                            } ?>">
                                            <?php
                                            if ($count_product_reviews == 1) {
                                                $name_review = 'Valoración';
                                            } else {
                                                $name_review = 'Valoraciones';
                                            }
                                            echo "$product_rating_stars
                                                    <span class='spr-badge-caption'>$count_product_reviews $name_review</span></a></div>
                                                "; ?> </div>
                                    <!-- /Detalle img -->
                                    <!-- Precio -->
                                    <?php echo "
                                        <!-- Sin descuento -->
                                            $product_price
                                        <!-- Con descuento -->
                                            $product_price_new
                                    "; ?>
                                    <!-- /Precio -->
                                    <!-- Vendidos ultimas horas
                                    <div class=" orderMsg">
                                            <img src="images/order-icon.jpg" alt="" /> <strong class="items">5</strong> vendidos en las últimas <strong class="time">26</strong> horas
                                    </div>
                                    -->
                                </div>
                                <!-- Descripcion producto-->
                                <div class="product-single__description rte">
                                    <ul>
                                        <?php
                                        //Caracteristicas del producto
                                        echo "
                                                <p class='mb-4 text-justify'>$pro_d1<p>
                                                <li>$pro_f1</li>
                                                <li>$pro_f3</li>
                                                <li>$pro_f2</li>
                                        ";

                                        //Muestra cuando hay 10 o menos productos
                                        if ($pro_stock <= 10 & $pro_stock != 0) {
                                            echo "
                                                <!-- /Descripcion producto-->
                                                <div id='quantity_message' class='mt-4'>Solamente <span class='items'>$pro_stock</span> en stock.</div>
                                            ";
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <?php
                                if ($pro_stock == 0 || $pro_stock == null) {
                                ?>
                                    <!-- Producto fuera de stock -->
                                    <button type="button" class="shopify-payment-button__button shopify-payment-button__button--unbranded">Producto no disponible</button>
                                <?php
                                } else { ?>
                                    <!-- Detalle producto a solicitar -->
                                    <form method="post" id="carrito" accept-charset="UTF-8" class="product-form product-form-product-template hidedropdown" enctype="multipart/form-data" onsubmit="event.preventDefault(); card();">
                                        <!-- Color -->
                                        <div class="swatch clearfix swatch-0 option1" data-option-index="0">
                                            <div class="product-form__item">
                                                <label class="header">Color: <span class="slVariant"><?php echo $pro_color ?></span></label>
                                            </div>
                                        </div>
                                        <!-- /Color -->
                                        <!-- Talla -->
                                        <div class="swatch clearfix swatch-1 option2" data-option-index="1">
                                            <div class="product-form__item">
                                                <label class="header">Talla:</label>
                                                <?php
                                                $get_stock = "SELECT * FROM product_variations AS p
                                                                INNER JOIN size AS s 
                                                                ON s.size_id = p.fk_size
                                                                WHERE fk_product ='$pro_id' ORDER BY s.size_id ";
                                                $run_stock = mysqli_query($con, $get_stock);

                                                while ($row_stock = mysqli_fetch_array($run_stock)) {
                                                    $pro_amount = $row_stock['variation_amount'];
                                                    $pro_size = $row_stock['size'];
                                                    echo "
                                                            <div data-value='$pro_size' class='swatch-element available'>
                                                                <input class='swatchInput' id='$pro_size' type='radio' name='size' value='$pro_size'> 
                                                                <label class='swatchLbl medium' for='$pro_size'>$pro_size</label>
                                                            </div>
                                                         ";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                        //Envio del id del producto y del cliente
                                        echo "
                                            <input type='hidden' id='pro_id' name='pro_id' value='$pro_id'>
                                            ";
                                        ?>
                                        <!-- /Talla -->
                                        <?php
                                        if ($pro_cat = "Mujeres" || $pro_cat = "Hombres") {
                                            $guia = 'sizeadult';
                                        } else {
                                            $guia = 'sizekid';
                                        }
                                        ?>
                                        <p class="infolinks"><a href="#<?php echo $guia ?>" class="sizelink btn">Guía de tallas</a></p>
                                        <!-- Producto accion -->
                                        <div class="product-action clearfix">
                                            <div class="product-form__item--quantity">
                                                <div class="wrapQtyBtn">
                                                    <!-- Cantidad producto -->
                                                    <div class="qtyField">
                                                        <a class="qtyBtn minus" href="javascript:void(0);"><i class="fa anm anm-minus-r" aria-hidden="true"></i></a>
                                                        <input type="text" id="product_qty" name="product_qty" value="1" min="1" class="product-form__input qty" autocomplete="off">
                                                        <a class="qtyBtn plus" href="javascript:void(0);"><i class="fa anm anm-plus-r" aria-hidden="true"></i></a>
                                                    </div>
                                                    <!-- /Cantidad producto -->
                                                </div>
                                            </div>
                                            <!-- Boton agregar -->
                                            <div class="product-form__item--submit">
                                                <button type="submit" name="add_cart" class="btn product-form__cart-submit">
                                                    <span>Agregar al carrito</span>
                                                </button>
                                            </div>
                                            <!-- /Boton agregar -->
                                        </div>
                                        <!-- /Producto accion -->
                                    </form>
                                    <!-- /Detalle producto a solicitar -->
                                <?php } ?>
                                <!-- Agregar a lista de deseos -->
                                <div class="display-table shareRow">
                                    <div class="display-table-cell medium-up--one-third">
                                        <?php
                                        //Si el usuario esta logueado
                                        if (isset($_SESSION['email'])) { ?>
                                            <div class="wishlist-btn">
                                                <?php
                                                echo "<a class='wishlist add-to-wishlist' onclick='wishlist($pro_id)' id='wishlist'>";
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

                                                //Producto agregado a lista de deseos
                                                if ($check_wishlist == 1) {
                                                    $icon = "<i id='icon' class='icon anm anm-heart whish' aria-hidden='true'; ></i> Agregado<span></span>";
                                                } else {
                                                    //No agregado 
                                                    $icon = "<i id='icon' class='icon anm anm-heart-l' aria-hidden='true'></i> Agregar<span></span>";
                                                }
                                                echo "
                                                        $icon 
                                                     ";
                                                ?>
                                                </a>
                                            </div>
                                        <?php }
                                        ?>
                                    </div>
                                </div>
                                <!-- Detalle de entrega y vistas -->
                                <p id="freeShipMsg" class="freeShipMsg text-uppercase" data-price="199"><i class="fa fa-truck" aria-hidden="true"></i>¡ACERCARSE! ¡SOLO<b class="freeShip"><span class="money" data-currency="Q"><?php echo " Q$price"; ?></span></b> CON <b>ENVIO GRATIS!</b></p>
                                <p class="shippingMsg  text-uppercase"><i class="fa fa-clock-o" aria-hidden="true"></i> Entrega estimada de<b id="fromDate"> 1</b> a <b id="toDate"> 3 </b>días</p>
                                <div class="userViewMsg" data-user="20" data-time="11000"><i class="fa fa-users" aria-hidden="true"></i> <strong class="uersView">14</strong> Personas estan viendo este producto</div>
                                <!-- /Detalle de entrega y vistas -->
                            </div>
                        </div>
                    </div>
                    <!-- Producto detalle -->
                    <!-- Característica de producto -->
                    <div class="prFeatures">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 feature">
                                <img src="images/credit-card.png" alt="Safe Payment" title="Safe Payment" />
                                <div class="details">
                                    <h3>Pago seguro</h3>Pague con la mayoría de los métodos de pago más seguros.
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 feature">
                                <img src="images/shield.png" alt="Confidence" title="Confidence" />
                                <div class="details">
                                    <h3>Confianza</h3>La protección cubre su compra y sus datos personales.
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 feature">
                                <img src="images/worldwide.png" alt="Worldwide Delivery" title="Worldwide Delivery" />
                                <div class="details">
                                    <h3>Envio gratis</h3> Envío gratis, seguro y rápido
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 feature">
                                <img src="images/phone-call.png" alt="Hotline" title="Hotline" />
                                <div class="details">
                                    <h3>Linea directa</h3> Hable con la línea de ayuda para su pregunta en (+502) 5574 8384
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Característica de producto -->
                    <!-- Fichas de productos -->
                    <div class="tabs-listing">
                        <ul class="product-tabs">
                            <li rel="tab1"><a class="tablink">Detalles de producto</a></li>
                            <?php if (isset($_SESSION['email'])) {
                                echo "<li rel='tab2'><a class='tablink'>Reseñas del producto</a></li>";
                            } ?>
                            <li rel="tab3"><a class="tablink">Envío &amp; Devoluciones</a></li>
                        </ul>
                        <div class="tab-container">
                            <div id="tab1" class="tab-content">
                                <div class="product-description rte">
                                    <?php
                                    //Caracteristicas del producto
                                    echo "
                                                <p class='text-justify'>$pro_d1<p>
                                                <p class='text-justify'>$pro_d2<p>
                                                <ul>
                                                    <li>$pro_f1</li>
                                                    <li>$pro_f3</li>
                                                    <li>$pro_f2</li>
                                                </ul>
                                        ";
                                    ?>
                                </div>
                            </div>

                            <div id="tab2" class="tab-content">
                                <div id="shopify-product-reviews">
                                    <div class="spr-container">
                                        <div class="spr-header clearfix">
                                            <div class="spr-summary">
                                                <?php
                                                echo "
                                                        <span class='product-review'><a class='reviewLink'>$product_rating_stars<span class='spr-summary-actions-togglereviews'> Basado en $count_product_reviews $name_review</span></span></a>
                                                        ";
                                                ?>
                                            </div>
                                        </div>
                                        <div class="spr-content">
                                            <div class="spr-form clearfix">
                                                <form method="post" id="new-review" onsubmit="event.preventDefault(); reseña();" accept-charset="UTF-8" class="new-review-form">
                                                    <h3 class="spr-form-title">Escribe una reseña</h3>
                                                    <fieldset class="spr-form-review">
                                                        <div class="spr-form-review-rating">
                                                            <label class="spr-form-label">Rating</label>
                                                            <div class="form-group">
                                                                <p class="clasificacion">
                                                                    <input id="radio1" type="radio" name="estrellas" value="5">
                                                                    <label for="radio1"><i class='font-13 fa fa-star-o'></i></label>
                                                                    <input id="radio2" type="radio" name="estrellas" value="4">
                                                                    <label for="radio2"><i class='font-13 fa fa-star-o'></i></label>
                                                                    <input id="radio3" type="radio" name="estrellas" value="3">
                                                                    <label for="radio3"><i class='font-13 fa fa-star-o'></i></label>
                                                                    <input id="radio4" type="radio" name="estrellas" value="2">
                                                                    <label for="radio4"><i class='font-13 fa fa-star-o'></i></label>
                                                                    <input id="radio5" type="radio" name="estrellas" value="1">
                                                                    <label for="radio5"><i class='font-13 fa fa-star-o'></i></label>
                                                                </p>

                                                            </div>
                                                        </div>

                                                        <div class="spr-form-review-title">
                                                            <label class="spr-form-label" for="review_title_10508262282">Titulo</label>
                                                            <input class="spr-form-input spr-form-input-text " id="review_titulo" type="text" name="review_titulo" placeholder="Dale un título a tu reseña" autocomplete="off" required>
                                                            <input type='hidden' id='pro_id' name='pro_id' value='<?php echo $pro_id?>'>
                                                        </div>

                                                        <div class="spr-form-review-body">
                                                            <label class="spr-form-label" for="review_body_10508262282">Reseña</label>
                                                            <div class="spr-form-input">
                                                                <textarea class="spr-form-input spr-form-input-textarea " id="review_body" data-product-id="10508262282" name="review_body" rows="10" autocomplete="off" placeholder="Escriba sus comentarios aquí" required></textarea>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset class="spr-form-actions">
                                                        <input type="submit" class="spr-button spr-button-primary button button-primary btn btn-primary" value="Enviar reseña">
                                                    </fieldset>
                                                </form>
                                            </div>
                                            <div class="spr-reviews">
                                                <?php getReview($pro_id); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tab3" class="tab-content text-justify">
                                <h4>Política de devoluciones</h4>
                                <p>Tiene usted (si es considerado por la ley como consumidor) derecho a desistir del presente contrato en un plazo de 14 días naturales sin necesidad de justificación, a contar desde que usted o un tercero por usted indicado, distinto del transportista, adquirió la posesión material de los bienes.</p>
                                <ol class="pl-4">
                                    <li>Si al abrir la mercancía se observará un deterioro visible del producto que pueda sospechar una pérdida de calidad o alteración, deberá entrar en contacto con nosotros a través de los teléfonos indicados en la sección contacto o por correo electrónico para proceder a una inspección o especificación del problema y poder realizar la devolución o reembolso correspondiente.</li>
                                    <li>No se admitirán las devoluciones de envases abiertos, manipulados o con el precinto violado por razones de seguridad.</li>
                                    <li>Para cualquier posible incidencia o reclamación, le recomendamos que se ponga en contacto con nosotros en los teléfonos o en el correo electrónico </li>
                                </ol>
                                <h4>Transporte</h4>
                                <p>Los envíos generados a través de los pedidos se gestionarán a través de empresas privadas de mensajería y transporte, en un plazo estimado de 48 a 96 horas</p>
                                <p>Los gastos de envío están incluidos en el precio final.</p>
                                <p>Los plazos de entrega indicados son orientativos. Si un artículo se encuentra temporalmente agotado avisaremos de tal circunstancia al cliente antes de enviarle el pedido con el resto de artículos comprados y le daríamos un nuevo plazo de entrega o, si no fuera posible servirle dicho producto, anularíamos su pedido si el cliente así lo desea. No realizamos entregas parciales de pedidos</p>
                            </div>
                        </div>
                    </div>
                    <!-- /Fichas de productos -->

                    <!-- Productos relacionados -->
                    <div class="related-product grid-products">
                        <!-- Header productos -->
                        <header class="section-header">
                            <h2 class="section-header__title text-center h2"><span>Productos relacionados</span></h2>
                            <p class="sub-heading">Somos tu mejor, siempre a la moda y con la mejor calidad</p>
                        </header>
                        <!-- /Header productos -->
                        <!-- Slider producto -->
                        <div class="productPageSlider">
                            <!-- Producto relacionados -->
                            <?php getProRel($pro_id, $pro_subcat_id); ?>
                            <!-- /Producto relacionados -->
                        </div>
                        <!-- /Slider producto -->
                    </div>
                    <!-- /Productos relacionados -->
                </div>
                <!--#ProductSection-product-template-->
            </div>
        </div>
        <!-- /Contenido -->
        <!-- Modals guias tallas adulto-->
        <div class="hide">
            <div id="sizeadult">
                <h3>GUIA DE TALLAS PARA MUJER</h3>
                <table>
                    <tbody>
                        <tr>
                            <th>Tamaño</th>
                            <th>XS</th>
                            <th>S</th>
                            <th>M</th>
                            <th>L</th>
                            <th>XL</th>
                        </tr>
                        <tr>
                            <td>Pecho</td>
                            <td>31" - 33"</td>
                            <td>33" - 35"</td>
                            <td>35" - 37"</td>
                            <td>37" - 39"</td>
                            <td>39" - 42"</td>
                        </tr>
                        <tr>
                            <td>Cintura</td>
                            <td>24" - 26"</td>
                            <td>26" - 28"</td>
                            <td>28" - 30"</td>
                            <td>30" - 32"</td>
                            <td>32" - 35"</td>
                        </tr>
                        <tr>
                            <td>Cadera</td>
                            <td>34" - 36"</td>
                            <td>36" - 38"</td>
                            <td>38" - 40"</td>
                            <td>40" - 42"</td>
                            <td>42" - 44"</td>
                        </tr>
                        <tr>
                            <td>Entrepierna regular</td>
                            <td>30"</td>
                            <td>30½"</td>
                            <td>31"</td>
                            <td>31½"</td>
                            <td>32"</td>
                        </tr>
                        <tr>
                            <td>Entrepierna larga (alta)</td>
                            <td>31½"</td>
                            <td>32"</td>
                            <td>32½"</td>
                            <td>33"</td>
                            <td>33½"</td>
                        </tr>
                    </tbody>
                </table>
                <h3>GUIA DE TALLAS PARA HOMBRES</h3>
                <table>
                    <tbody>
                        <tr>
                            <th>Tamaño</th>
                            <th>XS</th>
                            <th>S</th>
                            <th>M</th>
                            <th>L</th>
                            <th>XL</th>
                            <th>XXL</th>
                        </tr>
                        <tr>
                            <td>Pecho</td>
                            <td>33" - 36"</td>
                            <td>36" - 39"</td>
                            <td>39" - 41"</td>
                            <td>41" - 43"</td>
                            <td>43" - 46"</td>
                            <td>46" - 49"</td>
                        </tr>
                        <tr>
                            <td>Cintura</td>
                            <td>27" - 30"</td>
                            <td>30" - 33"</td>
                            <td>33" - 35"</td>
                            <td>36" - 38"</td>
                            <td>38" - 42"</td>
                            <td>42" - 45"</td>
                        </tr>
                        <tr>
                            <td>Cadera</td>
                            <td>33" - 36"</td>
                            <td>36" - 39"</td>
                            <td>39" - 41"</td>
                            <td>41" - 43"</td>
                            <td>43" - 46"</td>
                            <td>46" - 49"</td>
                        </tr>
                    </tbody>
                </table>
                <div style="padding-left: 30px;"><img src="images/size.jpg" alt=""></div>
            </div>
        </div>
        <!-- /Modals guias tallas -->
        <!-- Modals guias tallas niños-->
        <div class="hide">
            <div id="sizekid">
                <h3>GUIA DE TALLAS PARA NIÑOS</h3>
                <table>
                    <tbody>
                        <tr>
                            <th>Tamaño</th>
                            <th>4</th>
                            <th>6</th>
                            <th>8</th>
                            <th>10</th>
                            <th>12</th>
                            <th>14</th>
                            <th>16</th>
                        </tr>
                        <tr>
                            <td>Pecho</td>
                            <td>64 cm</td>
                            <td>68 cm</td>
                            <td>72 cm</td>
                            <td>76 cm</td>
                            <td>80 cm</td>
                            <td>84 cm</td>
                            <td>88 cm</td>
                        </tr>
                        <tr>
                            <td>Cintura</td>
                            <td>58 cm</td>
                            <td>59 cm</td>
                            <td>60 cm</td>
                            <td>62 cm</td>
                            <td>64 cm</td>
                            <td>66 cm</td>
                            <td>68 cm</td>
                        </tr>
                        <tr>
                            <td>Cadera</td>
                            <td>68 cm</td>
                            <td>72 cm</td>
                            <td>76 cm</td>
                            <td>80 cm</td>
                            <td>84 cm</td>
                            <td>88 cm</td>
                            <td>92 cm</td>
                        </tr>
                        <tr>
                            <td>Espalda</td>
                            <td>28 cm</td>
                            <td>30 cm</td>
                            <td>32 cm</td>
                            <td>34 cm</td>
                            <td>36 cm</td>
                            <td>38 cm</td>
                            <td>40 cm</td>
                        </tr>
                        <tr>
                            <td>Cuello</td>
                            <td>29 cm</td>
                            <td>30 cm</td>
                            <td>31 cm</td>
                            <td>32 cm</td>
                            <td>33 cm</td>
                            <td>34 cm</td>
                            <td>35 cm</td>
                        </tr>
                        <tr>
                            <td>Hombro</td>
                            <td>29 cm</td>
                            <td>30 cm</td>
                            <td>31 cm</td>
                            <td>32 cm</td>
                            <td>33 cm</td>
                            <td>34 cm</td>
                            <td>35 cm</td>
                        </tr>
                        <tr>
                            <td>Manga</td>
                            <td>36 cm</td>
                            <td>40 cm</td>
                            <td>44 cm</td>
                            <td>48 cm</td>
                            <td>52 cm</td>
                            <td>56 cm</td>
                            <td>60 cm</td>
                        </tr>
                        <tr>
                            <td>Tiro</td>
                            <td>16 cm</td>
                            <td>17.5 cm</td>
                            <td>19 cm</td>
                            <td>20.5 cm</td>
                            <td>22 cm</td>
                            <td>23.5 cm</td>
                            <td>25 cm</td>
                        </tr>
                        <tr>
                            <td>Cadera</td>
                            <td>12 cm</td>
                            <td>13.25 cm</td>
                            <td>14.5 cm</td>
                            <td>15.75 cm</td>
                            <td>17 cm</td>
                            <td>18.25 cm</td>
                            <td>19.5 cm</td>
                        </tr>
                    </tbody>
                </table>
                <div style="padding-left: 30px;"><img src="images/sizekid.png" alt=""></div>
            </div>
        </div>
        <!-- /Modals guias tallas -->
        <script>
            function reseña() {
                //$radio = $('input:radio[name=estrellas]:checked').val();
                $.ajax({
                    url: 'ajax/review.php?op=new-review',
                    type: 'POST',
                    async: true,
                    datatype: 'json',
                    data: $('#new-review').serialize(),

                    success: function(response) {
                        if (response == 1) {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.error('Todos los datos son necesarios');
                        }
                        if (response == 2) {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success('Reseña enviada');
                            location.reload();
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        </script>
    <?php }
include('includes/footer.php') ?>