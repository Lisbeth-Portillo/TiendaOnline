
<?php
/*
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
}*/