<?php include('includes/header.php');

//Redireccion si el usuario esta logueado 
if (isset($_SESSION['email'])) {
    echo "<script>window.open('index.php','_self')</script>";
}

?>
<!-- Contenido -->
<div id="page-content">
    <!-- Titulo pagina -->
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper">
                <h1 class="page-width">Crea una cuenta</h1>
            </div>
        </div>
    </div>
    <!-- /Titulo pagina -->
    <!-- Container -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 main-col offset-md-3">
                <div class="mb-4">
                    <form method="post" id="register" onsubmit="event.preventDefault();" accept-charset="UTF-8" class="contact-form">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="FirstName">Nombre</label>
                                    <input type="text" name="name" id="name" autofocus="" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="CustomerEmail">Email</label>
                                    <input type="email" name="email" id="email" autofocus="" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="CustomerPass">Contraseña</label>
                                    <div class="mb-1 mt-2" id="space_pass">
                                        <input type="password" value="" name="passr" id="passr" class="form-control" style="border-radius:0" autocomplete="off" required>
                                        <div class="input-group-append">
                                            <button type="text" class="btn newsletter__submit btn-pass" name="commit">
                                                <span class="newsletter__submit-text--large">
                                                    <i class="fa fa-check tick1"> </i>
                                                    <i class="fa fa-times cross1"> </i>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Nivel contraseña -->
                                    <span class="input-group-addon">
                                        <div id="meter_wrapper">
                                            <div id="meter"> </div>
                                        </div>
                                    </span>
                                    <!-- /Nivel contraseña -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <label for="CustomerPassword">Confirmar contraseña</label>
                                <div class="mb-5 mt-2" id="space_pass2">
                                    <input type="password" class="form-control confirm" id="confirmpass"  name="confirmpass" style="border-radius:0" autocomplete="off" required>
                                    <div class="input-group-append">
                                        <button type="text" class="btn newsletter__submit btn-pass" name="commit">
                                            <span class="newsletter__submit-text--large">
                                                <i class="fa fa-check tick1"> </i>
                                                <i class="fa fa-times cross1"> </i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12">
                                <input type="submit" class="btn mb-3" value="Registrarse">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Container -->
</div>
<!-- /Contenido -->
<?php include('includes/footer.php') ?>
<script>
    $(document).ready(function() {
        //Confirmacion de contraseñas
        $('.tick1').hide();
        $('.cross1').hide();

        $('.btn-pass').hide();

        $('.tick2').hide();
        $('.cross2').hide();
        $(".confirm").keyup(function() {
            var password = $('#passr').val();
            var confirmPassword = $('#confirmpass').val();

            if (password == confirmPassword) {

                $("#space_pass").addClass("input-group");
                $("#space_pass2").addClass("input-group");
                $('.btn-pass').show();

                $('.tick1').show();
                $('.cross1').hide();

                $('.tick2').show();
                $('.cross2').hide();

            } else {

                $("#space_pass").addClass("input-group");
                $("#space_pass2").addClass("input-group");
                $('.btn-pass').show();

                $('.tick1').hide();
                $('.cross1').show();

                $('.tick2').hide();
                $('.cross2').show();

            }

        });
    });

    //Comprobacion de contraseña del registro
    $(document).ready(function() {
        $("#passr").keyup(function() {
            check_pass();
        });
    });

    //Funcion de registro despues de validar
    $("#register").validate({
        submitHandler: function(form) {
            $.ajax({
                url: 'ajax/user.php?op=register',
                type: 'POST',
                async: true,
                datatype: 'json',
                data: $('#register').serialize(),

                success: function(response) {
                    if (response == 1) {
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.error('Correo electrónico ya registrado');
                    }
                    if (response == 3) {
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.error('Confirmación de contraseña fallida ');
                    }
                    if (response == 2) {
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success('Registro exitoso');
                        $(location).attr("href", "index.php");
                    }
                },
                error: function(error) {
                    console.log(error);

                }
            });
        }
    });
</script>