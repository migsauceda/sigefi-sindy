<?php

include("../clases/class_conexion_pg.php");

    $valor = $_POST['valor'];//numero denuncia
    $objConexion=new Conexion(); 
    $sql= "select denunciacompleta($valor);";

    $resultado=$objConexion->ejecutarComando($sql);
    $indicador=pg_num_rows($resultado);
    if ($indicador == 1)
        return 1;
    else
        return 0;
?>