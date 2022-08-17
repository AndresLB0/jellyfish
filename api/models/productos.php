<?php
/*
*	Clase para manejar la tabla productos de la base de datos.
*   Es clase hija de Validator.
*/
class Productos extends Validator
{
    // Declaración de atributos (propiedades).
    private $id = null;
    private $nombre = null;
    private $descripcion = null;
    private $precio = null;
    private $imagen = null;
    private $marca = null;
    private $tipoproducto = null;
    private $estado = null;
    private $existencias=null;
    private $ruta = '../images/productos/';

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
        if ($this->validateImageFile($file, 1000, 1000)) {
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
    public function setMarca($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->marca = $value;
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
    public function setExistencias($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->existencias = $value;
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

    public function getMarca()
    {
        return $this->marca;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getRuta()
    {
        return $this->ruta;
    }
    public function getExistencias()
    {
        return $this->existencias;
    }
    public function getTipoproducto()
    {
        return $this->tipoproducto;
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_producto, imagen_producto, nombre_producto, descripcion_producto, precio_producto, nombre_marca, estado_producto
                FROM productos INNER JOIN marca USING(id_marca)
                WHERE nombre_producto ILIKE ? OR descripcion_producto ILIKE ?
                ORDER BY nombre_producto';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO productos(nombre_producto, descripcion_producto, precio_producto, imagen_producto, estado_producto, id_marca, id_usuario)
                VALUES(?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->descripcion, $this->precio, $this->imagen, $this->estado, $this->marca, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_producto, imagen_producto, nombre_producto, descripcion_producto, precio_producto, nombre_marca, estado_producto
                FROM productos INNER JOIN marca USING(id_marca)
                ORDER BY nombre_producto';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, precio_producto, imagen_producto, id_marca, estado_producto
                FROM productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow($current_image)
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        ($this->imagen) ? $this->deleteFile($this->getRuta(), $current_image) : $this->imagen = $current_image;

        $sql = 'UPDATE productos
                SET imagen_producto = ?, nombre_producto = ?, descripcion_producto = ?, precio_producto = ?, estado_producto = ?, id_marca = ?
                WHERE id_producto = ?';
        $params = array($this->imagen, $this->nombre, $this->descripcion, $this->precio, $this->estado, $this->marca, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function readProductosMarca()
    {
        $sql = 'SELECT id_producto, imagen_producto, nombre_producto, descripcion_producto, precio_producto
                FROM productos INNER JOIN marca USING(id_marca)
                WHERE id_marca = ? AND estado_producto = true
                ORDER BY nombre_producto';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }
    public function readproductoTipo()
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
    public function cantidadProductosCategoria()
    {
        $sql = 'SELECT nombres_usuario,count(id_usuario)veces_atendido from usuarios inner join productos using (id_usuario)
        group by id_usuario order by id_usuario desc';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function porcentajeProductosCategoria()
    {
        $sql = 'SELECT nombre_categoria, ROUND((COUNT(id_producto) * 100.0 / (SELECT COUNT(id_producto) FROM productos)), 2) porcentaje
                FROM productos INNER JOIN categorias USING(id_categoria)
                GROUP BY nombre_Marca ORDER BY porcentaje DESC';
        $params = null;
        return Database::getRows($sql, $params);
    }

    /*
    *   Métodos para generar reportes.
    */
    public function productosCategoria()
    {
        $sql = 'SELECT nombre_producto, precio_producto, estado_producto
                FROM productos INNER JOIN marca USING(id_Marca)
                WHERE id_Marca = ?
                ORDER BY nombre_producto';
        $params = array($this->Marca);
        return Database::getRows($sql, $params);
    }
    public function ProductosTipo()
    {
        $sql = 'SELECT nombre_producto, precio_producto,nombre_marca
                FROM productos INNER JOIN marca using(id_marca)INNER JOIN tipo_producto USING(idtipo_producto)
                WHERE idtipo_producto = ?
                ORDER BY nombre_producto';
        $params = array($this->tipoproducto);
        return Database::getRows($sql, $params);
    }   
     public function Productosmarca()
    {
        $sql = 'SELECT nombre_producto, precio_producto,existencias
                FROM productos INNER JOIN marca USING(id_marca)
                WHERE id_marca = ?
                ORDER BY nombre_producto';
        $params = array($this->marca);
        return Database::getRows($sql, $params);
    }
}
