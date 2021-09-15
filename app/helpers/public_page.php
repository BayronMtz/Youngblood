<?php
/*
*   Clase para definir las plantillas de las páginas web del sitio público.
*/
class Public_Page
{
    /*
    *   Método para imprimir la plantilla del encabezado.
    *
    *   Parámetros: $title (título de la página web).
    *
    *   Retorno: ninguno.
    */
    public static function headerTemplate($title)
    {
        // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en las páginas web.
        session_start();
        // Se imprime el código HTML para el encabezado del documento.
        print('
            <!DOCTYPE html>
            <html lang="es">
                <head>
                    <meta charset="utf-8">
                    <title>YoungBlood - '.$title.'</title>
                    <link type="image/png" rel="icon" href="../../resources/img/logo.png"/>
                    <link type="text/css" rel="stylesheet" href="../../resources/css/materialize.min.css"/>
                    <link type="text/css" rel="stylesheet" href="../../resources/css/material_icons.css"/>
                    <link type="text/css" rel="stylesheet" href="../../resources/css/public.css"/>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                </head>
                <body>
        ');
        // Se obtiene el nombre del archivo de la página web actual.
        $filename = basename($_SERVER['PHP_SELF']);
        // Se comprueba si existe una sesión de cliente para mostrar el menú de opciones, de lo contrario se muestra otro menú.
        if (isset($_SESSION['id_cliente'])) {
            // Se verifica si la página web actual es diferente a login.php y register.php, de lo contrario se direcciona a index.php
            if ($filename != 'login.php' && $filename != 'signin.php' && $filename != 'cambiar_contra.php') {
                print('
                    <header>
                        <div class="navbar-fixed">
                            <nav class="indigo darken-4">
                                <div class="nav-wrapper">
                                    <a href="index.php" class="brand-logo"><img src="../../resources/img/logo.png" height="60"></a>
                                    <a href="#" data-target="mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                                    <ul class="right hide-on-med-and-down">
                                        <li><a href="index.php"><i class="material-icons left">view_module</i>Catálogo</a></li>
                                        <li><a href="index.php"><i class="material-icons left">search</i>Buscar producto</a></li>
                                        <li><a href="cart.php"><i class="material-icons left">shopping_cart</i>Carrito</a></li>
                                        <li><a href="pedidos.php"><i class="material-icons left">event_note</i>Mis Pedidos</a></li>
                                        <li><a href="#" class="dropdown-trigger" data-target="dropdown"><i class="material-icons left">verified_user</i>Cuenta: <b>' . $_SESSION['alias_cliente'] . '</b></a></li>
                                    </ul>
                                    <ul id="dropdown" class="dropdown-content">
                                        <li><a href="#" onclick="openProfileDialog()"><i class="material-icons">face</i>Editar perfil</a></li>
                                        <li><a href="#" onclick="openPasswordDialog()"><i class="material-icons">lock</i>Cambiar clave</a></li>
                                        <li><a href="#" onclick="openDevicesDialog()"><i class="material-icons">devices</i>Dispositivos</a></li>
                                        <li><a href="#" onclick="openSecurityDialog()"><i class="material-icons">security</i>Seguridad</a></li>
                                        <li><a href="#" onclick="logOut()"><i class="material-icons">clear</i>Salir</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <ul class="sidenav" id="mobile">
                            <li><a href="index.php"><i class="material-icons left">view_module</i>Catálogo</a></li>
                            <li><a href="index.php"><i class="material-icons left">search</i>Buscar producto</a></li>
                            <li><a href="cart.php"><i class="material-icons left">shopping_cart</i>Carrito</a></li>
                            <li><a href="pedidos.php"><i class="material-icons left">event_note</i>Mis Pedidos</a></li>
                            <li><a class="dropdown-trigger" href="#" data-target="dropdown-mobile"><i class="material-icons">verified_user</i>Cuenta: <b>' . $_SESSION['alias_usuario'] . '</b></a></li>
                        </ul>
                        <ul id="dropdown-mobile" class="dropdown-content">
                            <li><a href="#" onclick="openProfileDialog()">Editar perfil</a></li>
                            <li><a href="#" onclick="openPasswordDialog()">Cambiar clave</a></li>
                            <li><a href="#" onclick="openDevicesDialog()">Dispositivos</a></li>
                            <li><a href="#" onclick="openSecurityDialog()">Seguridad</a></li>
                            <li><a href="#" onclick="logOut()">Salir</a></li>
                        </ul>
                    </header>

                    <!-- Componente Modal para mostrar el formulario de editar perfil -->
                    <div id="profile-modal" class="modal">
                        <div class="modal-content">
                            <h4 class="center-align">Editar perfil</h4>
                            <form method="post" id="profile-form">
                                <div class="row">
                                    <div class="input-field col s12 m6">
                                        <i class="material-icons prefix">person</i>
                                        <input id="nombres_perfil" type="text" name="nombres_perfil" class="validate" required/>
                                        <label for="nombres_perfil">Nombres</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <i class="material-icons prefix">person</i>
                                        <input id="apellidos_perfil" type="text" name="apellidos_perfil" class="validate" required/>
                                        <label for="apellidos_perfil">Apellidos</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <i class="material-icons prefix">email</i>
                                        <input id="correo_perfil" type="email" name="correo_perfil" class="validate" required/>
                                        <label for="correo_perfil">Correo</label>
                                    </div>
                                    <div class="input-field col s12 m6">
                                        <i class="material-icons prefix">person_pin</i>
                                        <input id="alias_perfil" type="text" name="alias_perfil" class="validate" required/>
                                        <label for="alias_perfil">Alias</label>
                                    </div>
                                </div>
                                <div class="row center-align">
                                    <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i class="material-icons">cancel</i></a>
                                    <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Guardar"><i class="material-icons">save</i></button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Componente Modal para mostrar el formulario de cambiar contraseña -->
                    <div id="password-modal" class="modal">
                        <div class="modal-content">
                            <h4 class="center-align">Cambiar contraseña</h4>
                            <label>Su contraseña debe como mínimo ocho caracteres entre
                                alfanuméricos y especiales (al menos uno de cada uno) y que sea diferente al nombre de usuario</label>
                            
                            <form method="post" id="password-form">
                                <div class="row">
                                    <div class="input-field col s12 m6 offset-m3">
                                        <i class="material-icons prefix">security</i>
                                        <input id="clave_actual" type="password" name="clave_actual" class="validate" required/>
                                        <label for="clave_actual">Clave actual</label>
                                    </div>
                                </div>
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
                                        <input type="checkbox" onchange="showHidePassword(\'checkboxContraseña\', \'clave_actual\',\'clave_nueva_1\',\'clave_nueva_2\')" id="checkboxContraseña" />
                                        <span>Mostrar Contraseña</span>
                                        </label>
                                    </p>
                                </div>
                                <div class="row center-align">
                                    <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i class="material-icons">cancel</i></a>
                                    <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Guardar"><i class="material-icons">save</i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Componente Modal para mostrar el formulario de dispositivos -->
                    <div id="devices-modal" class="modal">
                        <div class="modal-content">
                            <h4 class="center-align">Dispositivos</h4>
                            <form method="post" id="device-form">
                                <div class="row">
                                    <!-- Tabla para mostrar los registros existentes -->
                                    <table class="highlight" id="data-table">
                                        <!-- Cabeza de la tabla para mostrar los títulos de las columnas -->
                                        <thead>
                                            <tr>
                                                <th>DISPOSITIVO</th>
                                                <th>FECHA</th>
                                                <th>HORA</th>
                                            </tr>
                                        </thead>
                                        <!-- Cuerpo de la tabla para mostrar un registro por fila -->
                                        <tbody id="tbody-devices">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row center-align">
                                    <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i class="material-icons">cancel</i></a>
                                </div>
                            </form>
                        </div>
                    </div>
        
                    <!-- Componente Modal para mostrar el formulario de seguridad -->
                    <div id="security-modal" class="modal">
                        <div class="modal-content">
                            <h4 class="center-align">Panel de Seguridad</h4>
                            <form method="post" id="security-form">
                                <div class="row">
                                    <div class="col s12 m6">
                                        <blockquote>
                                        Intentos fallidos de sesión: <b id="lblIntentos">14</b>
                                        </blockquote>
                                    </div>
                                    <div class="col s12 m6">
                                        <p>
                                            <label>
                                            <input id="checkbox_autenticacion" type="checkbox" />
                                            <span>Inicio de sesión en dos pasos</span>
                                            </label>
                                        </p>
                                        <input type="hidden" value="no" id="checkboxValue" name="checkboxValue"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Tabla para mostrar los registros existentes -->
                                    <table class="highlight" id="data-table">
                                        <!-- Cabeza de la tabla para mostrar los títulos de las columnas -->
                                        <thead>
                                            <tr>
                                                <th>FECHA</th>
                                                <th>HORA</th>
                                                <th>OBSERVACIÓN</th>
                                            </tr>
                                        </thead>
                                        <!-- Cuerpo de la tabla para mostrar un registro por fila -->
                                        <tbody id="tbody-security">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row center-align">
                                    <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Guardar Cambios"><i class="material-icons">save</i></button>
                                    <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i class="material-icons">cancel</i></a>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <main>
                ');
            } else {
                header('location: index.php');
            }
        } else {
            // Se verifica si la página web actual es diferente a index.php (Iniciar sesión) y a register.php (Crear primer usuario) para direccionar a index.php, de lo contrario se muestra un menú vacío.
            if ($filename != 'cart.php') {
                print('
                    <header>
                        <div class="navbar-fixed">
                            <nav class="indigo darken-4">
                                <div class="nav-wrapper">
                                    <a href="index.php" class="brand-logo"><img src="../../resources/img/logo.png" height="60"></a>
                                    <a href="#" data-target="mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                                    <ul class="right hide-on-med-and-down">
                                        <li><a href="index.php"><i class="material-icons left">view_module</i>Catálogo</a></li>
                                        <li><a href="index.php"><i class="material-icons left">search</i>Buscar producto</a></li>
                                        <li><a href="signin.php"><i class="material-icons left">person</i>Crear cuenta</a></li>
                                        <li><a href="login.php"><i class="material-icons left">login</i>Iniciar sesión</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <ul class="sidenav" id="mobile">
                            <li><a href="index.php"><i class="material-icons left">view_module</i>Catálogo</a></li>
                            <li><a href="index.php"><i class="material-icons left">search</i>Buscar producto</a></li>
                            <li><a href="signin.php"><i class="material-icons left">person</i>Crear cuenta</a></li>
                            <li><a href="login.php"><i class="material-icons left">login</i>Iniciar sesión</a></li>
                        </ul>
                    </header>
                    <main>
                ');
            } else {
                header('location: login.php');
            }
        }
        // Se llama al método que contiene el código de las cajas de dialogo (modals).
        self::modals();
    }

    /*
    *   Método para imprimir la plantilla del pie.
    *
    *   Parámetros: $controller (nombre del archivo que sirve como controlador de la página web).
    *
    *   Retorno: ninguno.
    */
    public static function footerTemplate($controller)
    {
        // Se imprime el código HTML para el pie del documento.
        print('
                    <!-- Contenedor para mostrar efecto parallax con una altura de 300px e imagen aleatoria -->
                    
                </main>
                <footer class="page-footer indigo darken-4">
                    <div class="container">
                        <div class="row">
                            <div class="col s12 m6 l6">
                                <h5 class="white-text">Nosotros</h5>
                                <p>
                                    <blockquote>
                                        <a href="#mision" class="modal-trigger white-text"><b>Misión</b></a>
                                        <span>|</span>
                                        <a href="#vision" class="modal-trigger white-text"><b>Visión</b></a>
                                        <span>|</span>
                                        <a href="#valores" class="modal-trigger white-text"><b>Valores</b></a>
                                    </blockquote>
                                    <blockquote>
                                        <a href="#terminos" class="modal-trigger white-text"><b>Términos y condiciones</b></a>
                                    </blockquote>
                                </p>
                            </div>
                            <div class="col s12 m6 l6">
                                <h5 class="white-text">Contáctanos</h5>
                                <p>
                                    <blockquote>
                                        <a class="white-text" href="https://www.facebook.com/" target="_blank"><b>facebook</b></a>
                                        <span>|</span>
                                        <a class="white-text" href="https://twitter.com/" target="_blank"><b>twitter</b></a>
                                    </blockquote>
                                    <blockquote>
                                        <a class="white-text" href="https://www.instagram.com/" target="_blank"><b>instagram</b></a>
                                        <span>|</span>
                                        <a class="white-text" href="https://www.youtube.com/" target="_blank"><b>youtube</b></a>
                                    </blockquote>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="footer-copyright">
                        <div class="container">
                            <span>© YOUNGBLOOD, todos los derechos reservados.</span>
                            <span class="white-text right">Be Brave, <a class="red-text text-accent-1" href="#"><b>Be Young</b></a></span>
                        </div>
                    </div>
                </footer>
                <script type="text/javascript" src="../../resources/js/materialize.min.js"></script>
                <script type="text/javascript" src="../../resources/js/sweetalert.min.js"></script>
                <script type="text/javascript" src="../../app/helpers/components.js"></script>
                <script type="text/javascript" src="../../app/controllers/public/initialization.js"></script>
                <script type="text/javascript" src="../../app/controllers/public/account.js"></script>
                <script type="text/javascript" src="../../app/controllers/public/'.$controller.'"></script>
            </body>
            </html>
        ');
    }

    /*
    *   Método para imprimir las cajas de dialogo (modals).
    */
    private static function modals()
    {
        // Se imprime el código HTML de las cajas de dialogo (modals).
        print('
            <!-- Componente Modal para mostrar los Términos y condiciones -->
            <div id="terminos" class="modal">
                <div class="modal-content">
                    <h4 class="center-align">TÉRMINOS Y CONDICIONES</h4>
                    <p>Nuestra empresa ofrece los mejores productos a nivel nacional con una calidad garantizada y...</p>
                </div>
                <div class="divider"></div>
                <div class="modal-footer">
                    <a href="#!" class="modal-action modal-close btn waves-effect"><i class="material-icons">done</i></a>
                </div>
            </div>

            <!-- Componente Modal para mostrar la Misión -->
            <div id="mision" class="modal">
                <div class="modal-content">
                    <h4 class="center-align">MISIÓN</h4>
                    <p>Ofrecer a nuestros clientes  productos de calidad, a precios cómodos  que cumplan con sus necesidades y 
                    exigencias, abarcando sus gustos de acuerdo a su estilo de ver y vivir la vida.</p>
                </div>
                <div class="divider"></div>
                <div class="modal-footer">
                    <a href="#!" class="modal-action modal-close btn waves-effect"><i class="material-icons">done</i></a>
                </div>
            </div>

            <!-- Componente Modal para mostrar la Visión -->
            <div id="vision" class="modal">
                <div class="modal-content">
                    <h4 class="center-align">VISIÓN</h4>
                    <p>En el 2023 seremos la empresa de ropa líder en prendas, superando las expectativas de nuestros consumidores 
                    con productos de alta calidad y diseño único, ofreciendo un servicio confiable y a tiempo.</p>
                </div>
                <div class="divider"></div>
                <div class="modal-footer">
                    <a href="#!" class="modal-action modal-close btn waves-effect"><i class="material-icons">done</i></a>
                </div>
            </div>

            <!-- Componente Modal para mostrar los Valores -->
            <div id="valores" class="modal">
                <div class="modal-content center-align">
                    <h4>VALORES</h4>
                    <p>Responsabilidad</p>
                    <p>Honestidad</p>
                    <p>Seguridad</p>
                    <p>Calidad</p>
                </div>
                <div class="divider"></div>
                <div class="modal-footer">
                    <a href="#!" class="modal-action modal-close btn waves-effect"><i class="material-icons">done</i></a>
                </div>
            </div>
        ');
    }
}
?>