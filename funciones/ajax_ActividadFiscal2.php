<?php
session_start(); 

include("../clases/class_conexion_pg.php");

$opcion= $_POST['opcion'];
$subetapa= $_POST['subetapa'];
$imputados= $_POST['imputados'];
$etapa= $_POST['etapa'];
$denunciaid= $_SESSION['denunciaid'];

$objConexion=new Conexion(); 


if($opcion== "imputados"){
    $sql= "select distinct i.tpersonaid, (cnombres || ' ' || capellidos) as nombres from mini_sedi.tbl_imputado as i
            inner join mini_sedi.tbl_imputado_delito as id on i.tpersonaid= id.tpersonaid
            where i.tdenunciaid= $denunciaid
            order by nombres";

    $resActividad=$objConexion->ejecutarComando($sql);
    $PrimerRegistro= 1;
    $json= "[";
    while ($Registro= pg_fetch_array($resActividad)){
        $imputadoid= $Registro[tpersonaid];  
        $nombreimputado = $Registro[nombres];

        if ($PrimerRegistro== 1){
            $PrimerRegistro= 0;            
        }
        else{
            $json .= ",";
        }
        $json .= "{\"imputadoid\":\"$imputadoid\",\"nombre\":\"$nombreimputado\"}";                        
    }
    $json .="]";
    echo $json; 
}

if($opcion== "delitos"){
    
    if (substr_count($imputados, ',') > 0){
        //delitos en comun
    $countImputados= substr_count($imputados, ',') + 1;
        $sql= "select ndelitoid, cdescripcion from mini_sedi.tbl_delito
                where ndelitoid in (select ndelito from mini_sedi.tbl_imputado_delito 
                where tpersonaid in ($imputados)  
                group by ndelito having count(ndelito) = $countImputados)";        
    }
    else{
        //delitos individual
        $sql= "select ndelitoid, cdescripcion from mini_sedi.tbl_delito
                where ndelitoid in 
                (select ndelito from mini_sedi.tbl_imputado_delito 
                where tpersonaid in ($imputados))";        
    }
    
    $resActividad=$objConexion->ejecutarComando($sql);
    $PrimerRegistro= 1;
    $json= "[";
    while ($Registro= pg_fetch_array($resActividad)){
        $delitoid= $Registro[ndelitoid];  
        $delitodesc = $Registro[cdescripcion];

        if ($PrimerRegistro== 1){
            $PrimerRegistro= 0;            
        }
        else{
            $json .= ",";
        }
        $json .= "{\"delitoid\":\"$delitoid\",\"delito\":\"$delitodesc\"}";                        
    }
    $json .="]";
    echo $json; 
}

if($opcion== "subetapa"){
    $sql= "select s.nsubetapaid, cdescripcion
            from mini_sedi.tbl_subetapa as s
            inner join mini_sedi.tbl_subetapa_actividad as sa on s.nsubetapaid= sa.nsubetapaid
            where nactividadid= $subetapa
            order by cdescripcion";

    $resSubEtapa=$objConexion->ejecutarComando($sql);
    $PrimerRegistro= 1;
    $json= "[";
    while ($Registro= pg_fetch_array($resSubEtapa)){
        $subetapaidid= $Registro[nsubetapaid];  
        $descripcion = $Registro[cdescripcion];

        if ($PrimerRegistro== 1){
            $PrimerRegistro= 0;            
        }
        else{
            $json .= ",";
        }
        $json .= "{\"subetapaid\":\"$subetapaidid\",\"descripcion\":\"$descripcion\"}";                        
    }
    $json .="]";
    echo $json; 
}

if($opcion== "materia"){
    $sql= "select nmateria, cdescripcion from mini_sedi.tbl_materia
            order by cdescripcion";

    $resSubEtapa=$objConexion->ejecutarComando($sql);
    $PrimerRegistro= 1;
    $json= "[";
    while ($Registro= pg_fetch_array($resSubEtapa)){
        $materiaid= $Registro[nmateria]; 
        $_SESSION['idmateria']=$materiaid; 
        $descripcion = $Registro[cdescripcion];

        if ($PrimerRegistro== 1){
            $PrimerRegistro= 0;            
        }
        else{
            $json .= ",";
        }
        $json .= "{\"materiaid\":\"$materiaid\",\"descripcion\":\"$descripcion\"}";                        
    }
    $json .="]";
    echo $json; 
}

if($opcion== "etapa"){
    $sql= "select netapaid, cdescripcion from mini_sedi.tbl_etapa
            order by cdescripcion";

    $resSubEtapa=$objConexion->ejecutarComando($sql);
    $PrimerRegistro= 1;
    $json= "[";
    while ($Registro= pg_fetch_array($resSubEtapa)){
        $netapaid= $Registro[netapaid];  
        $_SESSION['idetapa']=$netapaid;
        $descripcion = $Registro[cdescripcion];

        if ($PrimerRegistro== 1){
            $PrimerRegistro= 0;            
        }
        else{
            $json .= ",";
        }
        $json .= "{\"etapaid\":\"$netapaid\",\"descripcion\":\"$descripcion\"}";                        
    }
    $json .="]";
    echo $json; 
}
?>
