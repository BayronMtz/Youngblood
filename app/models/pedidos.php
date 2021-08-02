<?php
/*
*	Clase para manejar las tablas pedidos y detalle_pedido de la base de datos. Es clase hija de Validator.
*/
class Pedidos extends Validator
{
    // Declaración de atributos (propiedades).
    private $id_pedido = null;
    private $id_detalle = null;
    private $cliente = null;
    private $producto = null;
    private $cantidad = null;
    private $precio = null;
    private $estado = null; // Valor por defecto en la base de datos: 0
    /*
    *   ESTADOS PARA UN PEDIDO
    *   0: Pendiente. Es cuando el pedido esta en proceso por parte del cliente y se puede modificar el detalle.
    *   1: Finalizado. Es cuando el cliente finaliza el pedido y ya no es posible modificar el detalle.
    *   2: Entregado. Es cuando la tienda ha entregado el pedido al cliente.
    *   3: Anulado. Es cuando el cliente se arrepiente de haber realizado el pedido.
    */

    /*
    *   Métodos para asignar valores a los atributos.
    */
    public function setIdPedido($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdDetalle($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_detalle = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCliente($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setProducto($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCantidad($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->cantidad = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPrecio($value)
    {
        if ($this->validateMoney($value)) {
            $this->precio = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstado($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->estado = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getIdPedido()
    {
        return $this->id_pedido;
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    //Metodo para cargar los pedidos de un cliente
    public function readAllOnPublic()
    {
        $sql = 'SELECT*FROM pedidos 
                WHERE id_cliente = ? 
                AND estado_pedido NOT IN (0)';
        $params = array($_SESSION['id_cliente']);
        return Database::getRows($sql, $params);
    }

    //Metodo para cargar productos de un pedido
    public function readProductsOfOrder()
    {
        $sql = 'SELECT productos.nombre_producto, cantidad_producto, (cantidad_producto*precio) as subtotal, precio
                FROM detalle_pedido 
                INNER JOIN productos USING (id_producto) 
                WHERE id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::getRows($sql, $params);
    }

    //Metodo para cambiar el estado de un pedido a anulado por parte del cliente
    public function cancelOrder()
    {
        $sql = 'UPDATE pedidos SET estado_pedido = 3 WHERE id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::executeRow($sql, $params);
    }

    //Metodo para cargar los pedidos en el dashboard
    public function readAll()
    {
        $sql = 'SELECT CONCAT(clientes.nombres_cliente,\' \',clientes.apellidos_cliente) as cliente, estado_pedido, fecha_pedido 
                FROM pedidos
                INNER JOIN clientes ON pedidos.id_cliente = clientes.id_cliente
                WHERE estado_pedido NOT IN (0)';
        $params = null;
        return Database::getRows($sql, $params);
    }
    //Metodo para cargar los productos del carrito.
    public function readOrderInCart()
    {
        $sql = 'SELECT id_detalle, productos.nombre_producto, productos.id_producto, precio, cantidad_producto, 
                (cantidad_producto*precio_producto) as subtotal 
                FROM detalle_pedido 
                INNER JOIN productos ON detalle_pedido.id_producto = productos.id_producto 
                WHERE id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::getRows($sql, $params);
    }

    //Metodo para verificar si el cliente posee una orden en proceso.
    public function checkOrder()
    {
        $sql = 'SELECT*FROM pedidos 
                WHERE id_cliente = ? 
                AND estado_pedido = 0';
        $params = array($_SESSION['id_cliente']);
        return Database::getRow($sql, $params);
    }

    //Metodo para crear el pedido en proceso
    public function createOrder()
    {
        $sql = 'INSERT INTO pedidos(id_cliente, estado_pedido, fecha_pedido) 
                VALUES (?,0,current_date)';
        $params = array($_SESSION['id_cliente']);
        return Database::executeRow($sql, $params);
    }

    //Metodo para agregar productos al carrito.
    public function addToOrder()
    {
        $sql = 'INSERT INTO detalle_pedido(id_producto, cantidad_producto, precio, id_pedido) 
                VALUES (?,?,?,?)';
        $params = array($this->producto, $this->cantidad, $this->precio, $this->id_pedido);
        return Database::executeRow($sql, $params);
    }

    //Metodo para evitar detalles duplicados.
    public function noDuplicatedProducts()
    {
        $sql = 'SELECT*FROM detalle_pedido WHERE id_producto = ? AND id_pedido = ?';
        $params = array($this->producto, $this->id_pedido);
        return Database::getRow($sql, $params);
    }

    //Metodo para restar el stock luego de agregar al carrito
    public function updateStock($nueva_cantidad)
    {
        $sql = 'UPDATE productos SET cantidad = ? WHERE id_producto = ?';
        $params = array($nueva_cantidad, $this->producto);
        return Database::executeRow($sql, $params);
    }

    //Metodo para eliminar productos del carrito
    public function deleteFromCart($cantidad_eliminada)
    {
        $this->restoreStock($cantidad_eliminada);
        $sql = 'DELETE FROM detalle_pedido WHERE id_detalle = ?';
        $params = array($this->id_detalle);
        return Database::executeRow($sql, $params);
    }

    //Metodo para actualizar stock despues de eliminar del carrito
    public function restoreStock($cantidad_eliminada)
    {
        $sql = 'UPDATE productos SET cantidad = cantidad + ? WHERE id_producto = ?';
        $params = array($cantidad_eliminada, $this->producto);
        return Database::executeRow($sql, $params);
    }

    //Metodo para obtener la información de un producto
    public function productInfo()
    {
        $sql = 'SELECT*FROM productos WHERE id_producto = ?';
        $params = array($this->producto);
        return Database::getRow($sql, $params);
    }

    //Metodo para actualizar la cantidad de un producto en un pedido
    public function updateOnCart()
    {
        $sql = 'UPDATE detalle_pedido SET cantidad_producto = ? WHERE id_detalle = ?';
        $params = array($this->cantidad, $this->id_detalle);
        return Database::executeRow($sql, $params);
    }

    //Metodo para obtener el total de los productos
    public function getTotalPrice()
    {
        $sql = 'SELECT SUM(precio*cantidad_producto) as totalPedido 
                FROM detalle_pedido 
                WHERE id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::getRow($sql, $params);
    }

    //Metodo para cambiar el estado del pedido a finalizado.
    public function finishOrder()
    {
        $sql = 'UPDATE pedidos SET estado_pedido = 1 WHERE id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::executeRow($sql, $params);
    }


    
}
