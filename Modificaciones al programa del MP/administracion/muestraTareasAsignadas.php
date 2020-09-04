<?php
		include("../clases/class_conexion_pg.php");
		//iniciar e instanciar conexion
		$conexion=new Conexion();
		$rol=$_GET['rol'];
		
		$consulta="select * from tbl_tarea";
		$sqlTarea=$conexion->ejecutarComando($consulta);
		
		$consulta="select * from tbl_rol_tarea where rolid='$rol'";
		$sqlRolTarea=$conexion->ejecutarComando($consulta);
		$tareasAsignadas=array();
		
		$i=0;
		while ($row=pg_fetch_assoc($sqlRolTarea)){
			$tareasAsignadas[$i]=$row['tarea'];
			$i++;
		}
		
		echo "<select id='cboTareasAsignadas' name='cboTareasAsignadas' size='7' multiple style='width:100%'>";
		
		while ($row=pg_fetch_assoc($sqlTarea)){
			//for para agregar al combo box las tareas asignadas al rol
			for ($i=0; $i<sizeof($tareasAsignadas);$i++){ 
				if ($row['tareaid']==$tareasAsignadas[$i]){
					echo "<option value='$row[tareaid]'>$row[descripcion]</option>";
				}
			}
		}
		
		echo "</select>";
?>