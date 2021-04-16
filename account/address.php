<div class="tab-pane fade" id="address" role="tabpanel">
    <div class="myaccount-content">
        <h3>Dirección de envío y pago</h3><!-- Formulario -->
        <form method="post" action="#" id="address_update" accept-charset="UTF-8" class="contact-form" onsubmit="event.preventDefault(); address();">
            <?php getCheckout(); ?>
            <div class='single-input-item text-center mt-4'>
                <input type="submit" class="btn" value="Guardar cambios">
            </div>
        </form>
        <!-- /Formulario -->
    </div>
</div>
