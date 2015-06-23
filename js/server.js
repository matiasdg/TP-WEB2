$(document).ready(function(){
	datosCorrectos = false;
	puedoModificar = false;



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
	$("#calcularDemora").click(calcularDemora);
	$("#encargar").click(encargarProductos);
	$("#confirmar-pago").click(confirmarPago);
	$("#encargar-confirmar").click(confirmarDatos);
	$("#pago-tarjeta").click(habilitarModoPago);
	$("#cerrarSesion").click(cerrarSesion);
	$(".input-ing-admin").click(habilitarCantidad);
	$(".cantidad").keyup(cargarIngredientePizza);
	$("#pizzaNueva-precio").keyup(actualizarNuevoPrecio);
	$("#agregarPizzaAdmin").click(agregarPizzaAdmin);
	$(".eliminarPizzaAdmin").click(eliminarPizzaAdmin);
	$(".eliminarIngredienteAdmin").click(eliminarIngredienteAdmin);
	$("#agregarIngredienteAdmin").click(agregarIngredienteAdmin);
	$("#cancelarIngrediente").click(cancelarIngrediente);
	$("#agregarIngrediente").click(agregarIngrediente);
	$(".modificarIngredienteAdmin").click(modificarIngredienteAdmin);
	$("#modificarPizzaAdmin").click(modificarPizzaAdmin);
	$("#pizzaNueva-categoria").change(verificarCategoriaPizzaNueva);
	$(".selectSaborAdmin").change(cargarPrecioMixtaAdmin);
	$(".btn-disabled").click(function(event){event.preventDefault();});


});


function enviarCategoria(){
	var categoria = $(this).attr('id');
	var pathname = window.location.pathname;
	var pathname_array = pathname.split("/");
	var last = pathname_array[pathname_array.length - 1];

	//Si al clickear en una categoría del menú, no me encuentro en la página pizza.php, me redirijo a ella.
	if( !last.includes("pizzas.php") )
	{
		document.location.href = "pizzas.php?categoria=" + categoria;
	}
	


	//Con el método GET le envío la variable categoría a recibirCategoria.php, y proceso el resultado en cargarCategoria
	$.get( "inc/controller/recibirCategoria.php", { categoria: categoria}, cargarCategoria );
}

//Los datos recibidos se cargan en .boxes.
function cargarCategoria(data){

		
	$(".boxes").html(data);
}


function registrarUsuario(event){
	event.preventDefault();
	var datos = {}; 

	datos.nombre = $("#nombre").val();
	datos.apellido = $("#apellido").val();
	datos.usuario = $("#usuario").val();
	datos.pass = $("#password").val();
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

	console.log(datosJSON);

	//Con el método GET le envío las a registrarUsuario.php, y proceso el resultado en verMensajeRegistroUsuario().
	$.get( "inc/controller/registrarUsuario.php", { datos : datosJSON }, verMensajeRegistroUsuario );
}

function verMensajeRegistroUsuario(dato){
	$.fancybox(dato);
}

function iniciarSesion(){
	
	var mailUsuario = $("#mail-usuario").val();
	var pass = $("#pass").val();
	console.log(pass);


	$.get( "inc/controller/iniciarSesion.php", { mailUsuario : mailUsuario, pass : pass }, verMensajeIniciarSesion );
}

