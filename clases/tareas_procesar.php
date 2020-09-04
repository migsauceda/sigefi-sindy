<?php
include_once("class_conexion_pg.php");
function CrearTareas()
{
	$objConexion= new Conexion();
	
	$usuario= $usr;
	$sql= "select rolid from tbl_usr_rol where usuario="."'".$usuario."';";
	$Cursor= $objConexion->ejecutarComando($sql);	
	
	$TareaList="";
	while($Rol= pg_fetch_array($Cursor))
	{
		$sql= "select tarea from tbl_rol_tarea where rolid=".$Rol[rolid];
		$Cursor2= $objConexion->ejecutarComando($sql);

		while($Tarea= pg_fetch_array($Cursor2))
		{
			if ($TareaList== "")
			{
				$TareaList= $Tarea[tarea];
			}
			else
			{
				$TareaList= $TareaList."-".$Tarea[tarea];
			}
		}
		
	}
	$error= 0;
	if ($TareaList!="")
	{
		if (!setcookie("tarea",$TareaList,time() + 3600,"/")){
			$error= 1;
		}
	}
	else
	{
		$error= 1;
	}

	if ($error== 1)
	{
		echo
		"<script>
		alert('Error al cargar las tareas permitidas al usuario');
		</script>";
		
		$objConexion->cerrarConexion();
	}
	else
	{
		/*
		echo
		"<script>
		alert('Se cargo las tareas permitidas al usuario');
		</script>";
		*/
	}
}
?>