<?php

class ClientesCredito extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $rtnid;

    /**
     *
     * @var integer
     */
    public $diascredito;

    /**
     *
     * @var integer
     */
    public $limite;

    /**
     *
     * @var integer
     */
    public $idmoneda;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('idmoneda', 'Monedas', 'id', array('alias' => 'Monedas'));
        $this->belongsTo('rtnid', 'Clientes', 'rtnid', array('alias' => 'Clientes'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'clientes_credito';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ClientesCredito[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ClientesCredito
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
