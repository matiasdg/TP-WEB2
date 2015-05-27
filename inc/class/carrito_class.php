<?php
require (dirname(__DIR__)."/class/sistema_class.php");
include_once (dirname(__DIR__)."/modelo.php");


if(!isset($_SESSION)){
    session_start();
}

class Carrito extends Modelo {
	private $carrito = array();

    public function __construct()
    {
        parent::__construct();

		if(!isset($_SESSION["carrito"]))
		{
			$_SESSION["carrito"] = null;
			$this->carrito["precio_total"] = 0;
			$this->carrito["articulos_total"] = 0;
		}
		$this->carrito = $_SESSION['carrito'];
    }


    public function add($articulo){

		//Creo una clave única para el artículo con la fecha y hora actual.
        $format="%d%m%Y%H%M%S";
        $date=strftime($format);
		$unique_id = md5($date);
 		
 		//Agrego un campo al array con esa clave única.
		$articulo["unique_id"] = $unique_id;

		//Agrego el articulo a la sesión del carrito, identificándose con esa clave generada.
    	$_SESSION["carrito"][$unique_id] = $articulo;


    	$this->actualizarCarrito();

        $this->actualizarPrecio();

    }

    private function actualizarPrecio(){

    }


    public function eliminar($items){

        foreach($items as $item){
            unset($_SESSION["carrito"][$item]);
        }

        $this->actualizarCarrito();

    }

    public function informar(){
    	$carrito = $this->carrito;

    	foreach($carrito as $articulo)
    	{
    		echo "nombre: ".$articulo['nombre']."<br/>";
    		echo "precio: ".$articulo['precio']."<br/>";
    		echo "tamanio: ".$articulo['tamanio']."<br/>";

            echo "Detalles: <br/>";
    		foreach($articulo['detalles'] as $detalles)
    		{
    			echo $detalles."<br/>";
    		}	
    	}
    }

    public function mostrarProductos(){
        

        if(!isset($_SESSION["carrito"]))
        {
            echo "No hay productos agregados al carrito.<br/>";
            return false;
        }else
        {
            $carrito = $this->carrito;
        }


        echo "<div class='productos'>
                <div class='table-row'>
                    <div class='table-cell'>
                        <div class='title'>
                            <p>Nombre</p>
                        </div>
                    </div>
                    <div class='table-cell'>
                        <div class='title'>
                            <p>Detalles</p>
                        </div>
                    </div>
                    <div class='table-cell'>
                        <div class='title'>
                            <p>Tamaño</p>
                        </div>
                    </div>
                    <div class='table-cell'>
                        <div class='title'>
                            <p>Precio</p>
                        </div>
                    </div>
                </div>";
                $itemNumero = 1;

        foreach($carrito as $articulo){

            echo "  <div class='table-row item item-".$itemNumero."' id='".$articulo['unique_id']."'>
                        <div class='table-cell'>
                            <div class='details'>
                                <p>".$articulo['nombre']."</p>
                            </div>
                        </div>
                        <div class='table-cell'>
                            <div class='details'>
                                <p>";
                                foreach($articulo['detalles'] as $detalles)
                                {
                                    echo $detalles."<br/>";
                                }
                                echo "</p>
                            </div>
                        </div>
                        <div class='table-cell'>
                            <div class='details'>
                                <p>".$articulo['tamanio']."</p>
                            </div>
                        </div>
                        <div class='table-cell'>
                            <div class='details'>
                                <p>$".$articulo['precio']."</p>
                            </div>
                        </div>
                    </div>";

                    $itemNumero++;
        }


        echo "</div>";


    }


    public function actualizarCarrito(){
        //Llamo al método constructor.
        self::__construct();
    }


    public function realizarCompra($datos){
        $carrito = $this->carrito;

        $cantidadProductos = sizeof($carrito);

        //Traigo los datos correspondientes y los guardo en variabes:

        //Creo un objeto de tipo Sistema para llamar a un método de dicha clase.

        $sistema = new Sistema();
        $usuario = $_SESSION['usuario'];

        $id_usuario = $sistema->obtenerIdUsuario($usuario);

        $fecha_pedido = date("d/m/y");
        $calle = $datos['pago'];
        $numero_domicilio = $datos['pago'];
        $depto = $datos['pago'];
        $precio_total = self::obtenerPrecioTotal();
        $modo_pago = $datos['pago'];
        
        if(isset($datos['numeroTarjeta']))
        {
            $numero_tarjeta = $datos['numeroTarjeta'];
        }else
        {
            $numero_tarjeta = null;
        }
        
        
        $estado = "no entregado";
        $id_pedido = $sistema->obtenerIdUltimoPedido() + 1;

        foreach($carrito as $articulo)
        {
            $detalles_string = "";
            $nombreArticulo = $articulo['nombre'];
            $precioArticulo = $articulo['precio'];
            $tamanioArticulo = $articulo['tamanio'];

            foreach($articulo['detalles'] as $detalles)
            {
               $detalles_string = $detalles_tring + $detalles.". ";
            }   

            $consulta = "INSERT INTO PEDIDOS VALUES
                        ('$id_pedido', '$id_usuario', 'id_producto', '$fecha_pedido', '$nombreArticulo', 
                            '$detalles_string', $precioArticulo, '$tamanioArticulo', '$calle', $numero_domicilio, 
                            $depto, $precio_total, '$modo_pago', $numero_tarjeta, '$estado')";

            $this->db->query($consulta) or die("Error al realizar compra: " . mysqli_error($this->db));

        }


    }


    private function obtenerPrecioTotal(){
        $carrito = $this->carrito;
        $precio_total = 0;

        foreach($carrito as $producto){
            $precio_total = $precio_total + $producto['precio'];
        }

        return $precio_total;
    }

}

?>