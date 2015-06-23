<?php
require (dirname(__DIR__)."/libs/fpdf/fpdf.php");



class PDF extends Modelo {

    public function __construct(){
        parent::__construct();
    }

    public function generarPDF($id_pedido, $usuario){

    	

    	//Creo el PDF
    	$fecha_pedido = date("d/m/y");
       	$miPDF = new FPDF(); 
		$miPDF->AddPage(); 
		$miPDF->SetFont('Helvetica','B',12);
		$miPDF -> SetTextColor( 0 , 0 , 0);
		$miPDF -> SetFillColor( 255 , 255 , 255 );

		//Consulto los datos del usuario.
		$consulta = "SELECT * FROM USUARIO WHERE nombre_usuario = '$usuario'";
		$registrosUsuario = $this->db->query($consulta)
				 	or die("Error consultando los datos del usuario" . mysqli_error($this->db));

		while($objeto = $registrosUsuario->fetch_object())
		{
			$nombre = $objeto->nombre;
			$apellido = $objeto->apellido;
			$dni = $objeto->numero_dni;

		}

		$miPDF->Cell(0 , 10 , 'Variepizzas', 0 , 0 , 'L' , true);
		$miPDF -> Ln( 10);
		$miPDF->Cell(0 , 10 , 'Fecha: '.$fecha_pedido, 0 , 0 , 'L' , true);
		$miPDF -> Ln( 10);
		$miPDF->Cell(0 , 10 , iconv('UTF-8', 'windows-1252', 'Cliente: '.$nombre.' '.$apellido.'. DNI: '.$dni), 0 , 0 , 'L' , true);
		$miPDF -> Ln( 10);


		//Consulto los datos del pedido con ese id_pedido y los extraigo, para posteriormente volcarlos al pdf.
		$consulta = "SELECT * FROM PEDIDOS WHERE id_pedido = $id_pedido";
		$registrosPedido = $this->db->query($consulta)
				 	or die("Error consultando los datos del pedido" . mysqli_error($this->db));

		$objeto = $registrosPedido->fetch_object();

		$calle = $objeto->calle;
		$altura = $objeto->altura;
		$depto = $objeto->depto;
		$modo_pago = $objeto->modo_pago;


		$miPDF->Cell(0 , 10 , iconv('UTF-8', 'windows-1252', 'Dirección entrega: '.$calle.' '.$altura.'. Departamento: '.$depto), 0 , 0 , 'L' , true);
		$miPDF -> Ln( 10);

		$miPDF->Cell(0 , 10 , 'Modo pago: '.$modo_pago, 0 , 0 , 'L' , true);
		$miPDF -> Ln( 10);
		$miPDF->Cell(0 , 10 , 'Pedido: '.$id_pedido, 0 , 0 , 'L' , true);
		$miPDF -> Ln( 10);
		$miPDF->Cell(0 , 10 , 'Productos: ', 0 , 0 , 'L' , true);
		$miPDF -> Ln( 10);

		(float) $total = 0;

		$registrosPedido = $this->db->query($consulta)
				 	or die("Error consultando los datos del pedido" . mysqli_error($this->db));


		$miPDF -> Cell( 55, 10 , 'Nombre', 1, 0, 'C' , true );
		$miPDF -> Cell( 55, 10 , 'Detalles', 1, 0, 'C' , true );
		$miPDF -> Cell( 55, 10 , iconv('UTF-8', 'windows-1252', 'Tamaño'), 1, 0, 'C' , true );
		$miPDF -> Cell( 20, 10 , 'Precio', 1, 0, 'C' , true );
		$miPDF -> Ln( 10);
		
		$miPDF->SetFont('Helvetica');

		while ($objetos = $registrosPedido->fetch_object())
		{
			
			$miPDF -> Cell( 55, 10 , iconv('UTF-8', 'windows-1252', $objetos->producto), 0, 0, 'C' , true );
			$current_y = $miPDF->GetY();
			$current_x = $miPDF->GetX();
			$miPDF -> MultiCell( 55, 10 , iconv('UTF-8', 'windows-1252', $objetos->detalles), 0, 'C' , true );
			$altoProducto = $miPDF->GetY();

			$miPDF->SetXY($current_x + 55, $current_y);
			$current_x = $miPDF->GetX();

			$miPDF -> Cell( 55, 10 , $objetos->tamanio, 0, 0, 'C' , true );
			$miPDF -> Cell( 20, 10 , '$'.$objetos->precio, 0, 0, 'C' , true );

			$miPDF -> Ln( 10);
			$current_x = $miPDF->GetX();
			$miPDF->SetXY($current_x, $altoProducto);
			$miPDF -> Cell( 185, 1 , '', 'T', 0, 'C' , true );
			$miPDF -> Ln( 1);

			(float)$total = (float)$total + (float)$objetos->precio;
		}

		$current_x = $miPDF->GetX();
		$miPDF->SetXY($current_x, $altoProducto);

		$miPDF->SetFont('Helvetica','B',12);

		$miPDF -> Ln( 2);
		$miPDF -> Cell( 185, 10 , 'Precio total: $'.$total, 0, 0, 'R' , true );



		$format="%d%m%Y%H%M%S";
		$date=strftime($format);
		$nombrePDF = 'comprobante'.$date.'.pdf';
		$url = dirname(__DIR__).'/comprobantes/'.$nombrePDF;
		

		$miPDF->Output($url,'F');

    	return $nombrePDF;
    }

}
?>