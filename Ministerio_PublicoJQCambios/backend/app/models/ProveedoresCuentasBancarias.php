<?php

class ProveedoresCuentasBancarias extends \Phalcon\Mvc\Model
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
    public $idcuentabancaria;

    /**
     *
     * @var string
     */
    public $numerocuenta;

    /**
     *
     * @var string
     */
    public $beneficiario;

    /**
     *
     * @var string
     */
    public $nombrebanco;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('rtnidproveedor', 'Proveedores', 'rtnid', array('alias' => 'Proveedores'));
        $this->belongsTo('idcuentabancaria', 'ProveedoresTiposCuentasBancarias', 'id', array('alias' => 'ProveedoresTiposCuentasBancarias'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'proveedores_cuentas_bancarias';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProveedoresCuentasBancarias[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProveedoresCuentasBancarias
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
