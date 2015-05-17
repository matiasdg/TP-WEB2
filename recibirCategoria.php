
<?php
require_once ("pizza_class.php");

//Traigo la variable por javascript.
$categoria = $_REQUEST['categoria'];
$pizza = new Pizza();
$pizza->extraerPorCategoria($categoria);

?>