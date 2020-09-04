<?php
    session_start();  
    
    include("../clases/class_conexion_pg.php");
    
    $Rol= $_POST['Rol'];
    $SubBandeja= $_POST['Sub'];
    $Bandeja= $_POST['Ban'];
    
    $objConexion= new Conexion();
    
    $sql= "select identidad, nombres, apellidos from mini_sedi.tbl_usuarios
            where bactivo= true and fiscal= true and rol= $Rol and isubbandejaid= $SubBandeja
            and ibandejaid= $Bandeja order by nombres";        

//        exit($sql);        
    $Reg= $objConexion->ejecutarComando($sql);
    
    $PrimerRegistro= 1;
    $json= "[";
    while ($Registro= pg_fetch_array($Reg)){
        $identidad= $Registro[identidad];  
        $nombre = $Registro[nombres];
        $apellido = $Registro[apellidos];

        if ($PrimerRegistro== 1){
            $PrimerRegistro= 0;            
        }
        else{
            $json .= ",";
        }
        $json .= "{\"identidad\":\"$identidad\",\"nombre\":\"$nombre\",\"apellido\":\"$apellido\"}"; 
    }
    $json .="]";
    echo $json;     