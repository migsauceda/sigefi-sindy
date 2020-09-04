<?php

class CuentasPagar extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $idproveedor;

    /**
     *
     * @var integer
     */
    public $idordencompra;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('idproveedor', 'Proveedores', 'rtnid', array('alias' => 'Proveedores'));
        $this->belongsTo('idordencompra', 'OrdenCompra', 'id', array('alias' => 'OrdenCompra'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'cuentas_pagar';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return CuentasPagar[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return CuentasPagar
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
