<?php
// Se incluye la clase con las plantillas del documento.
require_once('../../app/helpers/public_page.php');
// Se imprime la plantilla del encabezado enviando el título de la página web.
Public_Page::headerTemplate('Cambiar contraseña');
?>

<!-- Formulario para registrar al primer usuario del dashboard -->
<div class="container">
    <form method="post" id="verificate-form" autocomplete="off">
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <blockquote>
                Ingresa el código enviado a tu correo electrónico.
                </blockquote>
            </div>
            <div class="input-field col s6 offset-m3">
                <i class="material-icons prefix">mail</i>
                <input id="codigo" name="codigo" type="text" class="validate" maxlength="6" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                <label for="codigo">Codigo de Verificación</label>
            </div>
        </div>
        <div class="row center-align">
            <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Iniciar sesión"><i class="material-icons">send</i></button>
        </div>
    </form>
</div>

<?php
// Se imprime la plantilla del pie enviando el nombre del controlador para la página web.
Public_Page::footerTemplate('autenticacion.js');
?>