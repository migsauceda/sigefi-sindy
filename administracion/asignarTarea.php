<?php
		include("../clases/class_conexion_pg.php");
		//iniciar e instanciar conexion
		$conexion=new Conexion();
		$rol=$_GET['rol'];
		$valor=$_GET['valor'];
//		$cantidadTareas=$_GET['cantidadTareas'];
		
		if ($valor=="una"){
			$tarea=$_GET['tarea'];
			//$consulta="insert into tbl_rol_tarea (rolid, tarea) values ($rol, $tarea)";
			$consulta="select mini_sedi.agregartarearol ($tarea, $rol)";
			$sqlTarea=$conexion->ejecutarProcedimiento($consulta);
		}else {
			$i=0;
			for ($i=0;$i<$cantidadTareas;$i++){
				$tarea=$_GET['tarea'.$i];
				//$consulta="insert into tbl_rol_tarea (rolid, tarea) values ($rol, $tarea)";
				$consulta="select mini_sedi.agregartarearol ($tarea, $rol)";
				$sqlTarea=$conexion->ejecutarProcedimiento($consulta);	
			}
		}		
?>