function verMensajeIniciarSesion(dato){
	var datos = JSON.parse(dato);

	if(datos.valido == true)
	{
		location.reload();
	}else
	{
		$.fancybox(datos.mensaje);

	}
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
		cargarPrecioMixtaAdmin();
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

	console.log(sabores);

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


function calcularDemora(){
	//Tomo los datos de los inputs.
	datos = {};
	datos.calle = $("#calle").val();
	datos.altura = $("#altura").val();
	datos.depto = $("#depto").val();

	var datosJSON = JSON.stringify(datos);

	$.get( "inc/controller/procesarDatosDomicilio.php", { datos : datosJSON }, recibirRespuestaDomicilio );
	
}


 function recibirRespuestaDomicilio(dato){
    // Convierto la cadena enviada desde PHP a un vector de objetos en JavaScript
	 var datos = JSON.parse(dato);

	
	 if(datos['datosCorrectos'] == true)
	 {
	 	//Si los datos son correctos procedo a calcular la distancia.

	 	//Generar una variable con el punto donde se encuentra el local.

	 	//Generar una variable con el punto donde se encuentra la dirección de la entrega

	 	//Googlemapear

	 	//Suponiendo que el domicilio se encuentra dentro del radio, entonces:
	 	domiciloPermitido = true;

	 }else
	 {
	 	//Si los datos no son correctos, muestro el mensaje correspondiente.
	 	$(".demora-info").html("<p>" + datos['mensaje'] + "</p>");
	 }

}

function encargarProductos(){
	//Tomo los datos de los inputs.
	datos = {};
	datos.calle = $("#calle").val();
	datos.altura = $("#altura").val();
	datos.depto = $("#depto").val();

	var datosJSON = JSON.stringify(datos);

	$.get( "inc/controller/procesarDatosDomicilio.php", { datos : datosJSON }, recibirRespuestaEncargo );
}

function recibirRespuestaEncargo(dato){

    // Convierto la cadena enviada desde PHP a un vector de objetos en JavaScript
	 var datos = JSON.parse(dato);

	
	 if(datos['datosCorrectos'] == true)
	 {

	 	//Generar una variable con el punto donde se encuentra el local.

	 	//Generar una variable con el punto donde se encuentra la dirección de la entrega

	 	//Googlemapear distancia entre dos puntos y calcular tiempo de llegada + tiempo de horno x cantidad de pizzas

	 	//Suponiendo que el domicilio se encuentra dentro del radio, entonces:
	 	domiciloPermitido = true;

	 	//Si el domicilio es permitido, entonces puedo encargar los productos
	 	//Se abre una caja eligiendo el modo de pago
		 $.fancybox({
	        href: "#metodo-pago"
	    });

	 }else
	 {
	 	//Si los datos no son correctos, muestro el mensaje correspondiente.
	 	$(".demora-info").html("<p>" + datos['mensaje'] + "</p>");
	 }	
}


function confirmarPago(){
	//Si no hay una sesión iniciada, abrir la ventana de iniciar sesión

	$.get( "inc/controller/verificarSesionIniciada.php", {}, recibirRespuestaVerificarSesion );
}

function recibirRespuestaVerificarSesion(dato){
	var datos = JSON.parse(dato);


	if(datos.sesionIniciada == true)
	{
		//Si sesionIniciada es true, procedo a abrir otro fancybox con los datos del usuario, y el boton CONFIRMAR Y ENCARGAR
		 
		 $("#confirmar-nombre").text(datos.datosUsuario.nombre);
		 $("#confirmar-apellido").text(datos.datosUsuario.apellido);
		 $("#confirmar-usuario").text(datos.datosUsuario.usuario);
		 $("#confirmar-tipo_dni").text(datos.datosUsuario.tipo_dni);
		 $("#confirmar-numero_dni").text(datos.datosUsuario.numero_dni);
		 $("#confirmar-calle").text(datos.datosUsuario.calle);
		 $("#confirmar-altura").text(datos.datosUsuario.altura);
		 $("#confirmar-depto").text(datos.datosUsuario.depto);
		 $("#confirmar-partido").text(datos.datosUsuario.partido);
		 $("#confirmar-provincia").text(datos.datosUsuario.provincia);
		 $("#confirmar-telefono").text(datos.datosUsuario.telefono);
		 $("#confirmar-celular").text(datos.datosUsuario.celular);
		 $("#confirmar-mail").text(datos.datosUsuario.email);

		 $("#confirmar-calle-encargo").text( $("#calle").val() );
		 $("#confirmar-altura-encargo").text( $("#altura").val() );
		 $("#confirmar-depto-encargo").text( $("#depto").val() );


		 $.fancybox({
	        href: "#confirmar-datos"
	    });
	}else
	{
		//Si sesionIniciada es false, abro la ventana de Iniciar Sesión.
		 $.fancybox({
	        href: "#iniciar-sesion"
	    });
	}

}


function confirmarDatos(){
	//Envío los datos del pago y domicilio a realizarCompra.php

	var datos = {};

	datos.calle = $("#calle").val();
	datos.altura = $("#altura").val();
	datos.depto = $("#depto").val();
	datos.pago = $('input:radio[name="modo-pago"]:checked').val();
	datos.numeroTarjeta = $("#tarjeta").val();

	var datosJSON = JSON.stringify(datos);

	$.get( "inc/controller/realizarCompra.php", {datos : datosJSON }, actualizarPagina);
}

function actualizarPagina(dato){
	 $.fancybox({
        href: "#mensaje-compra"
    });
}

function habilitarModoPago(){
	var tarjeta = $("#tarjeta");
	
	if( $(this).is(":checked") == true )
	{
		tarjeta.attr('disabled', false);

	}else
	{
		tarjeta.attr('disabled', true);
		tarjeta.val("null");
	}	
}

function cerrarSesion(){
	var dato;

	$.get("inc/controller/obtenerHash.php",
	function(data){
		dato = data;
		$.get( "inc/controller/cerrarSesion.php", {dato : dato }, actualizarPaginaSesion);
	});
}

function actualizarPaginaSesion(dato){
	location.reload();
}

function habilitarCantidad(){
	var label = $(this).next();
	var input = label.next();
	
	if( $(this).is(":checked") == true )
	{
		input.attr('disabled', false);

	}else
	{
		input.attr('disabled', true);
		input.val("");
		cargarIngredientePizza();
	}	
}

function cargarIngredientePizza(){
	//Tomo el valor
	var datos = [];
	var id_ingrediente;
	var cantidad;

	$( ".cantidad:enabled" ).each(function(){

		id_ingrediente = $(this).attr("id");
		cantidad = $(this).val();

		datos.push({'id_ingrediente': id_ingrediente, 'cantidad': cantidad});	

	});


	var datosJSON = JSON.stringify(datos);


	$.get( "inc/controller/cargarPrecioIgrediente.php", 
		{ datos : datosJSON }, 
		function(dato){
			$("#precio-dinamico").text(dato);
			actualizarNuevoPrecio();
	} );

}

function actualizarNuevoPrecio(){

	var precioDinamico = parseFloat( $("#precio-dinamico").text() );
	var precioInput = parseFloat( $("#pizzaNueva-precio").val() );

	var total = precioDinamico + precioInput;

	$("#precio-dinamico-total").text(total);
}

function agregarPizzaAdmin(){
    var form_data = new FormData();
 	var file_data = $('#pizzaNueva-imagen').prop('files')[0];   
    var nombre = $("#pizzaNueva-nombre").val();
    var categoria = $("#pizzaNueva-categoria").val();
    var precio = $("#precio-dinamico-total").text();
    var id_ingrediente;
	var cantidad;
	var sabores = [];
	var ingredientes = [];
	var contIngredientes;
	var contSabores;

    form_data.append('file', file_data);
    form_data.append('nombre', nombre);
    form_data.append('categoria', categoria);
    form_data.append('precio', precio);

    
	$( ".cantidad:enabled" ).each(function(){
		contIngredientes++;

		id_ingrediente = $(this).attr("id");
		cantidad = $(this).val();

		ingredientes.push({'id_ingrediente': id_ingrediente, 'cantidad': cantidad});	
	});

	$( ".selectSaborAdmin:enabled option:selected" ).each(function(){
		contSabores++;
		sabor = $(this).val();
		sabores.push(sabor);
	});

	var sabores = JSON.stringify(sabores);
	
	var ingredientes = JSON.stringify(ingredientes);

	if(categoria == "mixtas")
	{
    	form_data.append('sabores', sabores);
	}else
	{
    	form_data.append('ingredientes', ingredientes);
	}

    $.ajax({
                url: 'inc/controller/agregarPizza.php', // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(dato){
                    document.location.href = "pizzasAdmin.php";
                }
     });
}

