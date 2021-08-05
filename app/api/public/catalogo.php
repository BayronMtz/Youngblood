<?php
require_once('../../helpers/database.php');
require_once('../../helpers/validator.php');
require_once('../../models/categorias.php');
require_once('../../models/productos.php');
require_once('../../models/valoraciones.php');


// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancian las clases correspondientes.
    $categoria = new Categorias;
    $producto = new Productos;
    $valoracion = new Valoraciones;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se compara la acción a realizar según la petición del controlador.
    if (isset($_SESSION['id_cliente'])) {
        switch($_GET['action']){
            //Caso para cargar las puntuaciones de la base datos
            case 'readScores':
                if ($result['dataset'] = $valoracion->readScores()) {
                    $result['status'] = 1;
                    $result['message'] = 'Puntuaciones obtenidas correctamente.';
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay puntuaciones registradas.';
                    }
                }

                break;
            //Caso para crear una valoracion
            case 'createRatings':
                $_POST = $valoracion->validateForm($_POST);
                if ($valoracion->checkReview()) {
                    if ($valoracion->setValoracion($_POST['valoracion_producto'])) {
                        if (isset($_POST['cb_puntuacion'])) {
                            if ($valoracion->setIdPuntuacion($_POST['cb_puntuacion'])) {
                                if ($valoracion->setIdProducto($_POST['id_producto2'])) {
                                    if ($valoracion->createRatings()) {
                                        $result['status'] = 1;
                                        $result['message'] = 'Valoración enviada exitosamente.';
                                    } else {
                                        $result['exception'] = Database::getException();
                                    }
                                } else {
                                    $result['exception'] = 'Id de producto incorrecto.';
                                }
                            } else {
                                $result['exception'] = 'Id de puntuacion incorrecto.';
                            }
                        } else {
                            $result['exception'] = 'Por favor, seleccione una puntuación.';
                        }
                    } else {
                        $result['exception'] = 'Por favor, escriba una valoración.';
                    }
                } else {
                    $result['exception'] = 'Usted no ha comprado este producto. No puede realizar valoraciones de productos que usted no ha comprado.';
                }
                
                break;
            //Caso para cargar las valoraciones en el sitio publico
            case 'showReviews':
                if ($valoracion->setIdProducto($_POST['id_producto'])) {
                    if ($result['dataset'] = $valoracion->showReviews()) {
                        $result['status'] = 1;
                    } else {
                        if (Database::getException()) {
                            $result['exception'] = Database::getException();
                        } else {
                            $result['exception'] = 'No hay valoraciones para mostrar.';
                        }  
                    }
                } else {
                    $result['exception'] = 'Id incorrecto';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $categoria->readAll()) {
                    $result['status'] = 1;
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No existen categorías para mostrar';
                    }
                }
                break;
            case 'readProductosCategoria':
                if ($categoria->setId($_POST['id_categoria'])) {
                    if ($result['dataset'] = $categoria->readProductosCategoria()) {
                        $result['status'] = 1;
                    } else {
                        if (Database::getException()) {
                            $result['exception'] = Database::getException();
                        } else {
                            $result['exception'] = 'No existen productos para mostrar';
                        }
                    }
                } else {
                    $result['exception'] = 'Categoría incorrecta';
                }
                break;
            case 'readOne':
                if ($producto->setId($_POST['id_producto'])) {
                    if ($result['dataset'] = $producto->readOne()) {
                        $result['status'] = 1;
                    } else {
                        if (Database::getException()) {
                            $result['exception'] = Database::getException();
                        } else {
                            $result['exception'] = 'Producto inexistente';
                        }
                    }
                } else {
                    $result['exception'] = 'Producto incorrecto';
                }
                break;
                    
        }
    } else {
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $categoria->readAll()) {
                    $result['status'] = 1;
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No existen categorías para mostrar';
                    }
                }
                break;
            case 'readProductosCategoria':
                if ($categoria->setId($_POST['id_categoria'])) {
                    if ($result['dataset'] = $categoria->readProductosCategoria()) {
                        $result['status'] = 1;
                    } else {
                        if (Database::getException()) {
                            $result['exception'] = Database::getException();
                        } else {
                            $result['exception'] = 'No existen productos para mostrar';
                        }
                    }
                } else {
                    $result['exception'] = 'Categoría incorrecta';
                }
                break;
            //Caso para cargar las valoraciones en el sitio publico
            case 'showReviews':
                if ($valoracion->setIdProducto($_POST['id_producto'])) {
                    if ($result['dataset'] = $valoracion->showReviews()) {
                        $result['status'] = 1;
                    } else {
                        if (Database::getException()) {
                            $result['exception'] = Database::getException();
                        } else {
                            $result['exception'] = 'No hay valoraciones para mostrar.';
                        }  
                    }
                } else {
                    $result['exception'] = 'Id incorrecto';
                }
                break;
            case 'readOne':
                if ($producto->setId($_POST['id_producto'])) {
                    if ($result['dataset'] = $producto->readOne()) {
                        $result['status'] = 1;
                    } else {
                        if (Database::getException()) {
                            $result['exception'] = Database::getException();
                        } else {
                            $result['exception'] = 'Producto inexistente';
                        }
                    }
                } else {
                    $result['exception'] = 'Producto incorrecto';
                }
                break;
            
            default:
                $result['exception'] = 'Acción no disponible';
        }
    }
    
    
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
