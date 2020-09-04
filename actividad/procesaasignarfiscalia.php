<?php
    session_start();  

    include("../clases/class_conexion_pg.php");

    $arrFiscalia= $_POST['CodFiscalia'];
    $arrFiscalia= substr($arrFiscalia,1);
 
    $arrDenunciado= $_POST['CodImputado'];    
    $arrDenunciado= substr($arrDenunciado,1);
    $usuario= $_SESSION['usuario'];
    
    $DenunciaId= $_POST['txtDenunciaId'];
    $fecha= substr($_POST['txtFechaAsignacion'],6,4)
            .substr($_POST['txtFechaAsignacion'],3,2)
            .substr($_POST['txtFechaAsignacion'],0,2);    
    
    $objConexion= new Conexion();

    $sql= "SELECT fiscalia_asignar("
        ."array[".$arrFiscalia."], "       
        .$DenunciaId.", "
        ."array[".$arrDenunciado."], "
        ."'".$fecha."', "
        ."'".$usuario."' "
        .");";        

//exit($sql);
    $Reg= pg_fetch_array($objConexion->ejecutarComando($sql));  

    if ($Reg[0]= 't') //exito
    {
            echo "<script type='text/javascript'>";
            echo "alert('Asignación exitosa');";
            echo "</script>";
    }
    else
    {
            echo "<script type='text/javascript'>";
            echo "alert('Error al asignar fiscalía');";
            echo "</script>";        
    }
?>