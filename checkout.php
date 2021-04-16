<?php include('includes/header.php');

//Redireccion si el usuario no esta registrado o logueado
if (!isset($_SESSION['email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} ?>
<!-- Incluya el SDK de JavaScript de PayPal -->
<script src="https://www.paypal.com/sdk/js?client-id=AdZwI0l5812nBigrvF9aEkplPd0ZA70LC7yvu6aIU85sKuR969mHyhUN2WYYloxwtjfKeJm7FIy5ZRGm"></script>
<!-- Contenido -->
<div id="page-content">
    <!-- Titulo pagina-->
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper">
                <h1 class="page-width">Checkout</h1>
            </div>
        </div>
    </div>
    <!-- /Titulo pagina -->
    <?php
    $ip_add = getRealUserIp();
    $select_cart = "SELECT * FROM cart WHERE ip_add='$ip_add' AND cart_status = 0";
    $run_cart = mysqli_query($con, $select_cart);
    $count_cart = mysqli_num_rows($run_cart);

    if ($count_cart == 0) { ?>
        <div class="container mt-4 mb-4">
            <div class="col-12">
                <div class="your-order-payment">
                    <div class="your-order text-center">
                        <div class="customer-box returning-customer mb-4 ">
                            <h3> El pago no está disponible. Su carrito está vacío.</a></h3>
                        </div>
                        <a href="shop.php">
                            <button class="btn bg-light text-dark" type="button">
                                Seguir comprado
                            </button>
                        </a>
                    </div>
                    <hr />
                </div>
            </div>
        </div>

    <?php } else { ?>

        <!-- Container -->
        <div class="container mt-4">
            <div class="row billing-fields">
                <!-- Columna 1 -->
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 sm-margin-30px-bottom">
                    <div class="create-ac-content bg-light-gray padding-20px-all">
                        <!-- Formulario -->
                        <form method="post" action="#" id="checkout_details" accept-charset="UTF-8" class="contact-form" onsubmit="event.preventDefault();">
                            <fieldset>
                                <div class='customer-box returning-customer mb-4'>
                                    <h3> Detalles de <a href='#customer-login' id='customer' class='text-white text-decoration-underline' data-toggle='collapse'> facturacion y envio</a></h3>
                                </div>
                                <?php getCheckout(); ?>
                        </form>
                        <!-- /Formulario -->
                    </div>
                </div>
                <!-- /Columna 1 -->
                <!-- Columna 2 -->
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="your-order-payment">
                        <div class="your-order">
                            <div class="customer-box returning-customer mb-4">
                                <h3> Su <a href="#" id="customer" class="text-white text-decoration-underline" data-toggle="collapse"> pedido </a></h3>
                            </div>
                            <div class="table-responsive-sm order-table">
                                <table class="bg-white table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th class="text-left">Producto</th>
                                            <th>Precio</th>
                                            <th>Talla</th>
                                            <th>Color</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php getProCheckout(); ?>
                                </table>
                            </div>
                        </div>
                        <hr />
                        <div class="your-payment">
                            <h2 class="payment-title mb-3">payment method</h2>
                            <div class="payment-method">
                                <div class="payment-accordion">
                                    <div id="accordion" class="payment-section">
                                        <div class="card mb-2">
                                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                Pago contra entrega
                                            </button>
                                            <div id="collapseOne" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    <p class="no-margin font-15">Cuando reclames el paquete en la oficina o recibas el envío en la dirección final, pagas el producto cuando lo recibas.</p>
                                                    <a href="javascript:submitform(); pago1();">
                                                        <button class="btn border-dark" type="submit">Realizar pedido</button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mb-2">
                                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                PayPal
                                            </button>
                                            <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    <p class="no-margin font-15">Pague a través de PayPal; puede pagar con su tarjeta de crédito si no tiene una cuenta PayPal.</p>
                                                    <a href="javascript:submitform(); pago2();" id="paypal">
                                                        <button class="btn border-dark" type="submit">Metodos Paypal</button>
                                                    </a>
                                                </div>
                                                <!-- Configurar un elemento contenedor para el botón -->
                                                <div id="paypal-button-container" class="text-center paypal"></div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Columna 2 -->
</div>
</div>
<!-- Container -->
</div>
<!-- /Contenido -->
<?php } ?>
<script>
    function pago1() {
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
                url: "ajax/order.php?op=contrapago",
                method: "POST",
                data: $('#checkout_details').serialize(),

                success: function(data) {
                    if (data == 1) {
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success('Orden exitosa');
                        //Actualizar datos del carrito
                        itemsCard();
                        //Redireccion para ver pedido
                        $(location).attr("href", "account.php");

                    } else {
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.error('Orden fallida');
                    }
                }

            });
        }
    }

    function pago2() {
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

            //Metodo de paypal
            $('#paypal').hide();
            paypal.Buttons({
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: '1<?php //getTotal();?>'
                            }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        console.log(details);
                        $('#order_id').val(details.id);
                        $.ajax({
                            url: "ajax/order.php?op=paypal",
                            method: "POST",
                            data: $('#checkout_details').serialize(),

                            success: function(data) {
                                if (data == 1) {
                                    alertify.set('notifier', 'position', 'top-right');
                                    alertify.success('Orden no.' + details.id + " registrada");
                                    //Actualizar datos del carrito
                                    itemsCard();
                                    //Redireccion para ver pedido
                                    //$(location).attr("href", "account.php");

                                } else {
                                    alertify.set('notifier', 'position', 'top-right');
                                    alertify.error('Orden fallida');
                                }
                            }

                        });
                        //window.location.href = 'My account.php';
                    });
                }
            }).render('#paypal-button-container'); //Muestre las opciones de pago en su página web
        }
    }

    function submitform() {
        var validator = $("#checkout_details").validate();
        validator.form();
    }
