// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_USUARIOS = '../../app/api/dashboard/usuarios.php?action=';

// Método manejador de eventos que se ejecuta cuando se envía el formulario de cambiar clave.
document.getElementById('password-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();

    fetch(API_USUARIOS + 'changePasswordOut', {
        method: 'post',
        body: new FormData(document.getElementById('password-form'))
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
});

//Función para mostrar contraseña
function showHidePassword(checkbox, pass1, pass2) {
    var check = document.getElementById(checkbox);
    var password = document.getElementById(pass1);
    var password2 = document.getElementById(pass2);
    //Verificando el estado del check
    if (check.checked == true) {
        password.type = 'text';
        password2.type = 'text';
    } else {
        password.type = 'password';
        password2.type = 'password';
    }
}