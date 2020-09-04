<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author miguel
 */
class ListaUnaClave {
    private $Lista;
    
    public function __construct() {
        $Lista= new SplDoublyLinkedList();
    }


    public function Existe($clave){
        //encontrar
        //$clave= 2;
//        $L
        $existe= 0;
        while($this->valid()){
            if ($clave== $this->current()){
                $existe= 1;
                break;
            }
            $this->next();
        }
        if ($existe== 1)
            return true;
        else
            return false;
    }

    function AgregarDerecha($clave){
        $this->push($clave);          
    }
    
    function Borrar($borrar){
        $tmp= new SplDoublyLinkedList();
        $lista->rewind();
        //meter a $tmp lo que NO kiero borrar
        while($lista->valid()){
            if($lista->current()!=$borrar){
                $tmp->push($lista->current());
            }
            $lista->shift();
            $lista->next();           
        }
        $tmp->rewind();
        while($tmp->valid()){
            $lista->push($tmp->current());
            $tmp->next();
        }
        unset($tmp);        
    }
}

?>
