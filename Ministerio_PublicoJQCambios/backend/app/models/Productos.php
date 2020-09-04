<?php

class Productos extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $codigo;

    /**
     *
     * @var string
     */
    public $descripcion;

    /**
     *
     * @var integer
     */
    public $idsubcategoria;

    /**
     *
     * @var integer
     */
    public $impuesto;

    /**
     *
     * @var integer
     */
    public $idunidad;

    /**
     *
     * @var string
     */
    public $preciocosto;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'DetalleConsignacionSobranteRecuperacion', 'idproducto', array('alias' => 'DetalleConsignacionSobranteRecuperacion'));
        $this->hasMany('id', 'DetalleOrdenCompra', 'idproducto', array('alias' => 'DetalleOrdenCompra'));
        $this->hasMany('id', 'Inventario', 'idproducto', array('alias' => 'Inventario'));
        $this->hasMany('id', 'ProyectosMateriales', 'idproducto', array('alias' => 'ProyectosMateriales'));
        $this->hasMany('id', 'Transacciones', 'idproducto', array('alias' => 'Transacciones'));
        $this->belongsTo('idsubcategoria', 'Subcategorias', 'id', array('alias' => 'Subcategorias'));
        $this->belongsTo('idunidad', 'Unidades', 'id', array('alias' => 'Unidades'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'productos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Productos[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Productos
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
