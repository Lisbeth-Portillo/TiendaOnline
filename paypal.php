<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Add meta tags for mobile and IE -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> PayPal Smart Payment Buttons Integration | Responsive Buttons </title>

    <style>
        /* Media query for mobile viewport */
        @media screen and (max-width: 400px) {
            #paypal-button-container {
                width: 100%;
            }
        }

        /* Media query for desktop viewport */
        @media screen and (min-width: 400px) {
            #paypal-button-container {
                width: 250px;
            }
        }
    </style>
</head>

<body>
    <!-- Configurar un elemento contenedor para el botón -->
    <div id="paypal-button-container"></div>

    <!-- Incluya el SDK de JavaScript de PayPal -->
    <script src="https://www.paypal.com/sdk/js?client-id=test&currency=USD"></script>

    <script>
        // Renderice el botón de PayPal en # paypal-button-container
        paypal.Buttons().render('#paypal-button-container');
        // Renderice el botón de PayPal en # paypal-button-container
        paypal.Buttons().render('#paypal-button-container');

        //Modo prueba paypal Sanbox
        paypal.Button.render({
            env: 'sandbox', // Modo prueba
            client: {
                sandbox: 'AdZwI0l5812nBigrvF9aEkplPd0ZA70LC7yvu6aIU85sKuR969mHyhUN2WYYloxwtjfKeJm7FIy5ZRGm',
                production: 'xxxxxxxxx'
            },
            //Metodo de pago
            payment: function(data, actions) {
                return actions.payment.create({
                    payment: {
                        transactions: [{
                            amount: {
                                total: '150',
                                currency: 'USD'
                            }
                        }]
                    }
                });
            },
            //Mensaje de confirmacion de pago
            onAuthorize: function(data, actions) {
                //Obtenga los detalles de pago
                return actions.payment.get()
                    .then(function(paymentDetails) {
                        // Muestra una confirmación usando los detalles de paymentDetails
                        // Luego escuche un clic en su botón de confirmación
                        document.querySelector('#confirm-button')
                            .addEventListener('click', function() {
                                // Execute the payment
                                return actions.payment.execute()
                                    .then(function() {
                                        window.alert('COMPRA EXITOSA');
                                        // Mostrar una página de éxito al comprador
                                    });
                            });
                    });
            }
        }, '#paypal-button');
    </script>
</body>
<!-- 

                            <div class="payment-accordion">
                                <div id="accordion" class="payment-section">
                                    <div class="card mb-2">
                                        <div class="card-header">
                                            <a class="card-link" data-toggle="collapse" href="#collapseOne">Transferencia bancaria directa</a>
                                        </div>
                                        <div id="collapseOne" class="collapse" data-parent="#accordion">
                                            <div class="card-body">
                                                <p class="no-margin font-15">Realice su pago directamente en nuestra cuenta bancaria. Utilice su ID de pedido como referencia de pago. Su pedido no se enviará hasta que los fondos se hayan liquidado en nuestra cuenta.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card margin-15px-bottom border-radius-none">
                                        <div class="card-header">
                                            <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree"> PayPal </a>
                                        </div>
                                        <div id="collapseThree" class="collapse" data-parent="#accordion">
                                            <div class="card-body">
                                                <p class="no-margin font-15">Pague a través de PayPal; puede pagar con su tarjeta de crédito si no tiene una cuenta PayPal.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-2">
                                        <div class="card-header">
                                            <a class="collapsed card-link" data-toggle="collapse" href="#collapseFour"> Información del pago </a>
                                        </div>
                                        <div id="collapseFour" class="collapse" data-parent="#accordion">
                                            <div class="card-body">
                                                <fieldset>
                                                    <div class="row">
                                                        <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                                            <label for="input-cardname">Name on Card <span class="required-f">*</span></label>
                                                            <input name="cardname" value="" placeholder="Card Name" id="input-cardname" class="form-control" type="text">
                                                        </div>
                                                        <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                                            <label for="input-country">Credit Card Type <span class="required-f">*</span></label>
                                                            <select name="country_id" class="form-control">
                                                                <option value=""> --- Please Select --- </option>
                                                                <option value="1">American Express</option>
                                                                <option value="2">Visa Card</option>
                                                                <option value="3">Master Card</option>
                                                                <option value="4">Discover Card</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                                            <label for="input-cardno">Credit Card Number <span class="required-f">*</span></label>
                                                            <input name="cardno" value="" placeholder="Credit Card Number" id="input-cardno" class="form-control" type="text">
                                                        </div>
                                                        <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                                            <label for="input-cvv">CVV Code <span class="required-f">*</span></label>
                                                            <input name="cvv" value="" placeholder="Card Verification Number" id="input-cvv" class="form-control" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                                            <label>Expiration Date <span class="required-f">*</span></label>
                                                            <input type="date" name="exdate" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                                            <img class="padding-25px-top xs-padding-5px-top" src="images/payment-img.jpg" alt="card" title="card" />
                                                        </div>
                                                    </div>
                                                </fieldset>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

 -->
{create_time: "2021-04-03T19:39:25Z", 
    update_time: "2021-04-03T19:39:56Z", 
    id: "6S985414C9920921E", intent: "CAPTURE", //ORDEN
    status: "COMPLETED", …}
create_time: "2021-04-03T19:39:25Z"
id: "6S985414C9920921E"
intent: "CAPTURE"
links: [{…}]
payer: {email_address: "sb-rzj125494865@personal.example.com", 
    payer_id: "YPEJ9YMD5NB5L", address: {…}, name: {…}}
purchase_units: [{…}]
status: "COMPLETED"
update_time: "2021-04-03T19:39:56Z"
__proto__: Object

details.status
</html>