<?php

class TblTipodenuncia extends \Phalcon\Mvc\Model
{


	 public $istipodenucnia;
	 
    public $cdescripcion;

   
	public function getSchema()
    {
        return "mini_sedi";
     }
	 
 
    public function getSource()
    {
        return 'tbl_tipodenuncia';
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
