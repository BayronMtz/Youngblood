PGDMP         /                y         
   youngblood    13.4    13.4 d    6           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            7           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            8           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            9           1262    16395 
   youngblood    DATABASE     l   CREATE DATABASE youngblood WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'Spanish_El Salvador.1252';
    DROP DATABASE youngblood;
                postgres    false            �            1259    16549    bitacora    TABLE     �   CREATE TABLE public.bitacora (
    id_bitacora integer NOT NULL,
    id_usuario integer,
    id_cliente integer,
    fecha date NOT NULL,
    hora time without time zone NOT NULL,
    observacion character varying(100)
);
    DROP TABLE public.bitacora;
       public         heap    postgres    false            �            1259    16547    bitacora_id_bitacora_seq    SEQUENCE     �   CREATE SEQUENCE public.bitacora_id_bitacora_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE public.bitacora_id_bitacora_seq;
       public          postgres    false    221            :           0    0    bitacora_id_bitacora_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE public.bitacora_id_bitacora_seq OWNED BY public.bitacora.id_bitacora;
          public          postgres    false    220            �            1259    16396 
   categorias    TABLE     �   CREATE TABLE public.categorias (
    id_categoria integer NOT NULL,
    nombre_categoria character varying(50) NOT NULL,
    descripcion_categoria character varying(250),
    imagen_categoria character varying(50) NOT NULL
);
    DROP TABLE public.categorias;
       public         heap    postgres    false            �            1259    16399    categorias_id_categoria_seq    SEQUENCE     �   CREATE SEQUENCE public.categorias_id_categoria_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE public.categorias_id_categoria_seq;
       public          postgres    false    200            ;           0    0    categorias_id_categoria_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE public.categorias_id_categoria_seq OWNED BY public.categorias.id_categoria;
          public          postgres    false    201            �            1259    16401    clientes    TABLE     �  CREATE TABLE public.clientes (
    id_cliente integer NOT NULL,
    nombres_cliente character varying(50) NOT NULL,
    apellidos_cliente character varying(50) NOT NULL,
    dui_cliente character varying(10) NOT NULL,
    correo_cliente character varying(100) NOT NULL,
    telefono_cliente character varying(9) NOT NULL,
    nacimiento_cliente date NOT NULL,
    clave_cliente character varying(100) NOT NULL,
    estado_cliente boolean DEFAULT true NOT NULL,
    direccion_cliente character varying(200) NOT NULL,
    fecha_registro date,
    alias_usuario character varying(30),
    intentos integer,
    fecha_clave date,
    dobleverificacion character(2) NOT NULL
);
    DROP TABLE public.clientes;
       public         heap    postgres    false            �            1259    16408    clientes_id_cliente_seq    SEQUENCE     �   CREATE SEQUENCE public.clientes_id_cliente_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.clientes_id_cliente_seq;
       public          postgres    false    202            <           0    0    clientes_id_cliente_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.clientes_id_cliente_seq OWNED BY public.clientes.id_cliente;
          public          postgres    false    203            �            1259    16410    detalle_pedido    TABLE     �   CREATE TABLE public.detalle_pedido (
    id_detalle integer NOT NULL,
    id_producto integer NOT NULL,
    cantidad_producto smallint NOT NULL,
    precio numeric(5,2) NOT NULL,
    id_pedido integer NOT NULL
);
 "   DROP TABLE public.detalle_pedido;
       public         heap    postgres    false            �            1259    16413    detalle_pedidos_id_detalle_seq    SEQUENCE     �   CREATE SEQUENCE public.detalle_pedidos_id_detalle_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 5   DROP SEQUENCE public.detalle_pedidos_id_detalle_seq;
       public          postgres    false    204            =           0    0    detalle_pedidos_id_detalle_seq    SEQUENCE OWNED BY     `   ALTER SEQUENCE public.detalle_pedidos_id_detalle_seq OWNED BY public.detalle_pedido.id_detalle;
          public          postgres    false    205            �            1259    16523    dispositivos_cliente    TABLE     �   CREATE TABLE public.dispositivos_cliente (
    id_dispositivo_c integer NOT NULL,
    dispositivo character varying(200) NOT NULL,
    fecha date NOT NULL,
    hora time without time zone NOT NULL,
    id_cliente integer NOT NULL
);
 (   DROP TABLE public.dispositivos_cliente;
       public         heap    postgres    false            �            1259    16521 )   dispositivos_cliente_id_dispositivo_c_seq    SEQUENCE     �   CREATE SEQUENCE public.dispositivos_cliente_id_dispositivo_c_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 @   DROP SEQUENCE public.dispositivos_cliente_id_dispositivo_c_seq;
       public          postgres    false    217            >           0    0 )   dispositivos_cliente_id_dispositivo_c_seq    SEQUENCE OWNED BY     w   ALTER SEQUENCE public.dispositivos_cliente_id_dispositivo_c_seq OWNED BY public.dispositivos_cliente.id_dispositivo_c;
          public          postgres    false    216            �            1259    16536    dispositivos_usuario    TABLE     �   CREATE TABLE public.dispositivos_usuario (
    id_dispositivo_a integer NOT NULL,
    dispositivo character varying(200) NOT NULL,
    fecha date NOT NULL,
    hora time without time zone NOT NULL,
    id_usuario integer NOT NULL
);
 (   DROP TABLE public.dispositivos_usuario;
       public         heap    postgres    false            �            1259    16534 )   dispositivos_usuario_id_dispositivo_a_seq    SEQUENCE     �   CREATE SEQUENCE public.dispositivos_usuario_id_dispositivo_a_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 @   DROP SEQUENCE public.dispositivos_usuario_id_dispositivo_a_seq;
       public          postgres    false    219            ?           0    0 )   dispositivos_usuario_id_dispositivo_a_seq    SEQUENCE OWNED BY     w   ALTER SEQUENCE public.dispositivos_usuario_id_dispositivo_a_seq OWNED BY public.dispositivos_usuario.id_dispositivo_a;
          public          postgres    false    218            �            1259    16415    pedidos    TABLE     �   CREATE TABLE public.pedidos (
    id_pedido integer NOT NULL,
    id_cliente integer NOT NULL,
    estado_pedido smallint DEFAULT 0 NOT NULL,
    fecha_pedido date
);
    DROP TABLE public.pedidos;
       public         heap    postgres    false            �            1259    16419    pedidos_id_pedido_seq    SEQUENCE     �   CREATE SEQUENCE public.pedidos_id_pedido_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.pedidos_id_pedido_seq;
       public          postgres    false    206            @           0    0    pedidos_id_pedido_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.pedidos_id_pedido_seq OWNED BY public.pedidos.id_pedido;
          public          postgres    false    207            �            1259    16421 	   productos    TABLE     �  CREATE TABLE public.productos (
    id_producto integer NOT NULL,
    nombre_producto character varying(50) NOT NULL,
    descripcion_producto character varying(250) NOT NULL,
    precio_producto numeric(5,2) NOT NULL,
    imagen_producto character varying(50) NOT NULL,
    id_categoria integer NOT NULL,
    estado_producto boolean NOT NULL,
    id_usuario integer NOT NULL,
    cantidad numeric
);
    DROP TABLE public.productos;
       public         heap    postgres    false            �            1259    16427    productos_id_producto_seq    SEQUENCE     �   CREATE SEQUENCE public.productos_id_producto_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.productos_id_producto_seq;
       public          postgres    false    208            A           0    0    productos_id_producto_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.productos_id_producto_seq OWNED BY public.productos.id_producto;
          public          postgres    false    209            �            1259    16429    puntuaciones    TABLE     x   CREATE TABLE public.puntuaciones (
    id_puntuacion integer NOT NULL,
    puntuacion character varying(15) NOT NULL
);
     DROP TABLE public.puntuaciones;
       public         heap    postgres    false            �            1259    16432    puntuaciones_id_puntuacion_seq    SEQUENCE     �   CREATE SEQUENCE public.puntuaciones_id_puntuacion_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 5   DROP SEQUENCE public.puntuaciones_id_puntuacion_seq;
       public          postgres    false    210            B           0    0    puntuaciones_id_puntuacion_seq    SEQUENCE OWNED BY     a   ALTER SEQUENCE public.puntuaciones_id_puntuacion_seq OWNED BY public.puntuaciones.id_puntuacion;
          public          postgres    false    211            �            1259    16434    usuarios    TABLE     �  CREATE TABLE public.usuarios (
    id_usuario integer NOT NULL,
    nombres_usuario character varying(50) NOT NULL,
    apellidos_usuario character varying(50) NOT NULL,
    correo_usuario character varying(100) NOT NULL,
    alias_usuario character varying(50) NOT NULL,
    clave_usuario character varying(100) NOT NULL,
    intentos integer,
    estado_usuario integer,
    fecha_clave date,
    dobleverificacion character(2) NOT NULL
);
    DROP TABLE public.usuarios;
       public         heap    postgres    false            �            1259    16437    usuarios_id_usuario_seq    SEQUENCE     �   CREATE SEQUENCE public.usuarios_id_usuario_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.usuarios_id_usuario_seq;
       public          postgres    false    212            C           0    0    usuarios_id_usuario_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.usuarios_id_usuario_seq OWNED BY public.usuarios.id_usuario;
          public          postgres    false    213            �            1259    16439    valoraciones    TABLE       CREATE TABLE public.valoraciones (
    id_valoracion integer NOT NULL,
    id_cliente integer NOT NULL,
    valoracion character varying(200) NOT NULL,
    fecha date NOT NULL,
    id_puntuacion integer NOT NULL,
    id_producto integer NOT NULL,
    visibilidad integer
);
     DROP TABLE public.valoraciones;
       public         heap    postgres    false            �            1259    16442    valoraciones_id_valoracion_seq    SEQUENCE     �   CREATE SEQUENCE public.valoraciones_id_valoracion_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 5   DROP SEQUENCE public.valoraciones_id_valoracion_seq;
       public          postgres    false    214            D           0    0    valoraciones_id_valoracion_seq    SEQUENCE OWNED BY     a   ALTER SEQUENCE public.valoraciones_id_valoracion_seq OWNED BY public.valoraciones.id_valoracion;
          public          postgres    false    215            l           2604    16552    bitacora id_bitacora    DEFAULT     |   ALTER TABLE ONLY public.bitacora ALTER COLUMN id_bitacora SET DEFAULT nextval('public.bitacora_id_bitacora_seq'::regclass);
 C   ALTER TABLE public.bitacora ALTER COLUMN id_bitacora DROP DEFAULT;
       public          postgres    false    220    221    221            `           2604    16444    categorias id_categoria    DEFAULT     �   ALTER TABLE ONLY public.categorias ALTER COLUMN id_categoria SET DEFAULT nextval('public.categorias_id_categoria_seq'::regclass);
 F   ALTER TABLE public.categorias ALTER COLUMN id_categoria DROP DEFAULT;
       public          postgres    false    201    200            b           2604    16445    clientes id_cliente    DEFAULT     z   ALTER TABLE ONLY public.clientes ALTER COLUMN id_cliente SET DEFAULT nextval('public.clientes_id_cliente_seq'::regclass);
 B   ALTER TABLE public.clientes ALTER COLUMN id_cliente DROP DEFAULT;
       public          postgres    false    203    202            c           2604    16446    detalle_pedido id_detalle    DEFAULT     �   ALTER TABLE ONLY public.detalle_pedido ALTER COLUMN id_detalle SET DEFAULT nextval('public.detalle_pedidos_id_detalle_seq'::regclass);
 H   ALTER TABLE public.detalle_pedido ALTER COLUMN id_detalle DROP DEFAULT;
       public          postgres    false    205    204            j           2604    16526 %   dispositivos_cliente id_dispositivo_c    DEFAULT     �   ALTER TABLE ONLY public.dispositivos_cliente ALTER COLUMN id_dispositivo_c SET DEFAULT nextval('public.dispositivos_cliente_id_dispositivo_c_seq'::regclass);
 T   ALTER TABLE public.dispositivos_cliente ALTER COLUMN id_dispositivo_c DROP DEFAULT;
       public          postgres    false    217    216    217            k           2604    16539 %   dispositivos_usuario id_dispositivo_a    DEFAULT     �   ALTER TABLE ONLY public.dispositivos_usuario ALTER COLUMN id_dispositivo_a SET DEFAULT nextval('public.dispositivos_usuario_id_dispositivo_a_seq'::regclass);
 T   ALTER TABLE public.dispositivos_usuario ALTER COLUMN id_dispositivo_a DROP DEFAULT;
       public          postgres    false    218    219    219            e           2604    16447    pedidos id_pedido    DEFAULT     v   ALTER TABLE ONLY public.pedidos ALTER COLUMN id_pedido SET DEFAULT nextval('public.pedidos_id_pedido_seq'::regclass);
 @   ALTER TABLE public.pedidos ALTER COLUMN id_pedido DROP DEFAULT;
       public          postgres    false    207    206            f           2604    16448    productos id_producto    DEFAULT     ~   ALTER TABLE ONLY public.productos ALTER COLUMN id_producto SET DEFAULT nextval('public.productos_id_producto_seq'::regclass);
 D   ALTER TABLE public.productos ALTER COLUMN id_producto DROP DEFAULT;
       public          postgres    false    209    208            g           2604    16449    puntuaciones id_puntuacion    DEFAULT     �   ALTER TABLE ONLY public.puntuaciones ALTER COLUMN id_puntuacion SET DEFAULT nextval('public.puntuaciones_id_puntuacion_seq'::regclass);
 I   ALTER TABLE public.puntuaciones ALTER COLUMN id_puntuacion DROP DEFAULT;
       public          postgres    false    211    210            h           2604    16450    usuarios id_usuario    DEFAULT     z   ALTER TABLE ONLY public.usuarios ALTER COLUMN id_usuario SET DEFAULT nextval('public.usuarios_id_usuario_seq'::regclass);
 B   ALTER TABLE public.usuarios ALTER COLUMN id_usuario DROP DEFAULT;
       public          postgres    false    213    212            i           2604    16451    valoraciones id_valoracion    DEFAULT     �   ALTER TABLE ONLY public.valoraciones ALTER COLUMN id_valoracion SET DEFAULT nextval('public.valoraciones_id_valoracion_seq'::regclass);
 I   ALTER TABLE public.valoraciones ALTER COLUMN id_valoracion DROP DEFAULT;
       public          postgres    false    215    214            3          0    16549    bitacora 
   TABLE DATA           a   COPY public.bitacora (id_bitacora, id_usuario, id_cliente, fecha, hora, observacion) FROM stdin;
    public          postgres    false    221   ;�                 0    16396 
   categorias 
   TABLE DATA           m   COPY public.categorias (id_categoria, nombre_categoria, descripcion_categoria, imagen_categoria) FROM stdin;
    public          postgres    false    200   ݃                  0    16401    clientes 
   TABLE DATA             COPY public.clientes (id_cliente, nombres_cliente, apellidos_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, clave_cliente, estado_cliente, direccion_cliente, fecha_registro, alias_usuario, intentos, fecha_clave, dobleverificacion) FROM stdin;
    public          postgres    false    202   ��       "          0    16410    detalle_pedido 
   TABLE DATA           g   COPY public.detalle_pedido (id_detalle, id_producto, cantidad_producto, precio, id_pedido) FROM stdin;
    public          postgres    false    204   �       /          0    16523    dispositivos_cliente 
   TABLE DATA           f   COPY public.dispositivos_cliente (id_dispositivo_c, dispositivo, fecha, hora, id_cliente) FROM stdin;
    public          postgres    false    217   ��       1          0    16536    dispositivos_usuario 
   TABLE DATA           f   COPY public.dispositivos_usuario (id_dispositivo_a, dispositivo, fecha, hora, id_usuario) FROM stdin;
    public          postgres    false    219   ��       $          0    16415    pedidos 
   TABLE DATA           U   COPY public.pedidos (id_pedido, id_cliente, estado_pedido, fecha_pedido) FROM stdin;
    public          postgres    false    206   ��       &          0    16421 	   productos 
   TABLE DATA           �   COPY public.productos (id_producto, nombre_producto, descripcion_producto, precio_producto, imagen_producto, id_categoria, estado_producto, id_usuario, cantidad) FROM stdin;
    public          postgres    false    208   �       (          0    16429    puntuaciones 
   TABLE DATA           A   COPY public.puntuaciones (id_puntuacion, puntuacion) FROM stdin;
    public          postgres    false    210   �       *          0    16434    usuarios 
   TABLE DATA           �   COPY public.usuarios (id_usuario, nombres_usuario, apellidos_usuario, correo_usuario, alias_usuario, clave_usuario, intentos, estado_usuario, fecha_clave, dobleverificacion) FROM stdin;
    public          postgres    false    212   :�       ,          0    16439    valoraciones 
   TABLE DATA           }   COPY public.valoraciones (id_valoracion, id_cliente, valoracion, fecha, id_puntuacion, id_producto, visibilidad) FROM stdin;
    public          postgres    false    214   t�       E           0    0    bitacora_id_bitacora_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.bitacora_id_bitacora_seq', 5, true);
          public          postgres    false    220            F           0    0    categorias_id_categoria_seq    SEQUENCE SET     I   SELECT pg_catalog.setval('public.categorias_id_categoria_seq', 7, true);
          public          postgres    false    201            G           0    0    clientes_id_cliente_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.clientes_id_cliente_seq', 21, true);
          public          postgres    false    203            H           0    0    detalle_pedidos_id_detalle_seq    SEQUENCE SET     M   SELECT pg_catalog.setval('public.detalle_pedidos_id_detalle_seq', 49, true);
          public          postgres    false    205            I           0    0 )   dispositivos_cliente_id_dispositivo_c_seq    SEQUENCE SET     W   SELECT pg_catalog.setval('public.dispositivos_cliente_id_dispositivo_c_seq', 2, true);
          public          postgres    false    216            J           0    0 )   dispositivos_usuario_id_dispositivo_a_seq    SEQUENCE SET     W   SELECT pg_catalog.setval('public.dispositivos_usuario_id_dispositivo_a_seq', 1, true);
          public          postgres    false    218            K           0    0    pedidos_id_pedido_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('public.pedidos_id_pedido_seq', 20, true);
          public          postgres    false    207            L           0    0    productos_id_producto_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.productos_id_producto_seq', 15, true);
          public          postgres    false    209            M           0    0    puntuaciones_id_puntuacion_seq    SEQUENCE SET     L   SELECT pg_catalog.setval('public.puntuaciones_id_puntuacion_seq', 5, true);
          public          postgres    false    211            N           0    0    usuarios_id_usuario_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.usuarios_id_usuario_seq', 4, true);
          public          postgres    false    213            O           0    0    valoraciones_id_valoracion_seq    SEQUENCE SET     M   SELECT pg_catalog.setval('public.valoraciones_id_valoracion_seq', 16, true);
          public          postgres    false    215            �           2606    16554    bitacora bitacora_pkey 
   CONSTRAINT     ]   ALTER TABLE ONLY public.bitacora
    ADD CONSTRAINT bitacora_pkey PRIMARY KEY (id_bitacora);
 @   ALTER TABLE ONLY public.bitacora DROP CONSTRAINT bitacora_pkey;
       public            postgres    false    221            n           2606    16453 *   categorias categorias_nombre_categoria_key 
   CONSTRAINT     q   ALTER TABLE ONLY public.categorias
    ADD CONSTRAINT categorias_nombre_categoria_key UNIQUE (nombre_categoria);
 T   ALTER TABLE ONLY public.categorias DROP CONSTRAINT categorias_nombre_categoria_key;
       public            postgres    false    200            p           2606    16455    categorias categorias_pkey 
   CONSTRAINT     b   ALTER TABLE ONLY public.categorias
    ADD CONSTRAINT categorias_pkey PRIMARY KEY (id_categoria);
 D   ALTER TABLE ONLY public.categorias DROP CONSTRAINT categorias_pkey;
       public            postgres    false    200            s           2606    16457 $   clientes clientes_correo_cliente_key 
   CONSTRAINT     i   ALTER TABLE ONLY public.clientes
    ADD CONSTRAINT clientes_correo_cliente_key UNIQUE (correo_cliente);
 N   ALTER TABLE ONLY public.clientes DROP CONSTRAINT clientes_correo_cliente_key;
       public            postgres    false    202            u           2606    16459 !   clientes clientes_dui_cliente_key 
   CONSTRAINT     c   ALTER TABLE ONLY public.clientes
    ADD CONSTRAINT clientes_dui_cliente_key UNIQUE (dui_cliente);
 K   ALTER TABLE ONLY public.clientes DROP CONSTRAINT clientes_dui_cliente_key;
       public            postgres    false    202            w           2606    16461    clientes clientes_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.clientes
    ADD CONSTRAINT clientes_pkey PRIMARY KEY (id_cliente);
 @   ALTER TABLE ONLY public.clientes DROP CONSTRAINT clientes_pkey;
       public            postgres    false    202            y           2606    16463 "   detalle_pedido detalle_pedido_pkey 
   CONSTRAINT     h   ALTER TABLE ONLY public.detalle_pedido
    ADD CONSTRAINT detalle_pedido_pkey PRIMARY KEY (id_detalle);
 L   ALTER TABLE ONLY public.detalle_pedido DROP CONSTRAINT detalle_pedido_pkey;
       public            postgres    false    204            �           2606    16528 .   dispositivos_cliente dispositivos_cliente_pkey 
   CONSTRAINT     z   ALTER TABLE ONLY public.dispositivos_cliente
    ADD CONSTRAINT dispositivos_cliente_pkey PRIMARY KEY (id_dispositivo_c);
 X   ALTER TABLE ONLY public.dispositivos_cliente DROP CONSTRAINT dispositivos_cliente_pkey;
       public            postgres    false    217            �           2606    16541 .   dispositivos_usuario dispositivos_usuario_pkey 
   CONSTRAINT     z   ALTER TABLE ONLY public.dispositivos_usuario
    ADD CONSTRAINT dispositivos_usuario_pkey PRIMARY KEY (id_dispositivo_a);
 X   ALTER TABLE ONLY public.dispositivos_usuario DROP CONSTRAINT dispositivos_usuario_pkey;
       public            postgres    false    219            {           2606    16465    pedidos pedidos_pkey 
   CONSTRAINT     Y   ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_pkey PRIMARY KEY (id_pedido);
 >   ALTER TABLE ONLY public.pedidos DROP CONSTRAINT pedidos_pkey;
       public            postgres    false    206            }           2606    16467 '   productos productos_nombre_producto_key 
   CONSTRAINT     m   ALTER TABLE ONLY public.productos
    ADD CONSTRAINT productos_nombre_producto_key UNIQUE (nombre_producto);
 Q   ALTER TABLE ONLY public.productos DROP CONSTRAINT productos_nombre_producto_key;
       public            postgres    false    208                       2606    16469    productos productos_pkey 
   CONSTRAINT     _   ALTER TABLE ONLY public.productos
    ADD CONSTRAINT productos_pkey PRIMARY KEY (id_producto);
 B   ALTER TABLE ONLY public.productos DROP CONSTRAINT productos_pkey;
       public            postgres    false    208            �           2606    16471    puntuaciones puntuaciones_pkey 
   CONSTRAINT     g   ALTER TABLE ONLY public.puntuaciones
    ADD CONSTRAINT puntuaciones_pkey PRIMARY KEY (id_puntuacion);
 H   ALTER TABLE ONLY public.puntuaciones DROP CONSTRAINT puntuaciones_pkey;
       public            postgres    false    210            �           2606    16473 #   usuarios usuarios_alias_usuario_key 
   CONSTRAINT     g   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_alias_usuario_key UNIQUE (alias_usuario);
 M   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT usuarios_alias_usuario_key;
       public            postgres    false    212            �           2606    16475 $   usuarios usuarios_correo_usuario_key 
   CONSTRAINT     i   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_correo_usuario_key UNIQUE (correo_usuario);
 N   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT usuarios_correo_usuario_key;
       public            postgres    false    212            �           2606    16477    usuarios usuarios_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id_usuario);
 @   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT usuarios_pkey;
       public            postgres    false    212            �           2606    16479    valoraciones valoraciones_pkey 
   CONSTRAINT     g   ALTER TABLE ONLY public.valoraciones
    ADD CONSTRAINT valoraciones_pkey PRIMARY KEY (id_valoracion);
 H   ALTER TABLE ONLY public.valoraciones DROP CONSTRAINT valoraciones_pkey;
       public            postgres    false    214            q           1259    16480    nombre_index    INDEX     V   CREATE UNIQUE INDEX nombre_index ON public.categorias USING btree (nombre_categoria);
     DROP INDEX public.nombre_index;
       public            postgres    false    200            �           2606    16560 !   bitacora bitacora_id_cliente_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.bitacora
    ADD CONSTRAINT bitacora_id_cliente_fkey FOREIGN KEY (id_cliente) REFERENCES public.clientes(id_cliente);
 K   ALTER TABLE ONLY public.bitacora DROP CONSTRAINT bitacora_id_cliente_fkey;
       public          postgres    false    2935    202    221            �           2606    16555 !   bitacora bitacora_id_usuario_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.bitacora
    ADD CONSTRAINT bitacora_id_usuario_fkey FOREIGN KEY (id_usuario) REFERENCES public.usuarios(id_usuario);
 K   ALTER TABLE ONLY public.bitacora DROP CONSTRAINT bitacora_id_usuario_fkey;
       public          postgres    false    2951    221    212            �           2606    16481 ,   detalle_pedido detalle_pedido_id_pedido_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.detalle_pedido
    ADD CONSTRAINT detalle_pedido_id_pedido_fkey FOREIGN KEY (id_pedido) REFERENCES public.pedidos(id_pedido) NOT VALID;
 V   ALTER TABLE ONLY public.detalle_pedido DROP CONSTRAINT detalle_pedido_id_pedido_fkey;
       public          postgres    false    204    206    2939            �           2606    16486 .   detalle_pedido detalle_pedido_id_producto_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.detalle_pedido
    ADD CONSTRAINT detalle_pedido_id_producto_fkey FOREIGN KEY (id_producto) REFERENCES public.productos(id_producto);
 X   ALTER TABLE ONLY public.detalle_pedido DROP CONSTRAINT detalle_pedido_id_producto_fkey;
       public          postgres    false    2943    208    204            �           2606    16529 9   dispositivos_cliente dispositivos_cliente_id_cliente_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.dispositivos_cliente
    ADD CONSTRAINT dispositivos_cliente_id_cliente_fkey FOREIGN KEY (id_cliente) REFERENCES public.clientes(id_cliente);
 c   ALTER TABLE ONLY public.dispositivos_cliente DROP CONSTRAINT dispositivos_cliente_id_cliente_fkey;
       public          postgres    false    2935    217    202            �           2606    16542 9   dispositivos_usuario dispositivos_usuario_id_usuario_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.dispositivos_usuario
    ADD CONSTRAINT dispositivos_usuario_id_usuario_fkey FOREIGN KEY (id_usuario) REFERENCES public.usuarios(id_usuario);
 c   ALTER TABLE ONLY public.dispositivos_usuario DROP CONSTRAINT dispositivos_usuario_id_usuario_fkey;
       public          postgres    false    212    2951    219            �           2606    16491    productos id_categoria    FK CONSTRAINT     �   ALTER TABLE ONLY public.productos
    ADD CONSTRAINT id_categoria FOREIGN KEY (id_categoria) REFERENCES public.categorias(id_categoria) NOT VALID;
 @   ALTER TABLE ONLY public.productos DROP CONSTRAINT id_categoria;
       public          postgres    false    208    2928    200            �           2606    16496    productos id_usuario    FK CONSTRAINT     �   ALTER TABLE ONLY public.productos
    ADD CONSTRAINT id_usuario FOREIGN KEY (id_usuario) REFERENCES public.usuarios(id_usuario) NOT VALID;
 >   ALTER TABLE ONLY public.productos DROP CONSTRAINT id_usuario;
       public          postgres    false    2951    208    212            �           2606    16501    pedidos pedidos_id_cliente_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_id_cliente_fkey FOREIGN KEY (id_cliente) REFERENCES public.clientes(id_cliente);
 I   ALTER TABLE ONLY public.pedidos DROP CONSTRAINT pedidos_id_cliente_fkey;
       public          postgres    false    2935    202    206            �           2606    16506 )   valoraciones valoraciones_id_cliente_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.valoraciones
    ADD CONSTRAINT valoraciones_id_cliente_fkey FOREIGN KEY (id_cliente) REFERENCES public.clientes(id_cliente);
 S   ALTER TABLE ONLY public.valoraciones DROP CONSTRAINT valoraciones_id_cliente_fkey;
       public          postgres    false    2935    202    214            �           2606    16511 *   valoraciones valoraciones_id_producto_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.valoraciones
    ADD CONSTRAINT valoraciones_id_producto_fkey FOREIGN KEY (id_producto) REFERENCES public.productos(id_producto);
 T   ALTER TABLE ONLY public.valoraciones DROP CONSTRAINT valoraciones_id_producto_fkey;
       public          postgres    false    208    214    2943            �           2606    16516 ,   valoraciones valoraciones_id_puntuacion_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.valoraciones
    ADD CONSTRAINT valoraciones_id_puntuacion_fkey FOREIGN KEY (id_puntuacion) REFERENCES public.puntuaciones(id_puntuacion);
 V   ALTER TABLE ONLY public.valoraciones DROP CONSTRAINT valoraciones_id_puntuacion_fkey;
       public          postgres    false    2945    210    214            3   �   x�uϱ�0 ��?������q6�IC��#"Y��d/f`2B�dpő"5O����БS�##{��N�֭�[�y�=}��P�����m�`���W��`Κ��^�9�{ԗ\{�KY�=>�����GP����p6 ���I           x�-�AN�0E��)r T5m��.�H ���q;Am�i����Е��?����V!�W �)&$:+�/N��+EWM�����Jo���!��Dc!H�\\�h���8�T]�8_\H;V��pu��,ω�C�"�c�ZV���OUJ�j±!5��~.���3Q�]d�X�u�v�Q���"x^��P�=uc3du/�_�O����)xB���D+��GM����;��Q��9 �_�	��i��-U�A�G5d���(�?b�z�            x�}�͒��������7<�$��6���6�ڶ֞D	�T���`N�K��A��n{�*�*�e�w�h�Lq쑴�L��@}��!y�/nIb ���j�����!��PY�U� �u� ��ο��{���>��@7K{�{"~"���	�°w(�-]�^���h��
