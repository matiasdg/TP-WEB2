$(document).ready(function(){
	puedoEliminarProducto = false;

	//Se llama a la funcion changeBg cada 5 segundos.
	setInterval(changeBg, 5000);

	//Se llama a la función fnCheck cada vez que se selecciona o deselecciona un checkbox de los ingredientes.
	$( ".ingredientes input[type=checkbox]" ).on( "click", fnCheck );
	//Se llama a la funcion fnMasa cada vez que se selecciona o deselecciona la masa.
	$( ".masa input[type=radio]" ).on( "click", fnMasa );


	//fancybox
	$(".fancybox").fancybox({
	    openEffect  : 'none',
	    closeEffect : 'none'
	});

	//Botones del Carrito
	$('#eliminar-productos-carrito').click(eliminarProductosCarrito);

	$("#cancelar-productos-carrito").click(cancelarProductosCarrito);
	
	//$('#confirmar-productos-carrito').click(confirmarProductosCarrito);

	$(".item").click(cambiarEstadoItem);


	//Calcular demora en Carrito->Confirmacion.
	$("#confirmacion form input").bind("change click select", calcularDemora);


	//Slider del Home.
	setInterval(slider, 5000);

});


//Slider del background
function changeBg(){
	var element = $('.bg ul li');

	$( ".bg ul li" ).each(function( index ) {		

		if( $(this).css('opacity') == "1" )
		{
			$(this).css({'opacity':'0'});
			$(this).next().css({'opacity':'1'});

			if( !$(this).next().length )
			{
				$(".bg ul li:first").css({'opacity':'1'});
			}
		}
	});
}

function slider(){	

	$( ".slider ul li" ).each(function( index ) {
		if( $(this).css('transform') == "matrix(1, 0, 0, 1, 0, 0)" )
		{

			$(this).css({'transform':'translateX(-100%)',
						'-webkit-transform':'translateX(-100%)',
						'-moz-transform':'translateX(-100%)'});
			
			$(this).next().css({'transform':'translateX(0%)',
								'-webkit-transform':'translateX(0%)',
								'-moz-transform':'translateX(0%)'});

			if( !$(this).next().length )
			{
				$("#slider-mixtaPizza").css({'transform':'translateX(200%)',
											'-webkit-transform':'translateX(200%)',
											'-moz-transform':'translateX(200%)'});
				
				$("#slider-armaPizza").css({'transform':'translateX(100%)',
											'-webkit-transform':'translateX(100%)',
											'-moz-transform':'translateX(100%)'});
				
				$("#slider-promocion").css({'transform':'translateX(0%)',
											'-webkit-transform':'translateX(0%)',
											'-moz-transform':'translateX(0%)'});
			}
		}
	});
}


function fnCheck(){
	limitarIngredientes();
	informarIngredientes( $(this) );
}


function limitarIngredientes(){
	var cantidad = $( ".ingredientes input[type=checkbox]" ).length;
	var checked = $( ".ingredientes input[type=checkbox]:checked" ).length;
	var elemento = $(".ingredientes input[type=checkbox]");
	var limiteLleno = false;

	if(checked >= 15)
	{
		limiteLleno = true;
	}else
	{
		limiteLleno = false;
	}

	if(limiteLleno == true)
	{
		for(var i = 0; i < cantidad; i++)
		{
			if(elemento[i].checked == false)
			{
				elemento[i].disabled = true;
			}
		}
	}else
	{
		for(var i = 0; i < cantidad; i++)
		{
			if(elemento[i].checked == false)
			{
				elemento[i].disabled = false;
			}
		}		
	}

}


function informarIngredientes(element){
	var id = $(element).attr('id');
	var label = $(element).next();
	var texto = label.text();


	if( $(element).is(":checked") == true )
	{
		$('.armado .ingr-pers ul').append("<li>"+ texto +"</li>");
	}else
	{
		$(".armado .ingr-pers ul li").filter(":contains('"+texto+"')").remove()
	}

}


function fnMasa(){
	informarMasa( $(this) );
}

function informarMasa(element){
	var label = $(element).next();
	var texto = label.text();

	if( $(element).is(":checked") == true )
	{
		$('.armado .masa-pers ul').html("<li>"+ texto +"</li>");
	};

}


function eliminarProductosCarrito(event){
	event.preventDefault();
	var link = $("#confirmar-productos-carrito");

	if(puedoEliminarProducto)
	{
		//Eliminar productos de la lista.
		eliminarProducto();

		//Habilitar link Confirmar.
		habilitarLink(link);
		//Quitar Cancelar
		$("#cancelar-productos-carrito").css({'display':'none'});
		//Borrar clase item-true e item-false a todos los items.
		$(".item").removeClass("item-true");
		$(".item").removeClass("item-false");
		$(".item").css({'cursor':'default'});

		puedoEliminarProducto = false;
	}else
	{
		deshabilitarLink(link);

		$("#cancelar-productos-carrito").css({'display':'inline-block'});

		//Añadir clase item-true a todos los items.
		$(".item").addClass("item-true");
		$(".item").css({'cursor':'pointer'});

		//Cuando clickeo en un item, cambiar el estado.
		puedoEliminarProducto = true;
	}

}


function deshabilitarLink(element){
	element.click(function(){
		event.preventDefault();
		$(this).removeClass("fancybox");
	});

	element.addClass("btn-deshabilitado");
}

function habilitarLink(element){
	element.click(function(){
		event.preventDefault();
		$(this).addClass("fancybox");
	});

	element.removeClass("btn-deshabilitado");
}


function cambiarEstadoItem(){
	//Obtengo la tercera clase (siempre tiene que ser item-1, item-2, item-3, item-.....)
	//Tercera clase porque el div tiene: class="table-row item item-1"
	var clase = $(this).attr("class").split(' ')[2];

	
	if(puedoEliminarProducto)
	{
		//Si el item está verde, pasa a estar rojo. Si está rojo, pasa a estar verde
		if( $("."+clase).hasClass('item-true'))
		{
			$("."+clase).removeClass('item-true');
			$("."+clase).addClass('item-false');
		}else
		{
			$("."+clase).removeClass('item-false');
			$("."+clase).addClass('item-true');		
		}		
	}
}


function cancelarProductosCarrito(event){
	event.preventDefault();
	var link = $("#confirmar-productos-carrito");
	puedoEliminarProducto = false;

	//Habilitar link Confirmar.
	habilitarLink(link);
	//Quitar Cancelar
	$("#cancelar-productos-carrito").css({'display':'none'});
	//Borrar clase item-true e item-false a todos los items.
	$(".item").removeClass("item-true");
	$(".item").removeClass("item-false");
	$(".item").css({'cursor':'default'});

}


function eliminarProducto(){
	// var item = $(".item").attr("class").split(' ')[2];
	var id;
	var items = [];

	//Lo elimino del carrito:
	$(".item-false").each(function(){
		
		id = $(".item-false").attr("id");
		items.push(id);
	});

	console.log("items: " + items);

	var itemsJSON = JSON.stringify(items);
	$.get( "inc/controller/eliminarProductoCarrito.php", { items : itemsJSON } );
	$(".item-false").remove();
}



function calcularDemora(){

	//Si los inputs y selects tienen valores dentro->

	//Si los valores son corrrectos, mediante validaciones ->

	//Guardar los valores de los inputs y selects en un array.

	//Verificar mediante google maps cuántos kilómetros hay con respecto al local

	//Calcular tiempo.

	//Mostrar el tiempo en pantalla
}