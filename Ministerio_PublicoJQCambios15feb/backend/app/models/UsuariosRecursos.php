<?php

class UsuariosRecursos extends \Phalcon\Mvc\Model
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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'UsuariosRecursosControlador', 'idrecurso', array('alias' => 'UsuariosRecursosControlador'));
        $this->hasMany('id', 'UsuariosRecursosPerfiles', 'idrecurso', array('alias' => 'UsuariosRecursosPerfiles'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'usuarios_recursos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UsuariosRecursos[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UsuariosRecursos
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