</script>
<?php include('includes/footer.php') ?>
<!--
https://www.sandbox.paypal.com/checkoutnow?sessionID=a24cfd3358_mtg6ndq6ndq&buttonSessionID=1a2668392b_mtg6ndu6ndg&fundingSource=paypal&buyerCountry=GT&locale.x=es_US&commit=true&clientID=AdZwI0l5812nBigrvF9aEkplPd0ZA70LC7yvu6aIU85sKuR969mHyhUN2WYYloxwtjfKeJm7FIy5ZRGm&env=sandbox&sdkMeta=eyJ1cmwiOiJodHRwczovL3d3dy5wYXlwYWwuY29tL3Nkay9qcz9jbGllbnQtaWQ9QWRad0kwbDU4MTJuQmlncnZGOWFFa3BsUGQwWkE3MExDN3l2dTZhSVU4NXNLdVI5NjltSHloVU4yV1lZbG94d3RqZktlSm03Rkl5NVpSR20iLCJhdHRycyI6eyJkYXRhLXVpZCI6ImIyNWM4ZThjNjRfbXRnNm5kdTZuZGcifX0&xcomponent=1&version=5.0.218&token=8R5264609T816532Y
https://www.sandbox.paypal.com/checkoutnow?sessionID=a24cfd3358_mtg6ndq6ndq&buttonSessionID=1a2668392b_mtg6ndu6ndg&fundingSource=paypal&buyerCountry=GT&locale.x=es_US&commit=true&clientID=AdZwI0l5812nBigrvF9aEkplPd0ZA70LC7yvu6aIU85sKuR969mHyhUN2WYYloxwtjfKeJm7FIy5ZRGm&env=sandbox&sdkMeta=eyJ1cmwiOiJodHRwczovL3d3dy5wYXlwYWwuY29tL3Nkay9qcz9jbGllbnQtaWQ9QWRad0kwbDU4MTJuQmlncnZGOWFFa3BsUGQwWkE3MExDN3l2dTZhSVU4NXNLdVI5NjltSHloVU4yV1lZbG94d3RqZktlSm03Rkl5NVpSR20iLCJhdHRycyI6eyJkYXRhLXVpZCI6ImIyNWM4ZThjNjRfbXRnNm5kdTZuZGcifX0&xcomponent=1&version=5.0.218&token=7MC037269H022612U
    https://www.sandbox.paypal.com/checkoutnow?sessionID=a24cfd3358_mtg6ndq6ndq&buttonSessionID=1a2668392b_mtg6ndu6ndg&fundingSource=paypal&buyerCountry=GT&locale.x=es_US&commit=true&clientID=AdZwI0l5812nBigrvF9aEkplPd0ZA70LC7yvu6aIU85sKuR969mHyhUN2WYYloxwtjfKeJm7FIy5ZRGm&env=sandbox&sdkMeta=eyJ1cmwiOiJodHRwczovL3d3dy5wYXlwYWwuY29tL3Nkay9qcz9jbGllbnQtaWQ9QWRad0kwbDU4MTJuQmlncnZGOWFFa3BsUGQwWkE3MExDN3l2dTZhSVU4NXNLdVI5NjltSHloVU4yV1lZbG94d3RqZktlSm03Rkl5NVpSR20iLCJhdHRycyI6eyJkYXRhLXVpZCI6ImIyNWM4ZThjNjRfbXRnNm5kdTZuZGcifX0&xcomponent=1&version=5.0.218&token=7MC037269H022612U

    {create_time: "2021-04-07T18:46:58Z", 
        update_time: "2021-04-07T18:47:19Z", 
        id: "7MC037269H022612U", intent: "CAPTURE", 
        status: "COMPLETED", …}
    [
    {
        "href": "https://api.sandbox.paypal.com/v2/checkout/orders/7MC037269H022612U", //URL DE LA SOLICITUD
        "rel": "self",
        "method": "GET",
        "title": "GET"
    }
]-->