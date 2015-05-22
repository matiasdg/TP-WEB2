$(document).ready(function(){

	$(".btn-enviarCategoria").click(enviarCategoria);
	$("#registrarUsuario").click(registrarUsuario);
	$("#iniciarSesion").click(iniciarSesion);
	$(".checkSabor").click(activarSabor);
	$(".selectSabor").change(cargarDetallesMixta);
	$("input[name=tamanio]").click(cargarDetallesMixta);
	$("#agregarCarrito-Mixta").click(agregarCarritoMixta);
	$("#agregarCarrito-Predefinida").click(agregarCarritoPredefinida);
	$("input[name=tamanio-predefinida]").click(actualizarPrecioPredefinida);
	$("#agregarCarrito-Personalizada").click(agregarCarritoPersonalizada);
	$(".input-ing").click(actualizarIngredientesPersonalizada);



});


function enviarCategoria(){
	var categoria = $(this).attr('id');
	var pathname = window.location.pathname;
	var pathname_array = pathname.split("/");
	var last = pathname_array[pathname_array.length - 1];
	
	//Si al clickear en una categoría del menú, no me encuentro en la página pizza.php, me redirijo a ella.
	if(last != "pizzas.php")
	{
		document.location.href = "pizzas.php";
	}

	//Con el método GET le envío la variable categoría a recibirCategoria.php, y proceso el resultado en cargarCategoria
	$.get( "inc/controller/recibirCategoria.php", { categoria: categoria}, cargarCategoria );
}

//Los datos recibidos se cargan en .boxes.
function cargarCategoria(data){
	$(".boxes").html(data);
}


function registrarUsuario(){
	var datos = {}; 

	datos.nombre = $("#nombre").val();
	datos.apellido = $("#apellido").val();
	datos.usuario = $("#usuario").val();
	datos.pass = $("#pass").val();
	datos.repass = $("#repass").val();
	datos.tipo_dni = $("#tipo_dni").val();
	datos.numero_dni = $("#numero_dni").val();
	datos.calle = $("#calle").val();
	datos.altura = $("#altura").val();
	datos.depto = $("#depto").val();
	datos.partido = $("#partido").val();
	datos.provincia = $("#provincia").val();
	datos.telefono = $("#telefono").val();
	datos.celular = $("#celular").val()
	datos.mail = $("#mail").val();

	var datosJSON = JSON.stringify(datos);

	//Con el método GET le envío las a registrarUsuario.php, y proceso el resultado en verMensajeRegistroUsuario().
	$.get( "inc/controller/registrarUsuario.php", { datos : datosJSON }, verMensajeRegistroUsuario );
}

function verMensajeRegistroUsuario(dato){
	$.fancybox(dato);
}

function iniciarSesion(){
	console.log("iniciar sesion");
	var mailUsuario = $("#mail-usuario").val();
	var pass = $("#pass").val();


	$.get( "inc/controller/iniciarSesion.php", { mailUsuario : mailUsuario, pass : pass }, verMensajeIniciarSesion );
}

function verMensajeIniciarSesion(dato){
	$.fancybox(dato);
}


function activarSabor(){
	var select = $(this).next();
	
	if( $(this).is(":checked") == true )
	{
		select.attr('disabled', false);

	}else
	{
		select.attr('disabled', true);
		select.val("null");
		actualizarPrecio();
	}
}

function cargarDetallesMixta(){
	var sabor;
	var sabores = [];


	$( ".selectSabor:enabled option:selected" ).each(function(){
		sabor = "'" + $(this).val() + "'";
		sabores.push(sabor);

		//Desactivar los restantes sabores que ya fueron elegidos.
	});

	var tamanio = $('input:radio[name="tamanio"]:checked').val();

	var saboresJSON = JSON.stringify(sabores);

	$.get( "inc/controller/cargarPrecioMixta.php", { sabores : saboresJSON, tamanio : tamanio }, actualizarPrecio );
}

function agregarCarritoMixta(){
	var datos = {};
	var sabor;
	var sabores = [];

	datos.tamanio = $('input:radio[name="tamanio"]:checked').val();
	datos.precio = $(".precio p span").text();
	datos.nombre = "mixta"; 


	$( ".selectSabor:enabled option:selected" ).each(function(){
		sabor = $(this).val();
		sabores.push(sabor);

		//Desactivar los restantes sabores que ya fueron elegidos.
	});

	datos.detalles = sabores;

	console.log(datos);

	var datosJSON = JSON.stringify(datos);

	$.get( "inc/controller/agregarCarrito.php", { datos : datosJSON }, recibirMensajeAgregadoCarrito );
}

function agregarCarritoPredefinida(){
	var datos = {};
	var ingrediente;
	var ingredientes = [];

	datos.tamanio = $('input:radio[name="tamanio-predefinida"]:checked').val();
	datos.precio = $(".precio p span").text();
	datos.nombre = $(".pizza > p").text(); 


	$( ".ingredientes ul li" ).each(function(){
		ingrediente = $(this).text();
		ingredientes.push(ingrediente);
	});

	datos.detalles = ingredientes;

	var datosJSON = JSON.stringify(datos);

	$.get( "inc/controller/agregarCarrito.php", { datos : datosJSON }, recibirMensajeAgregadoCarrito );
}


function actualizarPrecioPredefinida(){
	var codigo = $(".pizza p").attr('id');
	
	var tamanio = $('input:radio[name="tamanio-predefinida"]:checked').val();
	console.log(tamanio);
	$.get( "inc/controller/cargarPrecioPredefinida.php", { codigo : codigo, tamanio : tamanio }, actualizarPrecio );
}

function actualizarPrecio(dato){
	$(".precio p span").html(dato);
}

function agregarCarritoPersonalizada(){
	console.log("hola");
	var datos = {};
	var ingrediente;
	var ingredientes = [];
	var masa;

	datos.tamanio = $('input:radio[name="tamanio-personalizada"]:checked').val();
	datos.precio = $(".precio p span").text();
	datos.nombre = $(".pizza > p").text();  

	masa = $('input:radio[name="masa"]:checked').val();
	ingredientes.push(masa);

	//Recorrer cada checkbox seleccionado y guardar el valor en ingredientes
	$( "input:checkbox[name='ingredientes']:checked" ).each(function(){

		console.log("esta check");
		ingrediente = $(this).attr('id');
		ingredientes.push(ingrediente);	

	});


	datos.detalles = ingredientes;

	var datosJSON = JSON.stringify(datos);

	$.get( "inc/controller/agregarCarrito.php", { datos : datosJSON }, recibirMensajeAgregadoCarrito );
	return false;	
}

function recibirMensajeAgregadoCarrito(dato){
	$.fancybox(dato);
}


function actualizarIngredientesPersonalizada(){
	var datos = {};
	var ingredientes = [];
	var ingrediente;
	var masa;

	//Cada vez que se clickee la masa o algún ingrediente, el precio va a cambiar.
	//Enviar los datos que están seleccionados por un array a php para calcular el precio.
	masa = "'" +  $('input:radio[name="masa"]:checked').val() + "'";
	ingredientes.push(masa);
	datos.tamanio = $('input:radio[name="tamanio-personalizada"]:checked').val();


	$( "input:checkbox[name='ingredientes']:checked" ).each(function(){

		ingrediente = "'" + $(this).attr("id") + "'";
		ingredientes.push(ingrediente);	

	});

	datos.detalles = ingredientes;

	var datosJSON = JSON.stringify(datos);

	$.get( "inc/controller/actualizarPrecioPersonalizada.php", { datos : datosJSON }, actualizarPrecio );
}
