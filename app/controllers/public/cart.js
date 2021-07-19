const API_PEDIDOS = '../../app/api/public/pedidos.php?action=';

document.addEventListener('DOMContentLoaded',function(){
    readOrderInCart();
});

function readOrderInCart(){
    fetch(API_PEDIDOS + 'readOrderInCart', {
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
        content += `
            <tr>
                <td>${row.nombre_producto}</td>
                <td>${row.precio}</td>
                <td>${row.cantidad_producto}</td>
                <td>${row.subtotal}</td>
                <td>
                    <a href="#" onclick="updateOrderStock(${row.id_detalle}, ${row.id_producto}, ${row.cantidad_producto})" class="btn waves-effect green tooltipped" data-tooltip="Editar cantidad"><i class="material-icons">mode_edit</i></a>
                    <a href="#" onclick="openDeleteDialog(${row.id_detalle}, ${row.cantidad_producto}, ${row.id_producto})"class="btn waves-effect red tooltipped" data-tooltip="Eliminar"><i class="material-icons">delete</i></a>
                </td>
            </tr>
        `;
    });
    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
    document.getElementById('tbody-rows').innerHTML = content;
   
    // Se inicializa el componente Tooltip asignado a los enlaces para que funcionen las sugerencias textuales.
    M.Tooltip.init(document.querySelectorAll('.tooltipped'));
}

//Funcion que se ejecuta al momento de agregar 
function updateOrderStock(detalle, producto, cantidad_pedido){
    // Se restauran los elementos del formulario.
    document.getElementById('item-form').reset();
    // Se abre la caja de dialogo (modal) que contiene el formulario.
    let instance = M.Modal.getInstance(document.getElementById('item-modal'));
    instance.open();

    //Se asignan los ids a campos invisibles.
    document.getElementById('id_producto').value = producto;
    document.getElementById('id_detalle').value = detalle;
    //Se agrega el id al form
    const data = new FormData();
    data.append('id_producto', producto);

    fetch(API_PEDIDOS + 'productInfo', {
        method: 'post',
        body: data
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    document.getElementById('contadorStock').textContent = parseInt(response.dataset.cantidad) + parseInt(cantidad_pedido);
                    document.getElementById('cantidad_producto').value = cantidad_pedido;
                    document.getElementById('cantidad_bodega').value = parseInt(response.dataset.cantidad) + parseInt(cantidad_pedido);
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

//Funcion que se ejecuta en el evento submit del form
document.getElementById('item-form').addEventListener('submit',function(event){
    event.preventDefault();

    if (parseInt(document.getElementById('cantidad_producto').value) > parseInt(document.getElementById('contadorStock').textContent)) {
        sweetAlert(2, 'No hay unidades en existencias, lo maximo permitido es: '+document.getElementById('contadorStock').textContent, null)
    } else {
        var stock_nuevo = parseInt(document.getElementById('contadorStock').textContent) - parseInt(document.getElementById('cantidad_producto').value);
        document.getElementById('cantidad_bodega').value = stock_nuevo;

        fetch(API_PEDIDOS + 'updateOnCart', {
            method: 'post',
            body: new FormData(document.getElementById('item-form'))
        }).then(function (request) {
            // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
            if (request.ok) {
                request.json().then(function (response) {
                    // Se comprueba si la respuesta es satisfactoria, de lo contrario se constata si el cliente ha iniciado sesión.
                    if (response.status) {
                        readOrderInCart();
                        let instance = M.Modal.getInstance(document.getElementById('item-modal'));
                        instance.close();
                        sweetAlert(1, response.message, null);
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
})

// Función para establecer el registro a eliminar y abrir una caja de dialogo de confirmación.
function openDeleteDialog(id, cantidad_carrito, producto) {
    // Se define un objeto con los datos del registro seleccionado.
    console.log(cantidad_carrito);
    const data = new FormData();
    data.append('id_detalle', id);
    data.append('id_producto', producto);
    data.append('cantidad_eliminada', cantidad_carrito);
    // Se llama a la función que elimina un registro. Se encuentra en el archivo components.js
    confirmDelete2('deleteFromCart',API_PEDIDOS, data);
}

//Funcion para eliminar registros del carrito.
function confirmDelete2(action, api, data) {
    swal({
        title: 'Advertencia',
        text: '¿Desea eliminar el registro?',
        icon: 'warning',
        buttons: ['No', 'Sí'],
        closeOnClickOutside: false,
        closeOnEsc: false
    }).then(function (value) {
        // Se verifica si fue cliqueado el botón Sí para hacer la petición de borrado, de lo contrario no se hace nada.
        if (value) {
            fetch(api + action, {
                method: 'post',
                body: data
            }).then(function (request) {
                // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
                if (request.ok) {
                    request.json().then(function (response) {
                        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                        if (response.status) {
                            // Se cargan nuevamente las filas en la tabla de la vista después de borrar un registro.
                            readOrderInCart();
                            sweetAlert(1, response.message, null);
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
}

function finishOrder(){
    swal({
        title: 'Advertencia',
        text: '¿Desea finalizar su orden?',
        icon: 'warning',
        buttons: ['No', 'Sí'],
        closeOnClickOutside: false,
        closeOnEsc: false
    }).then(function (value) {
        // Se verifica si fue cliqueado el botón Sí para hacer la petición de borrado, de lo contrario no se hace nada.
        if (value) {
            fetch(API_PEDIDOS + 'finishOrder', {
                method: 'get'
            }).then(function (request) {
                // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
                if (request.ok) {
                    request.json().then(function (response) {
                        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                        if (response.status) {
                            sweetAlert(1, response.message, 'index.php');
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
}