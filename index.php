<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Variepizzas - Inicio</title>
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
					session_start();

					if (isset($_SESSION['usuario'])){
					    echo 
					    "<ul class='usuario-menu'>
					    	<li id='open-menu-usuario'>
					    		<a href='#' id='usuario'>".$_SESSION['usuario']."</a>
							    <ul class='usuario-menu-desplegable'>
									<li><a href='#cerrarSesion' id='cerrarSesion'>Cerrar sesión</a></li>
							    </ul>					    		
					    	</li>
					    </ul> ";
					}else{
					    echo "<a href='#iniciar-sesion' class='iniciar-sesion-box'>INICIAR SESIÓN</a>";
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
			<div class="slider-box">
				<div class="slider">
					<ul>
						<li id="slider-promocion"><img src="images/slider/imagen1.jpg" alt=""></li>
						<li id="slider-armaPizza"><img src="images/slider/imagen2.jpg" alt=""></li>
						<li id="slider-mixtaPizza"><img src="images/slider/imagen3.jpg" alt=""></li>
					</ul>
				</div>
				<div class="slider-controles">
					<ul>
						<li></li>
						<li></li>
						<li></li>
					</ul>
				</div>
			</div>
			<div class="menu">
				<div class="item">
					<div class="pizza">
						<img src="images/pizzas/predefinidas/napolitana.jpg" alt="">
						<div class="oculto">
							<a href='pizzas.php?categoria=predefinidas'><i class='icon-circle-with-plus btn-enviarPizza'></i></a>
						</div>
					</div>
					<div class="name">
						<div class="horizontal-center">
							<p>DE LA CASA</p>
						</div>
					</div>						
				</div>
				<div class="item">
					<div class="pizza">
						<img src="images/pizzas/veganas/espinaca.jpg" alt="">
						<div class="oculto">
							<a href='pizzas.php?categoria=veganas'><i class='icon-circle-with-plus btn-enviarPizza'></i></a>
						</div>
					</div>
					<div class="name">
						<div class="horizontal-center">
							<p>VEGANAS</p>
						</div>
					</div>						
				</div>
				<div class="item">
					<div class="pizza">
						<img src="images/pizzas/celiacas/celiaca vegana.jpg" alt="">
						<div class="oculto">
							<a href='pizzas.php?categoria=celiacas'><i class='icon-circle-with-plus btn-enviarPizza'></i></a>
						</div>
					</div>
					<div class="name">
						<div class="horizontal-center">
							<p>CELIACAS</p>
						</div>
					</div>						
				</div>
				<div class="item">
					<div class="pizza">
						<img src="images/pizzas/infantiles/superman.jpg" alt="">
						<div class="oculto">
							<a href='pizzas.php?categoria=infantiles'><i class='icon-circle-with-plus btn-enviarPizza'></i></a>
						</div>
					</div>
					<div class="name">
						<div class="horizontal-center">
							<p>INFANTILES</p>
						</div>
					</div>						
				</div>
				<div class="item">
					<div class="pizza">
						<img src="images/pizzas/mixtas/cuatro estaciones.jpg" alt="">
						<div class="oculto">
							<a href='pizzas.php?categoria=mixtas'><i class='icon-circle-with-plus btn-enviarPizza'></i></a>
						</div>
					</div>
					<div class="name">
						<div class="horizontal-center">
							<p>MIXTAS</p>
						</div>
					</div>						
				</div>
				<div class="item">
					<div class="pizza">
						<img src="images/pizzas/personalizadas/pizza1.jpg" alt="">
						<div class="oculto">
							<a href='pizza-personalizada.php'><i class='icon-circle-with-plus btn-enviarPizza'></i></a>
						</div>
					</div>
					<div class="name">
						<div class="horizontal-center">
							<p>ARMÁ A TU GUSTO</p>
						</div>
					</div>						
				</div>
			</div>

			<div class="mapa">
				<div id="map">
					
				</div>
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
<script src="js/maps.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>	

<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

<!-- Add fancyBox -->
<link rel="stylesheet" href="fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
</body>
</html>