PGDMP         	                y         
   youngblood    13.3 (Debian 13.3-1.pgdg100+1)    13.3 (Debian 13.3-1.pgdg100+1) K    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    16885 
   youngblood    DATABASE     _   CREATE DATABASE youngblood WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'es_SV.UTF-8';
    DROP DATABASE youngblood;
                eduardo    false            �            1259    16886 
   categorias    TABLE     �   CREATE TABLE public.categorias (
    id_categoria integer NOT NULL,
    nombre_categoria character varying(50) NOT NULL,
    descripcion_categoria character varying(250),
    imagen_categoria character varying(50) NOT NULL
);
    DROP TABLE public.categorias;
       public         heap    postgres    false            �            1259    16889    categorias_id_categoria_seq    SEQUENCE     �   CREATE SEQUENCE public.categorias_id_categoria_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE public.categorias_id_categoria_seq;
       public          postgres    false    200            �           0    0    categorias_id_categoria_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE public.categorias_id_categoria_seq OWNED BY public.categorias.id_categoria;
          public          postgres    false    201            �            1259    16891    clientes    TABLE       CREATE TABLE public.clientes (
    id_cliente integer NOT NULL,
    nombres_cliente character varying(50) NOT NULL,
    apellidos_cliente character varying(50) NOT NULL,
    dui_cliente character varying(10) NOT NULL,
    correo_cliente character varying(100) NOT NULL,
    telefono_cliente character varying(9) NOT NULL,
    nacimiento_cliente date NOT NULL,
    clave_cliente character varying(100) NOT NULL,
    estado_cliente boolean DEFAULT true NOT NULL,
    direccion_cliente character varying(200) NOT NULL
);
    DROP TABLE public.clientes;
       public         heap    postgres    false            �            1259    16898    clientes_id_cliente_seq    SEQUENCE     �   CREATE SEQUENCE public.clientes_id_cliente_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.clientes_id_cliente_seq;
       public          postgres    false    202            �           0    0    clientes_id_cliente_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.clientes_id_cliente_seq OWNED BY public.clientes.id_cliente;
          public          postgres    false    203            �            1259    16900    detalle_pedido    TABLE     �   CREATE TABLE public.detalle_pedido (
    id_detalle integer NOT NULL,
    id_producto integer NOT NULL,
    cantidad_producto smallint NOT NULL,
    precio numeric(5,2) NOT NULL,
    id_pedido integer NOT NULL
);
 "   DROP TABLE public.detalle_pedido;
       public         heap    postgres    false            �            1259    16903    detalle_pedidos_id_detalle_seq    SEQUENCE     �   CREATE SEQUENCE public.detalle_pedidos_id_detalle_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 5   DROP SEQUENCE public.detalle_pedidos_id_detalle_seq;
       public          postgres    false    204            �           0    0    detalle_pedidos_id_detalle_seq    SEQUENCE OWNED BY     `   ALTER SEQUENCE public.detalle_pedidos_id_detalle_seq OWNED BY public.detalle_pedido.id_detalle;
          public          postgres    false    205            �            1259    16905    pedidos    TABLE     �   CREATE TABLE public.pedidos (
    id_pedido integer NOT NULL,
    id_cliente integer NOT NULL,
    estado_pedido smallint DEFAULT 0 NOT NULL,
    fecha_pedido date
);
    DROP TABLE public.pedidos;
       public         heap    postgres    false            �            1259    16909    pedidos_id_pedido_seq    SEQUENCE     �   CREATE SEQUENCE public.pedidos_id_pedido_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.pedidos_id_pedido_seq;
       public          postgres    false    206            �           0    0    pedidos_id_pedido_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.pedidos_id_pedido_seq OWNED BY public.pedidos.id_pedido;
          public          postgres    false    207            �            1259    16911 	   productos    TABLE     �  CREATE TABLE public.productos (
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
       public         heap    postgres    false            �            1259    16917    productos_id_producto_seq    SEQUENCE     �   CREATE SEQUENCE public.productos_id_producto_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.productos_id_producto_seq;
       public          postgres    false    208            �           0    0    productos_id_producto_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.productos_id_producto_seq OWNED BY public.productos.id_producto;
          public          postgres    false    209            �            1259    16982    puntuaciones    TABLE     x   CREATE TABLE public.puntuaciones (
    id_puntuacion integer NOT NULL,
    puntuacion character varying(15) NOT NULL
);
     DROP TABLE public.puntuaciones;
       public         heap    eduardo    false            �            1259    16980    puntuaciones_id_puntuacion_seq    SEQUENCE     �   CREATE SEQUENCE public.puntuaciones_id_puntuacion_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 5   DROP SEQUENCE public.puntuaciones_id_puntuacion_seq;
       public          eduardo    false    213            �           0    0    puntuaciones_id_puntuacion_seq    SEQUENCE OWNED BY     a   ALTER SEQUENCE public.puntuaciones_id_puntuacion_seq OWNED BY public.puntuaciones.id_puntuacion;
          public          eduardo    false    212            �            1259    16919    usuarios    TABLE     E  CREATE TABLE public.usuarios (
    id_usuario integer NOT NULL,
    nombres_usuario character varying(50) NOT NULL,
    apellidos_usuario character varying(50) NOT NULL,
    correo_usuario character varying(100) NOT NULL,
    alias_usuario character varying(50) NOT NULL,
    clave_usuario character varying(100) NOT NULL
);
    DROP TABLE public.usuarios;
       public         heap    postgres    false            �            1259    16922    usuarios_id_usuario_seq    SEQUENCE     �   CREATE SEQUENCE public.usuarios_id_usuario_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.usuarios_id_usuario_seq;
       public          postgres    false    210            �           0    0    usuarios_id_usuario_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.usuarios_id_usuario_seq OWNED BY public.usuarios.id_usuario;
          public          postgres    false    211            �            1259    16990    valoraciones    TABLE       CREATE TABLE public.valoraciones (
    id_valoracion integer NOT NULL,
    id_cliente integer NOT NULL,
    valoracion character varying(200) NOT NULL,
    fecha date NOT NULL,
    id_puntuacion integer NOT NULL,
    id_producto integer NOT NULL,
    visibilidad integer
);
     DROP TABLE public.valoraciones;
       public         heap    eduardo    false            �            1259    16988    valoraciones_id_valoracion_seq    SEQUENCE     �   CREATE SEQUENCE public.valoraciones_id_valoracion_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 5   DROP SEQUENCE public.valoraciones_id_valoracion_seq;
       public          eduardo    false    215            �           0    0    valoraciones_id_valoracion_seq    SEQUENCE OWNED BY     a   ALTER SEQUENCE public.valoraciones_id_valoracion_seq OWNED BY public.valoraciones.id_valoracion;
          public          eduardo    false    214                       2604    16924    categorias id_categoria    DEFAULT     �   ALTER TABLE ONLY public.categorias ALTER COLUMN id_categoria SET DEFAULT nextval('public.categorias_id_categoria_seq'::regclass);
 F   ALTER TABLE public.categorias ALTER COLUMN id_categoria DROP DEFAULT;
       public          postgres    false    201    200            !           2604    16925    clientes id_cliente    DEFAULT     z   ALTER TABLE ONLY public.clientes ALTER COLUMN id_cliente SET DEFAULT nextval('public.clientes_id_cliente_seq'::regclass);
 B   ALTER TABLE public.clientes ALTER COLUMN id_cliente DROP DEFAULT;
       public          postgres    false    203    202            "           2604    16926    detalle_pedido id_detalle    DEFAULT     �   ALTER TABLE ONLY public.detalle_pedido ALTER COLUMN id_detalle SET DEFAULT nextval('public.detalle_pedidos_id_detalle_seq'::regclass);
 H   ALTER TABLE public.detalle_pedido ALTER COLUMN id_detalle DROP DEFAULT;
       public          postgres    false    205    204            $           2604    16927    pedidos id_pedido    DEFAULT     v   ALTER TABLE ONLY public.pedidos ALTER COLUMN id_pedido SET DEFAULT nextval('public.pedidos_id_pedido_seq'::regclass);
 @   ALTER TABLE public.pedidos ALTER COLUMN id_pedido DROP DEFAULT;
       public          postgres    false    207    206            %           2604    16928    productos id_producto    DEFAULT     ~   ALTER TABLE ONLY public.productos ALTER COLUMN id_producto SET DEFAULT nextval('public.productos_id_producto_seq'::regclass);
 D   ALTER TABLE public.productos ALTER COLUMN id_producto DROP DEFAULT;
       public          postgres    false    209    208            '           2604    16985    puntuaciones id_puntuacion    DEFAULT     �   ALTER TABLE ONLY public.puntuaciones ALTER COLUMN id_puntuacion SET DEFAULT nextval('public.puntuaciones_id_puntuacion_seq'::regclass);
 I   ALTER TABLE public.puntuaciones ALTER COLUMN id_puntuacion DROP DEFAULT;
       public          eduardo    false    212    213    213            &           2604    16929    usuarios id_usuario    DEFAULT     z   ALTER TABLE ONLY public.usuarios ALTER COLUMN id_usuario SET DEFAULT nextval('public.usuarios_id_usuario_seq'::regclass);
 B   ALTER TABLE public.usuarios ALTER COLUMN id_usuario DROP DEFAULT;
       public          postgres    false    211    210            (           2604    16993    valoraciones id_valoracion    DEFAULT     �   ALTER TABLE ONLY public.valoraciones ALTER COLUMN id_valoracion SET DEFAULT nextval('public.valoraciones_id_valoracion_seq'::regclass);
 I   ALTER TABLE public.valoraciones ALTER COLUMN id_valoracion DROP DEFAULT;
       public          eduardo    false    215    214    215            �          0    16886 
   categorias 
   TABLE DATA           m   COPY public.categorias (id_categoria, nombre_categoria, descripcion_categoria, imagen_categoria) FROM stdin;
    public          postgres    false    200   �_       �          0    16891    clientes 
   TABLE DATA           �   COPY public.clientes (id_cliente, nombres_cliente, apellidos_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, clave_cliente, estado_cliente, direccion_cliente) FROM stdin;
    public          postgres    false    202   *`       �          0    16900    detalle_pedido 
   TABLE DATA           g   COPY public.detalle_pedido (id_detalle, id_producto, cantidad_producto, precio, id_pedido) FROM stdin;
    public          postgres    false    204   �a       �          0    16905    pedidos 
   TABLE DATA           U   COPY public.pedidos (id_pedido, id_cliente, estado_pedido, fecha_pedido) FROM stdin;
    public          postgres    false    206   �a       �          0    16911 	   productos 
   TABLE DATA           �   COPY public.productos (id_producto, nombre_producto, descripcion_producto, precio_producto, imagen_producto, id_categoria, estado_producto, id_usuario, cantidad) FROM stdin;
    public          postgres    false    208   &b       �          0    16982    puntuaciones 
   TABLE DATA           A   COPY public.puntuaciones (id_puntuacion, puntuacion) FROM stdin;
    public          eduardo    false    213   �c       �          0    16919    usuarios 
   TABLE DATA           �   COPY public.usuarios (id_usuario, nombres_usuario, apellidos_usuario, correo_usuario, alias_usuario, clave_usuario) FROM stdin;
    public          postgres    false    210   4d       �          0    16990    valoraciones 
   TABLE DATA           }   COPY public.valoraciones (id_valoracion, id_cliente, valoracion, fecha, id_puntuacion, id_producto, visibilidad) FROM stdin;
    public          eduardo    false    215   �d       �           0    0    categorias_id_categoria_seq    SEQUENCE SET     I   SELECT pg_catalog.setval('public.categorias_id_categoria_seq', 3, true);
          public          postgres    false    201            �           0    0    clientes_id_cliente_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.clientes_id_cliente_seq', 5, true);
          public          postgres    false    203            �           0    0    detalle_pedidos_id_detalle_seq    SEQUENCE SET     M   SELECT pg_catalog.setval('public.detalle_pedidos_id_detalle_seq', 21, true);
          public          postgres    false    205            �           0    0    pedidos_id_pedido_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('public.pedidos_id_pedido_seq', 5, true);
          public          postgres    false    207            �           0    0    productos_id_producto_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.productos_id_producto_seq', 10, true);
          public          postgres    false    209            �           0    0    puntuaciones_id_puntuacion_seq    SEQUENCE SET     L   SELECT pg_catalog.setval('public.puntuaciones_id_puntuacion_seq', 5, true);
          public          eduardo    false    212            �           0    0    usuarios_id_usuario_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.usuarios_id_usuario_seq', 1, true);
          public          postgres    false    211            �           0    0    valoraciones_id_valoracion_seq    SEQUENCE SET     M   SELECT pg_catalog.setval('public.valoraciones_id_valoracion_seq', 13, true);
          public          eduardo    false    214            *           2606    16931 *   categorias categorias_nombre_categoria_key 
   CONSTRAINT     q   ALTER TABLE ONLY public.categorias
    ADD CONSTRAINT categorias_nombre_categoria_key UNIQUE (nombre_categoria);
 T   ALTER TABLE ONLY public.categorias DROP CONSTRAINT categorias_nombre_categoria_key;
       public            postgres    false    200            ,           2606    16933    categorias categorias_pkey 
   CONSTRAINT     b   ALTER TABLE ONLY public.categorias
    ADD CONSTRAINT categorias_pkey PRIMARY KEY (id_categoria);
 D   ALTER TABLE ONLY public.categorias DROP CONSTRAINT categorias_pkey;
       public            postgres    false    200            /           2606    16935 $   clientes clientes_correo_cliente_key 
   CONSTRAINT     i   ALTER TABLE ONLY public.clientes
    ADD CONSTRAINT clientes_correo_cliente_key UNIQUE (correo_cliente);
 N   ALTER TABLE ONLY public.clientes DROP CONSTRAINT clientes_correo_cliente_key;
       public            postgres    false    202            1           2606    16937 !   clientes clientes_dui_cliente_key 
   CONSTRAINT     c   ALTER TABLE ONLY public.clientes
    ADD CONSTRAINT clientes_dui_cliente_key UNIQUE (dui_cliente);
 K   ALTER TABLE ONLY public.clientes DROP CONSTRAINT clientes_dui_cliente_key;
       public            postgres    false    202            3           2606    16939    clientes clientes_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.clientes
    ADD CONSTRAINT clientes_pkey PRIMARY KEY (id_cliente);
 @   ALTER TABLE ONLY public.clientes DROP CONSTRAINT clientes_pkey;
       public            postgres    false    202            5           2606    16941 "   detalle_pedido detalle_pedido_pkey 
   CONSTRAINT     h   ALTER TABLE ONLY public.detalle_pedido
    ADD CONSTRAINT detalle_pedido_pkey PRIMARY KEY (id_detalle);
 L   ALTER TABLE ONLY public.detalle_pedido DROP CONSTRAINT detalle_pedido_pkey;
       public            postgres    false    204            7           2606    16943    pedidos pedidos_pkey 
   CONSTRAINT     Y   ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_pkey PRIMARY KEY (id_pedido);
 >   ALTER TABLE ONLY public.pedidos DROP CONSTRAINT pedidos_pkey;
       public            postgres    false    206            9           2606    16945 '   productos productos_nombre_producto_key 
   CONSTRAINT     m   ALTER TABLE ONLY public.productos
    ADD CONSTRAINT productos_nombre_producto_key UNIQUE (nombre_producto);
 Q   ALTER TABLE ONLY public.productos DROP CONSTRAINT productos_nombre_producto_key;
       public            postgres    false    208            ;           2606    16947    productos productos_pkey 
   CONSTRAINT     _   ALTER TABLE ONLY public.productos
    ADD CONSTRAINT productos_pkey PRIMARY KEY (id_producto);
 B   ALTER TABLE ONLY public.productos DROP CONSTRAINT productos_pkey;
       public            postgres    false    208            C           2606    16987    puntuaciones puntuaciones_pkey 
   CONSTRAINT     g   ALTER TABLE ONLY public.puntuaciones
    ADD CONSTRAINT puntuaciones_pkey PRIMARY KEY (id_puntuacion);
 H   ALTER TABLE ONLY public.puntuaciones DROP CONSTRAINT puntuaciones_pkey;
       public            eduardo    false    213            =           2606    16949 #   usuarios usuarios_alias_usuario_key 
   CONSTRAINT     g   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_alias_usuario_key UNIQUE (alias_usuario);
 M   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT usuarios_alias_usuario_key;
       public            postgres    false    210            ?           2606    16951 $   usuarios usuarios_correo_usuario_key 
   CONSTRAINT     i   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_correo_usuario_key UNIQUE (correo_usuario);
 N   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT usuarios_correo_usuario_key;
       public            postgres    false    210            A           2606    16953    usuarios usuarios_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id_usuario);
 @   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT usuarios_pkey;
       public            postgres    false    210            E           2606    16995    valoraciones valoraciones_pkey 
   CONSTRAINT     g   ALTER TABLE ONLY public.valoraciones
    ADD CONSTRAINT valoraciones_pkey PRIMARY KEY (id_valoracion);
 H   ALTER TABLE ONLY public.valoraciones DROP CONSTRAINT valoraciones_pkey;
       public            eduardo    false    215            -           1259    16954    nombre_index    INDEX     V   CREATE UNIQUE INDEX nombre_index ON public.categorias USING btree (nombre_categoria);
     DROP INDEX public.nombre_index;
       public            postgres    false    200            F           2606    16955 ,   detalle_pedido detalle_pedido_id_pedido_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.detalle_pedido
    ADD CONSTRAINT detalle_pedido_id_pedido_fkey FOREIGN KEY (id_pedido) REFERENCES public.pedidos(id_pedido) NOT VALID;
 V   ALTER TABLE ONLY public.detalle_pedido DROP CONSTRAINT detalle_pedido_id_pedido_fkey;
       public          postgres    false    204    206    2871            G           2606    16960 .   detalle_pedido detalle_pedido_id_producto_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.detalle_pedido
    ADD CONSTRAINT detalle_pedido_id_producto_fkey FOREIGN KEY (id_producto) REFERENCES public.productos(id_producto);
 X   ALTER TABLE ONLY public.detalle_pedido DROP CONSTRAINT detalle_pedido_id_producto_fkey;
       public          postgres    false    208    2875    204            I           2606    16965    productos id_categoria    FK CONSTRAINT     �   ALTER TABLE ONLY public.productos
    ADD CONSTRAINT id_categoria FOREIGN KEY (id_categoria) REFERENCES public.categorias(id_categoria) NOT VALID;
 @   ALTER TABLE ONLY public.productos DROP CONSTRAINT id_categoria;
       public          postgres    false    208    2860    200            J           2606    16970    productos id_usuario    FK CONSTRAINT     �   ALTER TABLE ONLY public.productos
    ADD CONSTRAINT id_usuario FOREIGN KEY (id_usuario) REFERENCES public.usuarios(id_usuario) NOT VALID;
 >   ALTER TABLE ONLY public.productos DROP CONSTRAINT id_usuario;
       public          postgres    false    208    210    2881            H           2606    16975    pedidos pedidos_id_cliente_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_id_cliente_fkey FOREIGN KEY (id_cliente) REFERENCES public.clientes(id_cliente);
 I   ALTER TABLE ONLY public.pedidos DROP CONSTRAINT pedidos_id_cliente_fkey;
       public          postgres    false    206    2867    202            K           2606    16996 )   valoraciones valoraciones_id_cliente_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.valoraciones
    ADD CONSTRAINT valoraciones_id_cliente_fkey FOREIGN KEY (id_cliente) REFERENCES public.clientes(id_cliente);
 S   ALTER TABLE ONLY public.valoraciones DROP CONSTRAINT valoraciones_id_cliente_fkey;
       public          eduardo    false    215    202    2867            M           2606    17006 *   valoraciones valoraciones_id_producto_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.valoraciones
    ADD CONSTRAINT valoraciones_id_producto_fkey FOREIGN KEY (id_producto) REFERENCES public.productos(id_producto);
 T   ALTER TABLE ONLY public.valoraciones DROP CONSTRAINT valoraciones_id_producto_fkey;
       public          eduardo    false    208    2875    215            L           2606    17001 ,   valoraciones valoraciones_id_puntuacion_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.valoraciones
    ADD CONSTRAINT valoraciones_id_puntuacion_fkey FOREIGN KEY (id_puntuacion) REFERENCES public.puntuaciones(id_puntuacion);
 V   ALTER TABLE ONLY public.valoraciones DROP CONSTRAINT valoraciones_id_puntuacion_fkey;
       public          eduardo    false    215    2883    213            �   �   x�-�;� �N�'@�DV�s�H�4�b$�" 9�E5���L��,��gK��#�/�g?X�epmd��Ъ?r+&��%���g8� yۢCڴu�^.8��ιv���yش��v
