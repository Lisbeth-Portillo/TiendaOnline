<?php include('includes/header.php');

//Redireccion si el usuario no esta registrado o logueado
if (!isset($_SESSION['email'])) {
    echo "<script>window.open('index.php','_self')</script>";
}
?>
<!-- Contenido-->
<!-- Titulo pagina -->
<div class="page section-header text-center">
    <div class="page-title">
        <div class="wrapper">
            <h1 class="page-width">Mi cuenta</h1>
        </div>
    </div>
</div>
<!-- /Titulo pagina -->
<div id="page-content" class="mt-4 mb-4">
    <!-- Cpntainer -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Mi cuenta -->
                <div class="myaccount-page-wrapper">
                    <div class="row">
                        <!-- Columna 1 - menu -->
                        <div class="col-lg-3">
                            <div class="myaccount-tab-menu nav" role="tablist">
                                <a class="bg-light text-center" id="accountedit">
                                    <?php
                                    global $con;

                                    $email = $_SESSION['email'];
                                    $select_customer = "SELECT * FROM person WHERE person_email = '$email'";
                                    $run_customer = mysqli_query($con, $select_customer);
                                    $row_customer = mysqli_fetch_array($run_customer);
                                    $name = $row_customer['person_name'];

                                    echo " 
                                        <h2>Mi perfil</h2>
                                        <hr>
                                        <h6 class='mt-2 text-capitalize'>$name</h6>
                                        <h6 class='text-lowercase'>$email</h6>
                                    ";
                                    ?>
                                </a>

                                <a href="#orders" class="active" data-toggle="tab"><i class="fa fa-cart-arrow-down"></i> Pedidos</a>

                                <a href="#address" data-toggle="tab"><i class="fa fa-map-marker"></i> Dirección</a>

                                <a href="#wishlist" data-toggle="tab"><i class="fa fa-heart fa-2x"></i> Lista de deseos</a>

                                <a href="#account-info" data-toggle="tab"><i class="fa fa-user"></i> Detalles de la cuenta</a>

                                <a href="#account-pass" data-toggle="tab"><i class="fa fa-key"></i> Cambiar contraseña</a>

                                <a href="ajax/user.php?op=salir"><i class="fa fa-sign-out"></i> Cerra sesión</a>
                            </div>
                        </div>
                        <!-- /Columna 1 - menu -->

                        <!-- Columna 2 - contenido -->
                        <div class="col-lg-9 mt-5 mt-lg-0">
                            <div class="tab-content" id="myaccountContent">

                                <!-- Pedidos -->
                                <?php
                                if (!isset($_GET['order_id'])) {

                                    include('account/orders.php');
                                } else {
                                    $order_id = $_GET['order_id']
                                ?>

                                    <div class="tab-pane fade show active" id="orders" role="tabpanel">
                                        <div class="myaccount-content">
                                            <a href="account.php" class="btn--link cart-continue"><i class="icon icon-arrow-circle-left"></i> Regresar</a>
                                            <h3>Información de Ordenes</h3>

                                            <div class="myaccount-table table-responsive text-left">
                                                <!--Datos de la orden -->
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="font-weight: 400" colspan="2">Detalle de la Orden</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $email = $_SESSION['email'];

                                                        $get_customer = "SELECT * FROM customers AS c 
                                                                        INNER JOIN person AS p
                                                                        ON p.person_id = c.fk_person
                                                                        INNER JOIN municipality AS m
                                                                        ON m.municipality_id = c.fk_municipality
                                                                        INNER JOIN departments AS d
                                                                        ON d.department_id = c.fk_department
                                                                        WHERE p.person_email ='$email'";

                                                        $run_get_customer = mysqli_query($con, $get_customer);
                                                        $row_customer = mysqli_fetch_array($run_get_customer);
                                                        $customer_id = $row_customer['customer_id'];

                                                        $get_orders = "SELECT * FROM orders o
                                                                    INNER JOIN orders_status AS os
                                                                    ON o.fk_order_status = os.orders_status_id
                                                                    WHERE o.order_id='$order_id' ORDER BY 1 DESC";

                                                        $run_orders = mysqli_query($con, $get_orders);
                                                        $row_orders = mysqli_fetch_array($run_orders);

                                                        $orden_no = $row_orders['orden_no'];
                                                        $payment_method = $row_orders['payment_method'];
                                                        $order_date = $row_orders['order_date'];
                                                        $order_total = $row_orders['order_total'];
                                                        $status = $row_orders['status_name'];

                                                        if ($payment_method == 1) {
                                                            $payment_method = "Pago contraentrega";
                                                        } else {
                                                            $payment_method = "Paypal";
                                                        }
                                                        echo "        
                                                                    <tr>
                                                                        <td>
                                                                        <b>ID de Orden:</b> $orden_no <br>
                                                                        <b>Fecha registrada:</b> $order_date 
                                                                        </td>
                                                                        <td>
                                                                        <b>Forma de Pago:</b> $payment_method <br>
                                                                        <b>Estatus:</b> $status 
                                                                        </td>
                                                                    </tr>
                                                                ";

                                                        ?>
                                                    </tbody>
                                                </table>
                                                <!--Datos del envio -->
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="font-weight: 400">Dirección de envío y pago</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        //Direccion
                                                        $billing_name = $row_customer['billing_name'];
                                                        $billing_lastname = $row_customer['billing_lastname'];
                                                        $billing_address1 = $row_customer['billing_address1'];
                                                        $billing_address2 = $row_customer['billing_address2'];
                                                        $municipality = $row_customer['municipality'];
                                                        $departamento = $row_customer['departamento'];

                                                        if ($billing_address2 == " ") {
                                                            $address2 = "$billing_address2 <br>";
                                                        } else {
                                                            $address2 = "";
                                                        }
                                                        echo "        
                                                                    <tr>
                                                                        <td> 
                                                                        $billing_name $billing_lastname <br>
                                                                        $billing_address1 <br>
                                                                        $address2
                                                                        $municipality <br>
                                                                        $departamento <br>
                                                                        Guatemala<br>
                                                                        </td>
                                                                    </tr>
                                                                ";

                                                        ?>
                                                    </tbody>
                                                </table>
                                                <!--Datos de los productos -->
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre del Producto</th>
                                                            <th>Marca</th>
                                                            <th>Talla</th>
                                                            <th>Color</th>
                                                            <th>Cantidad</th>
                                                            <th>Precio</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        //No. de detalles de la orden
                                                        $get_no_details = "SELECT detail_order_id FROM details_order WHERE fk_order='$order_id'";

                                                        $run_no_details = mysqli_query($con, $get_no_details);
                                                        $count_no_details = mysqli_num_rows($run_no_details);

                                                        while ($row_no_details = mysqli_fetch_array($run_no_details)) {

                                                            $order_deta_id = $row_no_details['detail_order_id'];

                                                            $get_details = "SELECT * FROM orders AS o
                                                                        INNER JOIN details_order AS d
                                                                        ON d.fk_order = o.order_id
                                                                        INNER JOIN cart AS c
                                                                        ON c.cart_id = d.fk_cart
                                                                        INNER JOIN products AS p
                                                                        ON p.product_id = c.fk_product
                                                                        INNER JOIN manufacturers AS m
                                                                        ON m.manufacturer_id = p.fk_manufacturer
                                                                        INNER JOIN product_variations AS pv
                                                                        ON pv.fk_product = p.product_id
                                                                        INNER JOIN size AS s 
                                                                        ON s.size_id = pv.fk_size 
                                                                        WHERE d.detail_order_id='$order_deta_id' LIMIT 1";

                                                            $run_get_details = mysqli_query($con, $get_details);
                                                            while ($row_details = mysqli_fetch_array($run_get_details)) {
                                                                //Detalles del 
                                                                $pro_name = $row_details['product_name'];
                                                                $manu = $row_details['manufacturer_name'];
                                                                $size = $row_details['size'];
                                                                $pro_color = $row_details['product_color'];
                                                                $cart_amount = $row_details['cart_amount'];
                                                                $price = $row_details['price'];
                                                                $order_total = $row_details['order_total'];
                                                                $subtotal = $price * $cart_amount;
                                                                echo "        
                                                                    <tr>
                                                                        <td>$pro_name</td>
                                                                        <td>$manu</td>
                                                                        <td>$size</td>
                                                                        <td>$pro_color</td>
                                                                        <td>$cart_amount</td>
                                                                        <td>Q$price</td>
                                                                        <td>Q$subtotal</td>    
                                                                    </tr>
                                                                    
                                                                ";
                                                            }
                                                        }
                                                        echo "
                                                                <tr>
                                                                <td class='text-right' colspan='6'><b>Sub-Total</b></td>
                                                                <td >Q$subtotal</td>
                                                                </tr>
                                                                <tr>
                                                                <td class='text-right' colspan='6'><b>Transporte</b></td>
                                                                <td >Q0.00</td>
                                                                </tr>
                                                                <tr>
                                                                <td class='text-right' colspan='6'><b>SubTotal</b></td>
                                                                <td >$order_total</td>
                                                                </tr>
                                                            ";

                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php }  ?>
                                <!-- /Pedidos -->

                                <!-- Direcciones -->
                                <?php include('account/address.php') ?>
                                <!-- /Direcciones -->

                                <!-- Lista de deseos -->
                                <?php include('account/wishlist.php') ?>
                                <!-- /Lista de deseos -->

                                <!-- Detalles de la cuenta -->
                                <?php include('account/account.php') ?>
                                <!-- /Detalles de la cuenta -->

                                <!-- Cambio de contraseña -->
                                <?php include('account/pass.php') ?>
                                <!-- /Cambio de contraseña -->
                            </div>
                        </div>
                        <!-- Columna 2 - contenido -->
                    </div>
                </div>
                <!-- /Mi cuenta -->
            </div>
        </div>
    </div>
    <!-- /Container -->
