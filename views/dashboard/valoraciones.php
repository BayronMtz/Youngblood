<?php
// Se incluye la clase con las plantillas del documento.
require_once('../../app/helpers/dashboard_page.php');
// Se imprime la plantilla del encabezado enviando el título de la página web.
Dashboard_Page::headerTemplate('Administrar valoraciones');
?>

<div class="row">
    <!-- Formulario de búsqueda -->
    <form method="post" id="search-form">
        <div class="input-field col s6 m4">
            <i class="material-icons prefix">search</i>
            <input id="search" type="text" name="search" required/>
            <label for="search">Buscador</label>
        </div>
        <div class="input-field col s6 m4">
            <button type="submit" class="btn waves-effect green tooltipped" data-tooltip="Buscar"><i class="material-icons">check_circle</i></button>
        </div>
    </form>
    <!--div class="input-field center-align col s12 m4">
        < Enlace para abrir la caja de dialogo (modal) al momento de crear un nuevo registro>
        <a href="#" onclick="openCreateDialog()" class="btn waves-effect indigo tooltipped" data-tooltip="Crear"><i class="material-icons">add_circle</i></a>
    </div-->
</div>

<table class="highlight">
    <!-- Cabeza de la tabla para mostrar los títulos de las columnas -->
    <thead>
        <tr>
            <th>PRODUCTO</th>
            <th>COMENTARIOS</th>
            <th class="actions-column">ACCIONES</th>
        </tr>
    </thead>
    <!-- Cuerpo de la tabla para mostrar un registro por fila -->
    <tbody id="tbody-rows">
    </tbody>
</table>

<div id="comments-modal" class="modal">
    <div class="modal-content">
        <!-- Título para la caja de dialogo -->
        <h4 id="modal-title" class="center-align">Comentarios de <span id="lblProducto"></span></h4>
        <input type="text" id="id_producto2" class="hide">
        <!-- Tabla para mostrar los registros existentes -->
        <table class="highlight" id="data-table">
            <!-- Cabeza de la tabla para mostrar los títulos de las columnas -->
            <thead>
                <tr>
                    <th>CLIENTE</th>
                    <th>PUNTUACION</th>
                    <th>FECHA</th>
                    <th>Estado</th>
                    <th class="actions-column">ACCIONES</th>
                </tr>
            </thead>
            <!-- Cuerpo de la tabla para mostrar un registro por fila -->
            <tbody id="tbody-rows2">
            </tbody>
        </table>
        <div class="row center-align" style="margin-top: 25px;">
            <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i class="material-icons">cancel</i></a>
        </div>
    </div>
</div>

<div id="administer-modal" class="modal">
    <div class="modal-content">
        <!-- Título para la caja de dialogo -->
        <form method="post" id="administer-form">
            <input type="text" id="idproducto" class="hide">
            <input type="text" id="nombreproducto" class="hide">
            <input type="text" id="idvaloracion" class="hide">
        </form>

        <h4 id="modal-title" class="center-align">Comentario de <span id="lblCliente"></span></h4>
        <!-- Tabla para mostrar los registros existentes -->
        <p style="text-align: center;">Fecha: <b id="lblFecha">12</b></p>
        <p style="text-align: center;">Producto: <b id="lblProducto2"></b></p>
        <p style="text-align: center;">Puntuación: <b id="lblPuntuacion">12</b></p>
        <p style="text-align: center;">Estado: <b id="lblEstado">12</b></p>
        <div class="input-field col s12 m6">
            <i class="material-icons prefix">edit</i>
            <input id="valoracion_producto" type="text" name="valoracion_producto" readonly/>
            <label for="valoracion_producto">Comentario</label>
        </div>
        <div class="row center-align" style="margin-top: 25px;">
            <a id="btnOcultar" href="#" class="btn waves-effect purple darken-4 tooltipped" data-tooltip="Ocultar Comentario"><i class="material-icons">visibility_off</i></a>
            <a id="btnMostrar" href="#" class="btn waves-effect blue lighten-1 tooltipped" data-tooltip="Mostrar Comentario"><i class="material-icons">visibility</i></a>

        </div>
        <div class="row center-align" style="margin-top: 25px;">
            <a id="btnRegresar" href="#" class="btn waves-effect green tooltipped modal-close" data-tooltip="Regresar"><i class="material-icons">arrow_back</i></a>
            <a id="btnEliminar" href="#" class="btn waves-effect red tooltipped" data-tooltip="Eliminar"><i class="material-icons">delete</i></a>
        </div>
    </div>
</div>

<?php
// Se imprime la plantilla del pie enviando el nombre del controlador para la página web.
Dashboard_Page::footerTemplate('valoraciones.js');
?>
