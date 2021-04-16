<div class="tab-pane fade" id="wishlist" role="tabpanel">
    <div class="myaccount-content">
        <h3>Mi lista de deseos</h3>

        <div class="myaccount-table table-responsive text-center">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Nº</th>
                        <th colspan="2">Producto</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="wishlist-products">
                    <?php
                        getWishlist();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>