</div>
<!-- /Contenido-->
<script>
    function submitpass() {
        var validator = $("#changePass").validate();
        validator.form();
    }
    //Formulario de la direccion
    function changepass() {
        submitpass();
        old_pass = $("#old_pass").val();
        new_pass = $("#new_pass").val();
        new_pass_again = $("#new_pass_again").val();
        if (old_pass == '' || new_pass == '' || new_pass_again == '') {
            alertify.set('notifier', 'position', 'top-right');
            alertify.error('Ingrese los datos obligatorios');

        } else if (new_pass != new_pass_again) {
            alertify.set('notifier', 'position', 'top-right');
            alertify.error('No coiciden la nueva contraseña');
        } else {
            $.ajax({
                url: "ajax/user.php?op=changepass",
                method: "POST",
                data: {
                    old_pass: old_pass,
                    new_pass: new_pass,
                    new_pass_again: new_pass_again
                },

                success: function(data) {
                    if (data == 1) {
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success('Contraseña actualizada');
                        $("#old_pass").val('');
                        $("#new_pass").val('');
                        $("#new_pass_again").val('');

                    } else if (data == 2) {
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.error('La contraseña actual no coincide');
                    }
                }

            });
        }
    }

    //Formulario de la direccion
    function address() {
        name = $("#name").val();
        lastname = $("#lastname").val();
        email = $("#email").val();
        contact = $("#contact").val();
        address1 = $("#address1").val();
        depart = $("#depart").val();
        munic = $("#munic").val();
        if (name == '' || lastname == '' || email == '' || contact == '' || address1 == '' || depart == '' || munic == '') {
            alertify.set('notifier', 'position', 'top-right');
            alertify.error('Ingrese los datos obligatorios');
        } else {
            $.ajax({
                url: "ajax/user.php?op=address",
                method: "POST",
                data: $('#address_update').serialize(),

                success: function(data) {
                    if (data == 1) {
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success('Datos actualizados');
                    } else {
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.error('Error al actualizar los datos');
                    }
                }

            });
        }
    }

    function getval(sel) {
        $.get("municipio.php", "depart=" + $("#depart").val(), function(data) {
            $("#munic").html(data);
        });
    }

    //Formulario para cambiar contraseña
</script>
<?php include('includes/footer.php') ?>