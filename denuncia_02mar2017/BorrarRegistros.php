<?php
session_start();

include("../clases/class_conexion_pg.php");

$Borrar= $_GET[reg];
$Id= $_GET[id];
$Den= $_SESSION['denunciaid'];

if ($Borrar== 'denunciante'){ //borrar denunciante
    $sql= "delete from mini_sedi.tbl_denunciante where tpersonaid = $Id and tdenunciaid= $Den";
    $objConexion= new Conexion();
    $reg= $objConexion->ejecutarComando($sql); 
    
    $sql= "delete from mini_sedi.tbl_pdf_denunciante where tpersonaid = $Id and tdenunciaid= $Den";
    $objConexion= new Conexion();
    $reg= $objConexion->ejecutarComando($sql); 
    
    header("location: frmExpediente.php?borrar=1&rsl=300");
}
elseif ($Borrar== 'denunciado'){ //borrar denunciado
    $sql= "delete from mini_sedi.tbl_imputado where tpersonaid = $Id and tdenunciaid= $Den";
    $objConexion= new Conexion();
    $reg= $objConexion->ejecutarComando($sql); 
    
    $sql= "delete from mini_sedi.tbl_pdf_imputado where tpersonaid = $Id and tdenunciaid= $Den";
    $objConexion= new Conexion();
    $reg= $objConexion->ejecutarComando($sql); 
    
//    header("location: ../imputado/imputado.php?btn=nuevo");    
    header("location: frmExpediente.php?borrar=2&rsl=300");
}
elseif ($Borrar== 'ofendido'){ //borrar ofendido
    $sql= "delete from mini_sedi.tbl_ofendido where tpersonaid = $Id and tdenunciaid= $Den";
    $objConexion= new Conexion();
    $reg= $objConexion->ejecutarComando($sql); 
    
    $sql= "delete from mini_sedi.tbl_pdf_ofendido where tpersonaid = $Id and tdenunciaid= $Den";
    $objConexion= new Conexion();
    $reg= $objConexion->ejecutarComando($sql); 
    
//    header("location: ../ofendido/ofendido.php?btn=nuevo");        
    header("location: frmExpediente.php?borrar=3&rsl=300");
}
?>