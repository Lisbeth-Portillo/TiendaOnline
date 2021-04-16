<?php

//Obtencion de los productos por categoria - index
include('products.php');

//Slider - index
include('slider.php');

//Categorias - index
include('category.php');

//Paginacion - tienda
include('paginator.php');

//Fabricantes/marcas  - tienda
include('manufacturer.php');

//Reseñas de un producto  - detalle producto
include('review.php');

//Reseñas de un producto  - detalle producto
include('wishlist.php');

function getTotal()
{
    global $con;
    //Obtencion de ip del usuario
    $ip_add = getRealUserIp();

    //Detalle del la orden
    $select_cart = "SELECT * FROM cart AS c
                    INNER JOIN products AS p
                    ON c.fk_product = p.product_id 
                    WHERE ip_add='$ip_add' AND c.cart_status = 0";

    $run_cart = mysqli_query($con, $select_cart);

    $total = 0;

    while ($row_cart = mysqli_fetch_array($run_cart)) {
        //Datos del carrito
        $cart_amount = $row_cart['cart_amount'];

        //Datos del producto
        $pro_price = $row_cart['product_price'];
        $pro_price_new = $row_cart['product_price_new'];

        //Precio del producto
        if ($pro_price_new == 0) {
            $pro_price = $pro_price;
        } else {
            $pro_price = $pro_price_new;
        }

        $cart_subtotal =  $cart_amount * $pro_price;
        //Total
        $total += $cart_subtotal;
    }
    $Q_total = ROUND($total / 7.72, 2);
    echo $Q_total;
}

function getCheckout()
{
    global $con;
    $person_id = $_SESSION['id'];

    $select_customer = "SELECT * FROM person AS p
                        INNER JOIN customers AS c
                        ON p.person_id = c.fk_person 
                        WHERE p.person_id ='$person_id'";

    $run_customer = mysqli_query($con, $select_customer);
    $row_customer = mysqli_fetch_array($run_customer);

    //Datos del customer
    $customer_id = $row_customer['customer_id'];
    $customer_contact = $row_customer['person_contact'];
    $customer_email = $row_customer['person_email'];
    $customer_name = $row_customer['billing_name'];
    $customer_lastname = $row_customer['billing_lastname'];
    $customer_address1 = $row_customer['billing_address1'];
    $customer_address2 = $row_customer['billing_address2'];
    $fk_department = $row_customer['fk_department'];
    $fk_municipality = $row_customer['fk_municipality'];

    //Departamentos
    $depart = mysqli_query($con, 'SELECT * FROM departments');
    $departa = "";
    while ($data = mysqli_fetch_array($depart)) {
        $id_depart = $data['department_id'];
        $name_depart = $data['departamento'];
        $departa .= "<option value='$id_depart'>$name_depart</option>";
    }

    if ($fk_department != '' && $fk_municipality != '') {
        $depart_muni = "SELECT * FROM municipality AS m
                        INNER JOIN departments AS d 
                        ON d.department_id = m.fk_department
                        WHERE d.department_id = '$fk_department' AND m.municipality_id = '$fk_municipality'";

        $run_demu = mysqli_query($con, $depart_muni);
        $row_demu = mysqli_fetch_array($run_demu);

        //Datos del customer
        $muni = $row_demu['municipality'];
        $depa = $row_demu['departamento'];
        $municipality = "<option value='$fk_municipality'>$muni</option>";
        $departamento = "<option value='$fk_department'>$depa</option>";
    } else {
        $municipality = "<option value=''> --- Seleccion tu municipio --- </option>";
        $departamento = "<option value=''> --- Seleccion tu departamento --- </option>";
    }
    echo "
                <div class='row'>
                    <div class='form-group col-md-6 col-lg-6 col-xl-6 required'>
                        <label for='input-firstname'>Nombre</label>
                        <input name='name' value='$customer_name' id='name' type='text' autocomplete='off' required>
                    </div>
                    <div class='form-group col-md-6 col-lg-6 col-xl-6 required'>
                        <label for='input-lastname'>Apellido</label>
                        <input name='lastname' value='$customer_lastname' id='lastname' type='text' autocomplete='off' required>
                    </div>
                </div>
                <div class='row'>
                    <div class='form-group col-md-6 col-lg-6 col-xl-6 required'>
                        <label for='input-email'>E-Mail</label>
                        <input name='email' value='$customer_email' id='email' type='email' autocomplete='off' readonly required>
                    </div>
                    <div class='form-group col-md-6 col-lg-6 col-xl-6 required'>
                        <label for='input-telephone'>Telefono </label>
                        <input name='contact' value='$customer_contact' id='contact' type='tel' minlength='8' maxlength='8' required>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <div class='row'>
                    <div class='form-group col-12'>
                        <label for='input-company'>Dirección 1</label>
                        <input name='address1' value='$customer_address1' id='address1' type='text' autocomplete='off' required>
                    </div>
                </div>
                <div class='row'>
                    <div class='form-group col-12 '>
                        <label for='input-address-1'>Dirección 2</label>
                        <input name='address2' value='$customer_address2' id='address2' autocomplete='off' type='text'>
                        <input name='order_id' value='' id='order_id' type='hidden'>
                    </div>
                </div>
                <div class='row'>
                    <div class='form-group col-md-6 col-lg-6 col-xl-6'>
                        <label for='input-address-2'>Departamento </label>
                        <select name='depart' id='depart' onchange='getval(this);' required>
                        $departamento
                            $departa
                        </select>
                    </div>
                    <div class='form-group col-md-6 col-lg-6 col-xl-6 required'>
                        <label for='input-city'>Municipio </label>
                        <select name='munic' id='munic' required>
                        $municipality
                        </select>
                    </div>
                </div>
            </fieldset>
         ";
}


function editaccount()
{
    global $con;
    $person_session = $_SESSION['email'];

    $get_customer = "SELECT * FROM person WHERE person_email ='$person_session'";

    $run_customer = mysqli_query($con, $get_customer);
    $row_customer = mysqli_fetch_array($run_customer);

    //Datos de la cuenta
    $person_name = $row_customer['person_name'];
    $person_email = $row_customer['person_email'];
    $person_contact = $row_customer['person_contact'];

    echo "
            <form action='#' onsubmit='event.preventDefault();' id='editaccount'>
                <div class='row'>
                    <div class='col-lg-6'>
                        <div class='single-input-item'>
                            <label for='first-name' class='required'>Nombre</label>
                            <input type='text' id='name' name='name' value='$person_name' autocomplete='off' required>
                        </div>
                    </div>

                    <div class='col-lg-6'>
                        <div class='single-input-item'>
                            <label for='last-name' class='required'> Número de contacto</label>
                            <input type='tel' id='contact' name='contact' minlength='8' maxlength='8' autocomplete='off' value='$person_contact'>
                        </div>
                    </div>
                </div>

                <div class='single-input-item mt-2'>
                    <label for='display-name' class='required'>Correo electrónico</label>
                    <input type='email' id='email' name='email' value='$person_email' autocomplete='off' required>
                </div>
                <div class='single-input-item text-center mt-4'>
                    <button class='btn-login btn-add-to-cart bg-dark text-white p-2'>Guardar cambios</button>
                </div>
            </form>

         ";
}
