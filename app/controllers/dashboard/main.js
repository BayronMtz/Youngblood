// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_PRODUCTOS = '../../app/api/dashboard/productos.php?action=';
const API_CLIENTES = '../../app/api/dashboard/clientes.php?action=';
const API_PEDIDOS = '../../app/api/dashboard/pedidos.php?action=';

// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Se declara e inicializa un objeto con la fecha y hora actual.
    let today = new Date();
    // Se declara e inicializa una variable con el número de horas transcurridas en el día.
    let hour = today.getHours();
    // Se declara e inicializa una variable para guardar un saludo.
    let greeting = '';
    // Dependiendo del número de horas transcurridas en el día, se asigna un saludo para el usuario.
    if (hour < 12) {
        greeting = 'Buenos días';
    } else if (hour < 19) {
        greeting = 'Buenas tardes';
    } else if (hour <= 23) {
        greeting = 'Buenas noches';
    }
    // Se muestra el saludo en la página web.
    document.getElementById('greeting').textContent = greeting;
    // Se llaman a la funciones que muestran las gráficas en la página web.
    graficaBarrasCategorias();
    graficaLineasClientes();
    graficaPastelProductos();
    graficaLineasProductos();
    graficaDonaPedidos();
});
// Función para mostrar la cantidad de clientes registrados los ultimos 6 meses
function graficaLineasClientes() {
    fetch(API_CLIENTES + 'clienteMes', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas de la gráfica.
                if (response.status) {
                    // Se declaran los arreglos para guardar los datos por gráficar.
                    let meses = [];
                    let cantidad = [];
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        // Se asignan los datos a los arreglos.
                        meses.push(row.mes);
                        cantidad.push(row.cantidad);
                    });
                    // Se llama a la función que genera y muestra una gráfica de barras. Se encuentra en el archivo components.js
                    lineGraph('chart3', meses, cantidad, 'Ultimos 6 Meses', 'Cantidad de Clientes: ', 'Clientes Registrados');
                } else {
                    document.getElementById('chart3').remove();
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
}

// Función para mostrar la cantidad de productos vendidos los ultimos 6 meses
function graficaLineasProductos() {
    fetch(API_PRODUCTOS + 'productosVendidos', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas de la gráfica.
                if (response.status) {
                    // Se declaran los arreglos para guardar los datos por gráficar.
                    let meses = [];
                    let cantidad = [];
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        // Se asignan los datos a los arreglos.
                        meses.push(row.mes);
                        cantidad.push(row.cantidaddia);
                    });
                    // Se llama a la función que genera y muestra una gráfica de barras. Se encuentra en el archivo components.js
                    lineGraph('chart5', meses, cantidad, 'Ultimos 6 Meses', 'Productos Vendidos: ', 'Productos Vendidos');
                } else {
                    document.getElementById('chart5').remove();
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
}

// Función para mostrar la cantidad de clientes registrados los ultimos 6 meses
function graficaDonaPedidos() {
    fetch(API_PEDIDOS + 'pedidosEstado', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas de la gráfica.
                if (response.status) {
                    // Se declaran los arreglos para guardar los datos por gráficar.
                    let estado_pedido = [];
                    let porcentaje = [];
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        // Se asignan los datos a los arreglos.
                        estado_pedido.push(row.estado_pedido);
                        porcentaje.push(row.porcentaje);
                    });
                    /*  Es necesario crear un arreglo para tener los estados de los pedidos de forma textual y enviarlos a components.js,
                        aclarando esto: 
                    *
                    *   ESTADOS PARA UN PEDIDO
                    *   0: Pendiente. Es cuando el pedido esta en proceso por parte del cliente y se puede modificar el detalle.
                    *   1: Finalizado. Es cuando el cliente finaliza el pedido y ya no es posible modificar el detalle.
                    *   2: Entregado. Es cuando la tienda ha entregado el pedido al cliente.
                    *   3: Anulado. Es cuando el cliente se arrepiente de haber realizado el pedido.
                    */
                    
                    let estados = [];
                    //Recorremos el arreglo con los estados numericos, evaluando cada uno para ingresarlo al nuevo arreglo de forma textual
                    for (let index = 0; index < estado_pedido.length; index++) {
                        if (estado_pedido[index] == 0) {
                            estados[index] = 'Pendiente';
                        } else if (estado_pedido[index] == 1) {
                            estados[index] = 'Finalizado';
                        } else if (estado_pedido[index] == 2) {
                            estados[index] = 'Entregado';
                        } else if (estado_pedido[index] == 3) {
                            estados[index] = 'Anulado';
                        }
                    }

                    // Se llama a la función que genera y muestra una gráfica de barras. Se encuentra en el archivo components.js
                    doughnutGraph('chart6', estados, porcentaje, 'Pedidos por Estado');
                } else {
                    document.getElementById('chart6').remove();
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
}

//Funcion para mostrar el top 5 de productos mas vendidos en una grafica de pastel
function graficaPastelProductos() {
    fetch(API_PRODUCTOS + 'topProducts', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas de la gráfica.
                if (response.status) {
                    // Se declaran los arreglos para guardar los datos por gráficar.
                    let nombre_producto = [];
                    let cantidad = [];
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        // Se asignan los datos a los arreglos.
                        nombre_producto.push(row.nombre_producto);
                        cantidad.push(row.cantidad);
                    });
                    // Se llama a la función que genera y muestra una gráfica de barras. Se encuentra en el archivo components.js
                    pieGraph('chart4', nombre_producto, cantidad, 'Top 5 Productos mas Vendidos');
                } else {
                    document.getElementById('chart4').remove();
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
}

// Función para mostrar la cantidad de productos por categoría en una gráfica de barras.
function graficaBarrasCategorias() {
    fetch(API_PRODUCTOS + 'cantidadProductosCategoria', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas de la gráfica.
                if (response.status) {
                    // Se declaran los arreglos para guardar los datos por gráficar.
                    let categorias = [];
                    let cantidad = [];
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        // Se asignan los datos a los arreglos.
                        categorias.push(row.nombre_categoria);
                        cantidad.push(row.cantidad);
                    });
                    // Se llama a la función que genera y muestra una gráfica de barras. Se encuentra en el archivo components.js
                    barGraph('chart1', categorias, cantidad, 'Cantidad de productos', 'Cantidad de productos por categoría');
                } else {
                    document.getElementById('chart1').remove();
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
}