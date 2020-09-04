<?php

class ProveedoresConstancias extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $rtnidproveedor;

    /**
     *
     * @var string
     */
    public $fecha;

    /**
     *
     * @var string
     */
    public $data;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('rtnidproveedor', 'Proveedores', 'rtnid', array('alias' => 'Proveedores'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'proveedores_constancias';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProveedoresConstancias[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProveedoresConstancias
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
