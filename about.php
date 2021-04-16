<?php include('includes/header.php') ?>
<!-- Contenido -->
<div id="page-content">
    <!-- Titulo pagina -->
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper">
                <h1 class="page-width">Nosotros</h1>
            </div>
        </div>
    </div>
    <!-- /Titulo pagina -->
    <!-- Container -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 main-col">
                <!-- Nombre y descripcion tienda -->
                <div class="text-center mb-4">
                    <!-- Nombre -->
                    <h2 class="h2"><?php echo $site_title?></h2>
                    <div class="rte-setting">
                        <!-- Subtitulo -->
                        <p><strong>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</strong></p>
                        <!-- Texto -->
                        <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form,
                            accompanied by English versions from the 1914 translation by H. Rackham.</p>
                    </div>
                </div>
                <!-- Nombre y descripcion tienda -->
            </div>
        </div>
        <!-- Img -->
        <div class="row">
            <div class="col-12 col-sm-4 col-md-4 col-lg-4 mb-4"><img class="blur-up lazyload" data-src="images/about1.jpg" src="images/about1.jpg" alt="About Us" /></div>
            <div class="col-12 col-sm-4 col-md-4 col-lg-4 mb-4"><img class="blur-up lazyload" data-src="images/about2.jpg" src="images/about2.jpg" alt="About Us" /></div>
            <div class="col-12 col-sm-4 col-md-4 col-lg-4 mb-4"><img class="blur-up lazyload" data-src="images/about3.jpg" src="images/about3.jpg" alt="About Us" /></div>
        </div>
        <!-- /Img -->
        <div class="row">
            <!-- Texto -->
            <div class="col-12">
                <h2>Sed ut perspiciatis unde omnis iste natus error</h2>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure
                    of the moment, so blinded by desire, that they cannot foresee the pain.</p>
                <p>simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain
                    circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted.</p>
                <p></p>
            </div>
            <!-- /Texto -->
        </div>

        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-4">
                <h2 class="h2">About Annimex Web</h2>
                <div class="rte-setting">
                    <p><strong>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</strong></p>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                    <p></p>
                    <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa
                        qui officia deserunt mollitia animi, id est laborum et dolorum fuga.</p>
                </div>
            </div>
            <!-- Contacto -->
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <h2 class="h2">Contáctanos</h2>
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
            <!-- /Contanto -->
        </div>


    </div>
    <!-- /Container -->
</div>
<!-- /Contenido -->
<?php include('includes/footer.php') ?>