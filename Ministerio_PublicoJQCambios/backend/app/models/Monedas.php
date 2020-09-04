<?php

class Monedas extends \Phalcon\Mvc\Model
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
     * @var string
     */
    public $prefijo;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'ClientesCredito', 'idmoneda', array('alias' => 'ClientesCredito'));
        $this->hasMany('id', 'OrdenCompra', 'idmoneda', array('alias' => 'OrdenCompra'));
        $this->hasMany('id', 'ProveedoresCredito', 'idmoneda', array('alias' => 'ProveedoresCredito'));
        $this->hasMany('id', 'ProveedoresTiposCuentasBancarias', 'idmoneda', array('alias' => 'ProveedoresTiposCuentasBancarias'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'monedas';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Monedas[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Monedas
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
