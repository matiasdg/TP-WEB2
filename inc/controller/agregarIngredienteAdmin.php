<?php
require (dirname(__DIR__)."/class/pizza_class.php");

$json = $_REQUEST['datos'];
$datos = json_decode($json, true);


$pizza = new Pizza();
$pizza->agregarIngredienteAdmin($datos);
?>