<?php
//require_once '../clases/Persona.php';
require_once '../clases/Ofendido.php';

class ORM_Ofendido {

  public function ORM_Ofendido(){
	$objOfendido= new Ofendido;
  }

  public function GuardarOfendido($value, $copiado= "0")
  {      
//        session_start();
	//$objOfendido= new Denunciante;
	$objOfendido= $value;

	$usuario =$_SESSION['usuario'];
	$gall= $_SESSION['denunciaid'];
        $objOfendido->setDenunciaid($gall);

        //soundex para nombre
        $nombre_array= str_word_count($objOfendido->getNombreCompleto(), 1);
        
        for($i= 0; $i < count($nombre_array); $i++){
            if ($i== 0)
                $soundex_nombre= soundex($nombre_array[$i]);
            else
                $soundex_nombre= $soundex_nombre . ";" . soundex($nombre_array[$i]);            
        }  
        
        //soundex para apellido
        $nombre_array= str_word_count($objOfendido->getApellidoCompleto(), 1);
        
        for($i= 0; $i < count($nombre_array); $i++){
            if ($i== 0)
                $soundex_apellido= soundex($nombre_array[$i]);
            else
                $soundex_apellido= $soundex_apellido . ";" . soundex($nombre_array[$i]);            
        }

	//nota: falta nrelacionimputado ke se agrega despues mediante update
	$sql= "SELECT codigo, descripcion from ofendido_insert("
		.$gall.", "
		."'".$objOfendido->getIdentidad()."', "
		."'".$objOfendido->getNombreCompleto()."', "
		."'".$objOfendido->getApellidoCompleto()."', "
		."'".$objOfendido->getGenero()."', "
		.$objOfendido->getEstadoCivil().", "
		.$objOfendido->getProfesion().", "
		.$objOfendido->getOcupacion().", "
		.$objOfendido->getEscolaridad().", "
		."'".$objOfendido->getNacionalidad()."', "
		.$objOfendido->getGrupoEtnico().", "
		.$objOfendido->getDiscapacidad().", "
		.$objOfendido->getConocido().", "
		.$objOfendido->getEdad().", "
		."'".$objOfendido->getUmeDidaEdad()."', "
		."'".$objOfendido->getRangoEdad()."', "
		."'".$objOfendido->getDepartamentoid()."', "
		."'".$objOfendido->getMunicipioid()."', "
		."'".$objOfendido->getAldeaId()."', "
		."'".$objOfendido->getDetalle()."', "
		."'".$objOfendido->getBarrioId()."', "
		."'".$objOfendido->getOrientacionSex()."', "
		."'".$objOfendido->getTxtDireccion()."', "
		.$objOfendido->getPersonaId().", "
                ."'".$objOfendido->getTelefono()."', "
                .$objOfendido->getTipoDocumento().", "
		."'".$usuario."', "
		."'".$_SERVER['REMOTE_ADDR']."', "
                ."'".$soundex_nombre."', "
                ."'".$soundex_apellido."', "                 
                ."'".$objOfendido->getPersonaNatural()."', "
                ."'".$objOfendido->getNombreAsumido()."', "
                ."'".$objOfendido->getbApoderado()."', "
                ."'".$objOfendido->getApoderadoNombre()."', "
                ."'".$objOfendido->getApoderadoColegio()."', "
                ."'".$objOfendido->getRTN()."', "                
                ."'".$objOfendido->getEmbarazada()."', "
                ."'".$objOfendido->getFrecuencia()."', "
                ."'".$objOfendido->getTrabajoRemunerado()."', "
                ."'".$objOfendido->getAsisteCentroEducativo()."', "
                .$objOfendido->getNumeroHijos().", "
                ."'".$objOfendido->getIntentoSuicidio()."', "
                ."'".$objOfendido->getEnfermedadMental()."', "
                ."'".$objOfendido->getMecanismoMuerte()."', "            
                ."'".$objOfendido->getIntegraLGBTI()."' "
		.")";
        
//        echo $sql; 
        //exit($sql);        
        $objConexion= new Conexion();
        $reg= $objConexion->ejecutarComando($sql);
        $err= pg_fetch_array($reg);  

        $cadena_err= str_replace("\"", "-", $err['descripcion']);
        $retorno= "tab=3&rsl=0&err=".$cadena_err;

        if(strcmp($err['codigo'], '0') != 0) { 
            //regresa con error a la pagina ofindido
            $_SESSION['ofendido']= 'f';
            
            if ($copiado== '1')
            {
                echo "";
            }
            else
            {
                header("location: frmExpediente.php?".$retorno);
            }
        }else
        {                    
//            $_SESSION['validarestado']= 'no';

            if ($copiado== '1')
            { 
                echo "";
            }
            else
            { exit("salida else");
                //mostrar mensaje de exito, en el formulario ofendido
//                header("location: ../ofendido/ofendido.php?rsl2=100");
                header("location: frmExpediente.php?tab=3&rsl=100");
            }
        }         
  }
  
  
  public function ModificarOfendido($value)
  {
        $objOfendido= $value;

	$objConexion= new Conexion();
         /**Ingreso de Log (ultimo valor guadado en la tabla**/
        session_start();
        $usuario =$_SESSION['usuario'];
	$gall= $_SESSION['denunciaid'];
        $objOfendido->setDenunciaid($gall);        

        //soundex para nombre
        $nombre_array= str_word_count($objOfendido->getNombreCompleto(), 1);
        
        for($i= 0; $i < count($nombre_array); $i++){
            if ($i== 0)
                $soundex_nombre= soundex($nombre_array[$i]);
            else
                $soundex_nombre= $soundex_nombre . ";" . soundex($nombre_array[$i]);            
        }  
        
        //soundex para apellido
        $nombre_array= str_word_count($objOfendido->getApellidoCompleto(), 1);
        
        for($i= 0; $i < count($nombre_array); $i++){
            if ($i== 0)
                $soundex_apellido= soundex($nombre_array[$i]);
            else
                $soundex_apellido= $soundex_apellido . ";" . soundex($nombre_array[$i]);            
        }
        
        
	$sql= "SELECT codigo, descripcion from ofendido_update("
		.$gall.", "
		."'".$objOfendido->getIdentidad()."', "
		."'".$objOfendido->getNombreCompleto()."', "
		."'".$objOfendido->getApellidoCompleto()."', "
		."'".$objOfendido->getGenero()."', "
		.$objOfendido->getEstadoCivil().", "
		.$objOfendido->getProfesion().", "
		.$objOfendido->getOcupacion().", "
		.$objOfendido->getEscolaridad().", "
		."'".$objOfendido->getNacionalidad()."', "
		.$objOfendido->getGrupoEtnico().", "
		.$objOfendido->getDiscapacidad().", "
		.$objOfendido->getConocido().", "
		.$objOfendido->getEdad().", "
		."'".$objOfendido->getUmeDidaEdad()."', "
		."'".$objOfendido->getRangoEdad()."', "
		."'".$objOfendido->getDepartamentoid()."', "
		."'".$objOfendido->getMunicipioid()."', "
		."'".$objOfendido->getAldeaId()."', "
		."'".$objOfendido->getDetalle()."', "
		."'".$objOfendido->getBarrioId()."', "
		."'".$objOfendido->getOrientacionSex()."', "
		."'".$objOfendido->getTxtDireccion()."', "
		.$objOfendido->getPersonaId().", "
                ."'".$objOfendido->getTelefono()."', "                
                .$objOfendido->getTipoDocumento().", "                
		."'".$usuario."', "
		."'".$_SERVER['REMOTE_ADDR']."', "
                ."'".$soundex_nombre."', "
                ."'".$soundex_apellido."', " 
                ."'".$objOfendido->getPersonaNatural()."', "
                ."'".$objOfendido->getNombreAsumido()."', "
                ."'".$objOfendido->getbApoderado()."', "
                ."'".$objOfendido->getApoderadoNombre()."', "
                ."'".$objOfendido->getApoderadoColegio()."', "
                ."'".$objOfendido->getRTN()."', "
                ."'".$objOfendido->getEmbarazada()."', "
                ."'".$objOfendido->getFrecuencia()."', "
                ."'".$objOfendido->getTrabajoRemunerado()."', "
                ."'".$objOfendido->getAsisteCentroEducativo()."', "
                .$objOfendido->getNumeroHijos().", "
                ."'".$objOfendido->getIntentoSuicidio()."', "
                ."'".$objOfendido->getEnfermedadMental()."', "
                ."'".$objOfendido->getMecanismoMuerte()."', "                                
                ."'".$objOfendido->getIntegraLGBTI()."' "
		.")";
        
        
                
//        exit($sql);
        $objConexion= new Conexion();
        $reg= $objConexion->ejecutarProcedimiento($sql);
        $err= pg_fetch_array($reg); 
        
        $cadena_err= str_replace("\"", "-", $err['descripcion']);
        $retorno= "tab=3&rsl=0&err=".$cadena_err;
            
        if(strcmp($err['codigo'], '0') != 0) {
            //regresa con error a la pagina ofindido
//            header("location: ../ofendido/ofendido.php?".$rtorno);
            header("location: frmExpediente.php?".$retorno);
        }else
        {                    
            $_SESSION['validarestado']= 'no';
            //mostrar mensaje de exito, en el formulario ofendido
//            header("location: ../ofendido/ofendido.php?rsl2=200");
            header("location: frmExpediente.php?tab=3&rsl=200");
        }              	      
  }

