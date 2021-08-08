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
            estado = 'En proceso';
        } else if (row.estado_pedido == 1) {
            estado = 'Finalizado';
        } else if (row.estado_pedido == 2) {
            estado = 'Entregado';
        } else if (row.estado_pedido == 3) {
            estado = 'Anulado';
        }
        content += `
            <tr>
                <td>${row.cliente}</td>
                <td>${estado}</td>
                <td>${row.fecha_pedido}</td>
                <td>
                    <a href="#" onclick="showInfo(${row.id_pedido}, '${estado}', '${row.cliente}', '${row.fecha_pedido}')" class="btn waves-effect indigo tooltipped" data-tooltip="Ver pedido"><i class="material-icons">info</i></a>
                </td>
            </tr>
        `;
    });
    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
    document.getElementById('tbody-rows').innerHTML = content;
   
    // Se inicializa el componente Tooltip asignado a los enlaces para que funcionen las sugerencias textuales.
    M.Tooltip.init(document.querySelectorAll('.tooltipped'));
}

//Funcion que se ejecuta al abrir el modal para ver los productos de un pedido
function showInfo(id, estado, cliente, fecha){
    // Se restauran los elementos del formulario.
    document.getElementById('order-form').reset();
    // Se abre la caja de dialogo (modal) que contiene el formulario.
    let instance = M.Modal.getInstance(document.getElementById('order-modal'));
    instance.open();
    //Se asigna informacion importante acerca del pedido al modal
    document.getElementById('lblCliente').textContent = cliente;
    document.getElementById('lblEstado').textContent = estado;
    document.getElementById('lblFecha').textContent = fecha;

    //Se ocultan botones en base al estado del pedido
    if (estado == 'Anulado') {
        document.getElementById('btnEntregar').className = 'hide';
    } else if (estado == 'Finalizado') {
        document.getElementById('btnEntregar').className = 'btn waves-effect green tooltipped';
    } else if (estado == 'Entregado') {
        document.getElementById('btnEntregar').className = 'hide';
    }

    //Se asignan los ids a campos invisibles.
    document.getElementById('id_pedido').value = id;
    //Se agrega el id al form
    const data = new FormData();
    data.append('id_pedido', id);

    fetch(API_PEDIDOS + 'readProductsOfOrder', {
        method: 'post',
        body: data
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    fillProducts(response.dataset);         
                } else {
                    sweetAlert(2, response.exception, null);
                }

                // Se actualizan los campos para que las etiquetas (labels) no queden sobre los datos.
                M.updateTextFields();
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
}

// Función para llenar la tabla con los datos de los registros. Se manda a llamar en la función readRows().
function fillProducts(dataset) {
    let content = '';
    // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
    dataset.map(function (row) {
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        content += `
            <tr>
                <td>${row.nombre_producto}</td>
                <td>${row.precio}</td>
                <td>${row.cantidad_producto}</td>
                <td>${row.subtotal}</td>
            </tr>
        `;
    });

    let total = 0;
    // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
    dataset.map(function (row) {
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        total += parseFloat(row.precio) * parseFloat(row.cantidad_producto);
    });

    document.getElementById('lblTotal').textContent = '$'+total.toFixed(2);

    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
    document.getElementById('tbody-rows2').innerHTML = content;
   
    // Se inicializa el componente Tooltip asignado a los enlaces para que funcionen las sugerencias textuales.
}

// Método manejador de eventos que se ejecuta cuando se envía el formulario de buscar.
document.getElementById('search-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se llama a la función que realiza la búsqueda. Se encuentra en el archivo components.js
    searchRows(API_PEDIDOS, 'search-form');
});

//Se ejecuta al hacer clic para poder reportar una orden como entregada
document.getElementById('btnEntregar').addEventListener('click',function(event){
    //Evitamos recargar la pagina
    event.preventDefault();

    console.log('a');
    swal({
        title: 'Advertencia',
        text: '¿Desea reportar como entregado el pedido?',
        icon: 'warning',
        buttons: ['No', 'Sí'],
        closeOnClickOutside: false,
        closeOnEsc: false
    }).then(function (value) {
        // Se verifica si fue cliqueado el botón Sí para hacer la petición de borrado, de lo contrario no se hace nada.
        if (value) {
            fetch(API_PEDIDOS + 'giveOrder', {
                method: 'post',
                body: new FormData(document.getElementById('order-form'))
            }).then(function (request) {
                // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
                if (request.ok) {
                    request.json().then(function (response) {
                        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                        if (response.status) {
                            // Se cargan nuevamente las filas en la tabla de la vista después de borrar un registro.
                            readRows(API_PEDIDOS);
                            sweetAlert(1, response.message, null);

                            // Se abre la caja de dialogo (modal) que contiene el formulario.
                            let instance = M.Modal.getInstance(document.getElementById('order-modal'));
                            instance.close();
                        } else {
                            sweetAlert(2, response.exception, null);
                        }
                    });
                } else {
                    console.log(request.status + ' ' + request.statusText);
                }
            }).catch(function (error) {
                console.log(error);
            });
        }
    });
})

//Para reiniciar la busqueda
document.getElementById('btnReiniciar').addEventListener('click',function(event){
    //Evitamos recargar la pagina
    event.preventDefault();
    //Ejecutamos el evento para cargar las filas por default
    readRows(API_PEDIDOS);
})