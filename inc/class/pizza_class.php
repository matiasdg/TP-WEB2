
<?php
include_once (dirname(__DIR__)."/modelo.php");


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
						<img src='images/pizzas/mixtas/mixta.jpg' alt=''>
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

    	$consulta = "SELECT nombre, precio, categoria, id_pizza 
    				FROM PIZZAS
    				where PIZZAS.nombre = '$nombrePizza'";

		$registros = $this->db->query($consulta) or die('Error en la consulta: ' . mysqli_error($this->db));


		while( $registro = $registros->fetch_object() )
		{
			echo "
						<div class='pizza-foto'>
							<img src='images/pizzas/".$registro->categoria."/".$registro->nombre.".jpg' alt=''>
						</div>
						<p id=".$registro->id_pizza.">".$registro->nombre."</p>
					</div>
				</div>
				<div class='flex-item'>";

			if( $registro->categoria == 'mixtas' )
			{
				$consultaSabores = "SELECT nombre FROM PIZZA_MIXTA INNER JOIN PIZZAS ON
					 PIZZA_MIXTA.id_pizza = PIZZAS.id_pizza 
					 WHERE id_pizza_mixta = $registro->id_pizza";

				$registrosSabores = $this->db->query($consultaSabores) 
					or die('Error consultando los sabores: ' . mysqli_error($this->db));

				echo 
				"<div class='ingredientes'>
					<p>Sabores</p>
					<ul>";
						while( $registroSabores = $registrosSabores->fetch_object() )
						{
							echo"<li>".$registroSabores->nombre."</li>";
						}
					echo
					"</ul>
				</div>";
			}else
			{
				$consultaIngredientes = "SELECT INGREDIENTES.nombre as nombreIngredientes
							FROM PIZZAS INNER JOIN 
							(TIENE_INGREDIENTES INNER JOIN INGREDIENTES
							ON TIENE_INGREDIENTES.id_ingrediente = INGREDIENTES.id_ingrediente)
							ON PIZZAS.id_pizza = TIENE_INGREDIENTES.id_pizza 
							where PIZZAS.nombre = '$nombrePizza'";

				$registrosIngredientes = $this->db->query($consultaIngredientes) 
					or die('Error en la consulta de Ingredientes: ' . mysqli_error($this->db));

				echo 
				"<div class='ingredientes'>
					<p>Ingredientes</p>
					<ul>";
						while( $filaIngredientes = $registrosIngredientes->fetch_object() )
						{
							echo"<li>".$filaIngredientes->nombreIngredientes."</li>";
						}
					echo
					"</ul>
				</div>";
			}

				echo "</div>

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
							<p>Precio: $<span>".$registro->precio."</span></p>
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
		(float) $cantidad = sizeof($sabores);
		(float) $precioFinal = 0;

		$consulta = "SELECT precio FROM PIZZAS WHERE nombre IN ($sabor)";

		if($cantidad > 0)
		{
	    	$registros = $this->db->query($consulta)
	    	or die("Error en la consulta.".mysqli_error($this->db));

	    	while( $fila = $registros->fetch_object() ){
	    		
	    		(float) $precio = (float) $fila->precio / (float) $cantidad;
	    		(float) $precioFinal = (float) $precioFinal + (float) $precio;
	    	}			
		}

    	$precioFinalRedondo = number_format($precioFinal, 1);

    	if($tamanio == "mediana")
    	{
    		$precioFinalRedondo = $precioFinalRedondo / 2;
    		echo $precioFinalRedondo;
    	}else
    	{
    		echo $precioFinalRedondo;
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
    		echo $precio;
    	}else
    	{
    		echo $precio;
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
    		echo $subTotal;
    	}else
    	{
    		echo $subTotal;
    	}

	}


	public function cargarPizzaAdmin($datos){
		$nombre = $datos['nombre'];
		$categoria = $datos['categoria'];
		$precio = (float)$datos['precio'];


    	$ruta = PATH.'/images/pizzas/'.$categoria.'/';
    	$formato = explode(".",$_FILES["file"]["name"]);
		$newfilename = $nombre . '.' .end($formato);

		if ( 0 < $_FILES['file']['error'] ) {
	        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
	    }
	    else
	    {
	    	move_uploaded_file($_FILES['file']['tmp_name'], $ruta . $newfilename);
	    }



		//Ingreso la nueva pizza a PIZZAS.

		$id_pizza = self::obtenerIDUltimaPizza() + 1;

		$consultaPizza = "INSERT INTO PIZZAS (id_pizza, nombre, categoria, precio)
					select
					($id_pizza),
					('$nombre'),
					('$categoria'),
					($precio)";

    	$registrosPizza = $this->db->query($consultaPizza) or die("Error en la consulta.".mysqli_error($this->db));

		//Ingreso los respectivos ingredientes por separado en TIENE_INGREDIENTES

		if( isset($datos['ingredientes']) )
		{
			$ingredientes = $datos['ingredientes'];
			$ingredientes = json_decode($ingredientes, true);

		    foreach($ingredientes as $key=>$val)
			{
				//Por cada ingrediente hago un INSERT.
				$id_ingrediente = $val['id_ingrediente'];
				$cantidad = (float)$val['cantidad'];

				$consultaIng = "INSERT INTO TIENE_INGREDIENTES(id_pizza,id_ingrediente,cantidad,precio)
							select
							($id_pizza),
							($id_ingrediente),
							($cantidad),
							(SELECT (INGREDIENTES.precio*$cantidad)/1000 FROM INGREDIENTES
								WHERE INGREDIENTES.id_ingrediente = $id_ingrediente )";

	    		$registrosIng = $this->db->query($consultaIng) or die("Error ingresando los ingredientes: ".mysqli_error($this->db));
			}

		}elseif( isset($datos['sabores']) )
		{
			$sabores = $datos['sabores'];
			$sabores = json_decode($sabores, true);
			$cantidadSabores = sizeof($sabores);
			$ingredientes = array();

			//Obtengo el Id de los sabores

			$consultaId= "SELECT id_pizza FROM PIZZAS WHERE nombre IN ( '" . implode($sabores, "', '") . "' )";

	    	$registrosId = $this->db->query($consultaId) or die("Error consultando el Id: ".mysqli_error($this->db));

			while($registroId = $registrosId->fetch_object())
			{
				//Inserto la pizza mixta con los respectivos id_pizza de los sabores en PIZZA_MIXTA

				$consultaMixta = "INSERT INTO PIZZA_MIXTA(id_pizza_mixta, id_pizza)
									VALUES ($id_pizza, $registroId->id_pizza)";

	    		$registrosMixta = $this->db->query($consultaMixta) or die("Error Ingresando la pizza mixta: ".mysqli_error($this->db));
			}

		}




	}

	private function obtenerIDUltimaPizza(){
        $id_pizza = 0;

        $consulta = "SELECT MAX(id_pizza) as id_pizza FROM PIZZAS";

        $registros = $this->db->query($consulta) or die( "Error en la consulta obtenerIDPizza: ".mysqli_error($this->db) );
    
        while($objeto = $registros->fetch_object()){
            $id_pizza = $objeto->id_pizza;
        }

        return $id_pizza;
	}

	public function eliminarPizzaAdmin($id_pizza){

		$consulta = "DELETE FROM PIZZAS WHERE id_pizza = $id_pizza";

		$registros = $this->db->query($consulta) or die( "Error en la consulta obtenerIDPizza: ".mysqli_error($this->db) );

	}

	public function agregarIngredienteAdmin($datos){
		$nombre = $datos['nombre'];
		$stock = (float)$datos['stock'];
		$precio = (float)$datos['precio'];
		$id_ingrediente = self::obtenerUltimoIdIngrediente() + 1;

		$consulta = "INSERT INTO INGREDIENTES(id_ingrediente,nombre,stock,precio)
					values
					($id_ingrediente,
					'$nombre',
					$stock,
					$precio)";

		$registros = $this->db->query($consulta) or die("Error ingresando los ingredientes: ".mysqli_error($this->db));


	}

	public function agregarIngredientePizza($datos){
		$id_pizza = $datos['id_pizza'];
		$id_ingrediente = $datos['id_ingrediente'];
		$cantidad = $datos['cantidad'];

	}

	public function eliminarIngredienteAdmin($id_ingrediente){
		$pizzas = array();

		//Obtengo las pizzas que contengan ese ingrediente y las guardo en un array para posteriormente actualizarlas.

		$consultaPizzaIng = "SELECT id_pizza FROM TIENE_INGREDIENTES WHERE id_ingrediente = $id_ingrediente";

		$registrosPizzaIng = $this->db->query($consultaPizzaIng) or die( "Error eliminando el ingrediente: ".mysqli_error($this->db) );

		while($registroPizzaIng = $registrosPizzaIng->fetch_object())
		{
			$pizzas[] = $registroPizzaIng->id_pizza;
		}

		//Elimino el ingrediente

		$consulta = "DELETE FROM INGREDIENTES WHERE id_ingrediente = $id_ingrediente";

		$registros = $this->db->query($consulta) or die( "Error eliminando el ingrediente: ".mysqli_error($this->db) );

		//Actualizo el precio de las pizzas involucradas.

		$consultaPizza = "SELECT * FROM PIZZAS WHERE id_pizza IN ( '" . implode($pizzas, "', '") . "' )";

		$registrosPizza = $this->db->query($consultaPizza) or die( "Error consultando las pizzas: ".mysqli_error($this->db) );

		
		while($registroPizza = $registrosPizza->fetch_object())
		{
			$consultaActualizoPrecio = "UPDATE PIZZAS SET precio = (SELECT SUM(precio) FROM TIENE_INGREDIENTES WHERE id_pizza = $registroPizza->id_pizza)
										WHERE id_pizza = $registroPizza->id_pizza";

			$registrosPrecio = $this->db->query($consultaActualizoPrecio) or die( "Error actualizado el precio de las pizzas: ".mysqli_error($this->db) );
		}

	}

	public function mostrarIngredientesTabla(){
		$consulta = "SELECT * from INGREDIENTES ORDER BY nombre";

		$registros = $this->db->query($consulta) or die ("Error al consultar los ingredientes: " . mysqli_error($this->db));

		while( $registro = $registros->fetch_object() )
		{
			echo
			"<tr id='".$registro->id_ingrediente."'>
				<td>
					".$registro->nombre."
				</td>
				<td>
					".$registro->stock." gr"."
				</td>
				<td>
					$".$registro->precio."
				</td>
				<td>
					<a href='#' class='btn btn-info modificarIngredienteAdmin'>Modificar</a>
				</td>";

			if($registro->id_ingrediente == 001 || $registro->id_ingrediente == 002)
			{
					echo
					"<td>
						<a href='#' class='btn btn-warning-disabled btn-disabled'>Eliminar</a>
					</td>
				</tr>";
			}else
			{
					echo
					"<td>
						<a href='#' class='btn btn-warning eliminarIngredienteAdmin'>Eliminar</a>
					</td>
				</tr>";
			}


		}		
	}

	public function modificarIngredienteAdmin($datos){
		$nombre = $datos['nombre'];
		$precio = (float)$datos['precio'];
		$stock = (float)$datos['stock'];
		$id = $datos['id_ingrediente'];


		$consulta = "UPDATE INGREDIENTES SET precio = $precio, nombre = '$nombre', stock = $stock
					WHERE id_ingrediente = $id";

		$registros = $this->db->query($consulta) or die ("Error al actualizar los ingredientes: " . mysqli_error($this->db));

		//Actualizo TIENE_INGREDIENTES Y PIZZAS.

		self::actualizarPrecioPizzas($id);

	}

	private function actualizarPrecioPizzas($id){
		//Actualizo los precios de la pizza que involucren al ingrediente con id : $id.

		$consultaCantidad = "SELECT cantidad FROM TIENE_INGREDIENTES WHERE id_ingrediente = $id";

		$registrosCantidad = $this->db->query($consultaCantidad) or die ("Error al seleccionar la cantidad de ingredientes: " . mysqli_error($this->db));

		while( $registro = $registrosCantidad->fetch_object() )
		{
			$cantidad = (float)$registro->cantidad;

			$consulta = "UPDATE TIENE_INGREDIENTES SET 
					precio = (SELECT (INGREDIENTES.precio*$cantidad)/1000 FROM INGREDIENTES
							WHERE INGREDIENTES.id_ingrediente = $id)
					WHERE id_ingrediente = $id";

			$registros = $this->db->query($consulta) or die ("Error al actualizar TIENE_INGREDIENTES: " . mysqli_error($this->db));

		}


		$consultaPizzaCant = "SELECT DISTINCT id_pizza FROM `tiene_ingredientes` where id_ingrediente = $id";

		$registrosPizzaCant = $this->db->query($consultaPizzaCant) or die ("Error al seleccionar la cantidad de Pizzas: " . mysqli_error($this->db));

		while( $registro = $registrosPizzaCant->fetch_object() )
		{
			//obtengo el precio de la pizza que no es a la suma de los precios de los ingredientes
			//self::obtenerPrecioExtraPizza();

			$consultaPizza = "UPDATE PIZZAS SET precio = (SELECT SUM(TIENE_INGREDIENTES.precio) FROM TIENE_INGREDIENTES
							WHERE id_pizza = $registro->id_pizza)
							WHERE id_pizza = $registro->id_pizza";

			$registros = $this->db->query($consultaPizza) or die ("Error al actualizar el precio de PIZZAS: " . mysqli_error($this->db));
		}
	}

	private function obtenerPrecioExtraPizza(){}

	public function obtenerIngredientes(){

		$consulta = "SELECT * FROM INGREDIENTES";

		$registros = $this->db->query($consulta) or die ("Error al consultar los ingredientes: " . mysqli_error($this->db));

		while( $registro = $registros->fetch_object() )
		{
			echo "<li>
			<input type='checkbox' class='input-ing-admin' name='ingredientes' id='".$registro->id_ingrediente."'>
			<label for=''>".$registro->nombre."</label>
			<input type='text' class='cantidad' id='".$registro->id_ingrediente."' placeholder='gramos' disabled>
			</li>
			";
		}
	}

	public function cargarPrecioIgrediente($datos){
		$subtotal = 0;

		//Consulto el precio de los ingredientes y calculo el precio dependiendo de la cantidad de cada ingrediente

		foreach($datos as $key=>$val)
		{
			$id_ingrediente = $val['id_ingrediente'];
			$cantidad = $val['cantidad'];

			$consulta = "SELECT precio FROM INGREDIENTES WHERE id_ingrediente = '$id_ingrediente'";
			$registros = $this->db->query($consulta) or die("Error consultando los ingredientes: " . mysqli_error());

			$registro = $registros->fetch_object();

			$subtotal += ($cantidad*$registro->precio)/1000;
		}

		echo $subtotal;

	}

	public function mostrarPizzasTabla(){

		$consulta = "SELECT * from PIZZAS";

		$registros = $this->db->query($consulta) or die ("Error al consultar los ingredientes: " . mysqli_error());

		while( $registro = $registros->fetch_object() )
		{

			echo
			"<tr id='".$registro->id_pizza."'>
				<td>
					".$registro->nombre."
				</td>
				<td>
					".$registro->categoria."
				</td>";
			
			if($registro->categoria == "mixtas")
			{
				echo 
				"<td>
					". self::obtenerSaboresString($registro->id_pizza) ."
				</td>";
			}else
			{
				echo 
				"<td>
					". self::obtenerIngredientesString($registro->id_pizza) ."
				</td>";
			}

				echo 
				"<td>
					$".$registro->precio."
				</td>
				<td>
					<a href='modificarPizzaAdmin.php?id=".$registro->id_pizza."' class='btn btn-info'>Modificar</a>
				</td>
				<td>
					<a href='#' class='btn btn-warning eliminarPizzaAdmin'>Eliminar</a>
				</td>
			</tr>";
		}

	}

	private function obtenerSaboresString($id_pizza){
		$sabores = "";

		$consulta = "SELECT nombre FROM PIZZA_MIXTA INNER JOIN PIZZAS ON
					 PIZZA_MIXTA.id_pizza = PIZZAS.id_pizza 
					 WHERE id_pizza_mixta = $id_pizza";

		$registros = $this->db->query($consulta) or die ("Error al consultar los ingredientes: " . mysqli_error($this->db));

		while( $registro = $registros->fetch_object() )
		{
			$sabores = $sabores . ucfirst($registro->nombre) . ". ";
		}

		return $sabores;
	}

	private function obtenerIngredientesString($id){
		$ings = "";
		
		$consulta = "SELECT * from TIENE_INGREDIENTES INNER JOIN INGREDIENTES
					ON TIENE_INGREDIENTES.id_ingrediente = INGREDIENTES.id_ingrediente
					WHERE TIENE_INGREDIENTES.id_pizza = $id";

		$registros = $this->db->query($consulta) or die ("Error al consultar los ingredientes: " . mysqli_error($this->db));

		while( $registro = $registros->fetch_object() )
		{
			$ings = $ings . ucfirst($registro->nombre) . ". ";
		}

		return $ings;
	}

	private function obtenerUltimoIdIngrediente(){
        $id_ingrediente = 0;

        $consulta = "SELECT MAX(id_ingrediente) as id_ingrediente FROM INGREDIENTES";

        $registros = $this->db->query($consulta) or die( "Error en la consulta obtenerIDPizza: ".mysqli_error($this->db) );
    
        while($objeto = $registros->fetch_object()){
            $id_ingrediente = $objeto->id_ingrediente;
        }

        return $id_ingrediente;		
	}

	public function obtenerCategoriaDePizza($categoria){

		switch ($categoria) {
			case 'predefinidas': echo "	<option value='predefinidas' selected>Predefinidas</option>
										<option value='veganas'>Veganas</option>
										<option value='celiacas'>Celiacas</option>
										<option value='mixtas'>Mixtas</option>
										<option value='infantiles'>Infantiles</option>";
				break;
			case 'veganas': echo "	<option value='predefinidas'>Predefinidas</option>
									<option value='veganas' selected>Veganas</option>
									<option value='celiacas'>Celiacas</option>
									<option value='mixtas'>Mixtas</option>
									<option value='infantiles'>Infantiles</option>";
				break;
			case 'celiacas': echo "	<option value='predefinidas'>Predefinidas</option>
									<option value='veganas'>Veganas</option>
									<option value='celiacas' selected>Celiacas</option>
									<option value='mixtas'>Mixtas</option>
									<option value='infantiles'>Infantiles</option>";
				break;
			case 'mixtas': echo "	<option value='predefinidas'>Predefinidas</option>
									<option value='veganas'>Veganas</option>
									<option value='celiacas'>Celiacas</option>
									<option value='mixtas' selected>Mixtas</option>
									<option value='infantiles'>Infantiles</option>";
				break;
			case 'infantiles': echo "	<option value='predefinidas'>Predefinidas</option>
										<option value='veganas'>Veganas</option>
										<option value='celiacas'>Celiacas</option>
										<option value='mixtas'>Mixtas</option>
										<option value='infantiles' selected>Infantiles</option>";
				break;
		}

		
	}

	public function modificarPizzaAdminVista($id){

        $consulta = "SELECT * FROM PIZZAS
        			WHERE id_pizza = $id";

        $registros = $this->db->query($consulta) or die( "Error en modificarPizzaAdminVista: ".mysqli_error($this->db) );
    
    	$registro = $registros->fetch_object();

		echo"<div class='agregar-pizza-nombre'>
				<label for='nombre'>Nombre</label>
				<input type='text' id='pizzaNueva-nombre' value='".$registro->nombre."'>
				<input type='hidden' id='pizzaNueva-id' value='".$id."'>
			</div>

			<div class='agregar-pizza-nombre'>
				<label for='categoria'>Categoría</label>
				<select name='pizzaNueva-categoria' id='pizzaNueva-categoria'>";

				self::obtenerCategoriaDePizza($registro->categoria);

				echo "</select>
			</div>

			<div class='agregar-pizza-imagen'>
				<label for='imagen'>Imagen</label>
				<input type='file' id='pizzaNueva-imagen' accept='image/jpeg'>
			</div>";

			if($registro->categoria == 'mixtas')
			{
				echo 
				"<div class='agregar-pizza-sabores' style='height: 152px;' >
						<label for='imagen'>Sabores</label>
					<ul>";
						self::getSaboresDePizza($id);

						$precioIng = number_format(self::obtenerPrecioTotalSabores($id), 1);

						$precioExtra = $registro->precio - $precioIng;

					echo 
					"</ul>
				</div>

				<div class='agregar-pizza-ingredientes'>
					<label for='ingredientes'>Ingredientes</label>
					<ul>";
							self::obtenerIngredientesDePizza($id);

					echo "</ul>
				</div>";
			}else
			{
				echo 
				"<div class='agregar-pizza-sabores'  >
						<label for='imagen'>Sabores</label>
					<ul>";
						self::getSaboresDePizza($id);
					echo 
					"</ul>
				</div>

				<div class='agregar-pizza-ingredientes'>
					<label for='ingredientes'>Ingredientes</label>
					<ul>";
							self::obtenerIngredientesDePizza($id);
							$precioIng = self::obtenerPrecioTotalIngredientes($id);

							$precioExtra = $registro->precio - $precioIng;

					echo "</ul>
				</div>";
			}


			
			echo "<div class='agregar-pizza-precio'>
				<label for='precio'>Precio</label>
				<span>$</span>
				<span id='precio-dinamico'>".$precioIng."</span>
				<span>+</span>
				<input type='text' id='pizzaNueva-precio' value='".$precioExtra."'>
				<span> = $</span>
				<span id='precio-dinamico-total'>".$registro->precio."</span>
			</div>";
	}

	private function obtenerPrecioTotalSabores($id){

		$consultaPrecio = "SELECT SUM(precio/2) as precio FROM PIZZAS INNER JOIN PIZZA_MIXTA ON 
							PIZZAS.id_pizza = PIZZA_MIXTA.id_pizza
							WHERE id_pizza_mixta = $id";

		$registrosPrecio = $this->db->query($consultaPrecio) or die ("Error al obtener el precio total de los sabores: " . mysqli_error($this->db));

		$registroPrecio = $registrosPrecio->fetch_object();

		return (float)$registroPrecio->precio;
	}

	private function getSaboresDePizza($id){
		$cont = 0;

		$consultaSabores = "SELECT nombre FROM PIZZA_MIXTA INNER JOIN PIZZAS ON
							PIZZA_MIXTA.id_pizza = PIZZAS.id_pizza
							WHERE id_pizza_mixta = $id";
		
		$registrosSabores = $this->db->query($consultaSabores) or die ("Error al consultar los sabores: " . mysqli_error($this->db));

		while($registroSabores = $registrosSabores->fetch_object())
		{
			$cont++;

			echo
			"<li>
				<input type='checkbox' id='checkSabor-3' class='checkSabor' checked/>
				<select name='sabores3' id='sabores3' class='selectSaborAdmin'>
					<option value=null disabled>Seleccione</option>
					<option value='".$registroSabores->nombre."' selected>".$registroSabores->nombre."</option>";
						self::getSaboresRestantes($registroSabores->nombre);
				echo "</select>								
			</li>";
		}

		for($i=$cont;$i < 4;$i++)
		{
			echo
			"<li>
				<input type='checkbox' id='checkSabor-3' class='checkSabor'/>
				<select name='sabores3' id='sabores3' class='selectSaborAdmin' disabled>
					<option value=null disabled selected>Seleccione</option>";
						self::getSaboresExceptoMixta();
				echo "</select>								
			</li>";			
		}
	}

	public function obtenerPrecioInicialPersonalizada(){
		
		$consulta = "SELECT (30*precio)/1000 as precioSub FROM INGREDIENTES
						WHERE nombre = 'masa comun'";

    	$registros = $this->db->query($consulta)
    	or die("Error consultando el precio.".mysqli_error($this->db));

    	$registro = $registros->fetch_object();

    	echo $registro->precioSub;	
	}

	public function obtenerIngredientesLista(){

		$consulta = "SELECT * FROM INGREDIENTES
						WHERE nombre != 'masa comun' and nombre != 'masa sin gluten'
						ORDER BY nombre ";

    	$registros = $this->db->query($consulta)
    	or die("Error consultando los ingredientes.".mysqli_error($this->db));

    	while( $registro = $registros->fetch_object() )
    	{
    		echo
    		"<li><input type='checkbox' class='input-ing' name='ingredientes' id='".$registro->nombre."'>
    		<label for=''>".$registro->nombre."</label></li>";
    	}
	}

	public function getSaboresExceptoMixta(){
		$consulta = "SELECT nombre FROM PIZZAS WHERE categoria != 'mixtas'";

    	$registros = $this->db->query($consulta)
    	or die("Error en la consulta.".mysqli_error($this->db));

    	while( $fila = $registros->fetch_object() ){
    		echo "<option value='".$fila->nombre."'>".$fila->nombre."</option>";
    	}			
	}

	private function getSaboresRestantes($sabor){

		//Consulto todos los sabores excepto el que recibo por parámetro
		$consulta = "SELECT nombre FROM PIZZAS WHERE nombre != '$sabor' and categoria != 'mixtas'";

    	$registros = $this->db->query($consulta)
    	or die("Error en la consulta.".mysqli_error($this->db));

    	while( $fila = $registros->fetch_object() ){
    		echo "<option value='".$fila->nombre."'>".$fila->nombre."</option>";
    	}	
	}

	private function tieneIngrediente($id_pizza, $id_ingrediente){
		$consulta = "SELECT * FROM INGREDIENTES INNER JOIN TIENE_INGREDIENTES
						ON INGREDIENTES.id_ingrediente = TIENE_INGREDIENTES.id_ingrediente
						WHERE id_pizza = $id_pizza and TIENE_INGREDIENTES.id_ingrediente = $id_ingrediente";

		$registros = $this->db->query($consulta) or die ("Error al consultar los ingredientes: " . mysqli_error($this->db));
            
        if($registros->num_rows === 0)
        {
            return false;
        }else
        {
            return true;
        }
	}

	private function obtenerCantidadIngrediente($id_pizza, $id_ingrediente){
		$consulta = "SELECT * FROM INGREDIENTES INNER JOIN TIENE_INGREDIENTES
						ON INGREDIENTES.id_ingrediente = TIENE_INGREDIENTES.id_ingrediente
						WHERE id_pizza = $id_pizza and TIENE_INGREDIENTES.id_ingrediente = $id_ingrediente";

		$registros = $this->db->query($consulta) or die ("Error al consultar los ingredientes: " . mysqli_error($this->db));
        
        $registro = $registros->fetch_object();

        return (float)$registro->cantidad;  
	}

	private function obtenerIngredientesDePizza($id){
		$consulta = "SELECT * FROM INGREDIENTES";

		$registros = $this->db->query($consulta) or die ("Error al consultar los ingredientes: " . mysqli_error($this->db));

		while( $registro = $registros->fetch_object() )
		{
			//Si el ingrediente es parte de la pizza entonces le pongo checked con su respectiva cantidad

			if( self::tieneIngrediente($id, $registro->id_ingrediente) )
			{
				$cantidad = self::obtenerCantidadIngrediente($id, $registro->id_ingrediente);

				echo "<li>
				<input type='checkbox' class='input-ing-admin' name='ingredientes' id='".$registro->id_ingrediente."' checked>
				<label for=''>".$registro->nombre."</label>
				<input type='text' class='cantidad' id='".$registro->id_ingrediente."' placeholder='gramos' value='".$cantidad."'>
				</li>
				";
			}else
			{
				if( self::esMixta($id) )
				{
					echo "<li>
					<input type='checkbox' class='input-ing-admin' name='ingredientes' id='".$registro->id_ingrediente."' disabled>
					<label for=''>".$registro->nombre."</label>
					<input type='text' class='cantidad' id='".$registro->id_ingrediente."' placeholder='gramos' disabled>
					</li>
					";	
				}else
				{
					echo "<li>
					<input type='checkbox' class='input-ing-admin' name='ingredientes' id='".$registro->id_ingrediente."'>
					<label for=''>".$registro->nombre."</label>
					<input type='text' class='cantidad' id='".$registro->id_ingrediente."' placeholder='gramos' disabled>
					</li>
					";						
				}
			
			}

		}
	}

	private function esMixta($id){

		$consultaEsMixta = "SELECT categoria FROM PIZZAS WHERE id_pizza = $id";

		$registrosEsMixta = $this->db->query($consultaEsMixta) or die ("Error al consultar los ingredientes: " . mysqli_error($this->db));

		$registroEsMixta = $registrosEsMixta->fetch_object();

		if( $registroEsMixta->categoria == 'mixtas' )
		{
			return true;
		}else
		{
			return false;
		}
	}

	private function obtenerPrecioTotalIngredientes($id){
		$precio = 0;
		$consulta = "SELECT * FROM TIENE_INGREDIENTES
					WHERE id_pizza = $id";

		$registros = $this->db->query($consulta) or die ("Error en obtenerPrecioTotalIngredientes: " . mysqli_error($this->db));

		while( $registro = $registros->fetch_object() )
		{
			$precio += $precio + $registro->precio;
		}

		return $precio;
	}


	public function modificarPizzaAdmin($datos){
		$nombre = $datos['nombre'];
		$categoria = $datos['categoria'];
		$precio = (float)$datos['precio'];
		$id_pizza = $datos['id_pizza'];

    	$ruta = PATH.'/images/pizzas/'.$categoria.'/';
    	$formato = explode(".",$_FILES["file"]["name"]);
		$newfilename = $nombre . '.' .end($formato);

		if ( 0 < $_FILES['file']['error'] ) {
	        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
	    }
	    else
	    {
	    	move_uploaded_file($_FILES['file']['tmp_name'], $ruta . $newfilename);
	    }



		$consultaPizza = "UPDATE PIZZAS SET nombre = '$nombre', categoria = '$categoria', precio = $precio
							WHERE id_pizza = $id_pizza";

    	$registrosPizza = $this->db->query($consultaPizza) or die("Error en actualizando la tabla PIZZAS.".mysqli_error($this->db));

		//Ingreso los respectivos ingredientes por separado en TIENE_INGREDIENTES

		if( isset($datos['ingredientes']) )
		{
			$ingredientes = $datos['ingredientes'];
			$ingredientes = json_decode($ingredientes, true);
	    	$ingredientesArr = array();

		    foreach($ingredientes as $key=>$val)
			{
				$id_ingrediente = $val['id_ingrediente'];
				$cantidad = (float)$val['cantidad'];

				$ingredientesArr[] = $id_ingrediente;


				$consultaExiste = "SELECT * FROM TIENE_INGREDIENTES 
									WHERE id_pizza = $id_pizza and id_ingrediente = $id_ingrediente";

	    		$registrosExiste = $this->db->query($consultaExiste) or die("Error en verificando si existe el ingrediente. ".mysqli_error($this->db));

		        if($registrosExiste->num_rows === 0)
		        {
		        	//Si la relación ingrediente-pizza no existe en la tabla = > Inserto.
	        		$consultaIng = "INSERT INTO TIENE_INGREDIENTES(id_pizza,id_ingrediente,cantidad,precio)
									select
									($id_pizza),
									($id_ingrediente),
									($cantidad),
									(SELECT (INGREDIENTES.precio*$cantidad)/1000 FROM INGREDIENTES
										WHERE INGREDIENTES.id_ingrediente = $id_ingrediente )";
				    		$registrosIng = $this->db->query($consultaIng) or die("Error actualizando los ingredientes 1: ".mysqli_error($this->db));
		        }else
		        {
		            //Si la relacion ingrediente-pizza ya existe en la tabla = > Actualizo.
	        		$consultaIng = "UPDATE TIENE_INGREDIENTES 
									SET  id_ingrediente = $id_ingrediente, cantidad = $cantidad, precio = 
									(SELECT (INGREDIENTES.precio*$cantidad)/1000 FROM INGREDIENTES
									WHERE INGREDIENTES.id_ingrediente = $id_ingrediente )
									WHERE id_pizza = $id_pizza and id_ingrediente = $id_ingrediente";
				    		$registrosIng = $this->db->query($consultaIng) or die("Error actualizando los ingredientes 2: ".mysqli_error($this->db));

		        }

			}

			//Selecciono los ingredientes de la pizza que no están contenidos en el array
			$consultaNoExiste = "SELECT * FROM TIENE_INGREDIENTES 
								WHERE id_pizza = $id_pizza and
								id_ingrediente NOT IN ( '" . implode($ingredientesArr, "', '") . "' )";

			$registrosNoExiste = $this->db->query($consultaNoExiste) or die("Error en consultaNoExiste. ".mysqli_error($this->db));

			//Elimino los ingredientes que se encuentran en la tabla pero no el array

			while($registroNoExiste = $registrosNoExiste->fetch_object())
			{
				//Si el ingrediente que pasa no está contenido en el array, entonces lo elimino

				$consultaEliminoIng = "DELETE FROM TIENE_INGREDIENTES 
										WHERE id_ingrediente = $registroNoExiste->id_ingrediente and
										id_pizza = $id_pizza";

				$registrosEliminoIng = $this->db->query($consultaEliminoIng) or die("Error en consultaEliminoIng. ".mysqli_error($this->db));

			}	
		}elseif( isset($datos['sabores']) )
		{
			$sabores = $datos['sabores'];
			$sabores = json_decode($sabores, true);
			$cantidadSabores = sizeof($sabores);

			//Borro los datos y los vuelvo a insertar, en vez de actualizar.

			$consultaBorro = "DELETE FROM PIZZA_MIXTA WHERE id_pizza_mixta = $id_pizza";

	    	$registrosBorro = $this->db->query($consultaBorro) or die("Error Borrando los datos : ".mysqli_error($this->db));

			//Obtengo el Id de los sabores

			$consultaId= "SELECT id_pizza FROM PIZZAS WHERE nombre IN ( '" . implode($sabores, "', '") . "' )";

	    	$registrosId = $this->db->query($consultaId) or die("Error consultando el Id: ".mysqli_error($this->db));


			while($registroId = $registrosId->fetch_object())
			{
				//Actualizo la pizza mixta con los respectivos id_pizza de los sabores en PIZZA_MIXTA

				$consultaMixta = "INSERT INTO PIZZA_MIXTA(id_pizza_mixta, id_pizza)
									VALUES ($id_pizza, $registroId->id_pizza)";

	    		$registrosMixta = $this->db->query($consultaMixta) or die("Error Ingresando la pizza mixta: ".mysqli_error($this->db));
			}


		}


	}

	public function disminuirStockIngrediente(){
		//Para disminuir el stock necesito los ingredientes y la cantidad (gr).
		//Extraigo de la tabla X, los detalles de las pizzas que estén en estado Cocinando.
		//Necesito saber la categoria para ver como voy a tratar los ingredientes.
		//Necesito saber el nombre para ver que ingredientes y cantidad lleva en caso de ser predefinida
		//Necesito saber los detalles para ver como trato los ingredientes en caso de ser mixta o personalizada.
		//Necesito saber el tamaño para, en caso de ser mediana, dividir los ingredientes por 2.

		$consultaPizza = "SELECT nombre, detalles, categoria, tamanio FROM XXX WHERE estado = 'cocinando'";

	    $registrosPizza = $this->db->query($consultaPizza) or die("Error consultando las pizzas en horno: ".mysqli_error($this->db));

	    while($registroPizza = $registrosPizza->fetch_object())
	    {
	    	if( $registroPizza->categoria == 'mixtas' )
	    	{
	    		//Si la categoria es mixtas, entonces los detalles son los sabores (napolitana, muzzarella, etc)
	    		//La cantidad de cada ingrediente la extraigo de TIENE_INGREDIENTES, y va a estar alterada por: Tamaño de pizza, Tamaño porcion de sabor

	    	}elseif ( $registroPizza->categoria == 'personalizadas' )
	    	{
	    		//Si la categoria de la pizza es personalizada, entonces los detalles son ingredientes.
	    		//La cantidad de cada ingrediente es 30 gramos, y va a estar alterada por: Tamaño de pizza.

	    		foreach($datos['detalles'] as $ingrediente)
	    		{

	    		}

	    	}else
	    	{
	    		//Si la categoria no es mixta ni personalizada, entonces los detalles son ingredientes.
	    		//La cantidad de cada ingrediente la extraigo de TIENE_INGREDIENTES, y va a estar alterada por: Tamaño de pizza.

	    	}
	    }
	}


}

?>