<?php 
require (dirname(__DIR__)."/class/carrito_class.php");

$json = $_REQUEST['datos'];
$datos = json_decode($json, true);

$carrito = new Carrito();

if( sizeof($datos['detalles']) <= 1)
{
	echo "Por favor eliga al menos un ingrediente.";
}else
{
	$carrito->add($datos);
	$carrito->informar();
}

 ?>