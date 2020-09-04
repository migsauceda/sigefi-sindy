<?php

class Facturas extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $idproforma;

    /**
     *
     * @var string
     */
    public $fecha;

    /**
     *
     * @var integer
     */
    public $idcliente;

    /**
     *
     * @var integer
     */
    public $numeroreferencia;

    /**
     *
     * @var string
     */
    public $data;

    /**
     *
     * @var string
     */
    public $datapago;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'OrdenCompraFacturas', 'idfactura', array('alias' => 'OrdenCompraFacturas'));
        $this->hasMany('id', 'PagoProveedores', 'idfactura', array('alias' => 'PagoProveedores'));
        $this->hasMany('id', 'PagosClientes', 'idfactura', array('alias' => 'PagosClientes'));
        $this->belongsTo('idproforma', 'Proformas', 'id', array('alias' => 'Proformas'));
        $this->belongsTo('idcliente', 'Clientes', 'rtnid', array('alias' => 'Clientes'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'facturas';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Facturas[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Facturas
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
