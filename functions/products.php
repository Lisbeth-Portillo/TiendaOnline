<?php
// Obtención de los productos mas recientes por categoria - Index
function getPro($category)
{
    global $con;
    $get_products = "SELECT * FROM products WHERE fk_product_cat = $category  AND product_price_new = 0 AND status='Activo' ORDER BY product_id DESC LIMIT 10";
    $run_products = mysqli_query($con, $get_products);
    while ($row_pro = mysqli_fetch_array($run_products)) {

        //Productos
        $pro_id = $row_pro['product_id'];
        $pro_name = $row_pro['product_name'];
        $pro_price = $row_pro['product_price'];
        $pro_url = $row_pro['product_url'];

        //Img products
        $pro_img1 = "SELECT product_img FROM products_img WHERE fk_product = '$pro_id' AND position_img = 1";
        $run_img1 = $con->query($pro_img1);
        $row_img1 = $run_img1->fetch_assoc();
        $img_1 = $row_img1["product_img"];

        $pro_img2 = "SELECT product_img FROM products_img WHERE fk_product = '$pro_id' AND position_img = 2";
        $run_img2 = $con->query($pro_img2);
        $row_img2 = $run_img2->fetch_assoc();
        $img_2 = $row_img2["product_img"];

        $pro_label = $row_pro['product_label'];

        //Fabricante
        $manufacturer_id = $row_pro['fk_manufacturer'];
        $get_manufacturer = "SELECT * FROM manufacturers WHERE manufacturer_id='$manufacturer_id'";
        $run_manufacturer = mysqli_query($con, $get_manufacturer);
        $row_manufacturer = mysqli_fetch_array($run_manufacturer);
        $manufacturer_name = $row_manufacturer['manufacturer_name'];

        //Label producto
        if ($pro_label == "") {
            $product_label = "";
        } else {
            $product_label = "
            <div class='product-labels rectangular'><span class='lbl pr-label1'>$pro_label</span></div>
             ";
        }

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

        //Stock producto
        $get_p_stock = "SELECT SUM(variation_amount) AS stock FROM product_variations WHERE fk_product ='$pro_id'";
        $run_stock = mysqli_query($con, $get_p_stock);
        $row_stock = mysqli_fetch_array($run_stock);
        $pro_stock = $row_stock['stock'];

        if ($pro_stock == 0 || $pro_stock == null) {
            $outofstock_label = "<span class='sold-out'><span>Agotado</span></span>";
            $class = 'grid-view-item__image';
        } else {
            $outofstock_label = "";
            $class = '';
        }

        $store_back_url = 'details.php?pro_id=';

        echo " 
                        <div class='col-12 item'>
                            <!-- Imagen producto-->
                            <div class='product-image'>
                                <a href='$store_back_url$pro_url'>
                                    <!-- Imagen -->
                                    <img class='$class primary blur-up lazyload' data-src='../images/product-images/$img_1' alt='$pro_name' >
                                    <!-- Hover Imagen -->
                                    <img class='$class hover blur-up lazyload' data-src='../images/product-images/$img_2' alt='$pro_name'>
                                    <!-- Producto label -->
                                        $product_label
                                    <!-- /Producto label -->
                                        $outofstock_label
                                </a>    
                                <!-- Fabricante -->
                                <div class='bg-dark pt-2 pb-2 saleTime'><span class='text-white'>$manufacturer_name</span></div>
                                <!-- /Fabricante -->
                                <!-- Boton añadir -->
                                <a class='variants add'  href='$store_back_url$pro_url' method='post'>
                                    <button class='btn btn-addto-cart' type='button' tabindex='0'>Añadir al carrito</button>
                                </a>
                                <!-- /Boton añadir -->
                                <!-- Opciones producto -->
                                <div class='button-set'>
                                    <!-- Boton para agregar a vista de deseos  -->
                                    <div class='wishlist-btn'  onclick='wishlist($pro_id)'>
                                        <a class='wishlist add-to-wishlist' title='Agregar a deseos' href='#'>
                                            <i class='icon anm anm-heart-l'></i>
                                        </a>
                                    </div>
                                    <!-- Boton para agregar a vista de deseos  -->
                        
                                </div>
                                <!-- /Opciones producto -->
                            </div>
                            <!-- /Imagen producto -->
                            <!-- Detalles del producto-->
                            <div class='product-details text-center'>
                                <!-- Nombre del producto -->
                                <div class='product-name'>
                                    <a href='$store_back_url$pro_url'>$pro_name</a>
                                </div>
                                <!-- /Nombre del producto -->
                                <!-- Precio del producto -->
                                <div class='product-price'>
                                    <!-- Precio actual --> 
                                    <span class='price'>Q$pro_price</span>
                                </div>
                                <!-- /Precio del producto -->
                                <!-- Calificacion del producto -->
                                <div class='product-review'>
                                    $product_rating_stars
                                </div>
                                <!-- /Calificacion del producto -->
                            </div>
                            <!-- /Detalles del producto-->
                        </div>
                ";
    }
}

