<?php

class TblSubbandejas extends \Phalcon\Mvc\Model
{


	public $isubbandejaid;
	
	
	 
    public $cdescripcion;
	
	 public $dfechacreacion;
	 
    public $ibandejaid;
	 public $cdeptopaisid;
	 
    public $cmunicipioid;
	

   
	public function getSchema()
    {
        return "mini_sedi";
     }
	 
 
    public function getSource()
    {
        return 'tbl_subbandejas';
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
