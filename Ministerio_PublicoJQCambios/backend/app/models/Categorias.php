<?php

class Categorias extends \Phalcon\Mvc\Model
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
    public $descripcion;

    /**
     *
     * @var integer
     */
    public $facturable;

    /**
     *
     * @var integer
     */
    public $idcliente;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Inventario', 'idcategoria', array('alias' => 'Inventario'));
        $this->belongsTo('idcliente', 'Clientes', 'rtnid', array('alias' => 'Clientes'));
        $this->belongsTo('idcliente', 'Clientes', 'rtnid', array('alias' => 'Clientes'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'categorias';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Categorias[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Categorias
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
