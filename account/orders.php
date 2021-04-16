<div class="tab-pane fade show active" id="orders" role="tabpanel">
    <div class="myaccount-content">
        <h3>Mis pedidos</h3>

        <div class="myaccount-table table-responsive text-center">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>No. de Orden</th>
                        <th>Fecha registrada</th>
                        <th>Estado</th>
                        <th>Total</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $email = $_SESSION['email'];

                    $get_customer = "SELECT customer_id FROM customers AS c 
                                    INNER JOIN person AS p
                                    ON p.person_id = c.fk_person
                                    WHERE p.person_email ='$email'";

                    $run_get_customer = mysqli_query($con, $get_customer);
                    $row_customer = mysqli_fetch_array($run_get_customer);
                    $customer_id = $row_customer['customer_id'];

                    $get_orders = "SELECT * FROM orders o
                                   INNER JOIN orders_status AS os
                                   ON o.fk_order_status = os.orders_status_id
                                   WHERE fk_customer='$customer_id' ORDER BY 1 DESC";

                    $run_orders = mysqli_query($con, $get_orders);
                    $count_orders = mysqli_num_rows($run_orders);

                    if ($count_orders > 0) {
                        $i = 0;

                        while ($row_orders = mysqli_fetch_array($run_orders)) {

                            $order_id = $row_orders['order_id'];
                            $orden_no = $row_orders['orden_no'];
                            $payment_method = $row_orders['payment_method'];
                            $order_date = $row_orders['order_date'];
                            $order_total = $row_orders['order_total'];
                            $status = $row_orders['status_name'];

                            echo "        
                        <tr>
                            <td>#$orden_no</td>
                            <td>$order_date</td>
                            <td>$status</td>
                            <td>Q$order_total</td>
                            <td>
                            <a href='account.php?order_id=$order_id' class='btn bg-light text-dark border-dark' type='button'>Ver</a>
                            </td>
                        </tr>
                     ";
                        }
                    }else{
                        echo "<tr><td colspan='5'>No tiene pedidos registrados</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>