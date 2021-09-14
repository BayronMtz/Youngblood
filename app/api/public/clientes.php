<?php
require_once('../../helpers/database.php');
require_once('../../helpers/validator.php');
require_once('../../models/clientes.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $cliente = new Clientes;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'recaptcha' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como cliente para realizar las acciones correspondientes.
    if (isset($_SESSION['id_cliente'])) {
        // Se compara la acción a realizar cuando un cliente ha iniciado sesión.
        switch ($_GET['action']) {
            case 'logOut':
                unset($_SESSION['id_cliente']);
                $result['message'] = 'Sesión cerrada correctamente.';
                $result['status'] = 1;
                break;
            case 'readProfile':
                if ($result['dataset'] = $cliente->readProfile()) {
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
                if ($cliente->checkDevice()) {
                    $result['status'] = 1;
                    $result['message'] = 'Dispositivo registrado anteriormente.';
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        if ($cliente->registerDevice()) {
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
                if ($result['dataset'] = $cliente->getDevices()) {
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
                if ($result['dataset'] = $cliente->readFails()) {
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
                if ($result['dataset'] = $cliente->countFails()) {
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
                $_POST = $cliente->validateForm($_POST);
                if ($cliente->setNombres($_POST['nombres_perfil'])) {
                    if ($cliente->setApellidos($_POST['apellidos_perfil'])) {
                        if ($cliente->setCorreo($_POST['correo_perfil'])) {
                            if ($cliente->setAlias($_POST['alias_perfil'])) {
                                if ($cliente->editProfile2()) {
                                    $result['status'] = 1;
                                    $_SESSION['alias_usuario'] = $cliente->getAlias();
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
                if ($cliente->setId($_SESSION['id_cliente'])) {
                    $_POST = $cliente->validateForm($_POST);
                    if ($cliente->checkPassword($_POST['clave_actual'])) {
                        if ($_POST['clave_actual'] == $_POST['clave_nueva_1'] ||
                            $_POST['clave_actual'] == $_POST['clave_nueva_2']) {
                                $result['exception'] = 'Su clave no puede ser igual que la anterior.';
                        } else {
                            if ($_POST['clave_nueva_1'] == $_POST['clave_nueva_2']) {
                                if ($cliente->setClave($_POST['clave_nueva_1'])) {
                                    if ($cliente->changePassword()) {
                                        $result['status'] = 1;
                                        $result['message'] = 'Contraseña cambiada correctamente';
                                    } else {
                                        $result['exception'] = Database::getException();
                                    }
                                } else {
                                    $result['exception'] = $cliente->getPasswordError();
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
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el cliente no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'register':
                $_POST = $cliente->validateForm($_POST);
                // Se sanea el valor del token para evitar datos maliciosos.
                $token = filter_input(INPUT_POST, 'g-recaptcha-response', FILTER_SANITIZE_STRING);
                if ($token) {
                    $secretKey = '6LdBzLQUAAAAAL6oP4xpgMao-SmEkmRCpoLBLri-';
                    $ip = $_SERVER['REMOTE_ADDR'];

                    $data = array(
                        'secret' => $secretKey,
                        'response' => $token,
                        'remoteip' => $ip
                    );

                    $options = array(
                        'http' => array(
                            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                            'method'  => 'POST',
                            'content' => http_build_query($data)
                        ),
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false
                        )
                    );

                    $url = 'https://www.google.com/recaptcha/api/siteverify';
                    $context  = stream_context_create($options);
                    $response = file_get_contents($url, false, $context);
                    $captcha = json_decode($response, true);

                    if ($captcha['success']) {
                        if ($cliente->setNombres($_POST['nombres_cliente'])) {
                            if ($cliente->setApellidos($_POST['apellidos_cliente'])) {
                                if ($cliente->setCorreo($_POST['correo_cliente'])) {
                                    if ($cliente->setDireccion($_POST['direccion_cliente'])) {
                                        if ($cliente->setDUI($_POST['dui_cliente'])) {
                                            if ($cliente->setNacimiento($_POST['nacimiento_cliente'])) {
                                                if ($cliente->setUsuario($_POST['alias_usuario'])) {
                                                    if ($cliente->setTelefono($_POST['telefono_cliente'])) {
                                                        if ($_POST['clave_cliente'] == $_POST['confirmar_clave']) {
                                                            if ($cliente->setClave($_POST['clave_cliente'])) {
                                                                if ($cliente->createRow()) {
                                                                    $result['status'] = 1;
                                                                    $result['message'] = 'Cliente registrado correctamente';
                                                                } else {
                                                                    $result['exception'] = Database::getException();
                                                                }
                                                            } else {
                                                                $result['exception'] = $cliente->getPasswordError();
                                                            }
                                                        } else {
                                                            $result['exception'] = 'Claves diferentes';
                                                        }
                                                    } else {
                                                        $result['exception'] = 'Teléfono incorrecto';
                                                    }
                                                } else {
                                                    $result['exception'] = 'Alias incorrecto.';
                                                }
                                            } else {
                                                $result['exception'] = 'Fecha de nacimiento incorrecta';
                                            }
                                        } else {
                                            $result['exception'] = 'DUI incorrecto';
                                        }
                                    } else {
                                        $result['exception'] = 'Dirección incorrecta';
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
                        $result['recaptcha'] = 1;
                        $result['exception'] = 'No eres un humano';
                    }
                } else {
                    $result['exception'] = 'Ocurrió un problema al cargar el reCAPTCHA';
                }
                break;
            case 'logIn':
                $_POST = $cliente->validateForm($_POST);
                if ($cliente->checkUser($_POST['usuario'])) {
                    if ($cliente->getEstado()) {
                        if ($cliente->checkPassword($_POST['clave'])) {
                            if($cliente->verificar90dias()) {
                                if($cliente->actualizarIntentos(0)){
                                    $_SESSION['id_cliente'] = $cliente->getId();
                                    $_SESSION['correo_cliente'] = $cliente->getCorreo();
                                    $_SESSION['alias_cliente'] = $cliente->getUsuario();
                                    $result['status'] = 1;
                                    $result['message'] = 'Autenticación correcta';
                                } 
                            } else {
                                $result['error'] = 1;
                                $result['exception'] = 'Debes actualizar tu contraseña';
                                $_SESSION['id_cliente_tmp'] = $cliente->getId();
                                unset($_SESSION['id_cliente']);
                            }
                        } else {
                            $datos = $cliente->verificarIntentos();
                            if($datos['intentos'] < 3){
                                if($cliente->actualizarIntentos($datos['intentos'] + 1)) {
                                    if($cliente->accionCliente('Intento fallido N°'.$datos['intentos'] + 1.)) {
                                        $result['exception'] = 'La contraseña es incorrecta';
                                    }
                                }
                            } else {
                                if($cliente->actualizarEstado(0)){
                                    if($cliente->accionCliente('Se ha bloqueado el usuario del cliente')) {
                                        $result['exception'] = 'Se ha bloqueado el usuario por intentos fallidos';
                                    } 
                                    
                                } else {
                                    $result['exception'] = 'aqui';
                                }
                            }
                        }
                    } else {
                        $result['exception'] = 'La cuenta ha sido desactivada';
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
                if ($cliente->setId($_SESSION['id_cliente_tmp'])) {
                    $_POST = $cliente->validateForm($_POST);
                    if ($cliente->checkPassword($_POST['clave_actual'])) {
                        if ($_POST['clave_actual'] == $_POST['clave_nueva_1'] ||
                            $_POST['clave_actual'] == $_POST['clave_nueva_2']) {
                                $result['exception'] = 'Su clave no puede ser igual que la anterior.';
                        } else {
                            if ($_POST['clave_nueva_1'] == $_POST['clave_nueva_2']) {
                                if ($cliente->setClave($_POST['clave_nueva_1'])) {
                                    if ($cliente->changePasswordOut()) {
                                        $result['status'] = 1;
                                        $result['message'] = 'Contraseña cambiada correctamente';
                                        unset($_SESSION['id_cliente_tmp']);
                                        $_SESSION['id_cliente'] = $cliente->getId();
                                        $cliente->actualizarFecha();
                                    } else {
                                        $result['exception'] = Database::getException();
                                    }
                                } else {
                                    $result['exception'] = $cliente->getPasswordError();
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