// Obtención de los productos con descuentos
function getProDesc()
{
    global $con;
    $get_products = "SELECT * FROM products WHERE product_price_new > 0 AND status='Activo' LIMIT 10";
    $run_products = mysqli_query($con, $get_products);
    while ($row_pro = mysqli_fetch_array($run_products)) {

        //Productos
        $pro_id = $row_pro['product_id'];
        $pro_name = $row_pro['product_name'];
        $pro_price = $row_pro['product_price'];
        $pro_price_new = $row_pro['product_price_new'];
        $pro_url = $row_pro['product_url'];

        //Img products
        $pro_img1 = "SELECT product_img FROM products_img WHERE fk_product = '$pro_id' AND position_img = 1";
        $run_img1 = $con->query($pro_img1);
        $row_img1 = $run_img1->fetch_assoc();
        $img_1 = $row_img1["product_img"];

        $pro_img2 = "SELECT product_img FROM products_img WHERE fk_product = '$pro_id' AND position_img = 2";
        $run_img2 = $con->query($pro_img2);
        $row_img2 = $run_img2->fetch_assoc();
        $img_2 = $row_img2["product_img"];

        $pro_label = $row_pro['product_label'];

        //Fabricante
        $manufacturer_id = $row_pro['fk_manufacturer'];
        $get_manufacturer = "SELECT * FROM manufacturers WHERE manufacturer_id='$manufacturer_id'";
        $run_manufacturer = mysqli_query($con, $get_manufacturer);
        $row_manufacturer = mysqli_fetch_array($run_manufacturer);
        $manufacturer_name = $row_manufacturer['manufacturer_name'];

        //Label producto
        if ($pro_label == "") {
            $product_label = "";
        } else {
            $product_label = "<span class='lbl pr-label1'>$pro_label</span>";
        }

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

        //Stock producto
        $get_p_stock = "SELECT SUM(variation_amount) AS stock FROM product_variations WHERE fk_product ='$pro_id'";
        $run_stock = mysqli_query($con, $get_p_stock);
        $row_stock = mysqli_fetch_array($run_stock);
        $pro_stock = $row_stock['stock'];

        if ($pro_stock == 0 || $pro_stock == null) {
            $outofstock_label = "<span class='sold-out'><span>Agotado</span></span>";
            $class = 'grid-view-item__image';
        } else {
            $outofstock_label = "";
            $class = '';
        }
        //Calculo del porcentaje de descuento
        $pro_desc = (($pro_price_new * 100) / $pro_price) - 100;
        $round_pro_desc = ROUND($pro_desc, 2);
        $product_label_desc = "<span class='lbl on-sale'>$round_pro_desc%</span>";

        $store_back_url = 'details.php?pro_id=';

        echo "
                        <div class='col-12 item'>
                            <!-- Imagen producto-->
                            <div class='product-image'>
                                <a href='$store_back_url$pro_url'>
                                    <!-- Imagen -->
                                    <img class='$class primary blur-up lazyload' data-src='../images/product-images/$img_1' alt='$pro_name' >
                                    <!-- Hover Imagen -->
                                    <img class='$class hover blur-up lazyload' data-src='../images/product-images/$img_2' alt='$pro_name'>
                                    <!-- Producto label -->
                                    <div class='product-labels rectangular'>
                                        $product_label_desc
                                        $product_label
                                    </div>    
                                    <!-- /Producto label -->
                                        $outofstock_label
                                </a>    
                                <!-- Fabricante -->
                                <div class='bg-dark pt-2 pb-2 saleTime'><span class='text-white'>$manufacturer_name</span></div>
                                <!-- /Fabricante -->
                                <!-- Boton añadir -->
                                <a class='variants add'  href='$store_back_url$pro_url' method='post'>
                                    <button class='btn btn-addto-cart' type='button' tabindex='0'>Añadir al carrito</button>
                                </a>
                                <!-- /Boton añadir -->
                                <!-- Opciones producto -->
                                <div class='button-set'>
                                    <!-- Boton para agregar a vista de deseos  -->
                                    <div class='wishlist-btn'>
                                        <a class='wishlist add-to-wishlist' onclick='wishlist($pro_id)' title='Agregar a deseos' href='#'>
                                            <i class='icon anm anm-heart-l'></i>
                                        </a>
                                    </div>
                                    <!-- Boton para agregar a vista de deseos  -->
                        
                                </div>
                                <!-- /Opciones producto -->
                            </div>
                            <!-- /Imagen producto -->
                            <!-- Detalles del producto-->
                            <div class='product-details text-center'>
                                <!-- Nombre del producto -->
                                <div class='product-name'>
                                    <a href='$store_back_url$pro_url'>$pro_name</a>
                                </div>
                                <!-- /Nombre del producto -->
                                <!-- Precio del producto -->
                                <div class='product-price'>
                                    <!-- Precio anterior -->
                                    <span class='old-price'>Q$pro_price</span>
                                    <!-- Precio actual -->
                                    <span class='price'>Q$pro_price_new</span>
                                </div>
                                <!-- /Precio del producto -->
                                <!-- Calificacion del producto -->
                                <div class='product-review'>
                                    $product_rating_stars
                                </div>
                                <!-- /Calificacion del producto -->
                            </div>
                            <!-- /Detalles del producto-->
                        </div>
                ";
    }
}
//Obtencion de productos - Tienda

