<?php
include("../clases/class_conexion_pg.php");

session_start(); 

if (isset($_SESSION['oDenunciado'])){ 
    $personaid= $_POST['personaid'];
    $denunciaid= $_SESSION['denunciaid'];
} 

$objConexion=new Conexion(); 

$sql= "select nmovilid, tpersonaid, tdenunciaid from mini_sedi.denunciado_movil("
    ."'".$denunciaid."', "
    ."'".$personaid."'"
    .");";
//echo $sql;
$cursor= $objConexion->ejecutarProcedimiento($sql);

$i= 0;
//while ($registro= pg_fetch_assoc($cursor)){
//    $enviar[]= $registro;
////    $i++;
//}
$registro= pg_fetch_assoc($cursor);
$enviar[]= $registro;
echo json_encode(array_values($enviar));  
?>