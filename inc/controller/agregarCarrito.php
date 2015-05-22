<?php 
require (dirname(__DIR__)."/class/carrito_class.php");

$json = $_REQUEST['datos'];
$datos = json_decode($json, true);

$carrito = new Carrito();
$carrito->add($datos);
$carrito->informar();
 ?>