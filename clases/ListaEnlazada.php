<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ListaEnlazada
 *
 * @author miguel
 */
class ListaEnlazada extends SplObjectStorage {

    
    function __construct() {
        //$this->Lista= new SplObjectStorage();
    }

    public function AgregarDerecha($obj){
        $this->attach($obj);
    }
    
    public function RetornarActual(){
        if ($this->valid()){
            return $this->current();
        }
        else
            return false;        
    }

    public function Siguiente(){
        $this->next();
        
        if ($this->valid())
            return $this->RetornarActual();
        else
            return false;
    }
    
    public function Anterior(){    
        if (!$this->valid())
            return false;
        
        $Actual= $this->key();
        for($i=0; $i < $Actual-1; $i++)
            $this->next();
        
        return $this->RetornarActual();
    }
    
    public function Ira($indice){
        if ($indice > $this->count() || $indice < 0){
            return false;
        }
        for($i=0; $i < $indice; $i++)
            $this->next();
        
        return $this->RetornarActual();   
    }
    
    public function Primero(){
        $this->rewind();
        if ($this->valid())
            return $this->RetornarActual();   
        else
            return false;
    }
    
    public function Ultimo(){
        $this->rewind();
        if ($this->valid()){
            for($i= 0; $i < $this->count(); $i++)
                $this->next();
        }
    }
}
?>
