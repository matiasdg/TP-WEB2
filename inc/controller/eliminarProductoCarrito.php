<?php 
require (dirname(__DIR__)."/class/carrito_class.php");

$json = $_REQUEST['items'];
$items = json_decode($json, true);

$carrito = new Carrito();
$carrito->eliminar($items);

 ?>