<?php
		include("../clases/class_conexion_pg.php");
		//iniciar e instanciar conexion
		$conexion=new Conexion();
		$rol=$_GET['rol'];
		$valor=$_GET['valor'];
		$cantidadTareas=$_GET['cantidadTareas'];
		
		if ($valor=="una"){
			$tarea=$_GET['tarea'];
			//$consulta="delete from tbl_rol_tarea where rolid=$rol and tarea=$tarea";
			$consulta="delete from mini_sedi.tbl_rol_tarea where tarea=$tarea and rolid= $rol";
			$sqlTarea=$conexion->ejecutarProcedimiento($consulta);
		}else {
			$i=0;
			for ($i=0;$i<$cantidadTareas;$i++){
				$tarea=$_GET['tarea'.$i];
				//$consulta="delete from tbl_rol_tarea where rolid=$rol and tarea=$tarea";
				$consulta="select mini_sedi.borrar_tarea_rol ($tarea, $rol)";
				
				$sqlTarea=$conexion->ejecutarProcedimiento($consulta);	
			}
		}		
?>