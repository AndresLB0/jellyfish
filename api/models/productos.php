<?php
/*
*	Clase para manejar la tabla Producto de la base de datos.
*   Es clase hija de Validator.
*/
class producto extends Validator
{
    // Declaración de atributos (propiedades).
    private $id = null;
    private $nombre = null;
    private $descripcion = null;
    private $precio = null;
    private $imagen = null;
    private $tipoproducto = null;
    private $estado = null;
    private $ruta = '../images/producto/';

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

    public function setNombre($value)
    {
        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDescripcion($value)
    {
        if ($this->validateString($value, 1, 250)) {
            $this->descripcion = $value;
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

    public function setImagen($file)
    {
        if ($this->validateImageFile($file, 500, 500)) {
            $this->imagen = $this->getFileName();
            return true;
        } else {
            return false;
        }
    }

    public function setTipoproducto($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->tipoproducto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstado($value)
    {
        if ($this->validateBoolean($value)) {
            $this->estado = $value;
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

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function getTipoproducto()
    {
        return $this->tipoproducto;
    }

    public function getEstado()
    {
        return $this->estado;
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
        $sql = 'SELECT id_producto, imagen, nombre, descripcion, precio, tipo_producto, estado
                FROM producto INNER JOIN tipo_producto USING(idtipo_producto)
                WHERE nombre ILIKE ? OR descripcion ILIKE ?
                ORDER BY nombre';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO producto(nombre, descripcion, precio, imagen, estado, idtipo_producto, id_usuario)
                VALUES(?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->descripcion, $this->precio, $this->imagen, $this->estado, $this->tipoproducto, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_producto, imagen, nombre, descripcion, precio, tipo_producto, estado
                FROM producto INNER JOIN tipo_producto USING(idtipo_producto)
                ORDER BY nombre';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_producto, nombre, descripcion, precio, imagen, idtipo_producto, estado
                FROM producto
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow($current_image)
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        ($this->imagen) ? $this->deleteFile($this->getRuta(), $current_image) : $this->imagen = $current_image;

        $sql = 'UPDATE producto
                SET imagen = ?, nombre = ?, descripcion = ?, precio = ?, estado = ?, idtipo_producto = ?
                WHERE id_producto = ?';
        $params = array($this->imagen, $this->nombre, $this->descripcion, $this->precio, $this->estado, $this->tipoproducto, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM producto
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function readproductotipoproducto()
    {
        $sql = 'SELECT id_producto, imagen, nombre, descripcion, precio
                FROM producto INNER JOIN tipo_producto USING(idtipo_producto)
                WHERE idtipo_producto = ? AND estado = true
                ORDER BY nombre';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    /*
    *   Métodos para generar gráficas.
    */
    public function cantidadproductotipoproducto()
    {
        $sql = 'SELECT tipo_producto, COUNT(id_producto) cantidad
                FROM producto INNER JOIN tipo_producto USING(idtipo_producto)
                GROUP BY tipo_producto ORDER BY cantidad DESC';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function porcentajeproductotipoproducto()
    {
        $sql = 'SELECT tipo_producto, ROUND((COUNT(id_producto) * 100.0 / (SELECT COUNT(id_producto) FROM producto)), 2) porcentaje
                FROM producto INNER JOIN tipo_producto USING(idtipo_producto)
                GROUP BY tipo_producto ORDER BY porcentaje DESC';
        $params = null;
        return Database::getRows($sql, $params);
    }

    /*
    *   Métodos para generar reportes.
    */
    public function Productostipoproducto()
    {
        $sql = 'SELECT nombre, precio,valoracion
        FROM producto INNER JOIN tipo_producto USING(idtipo_producto) inner join valoracion using(id_valoracion)
        where idtipo_producto=?
        ORDER BY nombre';
        $params = array($this->tipoproducto);
        return Database::getRows($sql, $params);
    }
    public function Productosmarca()
    {
        $sql = 'SELECT nombre, precio, existencias
                FROM producto INNER JOIN marca USING(id_marca)
                WHERE id_marca = ?
                ORDER BY nombre';
        $params = array($this->tipoproducto);
        return Database::getRows($sql, $params);
    }
}
