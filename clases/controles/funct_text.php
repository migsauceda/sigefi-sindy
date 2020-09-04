<?php 
//El resultado debe de ser una consulta con dos columnas una que guarda los codigos y otra para las etiquetas o descripciones
function cajaTexto($nombreText,$tamano,$texto=NULL,$propiedades=""){
	echo "<input type='text' name='".$nombreText."' id='".$nombreText."' size='".$tamano."' ";    
	if (isset($_POST[$nombreText])) echo " value='".utf8_encode(htmlentities($_POST[$nombreText]))."' ";
	if(isset($texto) && !isset($_GET["postback"])) echo " value='".utf8_encode(htmlentities($texto))."' ";
	echo $propiedades." />";
}
?>