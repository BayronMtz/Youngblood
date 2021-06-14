	create table usuarios
	(
		id_usuario int not null primary key,
		nombres_u varchar(25) not null,
		apellidos varchar(25) not null,
		email varchar(75) not null,
		alias_u varchar(15) not null,
		contrasena_u varchar(75) not null
	);
	
	create table clientes
	(
		id_cliente int not null primary key,
		nombres_c varchar(25) not null,
		apellidos_c varchar(25) not null,
		dui_c varchar(10) not null,
		email_c varchar(75) not null,
		telefono_c varchar(9) not null,
		nacimiento_c date not null,
		direccion varchar(200) not null,
		contrasena_c varchar(75) not null,
		estado_c boolean not null
	);
	
	create table pedidos
	(
		id_pedido int not null primary key,
		id_cliente int not null,
		estado_pedido int not null,
		fecha_pedido date not null,
		
		foreign key (id_cliente) references clientes(id_cliente)
	);
	
	create table categoria
	(
		id_categoria int not null primary key,
		nombre_categoria varchar(50) not null,
		descripcion_categoria varchar(250) not null,
		imagen_categoria varchar(50) not null
	);
	
	
	
	create table productos
	(
		id_producto int not null primary key,
		id_categoria int not null,
		nombre_producto varchar(50) not null,
		descripcion_producto varchar(250) not null,
		id_talla int not null,
		precio_producto numeric(5,2) not null,
		imagen_producto varchar(50) not null,
		estado_producto boolean not null,
		id_usuario int not null,
		
		foreign key (id_categoria) references categoria(id_categoria),
		foreign key (id_talla) references talla(id_talla),
		foreign key (id_usuario) references usuarios(id_usuario)
	);
	
	create table detalle_pedido
	(
		id_detalle int not null primary key,
		id_pedido int not null,
		id_producto int not null,
		cantidad_producto int not null,
		precio_producto numeric(5,2) not null,
		
		foreign key (id_pedido) references pedidos(id_pedido),
		foreign key (id_producto) references productos(id_producto)
	);
	
	create table valoraciones
	(
		id_valoracion int not null primary key,
		id_detalle int not null,
		calificacion_producto int null,
		comentario_producto varchar(250) null,
		fecha_comentario date null,
		estado_comentario boolean null,
		
		foreign key (id_detalle) references detalle_pedido(id_detalle)
	)