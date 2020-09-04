<?php 	
                session_start();
		include_once("clases/class_conexion_pg.php");
		$objConexion=new Conexion();
		$usuario=$_SESSION['usuario'];
		$resultado=$objConexion->ejecutarComando("SELECT usuario,contrasena FROM tbl_usuarios WHERE usuario='".$usuario."';");
		$JSON="";
		$autorizado=false;
		if(pg_num_rows($resultado)<=0){
			$JSON="{existe:false}";			
			header("Location:index.php");				
		}else{
			$registro=pg_fetch_array($resultado);
			if( $_COOKIE["contrasena"] == crypt($registro["contrasena"],"garchado")){
				$JSON="{existe:true}";
				
			}else{
				$JSON="{existe:false}";
				header("Location:error/");			
			}			
		}
?>
