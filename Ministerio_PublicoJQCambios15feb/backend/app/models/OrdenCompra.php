<?php

class OrdenCompra extends \Phalcon\Mvc\Model
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
    public $idproyecto;

    /**
     *
     * @var integer
     */
    public $idproveedor;

    /**
     *
     * @var integer
     */
    public $idestado;

    /**
     *
     * @var string
     */
    public $flete;

    /**
     *
     * @var integer
     */
    public $idmoneda;

    /**
     *
     * @var string
     */
    public $data;

    /**
     *
     * @var integer
     */
    public $idtipo;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'CuentasPagar', 'idordencompra', array('alias' => 'CuentasPagar'));
        $this->hasMany('id', 'DetalleOrdenCompra', 'idordencompra', array('alias' => 'DetalleOrdenCompra'));
        $this->hasMany('id', 'OrdenCompraFacturas', 'idordencompra', array('alias' => 'OrdenCompraFacturas'));
        $this->hasMany('id', 'OrdesCompraDetalleParciales', 'idordencompra', array('alias' => 'OrdesCompraDetalleParciales'));
        $this->belongsTo('idestado', 'OrdenCompraEstados', 'id', array('alias' => 'OrdenCompraEstados'));
        $this->belongsTo('idmoneda', 'Monedas', 'id', array('alias' => 'Monedas'));
        $this->belongsTo('idproveedor', 'Proveedores', 'rtnid', array('alias' => 'Proveedores'));
        $this->belongsTo('idtipo', 'OrdesCompraTipos', 'id', array('alias' => 'OrdesCompraTipos'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'orden_compra';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return OrdenCompra[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return OrdenCompra
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
