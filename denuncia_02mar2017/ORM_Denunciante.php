<?php
//require_once 'Persona.php';
//require_once '../clases/Denunciante.php';
require_once '../clases/Usuario.php';

class ORM_Denunciante {

  public function ORM_Denunciante(){
	$objDenunciante= new Denunciante;
  }

  public function GuardarDenunciante($value)
  { 
        session_start();
        if (isset($_SESSION['objUsuario'])){ 
            $objUsuario= $_SESSION['objUsuario'];        
        }else{
            exit("Error no exite usuario en archivo orm_denunciante");
        }               
	//$objDenunciante= new Denunciante;
	$objDenunciante= $value;

	$usuario = $objUsuario->getUsuario();
	$gall= $_SESSION['denunciaid'];
        $objDenunciante->setDenunciaid($gall);

        //soundex para nombre
        $nombre_array= str_word_count($objDenunciante->getNombreCompleto(), 1);

        for($i= 0; $i < count($nombre_array); $i++){
            if ($i== 0)
                $soundex_nombre= soundex($nombre_array[$i]);
            else
                $soundex_nombre= $soundex_nombre . ";" . soundex($nombre_array[$i]);            
        }  
     
        //soundex para apellido
        $nombre_array= str_word_count($objDenunciante->getApellidoCompleto(), 1);
        
        for($i= 0; $i < count($nombre_array); $i++){
            if ($i== 0)
                $soundex_apellido= soundex($nombre_array[$i]);
            else
                $soundex_apellido= $soundex_apellido . ";" . soundex($nombre_array[$i]);            
        }

	//nota: falta nrelacionimputado ke se agrega despues mediante update
	$sql= "SELECT codigo, descripcion from denunciante_insert("
		.$gall.", "
		."'".$objDenunciante->getIdentidad()."', "
		."'".$objDenunciante->getNombreCompleto()."', "
		."'".$objDenunciante->getApellidoCompleto()."', "
		."'".$objDenunciante->getGenero()."', "
		.$objDenunciante->getEstadoCivil().", "
		.$objDenunciante->getProfesion().", "
		.$objDenunciante->getOcupacion().", "
		.$objDenunciante->getEscolaridad().", "
		."'".$objDenunciante->getNacionalidad()."', "
		.$objDenunciante->getGrupoEtnico().", "
		.$objDenunciante->getDiscapacidad().", "
		.$objDenunciante->getConocido().", "
		.$objDenunciante->getEdad().", "
		."'".$objDenunciante->getUmeDidaEdad()."', "
		."'".$objDenunciante->getRangoEdad()."', "
		."'".$objDenunciante->getDepartamentoid()."', "
		."'".$objDenunciante->getMunicipioid()."', "
		."'".$objDenunciante->getAldeaId()."', "
		."'".$objDenunciante->getDetalle()."', "
		."'".$objDenunciante->getBarrioId()."', "
		."'".$objDenunciante->getOrientacionSex()."', "
		."'".$objDenunciante->getTxtDireccion()."', "
		.$objDenunciante->getPersonaId().", "
                .$objDenunciante->getTipoDocumento().", "
                ."'".$objDenunciante->getTelefono()."', "
		."'".$usuario."', "
		."'Proxy:".$_SERVER['REMOTE_ADDR']." IP_Real:".$_SERVER['HTTP_X_FORWARDED_FOR']."IP_:".$_SERVER['REMOTE_ADDR']."', "
                ."'".$soundex_nombre."', "
                ."'".$soundex_apellido."', "
                ."'".$objDenunciante->getbApoderado()."', "
                ."'".$objDenunciante->getApoderadoNombre()."', "
                ."'".$objDenunciante->getApoderadoColegio()."', "
                ."'".$objDenunciante->getPersonaNatural()."', "
                ."'".$objDenunciante->getNombreAsumido()."', "
                ."'".$objDenunciante->getRTN()."', "
                ."'".$objDenunciante->getIntegraLGBTI()."' "
		.")";

//        exit($sql);
        $objConexion= new Conexion();
        $reg= $objConexion->ejecutarComando($sql);
        $err= pg_fetch_array($reg);  
        
        $cadena_err= str_replace("\"", "-", $err['descripcion']);
        $retorno= "tab=1&rsl=0&err=".$cadena_err;
            
        if(strcmp($err['codigo'], '0') != 0) {
            //regresa con error a la pagina denunciante
            $_SESSION['denunciante']= 'f';
//            header("location: ../denunciante/denunciante.php?".$rtorno);
            header("location: frmExpediente.php?".$retorno);
        }else
        {                 
            //mostrar mensaje de exito, en el formulario denunciante
            $_SESSION['validarestado']= 'no';
//            header("location: ../denunciante/denunciante.php?rsl2=100");
            header("location: frmExpediente.php?tab=1&rsl=100");
        }          
  }  
  
