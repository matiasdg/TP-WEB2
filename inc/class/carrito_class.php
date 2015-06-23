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

    }


    public function eliminar($items){

        foreach($items as $item){
            unset($_SESSION["carrito"][$item]);
        }

        $this->actualizarCarrito();

    }

    public function informar(){
    	$carrito = $this->carrito;

        //Informo el último producto agregado

        $ultimoArticulo = end($carrito);

        echo
        "<div class='mensaje-carrito'>
            <div class='title'>
                <p>Producto agregado</p>
            </div>

            <div class='producto-nombre'>
                <label>Nombre</label>
                <p>".$ultimoArticulo['nombre']."</p>
            </div>
            <div class='producto-detalles'>
                <label>Detalles</label>
                <p>";
                    foreach($ultimoArticulo['detalles'] as $detalles)
                    {
                        echo $detalles.". ";
                    }   
                echo
                "</p>
            </div>
            <div class='producto-tamanio'>
                <label>Tamaño</label>
                <p>".$ultimoArticulo['tamanio']."</p>
            </div>
            <div class='producto-precio'>
                <label>Precio</label>
                <p>$".$ultimoArticulo['precio']."</p>
            </div>
        </div>";
    }

    private function estaVacio(){
        $carrito = $this->carrito;

        if( sizeof($carrito) == 0 )
        {
            return true;
        }else
        {
            return false;
        }
    }

    public function mostrarProductos(){
        

        if(!isset($_SESSION["carrito"]))
        {
            echo "No hay productos agregados al carrito.<br/>";
            return false;
        }elseif ( self::estaVacio())
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

            echo "  
                    <div class='table-row item item-".$itemNumero."' id='".$articulo['unique_id']."'>
                    <div class='title-movil'><p>Producto ".$itemNumero."</p></div>
                        <div class='table-cell'>
                            <div class='details'>
                                <p>".ucfirst( $articulo['nombre'] )."</p>
                            </div>
                        </div>
                        <div class='table-cell'>
                            <div class='details'>
                                <p>";
                                foreach($articulo['detalles'] as $detalles)
                                {
                                    echo ucfirst( $detalles )."<br/>";
                                }
                                echo "</p>
                            </div>
                        </div>
                        <div class='table-cell'>
                            <div class='details'>
                                <p>".ucfirst( $articulo['tamanio'] )."</p>
                            </div>
                        </div>
                        <div class='table-cell'>
                            <div class='details'>
                                <p>$".ucfirst( $articulo['precio'] )."</p>
                            </div>
                        </div>
                    </div>";

                    $itemNumero++;
        }


        echo "</div>";

        echo "<div class='total'>
                <p>TOTAL: $<span>".self::obtenerPrecioTotal()."</span></p>
             </div>";


        echo "  <div class='controles'>
                    <a class='btn btn-warning' href='#' id='cancelar-productos-carrito'>Cancelar</a>
                    <a class='btn btn-warning' href='#' id='eliminar-productos-carrito'>Eliminar Productos</a>
                    <a href='#confirmacion' class='btn btn-success confirmacion' id='confirmar-productos-carrito'>Confirmar Productos</a>
                </div>";


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

        //Obtengo la fecha actual.
        $fecha_pedido = date("d/m/y");
        $calle = $datos['calle'];
        $numero_domicilio = $datos['altura'];
        $depto = $datos['depto'];
        //Obtengo el precio total de los productos del carrito.
        $precio_total = self::obtenerPrecioTotal();
        $modo_pago = $datos['pago'];
        
        if(isset($datos['numeroTarjeta']))
        {
            $numero_tarjeta = $datos['numeroTarjeta'];
        }else
        {
            $numero_tarjeta = 0;
        }
        
        
        $estado = 'no entregado';
        //Obtengo el último ID de pedido de la BDD, y le sumo 1. 
        //(Si el último pedido es el 012, el pedido que procesamos ahora será el 013) 
        $id_pedido = $sistema->obtenerIdUltimoPedido() + 1;

        //Recorro todos los productos del carrito.
        foreach($carrito as $articulo)
        {
            $detalles_string = "";
            $nombreArticulo = $articulo['nombre'];
            $precioArticulo = $articulo['precio'];
            $tamanioArticulo = $articulo['tamanio'];

            //$articulo['detalles'] es un array que contiene los ingredientes o tipos de pizza(mixtas).
            //Por lo tanto, recorro cada ítem para guardarlos en una cadena.
            foreach($articulo['detalles'] as $detalles)
            {
               $detalles_string = $detalles_string . $detalles.". ";
            }

            $numero_domicilio = (int)$numero_domicilio;
            $numero_tarjeta = (int)$numero_tarjeta;

            $consulta = "INSERT INTO PEDIDOS 
                        (id_pedido, id_usuario, fecha, producto, detalles, precio, tamanio, calle, altura, depto, modo_pago, numero_tarjeta, estado) VALUES
                        ($id_pedido, '$id_usuario', '$fecha_pedido', '$nombreArticulo', '$detalles_string', $precioArticulo, '$tamanioArticulo', '$calle', $numero_domicilio, '$depto', '$modo_pago', $numero_tarjeta, 'no entregado')";

            $this->db->query($consulta) or die("Error al realizar compra: " . mysqli_error($this->db));

        }

        return $id_pedido;
    }


    private function obtenerPrecioTotal(){
        $carrito = $this->carrito;
        $precio_total = 0;

        foreach($carrito as $producto){
            $precio_total = $precio_total + $producto['precio'];
        }

        return $precio_total;
    }

    public function actualizarPrecio(){
        echo self::obtenerPrecioTotal();
    }

}

?>