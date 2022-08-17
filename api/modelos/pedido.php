<?php

class Pedido extends validator 
{
    private $idcliente = null;
    private $fecha= null;
    private $idempleado = null;
    private $idpedido = null;
    private $estado= null;
    private $direccion = null;

    public function setIdCliente($value)
    {
        if ($this->validateNaturalNumber($value)){
            $this->idcliente = $value;
            return true;
        } else{
           return false;
        }
    }

    public function setFecha($value)
    {
        // Se dividen las partes de la fecha y se guardan en un arreglo en el siguiene orden: año, mes y día.
        $date = explode('-', $value);
        if (checkdate($date[1], $date[2], $date[0])) {
            return true;
        } else {
            return false;
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

    public function setIdPedido($value)
    {
        if ($this->validateNaturalNumber($value)){
            $this->idpedido = $value;
            return true;
        } else{
           return false;
        }
    }

    public function setEstado($value)
    {
        if ($value) {
            if ($this->validateString($value, 1, 250)) {
                $this->estado = $value;
                return true;
            } else {
                return false;
            }
        } else {
            $this-> = null;
            return true;
        }
    }

    public function setDireccion($value)
    {
        if ($value) {
            if ($this->validateString($value, 1, 250)) {
                $this->direccion = $value;
                return true;
            } else {
                return false;
            }
        } else {
            $this-> = null;
            return true;
        }
    }

    public function getIdCliente()
    {
        return $this->idcliente;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getIdEmpleado()
    {
        return $this->empleado;
    }

    public function getIdPedido()
    {
        return $this->idpedido;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function searchRows($value)
    {
        $sql = 'SELECT id_cliente, fecha, id_empleado, id_pedido, estado, direccion
                FROM pedido
                WHERE estado ILIKE ? 
                ORDER BY usuario';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO public.pedido(
            id_cliente, fecha, id_empleado, estado, direccion)
            VALUES (?, ?, ?, ?, ?)';
        $params = array($this->idcliente, $this->fecha, $this->idempleado,  $this->estado, $this->direccion);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT *
                FROM pedido
                ORDER BY estado';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_cliente, fecha, id_empleado, estado, direccion"
        FROM pedido
        WHERE id_pedido = ?';
        $params = array($this->idpedido);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE pedido
        SET id_cliente=?, fecha=?, id_empleado=?, estado=?, direccion=?
        WHERE id_pedido=?';
        $params = array($this->idcliente, $this->fecha, $this->idempleado,  $this->estado, $this->direccion);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM pedido
        WHERE id_pedido';
        $params = array($this->idpedido);
        return Database::executeRow($sql, $params);
    }
}








