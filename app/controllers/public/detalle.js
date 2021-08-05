// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_CATALOGO = '../../app/api/public/catalogo.php?action=';
const ENDPOINT_SCORE = '../../app/api/public/catalogo.php?action=readScores';
const API_PEDIDOS = '../../app/api/public/pedidos.php?action=';

// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Se busca en la URL las variables (parámetros) disponibles.
    let params = new URLSearchParams(location.search);
    // Se obtienen los datos localizados por medio de las variables.
    const ID = params.get('id');
    // Se llama a la función que muestra el detalle del producto seleccionado previamente.
    readOneProducto(ID);
    document.getElementById('id_producto2').value = ID;

    fillSelect(ENDPOINT_SCORE, 'cb_puntuacion', null);

    showReviews();

    M.updateTextFields();

});

//Funcion para cargar las valoraciones
function showReviews(){
    // Se busca en la URL las variables (parámetros) disponibles.
    let params = new URLSearchParams(location.search);
    // Se obtienen los datos localizados por medio de las variables.
    const ID = params.get('id');
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('id_producto', ID);

    fetch(API_CATALOGO + 'showReviews', {
        method: 'post',
        body: data
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                let data = [];
                if (response.status) {
                    // Se colocan los datos en la tarjeta de acuerdo al comentario seleccionado previamente.
                    data = response.dataset;
                } else {
                    // Se presenta un mensaje de error cuando no existen datos para mostrar.
                    document.getElementById('title2').innerHTML = `<i class="material-icons small">cloud_off</i><span class="red-text">${response.exception}</span>`;
                }
                fillReviews(data);
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
}

function fillReviews(dataset) {
    let content = '';
    // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
    dataset.map(function (row) {
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        content += `
            <div class="col s12 m6">
                <div class="card white-grey darken-1">
                    <div class="card-content dark-text">
                        <span class="card-title">${row.cliente}</span>
                        <p>${row.puntuacion}</p>
                        <p>${row.fecha}</p>
                        <p style="margin-top: 10px;">${row.valoracion}</p>
                    </div>
                </div>
            </div>
        `;
    });
    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
    document.getElementById('row-body').innerHTML = content;
}

// Función para obtener y mostrar los datos del producto seleccionado.
function readOneProducto(id) {
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('id_producto', id);

    fetch(API_CATALOGO + 'readOne', {
        method: 'post',
        body: data
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    // Se colocan los datos en la tarjeta de acuerdo al producto seleccionado previamente.
                    document.getElementById('imagen').setAttribute('src', '../../resources/img/productos/' + response.dataset.imagen_producto);
                    document.getElementById('nombre').textContent = response.dataset.nombre_producto;
                    document.getElementById('descripcion').textContent = response.dataset.descripcion_producto;
                    document.getElementById('precio').textContent = response.dataset.precio_producto;
                    document.getElementById('cantidad').textContent = response.dataset.cantidad;
                    // Se asignan los valores a los campos ocultos del formulario.
                    document.getElementById('id_producto').value = response.dataset.id_producto;
                    document.getElementById('precio_producto').value = response.dataset.precio_producto;

                    if (response.dataset.cantidad == 0) {
                        document.getElementById('shopping-form').className = 'hide';
                        document.getElementById('disponiblelbl').className = '#';
                    }
                } else {
                    // Se presenta un mensaje de error cuando no existen datos para mostrar.
                    document.getElementById('title').innerHTML = `<i class="material-icons small">cloud_off</i><span class="red-text">${response.exception}</span>`;
                    // Se limpia el contenido cuando no hay datos para mostrar.
                    document.getElementById('detalle').innerHTML = '';
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
}

// Método manejador de eventos que se ejecuta cuando se envía el formulario de agregar un producto al carrito.
document.getElementById('shopping-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();

    var cantidad = parseInt(document.getElementById('cantidad').textContent);

    if (parseInt(document.getElementById('cantidad_producto').value) > cantidad) {
        sweetAlert(2, 'Cantidad maxima superada, lo permitido es: '+cantidad,null);
    } else {
        var nueva_cantidad = parseInt(document.getElementById('cantidad').textContent) - parseInt(document.getElementById('cantidad_producto').value);
        document.getElementById('nuevo_stock').value = nueva_cantidad;

        fetch(API_PEDIDOS + 'createDetail', {
            method: 'post',
            body: new FormData(document.getElementById('shopping-form'))
        }).then(function (request) {
            // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
            if (request.ok) {
                request.json().then(function (response) {
                    // Se comprueba si la respuesta es satisfactoria, de lo contrario se constata si el cliente ha iniciado sesión.
                    if (response.status) {
                        sweetAlert(1, response.message, 'index.php');
                    } else {
                        // Se verifica si el cliente ha iniciado sesión para mostrar la excepción, de lo contrario se direcciona para que se autentique. 
                        if (response.session) {
                            sweetAlert(2, response.exception, null);
                        } else {
                            sweetAlert(3, response.exception, 'login.php');
                        }
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

//Al ejecutar el evento submit del formulario de valoraciones
document.getElementById('valoraciones-form').addEventListener('submit',function(event){
    //Se evita recargar la pagina
    event.preventDefault();

    fetch(API_CATALOGO + 'createRatings', {
        method: 'post',
        body: new FormData(document.getElementById('valoraciones-form'))
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
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

})