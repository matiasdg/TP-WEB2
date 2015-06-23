<?php 
require (dirname(__DIR__)."/class/sistema_class.php");

$sesion = $_REQUEST['dato'];
$sistema = new Sistema();
$sistema->cerrarSesion($sesion);

?>