function getProducts($id, $clave)
{

    global $con;

    //Productos a mostrar por pagina
    $p_page = 12;

    //Obtencion de la posicion de la pagina
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    if ($id != " " && $clave != " ") {
        $filtro = "AND $clave = $id";
    } else {
        $filtro = '';
    }
    // (pagina_actual - 1) * cantidad_mostrar
    $start_from = ($page - 1) * $p_page;
    $get_product = "SELECT * FROM products 
                    WHERE status='Activo' $filtro ORDER BY 1 DESC LIMIT $start_from,$p_page";
    $run_product = mysqli_query($con, $get_product);

    while ($row_products = mysqli_fetch_array($run_product)) {

        //Datos producto
        $pro_id = $row_products['product_id'];
        $pro_name = $row_products['product_name'];
        $pro_price = $row_products['product_price'];
        $pro_price_new = $row_products['product_price_new'];
        $pro_url = $row_products['product_url'];

        //Img products
        $pro_img1 = "SELECT product_img FROM products_img WHERE fk_product = '$pro_id' AND position_img = 1";
        $run_img1 = $con->query($pro_img1);
        $row_img1 = $run_img1->fetch_assoc();
        $img_1 = $row_img1["product_img"];

        $pro_img2 = "SELECT product_img FROM products_img WHERE fk_product = '$pro_id' AND position_img = 2";
        $run_img2 = $con->query($pro_img2);
        $row_img2 = $run_img2->fetch_assoc();
        $img_2 = $row_img2["product_img"];

        $pro_label = $row_products['product_label'];

        //Fabricante
        $manufacturer_id = $row_products['fk_manufacturer'];
        $get_manufacturer = "SELECT * FROM manufacturers WHERE manufacturer_id='$manufacturer_id'";
        $run_manufacturer = mysqli_query($con, $get_manufacturer);
        $row_manufacturer = mysqli_fetch_array($run_manufacturer);
        $manufacturer_name = $row_manufacturer['manufacturer_name'];

        //Etiqueta producto
        if ($pro_label == "") {
            $product_label = "";
        } else {
            $product_label = " <span class='lbl pr-label1'>$pro_label</span>";
        }

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

        //Stock producto
        $get_p_stock = "SELECT SUM(variation_amount) AS stock FROM product_variations WHERE fk_product ='$pro_id'";
        $run_stock = mysqli_query($con, $get_p_stock);
        $row_stock = mysqli_fetch_array($run_stock);
        $pro_stock = $row_stock['stock'];

        if ($pro_stock == 0 || $pro_stock == null) {
            $outofstock_label = "<span class='sold-out'><span>Agotado</span></span>";
            $class = 'grid-view-item__image';
        } else {
            $outofstock_label = "";
            $class = '';
        }

        //Precio nuevo - descuento / etiqueta producto con descuento
        if ($pro_price_new == 0) {
            //Precio actual
            $product_price = "<span class='price'>Q$pro_price</span>";
            //Precio de descuento
            $product_price_new = "";
            $product_label_desc = "";
        } else {
            //Precio anterior
            $product_price = "<span class='old-price'>Q$pro_price</span>";
            //Precio actuals
            $product_price_new = "<span class='price'>Q$pro_price_new</span>";
            //Calculo del porcentaje de descuento
            $pro_desc = (($pro_price_new * 100) / $pro_price) - 100;
            $round_pro_desc = ROUND($pro_desc, 2);
            $product_label_desc = "<span class='lbl on-sale'>$round_pro_desc%</span>";
        }

        $store_back_url = 'details.php?pro_id=';

        echo "
                <div class='col-6 col-sm-6 col-md-4 col-lg-3 item'>
                    <!-- Imagen producto-->
                    <div class='product-image'>
                        <a href='$store_back_url$pro_url'>
                            <!-- Imagen -->
                            <img class='$class primary blur-up lazyload' data-src='../images/product-images/$img_1' alt='$pro_name' >
                            <!-- Hover Imagen -->
                            <img class='$class hover blur-up lazyload' data-src='../images/product-images/$img_2' alt='$pro_name'>
                            <!-- Producto label -->
                            <div class='product-labels rectangular'>
                                $product_label_desc
                                $product_label
                            </div> 
                            <!-- /Producto label -->
                                $outofstock_label
                        </a>    
                        <!-- Fabricante -->
                        <div class='pt-2 pb-2 saleTime manu'><span class='text-white'>$manufacturer_name</span></div>
                        <!-- /Fabricante -->
                        <!-- Boton añadir -->
                        <a class='variants add'  href='$store_back_url$pro_url' method='post'>
                            <button class='btn btn-addto-cart' type='button' tabindex='0'>Añadir al carrito</button>
                        </a>
                        <!-- /Boton añadir -->
                        <!-- Opciones producto -->
                        <div class='button-set'>
                            <!-- Boton para agregar a vista de deseos  -->
                            <div class='wishlist-btn'>
                                <a class='wishlist add-to-wishlist' onclick='wishlist($pro_id)' title='Agregar a deseos' href='#'>
                                    <i class='icon anm anm-heart-l'></i>
                                </a>
                            </div>
                            <!-- Boton para agregar a vista de deseos  -->
                
                        </div>
                        <!-- /Opciones producto -->
                    </div>
                    <!-- /Imagen producto -->
                    <!-- Detalles del producto-->
                    <div class='product-details text-center'>
                        <!-- Nombre del producto -->
                        <div class='product-name'>
                            <a href='$store_back_url$pro_url'>$pro_name</a>
                        </div>
                        <!-- /Nombre del producto -->
                        <!-- Precio del producto -->
                        <div class='product-price'>
                        $product_price
                        $product_price_new
                        </div>
                        <!-- /Precio del producto -->
                        <!-- Calificacion del producto -->
                        <div class='product-review'>
                            $product_rating_stars
                        </div>
                        <!-- /Calificacion del producto -->
                    </div>
                    <!-- /Detalles del producto-->
                </div>
                ";
    }
}

