<?php include('includes/header.php') ?>
<!-- Contenido -->
<div id="page-content">
    <!-- Titulo pagina -->
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper">
                <h1 class="page-width">Tu carrito</h1>
            </div>
        </div>
    </div>
    <!-- /Titulo pagina -->
    <!-- Container -->
    <div class="container mt-4">
        <div class="row">
            <!-- Columna 1 -->
            <div class="col-12 col-sm-12 col-md-8 col-lg-8 main-col">
                <!-- Formulario -->
                <form action="#" method="post" class="cart style2">
                    <!-- Tabla -->
                    <table>
                        <thead class="cart__row cart__header">
                            <tr>
                                <th colspan="2" class="text-center">Producto</th>
                                <th class="text-center">Precio</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-right">SubTotal</th>
                                <th class="action">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody id="cart-products-tbody">
                            <?php
                            //Obtencion de la IP
                            $ip_add = getRealUserIp();

                            //Productos por IP
                            $select_cart = "SELECT * FROM cart AS c
                                            INNER JOIN products AS p
                                            ON c.fk_product = p.product_id 
                                            INNER JOIN manufacturers AS m
                                            ON m.manufacturer_id = p.fk_manufacturer
                                            WHERE ip_add='$ip_add' AND c.cart_status = 0";

                            $run_cart = mysqli_query($con, $select_cart);

                            $total = 0;
                            $num_rows = mysqli_num_rows($run_cart);

                            while ($row_cart = mysqli_fetch_array($run_cart)) {
                                //Datos del carrito
                                $cart_id = $row_cart['cart_id'];
                                $pro_id = $row_cart['fk_product'];
                                $cart_amount = $row_cart['cart_amount'];
                                $cart_size = $row_cart['cart_size'];

                                //Marca
                                $pro_manu = $row_cart['manufacturer_name'];

                                //Datos del producto
                                $pro_url = $row_cart['product_url'];
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



                                //Img products
                                $pro_img1 = "SELECT product_img FROM products_img WHERE fk_product = '$pro_id' AND position_img = 1";
                                $run_img1 = $con->query($pro_img1);
                                $row_img1 = $run_img1->fetch_assoc();
                                $pro_img = $row_img1["product_img"];

                                //Cantidad variacion
                                $amount_size = "SELECT * FROM product_variations AS p
                                            INNER JOIN size AS s
                                            ON s.size_id = p.fk_size 
                                            WHERE fk_product = '$pro_id' AND size = '$cart_size'";

                                $run_amount = $con->query($amount_size);
                                $row_amount = $run_amount->fetch_assoc();
                                $variation_amount = $row_amount["variation_amount"];
                                $variation_id = $row_amount["product_variation_id"];

                                $cart_subtotal =  $cart_amount * $pro_price;

                                //Total
                                $total += $cart_subtotal;

                                echo "
                                        <!-- Producto -->
                                        <tr class='cart__row border-bottom line1 cart-flex border-top'>
                                            <!-- Img -->
                                            <td class='cart__image-wrapper cart-flex-item'>
                                                <a href='details.php?pro_id=$pro_url'><img class='cart__image' src='images/product-images/$pro_img'></a>
                                            </td>
                                            <!-- /Img -->
                                            <!-- Nombre -->
                                            <td class='cart__meta small--text-left cart-flex-item'>
                                                <div class='list-view-item__title'>
                                                    <a href='#'>$pro_name</a>
                                                </div>
                                                <div class='cart__meta-text'>
                                                    Marca: $pro_manu<br>
                                                    Size: $cart_size, Color: $pro_color
                                                    <input type='hidden' name='size' value='$cart_size'>
                                                </div>
                                            </td>
                                            <!-- /Nombre -->
                                            <!-- Precio -->
                                            <td class='cart__price-wrapper cart-flex-item'>
                                                <span class='money'>Q$pro_price</span>
                                            </td>
                                            <!-- /Precio -->
                                            <!-- Cantidad -->
                                            <td class='cart__update-wrapper cart-flex-item text-right'>
                                                <div class='cart__qty text-center'>
                                                    <div class='qtyField'> 
                                                        <input class='cart__qty-input qty' type='number' name='qty' autocomplete='off' onkeyup='Amount($cart_id)' onchange='Amount($cart_id)' id='$cart_id' value='$cart_amount' data-cart_id='$cart_id' min='1' data-product_id='$pro_id' max='$variation_amount' >
                                                    </div>
                                                </div>
                                            </td>
                                            <!-- /Cantidad -->
                                            <!-- Subtotal -->
                                            <td class='text-right small--hide cart-price'>
                                                <div><span class='money'>$cart_subtotal</span></div>
                                            </td>
                                            <!-- /Subtotal -->
                                            <!-- Boton quitar -->
                                            <td class='text-center small--hide'><a href='#' class='btn btn--secondary cart__remove' onclick='Remove($cart_id)' ><i class='icon icon anm anm-times-l'></i></a></td>
                                            <!-- /Boton quitar -->
                                        </tr>
                                        <!-- /Producto -->
                                     ";
                            }
                            if ($num_rows == 0) {
                                echo "<tr class='text-center'>
                                        <td colspan='5'>No tiene productos en su carrito</td>
                                      </tr>";
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <!-- Botones acciones -->
                            <tr>
                                <td colspan="3" class="text-left"><a href="shop.php" class="btn--link cart-continue"><i class="icon icon-arrow-circle-left"></i> Seguir comprando</a></td>
                                <td colspan="3" class="text-right"><button type="submit" name="update" class="btn--link cart-update"><i class="fa fa-refresh"></i> Actualizar</button></td>
                            </tr>
                            <!-- /Botones acciones -->
                        </tfoot>
                    </table>
                    <!-- /Tabla -->
                </form>
                <!-- /Formulario -->
            </div>
            <!-- /Columna 1 -->
            <!-- Columna 2 -->
            <div class="col-12 col-sm-12 col-md-4 col-lg-4 cart__footer">
                <!-- Total y condiciones -->
                <div class="solid-border">
                    <div class="row" id="cart-summary-tbody">
                        <span class="col-12 col-sm-6 cart__subtotal-title">Total:</span>
                        <span class="col-12 col-sm-6 cart__subtotal-title cart__subtotal text-center" style="font-size: 30px"><span class="money total">Q<?php echo $total ?>.00</span></span>
                    </div>
                    <div class="cart__shipping">Gastos de envío e impuestos calculados al finalizar la compra</div>
                    <p class="cart_tearm">
                        <label>
                            <input type="checkbox" name="termcond" id="termcond" class="checkbox" required="">
                            Estoy de acuerdo con los términos y condiciones
                        </label>
                    </p>
                    <input type="submit" name="checkout" onclick="checkout();" class="btn btn--small-wide checkout" value="Checkout">
                </div>
                <!-- Total y condiciones -->
            </div>
            <!-- /Columna 2 -->
        </div>
    </div>
    <!-- /Container -->
</div>
<!-- /Contenido -->

<?php include('includes/footer.php'); ?>

<script>
    //Actualizar precio total y por producto en base a la cantidad
    function Amount(cart_id) {
        var id = '#' + cart_id;
        var value = parseInt($(id).val(), 10); //Precio actual
        var max = parseInt($(id).attr("max"), 10); //Precio maximo
        var min = parseInt($(id).attr("min"), 10);; //Precio minimo 1

        //Precio del producto seleccionado
        var value = parseInt($(id).val(), 10); //Precio actual
        var max = parseInt($(id).attr("max"), 10); //Precio maximo
        var min = parseInt($(id).attr("min"), 10);; //Precio minimo 1

        if (value > max) { //No sobrepasa el valor maximo
            value = max;
            $(id).val(value);

        } else if (value < min) { //No sobrepasa el valor minimo
            value = min;
            $(id).val(value);
        }

        var quantity = $(id).val(); //Cantidad
        var cart_id = $(id).data("cart_id"); //Id de la variacion del producto
        var product_id = $(id).data("product_id"); //Id del producto

        var post_data = {
            cart_id: cart_id,
            product_id: product_id,
            qty: quantity
        };
        if (quantity != '') {
            $.ajax({
                url: "ajax/carrito.php?op=updatecart",
                method: "POST",
                data: post_data,

                success: function(data) {
                    $(".total").html(data); //Total de la compra
                    $("#cart-products-tbody").load('cart/cart_body.php'); //Productos
                    $("#cart-summary-tbody").load('cart/cart_summary.php'); //Total
                }

            });

        }
        //Actualizar numero de productos en el carrito
        itemsCard();
    }

    function Remove(cart_id) {
        $.ajax({
            url: "ajax/carrito.php?op=deletecart",
            method: "POST",
            data: {
                cart_id: cart_id
            },

            success: function(data) {
                if (data == 1) {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success('Producto eliminado');
                    //Actualizar datos de la pagina
                    $("#cart-products-tbody").load('cart/cart_body.php'); //Productos
                    $("#cart-summary-tbody").load('cart/cart_summary.php'); //Total
                    //Actualizar numero de productos en el carrito
                    itemsCard();

                } else {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.error('ERROR');
                }
            }

        });
    }

    function checkout() {
        $checkbox = $('input:checkbox[name=termcond]:checked').val();
        if ($checkbox == 'on') {
            $(location).attr("href", "checkout.php");
        } else {
            alertify.set('notifier', 'position', 'top-right');
            alertify.error('Acepte los términos y condiciones');
        }
    }
</script>