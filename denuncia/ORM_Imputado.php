<?php
require_once '../clases/Persona.php';
require_once '../clases/Imputado.php';
require_once '../clases/Usuario.php';

class ORM_Imputado {

  public function ORM_Imputado(){
	$objImputado= new Imputado;
  }

  public function Guardarimputado($value)
  {
          session_start();
	//$objImputado= new imputado;
	$objImputado= $value;
        
        if (isset($_SESSION['objUsuario'])){ 
            $objUsuario= $_SESSION['objUsuario'];        
        }else{
            exit("Error no exite usuario en archivo orm_imputado");
        }          

	$usuario = $objUsuario->getUsuario();
	$gall= $_SESSION['denunciaid'];
        $objImputado->setDenunciaid($gall);

        $Culposos= $objImputado->getCulposos();
        $Tentativas= $objImputado->getTentativas();
                
        $Delitos= $objImputado->getDelitos();
        $Alias= $objImputado->getAlias();
        
        if (strlen($Delitos)== 0)
            $Delitos= 0;
        
        if (strlen($Alias)== 0)
            $Alias= "'--- ningun alias ---'";
        
        $Objetos= $objImputado->getObjetos();
        
        if (strlen($Objetos)== 0)
            $Objetos= 0;
       
        $Transporte= $objImputado->getTransporte();
        
        if (strlen($Transporte)== 0)
            $Transporte= 0;   
        
        $Armas= $objImputado->getArmas();
        
        if (strlen($Armas)== 0)
            $Armas= 0;           
        
        //soundex para nombre
        $nombre_array= str_word_count($objImputado->getNombreCompleto(), 1);
        
        for($i= 0; $i < count($nombre_array); $i++){
            if ($i== 0)
                $soundex_nombre= soundex($nombre_array[$i]);
            else
                $soundex_nombre= $soundex_nombre . ";" . soundex($nombre_array[$i]);            
        }  
        
        //soundex para apellido
        $nombre_array= str_word_count($objImputado->getApellidoCompleto(), 1);
        
        for($i= 0; $i < count($nombre_array); $i++){
            if ($i== 0)
                $soundex_apellido= soundex($nombre_array[$i]);
            else
                $soundex_apellido= $soundex_apellido . ";" . soundex($nombre_array[$i]);            
        }         
        
	//nota: falta nrelacionimputado ke se agrega despues mediante update
	$sql= "SELECT codigo, descripcion from mini_sedi.denunciado_insert("
		.$gall.", "
		."'".$objImputado->getIdentidad()."', "
		."'".$objImputado->getNombreCompleto()."', "
		."'".$objImputado->getApellidoCompleto()."', "
		."'".$objImputado->getGenero()."', "
		.$objImputado->getEstadoCivil().", "
		.$objImputado->getProfesion().", "
		.$objImputado->getOcupacion().", "
		.$objImputado->getEscolaridad().", "
		."'".$objImputado->getNacionalidad()."', "
		.$objImputado->getGrupoEtnico().", "
		.$objImputado->getDiscapacidad().", "
		.$objImputado->getConocido().", "
		.$objImputado->getEdad().", "
		."'".$objImputado->getUmeDidaEdad()."', "
		."'".$objImputado->getRangoEdad()."', "
		."'".$objImputado->getDepartamentoid()."', "
		."'".$objImputado->getMunicipioid()."', "
		."'".$objImputado->getAldeaId()."', "
		."'".$objImputado->getDetalle()."', "
		."'".$objImputado->getBarrioId()."', "
		."'".$objImputado->getOrientacionSex()."', "
		."'".$objImputado->getTxtDireccion()."', "
		.$objImputado->getPersonaId().", "
                .$objImputado->getTipoDocumento().", "
                ."'".$objImputado->getTelefono()."', "
		."'".$usuario."', "
                ."array[".$Alias."], "
                ."array[".$Delitos."], "
                ."array['".$Culposos."'], "
                ."array['".$Tentativas."'], "                
                ."'".$soundex_nombre."', "
                ."'".$soundex_apellido."', "
		."'".$_SERVER['REMOTE_PORT']."', "
                ."'".$objImputado->getPersonaNatural()."', "
                ."'".$objImputado->getApoderadoNombre()."', "
                ."'".$objImputado->getRTN()."', "
                ."'".$objImputado->getSexo()."', "
                .$objImputado->getMovil().", "                
                ."'".$objImputado->getCondicionAgresor()."', "
                ."'".$objImputado->getTrabajoRemunerado()."', "
                ."'".$objImputado->getAsisteEducacion()."', "
                ."array[".$Transporte."], "
                ."array[".$Armas."], "
                ."array[".$Objetos."], "
                ."'".$objImputado->getIntegraLGBTI()."' "
		.")";
exit($sql);
        $objConexion= new Conexion();
        $reg= $objConexion->ejecutarComando($sql);
        $err= pg_fetch_array($reg);  
        
        $cadena_err= str_replace("\"", "-", $err['descripcion']);
        $retorno= "tab=2&rsl=0&err=".$cadena_err;
            
        if(strcmp($err['codigo'], '0') != 0) {
            //retorna con error a la pagina imputado
//            header("location: ../imputado/imputado.php?rsl2=300"."&err=".$err['descripcion']);
            $_SESSION['denunciado']= 'f';
//            header("location: ../imputado/imputado.php?".$rtorno);
            header("location: frmExpediente.php?".$retorno);
        }else
        {         
            $_SESSION['validarestado']= 'no';
            //mostrar mensaje de exito, en el formulario imputado
//            header("location: ../imputado/imputado.php?rsl2=100");
            header("location: frmExpediente.php?tab=2&rsl=100");
        }                	
  }
  
