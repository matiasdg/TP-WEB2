<?php
require (dirname(__DIR__)."/class/pizza_class.php");



$id = $_REQUEST['id'];
echo $id;

$pizza = new Pizza();
$pizza->eliminarPizzaAdmin($id);
?>