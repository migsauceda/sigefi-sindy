<?php
//session_start();

//require_once 'Denunciante.php';
//require_once 'Ofendido.php';
//require_once 'Imputado.php';

require_once '../clases/Persona.php';
require_once '../clases/Denuncia.php';
require_once '../clases/Usuario.php';

session_start(); 

class ORM_Denuncia {
  
  public function ORM_Denuncia(){
    $oDenuncia= new Denuncia;           
  }


  public function GuardarDenuncia($value)
  { 
      	session_start();        
        if (isset($_SESSION['objUsuario'])){ 
            $objUsuario= $_SESSION['objUsuario'];        
        }else{
            exit("Error no exite usuario en archivo orm_denuncia");
        }       
        
	$oDenuncia= $value;        

	//genera el numero de denuncia y lo guarda en variable de session
        //esto se pasa al archivo "procesagenerales.php
        
        //al generar el numero de denuncias con microtime() y usar la funcion
        //floor() eventualmente se genera un numero repetido, por eso se le suma
        //un numero aleatorio generado con rand() entre 1 y 50

        $gall= microtime(true);
        $gall= floor($gall);
        $gall= $gall + rand(1, 50);

        $_SESSION['denunciaid']= $gall;
        $oDenuncia->setDenunciaId($gall);
        $Bandeja= $objUsuario->getSubBandejaId();

        //$oDenuncia->setLugarRecepcion($_SESSION["ubicacion"]);
        $oDenuncia->setUsuario($objUsuario->getUsuario());

        //validar si el campo fecha del hecho viene con valor nulo
        if ($oDenuncia->getFechaHecho()==''){
            $FechaHecho= '19000101';
        }
        else {
            $FechaHecho= $oDenuncia->getFechaHecho();
        }

        //validar si el campo fecha de denuncia viene con valor nulo
        if ($oDenuncia->getFechaDenuncia()==''){
            $FechaDenuncia= '19000101';
        }
        else {
            $FechaDenuncia= $oDenuncia->getFechaDenuncia();
        }
    
	$sql= "SELECT codigo, descripcion from mini_sedi.generales_insert("
		."'".$oDenuncia->getDenunciaId()."', "
		."'".$oDenuncia->getNumero()."', "
		."'".$oDenuncia->getExpedienteJudicial()."', "
		."'".$oDenuncia->getExpedientePolicial()."', "
		."'".$FechaDenuncia."', "
		."'".$FechaHecho."', "
        	."'".$oDenuncia->getDepartamentoDenuncia()."', "
		."'".$oDenuncia->getMunicipioDenuncia()."', "
		."'".$oDenuncia->getDepartamentoHecho()."', "
		."'".$oDenuncia->getMunicipioHecho()."', "
		."'".$oDenuncia->getAldeaCaserioHecho()."', "
		."'".$oDenuncia->getBarrioColoniaHecho()."', "
		."'".$oDenuncia->getLugarRecepcion()."', "
		."'".$oDenuncia->getEstado()."', "
		."'".$oDenuncia->getDetalleDireccion()."', "
		."'".$oDenuncia->getNarracionHecho()."', "
        	."'".$oDenuncia->getTxtDireccionDenuncia()."', "
        	."'".$oDenuncia->getTxtDireccionHecho()."', "
		."'".$oDenuncia->getUsuario()."', "                
                .$Bandeja.", "
		."'".$_SERVER['REMOTE_ADDR']."', "
                ."'".$oDenuncia->getHoraDenuncia()."', "
                ."'".$oDenuncia->getHoraHecho()."', "
                .$oDenuncia->getLugarHecho().", "
                ."'".$oDenuncia->getAutopsia()."', "
                ."'".$oDenuncia->getLevantamiento()."', "
                ."'".$oDenuncia->getTransito()."'"
	.");";
        
//        exit($sql);
        $objConexion= new Conexion();
        $reg= $objConexion->ejecutarComando($sql);
        $err= pg_fetch_array($reg);  

        $cadena_err= str_replace("\"", "-", $err['descripcion']);
        $retorno= "tab=0&rsl=0&err=".$cadena_err;

        if(strcmp($err['codigo'], '0') != 0) {
            //retornar a la pagina con msj de error
            $_SESSION['generales']= 'f';
            header("location: frmExpediente.php?".$retorno);
        }else
        {         
            $_SESSION['validarestado']= 'no';
            $_SESSION['CambiarTab']= 1;

            header("location: frmExpediente.php?tab=0&rsl=100");
        }
  }

