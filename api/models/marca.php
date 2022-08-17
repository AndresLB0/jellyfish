<?php
/*
*	Clase para manejar la tabla marca de la base de datos.
*   Es clase hija de Validator.
*/
class marca extends Validator
{
    // Declaración de atributos (propiedades).
    private $id = null;
    private $nombre = null;
    private $imagen = null;
    private $ruta = '../images/carrousel/';

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
            $this->marca = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setImagen($file)
    {
        if ($this->validateImageFile($file, 1000, 1000)) {
            $this->imagen = $this->getFileName();
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

    public function getmarca()
    {
        return $this->marca;
    }
    public function getImagen()
    {
        return $this->imagen;
    }
    public function getRuta()
    {
        return $this->ruta;
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_marca, nombre_marca,imagen
                FROM marca
                WHERE marca ILIKE ?
                ORDER BY marca';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO marca(nombre_marca,imagen)
                VALUES(?,?)';
        $params = array($this->marca,$this->imagen,);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_marca, nombre_marca,imagen
                FROM marca
                ORDER BY marca';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_marca, nombre_marca,imagen
                FROM marca
                WHERE id_marca = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow($current_image)
    {
        ($this->imagen) ? $this->deleteFile($this->getRuta(), $current_image) : $this->imagen = $current_image;

        $sql = 'UPDATE marca
                SET nombre_marca = ?,imagen=?
                WHERE id_marca = ?';
        $params = array($this->marca,$this->id,$this->imagen,);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM marca
                WHERE id_marca = ?';

        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
