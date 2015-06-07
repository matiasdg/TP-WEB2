<?php
require (dirname(__DIR__)."/modelo.php");
require (dirname(__DIR__)."libs/fpdf/fpdf.php");



class PDF extends Modelo {

    public function __construct(){
        parent::__construct();
    }

    public function generarPDF($id_pedido, $usuario){

    	

    	//Creo el PDF
       	$miPDF = new FPDF(); 
		$miPDF->AddPage(); 
		$miPDF->SetFont('Helvetica','B',12);
		$miPDF -> SetTextColor( 0 , 0 , 0);
		$cabecera = array(iconv('UTF-8', 'windows-1252', "Año"), "Mes", "Ingresos", "Gastos", "Bal. Mensual", "Bal. Global");
		
		for ($i = 0; $i < count( $cabecera) ; $i++)
		{
			$mipdf -> SetFillColor( 191 , 191 , 191 );
			$mipdf -> Cell ( 30 , 10 , $cabecera[ $i ], 1 , 0 , 'C' , true );
		}

		$mipdf -> Ln( 10);


		//Consulto los datos del pedido con ese id_pedido y los extraigo, para posteriormente volcarlos al pdf.
		$consulta = "SELECT * FROM PEDIDOS WHERE id_pedido = $id_pedido";
		$registrosPedido = $this->db->query($consulta)
				 	or die("Error consultando los datos del pedido" . mysqli_error($this->db));

		//Consulto los datos del usuario.
		$usuario = md5($usuario);
		$consulta = "SELECT * FROM USUARIO WHERE nombre_usuario = '$usuario'";
		$registrosUsuario = $this->db->query($consulta)
				 	or die("Error consultando los datos del usuario" . mysqli_error($this->db));

		while($objeto = $registrosUsuario->fetch_object())
		{
			$nombre = $objeto->nombre;
			$apellido = $objeto->apellido;
			$dni = $objeto->numero_dni;

		}


		while ($objeto = $registrosPedido->fetch_object())
		{
			$fecha =

			$mipdf -> SetFillColor( 255 , 255 , 255 );
			$mipdf -> Cell( 30, 10 , $anio, 1, 0, 'C' , true );
			$mipdf -> Cell( 30, 10 , $mes, 1, 0, 'C' , true );
			$mipdf -> Cell( 30, 10 , "$".$ingreso_total, 1, 0, 'C' , true );
			$mipdf -> Cell( 30, 10 , "$".$gasto_total, 1, 0, 'C' , true );
			$mipdf -> Cell( 30, 10 , "$".$balance_mes, 1, 0, 'C' , true );
			$mipdf -> Cell( 30, 10 , "$".$balance_fecha, 1, 0, 'C' , true );
			$mipdf -> Ln( 10);
		}



		$format="%d%m%Y%H%M%S";
		$date=strftime($format);
		$url = 'comprobante'.$date.'.pdf';
		

		$miPDF->Output($url,'F');

    	return $nombrePDF;
    }

}
?>