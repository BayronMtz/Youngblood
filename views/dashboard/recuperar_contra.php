<?php
// Se incluye la clase con las plantillas del documento.
require_once('../../app/helpers/dashboard_page.php');
// Se imprime la plantilla del encabezado enviando el título de la página web.
Dashboard_Page::headerTemplate('Cambiar contraseña');
?>

<div class="container">
    <div class="row">
                    <label>Su contraseña debe como mínimo ocho caracteres entre
                        alfanuméricos y especiales (al menos uno de cada uno) y que sea diferente al nombre de usuario</label>
                    
                    <form method="post" id="password-form">
                        <div class="row center-align">
                            <label>CLAVE NUEVA</label>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">security</i>
                                <input id="clave_nueva_1" type="password" name="clave_nueva_1" class="validate" required/>
                                <label for="clave_nueva_1">Clave</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">security</i>
                                <input id="clave_nueva_2" type="password" name="clave_nueva_2" class="validate" required/>
                                <label for="clave_nueva_2">Confirmar clave</label>
                            </div>
                        </div>
                        <div class="row center-align">
                            <p>
                                <label>
                                <input type="checkbox" onchange="showHidePassword('checkboxContraseña','clave_nueva_1','clave_nueva_2')" id="checkboxContraseña" />
                                <span>Mostrar Contraseña</span>
                                </label>
                            </p>
                        </div>
                        <div class="row center-align">
                            <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Guardar"><i class="material-icons">save</i></button>
                        </div>
                    </form>
    </div>
</div>
<?php
// Se imprime la plantilla del pie enviando el nombre del controlador para la página web.
Dashboard_Page::footerTemplate('recuperar_contra.js');
?>
