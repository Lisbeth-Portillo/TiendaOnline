<?php
// Obtención de los productos mas recientes por categoria - Index
function getReview($pro_id)
{
    global $con;
    //Críticas o revisiones de los productos
    $select_product_reviews = "SELECT * FROM reviews AS r
                               INNER JOIN customers AS c
                               ON c.customer_id = r.fk_costumer
                               INNER JOIN person AS p
                               ON p.person_id = c.fk_person 
                               WHERE fk_product='$pro_id' AND review_status = 'Aprobado' 
                               ORDER BY review_id DESC LIMIT 5";

    $run_product_reviews = mysqli_query($con, $select_product_reviews);
    while ($row_reviews = mysqli_fetch_array($run_product_reviews)) {

        //Datos de la reseña
        $review_name = $row_reviews['review_name'];
        $review_cont = $row_reviews['review_content'];
        $review_date = $row_reviews['review_date'];
        $c_name = $row_reviews['person_name'];

        //Numero de criticas del producto
        $count_product_reviews = mysqli_num_rows($run_product_reviews);
        
        if ($count_product_reviews != 0) {
            $star_product_rating = $row_reviews['review_rating'];;
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

        //Fecha
        date_default_timezone_set('UTC');
        //$hora = strftime("%I:%M:%S %p", strtotime($timestamp));Descomentar en caso de requerir hora
        setlocale(LC_TIME, 'spanish');
        $fecha = utf8_encode(strftime("%b %d, %Y", strtotime($review_date)));
        //$hora; concatenar con fecha para obtener fecha y hora

        echo " 
            <!-- Reseña -->
            <div class='spr-review'>
                <div class='spr-review-header'>
                    <!-- Valoraciones -->
                    <span class='product-review spr-starratings spr-review-header-starratings'><span class='reviewLink'>$product_rating_stars</span></span>
                    <!-- Cliente -->
                    <h3 class='spr-review-header-title text-capitalize'>$review_name</h3>
                    <p class='text-capitalize'>$c_name</p>
                    <!-- Fecha -->
                    <span class='spr-review-header-byline'><strong>$fecha</strong></span>
                </div>
                <!-- Contenido -->
                <div class='spr-review-content'>
                    <p class='spr-review-content-body'>$review_cont
                    </p>
                </div>
            </div>
            <!-- Reseña -->     
            ";
    }
}
