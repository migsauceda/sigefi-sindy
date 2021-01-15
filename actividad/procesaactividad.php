<?php
    session_start();

    include("../clases/class_conexion_pg.php");

    if(isset($_SESSION['denunciaid'] ))
    { 
        $objConexion= new Conexion();

        //campos agrabar
        $gall= $_SESSION['denunciaid']; //denuncia
        $FiscalId= $_POST['txtFiscalid']; //fiscal

        //viene con este formato:  27/04/2011  y se transfroma a 20110427
        $value= $_POST["txtFecha"];
        $FechaAnsi= substr($value,6,4).substr($value,3,2).substr($value,0,2);     

        $HoraAnsi= substr($value,11,2).':'.substr($value,14,2);

        $Materia= $_POST["cboMateria"]; //una sola materia
        $Etapa= $_POST["cboEtapa"];//una sola etapa
//        $Etapa= $_POST["cboEtapa"];//una sola etapa
//        $SubEtapa= $_POST["cboSubEtapa"]; //listado de subetapas
        $SubEtapa= 0;
        $Actividad= $_POST["txtTodosActividades"]; //listado de actividad
        $tmp= str_replace(";", ",",$Actividad);
        $tam= strlen($tmp);
        if (substr($tmp, $tam-1,1)== ",") 
              $tmp= substr($tmp,0, $tam-1);
         
        

        $Delito= $_POST["txtDelito"]; //listado de delitos
        $Imputados= $_POST["txtImputados"];
        $desc = $_POST["desc"]; //descripcion del anexo

        //if (empty($SubEtapa)) $SubEtapa= 0;
       // if (empty($Actividad)) $Actividad= 0;

        $nombre = $_FILES['archivoa']['name']; //este es el nombre del archivo que acabas de subir
        $type =$_FILES['archivoa']['type']; //este es el tipo de archivo que acabas de subir
        $tmp_name = $_FILES['archivoa']['tmp_name'];//este es donde esta almacenado el archivo que acabas de subir.
        $size = $_FILES['archivoa']['size']; //este es el tamaño en bytes que tiene el archivo que acabas de subir.
        $error = $_FILES['archivoa']['error']; //este almacena el codigo de error que resultaría en la subida.
/*
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
        $array=  substr($array, 1);
*/
        $sqlmax = "SELECT max(iddoc) as maximo  FROM mini_sedi.tbl_documentos;";
        $resultado = $objConexion->ejecutarComando($sqlmax) or die ("No se pudo insertar los datos en la base de datos.");
        $numReg = pg_num_rows($resultado);
        if($numReg>0){
            while($fila=pg_fetch_array($resultado))
            {
               $ide = $fila["maximo"];
            }
        }else {$ide = 0;}

        $id = $ide + 1;    
                    # Contenido del archivo
        $fp = fopen($tmp_name, "rb");
        $buffer = fread($fp, filesize($tmp_name));
        fclose($fp);

        # Descripción de la foto
        $desc = $_POST["desc"];

        # Escapa el contenido del archivo para ingresarlo como bytea
        $buffer=pg_escape_bytea($buffer);


        $sql= "SELECT mini_sedi.actividad_delito_insert("
                ."array[".$Delito."], " //delitos
                ."array[".$tmp."], " //actividad listado
                ."array[".$Imputados."], " //imputados listado
                ."'".$FiscalId."', " //fiscal
                
                .$Materia.", " //materia             
                ."'".$FechaAnsi."', "
                .$Etapa.", " //etapa
                .$gall.", " //denuncia
                
                ."array[".$SubEtapa."], "
                ."'".$HoraAnsi."', "                
                ."'1221', "                
                .$id.", " //
                
                ."'".$desc."', "
                ."'".$buffer."', "
                ."'".$type."', " 
                .$size.", "
                ."true "
                .");";
           //exit($sql);
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
