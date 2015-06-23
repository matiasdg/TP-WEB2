<?php
require (dirname(__DIR__)."/class/pizza_class.php");




if( isset($_POST['ingredientes']) )
{
	$datos = array(
	    "nombre" => $_POST['nombre'],
	    "categoria" => $_POST['categoria'],
	    "precio" => $_POST['precio'],
	    "ingredientes" => $_POST['ingredientes'],
	    "id_pizza" => $_POST['id_pizza']
	);	
};

if( isset($_POST['sabores']) )
{
	$datos = array(
	    "nombre" => $_POST['nombre'],
	    "categoria" => $_POST['categoria'],
	    "precio" => $_POST['precio'],
	    "sabores" => $_POST['sabores'],
	    "id_pizza" => $_POST['id_pizza']
	);	
};


$pizza = new Pizza();
$pizza->modificarPizzaAdmin($datos);
?>