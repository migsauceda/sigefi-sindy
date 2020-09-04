<?php

class ConsignacionSobrantesRecuperacion extends \Phalcon\Mvc\Model
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
    public $idcliente;

    /**
     *
     * @var integer
     */
    public $idbodega;

    /**
     *
     * @var integer
     */
    public $idtipoentrada;

    /**
     *
     * @var integer
     */
    public $idproyecto;

    /**
     *
     * @var integer
     */
    public $idempleado;

    /**
     *
     * @var string
     */
    public $fecha;

    /**
     *
     * @var string
     */
    public $data;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'DetalleConsignacionSobranteRecuperacion', 'idconsignacionsobranterecuperacion', array('alias' => 'DetalleConsignacionSobranteRecuperacion'));
        $this->belongsTo('idcliente', 'Clientes', 'rtnid', array('alias' => 'Clientes'));
        $this->belongsTo('idbodega', 'Bodegas', 'id', array('alias' => 'Bodegas'));
        $this->belongsTo('idtipoentrada', 'TiposEntradas', 'id', array('alias' => 'TiposEntradas'));
        $this->belongsTo('idproyecto', 'Proyectos', 'id', array('alias' => 'Proyectos'));
        $this->belongsTo('idempleado', 'Empleados', 'id', array('alias' => 'Empleados'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'consignacion_sobrantes_recuperacion';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ConsignacionSobrantesRecuperacion[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ConsignacionSobrantesRecuperacion
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
