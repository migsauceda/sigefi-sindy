<?php
class TblEtnia extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $netniaid;

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
        return 'tbl_etnia';
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
