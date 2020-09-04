<?php
include "conexion.php";
$actividad =$_POST["actividad"];
$fiscal =$_POST["fiscal"];
$fiscal1 =$_POST["fiscal1"];
echo $sql="UPDATE mini_sedi.tbl_agenda
 SET fiscal='$fiscal'
 WHERE agendaid=$actividad;";
pg_query($sql);
header("location:agenda.php?usuario=$fiscal1");
?>
