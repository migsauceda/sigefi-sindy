<?php
if (!isset($_GET["accion"]))
{
	return;
}

if (($_GET["accion"]== "modificar")) //modificar
{
	CrearCookee($_POST['txtDenunciaid']); 
	echo "<script>window.location='../generales/modificargenerales.php?modificar=modificar&denunciaid=".$_POST['txtDenunciaid']."</script>";
}


  function CrearCookee($value)
  {
	if(!empty($_COOKIE["denuncia"]))
	{
		setcookie("denuncia","");
		setcookie("accion","");
	}

	if (!setcookie("denuncia",$value,time() + 3600,"/")){
		echo "Error al crear Cookee";
	}
	if (!setcookie("accion","modificar",time() + 3600,"/")){
		echo "Error al crear Cookee";
	}
  }	

  function CrearCookeeTarea($value)
  {
	if (!setcookie("Tarea",$value,time() + 3600,"/")){
		echo "Error al crear Cookee";
	}
  }

  function TraerCookee($value)
  {
	$galleta= $_COOKIE[$value];
  }
	
  function BorrarCookee()
  {
	if (!setcookie("denuncia","",time() + 3600,"/")){
		echo "Error al crear Cookee";
	}
	if (!setcookie("accion","",time() + 3600,"/")){
		echo "Error al crear Cookee";
	}	
  }
?>