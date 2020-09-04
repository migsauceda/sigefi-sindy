<?php

class ClientesContactos extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $rtnid;

    /**
     *
     * @var string
     */
    public $nombre;

    /**
     *
     * @var integer
     */
    public $idtelefono;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('rtnid', 'Clientes', 'rtnid', array('alias' => 'Clientes'));
        $this->belongsTo('idtelefono', 'Telefonos', 'id', array('alias' => 'Telefonos'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'clientes_contactos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ClientesContactos[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ClientesContactos
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
