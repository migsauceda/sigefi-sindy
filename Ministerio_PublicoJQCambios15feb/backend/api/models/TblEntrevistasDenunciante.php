<?php

class TblEntrevistasDenunciante  extends \Phalcon\Mvc\Model
{
	public $entrevistaid;
	
    public $cnombres;
	
	public $capellidos;
	 
    public $cgenero;
	
	public $nprofesionid;
	 
    public $nocupacionid;
	
	public $nescolaridadid;
	
	public $netniaid;
	
	public $ndiscapacidadid;
	 
    public $iedad;
	
	public $cbarrioid;
	 
   // public $orientacionsexual;
	
	public $cdireccion;
	
	public $nestadocivilid;
	
	public $ctelefono;
	
	public $cmetanombre;
	
	public $cmetaapellido;

	public $personanatural;
	
	public $aplicagbti;
	
	public $nidentificacionid;
    
	
    public function getSource()
    {
        return 'tbl_entrevistas_denunciante';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TblEnterprise[]
     */
	 	public function getSchema()
    {
        return "mini_sedi";
     }
	 
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
