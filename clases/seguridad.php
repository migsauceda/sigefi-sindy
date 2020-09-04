<?php
session_start();
//validar si es posible para un $usr logeado, hacer una tarea tarea

include_once("class_conexion_pg.php");

function TareaValida($tarea)
{
//conocer usuario
$usr= $_SESSION['usuario'];

//conocer las tareas, convirtiendolas en arreglo
$sql= "select tarea from tbl_rol_tarea r, tbl_usr_rol u "
	."where r.rolid= u.rolid and usuario= '".$usr."' and tarea= ".$tarea.";";

$objConexion= new Conexion();
$Cursor= $objConexion->ejecutarComando($sql);
$Rol= pg_fetch_array($Cursor);

if (empty($Rol[tarea]))
	return false;
else
	return true;
}
?>