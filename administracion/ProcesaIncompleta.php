<?php
session_start();

include_once("../clases/class_conexion_pg.php");

$oConeccion= new Conexion();

$Bandera= $_GET[banderah];
$Usr= $_SESSION['usuario'];

//cuando se inicia el programa o cuando se clikea nuevo
if ($Bandera== 1 || ($Bandera== 2))
{    
    $sql= "select * from tbl_controlestados where usr= '".$Usr."' and "
        ."(not generales or not denunciante or not denunciado or not ofendido);";
    $reg= $oConeccion->ejecutarComando($sql);
    if (pg_num_rows($reg) > 0) //tiene denuncias incompletas
    {
        $arr= pg_fetch_array($reg);
        $_SESSION['fecha']= $arr["fecha"];
        $_SESSION['denunciaid']= $arr["denuncia"];
        $_SESSION['generales']= $arr["generales"];
        $_SESSION['denunciante']= $arr["denunciante"];
        $_SESSION['denunciado']= $arr["denunciado"];
        $_SESSION['ofendido']= $arr["ofendido"];

        echo
        "<script>
            location.href='DenunciaPendiente.php';
        </script>";
    }
    else
    {
       if ($Bandera== 2)
       {
            echo
            "<script>
                location.href='../generales/generales.php';
            </script>";
       }
       else {
            echo
            "<script>
                location.href='../aplicacion.php';
            </script>";
       }
    }
}
else
{
    $Fecha= $_POST[fechah];
    $Accion= $_POST[accionh];

    //se decide no continuar con la denuncia
    if ($Accion== 0){
        $sql= "delete from tbl_controlestados where usr= '".$Usr."' and "
            ."fecha= '".$Fecha."';";
        if ($oConeccion->ejecutarComando($sql)){
            echo
            "<script>
                alert('Ya no tiene denuncias pendientes');
            </script>";

            echo
            "<script>
                location.href='../aplicacion.php';
            </script>";  
        }
    }
    else //se decide completar la denuncia
    {
            $_SESSION['incompleta']= 1;
            echo
            "<script>
                location.href='../aplicacion.php';
            </script>";  
    }
}//else inicio
?>
