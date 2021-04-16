<?php
//Categorias collecion index
function getColCategory()
{
    global $con;
    //Obtencion de las categorias
    $get_product_cat = "SELECT * FROM product_subcategories ORDER BY product_subcat_id DESC ";
    $run_product_cat = mysqli_query($con, $get_product_cat);
    while ($row_cat = mysqli_fetch_array($run_product_cat)) {

        $subcat_id = $row_cat['product_subcat_id'];
        $subcat_name = $row_cat['product_subcat_name'];
        $subcat_img = $row_cat['product_subcat_img'];

        echo "
                <div class='collection-grid-item'>
                    <!-- Link categoria -->
                    <a href='shop.php?p_subcat=$subcat_id' class='collection-grid-item__link'>
                        <!-- Imagen categoria -->
                        <img data-src='images/subcategory/$subcat_img' alt='$subcat_name' class='blur-up lazyload' />
                        <!-- /Imagen categoria -->
                        <div class='collection-grid-item__title-wrapper'>
                            <!-- Nombre categoria -->
                            <h3 class='collection-grid-item__title btn btn--secondary no-border'>$subcat_name</h3>
                            <!-- /Nombre categoria -->
                        </div>
                    </a>
                    <!-- /Link categoria -->
                </div>
                ";
    }
}
//Categorias footer
function getCatSlider()
{
    global $con;
    //Obtencion de las categorias
    $get_product_cat = "SELECT * FROM product_categories ORDER BY product_cat_id LIMIT 2";
    $run_product_cat = mysqli_query($con, $get_product_cat);
    while ($row_cat = mysqli_fetch_array($run_product_cat)) {

        $cat_id = $row_cat['product_cat_id'];
        $cat_name = $row_cat['product_cat_name'];

        if ($cat_id == 1) {
            $class = 'active';
        } else {
            $class = '';
        }
        echo "
                <li class='$class' rel='tab$cat_id'>$cat_name</li>
             ";
    }
}
//Categorias - subcategorias Tienda
function getSubCategory()
{
    global $con;
    //Obtencion de las categorias
    $get_product_cat = "SELECT * FROM product_categories";
    $run_product_cat = mysqli_query($con, $get_product_cat);
    while ($row_cat = mysqli_fetch_array($run_product_cat)) {

        $cat_id = $row_cat['product_cat_id'];
        $cat_name = $row_cat['product_cat_name'];

        $get_product_subcat = "SELECT p.product_subcat_name AS name_subcategory, p.product_subcat_id AS id_subcategory FROM details_categories AS d 
                                INNER JOIN product_subcategories AS p
                                ON p.product_subcat_id = d.fk_product_subcat
                                WHERE d.fk_product_cat = $cat_id";

        $run_product_subcat = mysqli_query($con, $get_product_subcat);

        $subcategory = "";
        while ($row_subcat = mysqli_fetch_array($run_product_subcat)) {
            $subcat_id = $row_subcat['id_subcategory'];
            $subcat_name = $row_subcat['name_subcategory'];

            $subcategory .= "
                                <li class='level2'>
                                    <a href='shop.php?p_subcat=$subcat_id'>
                                        <label for='checks$subcat_name'><span><span></span></span>-$subcat_name</label>
                                    </a>
                                </li>
                            ";
        }
        if (!empty($subcategory)) {
            $product_subcat = " <ul class='sublinks'>$subcategory</ul>";
            $class_subact = 'level1 sub-level';
        } else {
            $class_subact = 'lvl-1';
            $product_subcat = '';
        }
        echo "
                    <!-- Categoria principal -->
                    <li class='$class_subact'><a href='#;' class='site-nav'>$cat_name</a>
                    <!-- Sub-categoria -->
                        $product_subcat
                    </li>
                ";
    }
}

