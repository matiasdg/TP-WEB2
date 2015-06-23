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
				if(!isset($_SESSION)){
				    session_start();
				}
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
			<div class="carrito">
			<?php 
				require ("inc/class/carrito_class.php");

				$carrito = new Carrito();
				$carrito->mostrarProductos();
			 ?>
			</div>

			<div id="confirmacion">
				<div class="title">
					<p>CONFIRMAR COMPRA</p>
				</div>
				<form action="">
					<p>Indique dónde desea recibir su compra</p>

					<label for="calle">Calle</label>
					<input type="text" id="calle">

					<div class="tabla">
						<div class"col-50">
							<label for="altura">Altura</label>
							<input type="text" id="altura">
						</div>
						<div class="col-50">
							<label for="depto">Departamento</label>
							<input type="text" id="depto">
						</div>
					</div>

					<div class="demora-info">
						<a href="#" class="btn btn-info" id="calcularDemora">Calcular tiempo de demora</a>
					</div>

					<a href="#metodo-pago" class="btn btn-success btn-submit" id="encargar">Siguiente paso</a>

				</form>
			</div>


			<div id="metodo-pago">
				<div class="title">
					<p>CONFIRMAR COMPRA</p>
				</div>
				<form action="">
					<p>Indique el modo de pago</p>

					<div class="tabla">
						<div class"col-50">
							<input type="radio" name="modo-pago" id="pago-tarjeta" value="radio-tarjeta" >
							<label for="tarjeta">Tarjeta de crédito</label>
							<input type="text" id="tarjeta" disabled>
						</div>
						<div class="col-50">
							<input type="radio" name="modo-pago" value="input-efectivo" checked>
							<label for="efectivo">Efectivo</label>
						</div>
					</div>

					<a href="#" class="btn btn-success btn-submit" id="confirmar-pago">Siguiente paso</a>

				</form>
			</div>


			<div id="confirmar-datos">
				<div class="title">
					<p>CONFIRMAR COMPRA</p>
				</div>
				<form action="">
					<div class="confirmar-info">
						<p>Por favor, lea aténtamente si los datos son correctos antes de confirmar la compra.</p>
						<p>Al confirmar la compra obtendrá un comprobante con los datos correspondientes.</p>
					</div>

					<div class="tabla">
						<div class="confirmar-title-seccion">
							<p>Datos Personales</p>
						</div>

						<div class"col-50">
							<label for="tarjeta">Nombre</label>
							<p id="confirmar-nombre">Juan</p>
						</div>
						<div class="col-50">
							<label for="efectivo">Apellido</label>
							<p id="confirmar-apellido">Pérez</p>
						</div>
						<label for="usuario">Usuario</label>
						<p id="confirmar-usuario">JuanP</p>
						<label for="tipo-dni">Tipo de documento</label>
						<p id="confirmar-tipo_dni">DNI</p>
						<label for="dni">Número de documento</label>
						<p id="confirmar-numero_dni">20987237</p>
						<label for="calle">Calle</label>
						<p id="confirmar-calle">Calle Falsa</p>
						<label for="altura">Altura</label>
						<p id="confirmar-altura">123</p>
						<label for="departamento">Departamento</label>
						<p id="confirmar-depto">9</p>
						<label for="partido">Partido</label>
						<p id="confirmar-partido">Moron</p>
						<label for="provincia">Provincia</label>
						<p id="confirmar-provincia">Buenos Aires</p>
						<label for="telefono">Teléfono</label>
						<p id="confirmar-telefono">47783219</p>
						<label for="celular">Teléfono personal</label>
						<p id="confirmar-celular">15783982</p>
						<label for="mail">Email</label>
						<p id="confirmar-mail">juanperez@it</p>
						
						<!-- Datos del domicilio de la entrega -->
						<div class="domicilio-confirmar">
							<div class="confirmar-title-seccion">
								<p>Domicilio de entrega</p>
							</div>

							<label for="calle">Calle</label>
							<p id="confirmar-calle-encargo">Calle Falsa</p>
							<label for="altura">Altura</label>
							<p id="confirmar-altura-encargo">1213</p>
							<label for="departamento">Departamento</label>
							<p id="confirmar-depto-encargo">23</p>
						</div>

					</div>

					<a href="#" class="btn btn-success btn-submit" id="encargar-confirmar">Confirmar compra</a>

				</form>
			</div>

			<div id="mensaje-compra">
				<p>Compra realizada!</p>
				<p>Se le ha enviado el comprobante por mail.</p>
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