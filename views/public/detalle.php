<?php
// Se incluye la clase con las plantillas del documento.
require_once('../../app/helpers/public_page.php');
// Se imprime la plantilla del encabezado enviando el título de la página web.
Public_Page::headerTemplate('Detalles del producto');
?>

<!-- Contenedor para mostrar el detalle del producto seleccionado previamente -->
<div class="container">
    <!-- Título del contenido principal -->
    <h4 class="center indigo-text" id="title">Detalles del producto</h4>
    <div class="row" id="detalle">
        <!-- Componente Horizontal Card para mostrar el detalle de un producto -->
        <div class="card horizontal">
            <div class="card-image">
                <!-- Se muestra una imagen por defecto mientras se carga la imagen del producto -->
                <img id="imagen" src="../../resources/img/unknown.png">
            </div>
            <div class="card-stacked">
                <div class="card-content">
                    <h3 id="nombre" class="header"></h3>
                    <p id="descripcion"></p>
                    <p>Precio (US$) <b id="precio"></b></p>
                </div>
                <div class="card-action">
                    <!-- Formulario para agregar el producto al carrito de compras -->
                    <form method="post" id="shopping-form">
                        <!-- Campos ocultos para asignar los datos necesarios del producto -->
                        <input type="number" id="id_producto" name="id_producto" class="hide"/>
                        <input type="number" id="precio_producto" name="precio_producto" class="hide"/>
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
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Se imprime la plantilla del pie enviando el nombre del controlador para la página web.
Public_Page::footerTemplate('detalle.js');
?>