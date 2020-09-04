<?php
include("../clases/class_conexion_pg.php");
$opcion= $_POST[accion];
$valor= $_POST[valor];

if ($opcion== 'perfil'){
    $objConexion=new Conexion(); 
    $sql= "SELECT rolid, descripcion FROM mini_sedi.tbl_rol
        order by descripcion;";
    $resFiscalia=$objConexion->ejecutarComando($sql);

    echo "<option value=0>Seleccione un perfil</option>";
    while ($fila=pg_fetch_array($resFiscalia)){
        $Campo= $fila[rolid];
        $Descripcion= $fila[descripcion];
        echo "<option value='$Campo'>$Descripcion</option>";
    }         
}
else if($opcion== 'bandeja'){
    $objConexion=new Conexion(); 
    $sql= "SELECT ibandejaid, cdescripcion FROM mini_sedi.tbl_bandejas "
            . "where ibandejaid >= 0 order by cdescripcion";
//        where ibandejaid = $valor order by cdescripcion;";
    $rsBandeja=$objConexion->ejecutarComando($sql);		

    echo "<option value=0>Seleccione una bandeja</option>";
    while ($fila=pg_fetch_array($rsBandeja)){
        $Campo= $fila[ibandejaid];
        $Descripcion= $fila[cdescripcion];            
        echo "<option value='$Campo'>$Descripcion</option>";
    }        
}
else if($opcion== 'subbandeja'){
    $objConexion=new Conexion(); 
    $sql= "SELECT isubbandejaid, cdescripcion FROM mini_sedi.tbl_subbandejas
        where ibandejaid= $valor order by cdescripcion;";
    $rsBandeja=$objConexion->ejecutarComando($sql);		

    echo "<option value=0>Seleccione una sub bandeja</option>";
    while ($fila=pg_fetch_array($rsBandeja)){
        $Campo= $fila[isubbandejaid];
        $Descripcion= $fila[cdescripcion];            
        echo "<option value='$Campo'>$Descripcion</option>";
    }        
}
else if($_POST[accion]== 'lugar'){
    $objConexion=new Conexion();
    $sql= "SELECT ilugarid, descripcion FROM mini_sedi.tbl_lugartrabajo
        order by descripcion; ";
    $rsPerfil=$objConexion->ejecutarComando($sql);
    
    while ($fila=pg_fetch_array($rsPerfil)){
        $Campo= $fila[ilugarid];
        $Descripcion= $fila[descripcion];
        echo "<option value='$Campo'>$Descripcion</option>";
    }     
}
?>
