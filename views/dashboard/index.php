<?php
// Se incluye la clase con las plantillas del documento.
require_once('../../app/helpers/dashboard_page.php');
// Se imprime la plantilla del encabezado enviando el título de la página web.
Dashboard_Page::headerTemplate('Iniciar sesión');
?>

<div class="container">
    <div class="row">
        <!-- Formulario para iniciar sesión -->
        <form method="post" id="session-form" autocomplete="off">
            <div class="input-field col s12 m6 offset-m3">
                <i class="material-icons prefix">person_pin</i>
                <input id="alias" type="text" name="alias" class="validate" required/>
                <label for="alias">Alias</label>
            </div>
            <div class="input-field col s12 m6 offset-m3">
                <i class="material-icons prefix">security</i>
                <input id="clave" type="password" name="clave" class="validate" required/>
                <label for="clave">Clave</label>
            </div>
            <div class="col s12 center-align">
                <p>
                    <label>
                    <input type="checkbox" onchange="showHidePassword('checkboxContraseña', 'clave')" id="checkboxContraseña" />
                    <span>Mostrar Contraseña</span>
                    </label>
                </p>
                <a href="verificar_email.php" class="form-text">¿Hás olvidado tu contraseña?</a>
            </div>
            
            <div class="col s12 center-align">
                <br>
                <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Ingresar"><i class="material-icons">send</i></button>
            </div>
        </form>
    </div>
</div>

<?php
// Se imprime la plantilla del pie enviando el nombre del controlador para la página web.
Dashboard_Page::footerTemplate('index.js');
?>
