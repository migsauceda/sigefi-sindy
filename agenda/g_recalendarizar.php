<?php
include "conexion.php";
$actividad =$_POST["actividad"];
$fecha_actividad =$_POST["reasignacion"];
$fiscal=$_POST["fiscal"];
$sql="UPDATE mini_sedi.tbl_agenda
SET fecha_actividad ='$fecha_actividad'
WHERE agendaid=$actividad;";
pg_query($sql);



$fechaModificacion=date("Y-m-d");
  $sql2="INSERT INTO mini_sedi.tbl_agenda_historico(
  fiscal,
  fecha_actividad,
  agendaid,
    fecha_modificacion)
	VALUES ('$fiscal','$fecha_actividad','$actividad','$fechaModificacion')";
  pg_query($sql2);
header("location:agenda.php?usuario=$fiscal");

?>
