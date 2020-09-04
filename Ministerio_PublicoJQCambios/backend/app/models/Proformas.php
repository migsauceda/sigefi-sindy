<?php

class Proformas extends \Phalcon\Mvc\Model
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
     * @var string
     */
    public $fecha;

    /**
     *
     * @var integer
     */
    public $rtnidcliente;

    /**
     *
     * @var integer
     */
    public $validez;

    /**
     *
     * @var double
     */
    public $subtotal;

    /**
     *
     * @var double
     */
    public $impuesto;

    /**
     *
     * @var integer
     */
    public $facturable;

    /**
     *
     * @var integer
     */
    public $idestado;

    /**
     *
     * @var integer
     */
    public $idunidadmontada;

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
        $this->hasMany('id', 'CuentasCobrar', 'idpreforma', array('alias' => 'CuentasCobrar'));
        $this->hasMany('id', 'Facturas', 'idproforma', array('alias' => 'Facturas'));
        $this->belongsTo('idestado', 'ProformaEstados', 'id', array('alias' => 'ProformaEstados'));
        $this->belongsTo('idproyecto', 'Proyectos', 'id', array('alias' => 'Proyectos'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'proformas';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Proformas[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Proformas
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
