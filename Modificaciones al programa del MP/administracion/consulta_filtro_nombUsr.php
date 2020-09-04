<?php
		include("../clases/class_conexion_pg.php");
		//iniciar e instanciar conexion
		$conexion=new Conexion();
		//obtener el recuroso id
		$filtro=strtoupper($_GET['filtro']);
				
		$consulta="select * from tbl_usuarios where upper(nombreapellido) like'%".$filtro."%'";
		
		$filtro=strtoupper($filtro);
		$sqlp=$conexion->ejecutarComando($consulta);
		echo "<select id=\"cboNombre\" name=\"cboNombre\" size=\"5\" multiple style=\"width:100%\" onChange=\"mostrarNombreUsr()\">";
		while($row = pg_fetch_assoc($sqlp)){
			echo " <option value='".$row['nombreapellido']."'>".$row['nombreapellido']."</option>";
		}
		echo "</select>";
?>