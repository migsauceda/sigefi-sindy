<?php 
//El resultado debe de ser una consulta con dos columnas una que guarda los codigos y otra para las etiquetas o descripciones
function combo($nombreCombo,$resultado,$campoValor,$campoEtiqueta,$valorDefecto=NULL,$propiedades=""){
	echo "<select name='".$nombreCombo."' id='".$nombreCombo."' ".$propiedades.">";
	if ($resultado== null) return;
	echo "<option value='0'>Seleccione...</option>";
	while($fila=pg_fetch_array($resultado)){		
		echo "<option value='".$fila[$campoValor]."'";
		if(isset($_POST[$nombreCombo])) if($fila[$campoValor]==$_POST[$nombreCombo]) echo "selected='selected'"; 
		if(isset($valorDefecto) && !isset($_GET["postback"])) if($fila[$campoValor]== $valorDefecto)  echo "selected='selected'";
		echo " >".$fila[$campoEtiqueta]."</option>";
	}
	echo "</select>";
}
?>