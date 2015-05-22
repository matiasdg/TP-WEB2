
<?php
require (dirname(__DIR__)."/modelo.php");


class Pizza extends Modelo {

    public function __construct()
    {
        parent::__construct();
    }

    public function extraerPorCategoria($categoria){


    	$consulta = "SELECT nombre, precio, categoria FROM PIZZAS where categoria = '$categoria'";

		$registros = $this->db->query($consulta) 
			or die('Error: ' . mysqli_error($this->db));

		//Mediante un while voy cargando todas las pizzas de dicha categoría

			if($categoria == "personalizada")
			{
				echo "<div class='box'>
				<div class='pizza'>
				<img src='images/pizzas/".$fila->categoria."/".$fila->nombre.".jpg' alt=''>
						<div class='oculto'>
							<a href='pizza-personalizada.php'><i class='icon-circle-with-plus btn-enviarPizza'></i></a>
						</div>
					</div>
					<div class='name'>
						<div class='horizontal-center'>
							<div class='title'>
								<p>ARMÁ TU PIZZA</p>
							</div>
						</div>
					</div>
				</div>";

			}elseif ($categoria == "mixtas")
			{
				while( $fila = $registros->fetch_object() ){
				echo "<div class='box'>
						<div class='pizza'>
						<img src='images/pizzas/".$fila->categoria."/".$fila->nombre.".jpg' alt=''>
							<div class='oculto'>
								<a href='pizza-predefinida.php?nombrePizza=".$fila->nombre."'><i class='icon-circle-with-plus btn-enviarPizza'></i></a>
							</div>
						</div>
						<div class='name'>
							<div class='horizontal-center'>
								<div class='title'>
									<p>".$fila->nombre."</p>
								</div>
							</div>
						</div>
					</div>";
					}
				
				echo "<div class='box'>
						<div class='pizza'>
						<img src='images/pizzas/mixtas/mixta-armar.jpg' alt=''>
							<div class='oculto'>
								<a href='pizza-mixta.php'><i class='icon-circle-with-plus btn-enviarPizza'></i></a>
							</div>
						</div>
						<div class='name'>
							<div class='horizontal-center'>
								<div class='title'>
									<p>ARMÁ TU MIXTA</p>
								</div>
							</div>
						</div>
					</div>";


			}else
			{
				while( $fila = $registros->fetch_object() ){
				echo "<div class='box'>
				<div class='pizza'>
					<img src='images/pizzas/".$fila->categoria."/".$fila->nombre.".jpg' alt=''>
							<div class='oculto'>
								<a href='pizza-predefinida.php?nombrePizza=".$fila->nombre."'><i class='icon-circle-with-plus btn-enviarPizza'></i></a>
							</div>
						</div>
						<div class='name'>
							<div class='horizontal-center'>
								<div class='title'>
									<p>".$fila->nombre."</p>
								</div>
								<div class='precio-pizza'>
									<p>$".$fila->precio."</p>
								</div>
							</div>
						</div>
					</div>";
				}
			}
					
		
    }

    public function cargarPizza($nombrePizza){

    	
    	$consultaIngredientes = "SELECT INGREDIENTES.nombre as nombreIngredientes
    				FROM PIZZAS INNER JOIN 
    				(TIENE_INGREDIENTES INNER JOIN INGREDIENTES
    				ON TIENE_INGREDIENTES.id_ingrediente = INGREDIENTES.id_ingrediente)
    				ON PIZZAS.id_pizza = TIENE_INGREDIENTES.id_pizza 
    				where PIZZAS.nombre = '$nombrePizza'";

		$registrosIngredientes = $this->db->query($consultaIngredientes) 
			or die('Error en la consulta de Ingredientes: ' . mysqli_error($this->db));

    	$consulta = "SELECT nombre, precio, categoria, id_pizza 
    				FROM PIZZAS
    				where PIZZAS.nombre = '$nombrePizza'";


		$registros = $this->db->query($consulta) 
			or die('Error en la consulta: ' . mysqli_error($this->db));

		while( $fila = $registros->fetch_object() ){
		
			echo "
						<div class='pizza-foto'>
							<img src='images/pizzas/".$fila->categoria."/".$fila->nombre.".jpg' alt=''>
						</div>
						<p id=".$fila->id_pizza.">".$fila->nombre."</p>
					</div>
				</div>
				<div class='flex-item'>
					<div class='ingredientes'>
						<p>Ingredientes</p>
						<ul>";
							while( $filaIngredientes = $registrosIngredientes->fetch_object() )
							{
								echo"<li>".$filaIngredientes->nombreIngredientes."</li>";
							}
						echo"</ul>
					</div>
				</div>

				<div class='flex-item'>
					<div class='opciones'>
						<p>Tamaño</p>
						<ul>
							<li><input type='radio' name='tamanio-predefinida' value='grande' checked='checked'><label for='grande'>Grande</label></li>
							<li><input type='radio' name='tamanio-predefinida' value='mediana'><label for='mediana'>Mediana</label></li>
						</ul>
					</div>
				</div>

				<div class='flex-item'>
					<div class='precio-btn'>
						<div class='precio'>
							<p>Precio: <span>$".$fila->precio."</span></p>
						</div>";
						
		}	
    }


