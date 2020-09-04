<?php
include "conexion.php";
$activida =$_POST["actividad"];
$horainicio =$_POST["horainicio"];
$horafin =$_POST["horafin"];
$fecha_act=$_POST["fecha_act"];
$expediente=$_POST["expediente"];
$desc=$_POST["desc"];
$fiscal=$_POST["fiscal"];
$color_grupo="#a3c6ff";
$activo=1;

$recordatorio="";
$fecha_alarma="";
if (isset($_POST["recordatorio"])) {
    if(!empty($_POST["recordatorio"])){
      $fecha_alarma=",fecha_alarma";
      $recordatorio=",'".$_POST["recordatorio"]."'" ;
    }
    else {

    }
}

 $sql="INSERT INTO mini_sedi.tbl_agenda(
hora_inicio, hora_fin,actividad,fecha_actividad,expediente,descripcion,fiscal,activo,color_grupo,estado $fecha_alarma)
VALUES ('$horainicio', '$horafin', '$activida','$fecha_act','$expediente','$desc','$fiscal','$activo','$color_grupo','1' $recordatorio)";

  pg_query($sql);
  header("location:agenda.php?usuario=$fiscal");
?>
