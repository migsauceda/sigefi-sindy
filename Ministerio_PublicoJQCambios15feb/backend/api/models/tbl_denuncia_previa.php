<?php
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\InclusionIn;
class tbl_denuncia_previa extends Model
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

    public $nentrevistaid;

    public $centroatencion;

    public $observacioncentroatencion;

	
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
