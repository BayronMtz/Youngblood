<?php
// Se incluye la clase con las plantillas del documento.
require_once('../../app/helpers/public_page.php');
// Se imprime la plantilla del encabezado enviando el título de la página web.
Public_Page::headerTemplate('Carrito de compras');
?>

<!-- Contenedor para mostrar el detalle del carrito de compras -->
<div class="container">
    <!-- Título del contenido principal -->
    <h4 class="center-align indigo-text">Carrito de compras</h4>
    <!-- Tabla para mostrar el detalle de los productos agregados al carrito de compras -->
    <table class="striped">
        <!-- Cabeza de la tabla para mostrar los títulos de las columnas -->
        <thead>
            <tr>
                <th>PRODUCTO</th>
                <th>PRECIO (US$)</th>
                <th>CANTIDAD</th>
                <th>SUBTOTAL (US$)</th>
                <th class="actions-column">ACCIONES</th>
            </tr>
        </thead>
        <!-- Cuerpo de la tabla para mostrar un registro por fila -->
        <tbody id="tbody-rows">
        </tbody>
    </table>
    <!-- Fila para mostrar el monto total a pagar -->
    <div class="row right-align">
        <p>TOTAL A PAGAR: <span class="blue-text" id="lblTotal">$0.00</span></p>
        
    </div>
    <!-- Fila para mostrar un botón que finaliza el pedido -->
    <div class="row right-align">
        <button type="button" onclick="finishOrder()" class="btn waves-effect blue tooltipped" data-tooltip="Finalizar pedido"><i class="material-icons">payment</i></button>
    </div>
    <!-- Fila para mostrar un enlace con la dirección de la página web principal para seguir comprando -->
    <div class="row right-align">
        <a href="index.php" class="btn waves-effect indigo tooltipped" data-tooltip="Seguir comprando"><i class="material-icons">store</i></a>
    </div>
</div>

<!-- Componente Modal para mostrar una caja de dialogo -->
<div id="item-modal" class="modal">
    <div class="modal-content">
        <!-- Título para la caja de dialogo -->
        <h4 class="center-align">Cambiar cantidad</h4>
        <!-- Formulario para cambiar la cantidad de producto -->
        <form method="post" id="item-form">
            <!-- Campo oculto para asignar el id del registro al momento de modificar -->
            <input type="number" id="id_detalle" name="id_detalle" class="hide"/>
            <input type="number" id="id_producto" name="id_producto" class="hide"/>
            <div class="row">
                <h5 class="center">Disponible: <span id="contadorStock"></span></h1>
                <div class="input-field col s12 m4 offset-m4">
                    <i class="material-icons prefix">list</i>
                    <input type="number" id="cantidad_producto" name="cantidad_producto" min="1" class="validate" required/>
                    <label for="cantidad_producto">Cantidad</label>
                </div>

                <div class="input-field hide col s12 m4 offset-m4">
                    <i class="material-icons prefix">list</i>
                    <input type="text" id="cantidad_bodega" name="cantidad_bodega" min="1" class="validate"/>
                    <label for="cantidad_bodega">Stock bodega:</label>
                </div>
            </div>
            <div class="row center-align">
                <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i class="material-icons">cancel</i></a>
                <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Guardar"><i class="material-icons">save</i></button>
            </div>
        </form>
    </div>
</div>

<?php
// Se imprime la plantilla del pie enviando el nombre del controlador para la página web.
Public_Page::footerTemplate('cart.js');
?>