/*SIN TERMINAR*/

use PIZZERIA_TEST;

INSERT INTO INGREDIENTES (id_ingrediente,nombre,stock,precio) VALUES
(001,'masa comun', 2000, 20),
(002,'masa sin gluten', 1000, 30),
(003,'salsa de tomate', 2000, 30),
(004,'tomate natural', 2000, 50),
(005,'oregano', 2000, 10),
(006,'aceituna', 2000, 50),
(007,'provolone', 2000, 30),
(008,'pepperoni', 2000, 30),
(009,'cebolla', 2000, 30),
(010,'albahaca', 2000, 30),
(011,'tomate cherry', 2000, 30),
(012,'huevo', 2000, 30),
(013,'verdeo', 2000, 30),
(014,'morrones', 2000, 30),
(015,'longaniza', 2000, 30),
(016,'palmitos', 2000, 30),
(017,'salsa golf', 2000, 30),
(018,'salsa blanca', 2000, 30),
(019,'ajo', 2000, 30),
(020,'parmesano', 2000, 30),
(021,'aceite de oliva', 2000, 30),
(022,'roquefort', 2000, 30),
(023,'berenjena', 2000, 30),
(024,'espinaca', 2000, 50),
(025,'pimientos rojos', 2000, 50),
(026,'garbanzos cocidos', 2000, 50),
(027,'queso rayado', 2000, 80),
(028,'anchoas', 2000, 100),
(029,'jamon', 2000, 60),
(030,'panceta', 2000, 90),
(031,'huevo duro', 2000, 80),
(032,'carne picada', 2000, 70),
(033,'champignones', 2000, 50),
(034,'papa frita', 5000, 50),
(035,'papa al horno', 5000, 70),
(036,'muzzarella', 5000, 100);



/*Ingreso la pizza 001, sin el precio.*/
INSERT INTO PIZZAS (id_pizza, nombre, categoria)
select
(001, 'napolitana','predefinidas'),
(002, 'alemana','predefinidas'),
(003, 'anchoas','predefinidas'),
(004, 'calabresa','predefinidas'),
(005, 'champignon','predefinidas'),
(006, 'cuatro quesos','predefinidas'),
(007, 'espinaca','predefinidas'),
(008, 'fugazzeta','predefinidas'),
(009, 'jamon y morron','predefinidas'),
(010, 'muzzarella','predefinidas'),
(011, 'palmitos','predefinidas'),
(012, 'panceta','predefinidas'),
(013, 'pepperoni','predefinidas'),
(014, 'provolone','predefinidas'),
(015, 'celiaca vegana','celiacas'),
(016, 'superman','infantiles'),
(017, 'papas fritas','infantiles'),
(018, 'angry bird','infantiles'),
(019, 'hallowen','infantiles'),
(020, 'kity','infantiles'),
(022, 'berenjena','veganas'),
(023, 'espinaca y batata','veganas'),
(024, 'espinaca','veganas'),
(025, 'humus','veganas'),
(026, 'batata','veganas'),
(028, 'napozzarella','mixtas'),
(029, 'vegana infantil','mixtas'),
(030, 'calabresa y panceta','mixtas');



/*Ingreso el ingrediente 001 de la pizza 001*/
INSERT INTO TIENE_INGREDIENTES(id_pizza,id_ingrediente,cantidad,precio)
select
(001),
(001),
(350),
(SELECT (INGREDIENTES.precio*350)/1000 FROM INGREDIENTES
	WHERE INGREDIENTES.id_ingrediente = 001 );

/*Ingreso el ingrediente 002 de la pizza 001*/
INSERT INTO TIENE_INGREDIENTES(id_pizza,id_ingrediente,cantidad,precio)
select
(001),
(002),
(60),
(SELECT (INGREDIENTES.precio*60)/1000 FROM INGREDIENTES
	WHERE INGREDIENTES.id_ingrediente = 002 );

