<?php

class Empleado extends validator 
{
    private $telefono = null;
    private $correo= null;
    private $apellido = null;
    private $nombre = null;
    private $idtipo= null;
    private $usuario = null;
    private $idempleado = null;

    public function setTelefono($value)
    {
        if ($value) {
            if ($this->validatePhone($value, 1, 8)) {
                $this->telefono = $value;
                return true;
            } else {
                return false;
            }
        } else {
            $this-> = null;
            return true;
        }
    }

    public function setCorreo($value)
    {
        if ($value) {
            if ($this->validateEmail($value, 1, 250)) {
                $this->correo = $value;
                return true;
            } else {
                return false;
            }
        } else {
            $this-> = null;
            return true;
        }
    }
    
    public function setApellido($value)
    {
        if ($value) {
            if ($this->validateAlphabetic($value, 1, 250)) {
                $this->apellido = $value;
                return true;
            } else {
                return false;
            }
        } else {
            $this->apellido = null;
            return true;
        }
    }

    public function setNombre($value)
    {
        if ($value) {
            if ($this->validateAlphabetic($value, 1, 250)) {
                $this->nombre = $value;
                return true;
            } else {
                return false;
            }
        } else {
            $this->nombre = null;
            return true;
        }
    }

    public function setIdTipo($value)
    {
        if ($this->validateNaturalNumber($value)){
            $this->idtipo = $value;
            return true;
        } else{
           return false;
        }
    }

    public function setUsuario($value)
    {
        if ($value) {
            if ($this->validateString($value, 1, 250)) {
                $this->usuario = $value;
                return true;
            } else {
                return false;
            }
        } else {
            $this-> = null;
            return true;
        }
    }

    public function setIdEmpleado($value)
    {
        if ($this->validateNaturalNumber($value)){
            $this->idempleado = $value;
            return true;
        } else{
           return false;
        }
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getIdTipo()
    {
        return $this->idtipo;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getIdEmpleado()
    {
        return $this->empleado;
    }

    public function searchRows($value)
    {
        $sql = 'SELECT telefono, correo, apellido, nombre_empleado, idtipo_empleado, usuario, contraseña, id_empleado
                FROM empleado
                WHERE nombre_empleado ILIKE ? OR apellido ILIKE ?
                ORDER BY usuario';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO empleado(
            telefono, correo, apellido, nombre_empleado, idtipo_empleado, usuario, "contraseña")
            VALUES (?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->telefono, $this->correo, $this->apellido, $this->nombre, $this->idtipo, $this->usuario, $this->contraseña);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT *
                FROM empleado
                ORDER BY nombre';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT telefono, correo, apellido, nombre_empleado, idtipo_empleado, usuario, "contraseña"
        FROM empleado
        WHERE id_empleado = ?';
        $params = array($this->idempleado);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE empleado
        SET telefono=?, correo=?, apellido=?, nombre_empleado=?, idtipo_empleado=?, usuario=?, "contraseña"=?
        WHERE id_empleado=?';
        $params = array($this->telefono, $this->correo, $this->apellido, $this->nombre, $this->idtipo, $this->usuario, $this->contraseña, $this-> idempleado);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM empleado
        WHERE id_empleado=?';
        $params = array($this->idempleado);
        return Database::executeRow($sql, $params);
    }
}











