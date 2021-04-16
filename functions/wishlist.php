
<?php
function getWishlist()
{
    global $con;
    $customer_session = $_SESSION['email'];

    $get_customer = "SELECT c.customer_id AS customer_id FROM customers AS c 
                     INNER JOIN person AS p 
                     ON p.person_id = c.fk_person
                     WHERE p.person_email ='$customer_session'";

    $run_customer = mysqli_query($con, $get_customer);
    $row_customer = mysqli_fetch_array($run_customer);
    $customer_id = $row_customer['customer_id'];

    $i = 0;

    $get_wishlist = "SELECT * FROM wishlist WHERE fk_customer='$customer_id'";
    $run_wishlist = mysqli_query($con, $get_wishlist);
    $num_rows = mysqli_num_rows($run_wishlist);

    while ($row_wishlist = mysqli_fetch_array($run_wishlist)) {

        $wishlist_id = $row_wishlist['wishlist_id'];
        $product_id = $row_wishlist['fk_product'];
        $get_products = "SELECT * FROM products WHERE product_id='$product_id'";
        $run_products = mysqli_query($con, $get_products);
        $row_products = mysqli_fetch_array($run_products);
        $product_name = $row_products['product_name'];
        $product_url = $row_products['product_url'];
        $product_color = $row_products['product_color'];

        //Fabricante
        $manufacturer_id = $row_products['fk_manufacturer'];
        $get_manufacturer = "SELECT * FROM manufacturers WHERE manufacturer_id='$manufacturer_id'";
        $run_manufacturer = mysqli_query($con, $get_manufacturer);
        $row_manufacturer = mysqli_fetch_array($run_manufacturer);
        $manufacturer_name = $row_manufacturer['manufacturer_name'];

        //Img products
        $pro_img1 = "SELECT product_img FROM products_img WHERE fk_product = '$product_id' AND position_img = 1";
        $run_img1 = $con->query($pro_img1);
        $row_img1 = $run_img1->fetch_assoc();
        $img_1 = $row_img1["product_img"];

        $i++;

        echo "
            <tr>
                    <td width='100'>$i</td>
                    <td width='100'><img src='images/product-images/$img_1' width='60' height='70'></td>
                    <td class='text-left'>
                    <a class='h4' href='details.php?pro_id=$product_url'>$product_name</a>
                        <div class='cart__meta-text'>
                           <b>Marca</b>: $manufacturer_name, <b>Color</b>: $product_color
                        </div>
                    </td>
                    <td class='text-center small--hide'><a href='#' class='btn btn-wishlist cart__remove' onclick='RemoveWish($wishlist_id)' ><i class='icon icon anm anm-times-l'></i></a></td>
            </tr>
        ";
    }
    if ($num_rows == 0) {
        echo "<tr class='text-center'>
                <td colspan='5'>No tiene productos agregados</td>
              </tr>";
    }
}