  public function RecuperarOfendido($value)
  {
		$sql= "select "
		."tdenunciaid, cdocumentoid, cnombres, capellidos, "
		."cgenero, nestadocivil, nprofesionid, nocupacionid, " 
                ."nescolaridadid, cnacionalidadid, netniaid, ndiscapacidadid, " 
                ."nconocido, iedad, cunidadmedidaedad, crangoedad, "
		."cdepartamentoid, cmunicipioid, caldeaid, cdetalle, "
		."cbarrioid, corientacionsexual, tpersonaid, cdireccion, "
                ."ntipodocumento, ctelefono, bpersonanatural, cnombreasumido, "
                ."crtn, bapoderadolegal, capoderadolegal, ccolegioabogado, crepresentantelegal,  "
                . "cesmenor, aplicalgbti "                        
		."from tbl_ofendido where "
		."tdenunciaid= ".$value.";";
	
		$objConexion= new Conexion();
		$Cursor= $objConexion->ejecutarComando($sql);

		return $Cursor;
//                echo $sql;
		//return $sql;
  }

  public function RecuperarOfendidoId($valdenuncia, $valofendido)
  {
		$sql= "select "
		."tdenunciaid, cdocumentoid, cnombres, capellidos, "
		."cgenero, nestadocivil, nprofesionid, nocupacionid, " 
                ."nescolaridadid, cnacionalidadid, netniaid, ndiscapacidadid, " 
                ."nconocido, iedad, cunidadmedidaedad, crangoedad, "
		."cdepartamentoid, cmunicipioid, caldeaid, cdetalle, "
		."cbarrioid, corientacionsexual, tpersonaid, cdireccion, "
                ."ntipodocumento, ctelefono, bpersonanatural, cnombreasumido, "
                ."crtn, bapoderadolegal, capoderadolegal, ccolegioabogado, crepresentantelegal,"
                . "cesmenor, aplicalgbti "
		."from tbl_ofendido where "
		."tdenunciaid= ".$valdenuncia." and tpersonaid= ".$valofendido.";";
//exit("sql: ".$sql);
		$objConexion= new Conexion();
		$Cursor= $objConexion->ejecutarComando($sql);

		return $Cursor;
      //exit($sql);
		//return $sql;
  }
  
  public function RecuperarListaOfendidos($valdenuncia){
    $sql="select tpersonaid from tbl_ofendido where tdenunciaid= $valdenuncia";
      
    $objConexion= new Conexion();
    $Cursor= $objConexion->ejecutarComando($sql);
//    exit($sql);
    return $Cursor;      
  }  
  
  public function RecuperarTxtc($Tabla, $Campo, $Valor)
  {
		$objConexion= new Conexion();
		
		$sql= "select cdescripcion from ".$Tabla." where ".$Campo."= '".$Valor."';";
		
		$Cursor= $objConexion->ejecutarComando($sql);

		return $Cursor;
		//return $sql;
  }

  public function RecuperarTxtw($Tabla, $where)
  {
		$objConexion= new Conexion();
		
		$sql= "select cdescripcion from ".$Tabla." ".$where."';";
		
		$Cursor= $objConexion->ejecutarComando($sql);

		return $Cursor;
		//return $sql;
  }
}
?>