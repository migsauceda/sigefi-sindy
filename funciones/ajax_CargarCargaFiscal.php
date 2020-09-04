<?php
    include("../clases/class_conexion_pg.php");

    //funciones genericas
    include "../funciones/php_funciones.php";   

    $fiscal= $_POST[fiscal];
    $Cursor= CargarCargaFiscal($fiscal); 
    $PrimerRegistro= 1;
    $json= "[";
    while ($Registro= pg_fetch_array($Cursor)){
        $denuncia= $Registro[tdenunciaid];            
        $imputado = $Registro[imputado];
        $imputadoid = $Registro[tpersonaid];
        $delito = $Registro[delito]; 
        $delitoid = $Registro[delitoid]; 
        
        if ($PrimerRegistro== 1){
            $PrimerRegistro= 0;            
        }
        else{
            $json .= ",";
        }
        $json .= "{\"denuncia\":\"$denuncia\",\"imputado\":\"$imputado\","
                . "\"imputadoid\":\"$imputadoid\",\"delito\":\"$delito\","
                . "\"delitoid\":\"$delitoid\"}";                        
    }
    $json .="]";
    echo $json;
?>