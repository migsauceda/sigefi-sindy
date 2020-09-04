<?php
session_start();

include_once("../clases/class_conexion_pg.php");
include_once("../funciones/php_funciones.php");

//parametros del formulario
$Nombre= $_POST['NomPropio'];
$Apellido= $_POST['ApePropio'];
$Usr= $_POST['NomUsr'];
$contrasena= $_POST['pass'];
$CambioClave= 'false';
$VenceClave= '20170101';
$Identidad=$_POST['identidad'];
$BandejaId= $_POST['cboUsaBandeja'];
$SubBandejaId= $_POST['cboSubBandeja'];


$Rol= $_POST['cboPerfil'];
if ($_POST['chkFiscal']== 'Fiscal'){
    $Fiscal= 'true';
}
else{
    $Fiscal= 'false';
}

if (isset($_POST['chkUsrActivo'])){
    $Activo= 'true';
}
else{
    $Activo= 'false';
}

$clave= $contrasena;

//generar nueva clave, segun funcin hash, encriptar
$PassCript= clave($clave, false);

//guardar
$oConeccion= new Conexion();
            
$sql="";
$Accion= $_POST[txtAccion];

if ($Accion== 'crear'){  //crear usr nuevo
    $sql= "select codigo, descripcion from mini_sedi.usuario_nuevo("
        ."'".$Usr."', "
        ."'".$PassCript."', "
        ."'".$Nombre."', "
        ."'".$Apellido."', "
        .$CambioClave.", "
        .$BandejaId.", "
        ."'".$Identidad."', "
        ."'".$VenceClave."', "
        .$SubBandejaId.", "
        .$Rol.","
        .$Fiscal.");";
    
//    exit($sql);
}    

if ($Accion== 'generar'){  //cambiar passwd
    $sql= "select codigo, descripcion from mini_sedi.usuario_clave("
        ."'".$Usr."', "
        ."'".$PassCript."');";   
}    

if ($Accion== 'actualizar'){  //actualiar perfil
    $sql= "select codigo, descripcion from mini_sedi.usuario_perfil("
        ."'".$Usr."', "
        .$BandejaId.", "
        .$SubBandejaId.", "
        .$Rol.", "
        .$Fiscal.");";
}

if ($Accion== 'inactivar'){  //inactivar usr
    if ($Activo== 'true'){
        $sql= "select codigo, descripcion from mini_sedi.usuario_activar("
            ."'".$Usr."',true);";
    }
    else{
        $sql= "select codigo, descripcion from mini_sedi.usuario_activar("
            ."'".$Usr."',false);";        
    }
}

//exit($sql);
$reg= $oConeccion->ejecutarComando($sql);
$valor= pg_fetch_array($reg);
$cadena_err= $valor['descripcion'];
$cadena_err= str_replace("\"", "", $cadena_err);
$codigo_err= $valor['codigo'];

$cadena= "../administracion/AdmonUsr.php?codigo=$codigo_err&descripcion=$cadena_err";
//exit($cadena);

echo
"<script>
location.href='$cadena';
</script>";
//185-2013
?>