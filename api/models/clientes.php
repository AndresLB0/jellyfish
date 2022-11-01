<?php
/*
*	Clase para manejar la tabla clientes de la base de datos.
*   Es clase hija de Validator.
*/
class Clientes extends Validator
{
    // Declaración de atributos (propiedades).
    private $id = null;
    private $nombres = null;
    private $apellidos = null;
    private $correo = null;
    private $telefono = null;
    private $dui = null;
    private $nacimiento = null;
    private $direccion = null;
    private $usuario = null;
    private $clave = null;
    private $token = null;
    private $intentos = null;
    private $fecha_intentos = null;
    private $dias_clave = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
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

    public function setTelefono($value)
    {
        if ($this->validatePhone($value)) {
            $this->telefono = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setUsuario($value)
    {
        if ($this->validateAlphanumeric($value,1,200)) {
            $this->usuario= $value;
            return true;
        } else {
            return false;
        }
    }

    public function setClave($value)
    {
        if ($this->validatePassword($value)) {
            $this->clave = password_hash($value, PASSWORD_DEFAULT);
            return true;
        } else {
            return false;
        }
    }
    public function setToken($value)
    {
        if ($this->validateToken($value)) {
            $this->token = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setIntentos($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->intentos = $value;
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

    public function getUsuario()
    {
        return $this->usuario;
    }
    public function getCorreo()
    {
        return $this->correo;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getClave()
    {
        return $this->clave;
    }
    public function getToken()
    {
        return $this->token;
    }
    public function getIntentos()
    {
        return $this->intentos;
    }

    public function getFechaIntentos()
    {
        return $this->fecha_intentos;
    }
    public function getDiasClave()
    {
        return $this->dias_clave;
    }
    /*
    *   Métodos para gestionar la cuenta del cliente.
    */
 
    public function checkToken($token)
    {
        $sql = 'SELECT id_cliente FROM cliente WHERE token = ?';
        $params = array($token);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_cliente'];
            $this->token = $_SESSION['codigo'];
            return true;
        } else {
            return false;
        }
    }
    public function checkPassword($password)
    {
        $sql = 'SELECT contraseña,nombre,usuario,EXTRACT(days from (CURRENT_DATE - fecha_clave)) as dias FROM cliente WHERE id_cliente = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        // Se verifica si la contraseña coincide con el hash almacenado en la base de datos.
        if (password_verify($password, $data['contraseña'])) {
            $this->dias_clave = $data['dias'];
            $this->nombres = $data['nombre'];
            $this->usuario = $data['usuario'];
            return true;
        } else {
            return false;
        }
    }
    public function deleteToken()
    {
        $sql = 'UPDATE cliente SET token = NULL WHERE id_cliente = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
    public function forgetPassword()
    {
        date_default_timezone_set('America/El_Salvador');
        $date = date('Y-m-d');
        $sql = 'UPDATE cliente SET contraseña = ?, fecha_clave=? WHERE id_cliente = ?';
        $params = array($this->clave,$date, $this->id);
        return Database::executeRow($sql, $params);
    }
    public function checkEmail($correo)
    {
        $sql = 'SELECT id_cliente,intentos,EXTRACT(days from (CURRENT_DATE - fecha_intentos)) as intent FROM cliente WHERE correo = ?';
        $params = array($correo);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_cliente'];
            $this->intentos = $data['intentos'];
            $this->fecha_intentos = $data['intent'];
            $this->correo=$correo;
            return true;
        } else {
            return false;
        }
    }
    public function saveToken()
    {
        $sql = 'UPDATE cliente SET token = ? WHERE id_cliente = ?';
        $params = array($_SESSION['codigo'], $this->id);
        return Database::executeRow($sql, $params);
    }
    public function changePassword()
    {
        date_default_timezone_set('America/El_Salvador');
        $date = date('Y-m-d');
        $sql = 'UPDATE cliente SET contraseña = ?,fecha_clave=? WHERE id_cliente = ?';
        $params = array($this->clave,$date, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE clientes
                SET nombres_cliente = ?, apellidos_cliente = ?, correo_cliente = ?, dui_cliente = ?, telefono_cliente = ?, nacimiento_cliente = ?, direccion_cliente = ?
                WHERE id_cliente = ?';
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->dui, $this->telefono, $this->nacimiento, $this->direccion, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function changeStatus()
    {
        $sql = 'UPDATE clientes
                SET estado_cliente = ?
                WHERE id_cliente = ?';
        $params = array($this->estado, $this->id);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_cliente, nombres_cliente, apellidos_cliente, correo_cliente, dui_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente
                FROM clientes
                WHERE apellidos_cliente ILIKE ? OR nombres_cliente ILIKE ? OR correo_cliente ILIKE ?
                ORDER BY apellidos_cliente';
        $params = array("%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO cliente(nombre, apellido, correo, telefono,usuario,contraseña)
                VALUES(?, ?, ?, ?, ?, ?)';
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->telefono,$this->usuario, $this->clave);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_cliente, nombre, apellido, correo, dui_cliente, estado_cliente
                FROM clientes
                ORDER BY apellidos_cliente';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_cliente, nombres_cliente, apellidos_cliente, correo_cliente, dui_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente
                FROM clientes
                WHERE id_cliente = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE clientes
                SET nombres_cliente = ?, apellidos_cliente = ?, dui_cliente = ?, estado_cliente = ?, telefono_cliente = ?, nacimiento_cliente = ?, direccion_cliente = ?
                WHERE id_cliente = ?';
        $params = array($this->nombres, $this->apellidos, $this->dui, $this->estado, $this->telefono, $this->nacimiento, $this->direccion, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM clientes
                WHERE id_cliente = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
    public function intentoFallido($correo)
    {
        $sql = 'UPDATE cliente
    set intentos = intentos + 1
    WHERE correo = ? ';
        $params = array($correo);
        $this->correo = $correo;
        Database::executeRow($sql, $params);
    }
    //Método para agregar una unidad a los intentos fallidos e ingresar la fehca y hora del ultimo intento fallido
    public function bloqueoIntentos($correo)
    {
        date_default_timezone_set('America/El_Salvador');
        $future_date = date("Y-m-d");
        $sql = 'UPDATE cliente
    set intentos = 0, fecha_intentos = ?
    WHERE correo = ?;';
        $params = array($future_date, $correo);
        $this->correo = $correo;
        return Database::executeRow($sql, $params);
    }

    //Método para agregar una unidad a los intentos fallidos e ingresar la fehca y hora del ultimo intento fallido
    public function reinicioConteoIntentos($correo)
    {
        $sql = 'UPDATE cliente
    set intentos = 0
    WHERE correo = ?';
        $params = array($correo);
        $this->correo = $correo;
        return Database::executeRow($sql, $params);
    }
}
