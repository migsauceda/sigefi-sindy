<?php

class UsuariosRecursosControlador extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $idcontrolador;

    /**
     *
     * @var integer
     */
    public $idrecurso;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('idcontrolador', 'UsuariosControlador', 'id', array('alias' => 'UsuariosControlador'));
        $this->belongsTo('idrecurso', 'UsuariosRecursos', 'id', array('alias' => 'UsuariosRecursos'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'usuarios_recursos_controlador';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UsuariosRecursosControlador[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UsuariosRecursosControlador
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
