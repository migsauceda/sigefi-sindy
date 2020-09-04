<?php

use Phalcon\Mvc\Model\Validator\Email as Email;

class Empleados extends \Phalcon\Mvc\Model
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
    public $direccion;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var integer
     */
    public $idusuario;

    /**
     *
     * @var string
     */
    public $sexo;

    /**
     *
     * @var string
     */
    public $estadocivil;

    /**
     *
     * @var integer
     */
    public $idcargo;

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $this->validate(
            new Email(
                array(
                    'field'    => 'email',
                    'required' => true,
                )
            )
        );

        if ($this->validationHasFailed() == true) {
            return false;
        }

        return true;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'ConsignacionSobrantesRecuperacion', 'idempleado', array('alias' => 'ConsignacionSobrantesRecuperacion'));
        $this->belongsTo('idusuario', 'Usuarios', 'id', array('alias' => 'Usuarios'));
        $this->belongsTo('idcargo', 'Cargos', 'id', array('alias' => 'Cargos'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'empleados';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Empleados[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Empleados
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
