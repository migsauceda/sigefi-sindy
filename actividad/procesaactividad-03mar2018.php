<?php
        session_start();
        
	include("../clases/class_conexion_pg.php");
        
	if(isset($_SESSION['denunciaid'] ))
	{ 
                $gall= $_SESSION['denunciaid'];
		$objConexion= new Conexion();
                   
                $desc = $_POST["desc"];
             
                
                //viene con este formato:  27/04/2011  y se transfroma a 20110427
                $value= $_POST[txtFecha];
                $FechaAnsi= substr($value,6,4).substr($value,3,2).substr($value,0,2);     
    
                $HoraAnsi= substr($value,11,2).':'.substr($value,14,2);
              
                //evitar q campos opcionales queden en blanco
                $SubEtapa= $_POST[cboSubEtapa];                
                $actividad= $_POST[cboActividad];
                
                if (empty($SubEtapa)) $SubEtapa= 0;
                if (empty($actividad)) $actividad= 0;
                
                $nombre = $_FILES['archivoa']['name']; //este es el nombre del archivo que acabas de subir
                $type =$_FILES['archivoa']['type']; //este es el tipo de archivo que acabas de subir
                $tmp_name = $_FILES['archivoa']['tmp_name'];//este es donde esta almacenado el archivo que acabas de subir.
                $size = $_FILES['archivoa']['size']; //este es el tamaño en bytes que tiene el archivo que acabas de subir.
                $error = $_FILES['archivoa']['error']; //este almacena el codigo de error que resultaría en la subida.

                
                if ( !empty($_POST['como']) && is_array($_POST['como']) ) {
                        $cant = array();
                        $print = array();
                        $array= "";
                        $i =0;

                        foreach ( $_POST['como'] as $como ) { 
                                $cant[$i] = $como;
                                $i++;
                         }
                        for($j=0;$j<$i;$j++) { 
                                $array = $array.",".$cant[$j]; 
                }}
//               if (isset($_POST['como']))
//                {
//                    $delito = $_POST['como'];
//                    $n        = count($delito);
//                    $i        = 0;
//
//                    
//                         "<ol>";
//                    while ($i < $n)
//                    {
//                       echo "<li>{$delito[$i]}</li>";
//                       $i++;
//                    }
//                    echo "</ol>";
//                 }
                $array=  substr($array, 1);
             
                
//                $msj= "delitos: array[".$array."],<br> actividad : $actividad,<br> Imputado: $_POST[cboImputado],<br> 
//                        fiscal: '$_POST[txtFiscalid]',<br> Materia $_POST[cboMateria],<br>Fecha:'$FechaAnsi',<br>
//                        Etapa: $_POST[cboEtapa],<br>Denuncia: $gall,<br>SubEtapa: $SubEtapa,<br>Hora: '$HoraAnsi',<br>
//                        IP: '1221';<br><br>Archivo<br><br> 
//                        Descripcion:$desc,<br> Tipo: $type,<br>Size: $size,<br> Nombre: $nombre,<br>Tmp_Name $tmp_name.";
//                exit($msj);
                
                $sqlmax = "SELECT max(iddoc) as maximo  FROM mini_sedi.tbl_documentos;";
  $resultado = $objConexion->ejecutarComando($sqlmax) or die ("No se pudo insertar los datos en la base de datos.");
$numReg = pg_num_rows($resultado);
if($numReg>0){
while($fila=pg_fetch_array($resultado))
{
   $ide = $fila["maximo"];
}}else {$ide = 0;}
        $id = $ide + 1;    
		# Contenido del archivo
	  $fp = fopen($tmp_name, "rb");
  	$buffer = fread($fp, filesize($tmp_name));
		fclose($fp);
		
		# Descripción de la foto
		$desc = $_POST["desc"];
		
			# Escapa el contenido del archivo para ingresarlo como bytea
			$buffer=pg_escape_bytea($buffer);
			

                $sql= "SELECT actividad_delito_insert("
                        ."array[".$array."], "
                        .$actividad.", "
                        .$_POST[cboImputado].", "
                        ."'".$_POST[txtFiscalid]."', "
                        .$_POST[cboMateria].", "
                        ."'".$FechaAnsi."', "
                        .$_POST[cboEtapa].", "
                        .$gall.", " 
                        .$SubEtapa.", "
                        ."'".$HoraAnsi."', "
                        ."'1221', "
                        .$id.", " 
                        ."'".$desc."', "
                        ."'".$buffer."', "
                        ."'".$type."', " 
                        .$size.", "
                        ."true "
                        .");";
     //           exit($sql);
		$objConexion= new Conexion();
                $reg= $objConexion->ejecutarComando($sql);
                 
                        $mostrar= '<script type="text/javascript">';
                        $mostrar.= 'alert("Registro guardado")';
                        $mostrar.= '</script>';
        echo $mostrar; 
                 
	}
	else //cookies
	{
		echo"<script type='text/javascript'>
			alert(\"Error al guardar, NO se pudo acceder a las COOKIEs \\nintentelo nuevamente\");
		</script>";
	}

?>