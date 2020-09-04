<?php

class CuentasCobrar extends \Phalcon\Mvc\Model
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
    public $idpreforma;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('idpreforma', 'Proformas', 'id', array('alias' => 'Proformas'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'cuentas_cobrar';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return CuentasCobrar[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return CuentasCobrar
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
