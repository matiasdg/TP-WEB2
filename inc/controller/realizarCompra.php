<?php 
require (dirname(__DIR__)."/class/carrito_class.php");

$json = $_REQUEST['datos'];
$datos = json_decode($json, true);

$carrito = new Carrito();
$id_pedido = $carrito->realizarCompra($datos);

//Genero PDF
$usuario = $_SESSION['usuario'];
$pdf = new PDF();
$nombrePDF = $pdf->generarPDF($id_pedido, $usuario);

//Envío el PDF por mail.

$sistema = new Sistema();
$mailTo = $sistema->obtenerMailUsuario();

$my_file = $nombrePDF;
$my_path = $_SERVER['DOCUMENT_ROOT']."/comprobantes/";
$my_name = "Variepizzas";
$my_mail = "comprobante@variepizzas.com.ar";
$my_replyto = "comprobante@variepizzas.com.ar";
$my_subject = "Le adjuntamos el comprobante de su compra";
$my_message = "Pagueme dinero.";

$sistema->enviarMail($my_file, $my_path, $mailTo, $my_mail, $my_name, $my_replyto, $my_subject, $my_message);
 ?>