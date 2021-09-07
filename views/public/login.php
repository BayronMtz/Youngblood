<?php
// Se incluye la clase con las plantillas del documento.
require_once('../../app/helpers/public_page.php');
// Se imprime la plantilla del encabezado enviando el título de la página web.
Public_Page::headerTemplate('Iniciar sesión');
?>

<!-- Contenedor para mostrar el formulario de inicio de sesión -->
<div class="container">
    <!-- Título del contenido principal -->
    <h4 class="center-align indigo-text">Iniciar sesión</h4>
    <!-- Formulario para iniciar sesión -->
    <form method="post" id="session-form" autocomplete="off">
        <div class="row">
            <div class="input-field col s12 m4 offset-m4">
                <i class="material-icons prefix">email</i>
                <input type="email" id="usuario" name="usuario" autocomplete="off" class="validate" required/>
                <label for="usuario">Correo electrónico</label>
            </div>
            <div class="input-field col s12 m4 offset-m4">
                <i class="material-icons prefix">security</i>
                <input type="password" id="clave" name="clave" class="validate" required/>
                <label for="clave">Clave</label>
            </div>
        </div>
        <div class="row center-align">
            <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Ingresar"><i class="material-icons">send</i></button>
        </div>
    </form>
    <div class="row center-align">
        <a href="signin.php" type="submit" class="btn waves-effect indigo tooltipped" data-tooltip="Registrarse"><i class="material-icons">person</i></a>
    </div>
</div>

<?php
// Se imprime la plantilla del pie enviando el nombre del controlador para la página web.
Public_Page::footerTemplate('login.js');
?>