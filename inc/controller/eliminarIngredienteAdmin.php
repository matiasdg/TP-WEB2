<?php
require (dirname(__DIR__)."/class/pizza_class.php");

$id = $_REQUEST['id'];

$pizza = new Pizza();
$pizza->eliminarIngredienteAdmin($id);
?>