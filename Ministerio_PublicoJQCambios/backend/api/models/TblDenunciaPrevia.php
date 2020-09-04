<?php

class  TblDenunciaPrevia extends \Phalcon\Mvc\Model
{
	public $ndenunciapreviaid;
	
    public $dfecha_denuncia;
	
	public $dfecha_hecho;
	 
    public $cnarracionhecho;
	
	public $cdeptodenuncia;
	 
    public $cmunicipiodenuncia;
	
	public $cdireccion_denuncia;
	
	public $cdireccion_hecho;
	
	public $ccreada;
	 
    public $nidbandejaid;
	
	public $dfecha_registro;
	 
    public $thora_denuncia;
	
	public $thora_hecho;
	
	public $flatitud_lugar_hecho;
	
	public $flongitud_lugar_hecho;
	
	public $ntipodenunciaid;
	
	public $baplica_denuncia;

public $cnumerotomaturno;

    public $nentrevistaid;

	
	public function getSchema()
    {
        return "mini_sedi";
    }
	 
	
    public function getSource()
    {
        return 'tbl_denuncia_previa';
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
