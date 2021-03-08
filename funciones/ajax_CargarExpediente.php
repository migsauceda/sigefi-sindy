<?php
session_start(); 

include("../clases/class_conexion_pg.php");
$objConexion=new Conexion(); 
$opcion= $_POST['opcion'];


if($opcion== "bandeja"){
    $sql= "select ibandejaid, cdescripcion from mini_sedi.tbl_bandejas 
           where esfiscalia= 1 order by cdescripcion";

    $resSubEtapa=$objConexion->ejecutarComando($sql);


    $PrimerRegistro= 1;
    $json= "[";
    while ($Registro= pg_fetch_array($resSubEtapa)){
        $nbandejaid= $Registro[ibandejaid];  
        $_SESSION['idbandeja']=$nbandejaid;
        $descripcion = $Registro[cdescripcion];

        if ($PrimerRegistro== 1){
            $PrimerRegistro= 0;            
        }
        else{
            $json .= ",";
        }
        $json .= "{\"bandejaid\":\"$nbandejaid\",\"descripcion\":\"$descripcion\"}";                        
    }
    $json .="]";
    echo $json; 
}

if($opcion== "entrega"){

    $Expedienteid=$_POST['Expedienteid'];
   $consulta= "UPDATE mini_sedi.tbl_denuncia SET brecibido= true WHERE tdenunciaid= '$Expedienteid'";

    $resEntrega=$objConexion->ejecutarComando($consulta);

    $PrimerRegistro= 1;
    $json= "[";
    if ($Registro= pg_fetch_array($resEntrega)){
        
       $recibido = $Registro['brecibido'];

        if ($PrimerRegistro== 1){
            $PrimerRegistro= 0;          
        }
        else{
            $json .= ",";
        }
        $json .= "{\"recibido\":\" $recibido\"}";                        
    }
    $json .="]";
    echo $json; 

    







}


?>
