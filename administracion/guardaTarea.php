<?php
		include("../clases/class_conexion_pg.php");
		//iniciar e instanciar conexion
		$conexion=new Conexion();
		$tarea=$_GET['tarea'];
		
		$consulta="select mini_sedi.agregartarea('".$tarea."')";
		
		$sqlp=$conexion->ejecutarProcedimiento($consulta);
?>