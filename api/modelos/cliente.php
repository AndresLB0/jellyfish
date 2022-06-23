<?php

class Cliente extends validator 
{
    private $nombre = null;
    private $apellido = null;
    private $correo = null;
    private $telefono = null;
    private $usuario = null;
    private $contraseña = null;
    private $id_cliente = null;

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
   
    public function setContraseña($value)
    {
        if ($value) {
            if ($this->validatePassword($value, 1, 250)) {
                $this->contraseña = $value;
                return true;
            } else {
                return false;
            }
        } else {
            $this-> = null;
            return true;
        }
    }

    public function setIdCliente($value)
    {
        if ($this->validateNaturalNumber($value)){
            $this->idCliente = $value;
            return true;
        } else{
           return false;
        }
    }


    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getContraseña()
    {
        return $this->contraseña;
    }

    public function getIdCliente()
    {
        return $this->idcliente;
    }

    public function searchRows($value)
    {
        $sql = 'SELECT nombre, apellido, correo, telefono, usuario, contraseña,id_cliente
                FROM cliente
                WHERE nombre ILIKE ? OR apellido ILIKE ?
                ORDER BY usuario';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO cliente(
            nombre, apellido, correo, telefono, usuario, "contraseña")
            VALUES (?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->apellido, $this->correo, $this->telefono, $this->usuario, $this->contraseña);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT *
                FROM cliente
                ORDER BY nombre';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT  nombre, apellido, correo, telefono, usuario, "contraseña", id_cliente
                FROM cliente
                WHERE id_cliente = ?';
        $params = array($this->idCliente);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE cliente
        SET nombre=?, apellido=?, correo=?, telefono=?, usuario=?, "contraseña"=?
        WHERE id_cliente=? ';
        $params = array($this->nombre, $this->apellido, $this->correo, $this->telefono, $this->usuario, $this->contraseña , $this->idCliente);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM cliente
        WHERE id_cliente=?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}


