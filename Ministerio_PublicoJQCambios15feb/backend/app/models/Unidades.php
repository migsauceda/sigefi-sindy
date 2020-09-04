<?php

class Unidades extends \Phalcon\Mvc\Model
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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Inventario', 'idunidad', array('alias' => 'Inventario'));
        $this->hasMany('id', 'Productos', 'idunidad', array('alias' => 'Productos'));
        $this->hasMany('id', 'ProyectosMateriales', 'idunidad', array('alias' => 'ProyectosMateriales'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'unidades';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Unidades[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Unidades
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
