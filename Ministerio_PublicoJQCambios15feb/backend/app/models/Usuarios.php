<?php

class Usuarios extends \Phalcon\Mvc\Model
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
    public $contrasena;

    /**
     *
     * @var string
     */
    public $cambiocontrasena;

    /**
     *
     * @var integer
     */
    public $estado;

    /**
     *
     * @var integer
     */
    public $intentoscontrasena;

    /**
     *
     * @var integer
     */
    public $idperfil;

    /**
     *
     * @var string
     */
    public $usuarioscol;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Empleados', 'idusuario', array('alias' => 'Empleados'));
        $this->belongsTo('id', 'UsuariosPerfiles', 'id', array('alias' => 'UsuariosPerfiles'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'usuarios';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Usuarios[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Usuarios
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
