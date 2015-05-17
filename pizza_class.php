
<?php
require_once ("modelo.php");



class Pizza extends Modelo {

    public function __construct()
    {
        parent::__construct();
    }

    public function extraerPorCategoria($categoria){


    	$consulta = "SELECT nombre, precio, categoria FROM PIZZAS where categoria = '$categoria'";

		$registros = $this->db->query($consulta) 
			or die('Error: ' . mysqli_error($this->db));

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

    public function cargarPizza($nombrePizza){

    	
    	$consultaIngredientes = "SELECT INGREDIENTES.nombre as nombreIngredientes
    				FROM PIZZAS INNER JOIN 
    				(TIENE_INGREDIENTES INNER JOIN INGREDIENTES
    				ON TIENE_INGREDIENTES.id_ingrediente = INGREDIENTES.id_ingrediente)
    				ON PIZZAS.id_pizza = TIENE_INGREDIENTES.id_pizza 
    				where PIZZAS.nombre = '$nombrePizza'";

		$registrosIngredientes = $this->db->query($consultaIngredientes) 
			or die('Error en la consulta de Ingredientes: ' . mysqli_error($this->db));

    	$consulta = "SELECT nombre, precio, categoria 
    				FROM PIZZAS
    				where PIZZAS.nombre = '$nombrePizza'";


		$registros = $this->db->query($consulta) 
			or die('Error en la consulta: ' . mysqli_error($this->db));

		while( $fila = $registros->fetch_object() ){
		
			echo "<div class='pizza-predefinida'>
				<div class='flex-item'>
					<div class='pizza'>
						<div class='pizza-foto'>
							<img src='images/pizzas/".$fila->categoria."/".$fila->nombre.".jpg' alt=''>
						</div>
						<p>".$fila->nombre."</p>
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
							<li><input type='radio' name='tamanio' id='grande'><label for=''>Grande</label></li>
							<li><input type='radio' name='tamanio' id='mediana'><label for=''>Mediana</label></li>
						</ul>
					</div>
				</div>

				<div class='flex-item'>
					<div class='precio-btn'>
						<div class='precio'>
							<p>Precio: <span>$".$fila->precio."</span></p>
						</div>
						<a href='' class='btn btn-success'>Agregar al carrito</a>
					</div>
				</div>
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

}

?>