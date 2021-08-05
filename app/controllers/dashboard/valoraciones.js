// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_VALORACIONES = '../../app/api/dashboard/valoraciones.php?action=';

// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Se llama a la función que obtiene los registros para llenar la tabla. Se encuentra en el archivo components.js
    readRows(API_VALORACIONES);
});

// Función para llenar la tabla con los datos de los registros. Se manda a llamar en la función readRows().
function fillTable(dataset) {
    let content = '';
    // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
    dataset.map(function (row) {
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        content += `
            <tr>
                <td>${row.nombre_producto}</td>
                <td>${row.cantidadvaloraciones}</td>
                <td>
                    <a href="#" onclick="openCommentsDialog(${row.id_producto}, '${row.nombre_producto}')" class="btn waves-effect blue tooltipped" data-tooltip="Comentarios"><i class="material-icons">info</i></a>
                </td>
            </tr>
        `;
    });
    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
    document.getElementById('tbody-rows').innerHTML = content;
    // Se inicializa el componente Tooltip asignado a los enlaces para que funcionen las sugerencias textuales.
    M.Tooltip.init(document.querySelectorAll('.tooltipped'));
}

//Se ejecuta para ver los comentarios hechos a un producto.
function openCommentsDialog(id, nombre){
    // Se abre la caja de dialogo (modal) que contiene el formulario.
    let instance = M.Modal.getInstance(document.getElementById('comments-modal'));
    instance.open();

    //Se asignan los parametros a controles de la pagina
    document.getElementById('lblProducto').textContent = nombre;
    document.getElementById('id_producto2').value = id;

    //Se hace una peticion para obtener los commentarios
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('id_producto', id);

    fetch(API_VALORACIONES + 'readCommentsOfProduct', {
        method: 'post',
        body: data
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                let data = [];
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    data = response.dataset;
                } else {
                    sweetAlert(4, response.exception, null);
                }
                // Se envían los datos a la función del controlador para que llene la tabla en la vista.
                fillComments(data);
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
}

// Función para llenar la tabla con los datos de los registros. Se manda a llamar en la función readRows().
function fillComments(dataset) {
    let content = '';
    //Capturamos el nombre del producto
    let nombreproducto = document.getElementById('lblProducto').textContent;
    // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
    dataset.map(function (row) {
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.

        let estado = '';
        if (row.visibilidad == 0) {lblProducto
            estado = 'Oculto';
        } else if (row.visibilidad == 1) {
            estado = 'Visible';
        }
        content += `
            <tr>
                <td>${row.cliente}</td>
                <td style="color: #e8d905;">${row.puntuacion}</td>
                <td>${row.fecha}</td>
                <td>${estado}</td>
                <td>
                    <a href="#" onclick="openAdminDialog(${row.id_valoracion}, ${row.id_producto}, '${nombreproducto}', '${row.cliente}')" class="btn waves-effect blue tooltipped modal-close" data-tooltip="Actualizar"><i class="material-icons">mode_edit</i></a>
                </td>
            </tr>
        `;
    });
    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
    document.getElementById('tbody-rows2').innerHTML = content;
    // Se inicializa el componente Material Box asignado a las imagenes para que funcione el efecto Lightbox.
    M.Materialbox.init(document.querySelectorAll('.materialboxed'));
    // Se inicializa el componente Tooltip asignado a los enlaces para que funcionen las sugerencias textuales.
    M.Tooltip.init(document.querySelectorAll('.tooltipped'));
}

//Abre el modal para administrar un comentario
function openAdminDialog(idvaloracion, idproducto, nombreproducto, cliente){
    // Se abre la caja de dialogo (modal) que contiene el formulario.
    let instance = M.Modal.getInstance(document.getElementById('administer-modal'));
    instance.open();
    //Se asignan valores a algunos inputs
    document.getElementById('idproducto').value = idproducto;
    document.getElementById('nombreproducto').value = nombreproducto;
    document.getElementById('lblCliente').textContent = cliente;
    document.getElementById('idvaloracion').value = idvaloracion;

    //Se hace una peticion para obtener los commentarios
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('id_valoracion', idvaloracion);

    fetch(API_VALORACIONES + 'getReview', {
        method: 'post',
        body: data
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                let data = [];
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    //Variable que contiene el estado visible de una valoracion
                    let estado = '';
                    //Verificamos el estado de la valoracion para asignar un texto predeterminado
                    if (response.dataset.visibilidad == 0) {
                        estado = 'Oculto';
                        document.getElementById('btnOcultar').className = 'hide';
                        document.getElementById('btnMostrar').className = 'btn waves-effect blue lighten-1 tooltipped';

                    } else if (response.dataset.visibilidad == 1) {
                        estado = 'Visible';
                        document.getElementById('btnOcultar').className = 'btn waves-effect purple darken-4 tooltipped';
                        document.getElementById('btnMostrar').className = 'hide';
                    }
                    //Se asignan los valores a los labels
                    document.getElementById('lblFecha').textContent = response.dataset.fecha;
                    document.getElementById('lblProducto2').textContent = response.dataset.nombre_producto;
                    document.getElementById('lblPuntuacion').textContent = response.dataset.puntuacion;
                    document.getElementById('lblEstado').textContent = estado;
                    document.getElementById('valoracion_producto').value = response.dataset.valoracion;
                    // Se actualizan los campos para que las etiquetas (labels) no queden sobre los datos.
                    M.updateTextFields();

                } else {
                    sweetAlert(4, response.exception, null);
                }
                // Se envían los datos a la función del controlador para que llene la tabla en la vista.
                fillComments(data);
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
}

//Se ejecuta para poder regresar al modal anterior
document.getElementById('btnRegresar').addEventListener('click',function(event){
    //Evitamos recargar la pagina
    event.preventDefault();
    //Ejecutamos el metodo que abre el otro modal
    openCommentsDialog(document.getElementById('idproducto').value, document.getElementById('nombreproducto').value);

});

//Para realizar busquedas
document.getElementById('search-form').addEventListener('submit',function(event){
    //Evitamos recargar la pagina
    event.preventDefault();
    //Busqueda
    searchRows(API_VALORACIONES, 'search-form');
});

//Se ejecuta para poder ocultar un comentario
document.getElementById('btnOcultar').addEventListener('click',function(event){
    //Se evita que se recargue la pagina
    event.preventDefault();
    let idvaloracion = document.getElementById('idvaloracion').value;
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('idvaloracion', idvaloracion);
    //SweetAlert
    swal({
        title: 'Advertencia',
        text: '¿Desea ocultar el comentario?',
        icon: 'warning',
        buttons: ['No', 'Sí'],
        closeOnClickOutside: false,
        closeOnEsc: false
    }).then(function (value) {
        // Se verifica si fue cliqueado el botón Sí para hacer la petición de borrado, de lo contrario no se hace nada.
        if (value) {
            //Se hace una peticion para ocultar un comentario
            fetch(API_VALORACIONES + 'hideReview', {
                method: 'post',
                body: data
            }).then(function (request) {
                // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
                if (request.ok) {
                    request.json().then(function (response) {
                        let data = [];
                        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                        if (response.status) {
                            // Se cierra la caja de dialogo (modal) que contiene el formulario.
                            let instance = M.Modal.getInstance(document.getElementById('administer-modal'));
                            instance.close();
                            //Mensaje
                            sweetAlert(1, response.message, null);
                        } else {
                            sweetAlert(4, response.exception, null);
                        }
                        // Se envían los datos a la función del controlador para que llene la tabla en la vista.
                        fillComments(data);
                    });
                } else {
                    console.log(request.status + ' ' + request.statusText);
                }
            }).catch(function (error) {
                console.log(error);
            });
        }
    }); 
});

//Se ejecuta para poder mostrar un comentario
document.getElementById('btnMostrar').addEventListener('click',function(event){
    //Se evita que se recargue la pagina
    event.preventDefault();
    let idvaloracion = document.getElementById('idvaloracion').value;
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('idvaloracion', idvaloracion);
    //SweetAlert
    swal({
        title: 'Advertencia',
        text: '¿Desea mostrar el comentario?',
        icon: 'warning',
        buttons: ['No', 'Sí'],
        closeOnClickOutside: false,
        closeOnEsc: false
    }).then(function (value) {
        // Se verifica si fue cliqueado el botón Sí para hacer la petición de borrado, de lo contrario no se hace nada.
        if (value) {
            //Se hace una peticion para ocultar un comentario
            fetch(API_VALORACIONES + 'showReview', {
                method: 'post',
                body: data
            }).then(function (request) {
                // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
                if (request.ok) {
                    request.json().then(function (response) {
                        let data = [];
                        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                        if (response.status) {
                            // Se cierra la caja de dialogo (modal) que contiene el formulario.
                            let instance = M.Modal.getInstance(document.getElementById('administer-modal'));
                            instance.close();
                            //Mensaje
                            sweetAlert(1, response.message, null);
                        } else {
                            sweetAlert(4, response.exception, null);
                        }
                        // Se envían los datos a la función del controlador para que llene la tabla en la vista.
                        fillComments(data);
                    });
                } else {
                    console.log(request.status + ' ' + request.statusText);
                }
            }).catch(function (error) {
                console.log(error);
            });
        }
    }); 
});

//Se ejecuta para eliminar
document.getElementById('btnEliminar').addEventListener('click',function(event){
    //evitar que se recargue la pagina
    event.preventDefault();
    let idvaloracion = document.getElementById('idvaloracion').value;
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('idvaloracion', idvaloracion);
    //SweetAlert
    swal({
        title: 'Advertencia',
        text: '¿Desea eliminar el comentario?',
        icon: 'warning',
        buttons: ['No', 'Sí'],
        closeOnClickOutside: false,
        closeOnEsc: false
    }).then(function (value) {
        // Se verifica si fue cliqueado el botón Sí para hacer la petición de borrado, de lo contrario no se hace nada.
        if (value) {
            //Se hace una peticion para ocultar un comentario
            fetch(API_VALORACIONES + 'deleteReview', {
                method: 'post',
                body: data
            }).then(function (request) {
                // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
                if (request.ok) {
                    request.json().then(function (response) {
                        let data = [];
                        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                        if (response.status) {
                            // Se llama a la función que obtiene los registros para llenar la tabla. Se encuentra en el archivo components.js
                            readRows(API_VALORACIONES);
                            // Se cierra la caja de dialogo (modal) que contiene el formulario.
                            let instance = M.Modal.getInstance(document.getElementById('administer-modal'));
                            instance.close();
                            //Mensaje
                            sweetAlert(1, response.message, null);
                        } else {
                            sweetAlert(4, response.exception, null);
                        }
                        // Se envían los datos a la función del controlador para que llene la tabla en la vista.
                        fillComments(data);
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