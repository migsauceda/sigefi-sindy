<?php 
//El resultado debe de ser una consulta con dos columnas una que guarda los codigos y otra para las etiquetas o descripciones
function combo($nombreCombo,$resultado,$campoValor,$campoEtiqueta,$primeraEtiqueta="-Seleccione Opcion-",$valorDefecto=NULL,$propiedades=""){
	echo "<select name='".$nombreCombo."' ".$propiedades.">";
	echo "<option value=''>-".$primeraEtiqueta."-</option>";
	while($fila=pg_fetch_array($resultado)){		
		echo "<option value='".$fila[$campoValor]."'";
		if(isset($_POST[$nombreCombo])) if($fila[$campoValor]==$_POST[$nombreCombo]) echo "selected='selected'"; 
		if(isset($valorDefecto) && !isset($_GET["postback"])) if($fila[$campoValor]== $valorDefecto)  echo "selected='selected'";
		echo " >".utf8_encode(htmlentities($fila[$campoEtiqueta]))."</option>";
	}
	echo "</select>";
}
?>