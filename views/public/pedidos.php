<?php
// Se incluye la clase con las plantillas del documento.
require_once('../../app/helpers/public_page.php');
// Se imprime la plantilla del encabezado enviando el título de la página web.
Public_Page::headerTemplate('Mis Pedidos');
?>

<!-- Contenedor para mostrar los pedidos del cliente -->
<div class="container">
    <!-- Título del contenido principal -->
    <h4 class="center-align indigo-text">Mis Pedidos</h4>
    <!-- Tabla para mostrar el detalle de los productos agregados al carrito de compras -->
    <table class="striped">
        <!-- Cabeza de la tabla para mostrar los títulos de las columnas -->
        <thead>
            <tr>
                <th>ESTADO</th>
                <th>FECHA</th>
                <th class="actions-column">ACCIONES</th>
            </tr>
        </thead>
        <!-- Cuerpo de la tabla para mostrar un registro por fila -->
        <tbody id="tbody-rows">
        </tbody>
    </table>
</div>

<!-- Componente Modal para mostrar una caja de dialogo -->
<div id="order-modal" class="modal">
    <div class="modal-content">
        <!-- Título para la caja de dialogo -->
        <h4 class="center-align">Información del Pedido</h4>
        <!-- Formulario para cambiar la cantidad de producto -->
        <form method="post" id="order-form">
            <!-- Campo oculto para asignar el id del registro al momento de modificar -->
            <input type="number" id="id_pedido" name="id_pedido" class="hide"/>
            <table class="striped">
                <!-- Cabeza de la tabla para mostrar los títulos de las columnas -->
                <thead>
                    <tr>
                        <th>PRODUCTO</th>
                        <th>PRECIO (US$)</th>
                        <th>CANTIDAD</th>
                        <th>SUBTOTAL (US$)</th>
                    </tr>
                </thead>
                <!-- Cuerpo de la tabla para mostrar un registro por fila -->
                <tbody id="tbody-rows2">
                </tbody>
            </table>
            <div class="row center-align" style="margin-top: 30px;">
                <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i class="material-icons">cancel</i></a>
                <button type="submit" id="btnCancelar" class="btn waves-effect red tooltipped" data-tooltip="Cancelar Pedido"><i class="material-icons">delete_forever</i></button>
                <a href="#" id="btnReporte" onclick="openCreateDialog()" class="btn waves-effect amber tooltipped" data-tooltip="Reporte de pedidos"><i class="material-icons">assignment</i></a>
            </div>
        </form>
    </div>
</div>

<?php
// Se imprime la plantilla del pie enviando el nombre del controlador para la página web.
Public_Page::footerTemplate('pedidos.js');
?>