// Obtención de los productos mas recientes por categoria - Index
function getProRel($id, $subcat)
{
    global $con;
    $get_products = "SELECT * FROM products WHERE fk_product_subcat = $subcat  AND product_id NOT IN($id) AND status='Activo' ORDER BY product_id DESC LIMIT 10";
    $run_products = mysqli_query($con, $get_products);
    $count_products = mysqli_num_rows($run_products);
    if ($count_products == 0) {
        echo "<div class='col-12 item'><h5>No se encontraron productos relacionados</h5></div>";
    } else {
        while ($row_pro = mysqli_fetch_array($run_products)) {

            //Productos
            $pro_id = $row_pro['product_id'];
            $pro_name = $row_pro['product_name'];
            $pro_price = $row_pro['product_price'];
            $pro_price_new = $row_pro['product_price_new'];
            $pro_url = $row_pro['product_url'];

            //Img products
            $pro_img1 = "SELECT product_img FROM products_img WHERE fk_product = '$pro_id' AND position_img = 1";
            $run_img1 = $con->query($pro_img1);
            $row_img1 = $run_img1->fetch_assoc();
            $img_1 = $row_img1["product_img"];

            $pro_img2 = "SELECT product_img FROM products_img WHERE fk_product = '$pro_id' AND position_img = 2";
            $run_img2 = $con->query($pro_img2);
            $row_img2 = $run_img2->fetch_assoc();
            $img_2 = $row_img2["product_img"];

            $pro_label = $row_pro['product_label'];

            //Fabricante
            $manufacturer_id = $row_pro['fk_manufacturer'];
            $get_manufacturer = "SELECT * FROM manufacturers WHERE manufacturer_id='$manufacturer_id'";
            $run_manufacturer = mysqli_query($con, $get_manufacturer);
            $row_manufacturer = mysqli_fetch_array($run_manufacturer);
            $manufacturer_name = $row_manufacturer['manufacturer_name'];

            //Label producto
            if ($pro_label == "") {
                $product_label = "";
            } else {
                $product_label = "
                <span class='lbl pr-label1'>$pro_label</span>
             ";
            }

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

            //Stock producto
            $get_p_stock = "SELECT SUM(variation_amount) AS stock FROM product_variations WHERE fk_product ='$pro_id'";
            $run_stock = mysqli_query($con, $get_p_stock);
            $row_stock = mysqli_fetch_array($run_stock);
            $pro_stock = $row_stock['stock'];

            if ($pro_stock == 0 || $pro_stock == null) {
                $outofstock_label = "<span class='sold-out'><span>Agotado</span></span>";
                $class = 'grid-view-item__image';
            } else {
                $outofstock_label = "";
                $class = '';
            }

            //Precio nuevo - descuento / etiqueta producto con descuento
            if ($pro_price_new == 0) {
                //Precio actual
                $product_price = "<span class='price'>Q$pro_price</span>";
                //Precio de descuento
                $product_price_new = "";
                $product_label_desc = "";
            } else {
                //Precio anterior
                $product_price = "<span class='old-price'>Q$pro_price</span>";
                //Precio actuals
                $product_price_new = "<span class='price'>Q$pro_price_new</span>";
                //Calculo del porcentaje de descuento
                $pro_desc = (($pro_price_new * 100) / $pro_price) - 100;
                $round_pro_desc = ROUND($pro_desc, 2);
                $product_label_desc = "<span class='lbl on-sale'>$round_pro_desc%</span>";
            }

            $store_back_url = 'details.php?pro_id=';

            echo "
                <div class='col-12 item'>
                    <!-- Imagen producto-->
                    <div class='product-image'>
                        <a href='$store_back_url$pro_url'>
                            <!-- Imagen -->
                            <img class='$class primary blur-up lazyload' data-src='../images/product-images/$img_1' alt='$pro_name' >
                            <!-- Hover Imagen -->
                            <img class='$class hover blur-up lazyload' data-src='../images/product-images/$img_2' alt='$pro_name'>
                            <!-- Producto label -->
                            <div class='product-labels rectangular'>
                                $product_label_desc
                                $product_label
                            </div> 
                            <!-- /Producto label -->
                                $outofstock_label
                        </a>    
                        <!-- Fabricante -->
                        <div class='pt-2 pb-2 saleTime manu'><span class='text-white'>$manufacturer_name</span></div>
                        <!-- /Fabricante -->
                        <!-- Boton añadir -->
                        <a class='variants add'  href='$store_back_url$pro_url' method='post'>
                            <button class='btn btn-addto-cart' type='button' tabindex='0'>Añadir al carrito</button>
                        </a>
                        <!-- /Boton añadir -->
                        <!-- Opciones producto -->
                        <div class='button-set'>
                            <!-- Boton para agregar a vista de deseos  -->
                            <div class='wishlist-btn'>
                                <a class='wishlist add-to-wishlist' onclick='wishlist($pro_id)' title='Agregar a deseos' href='#'>
                                    <i class='icon anm anm-heart-l'></i>
                                </a>
                            </div>
                            <!-- Boton para agregar a vista de deseos  -->
                
                        </div>
                        <!-- /Opciones producto -->
                    </div>
                    <!-- /Imagen producto -->
                    <!-- Detalles del producto-->
                    <div class='product-details text-center'>
                        <!-- Nombre del producto -->
                        <div class='product-name'>
                            <a href='$store_back_url$pro_url'>$pro_name</a>
                        </div>
                        <!-- /Nombre del producto -->
                        <!-- Precio del producto -->
                        <div class='product-price'>
                        $product_price
                        $product_price_new
                        </div>
                        <!-- /Precio del producto -->
                        <!-- Calificacion del producto -->
                        <div class='product-review'>
                            $product_rating_stars
                        </div>
                        <!-- /Calificacion del producto -->
                    </div>
                    <!-- /Detalles del producto-->
                </div>
                ";
        }
    }
}

