<?php
/*
*	Clase para manejar la tabla valoraciones de la base de datos. Es clase hija de Validator.
*/
    class Valoraciones extends Validator{

        //Variables
        private $idvaloracion = null;
        private $idcliente = null;
        private $valoracion = null;
        private $fecha = null;
        private $idpuntuacion = null;
        private $idproducto = null;

        //Metodos set
        public function setIdValoracion($value)
        {
            if ($this->validateNaturalNumber($value)) {
                $this->idvaloracion = $value;
                return true;
            } else {
                return false;
            }
        }

        public function setIdCliente($value)
        {
            if ($this->validateNaturalNumber($value)) {
                $this->idcliente = $value;
                return true;
            } else {
                return false;
            }
        }

        public function setValoracion($value)
        {
            if ($this -> validateAlphabetic($value, 1, 200)) {
                $this -> valoracion = $value;
                return true;
            }
            else{
                return false;
            }
        }

        public function setFecha($value)
        {
            if ($this->validateDate($value)) {
                $this->fecha = $value;
                return true;
            } else {
                return false;
            }
        }

        public function setIdPuntuacion($value)
        {
            if ($this->validateNaturalNumber($value)) {
                $this->idpuntuacion = $value;
                return true;
            } else {
                return false;
            }
        }

        public function setIdProducto($value)
        {
            if ($this->validateNaturalNumber($value)) {
                $this->idproducto = $value;
                return true;
            } else {
                return false;
            }
        }

        //Metodos get
        public function getIdValoracion()
        {
            return $this->idvaloracion;
        }

        public function getIdCliente()
        {
            return $this->idcliente;
        }

        public function getValoracion()
        {
            return $this->valoracion;
        }

        public function getFecha()
        {
            return $this->fecha;
        }

        public function getIdPuntuacion()
        {
            return $this->idpuntuacion;
        }

        public function getIdProducto()
        {
            return $this->idproducto;
        }   

        //Consulta para obtener las puntuaciones registradas en la base de datos
        public function readScores()
        {
            $sql = 'SELECT*FROM puntuaciones';
            $params = null;
            return Database::getRows($sql, $params);
        }

        //Consulta para cargar los productos en la pagina de valoraciones
        public function readAll()
        {
            $sql = 'SELECT productos.id_producto, productos.nombre_producto, COUNT(id_valoracion) as cantidadValoraciones FROM valoraciones
                    INNER JOIN productos USING (id_producto)
                    GROUP BY productos.id_producto';
            $params = null;
            return Database::getRows($sql, $params);
        }

        //Consulta para cargar los comentarios de un producto
        public function readCommentsOfProduct()
        {
            $sql = 'SELECT id_valoracion, id_producto, CONCAT(clientes.nombres_cliente,\' \',clientes.apellidos_cliente) as cliente, puntuaciones.puntuacion, fecha, visibilidad FROM valoraciones
                    INNER JOIN clientes USING (id_cliente)
                    INNER JOIN puntuaciones USING (id_puntuacion)
                    WHERE id_producto = ?';
            $params = array($this->idproducto);
            return Database::getRows($sql, $params);
        }

        //Consulta para obtener la informacion de un cliente
        public function readClient()
        {
            $sql = 'SELECT CONCAT(nombres_cliente,\' \',apellidos_cliente) as cliente, dui_cliente 
                    FROM clientes 
                    WHERE id_cliente = ?';
            $params = array($this->idcliente);
            return Database::getRow($sql, $params);
        }

        //Consulta para obtener nombres de los productos
        public function getProducts()
        {
            $sql = 'SELECT id_producto, nombre_producto FROM productos';
            $params = null;
            return Database::getRows($sql, $params);
        }

        //Consulta para obtener valoraciones parametrizadas por cliente y product
        public function getReviewsByProduct()
        {
            $sql = 'SELECT valoracion, fecha, puntuaciones.puntuacion 
                    FROM valoraciones 
                    INNER JOIN puntuaciones USING(id_puntuacion) 
                    WHERE id_cliente = ? AND id_producto = ?';
            $params = array($this->idcliente, $this->idproducto);
            return Database::getRows($sql, $params);
        }

        //Consulta para cargar una valoracion
        public function getReview()
        {
            $sql = 'SELECT valoracion, fecha, puntuaciones.puntuacion, productos.nombre_producto, visibilidad FROM valoraciones
                    INNER JOIN puntuaciones USING (id_puntuacion)
                    INNER JOIN productos USING (id_producto)
                    WHERE id_valoracion = ?';
            $params = array($this->idvaloracion);
            return Database::getRow($sql, $params);
        }

        //Update para mostrar un comentario
        public function showReview()
        {
            $sql = 'UPDATE valoraciones SET visibilidad = 1 WHERE id_valoracion = ?';
            $params = array($this->idvaloracion);
            return Database::executeRow($sql, $params);
        }

        //Update para ocultar un comentario
        public function hideReview()
        {
            $sql = 'UPDATE valoraciones SET visibilidad = 0 WHERE id_valoracion = ?';
            $params = array($this->idvaloracion);
            return Database::executeRow($sql, $params);
        }

        //Eliminar un comentario
        public function deleteReview()
        {
            $sql = 'DELETE FROM valoraciones WHERE id_valoracion = ?';
            $params = array($this->idvaloracion);
            return Database::executeRow($sql, $params);
        }

        //Verificar que el cliente haya comprado el producto posteriormente para poder realizar una valoración
        public function checkReview()
        {
            $sql = 'SELECT*FROM detalle_pedido INNER JOIN pedidos USING (id_pedido) WHERE pedidos.id_cliente = ?';
            $params = array($_SESSION['id_cliente']);
            return Database::getRows($sql, $params);
        }

        //Mostrar valoraciones en el sitio publico
        public function showReviews()
        {
            $sql = 'SELECT CONCAT(clientes.nombres_cliente,\' \',clientes.apellidos_cliente) as cliente, puntuaciones.puntuacion, fecha, valoracion FROM valoraciones 
                    INNER JOIN clientes USING(id_cliente)
                    INNER JOIN puntuaciones USING(id_puntuacion)
                    WHERE id_producto = ? AND visibilidad = 1';
            $params = array($this->idproducto);
            return Database::getRows($sql, $params);
        }

        //Consulta para realizar busquedas
        public function searchRows($value)
        {
            $sql = 'SELECT productos.nombre_producto, COUNT(id_valoracion) as cantidadValoraciones FROM valoraciones
                    INNER JOIN productos USING (id_producto)
                    WHERE productos.nombre_producto ILIKE ?
                    GROUP BY productos.nombre_producto';
            $params = array("%$value%");
            return Database::getRows($sql, $params);
        }

        //Operación sql para insertar datos a la tabla de valoraciones
        public function createRatings()
        {
            $sql = 'INSERT INTO valoraciones(id_cliente, valoracion, fecha, id_puntuacion, id_producto, visibilidad) 
                    VALUES (?,?,current_date,?,?,0)';
            $params = array($_SESSION['id_cliente'], $this->valoracion, $this->idpuntuacion, $this->idproducto);
            return Database::executeRow($sql, $params);
        }

    }
?>