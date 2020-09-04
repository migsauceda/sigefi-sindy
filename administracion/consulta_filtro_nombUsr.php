<?php
		include("../clases/class_conexion_pg.php");
		//iniciar e instanciar conexion
		$conexion=new Conexion();
		//obtener el recuroso id
		$filtro=strtoupper($_GET['filtro']);
                $campo=$_GET['campo'];		
		               
		$filtro=strtoupper($filtro);		              
                
                if($campo=='usr'){
                    $consulta="select * from mini_sedi.tbl_usuarios where upper(usuario) like'%".$filtro."%'";
                    $var1= "<select id=\"cboUsuario\" name=\"cboUsuario\" size=\"5\" multiple ";
                    $var2= "style=\"width:100%\" onChange=\"mostrarNombreUsr('usr')\" >";
                }elseif ($campo=='nombre') {
                    $consulta="select * from mini_sedi.tbl_usuarios where upper(nombres) like'%".$filtro."%'";
                    $var1= "<select id=\"cboNombre\" name=\"cboNombre\" size=\"5\" multiple ";
                    $var2= "style=\"width:100%\" onChange=\"mostrarNombreUsr('nombre')\" >";
                }elseif ($campo== 'apellido') {
                    $consulta="select * from mini_sedi.tbl_usuarios where upper(apellidos) like'%".$filtro."%'";
                    $var1= "<select id=\"cboApellido\" name=\"cboApellido\" size=\"5\" multiple ";
                    $var2= "style=\"width:100%\" onChange=\"mostrarNombreUsr('apellido')\" >";
                }

                $sqlp=$conexion->ejecutarComando($consulta);  
                
		echo $var1.$var2;
		while($row = pg_fetch_assoc($sqlp)){
			echo " <option value='$row[usuario]'>$row[nombres]</option>";
		}
		echo "</select>";   
?>