<?php
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class TblAldea extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $caldeaid;

    /**
     *
     * @var string
     */
	 public $cmunicipioid;
	 
	 public $cdepartamentoid;
	 
    public $cdescripcion;

	public $carea;
   
	public function getSchema()
    {
        return "mini_sedi";
     }
	 
 
    public function getSource()
    {
        return 'tbl_aldea';
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
	
	public static function GetAldea($municipio=null) {
			$sql="select caldeaid,cmunicipioid,cdepartamentoid,initcap(cdescripcion)  cdescripcion from mini_sedi.tbl_aldea  where cmunicipioid='$municipio' order by cdescripcion asc";
			$result = new TblAldea();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
	}
	

}
