<?php

class UsuariosPerfiles extends \Phalcon\Mvc\Model
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
    public $descripcion;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Usuarios', 'id', array('alias' => 'Usuarios'));
        $this->hasMany('id', 'UsuariosRecursosPerfiles', 'idperfil', array('alias' => 'UsuariosRecursosPerfiles'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'usuarios_perfiles';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UsuariosPerfiles[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UsuariosPerfiles
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
