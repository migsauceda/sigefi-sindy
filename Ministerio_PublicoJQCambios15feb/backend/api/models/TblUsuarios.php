<?php

class TblUsuarios extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $usuario;

    /**
     *
     * @var string
     */
	 public $contrasena;
	 
	 public $ilugarid;
	 
    public $nombres;

	public $pedircambiopasswd;
	
	public $ibandejaid;
	public $identidad;
	
	public $apellidos;
	public $vencimientoclave;
	
	public $isubbandejaid;
	public $rol;
	public $fiscal;
	public $bactivo;
   
	public function getSchema()
    {
        return "mini_sedi";
     }
	 
 
    public function getSource()
    {
        return 'tbl_usuarios';
    }
	
	

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TblEnterprise[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TblEnterprise
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
