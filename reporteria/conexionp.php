<?php 

	$conexion = pg_connect("dbname=sigefi user=mini_sedi_login password=(m1n1*cd1) port=5432 host=localhost")
							or die("No se conecto".pg_last_error());

	function ejecutarQuery($query){

      global $conexion;
      return $resultado = pg_query($conexion, $query);
  	}    
  	
 ?>