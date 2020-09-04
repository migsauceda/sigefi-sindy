<?php
    include("../clases/class_conexion_pg.php");
    //iniciar e instanciar conexion
    $conexion=new Conexion();
    //obtener el recuroso id
    $usr=($_POST['usr']);
    
    $consulta="select * from mini_sedi.tbl_usuarios as usr where upper(usuario) = '".strtoupper($usr)."';";

    $sqlp=$conexion->ejecutarComando($consulta);

    $cadena= "[";
    while($fila = pg_fetch_assoc($sqlp)){
        if($cadena != "[")
            {$cadena .= ",";}
            
        $cadena.= '{"usuario" : "' . $fila['usuario'] . '", ';
        $cadena.= '"nombres" : "' . $fila['nombres'] . '", ';
        $cadena.= '"apellidos" : "' . $fila['apellidos'] . '", ';
        $cadena.= '"ibandejaid" :' . $fila['ibandejaid'] . ', ';
        $cadena.= '"isubbandejaid" : ' . $fila['isubbandejaid'] . ', ';
        $cadena.= '"rol" : "' . $fila['rol'] . '", ';
        $cadena.= '"identidad" : "' . $fila['identidad'] . '", ';
        $cadena.= '"fiscal" : "' . $fila['fiscal'] . '", ';
        $cadena.= '"activo" : "' . $fila['bactivo'] . '"}';
    }
    
    $cadena .= "]";
    
    $json= '{"usuariodata" :'. $cadena . '}';
    
//    echo $cadena;
//    echo $consulta;
    echo $json;
?>
