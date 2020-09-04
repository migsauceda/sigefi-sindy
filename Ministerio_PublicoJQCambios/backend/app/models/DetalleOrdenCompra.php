<?php

class DetalleOrdenCompra extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $idordencompra;

    /**
     *
     * @var integer
     */
    public $idproducto;

    /**
     *
     * @var integer
     */
    public $cantidad;

    /**
     *
     * @var string
     */
    public $preciocosto;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('idordencompra', 'OrdenCompra', 'id', array('alias' => 'OrdenCompra'));
        $this->belongsTo('idproducto', 'Productos', 'id', array('alias' => 'Productos'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'detalle_orden_compra';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return DetalleOrdenCompra[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return DetalleOrdenCompra
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
