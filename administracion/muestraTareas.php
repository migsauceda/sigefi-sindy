<?php
		include("../clases/class_conexion_pg.php");
		//iniciar e instanciar conexion
		$conexion=new Conexion();
		$rol=$_GET['rol'];
		
		$consulta="select * from mini_sedi.tbl_tarea";
		$sqlTarea=$conexion->ejecutarComando($consulta);
		
		$consulta="select * from mini_sedi.tbl_rol_tarea where rolid='$rol'";
		$sqlRolTarea=$conexion->ejecutarComando($consulta);
		$tareasAsignadas=array();
		
		$i=0;
		while ($row=pg_fetch_assoc($sqlRolTarea)){
			$tareasAsignadas[$i]=$row['tarea'];
			$i++;
		}
		
		echo "<select id='cboTareas' name='cboTareas' size='7' multiple style='width:100%'>";
		
		$asignada=false;
		while ($row=pg_fetch_assoc($sqlTarea)){
			//for para verificar si la tarea ha sido asignada al rol
			for ($i=0; $i<sizeof($tareasAsignadas);$i++){ 
				if ($row['tareaid']==$tareasAsignadas[$i]){
					$asignada=true;
				}
			}
			
			if ($asignada==false){
				echo "<option value='$row[tareaid]'>$row[descripcion]</option>";
			}
			$asignada=false;
		}
		
		echo "</select>";
?>