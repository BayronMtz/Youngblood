//Constante para la api
const API_PEDIDOS = '../../app/api/public/pedidos.php?action=';

//se ejecuta al cargar la pagina
document.addEventListener('DOMContentLoaded',function(){
    checkOrders();
});

//Funcion para cargar las funciones del cliente
function checkOrders(){
    fetch(API_PEDIDOS + 'checkOrders', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    // Se colocan los datos en la tarjeta de acuerdo al producto seleccionado previamente.
                    fillTable(response.dataset);
                } else {
                    // No se muestra nada
                    let content = '';
                    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
                    document.getElementById('tbody-rows').innerHTML = content;
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
}

// Función para llenar la tabla con los datos de los registros. Se manda a llamar en la función readRows().
function fillTable(dataset) {
    let content = '';
    // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
    dataset.map(function (row) {
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        let estadopedido = '';
        if (row.estado_pedido == 1) {
            estadopedido = 'Finalizado';
        } else if(row.estado_pedido == 2){
            estadopedido = 'Entregado';
        } else if(row.estado_pedido == 3){
            estadopedido = 'Anulado';
        }
        content += `
            <tr>
                <td>${estadopedido}</td>
                <td>${row.fecha_pedido}</td>
                <td>
                    <a href="#" onclick="showInfo(${row.id_pedido}, ${row.estado_pedido})" class="btn waves-effect blue tooltipped" data-tooltip="Editar cantidad"><i class="material-icons">info</i></a>
                </td>
            </tr>
        `;
    });
    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
    document.getElementById('tbody-rows').innerHTML = content;
   
    // Se inicializa el componente Tooltip asignado a los enlaces para que funcionen las sugerencias textuales.
}

//Funcion para mostrar información de un pedido
function showInfo(id, estado){
    //Se muestran o se ocultan botones en base al estado
    if (estado == 1) {
        document.getElementById('btnCancelar').className = 'btn waves-effect red tooltipped';
        document.getElementById('btnReporte').className = 'hide';
    } else if (estado == 2) {
        document.getElementById('btnCancelar').className = 'hide';
        document.getElementById('btnReporte').className = 'btn waves-effect amber tooltipped';
    } else if (estado == 3) {
        document.getElementById('btnCancelar').className = 'hide';
        document.getElementById('btnReporte').className = 'hide';
    }
    // Se restauran los elementos del formulario.
    document.getElementById('order-form').reset();
    // Se abre la caja de dialogo (modal) que contiene el formulario.
    let instance = M.Modal.getInstance(document.getElementById('order-modal'));
    instance.open();

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

    document.getElementById('lblTotal').textContent = '$'+total;

    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
    document.getElementById('tbody-rows2').innerHTML = content;
   
    // Se inicializa el componente Tooltip asignado a los enlaces para que funcionen las sugerencias textuales.
}

//Funcion que se ejecuta para anular un pedido
document.getElementById('btnCancelar').addEventListener('click',function(event){
    //Se evita recargar la pagina
    event.preventDefault();

    swal({
        title: 'Advertencia',
        text: '¿Desea anular el pedido?',
        icon: 'warning',
        buttons: ['No', 'Sí'],
        closeOnClickOutside: false,
        closeOnEsc: false
    }).then(function (value) {
        // Se verifica si fue cliqueado el botón Sí para hacer la petición de borrado, de lo contrario no se hace nada.
        if (value) {
            fetch(API_PEDIDOS + 'cancelOrder', {
                method: 'post',
                body: new FormData(document.getElementById('order-form'))
            }).then(function (request) {
                // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
                if (request.ok) {
                    request.json().then(function (response) {
                        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                        if (response.status) {
                            // Se cargan nuevamente las filas en la tabla de la vista después de borrar un registro.
                            checkOrders();
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