<?php

class Transacciones extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $idbodega;

    /**
     *
     * @var integer
     */
    public $idproducto;

    /**
     *
     * @var integer
     */
    public $idmovimiento;

    /**
     *
     * @var integer
     */
    public $iddocumento;

    /**
     *
     * @var string
     */
    public $fecha;

    /**
     *
     * @var integer
     */
    public $cantidad;

    /**
     *
     * @var integer
     */
    public $idestadotransito;

    /**
     *
     * @var integer
     */
    public $idbodegadestino;

    /**
     *
     * @var integer
     */
    public $idordencompra;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('idbodega', 'Bodegas', 'id', array('alias' => 'Bodegas'));
        $this->belongsTo('iddocumento', 'Documentos', 'id', array('alias' => 'Documentos'));
        $this->belongsTo('idestadotransito', 'EstadosTransito', 'id', array('alias' => 'EstadosTransito'));
        $this->belongsTo('idmovimiento', 'Movimientos', 'id', array('alias' => 'Movimientos'));
        $this->belongsTo('idproducto', 'Productos', 'id', array('alias' => 'Productos'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'transacciones';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Transacciones[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Transacciones
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
