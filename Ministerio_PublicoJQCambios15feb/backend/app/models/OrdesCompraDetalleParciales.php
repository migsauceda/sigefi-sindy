<?php

class OrdesCompraDetalleParciales extends \Phalcon\Mvc\Model
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
     *
     * @var string
     */
    public $facturareferencia;

    /**
     *
     * @var string
     */
    public $fecha;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('idordencompra', 'OrdenCompra', 'id', array('alias' => 'OrdenCompra'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'ordes_compra_detalle_parciales';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return OrdesCompraDetalleParciales[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return OrdesCompraDetalleParciales
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
