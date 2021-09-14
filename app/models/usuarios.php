<?php
/*
*	Clase para manejar la tabla usuarios de la base de datos. Es clase hija de Validator.
*/
class Usuarios extends Validator
{
    // Declaración de atributos (propiedades).
    private $id = null;
    private $nombres = null;
    private $apellidos = null;
    private $correo = null;
    private $alias = null;
    private $clave = null;
    private $estado = null;

    /*
    *   Métodos para asignar valores a los atributos.
    */
    public function setId($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id = $value;
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

    public function setNombres($value)
    {
        if ($this->validateAlphabetic($value, 1, 50)) {
            $this->nombres = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setApellidos($value)
    {
        if ($this->validateAlphabetic($value, 1, 50)) {
            $this->apellidos = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCorreo($value)
    {
        if ($this->validateEmail($value)) {
            $this->correo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setAlias($value)
    {
        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->alias = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setClave($value)
    {
        if ($this->validatePassword($value)) {
            $this->clave = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getId()
    {
        return $this->id;
    }

    public function getNombres()
    {
        return $this->nombres;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function getClave()
    {
        return $this->clave;
    }

    public function getEstado()
    {
        return $this->estado;
    }
    /*
    *   Métodos para gestionar la cuenta del usuario.
    */
    public function checkUser($alias)
    {
        $sql = 'SELECT id_usuario,estado_usuario FROM usuarios WHERE alias_usuario = ?';
        $params = array($alias);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_usuario'];
            $this->alias = $alias;
            $this->estado = $data['estado_usuario'];
            return true;
        } else {
            return false;
        }
    }

    //Carga los intentos fallidos
    public function readFails()
    {
        $sql = 'SELECT*FROM bitacora WHERE id_usuario = ?';
        $params = array($_SESSION['id_usuario']);
        return Database::getRows($sql, $params);
    }

    //Cuenta los intentos fallidos
    public function countFails()
    {
        $sql = 'SELECT COUNT(id_bitacora) as intentos FROM bitacora WHERE id_usuario = ?';
        $params = array($_SESSION['id_usuario']);
        return Database::getRow($sql, $params);
    }

    public function checkPassword($password)
    {
        $sql = 'SELECT clave_usuario FROM usuarios WHERE id_usuario = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        if (password_verify($password, $data['clave_usuario'])) {
            return true;
        } else {
            return false;
        }
    }

    public function changePassword()
    {
        $hash = password_hash($this->clave, PASSWORD_DEFAULT);
        $sql = 'UPDATE usuarios SET clave_usuario = ? WHERE id_usuario = ?';
        $params = array($hash, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    public function readProfile()
    {
        $sql = 'SELECT id_usuario, nombres_usuario, apellidos_usuario, correo_usuario, alias_usuario
                FROM usuarios
                WHERE id_usuario = ?';
        $params = array($_SESSION['id_usuario']);
        return Database::getRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE usuarios
                SET nombres_usuario = ?, apellidos_usuario = ?, correo_usuario = ?, alias_usuario = ?
                WHERE id_usuario = ?';
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->alias, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    //Registrar dispositivo
    public function registerDevice()
    {
        $sql = 'INSERT INTO dispositivos_usuario(dispositivo, fecha, hora, id_usuario) VALUES (?,current_date,current_time,?)';
        $params = array(php_uname(), $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    //Verificar si el dispositivo ya existe
    public function checkDevice()
    {
        $sql = 'SELECT*FROM dispositivos_usuario WHERE dispositivo = ? AND id_usuario = ?';
        $params = array(php_uname(), $_SESSION['id_usuario']);
        return Database::getRow($sql, $params);
    }

    //Obtener las sesiones de un dispositivo
    public function getDevices()
    {
        $sql = 'SELECT*FROM dispositivos_usuario WHERE id_usuario = ?';
        $params = array($_SESSION['id_usuario']);
        return Database::getRows($sql, $params);
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_usuario, nombres_usuario, apellidos_usuario, correo_usuario, alias_usuario
                FROM usuarios
                WHERE apellidos_usuario ILIKE ? OR nombres_usuario ILIKE ?
                ORDER BY apellidos_usuario';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        // Se encripta la clave por medio del algoritmo bcrypt que genera un string de 60 caracteres.
        $hash = password_hash($this->clave, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO usuarios(nombres_usuario, apellidos_usuario, correo_usuario, alias_usuario, clave_usuario,
                                    intentos, estado_usuario,fecha_clave)
                VALUES(?, ?, ?, ?, ?,?,?,current_date)';
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->alias, $hash,0,1);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_usuario, nombres_usuario, apellidos_usuario, correo_usuario, alias_usuario
                FROM usuarios
                ORDER BY apellidos_usuario';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_usuario, nombres_usuario, apellidos_usuario, correo_usuario
                FROM usuarios
                WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE usuarios 
                SET nombres_usuario = ?, apellidos_usuario = ?, correo_usuario = ?
                WHERE id_usuario = ?';
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM usuarios
                WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function verificarEstado(){
        if ($this->estado == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function verificarIntentos(){
        $sql = 'SELECT intentos
        FROM usuarios
        WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function actualizarIntentos($intentos)
    {
        $sql = 'UPDATE usuarios 
                SET intentos = ?
                WHERE id_usuario = ?';
        $params = array($intentos, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function actualizarEstado($estado)
    {
        $sql = 'UPDATE usuarios 
                SET estado_usuario = ?
                WHERE id_usuario = ?';
        $params = array($estado, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function accionUsuario($observacion)
    {
        $sql = 'INSERT INTO bitacora(id_usuario,fecha,hora,observacion) 
                VALUES(?,current_date,current_time,?)';
        $params = array($this->id, $observacion);
        return Database::executeRow($sql, $params);
    }

    public function verificar90dias(){
        $sql = 'SELECT fecha_clave FROM usuarios 
                WHERE id_usuario = ? AND fecha_clave > (SELECT current_date - 90)';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function changePasswordOut()
    {
        $hash = password_hash($this->clave, PASSWORD_DEFAULT);
        $sql = 'UPDATE usuarios SET clave_usuario = ? WHERE id_usuario = ?';
        $params = array($hash, $_SESSION['id_usuario_tmp']);
        return Database::executeRow($sql, $params);
    }

    public function actualizarFecha()
    {
        $sql = 'UPDATE usuarios 
                SET fecha_clave = current_date
                WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
