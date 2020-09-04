<?php
    session_start();
    $imputado= $_POST['imputado'];
    include("../clases/class_conexion_pg.php");    
    $objConexion= new Conexion();
           $query = "SELECT  distinct(tbl_delito.ndelitoid) as idelito, tbl_delito.cdescripcion as descripcion
FROM   mini_sedi.tbl_imputado_delito,   mini_sedi.tbl_delito,   mini_sedi.tbl_imputado,   mini_sedi.tbl_imputado_fiscal, 
  mini_sedi.tbl_usuarios
WHERE   tbl_imputado_delito.tpersonaid = tbl_imputado.tpersonaid AND  tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
  tbl_imputado_fiscal.tdenunciaid = tbl_imputado_delito.tdenunciaid AND  tbl_imputado_fiscal.timputadoid = tbl_imputado_delito.tpersonaid AND
  tbl_imputado_fiscal.cfiscal = tbl_usuarios.identidad AND  tbl_imputado.tpersonaid = $imputado";
//                exit($query);
          $consulta= $objConexion->ejecutarComando($query);  
	
	
	// Comienzo a imprimir el select
	$i = 1;
	while($registro=pg_fetch_array($consulta))
	{
		// Convierto los caracteres conflictivos a sus entidades HTML correspondientes para su correcta visualizacion
		$registro[1]=htmlentities($registro[1]);
		// Imprimo las opciones del select
                echo "<input type='checkbox' name='como[]'  value='$registro[0]' checked>
                        <label for='select2'>".$registro['descripcion']."</label><br>";
                $i++;
       }	
?>
