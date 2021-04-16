<?php include('includes/header.php'); ?>

<!-- Breadcrum -->
<div class="bredcrumbWrap">
    <div class="container breadcrumbs">
        <a href="index.php" title="Back to the home page">Incio</a><span aria-hidden="true">›</span><span>Resultado de "<?php echo @$_GET['user_query']; ?>"</span>
    </div>
</div>
<!-- /Breadcrum -->
<div class="container pt-5">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-9 col-lg-12 main-col">
            <div class="grid-products grid--view-items">
                <div class="row">
                    <?php
                    if (isset($_GET['user_query'])) {

                        $user_keyword = $_GET['user_query'];
                        $select_products = "SELECT * FROM products AS p
                                INNER JOIN manufacturers AS m
                                ON m.manufacturer_id = p.fk_manufacturer
                                INNER JOIN product_subcategories AS ps
                                ON ps.product_subcat_id = p.fk_product_subcat
                                INNER JOIN product_categories AS c 
                                ON c.product_cat_id = p.fk_product_cat
                                WHERE p.product_name LIKE '%$user_keyword%' OR 
                                p.product_label LIKE '%$user_keyword%' OR ps.product_subcat_name 
                                LIKE '%$user_keyword%' OR c.product_cat_name 
                                LIKE '%$user_keyword%' OR m.manufacturer_name LIKE '%$user_keyword%'";

                        $run_product = mysqli_query($con, $select_products);
                        $count = mysqli_num_rows($run_product);

                        if ($count == 0) {

                            echo "
                        <div class='container text-center mb-5'>
                            <h2>No se encontraron resultados de <br> $user_keyword</h2>
                        </div>
                        ";
                        } else {
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
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php') ?>