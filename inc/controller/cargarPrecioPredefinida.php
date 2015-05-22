<?php 
require (dirname(__DIR__)."/class/pizza_class.php");

$codigo = $_REQUEST['codigo'];
$tamanio = $_REQUEST['tamanio'];

$pizza = new Pizza();
$pizza->actualizarPrecioPredefinida($codigo, $tamanio);

 ?>