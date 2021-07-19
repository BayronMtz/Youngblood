<?php
require_once('../../helpers/database.php');
require_once('../../helpers/validator.php');
require_once('../../models/pedidos.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $pedido = new Pedidos;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como cliente para realizar las acciones correspondientes.
    if (isset($_SESSION['id_cliente'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un cliente ha iniciado sesión.
        switch ($_GET['action']) {
                //Cargar productos en el carrito
            case 'readOrderInCart':
                if ($data = $pedido->checkOrder()) {
                    if ($pedido->setIdPedido($data['id_pedido'])) {
                        if ($result['dataset'] = $pedido->readOrderInCart()) {
                            $result['status'] = 1;
                            $result['message'] = 'Productos encontrados';
                        } else {
                            $result['exception'] = 'No ha agregado productos al carrito final.';
                        }
                    } else {
                        $result['exception'] = 'Id incorrecto.';
                    }
                } else {
                    $result['exception'] = 'No ha creado ninguna orden para el carrito.';
                }
                break;
                //Agregar productos al carrito
            case 'createDetail':
                //Se verifica si el cliente posee una orden en proceso.
                if ($data = $pedido->checkOrder()) {
                    //Se asignan los valores para hacer la inserción
                    if ($pedido->setProducto($_POST['id_producto'])) {
                        if ($pedido->setCantidad($_POST['cantidad_producto'])) {
                            if ($pedido->setPrecio($_POST['precio_producto'])) {
                                if ($pedido->setIdPedido($data['id_pedido'])) {
                                    if ($pedido->noDuplicatedProducts()) {
                                        $result['exception'] = 'El producto ya ha sido agregado al carrito en esta orden.';
                                        break;
                                    } else {
                                        if ($pedido->updateStock($_POST['nuevo_stock'])) {
                                            if ($pedido->addToOrder()) {
                                                $result['status'] = 1;
                                                $result['message'] = 'Producto agregado al carrito correctamente.';
                                            } else {
                                                $result['exception'] = Database::getException();
                                            }
                                        } else {
                                            $result['exception'] = Database::getException();
                                        }
                                    }
                                    
                                } else {
                                    $result['exception'] = 'Pedido invalido.';
                                }
                            } else {
                                $result['exception'] = 'Precio invalido.';
                            }
                        } else {
                            $result['exception'] = 'Cantidad invalida.';
                        }
                    } else {
                        $result['exception'] = 'Producto inexistente.';
                    }
                } else {
                    //Si el cliente no posee una orden en proceso, entonces se crea una.
                    if ($pedido->createOrder()) {
                        if ($data = $pedido->checkOrder()) {
                            //Se asignan los valores para hacer la inserción
                            if ($pedido->setProducto($_POST['id_producto'])) {
                                if ($pedido->setCantidad($_POST['cantidad_producto'])) {
                                    if ($pedido->setPrecio($_POST['precio_producto'])) {
                                        if ($pedido->setIdPedido($data['id_pedido'])) {
                                            if ($pedido->noDuplicatedProducts()) {
                                                $result['exception'] = 'El producto ya ha sido agregado al carrito en esta orden.';
                                                break;
                                            } else {
                                                if ($pedido->updateStock($_POST['nuevo_stock'])) {
                                                    if ($pedido->addToOrder()) {
                                                        $result['status'] = 1;
                                                        $result['message'] = 'Producto agregado al carrito correctamente.';
                                                    } else {
                                                        $result['exception'] = Database::getException();
                                                    }
                                                } else {
                                                    $result['exception'] = Database::getException();
                                                }
                                            }
                                            
                                        } else {
                                            $result['exception'] = 'Pedido invalido.';
                                        }
                                    } else {
                                        $result['exception'] = 'Precio invalido.';
                                    }
                                } else {
                                    $result['exception'] = 'Cantidad invalida.';
                                }
                            } else {
                                $result['exception'] = 'Producto inexistente.';
                            }
                        } else {
                            $result['exception'] = 'Orden inexistente.';
                        }
                    } else {
                        $result['exception'] = Database::getException();
                    }
                }
                break;
            //Funcion para eliminar un producto del carrito
            case 'deleteFromCart':
                if ($pedido->setIdDetalle($_POST['id_detalle'])) {
                    if ($pedido->setProducto($_POST['id_producto'])) {
                        if ($pedido->deleteFromCart($_POST['cantidad_eliminada'])) {
                            $result['status'] = 1;
                            $result['message'] = 'Producto eliminado del carrito exitosamente.';
                        } else {
                            $result['exception'] = Database::getException();
                        }
                    } else {
                        $result['exception'] = 'Id producto incorrecto';
                    }
                } else {
                    $result['exception'] = 'Id incorrecto';
                }
                break;
            //Funcion para obtener la información de un producto.
            case 'productInfo':
                if ($pedido->setProducto($_POST['id_producto'])) {
                    if ($result['dataset'] = $pedido->productInfo()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } else {
                    $result['exception'] = 'Id incorrecto';
                }
                break;
            //Funcion para actualizar el stock de un producto en el carrito
            case 'updateOnCart':
                if ($pedido->setIdDetalle($_POST['id_detalle'])) {
                    if ($pedido->setProducto($_POST['id_producto'])) {
                        if ($pedido->setCantidad($_POST['cantidad_producto'])) {
                            if ($pedido->updateStock($_POST['cantidad_bodega'])) {
                                if ($pedido->updateOnCart()) {
                                    $result['status'] = 1;
                                    $result['message'] = 'Cantidad actualizada correctamente.';
                                } else {
                                    $result['exception'] = Database::getException();
                                }
                            } else {
                                $result['exception'] = Database::getException();
                            }
                        } else {
                            $result['exception'] = 'Cantidad invalida.';
                        }
                    } else {
                        $result['exception'] = 'Id producto incorrecto';
                    }
                } else {
                    $result['exception'] = 'Id detalle incorrecto';
                }
                break;
            //Caso para finalizar el pedido y mandarlo a administración.
            case 'finishOrder':
                if ($data = $pedido->checkOrder()) {
                    if ($pedido->setIdPedido($data['id_pedido'])) {
                        if ($pedido->finishOrder()) {
                            $result['status'] = 1;
                            $result['message'] = 'Orden finalizada correctamente.';
                        } else {
                            $result['exception'] = Database::getException();
                        }
                    } else {
                        $result['exception'] = 'Id incorrecto';
                    }
                } else {
                    $result['exception'] = 'Orden no encontrada';
                }
                break;
        }
    } else {
        // Se compara la acción a realizar cuando un cliente no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'createDetail':
                $result['exception'] = 'Debe iniciar sesión para agregar el producto al carrito';
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
