<?php 

	function tabla($nombreTabla,$resultado,$titulos,$nombreCampos,$accion,$propiedades="",$linkEliminar="",$linkModificar=""){
			echo "<table name='".$nombreTabla."' ".$propiedades.">\n";
			//imprimir Encabezados
			echo "<tr style='background-color:#000 ; color:#FFF'>";
			for($i=0;$i<count($titulos);$i++){
				echo "<td><b>".htmlentities(utf8_decode($titulos[$i]))."</b></td>";
			}
			if($accion) echo "<td align='center'>Acci&oacute;n</td>";
			echo "</tr>\n";	

			//imprimir contenido
			while($registro=pg_fetch_array($resultado)){
				echo "<tr>";
				for($i=0;$i<count($nombreCampos);$i++){
					echo "<td>".htmlentities(utf8_decode($registro[$nombreCampos[$i]]))."</td>";	
				}
				if($accion) echo "<td align='center'><a href='".$linkEliminar."?codigo=".$registro[$nombreCampos[0]]."'>X</a> <a href='".$linkModificar."?codigo=".$registro[$nombreCampos[0]]."'>M</a></td>";
				echo "<tr>\n";

			}

			echo "</table>\n";
	}

?>
