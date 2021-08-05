<?php
require_once('../../helpers/database.php');
require_once('../../helpers/validator.php');
require_once('../../models/valoraciones.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $valoracion = new Valoraciones;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'error' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            //Caso para mostrar todas las valoraciones
            case 'readAll':
                if ($result['dataset'] = $valoracion->readAll()) {
                    $result['status'] = 1;
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay productos registrados.';
                    }
                }
                break;
        //Caso para mostrar todas las valoraciones de un producto
        case 'readCommentsOfProduct':
            if ($valoracion->setIdProducto($_POST['id_producto'])) {
                if ($result['dataset'] = $valoracion->readCommentsOfProduct()) {
                    $result['status'] = 1;
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay comentarios para este producto.';
                    }
                }
            } else {
                $result['exception'] = 'Id incorrecto';
            }
            
            break;
        //Caso para obtener la información de una valoracion
        case 'getReview':
            if ($valoracion->setIdValoracion($_POST['id_valoracion'])) {
                if ($result['dataset'] = $valoracion->getReview()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = Database::getException();
                }
            } else {
                $result['exception'] = 'Id incorrecto';
            }
            break;
        //Caso para mostrar una valoracion
        case 'showReview':
            if ($valoracion->setIdValoracion($_POST['idvaloracion'])) {
                if ($valoracion->showReview()) {
                    $result['status'] = 1;
                    $result['message'] = 'Comentario mostrandose correctamente.';
                } else {
                    $result['exception'] = Database::getException();
                }
            } else {
                $result['exception'] = 'Id incorrecto';
            }
            break;
        //Caso para ocultar una valoracion
        case 'hideReview':
            if ($valoracion->setIdValoracion($_POST['idvaloracion'])) {
                if ($valoracion->hideReview()) {
                    $result['status'] = 1;
                    $result['message'] = 'Comentario ocultado correctamente.';
                } else {
                    $result['exception'] = Database::getException();
                }
            } else {
                $result['exception'] = 'Id incorrecto';
            }
            break;
        //Caso para ocultar una valoracion
        case 'deleteReview':
            if ($valoracion->setIdValoracion($_POST['idvaloracion'])) {
                if ($valoracion->deleteReview()) {
                    $result['status'] = 1;
                    $result['message'] = 'Comentario eliminado correctamente.';
                } else {
                    $result['exception'] = Database::getException();
                }
            } else {
                $result['exception'] = 'Id incorrecto';
            }
            break;
        //Caso para realizar busqueda
        case 'search':
            $_POST = $valoracion->validateForm($_POST);
            if ($_POST['search'] != '') {
                if ($result['dataset'] = $valoracion->searchRows($_POST['search'])) {
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
            
        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}
