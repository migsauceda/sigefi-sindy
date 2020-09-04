<?php
//funciones genericas
include_once './clases/class_conexion_pg.php';
include_once './funciones/php_funciones.php';

session_start();
if (isset($_SESSION['usuario'])){
    //borrar registros en tabla control de estados, para que no quede denuncia pendiente    
    $Usr= $_SESSION['usuario'];
    $sql= "select controlestados_delete('".$Usr."',".$_SESSION['denunciaid'].");";
//    exit($sql);
    $objConexion= new Conexion();
    $rsp= $objConexion->ejecutarProcedimiento($sql);

    DestruirSesion();
    
    //destruir cookies
    setcookie("denuncia","",time()-3600);
    setcookie("accion","",time()-3600);	
    
    //borrar registro de conexion activa
    $sql= "delete from tbl_user_session where usuario= '".$Usr."';";
//    $objConexion= new Conexion();
    $rsp= $objConexion->ejecutarProcedimiento($sql);
    
    //registra salida de sesion en el log
    $sql= "insert into tbl_log_general (usuario, ip_address, time_date, descripcion) 
        values ('$Usr','".$_SERVER['REMOTE_ADDR']."', 'now()', 'Sale del Sistema');";
//    $objConexion= new Conexion();
    $rsp= $objConexion->ejecutarProcedimiento($sql);
    
    header("location:index.php");
} else {
    header("location:index.php");
}
?>