    public function mostrarTodasPizzas(){

    	$consulta = "SELECT nombre, precio, categoria FROM PIZZAS";

    	$registros = $this->db->query($consulta)
    	or die("Error en la consulta.".mysqli_error($this->db));

		//Mediante un while voy cargando todas las pizzas de dicha categoría.
		while( $fila = $registros->fetch_object() ){
		echo "	<div class='box'>
					<div class='pizza'>
						<img src='images/pizzas/".$fila->categoria."/".$fila->nombre.".jpg' alt=''>
						<div class='oculto'>
							<a href='pizza-predefinida.php?nombrePizza=".$fila->nombre."'><i class='icon-circle-with-plus btn-enviarPizza'></i></a>
						</div>
					</div>
					<div class='name'>
						<div class='horizontal-center'>
							<div class='title'>
								<p>".$fila->nombre."</p>
							</div>
							<div class='precio-pizza'>
								<p>$".$fila->precio."</p>
							</div>
						</div>
					</div>
				</div>";

    	}

	}

	public function getSabores(){

		//Consulto todos los sabores
		$consulta = "SELECT nombre FROM PIZZAS";

    	$registros = $this->db->query($consulta)
    	or die("Error en la consulta.".mysqli_error($this->db));

    	while( $fila = $registros->fetch_object() ){
    		echo "<option value='".$fila->nombre."'>".$fila->nombre."</option>";
    	}	
	}

	public function getPrecio($sabores, $tamanio){
		$sabor = join(',',$sabores);

		//Tomo la cantidad de sabores.
		$cantidad = sizeof($sabores);
		$precioFinal = 0;

		$consulta = "SELECT precio FROM PIZZAS WHERE nombre IN ($sabor)";

		if($cantidad > 0)
		{
	    	$registros = $this->db->query($consulta)
	    	or die("Error en la consulta.".mysqli_error($this->db));

	    	while( $fila = $registros->fetch_object() ){
	    		
	    		$precio = $fila->precio / $cantidad;
	    		$precioFinal = $precioFinal + $precio;
	    	}			
		}

    	$precioFinalRedondo = number_format($precioFinal, 1);

    	if($tamanio == "mediana")
    	{
    		$precioFinalRedondo = $precioFinalRedondo / 2;
    		echo "$".$precioFinalRedondo;
    	}else
    	{
    		echo "$".$precioFinalRedondo;
    	}

	}


	public function actualizarPrecioPredefinida($codigo, $tamanio){

		$consulta = "SELECT precio FROM PIZZAS WHERE id_pizza = $codigo";

		$registros = $this->db->query($consulta) or die("Error: " . mysqli_error($this->db));


		while( $fila = $registros->fetch_object() ){
			$precio = $fila->precio;
		}


    	if($tamanio == "mediana")
    	{
    		$precio = $precio / 2;
    		echo "$".$precio;
    	}else
    	{
    		echo "$".$precio;
    	}

	}




	public function calcularPrecioPersonalizada($datos){
		//Obtener el precio de cada ingrediente por xx gramos.
		//Sumar todos esos ingredientes.
		//

		$ingredientes = $datos['detalles'];
		$ingrediente = join(',',$ingredientes);
		$subTotal = 0;

		$consulta = "SELECT (30*precio)/1000 as precioSub FROM INGREDIENTES WHERE nombre IN ($ingrediente)";

		$registros = $this->db->query($consulta) or die ("Error: " . mysqli_error($this->db));

		while($fila = $registros->fetch_object()){
			$subTotal = $subTotal + $fila->precioSub;
		}


    	if($datos['tamanio'] == "mediana")
    	{
    		$subTotal = $subTotal / 2;
    		echo "$".$subTotal;
    	}else
    	{
    		echo "$".$subTotal;
    	}

	}

}

?>