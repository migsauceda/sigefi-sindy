<?php
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;
class TblDepartamentoPais extends \Phalcon\Mvc\Model


{

    /**
     *
     * @var integer
     */
    public $cdepartamentoid;

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
        return 'tbl_departamentopais';
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

 public static function GetDepto($depto=null) {
			$sql="select  cdepartamentoid,initcap(cdescripcion)cdescripcion from mini_sedi.tbl_departamentopais";
			$result = new TblDepartamentoPais();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
	}
}
