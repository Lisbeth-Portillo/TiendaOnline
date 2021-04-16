<?php
include('includes/header.php');
?>
<!-- Contenido -->
<div id="page-content">
    <!-- Titulo pagina -->
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper">
                <h1 class="page-width">Contáctanos</h1>
            </div>
        </div>
    </div>
    <!-- /Titulo pagina -->
    <!-- Mapa -->
    <div class="map-section map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.4246662213372!2d-89.34429634936721!3d14.574861189768892!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f63b5565aee4e53%3A0xd941288cf1dbc0a!2sHxE!5e0!3m2!1ses-419!2sgt!4v1614659487657!5m2!1ses-419!2sgt" height="350" allowfullscreen></iframe>
    </div>
    <!-- /Mapa -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-8 col-lg-6 mb-4 text-center">
                <h2>Comuníquese con nosotros</h2>
                <p>
                    Si tiene alguna pregunta, no dude en contactarnos, nuestro centro de servicio al cliente está trabajando para usted. <br>

                </p>
            </div>
            <div class="col-12 col-sm-12 col-md-4 col-lg-6">
                <div class="open-hours">
                    <strong>Horario de apertura</strong><br>
                    Lunes - Sábado : 8am - 6pm<br>
                    Domingo: 8am - 3pm
                </div>
                <hr />
                <ul class="addressFooter">
                    <li><i class="icon anm anm-map-marker-al"></i>
                        <p><?php echo "$site_direction $site_direction2" ?></p>
                    </li>
                    <li class="phone"><i class="icon anm anm-phone-s"></i>
                        <p>+(502) <?php echo $site_number ?></p>
                    </li>
                    <li class="email"><i class="icon anm anm-envelope-l"></i>
                        <p><?php echo $site_gmail ?></p>
                    </li>
                </ul>
                <hr />
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<!-- /Contenido -->
<?php include('includes/footer.php') ?>