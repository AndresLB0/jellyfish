<?php
/*
*	Clase para manejar la tabla tipo_producto de la base de datos.
*   Es clase hija de Validator.
*/
class tipo_producto extends Validator
{
    // Declaración de atributos (propiedades).
    private $id = null;
    private $tipo_producto = null;

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

    public function setTipoproducto($value)
    {
        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->tipo_producto = $value;
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

    public function getTipo_producto()
    {
        return $this->tipo_producto;
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT idtipo_producto, tipo_producto
                FROM tipo_producto
                WHERE tipo_producto ILIKE ?
                ORDER BY tipo_producto';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tipo_producto(tipo_producto)
                VALUES(?)';
        $params = array($this->tipo_producto);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT idtipo_producto, tipo_producto
                FROM tipo_producto
                ORDER BY tipo_producto';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT idtipo_producto, tipo_producto
                FROM tipo_producto
                WHERE idtipo_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow($current_image)
    {

        $sql = 'UPDATE tipo_producto
                SET tipo_producto = ?
                WHERE idtipo_producto = ?';
        $params = array($this->tipo_producto,$this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tipo_producto
                WHERE idtipo_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
