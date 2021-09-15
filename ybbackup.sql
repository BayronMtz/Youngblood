PGDMP     0                    y         
   youngblood    13.4 (Debian 13.4-1.pgdg100+1)    13.4 (Debian 13.4-1.pgdg100+1) K    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    16746 
   youngblood    DATABASE     _   CREATE DATABASE youngblood WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'es_SV.UTF-8';
    DROP DATABASE youngblood;
                eduardo    false            �            1259    16747 
   categorias    TABLE     �   CREATE TABLE public.categorias (
    id_categoria integer NOT NULL,
    nombre_categoria character varying(50) NOT NULL,
    descripcion_categoria character varying(250),
    imagen_categoria character varying(50) NOT NULL
);
    DROP TABLE public.categorias;
       public         heap    postgres    false            �            1259    16750    categorias_id_categoria_seq    SEQUENCE     �   CREATE SEQUENCE public.categorias_id_categoria_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE public.categorias_id_categoria_seq;
       public          postgres    false    200            �           0    0    categorias_id_categoria_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE public.categorias_id_categoria_seq OWNED BY public.categorias.id_categoria;
          public          postgres    false    201            �            1259    16752    clientes    TABLE     H  CREATE TABLE public.clientes (
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
    alias_usuario character varying(30)
);
    DROP TABLE public.clientes;
       public         heap    postgres    false            �            1259    16759    clientes_id_cliente_seq    SEQUENCE     �   CREATE SEQUENCE public.clientes_id_cliente_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.clientes_id_cliente_seq;
       public          postgres    false    202            �           0    0    clientes_id_cliente_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.clientes_id_cliente_seq OWNED BY public.clientes.id_cliente;
          public          postgres    false    203            �            1259    16761    detalle_pedido    TABLE     �   CREATE TABLE public.detalle_pedido (
    id_detalle integer NOT NULL,
    id_producto integer NOT NULL,
    cantidad_producto smallint NOT NULL,
    precio numeric(5,2) NOT NULL,
    id_pedido integer NOT NULL
);
 "   DROP TABLE public.detalle_pedido;
       public         heap    postgres    false            �            1259    16764    detalle_pedidos_id_detalle_seq    SEQUENCE     �   CREATE SEQUENCE public.detalle_pedidos_id_detalle_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 5   DROP SEQUENCE public.detalle_pedidos_id_detalle_seq;
       public          postgres    false    204            �           0    0    detalle_pedidos_id_detalle_seq    SEQUENCE OWNED BY     `   ALTER SEQUENCE public.detalle_pedidos_id_detalle_seq OWNED BY public.detalle_pedido.id_detalle;
          public          postgres    false    205            �            1259    16766    pedidos    TABLE     �   CREATE TABLE public.pedidos (
    id_pedido integer NOT NULL,
    id_cliente integer NOT NULL,
    estado_pedido smallint DEFAULT 0 NOT NULL,
    fecha_pedido date
);
    DROP TABLE public.pedidos;
       public         heap    postgres    false            �            1259    16770    pedidos_id_pedido_seq    SEQUENCE     �   CREATE SEQUENCE public.pedidos_id_pedido_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.pedidos_id_pedido_seq;
       public          postgres    false    206            �           0    0    pedidos_id_pedido_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.pedidos_id_pedido_seq OWNED BY public.pedidos.id_pedido;
          public          postgres    false    207            �            1259    16772 	   productos    TABLE     �  CREATE TABLE public.productos (
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
       public         heap    postgres    false            �            1259    16778    productos_id_producto_seq    SEQUENCE     �   CREATE SEQUENCE public.productos_id_producto_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.productos_id_producto_seq;
       public          postgres    false    208            �           0    0    productos_id_producto_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.productos_id_producto_seq OWNED BY public.productos.id_producto;
          public          postgres    false    209            �            1259    16780    puntuaciones    TABLE     x   CREATE TABLE public.puntuaciones (
    id_puntuacion integer NOT NULL,
    puntuacion character varying(15) NOT NULL
);
     DROP TABLE public.puntuaciones;
       public         heap    postgres    false            �            1259    16783    puntuaciones_id_puntuacion_seq    SEQUENCE     �   CREATE SEQUENCE public.puntuaciones_id_puntuacion_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 5   DROP SEQUENCE public.puntuaciones_id_puntuacion_seq;
       public          postgres    false    210            �           0    0    puntuaciones_id_puntuacion_seq    SEQUENCE OWNED BY     a   ALTER SEQUENCE public.puntuaciones_id_puntuacion_seq OWNED BY public.puntuaciones.id_puntuacion;
          public          postgres    false    211            �            1259    16785    usuarios    TABLE     E  CREATE TABLE public.usuarios (
    id_usuario integer NOT NULL,
    nombres_usuario character varying(50) NOT NULL,
    apellidos_usuario character varying(50) NOT NULL,
    correo_usuario character varying(100) NOT NULL,
    alias_usuario character varying(50) NOT NULL,
    clave_usuario character varying(100) NOT NULL
);
    DROP TABLE public.usuarios;
       public         heap    postgres    false            �            1259    16788    usuarios_id_usuario_seq    SEQUENCE     �   CREATE SEQUENCE public.usuarios_id_usuario_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.usuarios_id_usuario_seq;
       public          postgres    false    212            �           0    0    usuarios_id_usuario_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.usuarios_id_usuario_seq OWNED BY public.usuarios.id_usuario;
          public          postgres    false    213            �            1259    16790    valoraciones    TABLE       CREATE TABLE public.valoraciones (
    id_valoracion integer NOT NULL,
    id_cliente integer NOT NULL,
    valoracion character varying(200) NOT NULL,
    fecha date NOT NULL,
    id_puntuacion integer NOT NULL,
    id_producto integer NOT NULL,
    visibilidad integer
);
     DROP TABLE public.valoraciones;
       public         heap    postgres    false            �            1259    16793    valoraciones_id_valoracion_seq    SEQUENCE     �   CREATE SEQUENCE public.valoraciones_id_valoracion_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 5   DROP SEQUENCE public.valoraciones_id_valoracion_seq;
       public          postgres    false    214            �           0    0    valoraciones_id_valoracion_seq    SEQUENCE OWNED BY     a   ALTER SEQUENCE public.valoraciones_id_valoracion_seq OWNED BY public.valoraciones.id_valoracion;
          public          postgres    false    215                       2604    16795    categorias id_categoria    DEFAULT     �   ALTER TABLE ONLY public.categorias ALTER COLUMN id_categoria SET DEFAULT nextval('public.categorias_id_categoria_seq'::regclass);
 F   ALTER TABLE public.categorias ALTER COLUMN id_categoria DROP DEFAULT;
       public          postgres    false    201    200            !           2604    16796    clientes id_cliente    DEFAULT     z   ALTER TABLE ONLY public.clientes ALTER COLUMN id_cliente SET DEFAULT nextval('public.clientes_id_cliente_seq'::regclass);
 B   ALTER TABLE public.clientes ALTER COLUMN id_cliente DROP DEFAULT;
       public          postgres    false    203    202            "           2604    16797    detalle_pedido id_detalle    DEFAULT     �   ALTER TABLE ONLY public.detalle_pedido ALTER COLUMN id_detalle SET DEFAULT nextval('public.detalle_pedidos_id_detalle_seq'::regclass);
 H   ALTER TABLE public.detalle_pedido ALTER COLUMN id_detalle DROP DEFAULT;
       public          postgres    false    205    204            $           2604    16798    pedidos id_pedido    DEFAULT     v   ALTER TABLE ONLY public.pedidos ALTER COLUMN id_pedido SET DEFAULT nextval('public.pedidos_id_pedido_seq'::regclass);
 @   ALTER TABLE public.pedidos ALTER COLUMN id_pedido DROP DEFAULT;
       public          postgres    false    207    206            %           2604    16799    productos id_producto    DEFAULT     ~   ALTER TABLE ONLY public.productos ALTER COLUMN id_producto SET DEFAULT nextval('public.productos_id_producto_seq'::regclass);
 D   ALTER TABLE public.productos ALTER COLUMN id_producto DROP DEFAULT;
       public          postgres    false    209    208            &           2604    16800    puntuaciones id_puntuacion    DEFAULT     �   ALTER TABLE ONLY public.puntuaciones ALTER COLUMN id_puntuacion SET DEFAULT nextval('public.puntuaciones_id_puntuacion_seq'::regclass);
 I   ALTER TABLE public.puntuaciones ALTER COLUMN id_puntuacion DROP DEFAULT;
       public          postgres    false    211    210            '           2604    16801    usuarios id_usuario    DEFAULT     z   ALTER TABLE ONLY public.usuarios ALTER COLUMN id_usuario SET DEFAULT nextval('public.usuarios_id_usuario_seq'::regclass);
 B   ALTER TABLE public.usuarios ALTER COLUMN id_usuario DROP DEFAULT;
       public          postgres    false    213    212            (           2604    16802    valoraciones id_valoracion    DEFAULT     �   ALTER TABLE ONLY public.valoraciones ALTER COLUMN id_valoracion SET DEFAULT nextval('public.valoraciones_id_valoracion_seq'::regclass);
 I   ALTER TABLE public.valoraciones ALTER COLUMN id_valoracion DROP DEFAULT;
       public          postgres    false    215    214            �          0    16747 
   categorias 
   TABLE DATA           m   COPY public.categorias (id_categoria, nombre_categoria, descripcion_categoria, imagen_categoria) FROM stdin;
    public          postgres    false    200   �_       �          0    16752    clientes 
   TABLE DATA           �   COPY public.clientes (id_cliente, nombres_cliente, apellidos_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, clave_cliente, estado_cliente, direccion_cliente, fecha_registro, alias_usuario) FROM stdin;
    public          postgres    false    202   a       �          0    16761    detalle_pedido 
   TABLE DATA           g   COPY public.detalle_pedido (id_detalle, id_producto, cantidad_producto, precio, id_pedido) FROM stdin;
    public          postgres    false    204   [g       �          0    16766    pedidos 
   TABLE DATA           U   COPY public.pedidos (id_pedido, id_cliente, estado_pedido, fecha_pedido) FROM stdin;
    public          postgres    false    206   ?h       �          0    16772 	   productos 
   TABLE DATA           �   COPY public.productos (id_producto, nombre_producto, descripcion_producto, precio_producto, imagen_producto, id_categoria, estado_producto, id_usuario, cantidad) FROM stdin;
    public          postgres    false    208   �h       �          0    16780    puntuaciones 
   TABLE DATA           A   COPY public.puntuaciones (id_puntuacion, puntuacion) FROM stdin;
    public          postgres    false    210   Fk       �          0    16785    usuarios 
   TABLE DATA           �   COPY public.usuarios (id_usuario, nombres_usuario, apellidos_usuario, correo_usuario, alias_usuario, clave_usuario) FROM stdin;
    public          postgres    false    212   {k       �          0    16790    valoraciones 
   TABLE DATA           }   COPY public.valoraciones (id_valoracion, id_cliente, valoracion, fecha, id_puntuacion, id_producto, visibilidad) FROM stdin;
    public          postgres    false    214   ]l       �           0    0    categorias_id_categoria_seq    SEQUENCE SET     I   SELECT pg_catalog.setval('public.categorias_id_categoria_seq', 7, true);
          public          postgres    false    201            �           0    0    clientes_id_cliente_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.clientes_id_cliente_seq', 18, true);
          public          postgres    false    203            �           0    0    detalle_pedidos_id_detalle_seq    SEQUENCE SET     M   SELECT pg_catalog.setval('public.detalle_pedidos_id_detalle_seq', 49, true);
          public          postgres    false    205            �           0    0    pedidos_id_pedido_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('public.pedidos_id_pedido_seq', 20, true);
          public          postgres    false    207            �           0    0    productos_id_producto_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.productos_id_producto_seq', 15, true);
          public          postgres    false    209            �           0    0    puntuaciones_id_puntuacion_seq    SEQUENCE SET     L   SELECT pg_catalog.setval('public.puntuaciones_id_puntuacion_seq', 5, true);
          public          postgres    false    211            �           0    0    usuarios_id_usuario_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.usuarios_id_usuario_seq', 2, true);
          public          postgres    false    213            �           0    0    valoraciones_id_valoracion_seq    SEQUENCE SET     M   SELECT pg_catalog.setval('public.valoraciones_id_valoracion_seq', 16, true);
          public          postgres    false    215            *           2606    16804 *   categorias categorias_nombre_categoria_key 
   CONSTRAINT     q   ALTER TABLE ONLY public.categorias
    ADD CONSTRAINT categorias_nombre_categoria_key UNIQUE (nombre_categoria);
 T   ALTER TABLE ONLY public.categorias DROP CONSTRAINT categorias_nombre_categoria_key;
       public            postgres    false    200            ,           2606    16806    categorias categorias_pkey 
   CONSTRAINT     b   ALTER TABLE ONLY public.categorias
    ADD CONSTRAINT categorias_pkey PRIMARY KEY (id_categoria);
 D   ALTER TABLE ONLY public.categorias DROP CONSTRAINT categorias_pkey;
       public            postgres    false    200            /           2606    16808 $   clientes clientes_correo_cliente_key 
   CONSTRAINT     i   ALTER TABLE ONLY public.clientes
    ADD CONSTRAINT clientes_correo_cliente_key UNIQUE (correo_cliente);
 N   ALTER TABLE ONLY public.clientes DROP CONSTRAINT clientes_correo_cliente_key;
       public            postgres    false    202            1           2606    16810 !   clientes clientes_dui_cliente_key 
   CONSTRAINT     c   ALTER TABLE ONLY public.clientes
    ADD CONSTRAINT clientes_dui_cliente_key UNIQUE (dui_cliente);
 K   ALTER TABLE ONLY public.clientes DROP CONSTRAINT clientes_dui_cliente_key;
       public            postgres    false    202            3           2606    16812    clientes clientes_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.clientes
    ADD CONSTRAINT clientes_pkey PRIMARY KEY (id_cliente);
 @   ALTER TABLE ONLY public.clientes DROP CONSTRAINT clientes_pkey;
       public            postgres    false    202            5           2606    16814 "   detalle_pedido detalle_pedido_pkey 
   CONSTRAINT     h   ALTER TABLE ONLY public.detalle_pedido
    ADD CONSTRAINT detalle_pedido_pkey PRIMARY KEY (id_detalle);
 L   ALTER TABLE ONLY public.detalle_pedido DROP CONSTRAINT detalle_pedido_pkey;
       public            postgres    false    204            7           2606    16816    pedidos pedidos_pkey 
   CONSTRAINT     Y   ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_pkey PRIMARY KEY (id_pedido);
 >   ALTER TABLE ONLY public.pedidos DROP CONSTRAINT pedidos_pkey;
       public            postgres    false    206            9           2606    16818 '   productos productos_nombre_producto_key 
   CONSTRAINT     m   ALTER TABLE ONLY public.productos
    ADD CONSTRAINT productos_nombre_producto_key UNIQUE (nombre_producto);
 Q   ALTER TABLE ONLY public.productos DROP CONSTRAINT productos_nombre_producto_key;
       public            postgres    false    208            ;           2606    16820    productos productos_pkey 
   CONSTRAINT     _   ALTER TABLE ONLY public.productos
    ADD CONSTRAINT productos_pkey PRIMARY KEY (id_producto);
 B   ALTER TABLE ONLY public.productos DROP CONSTRAINT productos_pkey;
       public            postgres    false    208            =           2606    16822    puntuaciones puntuaciones_pkey 
   CONSTRAINT     g   ALTER TABLE ONLY public.puntuaciones
    ADD CONSTRAINT puntuaciones_pkey PRIMARY KEY (id_puntuacion);
 H   ALTER TABLE ONLY public.puntuaciones DROP CONSTRAINT puntuaciones_pkey;
       public            postgres    false    210            ?           2606    16824 #   usuarios usuarios_alias_usuario_key 
   CONSTRAINT     g   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_alias_usuario_key UNIQUE (alias_usuario);
 M   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT usuarios_alias_usuario_key;
       public            postgres    false    212            A           2606    16826 $   usuarios usuarios_correo_usuario_key 
   CONSTRAINT     i   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_correo_usuario_key UNIQUE (correo_usuario);
 N   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT usuarios_correo_usuario_key;
       public            postgres    false    212            C           2606    16828    usuarios usuarios_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id_usuario);
 @   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT usuarios_pkey;
       public            postgres    false    212            E           2606    16830    valoraciones valoraciones_pkey 
   CONSTRAINT     g   ALTER TABLE ONLY public.valoraciones
    ADD CONSTRAINT valoraciones_pkey PRIMARY KEY (id_valoracion);
 H   ALTER TABLE ONLY public.valoraciones DROP CONSTRAINT valoraciones_pkey;
       public            postgres    false    214            -           1259    16831    nombre_index    INDEX     V   CREATE UNIQUE INDEX nombre_index ON public.categorias USING btree (nombre_categoria);
     DROP INDEX public.nombre_index;
       public            postgres    false    200            F           2606    16832 ,   detalle_pedido detalle_pedido_id_pedido_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.detalle_pedido
    ADD CONSTRAINT detalle_pedido_id_pedido_fkey FOREIGN KEY (id_pedido) REFERENCES public.pedidos(id_pedido) NOT VALID;
 V   ALTER TABLE ONLY public.detalle_pedido DROP CONSTRAINT detalle_pedido_id_pedido_fkey;
       public          postgres    false    204    2871    206            G           2606    16837 .   detalle_pedido detalle_pedido_id_producto_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.detalle_pedido
    ADD CONSTRAINT detalle_pedido_id_producto_fkey FOREIGN KEY (id_producto) REFERENCES public.productos(id_producto);
 X   ALTER TABLE ONLY public.detalle_pedido DROP CONSTRAINT detalle_pedido_id_producto_fkey;
       public          postgres    false    208    204    2875            I           2606    16842    productos id_categoria    FK CONSTRAINT     �   ALTER TABLE ONLY public.productos
    ADD CONSTRAINT id_categoria FOREIGN KEY (id_categoria) REFERENCES public.categorias(id_categoria) NOT VALID;
 @   ALTER TABLE ONLY public.productos DROP CONSTRAINT id_categoria;
       public          postgres    false    2860    200    208            J           2606    16847    productos id_usuario    FK CONSTRAINT     �   ALTER TABLE ONLY public.productos
    ADD CONSTRAINT id_usuario FOREIGN KEY (id_usuario) REFERENCES public.usuarios(id_usuario) NOT VALID;
 >   ALTER TABLE ONLY public.productos DROP CONSTRAINT id_usuario;
       public          postgres    false    212    208    2883            H           2606    16852    pedidos pedidos_id_cliente_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_id_cliente_fkey FOREIGN KEY (id_cliente) REFERENCES public.clientes(id_cliente);
 I   ALTER TABLE ONLY public.pedidos DROP CONSTRAINT pedidos_id_cliente_fkey;
       public          postgres    false    2867    202    206            K           2606    16857 )   valoraciones valoraciones_id_cliente_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.valoraciones
    ADD CONSTRAINT valoraciones_id_cliente_fkey FOREIGN KEY (id_cliente) REFERENCES public.clientes(id_cliente);
 S   ALTER TABLE ONLY public.valoraciones DROP CONSTRAINT valoraciones_id_cliente_fkey;
       public          postgres    false    202    2867    214            L           2606    16862 *   valoraciones valoraciones_id_producto_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.valoraciones
    ADD CONSTRAINT valoraciones_id_producto_fkey FOREIGN KEY (id_producto) REFERENCES public.productos(id_producto);
 T   ALTER TABLE ONLY public.valoraciones DROP CONSTRAINT valoraciones_id_producto_fkey;
       public          postgres    false    2875    208    214            M           2606    16867 ,   valoraciones valoraciones_id_puntuacion_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.valoraciones
    ADD CONSTRAINT valoraciones_id_puntuacion_fkey FOREIGN KEY (id_puntuacion) REFERENCES public.puntuaciones(id_puntuacion);
 V   ALTER TABLE ONLY public.valoraciones DROP CONSTRAINT valoraciones_id_puntuacion_fkey;
       public          postgres    false    214    210    2877            �     x�-�AN�0E��)r T5m��.�H ���q;Am�i����Е��?����V!�W �)&$:+�/N��+EWM�����Jo���!��Dc!H�\\�h���8�T]�8_\H;V��pu��,ω�C�"�c�ZV���OUJ�j±!5��~.���3Q�]d�X�u�v�Q���"x^��P�=uc3du/�_�O����)xB���D+��GM����;��Q��9 �_�	��i��-U�A�G5d���(�?b�z�      �   4  x�u�˖�8���)�aC�p�5*^����t�$JP����az��P/�A��u�z�Z&>���c�F��O�z3	�3H\����$�0�H�P����������a1�5U4]U 4MS�� ���?���)�_�\b�u�=����Ƌ�In�F.E2��.�0g`��;@���
