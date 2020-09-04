<?php

class Telefonos extends \Phalcon\Mvc\Model
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
    public $telefono;

    /**
     *
     * @var integer
     */
    public $idtelefonica;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'ClientesContactos', 'idtelefono', array('alias' => 'ClientesContactos'));
        $this->hasMany('id', 'ProveedoresContacto', 'idtelefono', array('alias' => 'ProveedoresContacto'));
        $this->belongsTo('idtelefonica', 'Telefonicas', 'id', array('alias' => 'Telefonicas'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'telefonos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Telefonos[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Telefonos
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
