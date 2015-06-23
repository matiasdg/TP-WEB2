<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Variepizzas - Administrador</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="fonts/style.css">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="icon" type="image/png" href="images/favicon-32.png" sizes="32x32">

</head>
<body>
	<div class="bg">
		<ul>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>
	<header>
		<div class="wrapper">
			<div class="logo">
				<object data="images/logo.svg" type="image/svg+xml"></object>
			</div>
			<nav>
				<ul>
					<li><a href="index.php">INICIO</a></li>
					<li class="open"><a class="selected" href="pizzas.php">PIZZAS</a>
						<ul class="menu-desplegable">
							<li><a class="btn-enviarCategoria" id="predefinidas" href="#PizzasDeLaCasa">Pizzas de la casa</a></li>
							<li><a class="btn-enviarCategoria" id="veganas" href="#PizzasVeganas">Pizzas veganas</a></li>
							<li><a class="btn-enviarCategoria" id="celiacas" href="#PizzasCeliacas">Pizzas celiácas</a></li>
							<li><a class="btn-enviarCategoria" id="infantiles" href="#PizzasInfantiles">Pizzas infantiles</a></li>
							<li><a class="btn-enviarCategoria" id="mixtas" href="#PizzasMixtas">Pizzas mixtas</a></li>
							<li><a href="pizza-personalizada.php">Pizzas personalizadas</a></li>
						</ul>
					</li>
					<li><a href="sucursales.php">DÓNDE ESTAMOS</a></li>
					<li><a href="contacto.php">CONTACTO</a></li>
				</ul>
			</nav>

			<div class="user-section">
				<?php
					session_start();

					require ("inc/class/sistema_class.php");

					$sistema = new Sistema();

					if (isset($_SESSION['usuario'])){

						if( $sistema->esAdministrador($_SESSION['usuario']) )
						{

					    echo 
					    "<ul class='usuario-menu'>
					    	<li id='open-menu-usuario'>
					    		<a href='#' id='usuario'>".$_SESSION['usuario']."</a>
							    <ul class='usuario-menu-desplegable'>
									<li><a href='#cerrarSesion' id='cerrarSesion'>Cerrar sesión</a></li>
							    </ul>					    		
					    	</li>
					    </ul> ";

						}else
						{
							echo "false";
							header("Location: accesoNoAutorizado.php"); 
							exit(); 
						}

					}else{
						echo "false";
						header("Location: accesoNoAutorizado.php"); 
						exit(); 
					}

				?>
				
				<div class="carrito">
					<a href="carrito.php"><i class="icon-shopping-cart"></i></a>
				</div>
			</div>
		</div>
	</header>
	<div id="iniciar-sesion">
		<div class="title">
			<p>INICIAR SESIÓN</p>
		</div>
		<form action="">
			<label>Mail o Nombre de usuario:</label>
			<input type="text" id="mail-usuario">
			<label>Contraseña:</label>
			<input type="password" id="pass">
			<a href="#" class="btn btn-success" id="iniciarSesion">Entrar</a>
			<a href="registro.php">¿No tenés cuenta? Registrate!</a>
		</form>
	</div>

	<div class="main">
		<div class="wrapper">
			<div class="agregar-pizza">
				<div class="title">
					<p>AGREGAR PIZZA</p>
				</div>
				<form action="inc/controller/agregarPizza.php" method="post" enctype="multipart/form-data">

					<div class="agregar-pizza-nombre">
						<label for="nombre">Nombre</label>
						<input type="text" id="pizzaNueva-nombre" required>
					</div>

					<div class="agregar-pizza-nombre">
						<label for="categoria">Categoría</label>
						<select name="pizzaNueva-categoria" id="pizzaNueva-categoria" required>
							<option value="predefinidas">Predefinidas</option>
							<option value="veganas">Veganas</option>
							<option value="celiacas">Celiacas</option>
							<option value="mixtas">Mixtas</option>
							<option value="infantiles">Infantiles</option>
						</select>
					</div>

					<div class="agregar-pizza-imagen">
						<label for="imagen">Imagen</label>
						<input type="file" id="pizzaNueva-imagen" accept="image/jpeg" required>
					</div>

					<div class="agregar-pizza-sabores">
						<label for="imagen">Sabores</label>
						<ul>
							<li>
								<input type="checkbox" id="checkSabor-1" class="checkSabor" />
								<select name="sabores1" id="sabores1" disabled="disabled" class="selectSaborAdmin">
									<option value=null disabled selected>Seleccione</option>
									<?php 
										require_once('inc/class/pizza_class.php');

										$pizza = new Pizza();
										$pizza->getSaboresExceptoMixta();
									 ?>
								</select>
							</li>
							<li>
								<input type="checkbox" id="checkSabor-2" class="checkSabor" />
								<select name="sabores2" id="sabores2" disabled="disabled" class="selectSaborAdmin">
									<option value=null disabled selected>Seleccione</option>
									<?php 
										require_once('inc/class/pizza_class.php');

										$pizza = new Pizza();
										$pizza->getSaboresExceptoMixta();
									 ?>
								</select>
							</li>
							<li>
								<input type="checkbox" id="checkSabor-3" class="checkSabor" />
								<select name="sabores3" id="sabores3" disabled="disabled" class="selectSaborAdmin">
									<option value=null disabled selected>Seleccione</option>
									<?php 
										require_once('inc/class/pizza_class.php');

										$pizza = new Pizza();
										$pizza->getSaboresExceptoMixta();
									 ?>
								</select>								
							</li>
							<li>
								<input type="checkbox" id="checkSabor-4" class="checkSabor"/>
								<select name="sabores4" id="sabores4" disabled="disabled" class="selectSaborAdmin">
									<option value=null disabled selected>Seleccione</option>
									<?php 
										require_once('inc/class/pizza_class.php');

										$pizza = new Pizza();
										$pizza->getSaboresExceptoMixta();
									 ?>
								</select>								
							</li>
						</ul>
					</div>

					<div class="agregar-pizza-ingredientes">
						<label for="ingredientes">Ingredientes</label>
						<ul>
							<?php
								require_once ("inc/class/pizza_class.php");
								$pizza = new Pizza();

								$pizza->obtenerIngredientes();
						 	?>								
						</ul>
					</div>
					
					<div class="agregar-pizza-precio">
						<label for="precio">Precio</label>
						<span>$</span>
						<span id="precio-dinamico">0</span>
						<span>+</span>
						<input type="text" id="pizzaNueva-precio" value="0">
						<span> = $</span>
						<span id="precio-dinamico-total">0</span>
					</div>


					<div class="center">
						<a href="#" class="btn btn-success" id="agregarPizzaAdmin">Agregar Pizza</a>
					</div>
				</form>
			</div>
			
		</div>

	</div>

	<footer>
		<div class="wrapper">
			<div class="social">
				<a href="#"><i class="icon-facebook"></i></a>
				<a href="#"><i class="icon-twitter"></i></a>
			</div>
			<div class="info">
				<p>VARIEPIZZAS</p>
			</div>
			<div class="desarrollo">
				<p>Desarrollado por</p><a href="#"> MGL</a>
			</div>
		</div>
	</footer>	
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/main.js"></script>
<script src="js/server.js"></script>
<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

<!-- Add fancyBox -->
<link rel="stylesheet" href="fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>	
</body>
</html>