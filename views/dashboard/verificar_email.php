<?php
// Se incluye la clase con las plantillas del documento.
require_once('../../app/helpers/dashboard_page.php');
// Se imprime la plantilla del encabezado enviando el título de la página web.
Dashboard_Page::headerTemplate('Verificar email');
?>

<div class="container">
    <div class="row">
        <label>Ingrese su correo electrónico para verificar su existencia en la base de datos 
            y mandar el código de verificación
        </label>
        
        <form method="post" id="password-form">
            <div class="row">
                <div class="input-field col s12 m6 offset-m3">
                    <i class="material-icons prefix">security</i>
                    <input id="txtCorreo" type="email" name="txtCorreo" class="validate" required/>
                    <label for="clave_actual">Correo</label>
                </div>
            </div>
            <div class="row center-align">
                <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Guardar"><i class="material-icons">check</i></button>
            </div>
        </form>
    </div>
</div>
<?php
// Se imprime la plantilla del pie enviando el nombre del controlador para la página web.
Dashboard_Page::footerTemplate('verificar_email.js');
?>
