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
        <h1 class="page-width">Login</h1>
      </div>
    </div>
  </div>
  <!-- /Titulo pagina -->
  <!-- Container -->
  <div class="container mt-4">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-6 col-lg-6 main-col offset-md-3">
        <div class="mb-4">
          <!-- Formulario -->
          <form method="post" action="#" id="login" onsubmit="event.preventDefault();" accept-charset="UTF-8" class="contact-form">
            <div class="row">
              <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                  <label for="CustomerEmail">Email</label>
                  <input type="email" name="email" id="email" autocomplete="off" autocapitalize="off" autofocus="" required>
                </div>
              </div>
              <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                  <label for="CustomerPassword">Contraseña</label>
                  <input type="password" value="" name="pass" id="pass" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12">
                <input type="submit" class="btn mb-3" value="Registrarse">
                <p class="mb-4">
                  <a href="register.php" id="RecoverPassword">¿No tienes una cuenta?</a> 
                  <a href="register.php" id="customer_register_link">Crear una cuenta</a>
                </p>
              </div>
            </div>
          </form>
          <!-- /Formulario -->
        </div>
      </div>
    </div>
  </div>
  <!-- /Container -->
</div>
<!-- /Contenido -->
<?php include('includes/footer.php') ?>
<script>
  //Funcion de registro despues de validar
  $("#login").validate({
    submitHandler: function(form) {
      $.ajax({
        url: 'ajax/user.php?op=login',
        type: 'POST',
        async: true,
        datatype: 'json',
        data: $('#login').serialize(),

        success: function(response) {
          if (response == 1) {
            alertify.set('notifier', 'position', 'top-right');
            alertify.error('El usuario es inválido');
          }
          if (response == 2) {
            alertify.set('notifier', 'position', 'top-right');
            alertify.success('Logueo exitoso');
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