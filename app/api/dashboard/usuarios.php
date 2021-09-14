<?php
require_once('../../helpers/database.php');
require_once('../../helpers/validator.php');
require_once('../../models/usuarios.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../../../libraries/phpmailer65/src/Exception.php';
require '../../../libraries/phpmailer65/src/PHPMailer.php';
require '../../../libraries/phpmailer65/src/SMTP.php';

//Creando instancia para mandar correo
$mail = new PHPMailer(true);
//To load the Spanish version
$mail->setLanguage('es', '../../../libraries/phpmailer65/language');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $usuario = new Usuarios;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'error' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'logOut':
                unset($_SESSION['id_usuario']);
                $result['message'] = 'Sesión cerrada correctamente.';
                $result['status'] = 1;
                break;
            case 'readProfile':
                if ($result['dataset'] = $usuario->readProfile()) {
                    $result['status'] = 1;
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'Usuario inexistente';
                    }
                }
                break;
                //Registrar dispositivo
             case 'registerDevice':
                if ($usuario->checkDevice()) {
                    $result['status'] = 1;
                    $result['message'] = 'Dispositivo registrado anteriormente.';
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        if ($usuario->registerDevice()) {
                            $result['status'] = 1;
                            $result['message'] = 'Dispositivo registrado.';
                        } else {
                            $result['exception'] = Database::getException();
                        }
                    }
                }
                break;
            //Obtener sesiones
            case 'getDevices':
                if ($result['dataset'] = $usuario->getDevices()) {
                    $result['status'] = 1;
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'Usted no posee sesiónes registradas.';
                    }   
                }
                break;
            //Caso para cargar los intentos fallidos
            case 'readFails':
                if ($result['dataset'] = $usuario->readFails()) {
                    $result['status'] = 1;
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'Usted no posee intentos fallidos.';
                    }
                    
                }
                break;

            //Caso para cargar la cantidad de intentos fallidos
            case 'countFails':
                if ($result['dataset'] = $usuario->countFails()) {
                    $result['status'] = 1;
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'Usted no posee intentos fallidos.';
                    }
                }
                break;
            case 'editProfile':
                $_POST = $usuario->validateForm($_POST);
                if ($usuario->setNombres($_POST['nombres_perfil'])) {
                    if ($usuario->setApellidos($_POST['apellidos_perfil'])) {
                        if ($usuario->setCorreo($_POST['correo_perfil'])) {
                            if ($usuario->setAlias($_POST['alias_perfil'])) {
                                if ($usuario->editProfile()) {
                                    $result['status'] = 1;
                                    $_SESSION['alias_usuario'] = $usuario->getAlias();
                                    $result['message'] = 'Perfil modificado correctamente';
                                } else {
                                    $result['exception'] = Database::getException();
                                }
                            } else {
                                $result['exception'] = 'Alias incorrecto';
                            }
                        } else {
                            $result['exception'] = 'Correo incorrecto';
                        }
                    } else {
                        $result['exception'] = 'Apellidos incorrectos';
                    }
                } else {
                    $result['exception'] = 'Nombres incorrectos';
                }
                break;
            case 'changePassword':
                if ($usuario->setId($_SESSION['id_usuario'])) {
                    $_POST = $usuario->validateForm($_POST);
                    if ($usuario->checkPassword($_POST['clave_actual'])) {
                        if ($_POST['clave_actual'] == $_POST['clave_nueva_1'] ||
                            $_POST['clave_actual'] == $_POST['clave_nueva_2']) {
                                $result['exception'] = 'Su clave no puede ser igual que la anterior.';
                        } else {
                            if ($_POST['clave_nueva_1'] == $_POST['clave_nueva_2']) {
                                if ($usuario->setClave($_POST['clave_nueva_1'])) {
                                    if ($usuario->changePassword()) {
                                        $result['status'] = 1;
                                        $result['message'] = 'Contraseña cambiada correctamente';
                                    } else {
                                        $result['exception'] = Database::getException();
                                    }
                                } else {
                                    $result['exception'] = $usuario->getPasswordError();
                                }
                            } else {
                                $result['exception'] = 'Claves nuevas diferentes';
                            }
                        }
                    } else {
                        $result['exception'] = 'Clave actual incorrecta';
                    }
                } else {
                    $result['exception'] = 'Usuario incorrecto';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $usuario->readAll()) {
                    $result['status'] = 1;
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay usuarios registrados';
                    }
                }
                break;
            case 'search':
                $_POST = $usuario->validateForm($_POST);
                if ($_POST['search'] != '') {
                    if ($result['dataset'] = $usuario->searchRows($_POST['search'])) {
                        $result['status'] = 1;
                        $rows = count($result['dataset']);
                        if ($rows > 1) {
                            $result['message'] = 'Se encontraron ' . $rows . ' coincidencias';
                        } else {
                            $result['message'] = 'Solo existe una coincidencia';
                        }
                    } else {
                        if (Database::getException()) {
                            $result['exception'] = Database::getException();
                        } else {
                            $result['exception'] = 'No hay coincidencias';
                        }
                    }
                } else {
                    $result['exception'] = 'Ingrese un valor para buscar';
                }
                break;
            case 'create':
                $_POST = $usuario->validateForm($_POST);
                if ($usuario->setNombres($_POST['nombres_usuario'])) {
                    if ($usuario->setApellidos($_POST['apellidos_usuario'])) {
                        if ($usuario->setCorreo($_POST['correo_usuario'])) {
                            if ($usuario->setAlias($_POST['alias_usuario'])) {
                                if ($_POST['clave_usuario'] == $_POST['confirmar_clave']) {
                                    if ($usuario->setClave($_POST['clave_usuario'])) {
                                        if ($usuario->createRow()) {
                                            $result['status'] = 1;
                                            $result['message'] = 'Usuario creado correctamente';
                                        } else {
                                            $result['exception'] = Database::getException();
                                        }
                                    } else {
                                        $result['exception'] = $usuario->getPasswordError();
                                    }
                                } else {
                                    $result['exception'] = 'Claves diferentes';
                                }
                            } else {
                                $result['exception'] = 'Alias incorrecto';
                            }
                        } else {
                            $result['exception'] = 'Correo incorrecto';
                        }
                    } else {
                        $result['exception'] = 'Apellidos incorrectos';
                    }
                } else {
                    $result['exception'] = 'Nombres incorrectos';
                }
                break;
            case 'readOne':
                if ($usuario->setId($_POST['id_usuario'])) {
                    if ($result['dataset'] = $usuario->readOne()) {
                        $result['status'] = 1;
                    } else {
                        if (Database::getException()) {
                            $result['exception'] = Database::getException();
                        } else {
                            $result['exception'] = 'Usuario inexistente';
                        }
                    }
                } else {
                    $result['exception'] = 'Usuario incorrecto';
                }
                break;
            case 'update':
                $_POST = $usuario->validateForm($_POST);
                if ($usuario->setId($_POST['id_usuario'])) {
                    if ($usuario->readOne()) {
                        if ($usuario->setNombres($_POST['nombres_usuario'])) {
                            if ($usuario->setApellidos($_POST['apellidos_usuario'])) {
                                if ($usuario->setCorreo($_POST['correo_usuario'])) {
                                    if ($usuario->updateRow()) {
                                        $result['status'] = 1;
                                        $result['message'] = 'Usuario modificado correctamente';
                                    } else {
                                        $result['exception'] = Database::getException();
                                    }
                                } else {
                                    $result['exception'] = 'Correo incorrecto';
                                }
                            } else {
                                $result['exception'] = 'Apellidos incorrectos';
                            }
                        } else {
                            $result['exception'] = 'Nombres incorrectos';
                        }
                    } else {
                        $result['exception'] = 'Usuario inexistente';
                    }
                } else {
                    $result['exception'] = 'Usuario incorrecto';
                }
                break;
            case 'delete':
                if ($_POST['id_usuario'] != $_SESSION['id_usuario']) {
                    if ($usuario->setId($_POST['id_usuario'])) {
                        if ($usuario->readOne()) {
                            if ($usuario->deleteRow()) {
                                $result['status'] = 1;
                                $result['message'] = 'Usuario eliminado correctamente';
                            } else {
                                $result['exception'] = Database::getException();
                            }
                        } else {
                            $result['exception'] = 'Usuario inexistente';
                        }
                    } else {
                        $result['exception'] = 'Usuario incorrecto';
                    }
                } else {
                    $result['exception'] = 'No se puede eliminar a sí mismo';
                }
                break;
            case 'active':
                if ($_POST['id_usuario'] != $_SESSION['id_usuario']) {
                    if ($usuario->setId($_POST['id_usuario'])) {
                        if ($usuario->readOne()) {
                            if ($usuario->actualizarEstado(1)) {
                                $result['status'] = 1;
                                $result['message'] = 'Usuario desbloqueado correctamente';
                            } else {
                                $result['exception'] = Database::getException();
                            }
                        } else {
                            $result['exception'] = 'Usuario inexistente';
                        }
                    } else {
                        $result['exception'] = 'Usuario incorrecto';
                    }
                } else {
                    $result['exception'] = 'No se puede eliminar a sí mismo';
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el administrador no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existe al menos un usuario registrado';
                } else {
                    if (Database::getException()) {
                        $result['error'] = 1;
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No existen usuarios registrados';
                    }
                }
                break;
            case 'register':
                $_POST = $usuario->validateForm($_POST);
                if ($usuario->setNombres($_POST['nombres'])) {
                    if ($usuario->setApellidos($_POST['apellidos'])) {
                        if ($usuario->setCorreo($_POST['correo'])) {
                            if ($usuario->setAlias($_POST['alias'])) {
                                if ($_POST['clave1'] == $_POST['clave2']) {
                                    if ($usuario->setClave($_POST['clave1'])) {
                                        if ($usuario->createRow()) {
                                            $result['status'] = 1;
                                            $result['message'] = 'Usuario registrado correctamente';
                                        } else {
                                            $result['exception'] = Database::getException();
                                        }
                                    } else {
                                        $result['exception'] = $usuario->getPasswordError();
                                    }
                                } else {
                                    $result['exception'] = 'Claves diferentes';
                                }
                            } else {
                                $result['exception'] = 'Alias incorrecto';
                            }
                        } else {
                            $result['exception'] = 'Correo incorrecto';
                        }
                    } else {
                        $result['exception'] = 'Apellidos incorrectos';
                    }
                } else {
                    $result['exception'] = 'Nombres incorrectos';
                }
                break;
            case 'logIn':
                $_POST = $usuario->validateForm($_POST);
                if ($usuario->checkUser($_POST['alias'])) {
                    if($usuario->verificarEstado()) {
                        if ($usuario->checkPassword($_POST['clave'])) {
                            if($usuario->verificar90dias()) {
                                if($usuario->actualizarIntentos(0)){
                                    $result['status'] = 1;
                                    $result['message'] = 'Autenticación correcta';
                                    $_SESSION['id_usuario'] = $usuario->getId();
                                    $_SESSION['alias_usuario'] = $usuario->getAlias();
                                }
                            } else {
                                $result['error'] = 1;
                                $result['exception'] = 'Debes actualizar tu contraseña';
                                $_SESSION['id_usuario_tmp'] = $usuario->getId();
                                unset($_SESSION['id_usuario']);
                            }
                        } else {
                            $datos = $usuario->verificarIntentos();
                            if($datos['intentos'] < 3){
                                if($usuario->actualizarIntentos($datos['intentos'] + 1)) {
                                    if($usuario->accionUsuario('Intento fallido N°'.$datos['intentos'] + 1.)) {
                                        $result['exception'] = 'La contraseña es incorrecta';
                                    }
                                }
                            } else {
                                if($usuario->actualizarEstado(0)){
                                    if($usuario->accionUsuario('Se ha bloqueado el usuario')) {
                                        $result['exception'] = 'Se ha bloqueado el usuario por intentos fallidos';
                                    } 
                                }
                            }
                        }
                    } else {
                        $result['exception'] = 'El usuario está bloqueado.';
                    }
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'Alias incorrecto';
                    }
                }
                break;
            case 'changePassword':
                if ($usuario->setId($_SESSION['id_usuario_tmp'])) {
                    $_POST = $usuario->validateForm($_POST);
                    if ($usuario->checkPassword($_POST['clave_actual'])) {
                        if ($_POST['clave_actual'] == $_POST['clave_nueva_1'] ||
                            $_POST['clave_actual'] == $_POST['clave_nueva_2']) {
                                $result['exception'] = 'Su clave no puede ser igual que la anterior.';
                        } else {
                            if ($_POST['clave_nueva_1'] == $_POST['clave_nueva_2']) {
                                if ($usuario->setClave($_POST['clave_nueva_1'])) {
                                    if ($usuario->changePasswordOut()) {
                                        $result['status'] = 1;
                                        $result['message'] = 'Contraseña cambiada correctamente';
                                        unset($_SESSION['id_usuario_tmp']);
                                        $_SESSION['id_usuario'] = $usuario->getId();
                                        $usuario->actualizarFecha();
                                    } else {
                                        $result['exception'] = Database::getException();
                                    }
                                } else {
                                    $result['exception'] = $usuario->getPasswordError();
                                }
                            } else {
                                $result['exception'] = 'Claves nuevas diferentes';
                            }
                        }
                    } else {
                        $result['exception'] = 'Clave actual incorrecta';
                    }
                } else {
                    $result['exception'] = 'Usuario incorrecto';
                }
                break;
            case 'validateEmail':
                $_POST = $usuario->validateForm($_POST);
                if ($usuario->setCorreo($_POST['txtCorreo'])) {
                    if ($correo = $usuario->checkEmail()) {
                        if ($correo['correo_usuario'] == $_POST['txtCorreo']) {
                            $_SESSION['id_usuario_tmp'] = $correo['id_usuario'];
                            $_SESSION['correo_usuario'] = $correo['correo_usuario'];
                            $result['status'] = 1;
                            $result['message'] = 'Correo verificado.';
                        } else {
                            $result['exception'] = 'El correo electrónico ingresado no coincide con su cuenta.';
                        }
                    } else {
                        if (Database::getException()) {
                            $result['exception'] = Database::getException();
                        } else {
                            $result['exception'] = 'No hay correo';
                        }
                    }
                } else {
                    $result['exception'] = 'Id pendiente de ingresar.';
                }
                break;
            case 'sendEmail':
                $_SESSION['codigo_email'] = random_int(100, 999999);
                try {
                        
                    //Ajustes del servidor
                    $mail->SMTPDebug = 0;                   
                    $mail->isSMTP();                                            
                    $mail->Host       = 'smtp.gmail.com';                     
                    $mail->SMTPAuth   = true;                                   
                    $mail->Username   = 'polusmarket2021@gmail.com';                     
                    $mail->Password   = 'polus123';                               
                    $mail->SMTPSecure = 'tls';            
                    $mail->Port       = 587;                                    
                
                    //Receptores
                    $mail->setFrom('polusmarket2021@gmail.com', 'Polus Support');
                    $mail->addAddress($_SESSION['correo_usuario']);    
                
                    //Contenido
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Codigo de Verificación';
                    $mail->Body    = 'Tu código de verificación es: <b>' . $_SESSION['codigo_email'] . '</b>.';
                    $mail->AltBody = 'Tu código de verificación es: ' . $_SESSION['codigo_email'] . '.';
                
                    if($mail->send()){
                        $result['status'] = 1;
                        $result['message'] = 'Correo verificado correctamente';
                    }
                } catch (Exception $e) {
                    $result['exception'] = $mail->ErrorInfo;
                }
                break;
            case 'validateCode':
                $_POST = $usuario->validateForm($_POST);
                if ($_SESSION['codigo_email'] == $_POST['txtCodigo']) {
                    unset($_SESSION['codigo_email']);
                    $result['status'] = 1;
                    $result['message'] = 'Código verificado correctamente.';
                } else {
                    $result['exception'] = 'El código que usted ha ingresado es invalido.';
                }
                
                break;
            case 'changePasswordOut':
                if ($usuario->setId($_SESSION['id_usuario_tmp'])) {
                    $_POST = $usuario->validateForm($_POST);
                    if ($_POST['clave_nueva_1'] == $_POST['clave_nueva_2']) {
                        if ($usuario->setClave($_POST['clave_nueva_1'])) {
                            if ($usuario->changePasswordOut()) {
                                $result['status'] = 1;
                                $result['message'] = 'Contraseña cambiada correctamente';
                                unset($_SESSION['id_usuario_tmp']);
                                $usuario->actualizarFecha();
                            } else {
                                $result['exception'] = Database::getException();
                            }
                        } else {
                            $result['exception'] = $usuario->getPasswordError();
                        }
                    } else {
                        $result['exception'] = 'Claves nuevas diferentes';
                    }
                } else {
                    $result['exception'] = 'Usuario incorrecto';
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible fuera de la sesión';
        }
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
