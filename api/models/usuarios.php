<?php
/*
*	Clase para manejar la tabla usuarios de la base de datos.
*   Es clase hija de Validator.
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
    private $token = null;
    private $telefono = null;
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
    public function setToken($value)
    {
        if ($this->validateToken($value)) {
            $this->token = $value;
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
            $this->clave = password_hash($value, PASSWORD_DEFAULT);
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

    public function getCorreo()
    {
        return $this->correo;
    }
    public function getTelefono()
    {
        return $this->telefono;
    }
    public function getAlias()
    {
        return $this->alias;
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
    *   Métodos para gestionar la cuenta del usuario.
    */
    public function checkUser($usuario)
    {
        $sql = 'SELECT id_empleado,intentos,EXTRACT(days from (CURRENT_DATE - fecha_intentos)) as intent FROM empleado WHERE usuario = ?';
        $params = array($usuario);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_empleado'];
            $this->intentos = $data['intentos'];
            $this->fecha_intentos = $data['intent'];
            $this->alias = $usuario;
            return true;
        } else {
            return false;
        }
    }
 public function saveToken()
    {
        $sql = 'UPDATE empleado SET token = ? WHERE id_empleado = ?';
        $params = array($_SESSION['codigo'], $this->id);
        return Database::executeRow($sql, $params);
    }
    public function deleteToken()
    {
        $sql = 'UPDATE empleado SET token = NULL WHERE id_empleado = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
    public function checkToken($token)
    {
        $sql = 'SELECT id_empleado FROM empleado WHERE token = ?';
        $params = array($token);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_empleado'];
            $this->token = $_SESSION['codigo'];
            return true;
        } else {
            return false;
        }
    }
    public function checkEmail($correo)
    {
        $sql = 'SELECT id_empleado,nombre_empleado FROM empleado WHERE correo = ?';
        $params = array($correo);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_empleado'];
            $this->nombres = $data['nombre_empleado'];
            $this->correo = $correo;
            return true;
        } else {
            return false;
        }
    }
    public function checkPassword($password)
    {
        $sql = 'SELECT clave,nombre_empleado,correo,EXTRACT(days from (CURRENT_DATE - fecha_clave)) as dias FROM empleado WHERE id_empleado = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        // Se verifica si la contraseña coincide con el hash almacenado en la base de datos.
        if (password_verify($password, $data['clave'])) {
            $this->dias_clave = $data['dias'];
            $this->nombres = $data['nombre_empleado'];
            $this->correo = $data['correo'];
            return true;
        } else {
            return false;
        }
    }
    public function forgetPassword()
     {
       date_default_timezone_set('America/El_Salvador');
        $date = date('Y-m-d');
        $sql = 'UPDATE empleado SET clave = ?,fecha_clave=? WHERE id_empleado = ?';
        $params = array($this->clave,$date, $this->id);
        return Database::executeRow($sql, $params);
    }
    public function changePassword()
    {
        date_default_timezone_set('America/El_Salvador');
        $date = date('Y-m-d');
        $sql = 'UPDATE empleado SET clave = ?,fecha_clave=? WHERE id_empleado = ?';
        $params = array($this->clave,$date, $_SESSION['id_usuario']);
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
                SET nombres_usuario = ?, apellidos_usuario = ?, correo_usuario = ?
                WHERE id_usuario = ?';
        $params = array($this->nombres, $this->apellidos, $this->correo, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
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
    public function registro()
    {
        date_default_timezone_set('America/El_Salvador');
        $date = date('Y-m-d');
        $sql = "WITH auto_cargo as (
          INSERT INTO tipo_empleado (tipo_empleado) VALUES ('propietario') 
          RETURNING id_tipoempleado)
        INSERT INTO empleado (nombre_empleado,apellido,correo,telefono,usuario,clave,fecha_clave,idtipo_empleado)
        VALUES (?,?,?,?,?,?,?,(SELECT id_tipoempleado FROM auto_cargo))";
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->telefono, $this->alias, $this->clave, $date);
        return Database::executeRow($sql, $params);
    }
    public function createRow()
    {
        $sql = 'INSERT INTO usuarios(nombres_usuario, apellidos_usuario, correo_usuario, alias_usuario, clave_usuario)
                VALUES(?, ?, ?, ?, ?)';
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->alias, $this->clave);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_empleado, nombre_empleado, apellido, correo, usuario
                FROM empleado
                ORDER BY apellido';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_usuario, nombres_usuario, apellidos_usuario, correo_usuario, alias_usuario
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
    public function intentoFallido($usuario)
    {
        $sql = 'UPDATE empleado
    set intentos = intentos + 1
    WHERE usuario = ? ';
        $params = array($usuario);
        $this->alias = $usuario;
        Database::executeRow($sql, $params);
    }
    //Método para agregar una unidad a los intentos fallidos e ingresar la fehca y hora del ultimo intento fallido
    public function bloqueoIntentos($usuario)
    {
        date_default_timezone_set('America/El_Salvador');
        $future_date = date("Y-m-d");
        $sql = 'UPDATE empleado
    set intentos = 0, fecha_intentos = ?
    WHERE usuario = ?;';
        $params = array($future_date, $usuario);
        $this->alias = $usuario;
        return Database::executeRow($sql, $params);
    }

    //Método para agregar una unidad a los intentos fallidos e ingresar la fehca y hora del ultimo intento fallido
    public function reinicioConteoIntentos($usuario)
    {
        $sql = 'UPDATE empleado
    set intentos = 0
    WHERE usuario = ?';
        $params = array($usuario);
        $this->alias = $usuario;
        return Database::executeRow($sql, $params);
    }
}
