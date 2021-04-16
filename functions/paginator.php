<?php
//Paginador
function getPaginator()
{
    $per_page = 12;
    global $con;
    $aWhere = array();

    //Path
    $path = '';

    //Obtener por fabricante
    if (isset($_REQUEST['p_man']) && is_array($_REQUEST['p_man'])) {
        foreach ($_REQUEST['p_man'] as $sKey => $sVal) {
            if ((int)$sVal != 0) {
                $aWhere[] = 'manufacturer_id=' . (int)$sVal;
            }
        }
    }

    /// Obtener por subcategoria
    if (isset($_REQUEST['p_subcat']) && is_array($_REQUEST['p_subcat'])) {
        foreach ($_REQUEST['p_subcat'] as $sKey => $sVal) {
            if ((int)$sVal != 0) {
                $aWhere[] = 'p_subcat_id=' . (int)$sVal;
            }
        }
    }
        $query = "SELECT * FROM products";

    $result = mysqli_query($con, $query);
    
    //Total de productos
    $total_records = mysqli_num_rows($result);

    //Total de paginas
    $total_pages = ceil($total_records / $per_page);

    //Url paginacion
    $pagination_url = "shop.php";

    //Inicializacion paginacion
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    //Primera página - parte 1
    echo "<li><a href='$pagination_url?page=1";

    //Filtracion por categoria / fabricante-marca
    if (!empty($path)) {
        echo "&" . $path;
    }

    //Primera página - parte 2
    echo "' ><i class='fa fa-angle-double-left'></i></a></li>";
    //Contandor paginas - clase active
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page) {
            $active = "active";
        } else {
            $active = "";
        }
        echo "<li class='$active'><a href='$pagination_url?page=" . $i . (!empty($path) ? '&' . $path : '') . "' >" . $i . "</a></li>";
    };
    //Ultima página - parte 1 
    echo "<li><a href='$pagination_url?page=$total_pages";
    
     //Filtracion por categoria / fabricante-marca
    if (!empty($path)) {
        echo "&" . $path;
    }
    //Ultima página - parte 2
    echo "' ><i class='fa fa-angle-double-right'></i></a></li>";

}