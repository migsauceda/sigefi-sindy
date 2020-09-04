<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Fiscal
 *
 * @author administrador
 */
require_once '../clases/Usuario.php';
require_once '../denuncia/ORM_Fiscal.php';

session_start();

class Fiscal extends Persona{
    private $Fiscalia; //bandeja
    private $Expedientes;
    
    function __construct() {
        if (isset($_SESSION['objUsuario'])){ 
            $objUsuario= $_SESSION['objUsuario'];        
        }else{
            exit("Error no exite usuario en archivo orm_denuncia");
        }
        $Fiscalia= $objUsuario->getSubBandejaId();
        $Expedientes= new SplDoublyLinkedList();        
    }
    
}
