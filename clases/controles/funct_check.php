<?php 
//El resultado debe de ser una consulta con dos columnas una que guarda los codigos y otra para las etiquetas o descripciones
function checkbox($nombreCheck,$etiqueta,$valor,$chekeado=false,$propiedades=""){	
	echo "<label><input type='checkbox' id='".$nombreCheck."' name='".$nombreCheck."' value='".$valor."'";
	if (isset($_POST[$nombreCheck])) echo " checked='checked' ";	
	if($chekeado==true && !isset($_GET["postback"]))  echo " checked='checked' ";
	echo $propiedades." />".$etiqueta."</label>";	
//echo	$_POST[$nombreCheck];
}
?>