<?php
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\InclusionIn;
class carsdetalle extends Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $color;
	
	public $idcarro;

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
        return 'carsdetalle';
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

	//desencamaronamelo
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
