<?php
require_once('../../helpers/database.php');
require_once('../../helpers/validator.php');
require_once('../../models/pedidos.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $pedidos = new Pedidos;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'error' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            //Caso para leer pedidos en el dashboard
            case 'readAll':
                if ($result['dataset'] = $pedidos->readAll()) {
                    $result['status'] = 1;
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay clientes registrados';
                    }
                }
                break;
            //Caso para ver productos de un pedido en el dashboard
            case 'readProductsOfOrder':
                if ($pedidos->setIdPedido($_POST['id_pedido'])) {
                    if ($result['dataset'] = $pedidos->readProductsOfOrder()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } else {
                    $result['exception'] = 'Id incorrecto';
                }
                break;
            //Caso para reportar un pedido como entregado
            case 'giveOrder':
                if ($pedidos->setIdPedido($_POST['id_pedido'])) {
                    if ($pedidos->giveOrder()) {
                        $result['status'] = 1;
                        $result['message'] = 'Orden entregada correctamente.';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } else {
                    $result['exception'] = 'Id incorrecto';
                }

                break;
            //Caso para realizar busquedas
            case 'search':
                $_POST = $pedidos->validateForm($_POST);
                if ($_POST['search'] != '') {
                    if ($result['dataset'] = $pedidos->searchRows($_POST['search'])) {
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
