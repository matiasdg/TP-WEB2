DROP DATABASE IF EXISTS PIZZERIA_TEST;

CREATE DATABASE pizzeria_test;


USE pizzeria_test;

CREATE TABLE USUARIO(
	id_usuario varchar(100) not null,
	tipo_usuario varchar(50) not null,
	nombre		varchar(50)	not null,
	apellido	varchar(50)	not null,
	nombre_usuario varchar(50) not null,
	pass	varchar(100)	not null,
	tipo_dni		varchar(5) not null,
	numero_dni	int(8)	not null,
	calle		varchar(30)	not null,
	altura		int(8)	not null,
	depto		varchar(20),
	partido		varchar(20)	not null,
	provincia	varchar(30) not null,
	telefono	varchar(10)	not null,
	celular		varchar(10),
	mail		varchar(20)	not null,
	primary key(id_usuario)

);

CREATE TABLE PIZZAS(
	id_pizza int not null,
	nombre varchar(100),
	categoria varchar(100),
	precio float,
	primary key(id_pizza)
); 

CREATE TABLE PIZZA_MIXTA(
	id_pizza_mixta int not null,
	id_pizza int not null,
	primary key(id_pizza, id_pizza_mixta),
	foreign key(id_pizza) references PIZZAS(id_pizza) ON DELETE CASCADE,
	foreign key(id_pizza_mixta) references PIZZAS(id_pizza) ON DELETE CASCADE
);


CREATE TABLE INGREDIENTES(
	id_ingrediente int not null,
	nombre varchar(100),
	stock int,
	precio float,
	primary key(id_ingrediente)
);

CREATE TABLE TIENE_INGREDIENTES(
	id_pizza int not null,
	id_ingrediente int not null,
	cantidad int,
	precio float,
	primary key(id_pizza,id_ingrediente),
	foreign key(id_pizza) references PIZZAS(id_pizza) ON DELETE CASCADE,
	foreign key(id_ingrediente) references INGREDIENTES(id_ingrediente) ON DELETE CASCADE
);

CREATE TABLE FACTURA(
	id_factura int not null AUTO_INCREMENT,
	id_cliente int not null,
	precio_total float not null,
	primary key(id_factura)
);

CREATE TABLE PRODUCTO(
	id_factura int not null,
	id_cliente int not null,
	id_pizza int not null,
	precio_pizza float not null,
	tamaño varchar(10) not null,
	primary key(id_factura,id_cliente),
	foreign key(id_factura) references FACTURA(id_factura)
	
);

CREATE TABLE MENSAJE(
	id_mensaje int not null auto_increment,
	nombre varchar(15) not null,
	apellido varchar(15) not null,
	email varchar(20) not null,
	asunto varchar(30) not null,
	mensaje varchar(600) not null,
	primary key(id_mensaje)
);

CREATE TABLE COMPRA(
	id_compra int not null auto_increment,
	estado varchar(10) not null,
	id_usuario varchar(10) not null,
	id_pizza int(11) not null,
	primary key(id_compra),
	foreign key (id_pizza) references PIZZAS(id_pizza),
	foreign key (id_usuario) references USUARIO(id_usuario)

); 
	
/*Clona tabla factura y guarda los datos de la tabla factura en la tabla comprobante*/

/*CON LIKE CREO UNA TABLA VACIA CON LA ESTRUCTURA DE LA TABLA FACTURA*/
CREATE TABLE COMPROBANTE LIKE FACTURA;
/*INSERTO TODOS LOS DATOS DE LA TABLA FACTURA EN COMPROBANTE**/
INSERT INTO COMPROBANTE SELECT * FROM FACTURA;

DROP TABLE COMPROBANTE;


/*Acá se van metiendo los productos del carrito*/
CREATE TABLE PEDIDOS(
	id_pedido int not null,
	id_usuario varchar(100) not null,
	fecha date not null,
	producto varchar(100) not null,
	detalles varchar(150) not null,
	precio float not null,
	tamanio varchar(100) not null,
	calle varchar(100) not null,
	altura int not null,
	depto varchar(20),
	modo_pago varchar(100) not null,
	numero_tarjeta int,
	estado varchar(100) not null

);