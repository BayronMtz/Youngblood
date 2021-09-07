<?php
// Se incluye la clase con las plantillas del documento.
require_once('../../app/helpers/public_page.php');
// Se imprime la plantilla del encabezado enviando el título de la página web.
Public_Page::headerTemplate('Registrarse');
?>

<!-- Contenedor para mostrar el formulario de registro de clientes -->
<div class="container">
    <!-- Título del contenido principal -->
    <h4 class="center-align indigo-text">Regístrate como cliente</h4>
    <!-- Formulario para crear cuenta -->
    <form method="post" id="register-form" autocomplete="off">
        <!-- Campo oculto para asignar el token del reCAPTCHA -->
        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response"/>
        <div class="row">
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">account_box</i>
                <input type="text" id="nombres_cliente" name="nombres_cliente" pattern="[a-zA-ZñÑáÁéÉíÍóÓúÚ\s]{1,50}" class="validate" required/>
                <label for="nombres_cliente">Nombres</label>
            </div>
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">account_box</i>
                <input type="text" id="apellidos_cliente" name="apellidos_cliente" pattern="[a-zA-ZñÑáÁéÉíÍóÓúÚ\s]{1,50}" class="validate" required/>
                <label for="apellidos_cliente">Apellidos</label>
            </div>
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">email</i>
                <input type="email" id="correo_cliente" name="correo_cliente" maxlength="100" class="validate" required/>
                <label for="correo_cliente">Correo electrónico</label>
            </div>
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">how_to_reg</i>
                <input type="text" id="dui_cliente" name="dui_cliente" placeholder="00000000-0" pattern="[0-9]{8}[-][0-9]{1}" class="validate" required/>
                <label for="dui_cliente">DUI</label>
            </div>
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">phone</i>
                <input type="text" id="telefono_cliente" name="telefono_cliente" placeholder="0000-0000" pattern="[2,6,7]{1}[0-9]{3}[-][0-9]{4}" class="validate" required/>
                <label for="telefono_cliente">Teléfono</label>
            </div>
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">cake</i>
                <input type="date" id="nacimiento_cliente" name="nacimiento_cliente" class="validate" required/>
                <label for="nacimiento_cliente">Nacimiento</label>
            </div>
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">security</i>
                <input type="password" id="clave_cliente" minlength="8" name="clave_cliente" class="validate" required/>
                <label for="clave_cliente">Clave</label>
            </div>
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">security</i>
                <input type="password" id="confirmar_clave" minlength="8" name="confirmar_clave" class="validate" required/>
                <label for="confirmar_clave">Confirmar clave</label>
            </div>
            <div class="input-field col s12">
                <i class="material-icons prefix">place</i>
                <input type="text" id="direccion_cliente" name="direccion_cliente" maxlength="200" class="validate" required/>
                <label for="direccion_cliente">Dirección</label>
            </div>
            <div class="input-field col s12">
                <i class="material-icons prefix">account_box</i>
                <input type="text" id="alias_usuario" name="alias_usuario" maxlength="200" class="validate" required/>
                <label for="alias_usuario">Alias</label>
            </div>
            <label class="center-align col s12">
                <input type="checkbox" id="condicion" name="condicion" required/>
                <span>Acepto <a href="#terminos" class="modal-trigger">términos y condiciones</a></span>
            </label>
        </div>
        <div class="row center-align">
            <div class="col s12">
                <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Registrar"><i class="material-icons">send</i></button>
            </div>
        </div>
    </form>
</div>

<!-- Importación del archivo para que funcione el reCAPTCHA. Para más información https://developers.google.com/recaptcha/docs/v3 -->
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?render=6LdBzLQUAAAAAJvH-aCUUJgliLOjLcmrHN06RFXT"></script>

<?php
// Se imprime la plantilla del pie enviando el nombre del controlador para la página web.
Public_Page::footerTemplate('signin.js');
?>