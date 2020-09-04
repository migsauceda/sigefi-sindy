<?php

class Bodegas extends \Phalcon\Mvc\Model
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
    public $nombre;

    /**
     *
     * @var string
     */
    public $ubicacion;

    /**
     *
     * @var integer
     */
    public $idtipobodega;

    /**
     *
     * @var integer
     */
    public $estado;

    /**
     *
     * @var integer
     */
    public $principal;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'ConsignacionSobrantesRecuperacion', 'idbodega', array('alias' => 'ConsignacionSobrantesRecuperacion'));
        $this->hasMany('id', 'Inventario', 'idbodega', array('alias' => 'Inventario'));
        $this->hasMany('id', 'ProyectoBodegas', 'idbodega', array('alias' => 'ProyectoBodegas'));
        $this->hasMany('id', 'Transacciones', 'idbodega', array('alias' => 'Transacciones'));
        $this->belongsTo('idtipobodega', 'BodegasTipo', 'id', array('alias' => 'BodegasTipo'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'bodegas';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Bodegas[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Bodegas
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
