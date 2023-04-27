<?php
include("../clases/class_conexion_pg.php");
include_once "../clases/Usuario.php";
session_start();

$Inicio= $_POST['inicio'];
$Fin= $_POST['fin'];

$objUsuairo= $_SESSION["objUsuario"];
$Bandeja= $objUsuairo->getBandejaId();

//$Inicio= "20180101";
//$Fin= "20180101";

//si es fiscal jefe de fiscalia
if ($objUsuairo->getRolId() == 3) //fiscal jefe
{    
    $Bandeja= $objUsuairo->getBandejaId();
    
    $sql= "select distinct nombres || ' ' || apellidos as fiscal
        from mini_sedi.tbl_usuarios where identidad not in
        (select cfiscalid from mini_sedi.tbl_imputado_actividad_delito
        where dfecha >= '$Inicio' and dfecha <= '$Fin') and ibandejaid= $Bandeja
        order by fiscal";  
}

//si es fiscal jefe de seccion
if ($objUsuairo->getRolId() == 16) //jefe seccion
{    
    $SubBandeja= $objUsuairo->getSubBandejaId();
    
    $sql= "select distinct nombres || ' ' || apellidos as fiscal
        from mini_sedi.tbl_usuarios where identidad not in
        (select cfiscalid from mini_sedi.tbl_imputado_actividad_delito
        where dfecha >= '$Inicio' and dfecha <= '$Fin') and isubbandejaid= $SubBandeja
        order by fiscal";
}

$conexion= new Conexion();
$cursor= $conexion->ejecutarProcedimiento($sql);
$reg= pg_fetch_array($cursor);

$json= "{\"Objeto\": [";
//$json= "[";
$primero= 1;
while ($reg){
    if ($primero == 0){
        $json .= ", ";
    }
    else{        
        $primero= 0;
    }
    $json .= "{\"Fiscal\":\"$reg[fiscal]\"}";
    $reg= pg_fetch_array($cursor);
}
$json .= "]}";
//$json .= "]";
echo $json;
//echo json_encode($json);