  public function ModificarDenunciante($value)
  {    
        $objDenunciante= $value;

	$objConexion= new Conexion();
         /**Ingreso de Log (ultimo valor guadado en la tabla**/
        session_start();
        if (isset($_SESSION['objUsuario'])){ 
            $objUsuario= $_SESSION['objUsuario'];        
        }else{
            exit("Error no exite usuario en archivo orm_denunciante");
        }                       
        
        $usuario = $objUsuario->getUsuario();
	$gall= $_SESSION['denunciaid'];
        $objDenunciante->setDenunciaid($gall);        

        //soundex para nombre
        $nombre_array= str_word_count($objDenunciante->getNombreCompleto(), 1);

        for($i= 0; $i < count($nombre_array); $i++){
            if ($i== 0)
                $soundex_nombre= soundex($nombre_array[$i]);
            else
                $soundex_nombre= $soundex_nombre . ";" . soundex($nombre_array[$i]);            
        }  
        
        //soundex para apellido
        $nombre_array= str_word_count($objDenunciante->getApellidoCompleto(), 1);
        
        for($i= 0; $i < count($nombre_array); $i++){
            if ($i== 0)
                $soundex_apellido= soundex($nombre_array[$i]);
            else
                $soundex_apellido= $soundex_apellido . ";" . soundex($nombre_array[$i]);            
        }

	$sql= "SELECT codigo, descripcion from denunciante_update("
		.$gall.", "
		."'".$objDenunciante->getIdentidad()."', "
		."'".$objDenunciante->getNombreCompleto()."', "
		."'".$objDenunciante->getApellidoCompleto()."', "
		."'".$objDenunciante->getGenero()."', "
		.$objDenunciante->getEstadoCivil().", "
		.$objDenunciante->getProfesion().", "
		.$objDenunciante->getOcupacion().", "
		.$objDenunciante->getEscolaridad().", "
		."'".$objDenunciante->getNacionalidad()."', "
		.$objDenunciante->getGrupoEtnico().", "
		.$objDenunciante->getDiscapacidad().", "
		.$objDenunciante->getConocido().", "
		.$objDenunciante->getEdad().", "
		."'".$objDenunciante->getUmeDidaEdad()."', "
		."'".$objDenunciante->getRangoEdad()."', "
		."'".$objDenunciante->getDepartamentoid()."', "
		."'".$objDenunciante->getMunicipioid()."', "
		."'".$objDenunciante->getAldeaId()."', "
		."'".$objDenunciante->getDetalle()."', "
		."'".$objDenunciante->getBarrioId()."', "
		."'".$objDenunciante->getOrientacionSex()."', "
		."'".$objDenunciante->getTxtDireccion()."', "
		.$objDenunciante->getPersonaId().", "
                .$objDenunciante->getTipoDocumento().", "
                ."'".$objDenunciante->getTelefono()."', "
		."'".$usuario."', "
		."'Proxy:".$_SERVER['REMOTE_ADDR']." IP_Real:".$_SERVER['HTTP_X_FORWARDED_FOR']."IP_:".$_SERVER['REMOTE_ADDR']."', "
                ."'".$soundex_nombre."', "
                ."'".$soundex_apellido."', "               
                ."'".$objDenunciante->getbApoderado()."', "
                ."'".$objDenunciante->getApoderadoNombre()."', "
                ."'".$objDenunciante->getApoderadoColegio()."', "
                ."'".$objDenunciante->getPersonaNatural()."', "
                ."'".$objDenunciante->getNombreAsumido()."', "
                ."'".$objDenunciante->getRTN()."', "
                ."'".$objDenunciante->getIntegraLGBTI()."' "
		.")";

//        exit($sql);
        $objConexion= new Conexion();
        $reg= $objConexion->ejecutarProcedimiento($sql);
        $err= pg_fetch_array($reg);  
        
        $cadena_err= str_replace("\"", "-", $err['descripcion']);
        $retorno= "tab=1&rsl=0&err=".$cadena_err;
            
        if(strcmp($err['codigo'], '0') != 0) {
            //regresa con error a la pagina denunciante
//            header("location: ../denunciante/denunciante.php?".$rtorno);
            header("location: frmExpediente.php?".$retorno);
        }else
        {                 
            //mostrar mensaje de exito, en el formulario denunciante
            $_SESSION['validarestado']= 'no';
//            header("location: ../denunciante/denunciante.php?rsl2=200");
            header("location: frmExpediente.php?tab=1&rsl=200");
        }            
  }