  public function Modificarimputado($value)
  {
	      
        $objImputado= $value;

	$objConexion= new Conexion();
         /**Ingreso de Log (ultimo valor guadado en la tabla**/
        session_start();
        if (isset($_SESSION['objUsuario'])){ 
            $objUsuario= $_SESSION['objUsuario'];        
        }else{
            exit("Error no exite usuario en archivo orm_imputado");
        }          

	$usuario = $objUsuario->getUsuario();
	$gall= $_SESSION['denunciaid'];
        $objImputado->setDenunciaid($gall);     
        
        $Culposos= $objImputado->getCulposos();
        $Tentativas= $objImputado->getTentativas();
        
        $Delitos= $objImputado->getDelitos();
        $Alias= $objImputado->getAlias();

        if (strlen($Delitos)== 0)
            $Delitos= 0;
        
        if (strlen($Alias)== 0)
            $Alias= "'--- ningun alias ---'";

        $Objetos= $objImputado->getObjetos();
        
        if (strlen($Objetos)== 0)
            $Objetos= 0;
       
        $Transporte= $objImputado->getTransporte();
        
        if (strlen($Transporte)== 0)
            $Transporte= 0;   
        
        $Armas= $objImputado->getArmas();
        
        if (strlen($Armas)== 0)
            $Armas= 0;           

        
        //soundex para nombre
        $nombre_array= str_word_count($objImputado->getNombreCompleto(), 1);
        
        for($i= 0; $i < count($nombre_array); $i++){
            if ($i== 0)
                $soundex_nombre= soundex($nombre_array[$i]);
            else
                $soundex_nombre= $soundex_nombre . ";" . soundex($nombre_array[$i]);            
        } 
        
        //soundex para apellido
        $nombre_array= str_word_count($objImputado->getApellidoCompleto(), 1);
        
        for($i= 0; $i < count($nombre_array); $i++){
            if ($i== 0)
                $soundex_apellido= soundex($nombre_array[$i]);
            else
                $soundex_apellido= $soundex_apellido . ";" . soundex($nombre_array[$i]);            
        }   
      
        $sql= "SELECT codigo, descripcion from mini_sedi.denunciado_update("
		.$gall.", "
		."'".$objImputado->getIdentidad()."', "
		."'".$objImputado->getNombreCompleto()."', "
		."'".$objImputado->getApellidoCompleto()."', "
		."'".$objImputado->getGenero()."', "
		.$objImputado->getEstadoCivil().", "
		.$objImputado->getProfesion().", "
		.$objImputado->getOcupacion().", "
		.$objImputado->getEscolaridad().", "
		."'".$objImputado->getNacionalidad()."', "
		.$objImputado->getGrupoEtnico().", "
		.$objImputado->getDiscapacidad().", "
		.$objImputado->getConocido().", "
		.$objImputado->getEdad().", "
		."'".$objImputado->getUmeDidaEdad()."', "
		."'".$objImputado->getRangoEdad()."', "
		."'".$objImputado->getDepartamentoid()."', "
		."'".$objImputado->getMunicipioid()."', "
		."'".$objImputado->getAldeaId()."', "
		."'".$objImputado->getDetalle()."', "
		."'".$objImputado->getBarrioId()."', "
		."'".$objImputado->getOrientacionSex()."', "
		."'".$objImputado->getTxtDireccion()."', "
		.$objImputado->getPersonaId().", "
        .$objImputado->getTipoDocumento().", "
                ."'".$objImputado->getTelefono()."', "
		."'".$usuario."', "
                ."array[".$Alias."], "
                ."array[".$Delitos."], "
                ."array['".$Culposos."'], "
                ."array['".$Tentativas."'], "                
                ."'".$soundex_nombre."', "
                ."'".$soundex_apellido."', "                
		."'".$_SERVER['REMOTE_ADDR']."', "
                ."'".$objImputado->getPersonaNatural()."', "
                ."'".$objImputado->getApoderadoNombre()."', "
                ."'".$objImputado->getRTN()."', "
                ."'".$objImputado->getSexo()."', "
                .$objImputado->getMovil().", "                
                ."'".$objImputado->getCondicionAgresor()."', "
                ."'".$objImputado->getTrabajoRemunerado()."', "
                ."'".$objImputado->getAsisteEducacion()."', "
                ."array[".$Transporte."], "
                ."array[".$Armas."], "
                ."array[".$Objetos."], "
                ."'".$objImputado->getIntegraLGBTI()."' "
		.")";
      
        $objConexion= new Conexion();
        $reg= $objConexion->ejecutarProcedimiento($sql);
        $err= pg_fetch_array($reg);  
        
        $cadena_err= str_replace("\"", "-", $err['descripcion']);
        $retorno= "tab=2&rsl=0&err=".$cadena_err;
            
        if(strcmp($err['codigo'], '0') != 0) {
            //retorna con error a la pagina imputado
            header("location: frmExpediente.php?".$retorno);
        }else{
            //echo $sql; 
            //mostrar mensaje de exito, en el formulario imputado
            header("location: frmExpediente.php?tab=2&rsl=200");
        }        
  }

