<?php 
require (dirname(__DIR__)."/class/carrito_class.php");
require (dirname(__DIR__)."/class/pdf_class.php");

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
//$mailTo = $sistema->obtenerMailUsuario();
$mailTo = "variepizzas@gmail.com";

$my_file = $nombrePDF;
$my_path = PATH."/inc/comprobantes/";
$my_name = "Variepizzas";
$my_mail = "variepizzas@gmail.com";
$my_replyto = "variepizzas@gmail.com";
$my_subject = "Comprobante de compra - Variepizzas";
$my_message = "
<html> 
<head> 
   <title>Comprobante de compra</title> 
</head> 
<body> 
<h1>Hola ".$usuario."!</h1> 
<p>
Adjunto se encuentra su comprobante, con sus datos y su número de pedido. Recuerde presentar el número de pedido cuando llegue su encargo.
</p>
<p><b>Gracias por su compra!</b></p>
<p><b>Variepizzas</b></p>
</body> 
</html> 
";

$sistema->enviarMail($my_file, $my_path, $mailTo, $my_mail, $my_name, $my_replyto, $my_subject, $my_message);
 ?>