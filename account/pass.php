<div class="tab-pane fade" id="account-pass" role="tabpanel">
    <div class="myaccount-content">
        <h3>Cambio de contraseña</h3>

        <div class="account-details-form">
            <form action="#" id="changePass" onsubmit="event.preventDefault();">
                <div class="single-input-item">
                    <label for="old_pass" class="required">Contraseña actual</label>
                    <input type="password" id="old_pass" required>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="single-input-item mt-2">
                            <label for="new_pass" class="required">Nueva contraseña</label>
                            <input type="password" id="new_pass" required>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="single-input-item mt-2">
                            <label for="new_pass_again" class="required">Confirmar contraseña</label>
                            <input type="password" id="new_pass_again" required>
                        </div>
                    </div>
                </div>
                <div class="single-input-item text-center mt-4">
                    <input type="submit" onclick="changepass();" class="btn mb-3" value="Guardar cambios">
                </div>
            </form>
        </div>
    </div>
</div>