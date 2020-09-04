<?php

class UsuariosRecursosPerfiles extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $idperfil;

    /**
     *
     * @var integer
     */
    public $idrecurso;

    /**
     *
     * @var integer
     */
    public $escritura;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('idperfil', 'UsuariosPerfiles', 'id', array('alias' => 'UsuariosPerfiles'));
        $this->belongsTo('idrecurso', 'UsuariosRecursos', 'id', array('alias' => 'UsuariosRecursos'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'usuarios_recursos_perfiles';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UsuariosRecursosPerfiles[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UsuariosRecursosPerfiles
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
