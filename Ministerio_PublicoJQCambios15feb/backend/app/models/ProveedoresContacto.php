<?php

use Phalcon\Mvc\Model\Validator\Email as Email;

class ProveedoresContacto extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $rtnidproveedor;

    /**
     *
     * @var integer
     */
    public $idtelefono;

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
        $this->belongsTo('rtnidproveedor', 'Proveedores', 'rtnid', array('alias' => 'Proveedores'));
        $this->belongsTo('idtelefono', 'Telefonos', 'id', array('alias' => 'Telefonos'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'proveedores_contacto';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProveedoresContacto[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProveedoresContacto
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