function eliminarPizzaAdmin(event){
	event.preventDefault();
	var id = $(this).closest("tr").attr("id");

	$.get( "inc/controller/eliminarPizzaAdmin.php", 
		{ id : id }, 
		function(dato){
			location.reload();
	} );

}

function eliminarIngredienteAdmin(event){
	event.preventDefault();
	var id = $(this).closest("tr").attr("id");

	$.get( "inc/controller/eliminarIngredienteAdmin.php", 
		{ id : id }, 
		function(dato){
			console.log(dato);
			location.reload();
	} );

}

function agregarIngredienteAdmin(event){
	event.preventDefault();

	$(this).css({'opacity':'0',
							'transform':'translateY(50%)'});

	$(".nuevoIng").css({'opacity':'1'});



}

function cancelarIngrediente(event){
	event.preventDefault();

	$(".nuevoIng").css({'opacity':'0'});
	//$(".nuevoIng").remove();
	$("#agregarIngredienteAdmin").css({
							'opacity':'1',
							'transform':'translateY(0%)'
						});

}

function agregarIngrediente(event){
	event.preventDefault();

	var datos = {};
	datos.nombre = $("#nombreIng").val();
	datos.stock = $("#stockIng").val();
	datos.precio = $("#precioIng").val();


	var datosJSON = JSON.stringify(datos);

	$.get( "inc/controller/agregarIngredienteAdmin.php", {datos : datosJSON }, function(data){ location.reload();});
}

