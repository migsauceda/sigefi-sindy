<?php 
//El resultado debe de ser una consulta con dos columnas una que guarda los codigos y otra para las etiquetas o descripciones
function radio($nombreRadio,$etiqueta,$valor,$chekeado=false,$propiedades=""){	
	echo "<label><input type='radio' name='".$nombreRadio."' id='".$nombreRadio."'   value='".$valor."'";
	if (isset($_POST[$nombreRadio])) if ($_POST[$nombreRadio]==$valor) echo " checked='true' ";
	if($chekeado==true && !isset($_GET["postback"]))  echo " checked='true' ";
	echo $propiedades." />".$etiqueta."</label>";		
}
?>