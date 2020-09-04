<?php

class Proyectos extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $descripcion;

    /**
     *
     * @var string
     */
    public $fechainicio;

    /**
     *
     * @var string
     */
    public $fechafinal;

    /**
     *
     * @var integer
     */
    public $idtipoproyecto;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'ConsignacionSobrantesRecuperacion', 'idproyecto', array('alias' => 'ConsignacionSobrantesRecuperacion'));
        $this->hasMany('id', 'Proformas', 'idproyecto', array('alias' => 'Proformas'));
        $this->hasMany('id', 'ProyectoBodegas', 'idproyecto', array('alias' => 'ProyectoBodegas'));
        $this->hasMany('id', 'UnidadesMontadas', 'idproyecto', array('alias' => 'UnidadesMontadas'));
        $this->belongsTo('idtipoproyecto', 'ProyectosTipos', 'id', array('alias' => 'ProyectosTipos'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'proyectos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Proyectos[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Proyectos
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
