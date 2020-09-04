<?php

class OrdenCompraFacturas extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $idordencompra;

    /**
     *
     * @var integer
     */
    public $idfactura;

    /**
     *
     * @var integer
     */
    public $retencion;

    /**
     *
     * @var string
     */
    public $data;

    /**
     *
     * @var string
     */
    public $fechaemision;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('idordencompra', 'OrdenCompra', 'id', array('alias' => 'OrdenCompra'));
        $this->belongsTo('idfactura', 'Facturas', 'id', array('alias' => 'Facturas'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'orden_compra_facturas';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return OrdenCompraFacturas[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return OrdenCompraFacturas
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
