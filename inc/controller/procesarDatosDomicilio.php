<?php
require (dirname(__DIR__)."/class/sistema_class.php");

$json = $_REQUEST['datos'];
$datos = json_decode($json, true);

$sistema = new Sistema();
$sistema->procesarDatosDomicilio($datos);
?>