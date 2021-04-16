  <!--Footer-->
  <footer id="footer">
      <div class="site-footer">
          <!-- Container -->
          <div class="container">
              <!--Footer Links-->
              <div class="footer-top">
                  <div class="row">
                      <div class="col-12 col-sm-12 col-md-3 col-lg-3 footer-links">
                          <h4 class="h4">Categorías</h4>
                          <ul>
                              <?php
                                $get_pro_cat = "SELECT * FROM product_categories";
                                $run_pro_cat = mysqli_query($con, $get_pro_cat);
                                while ($row_cat = mysqli_fetch_array($run_pro_cat)) {

                                    $p_cat_id = $row_cat['product_cat_id'];
                                    $p_cat_name = $row_cat['product_cat_name'];

                                    echo "
                                            <li><a href='shop.php?p_cat=$p_cat_id'>$p_cat_name</a></li>
                                         ";
                                }
                                ?>
                          </ul>
                      </div>
                      <div class="col-12 col-sm-12 col-md-3 col-lg-3 footer-links">
                          <h4 class="h4">Información</h4>
                          <ul>
                              <li><a href="#">Nosotros</a></li>
                              <li><a href="#">Contáctanos</a></li>
                              <li><a href="#">Politica de privacidad</a></li>
                              <li><a href="#">Términos y condiciones</a></li>
                          </ul>
                      </div>
                      <div class="col-12 col-sm-12 col-md-3 col-lg-3 footer-links">
                          <h4 class="h4">Mi cuenta</h4>
                          <ul>
                          <?php if(isset($_SESSION['email'])){
                                echo " <li><a href='account.php'>Mi perfil</a></li>";
                            }?>
                              <li><a href="#">Mi carro</a></li>
                              <li><a href="#">Checkout</a></li>
                          </ul>
                      </div>
                      <div class="col-12 col-sm-12 col-md-3 col-lg-3 contact-box">
                          <h4 class="h4">Contáctanos</h4>
                          <ul class="addressFooter">
                              <li><i class="icon anm anm-map-marker-al"></i>
                                  <p><?php echo "$site_direction <br>$site_direction2" ?></p>
                              </li>
                              <li class="phone"><i class="icon anm anm-phone-s"></i>
                                  <p>+(502) <?php echo $site_number ?></p>
                              </li>
                              <li class="email"><i class="icon anm anm-envelope-l"></i>
                                  <p><?php echo $site_gmail ?></p>
                              </li>
                          </ul>
                      </div>
                  </div>
              </div>
              <!-- /Footer Links-->
              <hr>
              <div class="footer-bottom">
                  <div class="row">
                      <!--Footer copyright-->
                      <div class="col-12 col-sm-12 col-md-6 col-lg-6 order-1 order-md-0 order-lg-0 order-sm-1 copyright text-sm-center text-md-left text-lg-left"><span></span> <a href="templateshub.net">Variedades Addison © 2021</a></div>
                      <!-- /Footer copyright-->
                      <!-- Footer metodos de pago-->
                      <div class="col-12 col-sm-12 col-md-6 col-lg-6 order-0 order-md-1 order-lg-1 order-sm-0 payment-icons text-right text-md-center">
                          <ul class="payment-icons list--inline">
                              <li><i class="icon fa fa-cc-paypal" aria-hidden="true"></i></li>
                          </ul>
                      </div>
                      <!-- /Footer metodos de pago-->
                  </div>
              </div>
          </div>
          <!-- /Container -->
      </div>
  </footer>
  <!--End Footer-->
  <!--Scoll Top-->
  <span id="site-scroll"><i class="icon anm anm-angle-up-r"></i></span>
  <!-- /Scoll Top-->
  <!-- Jquery -->
  
  <script src="../assets/js/star-rating.min.js"></script>
  <script src="../assets/js/vendor/jquery-3.3.1.min.js"></script>
  <script src="../assets/js/vendor/jquery.validate.min.js"></script>
  <script src="../assets/js/vendor/modernizr-3.6.0.min.js"></script>
  <script src="../assets/js/vendor/jquery.cookie.js"></script>
  <script src="../assets/js/vendor/wow.min.js"></script>
  <!-- Javascript -->
  <script src="../assets/js/bootstrap.min.js"></script>
  <script src="../assets/js/plugins.js"></script>
  <script src="../assets/js/popper.min.js"></script>
  <script src="../assets/js/lazysizes.js"></script>
  <script src="../assets/js/main.js"></script>
  <script src="../assets/js/scripts/function.js"></script>
  <script src="../assets/alertify/alertify.js"></script>
  </body>

  </html>