function modificarIngredienteAdmin(event){
	event.preventDefault();

	if(!puedoModificar)
	{
		puedoModificar = true;

		//Tomo el id de ese ítem.
		var id = $(this).closest("tr").attr("id");
		var tr = $(this).closest("tr");


		//Obtengo los valores de los inputs.
		var nombre = $.trim( $("#" + id + " td:nth-of-type(1)").text() );
		var stock = $.trim( $("#" + id + " td:nth-of-type(2)").text().replace(' gr', '') );
		var precio = $.trim( $("#" + id + " td:nth-of-type(3)").text().replace('$', '') );



		//Convierto todas las celdas de ese ítem en input's
		
		$("#" + id + " td:nth-of-type(1)").html( "<input type='text' id='nombreIng' value='"+nombre+"' />" );
		$("#" + id + " td:nth-of-type(2)").html( "<input type='text' id='stockIng' value='"+stock+"' />" );
		$("#" + id + " td:nth-of-type(3)").html( "<input type='text' id='precioIng' value='"+precio+"' />" );

			
	}else
	{
		var datos = {};

		datos.nombre = $("#nombreIng").val();
		datos.stock= $("#stockIng").val();
		datos.precio = $("#precioIng").val();
		datos.id_ingrediente = $(this).closest("tr").attr("id");

		var datosJSON = JSON.stringify(datos);

		$.get( "inc/controller/modificarIngredienteAdmin.php", {datos : datosJSON }, function(data){ console.log(data); puedoModificar = false; location.reload();});
	}

}

function modificarPizzaAdmin(event){
	event.preventDefault();

    var form_data = new FormData();
 	var file_data = $('#pizzaNueva-imagen').prop('files')[0];   
    var nombre = $("#pizzaNueva-nombre").val();
    var categoria = $("#pizzaNueva-categoria").val();
    var precio = $("#precio-dinamico-total").text();
    var id_ingrediente;
	var cantidad;
	var ingredientes = [];
	var sabor;
	var sabores = [];
	var id_pizza = $("#pizzaNueva-id").val();

    form_data.append('file', file_data);
    form_data.append('nombre', nombre);
    form_data.append('categoria', categoria);
    form_data.append('precio', precio);
    form_data.append('id_pizza', id_pizza);

    


	$( ".cantidad:enabled" ).each(function(){

		id_ingrediente = $(this).attr("id");
		cantidad = $(this).val();

		ingredientes.push({'id_ingrediente': id_ingrediente, 'cantidad': cantidad});	

	});

	$( ".selectSaborAdmin:enabled option:selected" ).each(function(){
		sabor = $(this).val();
		sabores.push(sabor);
	});

	var sabores = JSON.stringify(sabores);
	
	var ingredientes = JSON.stringify(ingredientes);

	if(categoria == "mixtas")
	{
    	form_data.append('sabores', sabores);
	}else
	{
    	form_data.append('ingredientes', ingredientes);
	}

    $.ajax({
                url: 'inc/controller/modificarPizzaAdmin.php', // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(dato){
                	console.log(dato);
                    document.location.href = "pizzasAdmin.php";
                }
     });

}

function verificarCategoriaPizzaNueva(){
	//Si la categoría seleccionada es Mixta
	//agrego los controles necesarios para elegir las
	//pizzas que quiero mixtear. (4 listas-checkbox con las respectivas pizzas).
	//Si la categoria elegida no es Mixta, quito esos controles.

	if( $(this).val() == "mixtas")
	{
		$(".agregar-pizza-ingredientes input[type=checkbox]").attr('disabled', true);
		$(".agregar-pizza-ingredientes input[type=checkbox]").attr('checked', false);
		$(".agregar-pizza-ingredientes input[type=text]").attr('disabled', true);
		$(".agregar-pizza-ingredientes input[type=text]").val('');
		$("#precio-dinamico").text('0');

		actualizarNuevoPrecio();

		$(".agregar-pizza-sabores").css({'height':'152px'});
	}else
	{
		$(".agregar-pizza-sabores").css({'height':'0px'});
		$(".agregar-pizza-sabores input[type=checkbox]").attr('checked', false);
		$(".agregar-pizza-sabores select").attr('disabled', true);
		$("#precio-dinamico").text('0');

		actualizarNuevoPrecio();

		$(".agregar-pizza-ingredientes input[type=checkbox]").attr('disabled', false);
	}
}

function cargarPrecioMixtaAdmin(){
	var sabor;
	var sabores = [];


	$( ".selectSaborAdmin:enabled option:selected" ).each(function(){
		sabor = "'" + $(this).val() + "'";
		sabores.push(sabor);

		//Desactivar los restantes sabores que ya fueron elegidos.
	});

	var tamanio = "grande";

	var saboresJSON = JSON.stringify(sabores);

	$.get( "inc/controller/cargarPrecioMixta.php", 
		{ sabores : saboresJSON, tamanio : tamanio }, 
		function(dato){
			$("#precio-dinamico").text(dato);
			actualizarNuevoPrecio();

	} );
}
