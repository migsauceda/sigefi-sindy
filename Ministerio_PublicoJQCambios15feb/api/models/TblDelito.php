<?php

use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class TblDelito extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $ndelitoid;

    /**
     *
     * @var string
     */
    public $cdescripcion;

    /**
     *
     * @var integer
    

    /**
     * Initialize method for model.
     */
     
	public function getSchema()
    {
        return "mini_sedi";
    }
	 
   
  public function getSource()
    {
        return 'tbl_delito';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Descuentos[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Descuentos
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

 public static function delitos($parameters = null)
    {
        $sql="select *from mini_sedi.tbl_delito";
			$result = new TblDepartamentoPais();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }
}