//Obtencion de los productos para el checkout
function getProCheckout()
{
    global $con;
    //Obtencion de la IP
    $ip_add = getRealUserIp();

    //Productos por IP
    $select_cart = "SELECT * FROM cart AS c
                     INNER JOIN products AS p
                     ON c.fk_product = p.product_id 
                     WHERE ip_add='$ip_add' AND c.cart_status = 0";

    $run_cart = mysqli_query($con, $select_cart);

    $total = 0;

    while ($row_cart = mysqli_fetch_array($run_cart)) {

        $cart_amount = $row_cart['cart_amount'];
        $cart_size = $row_cart['cart_size'];

        //Datos del producto
        $pro_name = $row_cart['product_name'];
        $pro_price = $row_cart['product_price'];
        $pro_price_new = $row_cart['product_price_new'];
        $pro_color = $row_cart['product_color'];

        //Precio del producto
        if ($pro_price_new == 0) {
            $pro_price = $pro_price;
        } else {
            $pro_price = $pro_price_new;
        }

        $cart_subtotal =  $cart_amount * $pro_price;

        //Total
        $total += $cart_subtotal;

        echo "
                <tr>
                    <td class='text-left'>$pro_name</td>
                    <td>Q$pro_price</td>
                    <td>$cart_size</td>
                    <td>$pro_color</td>
                    <td>$cart_amount</td>
                    <td>Q$cart_subtotal.00</td>
                </tr>
             ";
    }
    echo "
                </tbody>
                <tfoot class='font-weight-600'>
                    <tr>
                        <td colspan='5' class='text-right'>Transporte </td>
                        <td>Q0.00</td>
                    </tr>
                    <tr>
                        <td colspan='5' class='text-right'>Total</td>
                        <td>Q$total.00</td>
                    </tr>
                </tfoot>
     ";
}
