<?php
include "conexion.php";
echo $idac=$_GET["id"];
echo $usuario=$_GET["usuario"];
$sql="UPDATE mini_sedi.tbl_agenda
	SET
    activo=0
	WHERE
    agendaid=$idac";
pg_query($sql);
 header("location:agenda.php?usuario=$usuario");
 ?>