/*Cargar y actualizar precios de la pizza 001*/
UPDATE PIZZAS SET precio = (SELECT SUM(TIENE_INGREDIENTES.precio) FROM TIENE_INGREDIENTES
							WHERE TIENE_INGREDIENTES.id_pizza = 001)
WHERE id_pizza = 001;




/*Ingreso el ingrediente 001 de la pizza 002*/
INSERT INTO TIENE_INGREDIENTES(id_pizza,id_ingrediente,cantidad,precio)
select
(002),
(001),
(20),
(SELECT (INGREDIENTES.precio*20)/1000 FROM INGREDIENTES
	WHERE INGREDIENTES.id_ingrediente = 001 );


/*Cargar y actualizar precios de la pizza 002*/
UPDATE PIZZAS SET precio = (SELECT SUM(TIENE_INGREDIENTES.precio) FROM TIENE_INGREDIENTES
							WHERE TIENE_INGREDIENTES.id_pizza = 002)
WHERE id_pizza = 002;




/*Ingreso el ingrediente 005 de la pizza 003*/
INSERT INTO TIENE_INGREDIENTES(id_pizza,id_ingrediente,cantidad,precio)
select
(003),
(005),
(30),
(SELECT (INGREDIENTES.precio*30)/1000 FROM INGREDIENTES
	WHERE INGREDIENTES.id_ingrediente = 005 );


/*Cargar y actualizar precios de la pizza 003*/
UPDATE PIZZAS SET precio = (SELECT SUM(TIENE_INGREDIENTES.precio) FROM TIENE_INGREDIENTES
							WHERE TIENE_INGREDIENTES.id_pizza = 003)
WHERE id_pizza = 003;





/*Ingreso el ingrediente 034 de la pizza 004*/
INSERT INTO TIENE_INGREDIENTES(id_pizza,id_ingrediente,cantidad,precio)
select
(004),
(034),
(100),
(SELECT (INGREDIENTES.precio*100)/1000 FROM INGREDIENTES
	WHERE INGREDIENTES.id_ingrediente = 034 );


/*Cargar y actualizar precios de la pizza 002*/
UPDATE PIZZAS SET precio = (SELECT SUM(TIENE_INGREDIENTES.precio) FROM TIENE_INGREDIENTES
							WHERE TIENE_INGREDIENTES.id_pizza = 004)
WHERE id_pizza = 004;


INSERT INTO FACTURA(id_factura,id_cliente,precio_total)
select
(001),
(002),
(45);

INSERT INTO FACTURA(id_factura,id_cliente,precio_total)
select
(002),
(002),
(45);

INSERT INTO MENSAJE values(
(id_mensaje),
("Laura"),
("Lopez"),
("mail@outlook.com"),
("Pizzas para celiacos"),
("sdfdfgdfhfghf")
);

INSERT INTO MENSAJE values(
(id_mensaje),
("Matias"),
("Gomez"),
("matias@outlook.com"),
("Pizzas para veganos"),
("problema con veganas porque...")
);

INSERT INTO USUARIO (id_usuario, tipo_usuario, nombre, apellido, nombre_usuario, pass, tipo_dni,
numero_dni, calle, altura, depto, partido, provincia, telefono, celular, mail) VALUES(
MD5('beti'),
('admin'),
('beti'),
('simonson'),
('beti'),
MD5('betilafea'),
('DNI'),
(30981789),
('florencio varela'),
(123),
('1b'),
('moron'),
('buenos aires'),
('45562309'),
('1589128976'),
('betibeti@simonson.com')
);

INSERT INTO USUARIO (id_usuario, tipo_usuario, nombre, apellido, nombre_usuario, pass, tipo_dni,
numero_dni, calle, altura, depto, partido, provincia, telefono, celular, mail) VALUES(
MD5('rocko'),
('cliente'),
('rocko'),
('garcia'),
('rocko'),
MD5('rockoperro'),
('DNI'),
(31981789),
('rivadavia'),
(123),
('2b'),
('moron'),
('buenos aires'),
('45562309'),
('1589128976'),
('rocko@perro.com')
);