.�0 `�+@�� s�<��<< ẨsP1���������4 !piDR�蓠`�Jr��UV�䚮p"������;����i4?��l��[�A����Q���o�ީ�	}��'u�Vj�9���2�Իrj�^I`0 [�]���(q�m#���\V$N��kȡ�A��?{xV�:�`.�Mb�K�쒱�9�Ĉ5)�����-|ofGc�c�B���~2_�x%�%钤�F��1�R0��Gc��J'!�Mmt���#��DN�8$ݠO�Z��dy�lWD�z�tn9梉�<�ݍ��N��l�y#O�'ڼ�3h\4�])�*�W�t(�>l�0}�W�/ۨ!�43�tY�Y�5�"��.mC���eӖy64K]Cď�Z��ãs��-�P�,�`l݉���<�qc�Â,�6#x$��i`�2!��g��@SI���ٞ�2�Ѵ� ue&vb�7�^����b;[�c��U�n.m������E�'m�ydӞu�('%䞖]�H������Uɲ�bO]-G�{�tU���	xX���C��^%w|t�r�YL5G�6��:[���IM����̵ℹܬ���ꋀٽ��"Ȩ����IY�S��pf�-=�R+ʪq�x�܍����:�(���IwV����*��J���x��.6��x%�ݦg�5Ѿ�� X�$�W��(F�-�4c������LK�$k:�T
�Gʇ�2�>�?t�x���!%ͶJ���U��m�2�a3+;�m��=���V����s�k{V �9#�>r��ɩ.�3ݐ삃�(0R��t_T�C���`��b�0YO�;R�u����Gݖ�v�;�Y���{�t~*�7���-�8=�7��pe`�sJcP�39�%ª�]���«h�Gc���PċӍ���/_gWN'�v� ���I�u'�$����t��^�M����[Tw�>�F���g��
0�,�ucȚ��-zI��=�jХ����x_`o_�	�y>�6k�jlf���L�v��/Dmki/g�@�SOn����#�j��{̥����� 6��U�%��6�oZ)��b��j�V����KD�*��C7i����2̏�j�阼�]���طG�Aң^9��8L'Qǉ_^Fyq�ǗP*O>x���+�?�eE��k��e�p��u#NSY���8Q�qk�h����0��a���2ω+u���i���9�;]K%�Ofeպ��a�c����W�\4qҬq����������O�,[9�����H��U�'<�r>+�*�TA��_����m\H�h�$ʹ�&�q�Rr�#zc{ut��P2�&���|>�Q����O) 5pќE��������Ն��L�9���4��f�־<��pl^�Y:|���`�s��yޢ�"G��A�Rw�Vý���R:����1�`�G?�t�RM��(~X$�6d7�<�)����V�p���_U}�zR�5�Ҕ�I�A��f�Z\���M�t���ͧ��\;�q5�MQ{��Q_;���>��m��zT±}���M������.��E6��_���;ʳ� /sS�!�;;�i�:��'�`'�xإS��蒰���}u�y2}#<�w��b��h�%H�J<��z�\s�X/|����������      "   �   x�U�K�!D�pC>��e��I����� %%h�t��;�$-�օ�ea�gJ�K�z�	f�!��[��s��	�G9YG�%(^��u>��E~�&k҄�2��F:����X�v���q�8����F^�1c�hV����P����$UԳ`��� ģ�̶ v$��Z�5@�����/m�n�k��m��׏<���s��ט���Kc      /   z   x�3���K�//V�Qpq���u�t75��S04�3PH*��IQ0�401VЀ)64�Tp�u13�4202�5��54�40�20�26Գ42623�4�2��� �MͭLL��L�M,�R\1z\\\ �!.O      1   e   x�3���K�//V�Qpq���u�t75��S04�3PH*��IQ0�401VЀ)64�Tp�u13�4202�5��54�42�22�26�37��41�4����� �t      $   q   x�e�K
1еt��qr���uJi�x�2rt8LL�D�`O��&�H�L���E��(+�r�+����;]H�B���f�fJ]���\$8s��-&����� ���4T      &   v  x�m�͒� ���<��%���$�T%5��*�Mx�)Kt���i�r��dgS����Gk���C`�~��V`�a��-~e�l�Յ��,�*�ҸZK�(^��d#�pA�lx��+�8X�;`�f3~�~�Lug��lNLMyz����.?/���%���s�պM(�P5�e��Ա�}�X�y��x���6�.lÊ�'�������������m�UVv�˜[JMyf�a6�*\��Z��w?IuS�H���T'��2S>��z�;��*ӣCt��~��~���]c�v�Cm�\s�<1�]��3�v�<��_��Oe�e�'L/�2�ԩ���BR���cR��u:#\�&�s^�6Қ�&D�A��MV3��1E����(73;`,bȐ�>���1���v��i;uwV�(����6�k�U���� ������.c�C�@dY�m��\�Jh���uE� ��IɅ���Q/��Z�o���v��`EV�X��:�:4&q)$��f�0�#�-�>*#u�ۓ@��������7@k罋�/��Z6��d��7�\�����LD�E���z�,s�����g��g�'r��` '�ѩ��m���x/��ų~�?�2^6.��qy��^PJ� rʁ�      (   %   x�3�|4���D��P�m�`���(\�H� "G�      *   *  x�m��n�@�ח�p�V���( ���f��"0#8X��\�|����i�<�=�w�^EX�^V�\r��_[�v���6���*'I&�<�D�MWA]WK���Y����M�eY�R��\�|�[a]�ˍw.���	 P@E��CFOсqI{'�a�u��ߌ��]գ6�lI*�ȩK�7�md=kF���,,��ڲ*��ފ�����V �2㻎I��3H)�v�>���@t�7+~@.���+}D���H�cn4��<ĦV�b��O����$x|r�z����˒$}��z�      ,   �   x�U�An� E��)�� �i���]�麛)�,$�1Rr��!�X�\W����>�@|s9͌�)���##'Gi&�ښF��C��`�X9���M�}xS�ѥ��GXBG1x�qi6v!��<K��1O\0e,9a*Ey�HF8m,�A�%��&��SI����i��h�@qw���#�<)������>�f=�}u���kd���PJ�@�U     