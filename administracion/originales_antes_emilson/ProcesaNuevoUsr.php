<?php
session_start();

include_once("../clases/class_conexion_pg.php");
include_once("../funciones/php_funciones.php");

//parametros del formulario
$Propio=$_POST['NomPropio'];
$Usr=   $_POST['NomUsr'];
$Depto= $_POST['cboDependencia'];
$Accion=$_POST['txtAccion'];
$Bandeja= $_POST['txtBandeja'];
$BandejaId= $_POST['cboUsaBandeja'];


//crear nuevo password, sin encriptar
//$clave= CadenaRandom(8,true,true,false);

//temporalmete deshabilitado el random
$clave= $Usr;

//generar nueva clave, segun funcin hash, encriptar
$PassCript= clave($clave, false);

//guardar
$oConeccion= new Conexion();
        
if ($Bandeja== 'NoBandeja')
    $BandejaId= 0;
    
$sql="";
if ($Accion== 'crear'){
    $sql= "select usuario_nuevo("
        ."'".$Propio."', "
        ."'".$Usr."', "
        ."'".$PassCript."', "
        .$Depto.", "
        .$BandejaId.");";
}    

if ($Accion== 'generar'){
    $sql= "select usuario_reset_paswd("
        ."'".$Propio."', "
        ."'".$Usr."', "
        ."'".$PassCript."', "
        .$Depto.");";   
}    

//exit($sql);
$reg= $oConeccion->ejecutarProcedimiento($sql);
$valor= pg_fetch_array($reg);
if($valor[0]== 'f'){
    $rsp= pg_last_error($oConeccion);
    echo '<script type="text/javascript">
          alert("Error al crear usuario: '
          .$rsp.'");'
         .'</script>';
}
else{
    echo '<script type="text/javascript">alert("Usuario creado con clave: '
         . $clave . '");</script>';
}

echo
"<script>
location.href='../administracion/AdmonUsr.php';
</script>";
?>
