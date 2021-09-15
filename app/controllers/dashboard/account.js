/*
 *   Este controlador es de uso general en las páginas web del sitio privado. Se importa en la plantilla del pie del documento.
 *   Sirve para manejar todo lo que tiene que ver con la cuenta del usuario.
 */

// Constante para establecer la ruta y parámetros de comunicación con la API.
const API = '../../app/api/dashboard/usuarios.php?action=';

// Función para mostrar el formulario de editar perfil con los datos del usuario que ha iniciado sesión.
function openProfileDialog() {
    // Se abre la caja de dialogo (modal) que contiene el formulario para editar perfil, ubicado en el archivo de las plantillas.
    let instance = M.Modal.getInstance(document.getElementById('profile-modal'));
    instance.open();

    fetch(API + 'readProfile', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    // Se inicializan los campos del formulario con los datos del usuario que ha iniciado sesión.
                    document.getElementById('nombres_perfil').value = response.dataset.nombres_usuario;
                    document.getElementById('apellidos_perfil').value = response.dataset.apellidos_usuario;
                    document.getElementById('correo_perfil').value = response.dataset.correo_usuario;
                    document.getElementById('alias_perfil').value = response.dataset.alias_usuario;
                    // Se actualizan los campos para que las etiquetas (labels) no queden sobre los datos.
                    M.updateTextFields();
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

// Función para mostrar el formulario de editar perfil con los datos del usuario que ha iniciado sesión.
function openDevicesDialog() {
    // Se abre la caja de dialogo (modal) que contiene el formulario para editar perfil, ubicado en el archivo de las plantillas.
    let instance = M.Modal.getInstance(document.getElementById('devices-modal'));
    instance.open();

    fetch(API + 'getDevices', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    let content = '';
                    // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        hora = row.hora.substr(0, 8);
                        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
                        content += `
                                <tr>
                                    <td>${row.dispositivo}</td>
                                    <td>${row.fecha}</td>
                                    <td>${hora}</td>
                                </tr>
                            `;
                    });
                    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
                    document.getElementById('tbody-devices').innerHTML = content;

                    // Se inicializa el componente Tooltip asignado a los enlaces para que funcionen las sugerencias textuales.
                    M.Tooltip.init(document.querySelectorAll('.tooltipped'));
                    // Se actualizan los campos para que las etiquetas (labels) no queden sobre los datos.
                    M.updateTextFields();
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

// Función para mostrar el formulario de editar seguridad
function openSecurityDialog() {
    // Se abre la caja de dialogo (modal) que contiene el formulario para editar perfil, ubicado en el archivo de las plantillas.
    let instance = M.Modal.getInstance(document.getElementById('security-modal'));
    instance.open();

    fetch(API + 'readFails', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    let content = '';
                    // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        hora = row.hora.substr(0, 8);
                        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
                        content += `
                                <tr>
                                    <td>${row.fecha}</td>
                                    <td>${hora}</td>
                                    <td>${row.observacion}</td>
                                </tr>
                            `;
                    });
                    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
                    document.getElementById('tbody-security').innerHTML = content;

                    // Se inicializa el componente Tooltip asignado a los enlaces para que funcionen las sugerencias textuales.
                    M.Tooltip.init(document.querySelectorAll('.tooltipped'));
                    // Se actualizan los campos para que las etiquetas (labels) no queden sobre los datos.
                    M.updateTextFields();
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

    //Contador de intentos fallidos
    fetch(API + 'countFails', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    //Se asigna el numero obtenido al label
                    document.getElementById('lblIntentos').textContent = response.dataset.intentos;
                    // Se inicializa el componente Tooltip asignado a los enlaces para que funcionen las sugerencias textuales.
                    M.Tooltip.init(document.querySelectorAll('.tooltipped'));
                    // Se actualizan los campos para que las etiquetas (labels) no queden sobre los datos.
                    M.updateTextFields();
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

    //Capturar preferencia del usuario
    fetch(API + 'checkAuth', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    if (response.dataset.dobleverificacion == 'si') {
                        document.getElementById('checkboxValue').value = response.dataset.dobleverificacion;
                        document.getElementById('checkbox_autenticacion').setAttribute('checked', true);
                    } else {
                        document.getElementById('checkboxValue').value = response.dataset.dobleverificacion;
                    }
                    // Se inicializa el componente Tooltip asignado a los enlaces para que funcionen las sugerencias textuales.
                    M.Tooltip.init(document.querySelectorAll('.tooltipped'));
                    // Se actualizan los campos para que las etiquetas (labels) no queden sobre los datos.
                    M.updateTextFields();
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

//Al cambiar de valor el checkbox 
document.getElementById('checkbox_autenticacion').addEventListener('change',function(){
    if (document.getElementById('checkboxValue').value == 'no') {
        document.getElementById('checkboxValue').value = 'si';
    } else {
        document.getElementById('checkboxValue').value = 'no';
    }
});

// Método manejador de eventos que se ejecuta cuando se envía el formulario de editar perfil.
document.getElementById('profile-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();

    fetch(API + 'editProfile', {
        method: 'post',
        body: new FormData(document.getElementById('profile-form'))
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    // Se cierra la caja de dialogo (modal) del formulario.
                    let instance = M.Modal.getInstance(document.getElementById('profile-modal'));
                    instance.close();
                    // Se muestra un mensaje y se direcciona a la página web de bienvenida para actualizar el nombre del usuario en el menú.
                    sweetAlert(1, response.message, 'main.php');
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
});

// Método manejador de eventos que se ejecuta cuando se envía el formulario de editar seguridad.
document.getElementById('security-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();

    fetch(API + 'updateAuth', {
        method: 'post',
        body: new FormData(document.getElementById('security-form'))
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    // Se cierra la caja de dialogo (modal) del formulario.
                    let instance = M.Modal.getInstance(document.getElementById('security-modal'));
                    instance.close();
                    // Se muestra un mensaje
                    if (document.getElementById('checkboxValue').value == 'no') {
                        sweetAlert(1, 'Inicio de sesión en dos pasos desactivado correctamente.', null);
                    } else {
                        sweetAlert(1, 'Inicio de sesión en dos pasos activado correctamente.', null);
                    }
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
});

// Función para mostrar el formulario de cambiar contraseña del usuario que ha iniciado sesión.
function openPasswordDialog() {
    // Se restauran los elementos del formulario.
    document.getElementById('password-form').reset();
    // Se abre la caja de dialogo (modal) que contiene el formulario para cambiar contraseña, ubicado en el archivo de las plantillas.
    let instance = M.Modal.getInstance(document.getElementById('password-modal'));
    instance.open();
}

// Método manejador de eventos que se ejecuta cuando se envía el formulario de cambiar clave.
document.getElementById('password-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();

    fetch(API + 'changePassword', {
        method: 'post',
        body: new FormData(document.getElementById('password-form'))
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    // Se cierra la caja de dialogo (modal) del formulario.
                    let instance = M.Modal.getInstance(document.getElementById('password-modal'));
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
});

//Función para mostrar contraseña
function showHidePassword(checkbox, pass1, pass2, pass3) {
    var check = document.getElementById(checkbox);
    var password = document.getElementById(pass1);
    var password2 = document.getElementById(pass2);
    var password3 = document.getElementById(pass3);
    //Verificando el estado del check
    if (check.checked == true) {
        password.type = 'text';
        password2.type = 'text';
        password3.type = 'text';
    } else {
        password.type = 'password';
        password2.type = 'password';
        password3.type = 'password';
    }
}

// Función para mostrar un mensaje de confirmación al momento de cerrar sesión.
function logOut() {
    swal({
        title: 'Advertencia',
        text: '¿Quiere cerrar la sesión?',
        icon: 'warning',
        buttons: ['No', 'Sí'],
        closeOnClickOutside: false,
        closeOnEsc: false
    }).then(function (value) {
        // Se verifica si fue cliqueado el botón Sí para hacer la petición de cerrar sesión, de lo contrario se muestra un mensaje.
        if (value) {
            fetch(API + 'logOut', {
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
        } else {
            sweetAlert(4, 'Puede continuar con la sesión', null);
        }
    });
}