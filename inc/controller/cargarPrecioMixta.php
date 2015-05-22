<?php 
require (dirname(__DIR__)."/class/pizza_class.php");

$json = $_REQUEST['sabores'];
$sabores = json_decode($json, true);
$tamanio = $_REQUEST['tamanio'];

$pizza = new Pizza();
$pizza->getPrecio($sabores, $tamanio);


 ?>