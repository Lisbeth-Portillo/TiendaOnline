<?php

//session_start();

$db = mysqli_connect("localhost", "root", "", "ecommerce");

/// IP address code Ends /////

if (isset($_SESSION['customer_email'])) {

  $customer_email = $_SESSION['customer_email'];

  $select_customer = "select * from customers where customer_email='$customer_email'";

  $run_customer = mysqli_query($con, $select_customer);

  $row_customer = mysqli_fetch_array($run_customer);

  $customer_id = $row_customer['customer_id'];
} else {

  $customer_id = 0;
}

// items function Starts ///

function items()
{

  global $db;

  $count_items = 0;

  $ip_add = getRealUserIp();

  $get_items = "select * from cart where ip_add='$ip_add'";

  $run_items = mysqli_query($db, $get_items);

  while ($row_items = mysqli_fetch_array($run_items)) {

    $product_qty = $row_items['qty'];

    $count_items += $product_qty;
  }

  echo $count_items;
}


// items function Ends ///

// total_price function Starts //

function total_price()
{

  global $db;

  $ip_add = getRealUserIp();

  $total = 0;

  $select_cart = "select * from cart where ip_add='$ip_add'";

  $run_cart = mysqli_query($db, $select_cart);

  while ($record = mysqli_fetch_array($run_cart)) {

    $pro_id = $record['p_id'];

    $pro_qty = $record['qty'];


    $sub_total = $record['p_price'] * $pro_qty;

    $total += $sub_total;
  }

  echo "$" . $total;
}



// total_price function Ends //





/// getPaginator Function Starts ///

function getPaginator($vendor_id)
{

  /// getPaginator Function Code Starts ///

  $per_page = 6;

  global $db;

  $aWhere = array();

  $aPath = '';

  /// Manufacturers Code Starts ///

  if (isset($_REQUEST['man']) && is_array($_REQUEST['man'])) {

    foreach ($_REQUEST['man'] as $sKey => $sVal) {

      if ((int)$sVal != 0) {

        $aWhere[] = 'manufacturer_id=' . (int)$sVal;

        $aPath .= 'man[]=' . (int)$sVal . '&';
      }
    }
  }

  /// Manufacturers Code Ends ///

  /// Products Categories Code Starts ///

  if (isset($_REQUEST['p_cat']) && is_array($_REQUEST['p_cat'])) {

    foreach ($_REQUEST['p_cat'] as $sKey => $sVal) {

      if ((int)$sVal != 0) {

        $aWhere[] = 'p_cat_id=' . (int)$sVal;

        $aPath .= 'p_cat[]=' . (int)$sVal . '&';
      }
    }
  }

  /// Products Categories Code Ends ///

  /// Categories Code Starts ///

  if (isset($_REQUEST['cat']) && is_array($_REQUEST['cat'])) {

    foreach ($_REQUEST['cat'] as $sKey => $sVal) {

      if ((int)$sVal != 0) {

        $aWhere[] = 'cat_id=' . (int)$sVal;

        $aPath .= 'cat[]=' . (int)$sVal . '&';
      }
    }
  }

  /// Categories Code Ends ///

  $sWhere = (count($aWhere) > 0 ? ' and (' . implode(' or ', $aWhere) . ')' : '');

  if (empty($vendor_id)) {

    $query = "select * from products WHERE product_vendor_status='active' " . $sWhere;

    $pagination_url = "shop.php";
  } else {

    $query = "select * from products WHERE product_vendor_status='active' and vendor_id='$vendor_id'" . $sWhere;

    $select_customer = "select * from customers where customer_id='$vendor_id'";

    $run_customer = mysqli_query($db, $select_customer);

    $row_customer = mysqli_fetch_array($run_customer);

    $vendor_username = $row_customer['customer_username'];

    $pagination_url = "$vendor_username";
  }

  $result = mysqli_query($db, $query);

  $total_records = mysqli_num_rows($result);

  $total_pages = ceil($total_records / $per_page);

  if (isset($_GET['page'])) {

    $page = $_GET['page'];
  } else {

    $page = 1;
  }

  echo "<li><a href='$pagination_url?page=1";

  if (!empty($aPath)) {
    echo "&" . $aPath;
  }

  echo "' >" . 'First Page' . "</a></li>";

  for ($i = 1; $i <= $total_pages; $i++) {

    if ($i == $page) {

      $active = "active";
    } else {

      $active = "";
    }

    echo "<li class='$active'><a href='$pagination_url?page=" . $i . (!empty($aPath) ? '&' . $aPath : '') . "' >" . $i . "</a></li>";
  };

  echo "<li><a href='$pagination_url?page=$total_pages";

  if (!empty($aPath)) {
    echo "&" . $aPath;
  }

  echo "' >" . 'Last Page' . "</a></li>";

  /// getPaginator Function Code Ends ///

}