  public function RecuperarDenunciante($value)
  {
		$sql= "select "
		."tdenunciaid, cdocumentoid, cnombres, capellidos, "
		."cgenero, nestadocivil, nprofesionid, nocupacionid, " 
                ."nescolaridadid, cnacionalidadid, netniaid, ndiscapacidadid, " 
                ."nconocido, iedad, cunidadmedidaedad, crangoedad, "
		."cdepartamentoid, cmunicipioid, caldeaid, cdetalle, "
		."cbarrioid, corientacionsexual, tpersonaid, cdireccion, "
                ."ntipodocumento, ctelefono, cmetanombre, cmetaapellido, "
                ."capoderadolegal, ccolegioabogado, bapoderadolegal, bpersonanatural, "
                ."cnombreasumido, crtn, aplicalgbti "
		."from tbl_denunciante where "
		."tdenunciaid= ".$value.";";
	
		$objConexion= new Conexion();
		$Cursor= $objConexion->ejecutarComando($sql);
//echo "$sql";
		return $Cursor;
		//return $sql;
  }

  //recupera en función del numero de denuncia y denuciante
  public function RecuperarDenuncianteId($valdenuncia, $valdenunciante)
  {
		$sql= "select "
		."tdenunciaid, cdocumentoid, cnombres, capellidos, "
		."cgenero, nestadocivil, nprofesionid, nocupacionid, " 
                ."nescolaridadid, cnacionalidadid, netniaid, ndiscapacidadid, " 
                ."nconocido, iedad, cunidadmedidaedad, crangoedad, "
		."cdepartamentoid, cmunicipioid, caldeaid, cdetalle, "
		."cbarrioid, corientacionsexual, tpersonaid, cdireccion, "
                ."ntipodocumento, ctelefono, cmetanombre, cmetaapellido, "
                ."capoderadolegal, ccolegioabogado, bapoderadolegal, bpersonanatural, "
                ."cnombreasumido, crtn, aplicalgbti "
		."from tbl_denunciante where "
		."tdenunciaid= ".$valdenuncia." and tpersonaid= ".$valdenunciante.";";
	               
		$objConexion= new Conexion();
		$Cursor= $objConexion->ejecutarComando($sql);
//exit($valdenuncia."-".$valdenunciante);
//echo "$sql";
		return $Cursor;
//		return $sql;
 }  
  
  public function RecuperarListaDenunciante($valdenuncia){
    $sql="select tpersonaid from tbl_denunciante where tdenunciaid= $valdenuncia";
      
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