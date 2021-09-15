<?php
require_once('../../helpers/database.php');
require_once('../../helpers/validator.php');
require_once('../../models/clientes.php');

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
    $cliente = new Clientes;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'recaptcha' => 0,'auth' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como cliente para realizar las acciones correspondientes.
    if (isset($_SESSION['id_cliente'])) {
        // Se compara la acción a realizar cuando un cliente ha iniciado sesión.
        switch ($_GET['action']) {
            case 'logOut':
                unset($_SESSION['id_cliente']);
                unset($_SESSION['alias_usuario']);
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
            //Caso para actualizar la preferencia del usuario
            case 'updateAuth':
                if ($cliente->updateAuth($_POST['checkboxValue'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Actualizado correctamente.';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //Caso para capturar la preferencia del usuario
            case 'checkAuth':
                if ($cliente->setId($_SESSION['id_cliente'])) {
                    if ($result['dataset'] = $cliente->checkAuth()) {
                        $result['status'] = 1;
                    } else {
                        if (Database::getException()) {
                            $result['exception'] = Database::getException();
                        } else {
                            $result['exception'] = 'Usted no posee ninguna preferencia.';
                        }
                    }
                } else {
                    $result['exception'] = 'Id incorrecto.';
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
            case 'sendCode':
                $_SESSION['codigo'] = random_int(100, 999999);
                try {
                        
                    //Ajustes del servidor
                    $mail->SMTPDebug = 0;                   
                    $mail->isSMTP();                                            
                    $mail->Host       = 'smtp.gmail.com';                     
                    $mail->SMTPAuth   = true;                                   
                    $mail->Username   = '20190145@ricaldone.edu.sv';                     
                    $mail->Password   = '42861798';                               
                    $mail->SMTPSecure = 'tls';            
                    $mail->Port       = 587;                                    
                
                    //Receptores
                    $mail->setFrom('20190145@ricaldone.edu.sv', 'Youngblood Support');
                    $mail->addAddress($_SESSION['correo_cliente']);    
                
                    //Contenido
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Codigo de Verificación';
                    $mail->Body    = 'Tu código de verificación es: <b>' . $_SESSION['codigo'] . '</b>.';
                    $mail->AltBody = 'Tu código de verificación es: ' . $_SESSION['codigo'] . '.';
                
                    if($mail->send()){
                        $result['status'] = 1;
                        $result['message'] = 'Correo enviado correctamente';
                    }
                } catch (Exception $e) {
                    $result['exception'] = $mail->ErrorInfo;
                }
                break;
            case 'checkCode':
                $_POST = $cliente->validateForm($_POST);
                if ($_POST['codigo'] == $_SESSION['codigo']) {
                    unset($_SESSION['codigo']);
                    $_SESSION['id_cliente'] = $_SESSION['id_cliente_temp'];
                    unset($_SESSION['id_cliente_temp']);
                    $result['status'] = 1;
                    $result['message'] = 'Sesión iniciada correctamente.';
                } else {
                    $result['exception'] = 'El código ingresado es incorrecto.';
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
                                    $_SESSION['alias_usuario'] = $cliente->getUsuario();
                                    //Se captura si el usuario tiene activada la verificacion en dos pasos
                                    if ($data = $cliente->checkAuth()) {
                                        if ($data['dobleverificacion'] == 'si') {
                                            $_SESSION['id_cliente_temp'] = $cliente->getId();
                                            unset($_SESSION['id_cliente']);
                                            $result['status'] = 1;
                                            $result['auth'] = 1;
                                            $result['message'] = 'Usted posee la verificacion en dos pasos activada.';
                                        } else {
                                            $result['status'] = 1;
                                            $result['message'] = 'Autenticación correcta';
                                        }
                                    } else {
                                       if (Database::getException()) {
                                           $result['exception'] = Database::getException();
                                       } else {
                                           $result['exception'] = 'Por alguna razón usted no posee ninguna preferencia.';
                                       }
                                    }
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
            case 'validateEmail':
                $_POST = $cliente->validateForm($_POST);
                if ($cliente->setCorreo($_POST['txtCorreo'])) {
                    if ($correo = $cliente->checkEmail()) {
                        if ($correo['correo_cliente'] == $_POST['txtCorreo']) {
                            $_SESSION['id_cliente_tmp'] = $correo['id_cliente'];
                            $_SESSION['correo_cliente'] = $correo['correo_cliente'];
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
                    $mail->Username   = '20190145@ricaldone.edu.sv';                     
                    $mail->Password   = '42861798';                               
                    $mail->SMTPSecure = 'tls';            
                    $mail->Port       = 587;                                    
                
                    //Receptores
                    $mail->setFrom('20190145@ricaldone.edu.sv', 'Youngblood Support');
                    $mail->addAddress($_SESSION['correo_cliente']);    
                
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
                $_POST = $cliente->validateForm($_POST);
                if ($_SESSION['codigo_email'] == $_POST['txtCodigo']) {
                    unset($_SESSION['codigo_email']);
                    $result['status'] = 1;
                    $result['message'] = 'Código verificado correctamente.';
                } else {
                    $result['exception'] = 'El código que usted ha ingresado es invalido.';
                }
                
                break;
            case 'changePasswordOut':
                if ($cliente->setId($_SESSION['id_cliente_tmp'])) {
                    $_POST = $cliente->validateForm($_POST);
                    if ($_POST['clave_nueva_1'] == $_POST['clave_nueva_2']) {
                        if ($cliente->setClave($_POST['clave_nueva_1'])) {
                            if ($cliente->changePasswordOut()) {
                                $result['status'] = 1;
                                $result['message'] = 'Contraseña cambiada correctamente';
                                unset($_SESSION['id_cliente_tmp']);
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
