<?php
include "config/conexion.php";
$query0=$con->query("SELECT * FROM municipality WHERE fk_department=$_GET[depart]");
$municipio = array();
while($r=$query0->fetch_object()){ $municipio[]=$r; }
if(count($municipio)>0){
print "<option value=''>--- Seleccion tu municipio --- </option>";
foreach ($municipio as $m) {
	print "<option value='$m->municipality_id'>$m->municipality</option>";
}
}else{
print "<option value=''>-- No hay datos --</option>";
}
