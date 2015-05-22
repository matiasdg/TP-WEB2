<?php
require (dirname(__DIR__)."/modelo.php");
session_start();

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
        $carrito = $this->carrito;


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
        self::__construct();
    }

}

?>