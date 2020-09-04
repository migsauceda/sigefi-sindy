<?php
		include("../clases/class_conexion_pg.php");
		//iniciar e instanciar conexion
		$conexion=new Conexion();
		//obtener el recuroso id
		$filtro=strtoupper($_GET['filtro']);
				
		$consulta="select * from tbl_usuarios where upper(usuario) like'%".$filtro."%'";
		
		$filtro=strtoupper($filtro);
		$sqlp=$conexion->ejecutarComando($consulta);
		echo "<select id=\"cboUsuario\" name=\"cboUsuario\" size=\"5\" multiple style=\"width:100%\" onChange=\"mostrarUsr()\">";
		while($row = pg_fetch_assoc($sqlp)){
			echo " <option value='".$row['usuario']."'>".$row['usuario']."</option>";
		}
		echo "</select>";
?>