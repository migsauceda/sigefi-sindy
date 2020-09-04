<?php

class PagosClientes extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $idcuentacobrar;

    /**
     *
     * @var integer
     */
    public $idfactura;

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
     *
     * @var string
     */
    public $monto;

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
        return 'pagos_clientes';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return PagosClientes[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return PagosClientes
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
