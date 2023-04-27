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

$sql= "select distinct nombres || ' ' || apellidos as fiscal, ban.cdescripcion as bandeja, sban.cdescripcion as subbandeja, tdenunciaid, max(dfecha) as ultimo
    from mini_sedi.tbl_imputado_actividad_delito as iad
    inner join mini_sedi.tbl_usuarios as usr on iad.cfiscalid = usr.identidad
    inner join mini_sedi.tbl_bandejas as ban on usr.ibandejaid= ban.ibandejaid
    inner join mini_sedi.tbl_subbandejas as sban on usr.isubbandejaid= sban.isubbandejaid
    where dfecha >= '$Inicio' and dfecha <= '$Fin' and usr.ibandejaid= $Bandeja
    group by nombres, apellidos, ban.cdescripcion, sban.cdescripcion, tdenunciaid
    order by fiscal, bandeja, subbandeja, tdenunciaid, ultimo desc";

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
//    $json .= "{\"Fiscal\":\"$reg[fiscal]\", \"Bandeja\":\"$reg[bandeja]\", \"Subbandeja\":\"$reg[subbandeja]\", \"Expediente\":\"$reg[tdenunciaid]\", \"Fecha\":\"$reg[ultimo]\"}";
    $json .= "{\"Fiscal\":\"$reg[fiscal]\", \"Expediente\":\"$reg[tdenunciaid]\", \"Fecha\":\"$reg[ultimo]\"}";
    $reg= pg_fetch_array($cursor);
}
$json .= "]}";
//$json .= "]";
echo $json;
//echo json_encode($json);