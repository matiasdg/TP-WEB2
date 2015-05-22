<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Variepizzas - Carrito</title>
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
							<li><a class="btn-enviarCategoria" id="celiacas" href="#">Pizzas celiácas</a></li>
							<li><a class="btn-enviarCategoria" id="infantiles" href="#">Pizzas infantiles</a></li>
							<li><a class="btn-enviarCategoria" id="mixtas" href="#">Pizzas mixtas</a></li>
							<li><a href="pizza-personalizada.php">Pizzas personalizadas</a></li>
						</ul>
					</li>
					<li><a href="sucursales.php">DÓNDE ESTAMOS</a></li>
					<li><a href="contacto.php">CONTACTO</a></li>
				</ul>
			</nav>

			<div class="user-section">
				<?php
					if (isset($_SESSION['usuario'])){
					    echo "<p>".$_SESSION['usuario']."</p>";
					}else{
					    echo "<a href='#iniciar-sesion' class='fancybox'>INICIAR SESIÓN</a>";
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
			<div class="carrito">
			<?php 
				require ("inc/class/carrito_class.php");

				$carrito = new Carrito();
				$carrito->mostrarProductos();
			 ?>
				<div class="controles">
					<a class='btn btn-warning' href='#' id='cancelar-productos-carrito'>Cancelar</a>
					<a class="btn btn-warning" href="#" id="eliminar-productos-carrito">Eliminar Productos</a>
					<a class="btn btn-success fancybox" href="#confirmacion" id="confirmar-productos-carrito">Confirmar Productos</a>
				</div>
			</div>

			<div id="confirmacion">
				<div class="title">
					<p>CONFIRMAR COMPRA</p>
				</div>
				<form action="">
					<p>Indique dónde desea recibir su compra</p>

					<label for="calle">Calle</label>
					<input type="text">

					<div class="tabla">
						<div class"col-50">
							<label for="">Numero</label>
							<input type="text">
						</div>
						<div class="col-50">
							<label for="">Depto</label>
							<input type="text">
						</div>
					</div>

					<label for="">Localidad</label>
					<input type="text">
					<label for="">Partido</label>
					<select name="partido" id="">
						<option value="">Seleccione</option>
						<option value=""></option>
						<option value=""></option>
					</select>

					<div class="demora-info">
						<p>El tiempo mínimo de demora es <span>14hs</span></p>
					</div>

					<a href="#" class="btn btn-success btn-submit">Confirmar y Encargar</a>

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