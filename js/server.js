$(document).ready(function(){


	$(".btn-enviarCategoria").click(enviarCategoria);

});


function enviarCategoria(){
	var categoria = $(this).attr('id');
	var pathname = window.location.pathname;
	var pathname_array = pathname.split("/");
	var last = pathname_array[pathname_array.length - 1];
	
	console.log(last);
	if(last != "pizzas.php")
	{
		document.location.href = "pizzas.php";
	}

	//Con el método GET le envío la variable categoría a pizza_class.php, y proceso el resultado en cargarCategoria
	$.get( "recibirCategoria.php", { categoria: categoria}, cargarCategoria );
	return false;	
}

//Los datos recibidos se cargan en .boxes.
function cargarCategoria(data){

	$(".boxes").html(data);
}


