<?php

use Phalcon\Mvc\Model\Validator\Email as Email;

class Proveedores extends \Phalcon\Mvc\Model
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
    public $direccion;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var integer
     */
    public $internacional;

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
        $this->hasMany('rtnid', 'CuentasPagar', 'idproveedor', array('alias' => 'CuentasPagar'));
        $this->hasMany('rtnid', 'OrdenCompra', 'idproveedor', array('alias' => 'OrdenCompra'));
        $this->hasMany('rtnid', 'ProveedoresConstancias', 'rtnidproveedor', array('alias' => 'ProveedoresConstancias'));
        $this->hasMany('rtnid', 'ProveedoresContacto', 'rtnidproveedor', array('alias' => 'ProveedoresContacto'));
        $this->hasMany('rtnid', 'ProveedoresCredito', 'rtnidproveedore', array('alias' => 'ProveedoresCredito'));
        $this->hasMany('rtnid', 'ProveedoresCuentasBancarias', 'rtnidproveedor', array('alias' => 'ProveedoresCuentasBancarias'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'proveedores';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Proveedores[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Proveedores
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
