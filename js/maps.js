window.onload=initialize;

function initialize() {
  var mapOptions = {
    zoom: 14, //zoom del mapa
    
    center: new google.maps.LatLng(-34.655880, -58.616634), //para que centre en esa coordenada
    mapTypeId: google.maps.MapTypeId.TERRAIN //tipo de mapa
  };

  var radioPizzeria;
  
  var map = new google.maps.Map(document.getElementById('map'),
      mapOptions);
  //Defino las coordenadas de latitud y longitud para el path del poligono

//Coordenadas con las que construyo el poligono.
  var radioCoordenadas = [
    new google.maps.LatLng(-34.683403, -58.619413),
    new google.maps.LatLng(-34.673821, -58.630978),
    new google.maps.LatLng(-34.664443, -58.626470),
    new google.maps.LatLng(-34.660454, -58.624367),
    new google.maps.LatLng(-34.660524, -58.628874),
    new google.maps.LatLng(-34.660207, -58.630075),
    new google.maps.LatLng(-34.653111, -58.629903),
    new google.maps.LatLng(-34.647886, -58.628444),
    new google.maps.LatLng(-34.644179, -58.625827),
    new google.maps.LatLng(-34.642871, -58.625153),
    new google.maps.LatLng(-34.640860, -58.624410),
    new google.maps.LatLng(-34.642429, -58.622471),
    new google.maps.LatLng(-34.638951, -58.618501),
    new google.maps.LatLng(-34.659887, -58.593481)
  ];

  //Creo el poligono
  radioPizzeria = new google.maps.Polygon({
    paths: radioCoordenadas, //caminos del poligono.Establece ruta para el poligono.
    strokeColor: '#FF0000',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#FF0000',
    fillOpacity: 0.35
  });

  radioPizzeria.setMap(map);

//creo un marcador imagen con el path para el mapa y el tamaño del mapa. 

var markerImage = new google.maps.MarkerImage(
    'images/icono-pizza.png',
    new google.maps.Size(50,50), //tamaño
    null, //origen
    null, //anchor
    new google.maps.Size(50,50) //escala

);

var marker = new google.maps.Marker({
    position: new google.maps.LatLng(-34.655880, -58.616634), //Ubicacion del marcador.
    map: map,
    icon: markerImage, //seteo el icon marker al MarkerImage
    animation: google.maps.Animation.DROP
});

}
