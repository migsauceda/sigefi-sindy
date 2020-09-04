<?php

use Phalcon\Mvc\Model\Validator\Email as Email;

class Clientes extends \Phalcon\Mvc\Model
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
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $direccion;

    /**
     *
     * @var integer
     */
    public $internacional;

    /**
     *
     * @var integer
     */
    public $plazo;

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $this->validate(
            new Email(
                array(
                    'field'    => 'email',
                    'required' => true,
                )
            )
        );

        if ($this->validationHasFailed() == true) {
            return false;
        }

        return true;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('rtnid', 'Categorias', 'idcliente', array('alias' => 'Categorias'));
        $this->hasMany('rtnid', 'Categorias', 'idcliente', array('alias' => 'Categorias'));
        $this->hasMany('rtnid', 'ClientesContactos', 'rtnid', array('alias' => 'ClientesContactos'));
        $this->hasMany('rtnid', 'ClientesCredito', 'rtnid', array('alias' => 'ClientesCredito'));
        $this->hasMany('rtnid', 'ConsignacionSobrantesRecuperacion', 'idcliente', array('alias' => 'ConsignacionSobrantesRecuperacion'));
        $this->hasMany('rtnid', 'Facturas', 'idcliente', array('alias' => 'Facturas'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'clientes';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Clientes[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Clientes
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
