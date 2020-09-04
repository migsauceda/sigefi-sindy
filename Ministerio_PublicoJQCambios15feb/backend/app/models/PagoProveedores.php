<?php

class PagoProveedores extends \Phalcon\Mvc\Model
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
    public $idfactura;

    /**
     *
     * @var string
     */
    public $monto;

    /**
     *
     * @var string
     */
    public $data;

    /**
     *
     * @var string
     */
    public $fecha;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('idfactura', 'Facturas', 'id', array('alias' => 'Facturas'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'pago_proveedores';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return PagoProveedores[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return PagoProveedores
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
