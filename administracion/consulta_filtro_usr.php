<?php
		include("../clases/class_conexion_pg.php");
		//iniciar e instanciar conexion
		$conexion=new Conexion();
		//obtener el recuroso id
		$filtro=strtoupper($_GET['filtro']);
				
		$consulta="select * from mini_sedi.tbl_usuarios where upper(usuario) like'%".$filtro."%'";
		
		$filtro=strtoupper($filtro);
		$sqlp=$conexion->ejecutarComando($consulta);
		echo "<select id=\"cboUsuario\" name=\"cboUsuario\" size=\"5\" multiple style=\"width:100%\" onChange=\"mostrarNombreUsr('usr')\">";
//		echo "<select id=\"cboNombre\" name=\"cboNombre\" size=\"5\" multiple style=\"width:100%\" onChange=\"mostrarNombreUsr(".$row['usurio'].")\">";                
		while($row = pg_fetch_assoc($sqlp)){
			echo " <option value='".$row['usuario']."'>".$row['usuario']."</option>";
		}
		echo "</select>";
?>