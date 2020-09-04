<?php
	include("../clases/class_conexion_pg.php");
	if(!empty($_COOKIE["denuncia"]))
	{
		$gall= $_COOKIE["denuncia"];
		$objConexion= new Conexion();

		//nuevo fiscal; OJO Etapa es 1 porke es el codigo d riesgo
		$sql= "insert into tbl_imputado_actividad (tdenunciaid, "
		."nactividadid, nactividad2, netapa, tpersonaid, cfiscalid, materiaid, dfecha) values ("
                .$gall.", "
		.$_POST[cboActividad].", "
                .$_POST[cboActividad2].", "
                ."1, "
		.$_POST[cboImputado].", "
		.$_POST[txtFiscalid].", "
		.$_POST[cboMateria].", "
		."'".$_POST[txtFecha]."');";

		$objConexion= new Conexion();
		if(!$objConexion->ejecutarComando($sql)){
			echo"<script type='text/javascript'>
			alert(\"Error al guardar los datos de actividad fiscal \\nintentelo nuevamente\");
			</script>";
		}
	}
	else //cookies
	{
		echo"<script type='text/javascript'>
			alert(\"Error al guardar, NO se pudo acceder a las COOKIEs \\nintentelo nuevamente\");
		</script>";
	}

?>