v�F��v��[I)���7�      �   ]  x�m�Ir�@��us
nQh��]H��%"�C���Gۈa�f��#�b!������w�ԇ��#eQJy#�3
���b���Q
��LUӅ1z��w/	D�p�%HS04����,�D�p;�ā�mW�l�AN��1}cEp�yzI�ɴ�Ln\�L�E�8^U��DF��P�F�,��#��W��ov4�"#����#����F�{#��!�W��˨*�|Q��1�E~Km��senli�o��_BQnj�>�+"�����P���)�Z��h����I�=��􇣩�����>���,&���v��X�殖�i��?�r;,&K+���Z���N����)���!�q�АE      �   A   x�5���0��T��2�Ľ�8�ܹSbB�2w\ԃX��pS�k��*��`�!~	�-�^#�V'�      �   .   x�3�4�4�4202�5��50�2
C�u͹L�F�*b���� �y�      �   �  x�mSMo� <ï�D?۞EiOU/�WBd�vZ����{n���3�3K�~�kH��^��� Q0;�,!�	�4�AcC)ꩥ�����_G+b��������g����2�q�w���Uм-'(Fѷ��D��[��i��^۱���&�N�n��"Qa$9b7��ޝ}��;�i.5+�Y��<�/Yl�����!2���)�'�eg�)�"!�������>����,tm���(���G�)+�/��nk(;��1�(�X�:�S,n�Ֆ���֋�+hȮ��4�]�
����Ԑ��z�N�Wu�ѡ���=�2Ә����{��>gD�\�`11��ݺ)���rѫ���3�jƣy���}��B�ƕPl���Q{C��-�=���o�^V�XϏV?�DC�;x��{�b����yM)fU\}>�(�Q�-?�{_�k|g�e�?Kk��c����      �   %   x�3�|4���D��P�m�`���(\�H� "G�      �   v   x�3�tM)M,J���,K-J�,�,�KM)54pH�M���K����M�J� *T�*UT��,-"�K=2�J�=���B�J��C3��"��#���L}2��ܽM�
s��2�b���� ��%�      �   }   x�U�1�0Eg��@��6@W���%J-���&�8>�R������#��������.���}]55�--5�d�j4��:ps����1��;u�4�Kk�룮~��z:���o8 �O���*m     