/// getPaginator Function Ends ///


/// getProducts Function Starts ///

function getProducts($vendor_id)
{

  /// getProducts function Code Starts ///

  global $db;

  $aWhere = array();

  /// Manufacturers Code Starts ///

  if (isset($_REQUEST['man']) && is_array($_REQUEST['man'])) {

    foreach ($_REQUEST['man'] as $sKey => $sVal) {

      if ((int)$sVal != 0) {

        $aWhere[] = 'manufacturer_id=' . (int)$sVal;
      }
    }
  }

  /// Manufacturers Code Ends ///

  /// Products Categories Code Starts ///

  if (isset($_REQUEST['p_cat']) && is_array($_REQUEST['p_cat'])) {

    foreach ($_REQUEST['p_cat'] as $sKey => $sVal) {

      if ((int)$sVal != 0) {

        $aWhere[] = 'p_cat_id=' . (int)$sVal;
      }
    }
  }

  /// Products Categories Code Ends ///

  /// Categories Code Starts ///

  if (isset($_REQUEST['cat']) && is_array($_REQUEST['cat'])) {

    foreach ($_REQUEST['cat'] as $sKey => $sVal) {

      if ((int)$sVal != 0) {

        $aWhere[] = 'cat_id=' . (int)$sVal;
      }
    }
  }

  /// Categories Code Ends ///

  $per_page = 6;

  if (isset($_GET['page'])) {

    $page = $_GET['page'];
  } else {

    $page = 1;
  }

  $start_from = ($page - 1) * $per_page;

  global $customer_id;

  $ip_address = getRealUserIp();

  //$viewed_products = array();

  $relevent_products = array();

  $select_customer_history = "select * from customers_history where ip_address='$ip_address' and customer_id='$customer_id' order by 1 desc";

  $run_customer_history = mysqli_query($db, $select_customer_history);

  $count_customer_history = mysqli_num_rows($run_customer_history);

  while ($row_customer_history = mysqli_fetch_array($run_customer_history)) {

    $product_id = $row_customer_history["product_id"];

    $get_product = "select * from products where product_id='$product_id'";

    $run_product = mysqli_query($db, $get_product);

    $row_product = mysqli_fetch_array($run_product);

    $p_cat_id = $row_product['p_cat_id'];

    $cat_id = $row_product['cat_id'];

    if (!isset($relevent_products["p_cat_ids"]) and !isset($relevent_products["cat_ids"])) {

      $relevent_products["p_cat_ids"] = array();

      $relevent_products["cat_ids"] = array();
    }

    array_push($relevent_products["p_cat_ids"], $p_cat_id);

    array_push($relevent_products["cat_ids"], $cat_id);

    //array_push($viewed_products, $product_id);

  }

  //$product_ids = implode(",", $viewed_products);

  if (!empty($relevent_products)) {

    $p_cat_ids = implode(",", $relevent_products["p_cat_ids"]);

    $cat_ids = implode(",", $relevent_products["cat_ids"]);

    // $sLimit = " order by product_id IN ($product_ids) DESC,product_id DESC LIMIT $start_from,$per_page";

    $sLimit = " order by p_cat_id IN ($p_cat_ids) DESC,cat_id IN ($cat_ids) DESC,product_id DESC LIMIT $start_from,$per_page";
  } else {

    $sLimit = " order by 1 DESC LIMIT $start_from,$per_page";
  }

  $sWhere = (count($aWhere) > 0 ? ' and (' . implode(' or ', $aWhere) . ')' : '') . $sLimit;

  if (empty($vendor_id)) {

    $get_products = "select * from products WHERE product_vendor_status='active' " . $sWhere;
  } else {

    $get_products = "select * from products WHERE product_vendor_status='active' and vendor_id='$vendor_id'" . $sWhere;
  }

  $run_products = mysqli_query($db, $get_products);

  while ($row_products = mysqli_fetch_array($run_products)) {

    $pro_id = $row_products['product_id'];

    $pro_title = $row_products['product_title'];

    $pro_price = $row_products['product_price'];

    $pro_img1 = $row_products['product_img1'];

    $pro_label = $row_products['product_label'];

    $manufacturer_id = $row_products['manufacturer_id'];

    $get_manufacturer = "select * from manufacturers where manufacturer_id='$manufacturer_id'";

    $run_manufacturer = mysqli_query($db, $get_manufacturer);

    $row_manufacturer = mysqli_fetch_array($run_manufacturer);

    $manufacturer_name = $row_manufacturer['manufacturer_title'];

    $pro_psp_price = $row_products['product_psp_price'];

    $pro_url = $row_products['product_url'];

    $product_type = $row_products['product_type'];

    if ($product_type != "variable_product") {

      if ($pro_label == "Sale" or $pro_label == "Gift") {

        $product_price = "<del> $$pro_price </del>";

        $product_psp_price = "| $$pro_psp_price";
      } else {

        $product_psp_price = "";

        $product_price = "$$pro_price";
      }
    } else {

      $select_min_product_price = "select min(product_price) as product_price from product_variations where product_id='$pro_id' and product_price!='0'";

      $run_min_product_price = mysqli_query($db, $select_min_product_price);

      $row_min_product_price = mysqli_fetch_array($run_min_product_price);

      $minimum_product_price = $row_min_product_price["product_price"];

      $select_max_product_price = "select max(product_price) as product_price from product_variations where product_id='$pro_id'";

      $run_max_product_price = mysqli_query($db, $select_max_product_price);

      $row_max_product_price = mysqli_fetch_array($run_max_product_price);

      $maximum_product_price = $row_max_product_price["product_price"];

      $product_price = "$$minimum_product_price - $$maximum_product_price";

      $product_psp_price = "";
    }


    if ($pro_label == "") {

      $product_label = "";
    } else {

      $product_label = "

<a class='label sale' href='#' style='color:black;'>

<div class='thelabel'>$pro_label</div>

<div class='label-background'> </div>

</a>

";
    }

    if (empty($vendor_id)) {

      $store_back_url = "";
    } else {

      $store_back_url = "../";
    }

    $reviews_rating = array();

    $select_product_reviews = "select * from reviews where product_id='$pro_id' and review_status!='pending'";

    $run_product_reviews = mysqli_query($db, $select_product_reviews);

    $count_product_reviews = mysqli_num_rows($run_product_reviews);

    if ($count_product_reviews != 0) {

      while ($row_product_reviews = mysqli_fetch_array($run_product_reviews)) {

        $product_review_rating = $row_product_reviews['review_rating'];

        array_push($reviews_rating, $product_review_rating);
      }

      $total = array_sum($reviews_rating);

      $product_rating = $total / count($reviews_rating);

      $star_product_rating = substr($product_rating, 0, 1);
    } else {

      $star_product_rating = 0;
    }

    $product_rating_stars = "";

    for ($product_i = 0; $product_i < $star_product_rating; $product_i++) {

      $product_rating_stars .= " <img class='rating' src='$store_back_url" . "images/star_full_big.png'> ";
    }

    for ($product_i = $star_product_rating; $product_i < 5; $product_i++) {

      $product_rating_stars .= " <img class='rating' src='$store_back_url" . "images/star_blank_big.png'> ";
    }

    $product_rating_stars .= " ($count_product_reviews)";

    $select_product_stock = "select * from products_stock where product_id='$pro_id'";

    $run_product_stock = mysqli_query($db, $select_product_stock);

    if ($product_type != "variable_product") {

      $row_product_stock = mysqli_fetch_array($run_product_stock);

      $stock_status = $row_product_stock["stock_status"];
    } else {

      $instock = 0;

      while ($row_product_stock = mysqli_fetch_array($run_product_stock)) {

        $stock_status = $row_product_stock["stock_status"];

        if ($stock_status == "instock") {

          $instock += $row_product_stock["stock_quantity"];
        }
      }
    }

    if (

      ($product_type != "variable_product" and $stock_status == "outofstock") or
      ($product_type == "variable_product" and $instock == 0)

    ) {

      $outofstock_label = " <div class='out-of-stock-label'>Out of stock</div> ";
    } else {

      $outofstock_label = "";
    }

    echo "

<div class='col-md-4 col-sm-6 center-responsive' >

<div class='product' >

<a href='$store_back_url$pro_url'>

<img src='$store_back_url" . "admin_area/product_images/$pro_img1' class='product-img'>

$outofstock_label

</a>

<div class='text' >

<center>

<p class='btn btn-primary'> $manufacturer_name </p>

</center>

<hr>

<h3 class='product-title'> <a href='$store_back_url$pro_url'> $pro_title </a> </h3>

<p class='star-rating'> $product_rating_stars </p>

<p class='price'> $product_price $product_psp_price </p>

<p class='buttons'>

<a href='$store_back_url$pro_url' class='btn btn-default' >View details</a>

<a href='$store_back_url$pro_url' class='btn btn-primary'>

<i class='fa fa-shopping-cart'></i> Add to cart

</a>


</p>

</div>

$product_label


</div>

</div>

";
  }
  /// getProducts function Code Ends ///

}


/// getProducts Function Ends ///
