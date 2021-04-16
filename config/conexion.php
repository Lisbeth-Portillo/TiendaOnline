<?php
//Obtencio de la configuracion de la base de datos
require_once "global.php";
//Varible de conexion
$con = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

mysqli_query($con, 'SET NAMES "' . DB_ENCODE . '"');

//Muestra posible error en la conexion
if (mysqli_connect_errno()) {
	printf("Falló en la conexion con la base de datos: %s\n", mysqli_connect_error());
	exit();
}

//Verificacion del ingreso del customer a través del email
/*
if (isset($_SESSION["customer_email"])) {

	$customer_email = $_SESSION['customer_email'];
	$select_customer = "select * from customers where customer_email='$customer_email'";
	$run_customer = mysqli_query($con, $select_customer);
	$row_customer = mysqli_fetch_array($run_customer);
	$vendor_id = $row_customer['customer_id'];
	$customer_role = $row_customer['customer_role'];

	if ($customer_role == "vendor") {

		$select_vendor_commission = "select * from vendor_commissions where vendor_id='$vendor_id' and commission_status='pending'";
		$run_vendor_commission = mysqli_query($con, $select_vendor_commission);

		while ($row_vendor_commission = mysqli_fetch_array($run_vendor_commission)) {

			$commission_id = $row_vendor_commission['commission_id'];
			$order_id = $row_vendor_commission['order_id'];
			$commission_paid_date = new DateTime($row_vendor_commission['commission_paid_date']);
			date_default_timezone_set("UTC");
			$current_date = new DateTime("now");
			$select_vendor_order = "select * from vendor_orders where id='$order_id' and vendor_id='$vendor_id'";
			$run_vendor_order = mysqli_query($con, $select_vendor_order);
			$row_vendor_order = mysqli_fetch_array($run_vendor_order);
			$shipping_cost = $row_vendor_order['shipping_cost'];
			$net_amount = $row_vendor_order['net_amount'];
			$vendor_commission = $net_amount + $shipping_cost;

			if ($current_date >= $commission_paid_date) {
				$update_vendor_account = "update vendor_accounts set pending_clearance=pending_clearance-$vendor_commission,current_balance=current_balance+$vendor_commission where vendor_id='$vendor_id'";
				$run_vendor_account = mysqli_query($con, $update_vendor_account);
				$update_vendor_commission = "update vendor_commissions set commission_status='cleared' where commission_id='$commission_id' and vendor_id='$vendor_id'";
				$update_run_vendor_commission = mysqli_query($con, $update_vendor_commission);
			}

		}
	}
}
*/

//Obtencion de la ruta
$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$first_part = $components[1];

// IP address
function getRealUserIp()
{
  switch (true) {
    case (!empty($_SERVER['HTTP_X_REAL_IP'])):
      return $_SERVER['HTTP_X_REAL_IP'];
    case (!empty($_SERVER['HTTP_CLIENT_IP'])):
      return $_SERVER['HTTP_CLIENT_IP'];
    case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])):
      return $_SERVER['HTTP_X_FORWARDED_FOR'];
    default:
      return $_SERVER['REMOTE_ADDR'];
  }
}

//Ejecución de una consulta
if (!function_exists('ejecutarConsulta')) {
	function ejecutarConsulta($sql)
	{
		global $con;
		$query = $con->query($sql);
		return $query;
	}
	//Consulta de una fila
	function ejecutarConsultaSimpleFila($sql)
	{
		global $con;
		$query = $con->query($sql);
		$row = $query->fetch_assoc();
		return $row;
	}
	//Consulta el id del registro insertado
	function ejecutarConsulta_retornarID($sql)
	{
		global $con;
		$query = $con->query($sql);
		return $con->insert_id;
	}

	//Escape de caracteres y conversion a entidades html 
	function limpiarCadena($str)
	{
		global $con;
		$str = mysqli_real_escape_string($con, trim($str));
		return htmlspecialchars($str);
	}
}
