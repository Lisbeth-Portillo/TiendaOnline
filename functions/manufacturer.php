<?php
//Obtencion de marcas - tienda
function getManufac()
{
    global $con;
    //Obtencion de los marcas
    $get_product_man = "SELECT * FROM manufacturers";
    $run_product_man = mysqli_query($con, $get_product_man);
    while ($row_man = mysqli_fetch_array($run_product_man)) {

        $man_id = $row_man['manufacturer_id'];
        $man_name = $row_man['manufacturer_name'];

        echo "
                <li>
                    <input type='checkbox' value='$man_id 'id='checkm$man_id'>
                    <label for='checkm$man_id'><span><span></span></span>$man_name</label>
                </li>
             ";
    }
}
