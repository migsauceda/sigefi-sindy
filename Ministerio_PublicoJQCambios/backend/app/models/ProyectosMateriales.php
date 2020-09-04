<?php

class ProyectosMateriales extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $idunidad;

    /**
     *
     * @var integer
     */
    public $idproducto;

    /**
     *
     * @var integer
     */
    public $cantidaddefinida;

    /**
     *
     * @var integer
     */
    public $cantidadutilizada;

    /**
     *
     * @var integer
     */
    public $suministrado;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('idunidad', 'Unidades', 'id', array('alias' => 'Unidades'));
        $this->belongsTo('idproducto', 'Productos', 'id', array('alias' => 'Productos'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'proyectos_materiales';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProyectosMateriales[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProyectosMateriales
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
