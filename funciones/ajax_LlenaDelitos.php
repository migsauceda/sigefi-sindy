<?php
include("../clases/class_conexion_pg.php");

session_start(); 

if (isset($_SESSION['oDenunciado'])){ 
    $personaid= $_POST['personaid'];
    $denunciaid= $_SESSION['denunciaid'];
} 

$objConexion=new Conexion(); 

$sql= "select ndelito, cclasificacion from mini_sedi.denunciado_delito("
    ."'".$denunciaid."', "
    ."'".$personaid."'"
    .");";

$cursor= $objConexion->ejecutarProcedimiento($sql);

$i= 0;
while ($registro= pg_fetch_assoc($cursor)){
    $enviar[]= $registro;
//    $i++;
}
echo json_encode(array_values($enviar));      
?>
