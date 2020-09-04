<?php

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
	




    /**
     *
     * @var integer
    

    /**
     * Initialize method for model.
     */
   


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

}
