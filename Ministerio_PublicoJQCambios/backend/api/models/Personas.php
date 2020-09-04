<?php

class Personas extends \Phalcon\Mvc\Model
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
	
	public $identidad;
	
	public $correo;
	
	
	public $telefono;
	
	public $celular;
	
	public $genero;
	
	public $idniveleducativo;
	
	public $idestadocivil;
	
	
	public $idciudad;
	
	
	
	public $edad;
	
	public $des_edad;
	
	public $nacionalidad;
	
	public $descripcion;
	

    /**
     *
     * @var integer
    

    /**
     * Initialize method for model.
     */
   


    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Descuentos[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Descuentos
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
