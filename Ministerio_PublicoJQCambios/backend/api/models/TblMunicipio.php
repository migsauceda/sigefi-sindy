<?php

use Phalcon\Mvc\Model\Resultset\Simple as Resultset;
class TblMunicipio extends \Phalcon\Mvc\Model

{

    /**
     *
     * @var integer
     */
    public $cmunicipioid;

    /**
     *
     * @var string
     */
	 public $cdepartamentoid;
	 
    public $cdescripcion;

   
	public function getSchema()
    {
        return "mini_sedi";
     }
	 
 
    public function getSource()
    {
        return 'tbl_municipio';
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
	
	
	 public static function GetMuncipio($depto=null) {
			$sql="select cmunicipioid,cdepartamentoid,initcap(cdescripcion) cdescripcion from mini_sedi.tbl_municipio where cdepartamentoid='$depto' order by cdescripcion asc";
			$result = new TblMunicipio();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
	}
	

}

