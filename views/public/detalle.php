<?php
// Se incluye la clase con las plantillas del documento.
require_once('../../app/helpers/public_page.php');
// Se imprime la plantilla del encabezado enviando el título de la página web.
Public_Page::headerTemplate('Detalles del producto');
?>

<!-- Contenedor para mostrar el detalle del producto seleccionado previamente -->
<div class="container">
    <!-- Título del contenido principal -->
    <h3 class="center indigo-text" id="title">Detalles del producto</h3>
    <div class="row" id="detalle">
        <!-- Componente Horizontal Card para mostrar el detalle de un producto -->
        <div class="card horizontal">
            <div class="card-image">
                <!-- Se muestra una imagen por defecto mientras se carga la imagen del producto -->
                <img id="imagen" src="../../resources/img/unknown.png">
            </div>
            <div class="card-stacked">
                <div class="card-content">
                    <h4 id="nombre" class="header"></h4>
                    <p id="descripcion"></p>
                    <p>Precio (US$) <b id="precio"></b></p>
                    <p>Disponible: <b id="cantidad"></b></p>
                </div>
    
                <div class="card-action">
                    <!-- Formulario para agregar el producto al carrito de compras -->
                    <form method="post" id="shopping-form">
                        <!-- Campos ocultos para asignar los datos necesarios del producto -->
                        <input type="number" id="id_producto" name="id_producto" class="hide"/>
                        <input type="text" id="precio_producto" name="precio_producto" class="hide"/>
                        <input type="number" id="nuevo_stock" name="nuevo_stock" class="hide"/>
                        <div class="row center">
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">list</i>
                                <input type="number" id="cantidad_producto" name="cantidad_producto" min="1" class="validate" required/>
                                <label for="cantidad_producto">Cantidad</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <button type="submit" class="btn waves-effect waves-light blue tooltipped" data-tooltip="Agregar al carrito"><i class="material-icons">add_shopping_cart</i></button>
                            </div> 
                        </div>
                        
                    </form>
                    <h1 id="disponiblelbl" class="hide">No disponible</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Contenedor de las valoraciones-->
<div class="container">
    <h3 class="center indigo-text">Deja tu valoración</h3>
    <div class="row">
        <form method="post" id="valoraciones-form">
            <input type="text" class="hide" id="id_producto2" name="id_producto2">
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">star</i>
                <select id="cb_puntuacion" name="cb_puntuacion">
                </select>
                <label>Puntuación</label>
            </div>
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">edit</i>
                <input id="valoracion_producto" type="text" name="valoracion_producto" class="validate" required/>
                <label for="valoracion_producto">Comentario</label>
            </div>
            <div class="row center-align">
                <div class="col s12">
                    <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Enviar valoración"><i class="material-icons">send</i></button>
                </div>
            </div>
        </form>
    </div>
</div>

<!--Contenedor de comentarios -->
<div class="container">
    <h3 class="center indigo-text" id="title2">Valoraciones hechas por los clientes</h3>
    <div class="row" id="row-body">
        
    </div>
</div>

<?php
// Se imprime la plantilla del pie enviando el nombre del controlador para la página web.
Public_Page::footerTemplate('detalle.js');
?>