  public function Recuperarimputado($value)
  {
		$sql= "select "
		."tdenunciaid, cdocumentoid, cnombres, capellidos, "
		."cgenero, nestadocivil, nprofesionid, nocupacionid, " 
                ."nescolaridadid, cnacionalidadid, netniaid, ndiscapacidadid, " 
                ."nconocido, iedad, cunidadmedidaedad, crangoedad, "
		."cdepartamentoid, cmunicipioid, caldeaid, cdetalle, "
		."cbarrioid, corientacionsexual, tpersonaid, cdireccion, "
                ."ntipodocumento, ctelefono, cmetanombre, cmetaapellido, "
                ."bpersonanatural, crtn, capoderadolegal, csexo, ccolegioabogado, "
                . "ccondicion, ctrabajoremunerado, casisteeducacion, crepresentantelegalmenor,"
                . " bmenorinfractor, aplicalgbti "
		."from tbl_imputado where "
		."tdenunciaid= ".$value.";";               
                
		$objConexion= new Conexion();
		$Cursor= $objConexion->ejecutarComando($sql);
//echo "$sql";
		return $Cursor;
  }
                  
  public function RecuperarimputadoId($valdenuncia, $valdenunciado)
  {
		$sql= "select "
		."tdenunciaid, cdocumentoid, cnombres, capellidos, "
		."cgenero, nestadocivil, nprofesionid, nocupacionid, " 
                ."nescolaridadid, cnacionalidadid, netniaid, ndiscapacidadid, " 
                ."nconocido, iedad, cunidadmedidaedad, crangoedad, "
		."cdepartamentoid, cmunicipioid, caldeaid, cdetalle, "
		."cbarrioid, corientacionsexual, tpersonaid, cdireccion, "
                ."ntipodocumento, ctelefono, cmetanombre, cmetaapellido, "
                ."bpersonanatural, crtn, capoderadolegal, csexo, ccolegioabogado,"
                . "ccondicion, ctrabajoremunerado, casisteeducacion, crepresentantelegalmenor, "
                 . " bmenorinfractor, aplicalgbti "
		."from tbl_imputado where "
		."tdenunciaid= ".$valdenuncia." and tpersonaid= ".$valdenunciado.";";
	
		$objConexion= new Conexion();
		$Cursor= $objConexion->ejecutarComando($sql);
//echo "$sql";
		return $Cursor;
//		return $sql;
  }  
     
  public function RecuperarListaImputados($valdenuncia){
    $sql="select tpersonaid from tbl_imputado where tdenunciaid= $valdenuncia";
      
    $objConexion= new Conexion();
    $Cursor= $objConexion->ejecutarComando($sql);
//    exit($sql);
    return $Cursor;      
  }
          
          
  public function RecuperarAlias($Persona){
    session_start();
      
    $objConexion= new Conexion();

    $sql= "select alias from denunciado_alias("
        ."'".$_SESSION['denunciaid']."', "
        ."'".$Persona."'"
        .");";
      
    $reg= $objConexion->ejecutarProcedimiento($sql);
    
    return $reg;     
  }  
  
  public function RecuperarDelitos($Persona){
    session_start();
      
    $objConexion= new Conexion();

//    $sql= "select ndelito from denunciado_delito('1397968640', '1397968609')";
    
    $sql= "select ndelito, cclasificacion from denunciado_delito("
        ."'".$_SESSION['denunciaid']."', "
        ."'".$Persona."'"
        .");";

    $reg= $objConexion->ejecutarProcedimiento($sql);
   
    return $reg;     
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
