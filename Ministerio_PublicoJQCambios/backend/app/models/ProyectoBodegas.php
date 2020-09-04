<?php

class ProyectoBodegas extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $idproyecto;

    /**
     *
     * @var integer
     */
    public $idbodega;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('idproyecto', 'Proyectos', 'id', array('alias' => 'Proyectos'));
        $this->belongsTo('idbodega', 'Bodegas', 'id', array('alias' => 'Bodegas'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'proyecto_bodegas';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProyectoBodegas[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProyectoBodegas
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