�|�,:�t�"4L��NB�)�I���BE�X���3�aj��w�!��9�.�����,^^�N:�g��a��r�OӋ�O{�N8�$��;[�H�,��uĘ�5�a�%ɚ$�z�%����g��ԕ� �Ywա'ZM-_B2t~WI$E@ʃV~W�t�_V�=T�+���vq#o���kI�����2�
��`��8��tG�K�;`�9�Hb0${�[�(+�"H���\��gMUMLŸWJ4�A��^�u��R���5(��Kf�t�,j(�c�<N������ZRuf���;b�e?弑ՠ���b��҇~�����"D�t��`�����f�OϦ���M/]�W�p�-D���_vDtE���:�"҆՝�w����0��p��&τ��!�B��s����)��$�����'5e�*s����|��q���ʜ�GS]�f�n�Z��,�C��'����nd���U�d��љ<��G׸�}��>���UU��V��_{Z2u�z���o�W/�We:�L�b�)Y-���h��6]�c��'ez�[mej�����/U�ϭA�,�<��(�R�J����j��%U��$?��7��;W��:j��ӺB2|q�F�fm������<毤y��3C�߫9��~��ѷ��t5�����"`�Gn�����n���H�����$�����H�s895m�A5x77yS�K��Fʹ��~�hSW���d ��C/�\��=�x�qR�*�"�^Ee�Q^w����,q2���9Tt��n����j�j��l;J�v��J�13'ݖ�tg��0�H{�����6���'��b����0�B���<;�$i�kD�MYZ�/����}��0+R�� ���(��X�x7w����l=2��m&��κ����A_m���<V�*���WZ���;f�>O�2HH��]L�Cբ�FHq�H�J���DD��{^�&��ɺy]G٥����r9��5��,�O��bƽ��%��&�3���$˯� �u+�&�8BE��䟼54�5aT��{�"���۷-(���c����l�Ѹ˧�x�:S�]̍�jE�隝�;`��,\�x�wY2q�[�����XԠ^�Y��f@���x[�C\|�/H0t]$d�i��C�/W��z�	ܦ�q��2#S�������6F�H18yE9_�������֪�jPM�D,�?���7W��/����ɻK0��Д����	�_9ԉH�LLs��CA�̇	t��.�4W���tҮ��M����� Yq{�����B]�z��+�Ѿ�Ix�[�T� 7g;,���>���Gn&Y��'.�v�����/���᝔7���7��M/��D�a�*C��!;b�]7ܸGg<H�lu��آ�g�ߏH��@�X�C��j�qU      �   �   x�U�K�!D�pC>��e��I����� %%h�t��;�$-�օ�ea�gJ�K�z�	f�!��[��s��	�G9YG�%(^��u>��E~�&k҄�2��F:����X�v���q�8����F^�1c�hV����P����$UԳ`��� ģ�̶ v$��Z�5@�����/m�n�k��m��׏<���s��ט���Kc      �   q   x�e�K
1еt��qr���uJi�x�2rt8LL�D�`O��&�H�L���E��(+�r�+����;]H�B���f�fJ]���\$8s��-&����� ���4T      �   v  x�m�͒� ���<��%���$�T%5��*�Mx�)Kt���i�r��dgS����Gk���C`�~��V`�a��-~e�l�Յ��,�*�ҸZK�(^��d#�pA�lx��+�8X�;`�f3~�~�Lug��lNLMyz����.?/���%���s�պM(�P5�e��Ա�}�X�y��x���6�.lÊ�'�������������m�UVv�˜[JMyf�a6�*\��Z��w?IuS�H���T'��2S>��z�;��*ӣCt��~��~���]c�v�Cm�\s�<1�]��3�v�<��_��Oe�e�'L/�2�ԩ���BR���cR��u:#\�&�s^�6Қ�&D�A��MV3��1E����(73;`,bȐ�>���1���v��i;uwV�(����6�k�U���� ������.c�C�@dY�m��\�Jh���uE� ��IɅ���Q/��Z�o���v��`EV�X��:�:4&q)$��f�0�#�-�>*#u�ۓ@��������7@k罋�/��Z6��d��7�\�����LD�E���z�,s�����g��g�'r��` '�ѩ��m���x/��ų~�?�2^6.��qy��^PJ� rʁ�      �   %   x�3�|4���D��P�m�`���(\�H� "G�      �   �   x�M��n�0���Sx�\
ꁛRP�6L�2���C:W�2K��w�)|�mf&;~_���Q���"�!h��c�5ȊM�~r|�x�Y���Ci��<�4��K�`�4[N��v�9ӏe���'��4�A�w�
{����v�ՍB��J�#.��P���(�������M���إB�D���s,�,Z�9'�E���'p#&%�l��{��N��`����Lg      �   �   x�U�An� E��)�� �i���]�麛)�,$�1Rr��!�X�\W����>�@|s9͌�)���##'Gi&�ښF��C��`�X9���M�}xS�ѥ��GXBG1x�qi6v!��<K��1O\0e,9a*Ey�HF8m,�A�%��&��SI����i��h�@qw���#�<)������>�f=�}u���kd���PJ�@�U     