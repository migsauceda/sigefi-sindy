<?php

class Inventario extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $idproducto;

    /**
     *
     * @var integer
     */
    public $idbodega;

    /**
     *
     * @var integer
     */
    public $stockminimo;

    /**
     *
     * @var integer
     */
    public $stock;

    /**
     *
     * @var integer
     */
    public $ganancia;

    /**
     *
     * @var string
     */
    public $preciocosto;

    /**
     *
     * @var integer
     */
    public $cantidad;

    /**
     *
     * @var string
     */
    public $fechacreacion;

    /**
     *
     * @var integer
     */
    public $idunidad;

    /**
     *
     * @var integer
     */
    public $idcategoria;

    /**
     *
     * @var integer
     */
    public $esminimo;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('idbodega', 'Bodegas', 'id', array('alias' => 'Bodegas'));
        $this->belongsTo('idcategoria', 'Categorias', 'id', array('alias' => 'Categorias'));
        $this->belongsTo('idproducto', 'Productos', 'id', array('alias' => 'Productos'));
        $this->belongsTo('idunidad', 'Unidades', 'id', array('alias' => 'Unidades'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'inventario';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Inventario[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Inventario
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
