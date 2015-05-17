<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Variepizzas - Pizzas</title>
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
					<li><a  href="index.html">INICIO</a></li>
					<li class="open"><a class="selected" href="pizzas.php">PIZZAS</a>
						<ul class="menu-desplegable">
							<li><a class="btn-enviarCategoria" id="predefinidas" href="#PizzasDeLaCasa">Pizzas de la casa</a></li>
							<li><a class="btn-enviarCategoria" id="veganas" href="#PizzasVeganas">Pizzas veganas</a></li>
							<li><a class="btn-enviarCategoria" id="celiacas" href="#">Pizzas celiácas</a></li>
							<li><a class="btn-enviarCategoria" id="infantiles" href="#">Pizzas infantiles</a></li>
							<li><a class="btn-enviarCategoria" id="mixtas" href="#">Pizzas mixtas</a></li>
							<li><a href="pizza-personalizada.html">Pizzas personalizadas</a></li>
						</ul>
					</li>
					<li><a href="index.html">DÓNDE ESTAMOS</a></li>
					<li><a href="index.html">CONTACTO</a></li>
				</ul>
			</nav>

			<div class="user-section">
				<a href="#iniciar-sesion" class="fancybox">INICIAR SESIÓN</a>
				
				<div class="carrito">
					<a href="carrito.html"><i class="icon-shopping-cart"></i></a>
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
			<input type="text" id="">
			<label>Contraseña:</label>
			<input type="password" id="pass">
			<a href="#" class="btn btn-success">Entrar</a>
			<a href="registro.html">¿No tenés cuenta? Registrate!</a>
		</form>
	</div>

	<div class="main">
		<div class="wrapper">
			<div class="fixed-menu">
				<ul>
					<li><a class="btn-enviarCategoria" id="predefinidas" href="#">Pizzas de la casa</a></li>
					<li><a class="btn-enviarCategoria" id="veganas" href="#">Pizzas veganas</a></li>
					<li><a class="btn-enviarCategoria" id="celiacas" href="#">Pizzas celiácas</a></li>
					<li><a class="btn-enviarCategoria" id="infantiles" href="#">Pizzas infantiles</a></li>
					<li><a class="btn-enviarCategoria" id="mixtas" href="#">Pizzas mixtas</a></li>
					<li><a href="pizza-personalizada.html">Pizzas personalizadas</a></li>
				</ul>
			</div>
			<div class="fixed-menu-small">
				<div class="ancho">
					<div class="title">
						<p>M</p>
						<p>E</p>
						<p>N</p>
						<p>Ú</p>
					</div>
					<div class="menu">
						<ul>
							<li><a class="btn-enviarCategoria" id="predefinidas" href="#">Pizzas de la casa</a></li>
							<li><a class="btn-enviarCategoria" id="veganas" href="#">Pizzas veganas</a></li>
							<li><a class="btn-enviarCategoria" id="celiacas" href="#">Pizzas celiácas</a></li>
							<li><a class="btn-enviarCategoria" id="infantiles" href="#">Pizzas infantiles</a></li>
							<li><a class="btn-enviarCategoria" id="mixtas" href="#">Pizzas mixtas</a></li>
							<li><a href="pizza-personalizada.html">Pizzas personalizadas</a></li>
						</ul>					
					</div>
				</div>
			</div>
			<div class="boxes">
				<?php 
					require_once("pizza_class.php");

					$pizza = new Pizza();
					$pizza->mostrarTodasPizzas();
				 ?>
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