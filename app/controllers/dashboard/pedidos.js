// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_PEDIDOS = '../../app/api/dashboard/pedidos.php?action=';

// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Se llama a la función que obtiene los registros para llenar la tabla. Se encuentra en el archivo components.js
    readRows(API_PEDIDOS);
});

// Función para llenar la tabla con los datos de los registros. Se manda a llamar en la función readRows().
function fillTable(dataset) {
    let content = '';
    // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
    dataset.map(function (row) {
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        let estado = '';
        if (row.estado_pedido == 0) {
            estado = 'En proceso.';
        } else if (row.estado_pedido == 1) {
            estado = 'Finalizado.';
        } else if (row.estado_pedido == 2) {
            estado = 'Entregado.';
        } else if (row.estado_pedido == 3) {
            estado = 'Anulado.';
        }
        content += `
            <tr>
                <td>${row.cliente}</td>
                <td>${estado}</td>
                <td>${row.fecha_pedido}</td>
                <td>
                    <a href="#" onclick="openUpdateDialog(${row.id_cliente})" class="btn waves-effect indigo tooltipped" data-tooltip="Ver pedido"><i class="material-icons">info</i></a>
                    <a href="#" onclick="openDeleteDialog(${row.id_cliente})" class="btn waves-effect red tooltipped" data-tooltip="Eliminar"><i class="material-icons">delete</i></a>
                </td>
            </tr>
        `;
    });
    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
    document.getElementById('tbody-rows').innerHTML = content;
   
    // Se inicializa el componente Tooltip asignado a los enlaces para que funcionen las sugerencias textuales.
    M.Tooltip.init(document.querySelectorAll('.tooltipped'));
}