<?php
include "conexion.php";

include("../clases/Usuario.php");
session_start();
if (isset($_SESSION['objUsuario'])){
		$objUsuario= $_SESSION['objUsuario'];
}
$usuarioactual=$objUsuario->getUsuario();

$idag=$_POST["idag"];
$activida =$_POST["actividad"];
$horainicio =$_POST["horainicio"];
$horafin =$_POST["horafin"];
$expediente=$_POST["expediente"];
$desc=$_POST["desc"];
$recordar=$_POST["recordatorio"];
$fiscal=$_POST["fiscal"];
$motivoedicion=$_POST["mot"];
$estado = $_POST["estado"];
$fechaactual= date("Y-m-d h:i:s");
$fecha_actividad = $_POST["fecha_act"];

if ($recordar=="") {
  $recordar='null';
  $fechaalarma=',fecha_alarma=';
}
else {

  $fechaalarma=',fecha_alarma=';
  $recordar="'$recordar'";
}
//color_grupo
switch ($estado) {
	case '1':
		$color='#a3c6ff';
		break;

	case '2':
		$color='#43c66b';
		break;

	case '3':
		$color='#ff68de';
		break;

	case '4':
		$color='#f9f613';
		break;

	case '5':
		$color='#ff5959';
		break;

	default:
		# code...
		break;
}


  $sql="UPDATE mini_sedi.tbl_agenda
	SET
  hora_inicio='$horainicio',
  hora_fin='$horafin',
  descripcion='$desc',
  actividad='$activida',
  expediente='$expediente',
  estado = '$estado',
	fecha_actividad='$fecha_actividad',
	color_grupo='$color'
	$fechaalarma  $recordar
	WHERE agendaid=$idag";
  pg_query($sql);

/*
----------------------------------------------------------
*/

  $sql2="INSERT INTO mini_sedi.tbl_agenda_historico(

  hora_inicio,
  hora_fin,
  descripcion,
  motivo_reasignacions,
  fiscal,
  fecha_alarma,
  actividad,
  expediente,
  agendaid,
  estado,
  fecha_modificacion,
	fecha_actividad,
	color_grupo )
	VALUES ('$horainicio','$horafin','$desc','$motivoedicion','$usuarioactual',$recordar,'$activida ','$expediente ','$idag','$estado','$fechaactual','$fecha_actividad','$color');";
    pg_query($sql2);
  header("location:agenda.php?usuario=$fiscal");
?>
