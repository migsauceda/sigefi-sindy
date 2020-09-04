<?php

class Documentos extends \Phalcon\Mvc\Model
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
     * @var integer
     */
    public $idtipodocumento;

    /**
     *
     * @var string
     */
    public $imagen;

    /**
     *
     * @var string
     */
    public $data;

    /**
     *
     * @var string
     */
    public $idreferencia;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Transacciones', 'iddocumento', array('alias' => 'Transacciones'));
        $this->belongsTo('idtipodocumento', 'TiposDocumentos', 'id', array('alias' => 'TiposDocumentos'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'documentos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Documentos[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Documentos
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
