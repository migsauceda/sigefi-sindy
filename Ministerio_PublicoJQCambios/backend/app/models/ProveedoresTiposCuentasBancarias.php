<?php

class ProveedoresTiposCuentasBancarias extends \Phalcon\Mvc\Model
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
    public $idmoneda;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'ProveedoresCuentasBancarias', 'idcuentabancaria', array('alias' => 'ProveedoresCuentasBancarias'));
        $this->belongsTo('idmoneda', 'Monedas', 'id', array('alias' => 'Monedas'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'proveedores_tipos_cuentas_bancarias';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProveedoresTiposCuentasBancarias[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProveedoresTiposCuentasBancarias
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
