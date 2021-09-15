// Constante para establecer la ruta y parámetros de comunicación con la API.
const API2 = '../../app/api/dashboard/usuarios.php?action=';

//Se guarda una variable que contendra el tiempo
var time = 300000;

//Timeout
let timer;
const runTimer = () => {
    timer = window.setTimeout(
      () => {
        fetch(API2 + 'logOut', {
            method: 'get'
        }).then(function (request) {
            // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje indicando el problema.
            if (request.ok) {
                request.json().then(function (response) {
                    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                    if (response.status) {
                        sweetAlert(1, 'Sesión cerrada por inactividad.', 'index.php');
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
      }, time);
  }

runTimer();

//Al mover el mouse se reinicia el timeout
document.body.onmousemove = function(){
    clearTimeout(timer);
    runTimer();
}

//Al hacer click se reinicia el timeout
document.body.onclick = function(){
    clearTimeout(timer);
    runTimer();
}

//Al presionar una tecla se reinicia el timeout
document.body.onkeydown = function(){
    clearTimeout(timer);
    runTimer();
}

//Al hacer scroll se reinicia el timeout
document.body.onscroll = function(){
    clearTimeout(timer);
    runTimer();
}


