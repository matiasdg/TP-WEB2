<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Variepizzas - Registro</title>
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
				<object data="images/logo.svg" type="image/svg+xml" id="svg">
				</object>
			</div>
			<nav>
				<ul>
					<li><a  href="index.php">INICIO</a></li>
					<li class="open"><a class="selected" href="pizzas.php">PIZZAS</a>
						<ul class="menu-desplegable">
							<li><a href="">Pizzas de la casa</a></li>
							<li><a href="">Pizzas veganas</a></li>
							<li><a href="">Pizzas celiácas</a></li>
							<li><a href="">Pizzas infantiles</a></li>
							<li><a href="">Pizzas mixtas</a></li>
							<li><a href="pizza-personalizada.php">Pizzas personalizadas</a></li>
						</ul>
					</li>
					<li><a  href="sucursales.php">DÓNDE ESTAMOS</a></li>
					<li><a  href="contacto.php">CONTACTO</a></li>
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
									<li><a href='#'>Cerrar sesión</a></li>
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
			<div class="registro">
				<form action="">
					<div class="form-box">
						<div class="form-left">
							<label for="nombre">Nombre</label>
							<input type="text" id="nombre">
						</div>
						
						<div class="form-left">
							<label for="apellido">Apellido</label>
							<input type="text" id="apellido">
						</div>
					</div>
					
					<div class="form-box">
						<div class="form-left">
							<label for="usuario">Nombre de usuario</label>
							<input type="text" id="usuario">
						</div>
					</div>

					<div class="form-box">
						<div class="form-left">
							<label for="contraseña">Contraseña</label>
							<input type="password" id="password">
						</div>
												
						<div class="form-left">
							<label for="contraseña">Confirme contraseña</label>
							<input type="password" id="repass">
						</div>
					</div>

					<div class="form-box">
						<div class="form-left">
							<div class="form-left-20">
								<label for="tipo">Tipo DNI</label>
								<select name="tipo_dni" id="tipo_dni">
									<option value="DNI">DNI</option>
									<option value="CI">CI</option>
									<option value="LC">LC</option>
								</select>
							</div>
							
							<div class="form-left-80">
								<label for="dni">Número DNI</label>
								<input type="text" id="numero_dni">
							</div>
						</div>
					</div>
					
					<div class="form-box">
						<div class="form-left">
							<label for="calle">Calle</label>
							<input type="text" id="calle">
						</div>
						
						<div class="form-left">
							<div class="form-left-45">
								<label for="altura">Altura</label>
								<input type="text" id="altura">
							</div>
							
							<div class="form-left-45">
								<label for="depto">Departamento</label>
								<input type="text" id="depto">
							</div>
						</div>
					</div>
										
					<div class="form-box">
						<div class="form-left">
							<label for="partido">Partido</label>
							<input type="text" id="partido">
						</div>
						
						<div class="form-left">
							<label for="provincia">Provincia</label>
							<select name="provincia" id="provincia">
								<option value="buenos aires">Buenos Aires</option>
								<option value="catamarca">Catamarca</option>
								<option value="chaco">Chaco</option>
								<option value="chubut">Chubut</option>
								<option value="cordoba">Córdoba</option>
								<option value="corrientes">Corrientes</option>
								<option value="entre rios">Entre Ríos</option>
								<option value="formosa">Formosa</option>
								<option value="jujuy">Jujuy</option>
								<option value="la pampa">La Pampa</option>
								<option value="la rioja">La Rioja</option>
								<option value="mendoza">Mendoza</option>
								<option value="misiones">Misiones</option>
								<option value="neuquen">Neuquén</option>
								<option value="rio negro">Río Negro</option>
								<option value="salta">Salta</option>
								<option value="san juan">San Juan</option>
								<option value="san luis">San Luis</option>
								<option value="santa cruz">Santa Cruz</option>
								<option value="santa fe">Santa Fé</option>
								<option value="santiago del estero">Santiago del Estero</option>
								<option value="tierra del fuego">Tierra del Fuego</option>
								<option value="tucuman">Tucumán</option>
							</select>
						</div>
					</div>

					<div class="form-box">
						<div class="form-left">
							<label for="telefono">Teléfono</label>
							<input type="text" id="telefono">
						</div>
												
						<div class="form-left">
							<label for="celular">Celular</label>
							<input type="text" id="celular">
						</div>
					</div>
										
					<div class="form-box">
						<div class="form-left">
							<label for="mail">E-Mail</label>
							<input type="text" id="mail">
						</div>
					</div>

					<div class="btn-box">
						<a href="#" class="btn-form " id="registrarUsuario">REGISTRARSE</a>
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