  public function ModificarDenuncia($value)
  {     session_start();
  
        if (isset($_SESSION['objUsuario'])){ 
            $objUsuario= $_SESSION['objUsuario'];        
        }else{
            exit("Error no exite usuario");
        }       
        
        $oDenuncia= $value;
        $oDenuncia->setUsuario($objUsuario->getUsuario());

        //validar si el campo fecha del hecho viene con valor nulo
        if ($oDenuncia->getFechaHecho()==''){
            $FechaHecho= '19000101';
        }
        else {
            $FechaHecho= $oDenuncia->getFechaHecho();
        }

        //validar si el campo fecha de denuncia viene con valor nulo
        if ($oDenuncia->getFechaDenuncia()==''){
            $FechaDenuncia= '19000101';
        }
        else {
            $FechaDenuncia= $oDenuncia->getFechaDenuncia();
        }        
        
        $usuario = $objUsuario->getUsuario();
        $oDenuncia= $value;

	$sql= "select codigo, descripcion from mini_sedi.generales_update("
		."'".$oDenuncia->getDenunciaId()."', "
		."'".$oDenuncia->getNumero()."', "
		."'".$oDenuncia->getExpedienteJudicial()."', "
		."'".$oDenuncia->getExpedientePolicial()."', "
		."'".$oDenuncia->getFechaDenuncia()."', "
		."'".$oDenuncia->getFechaHecho()."', "
		."'".$oDenuncia->getDepartamentoDenuncia()."', "
		."'".$oDenuncia->getMunicipioDenuncia()."', "
		."'".$oDenuncia->getDepartamentoHecho()."', "
		."'".$oDenuncia->getMunicipioHecho()."', "
		."'".$oDenuncia->getAldeaCaserioHecho()."', "
		."'".$oDenuncia->getBarrioColoniaHecho()."', "
		."'".$oDenuncia->getLugarRecepcion()."', "
		."'".$oDenuncia->getEstado()."', "
		."'".$oDenuncia->getDetalleDireccion()."', "
		."'".$oDenuncia->getNarracionHecho()."', "
		."'".$oDenuncia->getTxtDireccionDenuncia()."', "
		."'".$oDenuncia->getTxtDireccionHecho()."', "
		."'".$usuario."', "
		."'".$_SERVER['REMOTE_ADDR']."', "
                ."'".$oDenuncia->getHoraDenuncia()."', "
                ."'".$oDenuncia->getHoraHecho()."', "
                .$oDenuncia->getLugarHecho().", "
                ."'".$oDenuncia->getAutopsia()."', "
                ."'".$oDenuncia->getLevantamiento()."', "
                ."'".$oDenuncia->getTransito()."'"               
	.");";

//	exit($sql);
        $objConexion= new Conexion();
        $reg= $objConexion->ejecutarProcedimiento($sql);
        $err= pg_fetch_array($reg);
        
        $cadena_err= str_replace("\"", "-", $err['descripcion']);
        $retorno= "tab=0&rsl=0&err=".$cadena_err;
            
        if(strcmp($err['codigo'], '0') != 0) {
            //retornar a la pagina con msj de error
//            header("location: generales.php?".$rtorno);      
            header("location: frmExpediente.php?".$retorno);
        }else
        {         
            $_SESSION['validarestado']= 'no';
            //mostrar mensaje de exito, en el formulario generales
//            header("location: generales.php?rsl=200");
            header("location: frmExpediente.php?tab=0&rsl=200");
        }             
  }  


  public function RecuperarDenuncia($value)
  {

		$sql= "select tdenunciaid, cexpedientesedi, cexpedientejudicial, dfechadenuncia, "
		."dfechahecho, cdeptodenuncia, cmunicipiodenuncia, cdeptohecho, cmunicipiohecho, "
		."caldeahecho, ccaseriohecho, nlugarrecepcion, cestadodenuncia, "
                ."cdetalledireccionhecho, cnarracionhecho, cexpedientepolicial, "
                ."cdireccionhecho, cdirecciondenuncia, thoradenuncia, thorahecho, nlugarid "
		."from tbl_denuncia where tdenunciaid= ".$value.";";

		$objConexion= new Conexion();
		$Cursor= $objConexion->ejecutarComando($sql);

		return $Cursor;
  }
}
?>
