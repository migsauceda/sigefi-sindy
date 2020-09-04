<?php
    session_start();  
    
    include("../clases/class_conexion_pg.php");
    
    $arrFiscal= $_POST['CodFiscal'];
    $arrFiscal= substr($arrFiscal,1);
    
    $arrDenunciado= $_POST['CodImputado'];    
    $arrDenunciado= substr($arrDenunciado,0);
    $usuario= $_SESSION['usuario'];
    
    $DenunciaId= $_POST['txtDenunciaId'];
    $fecha= substr($_POST['txtFechaAsignacion'],6,4)
            .substr($_POST['txtFechaAsignacion'],3,2)
            .substr($_POST['txtFechaAsignacion'],0,2);    
    
    $objConexion= new Conexion();
    
    $sql= "SELECT fiscal_asignar("
        ."array[".$arrFiscal."], "
        ."'".$DenunciaId."', "
        ."array[".$arrDenunciado."], "
        ."'".$fecha."', "
        ."'".$usuario."' "
        .");";        

//        exit($sql);        
    $Reg= pg_fetch_array($objConexion->ejecutarComando($sql));  
    
    $codigo= $Reg['codigo'];
    if($codigo== 0){
        echo "<script type='text/javascript'> alert('Asignación exitosa');</script>";
    }
    else{
        $Error= "Error: ".$Reg['descripcion'];
        echo "<script type='text/javascript'> alert($Error);</script>";
    }
?>