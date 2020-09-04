<?php
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;
class TblBarrio extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $cbarrioid;

    /**
     *
     * @var string
     */
    public $cdescripcion;

   
	public function getSchema()
    {
        return "mini_sedi";
     }
	 
 
    public function getSource()
    {
        return 'tbl_barrio';
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

	
	public static function GetBarrio($municipio=null) {
			$sql="select cbarrioid,cmunicipioid,initcap(cdescripcion)  cdescripcion from mini_sedi.tbl_barrio  where cmunicipioid='$municipio' order by cdescripcion asc";
			$result = new TblBarrio();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
	}
}
