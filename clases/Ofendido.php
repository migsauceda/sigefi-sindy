<?php

//require_once 'Denuncia.php';
require_once 'Persona.php';
require_once '../denuncia/ORM_Ofendido.php';

//Un ofendido puede participar en varias denuncias, y es una especializaci�n de la clase Persona
class Ofendido extends Persona {
  private $RelacionImputado;
  private $Conocido;
  private $tdenunciaid;
  
  private $EstaVivo;
  private $RepresentanteLegal;
  private $EsMenor;
  
  
  private $ApoderadoNombre;
  private $ApoderadoColegio;
  private $bApoderado;
  
  private $NombreAsumido;
  
  private $Embarazada;              //si-no-NA
  private $Frecuencia;              //primera-varias
  private $TrabajoRemunerado;       //si-no
  private $AsisteCentroEducativo;   //si-no-NA
  private $NumeroHijos;             //default 0
  
  private $IntentoSuicidio;
  private $EnfermedadMental;
  private $MecanismoMuerte;
  
  final public function getIntentoSuicidio() {
      return $this->IntentoSuicidio;
  }
  public function setIntentoSuicidio($value) {
      $this->IntentoSuicidio= $value;
  }
  
  final public function getEnfermedadMental() {
      return $this->EnfermedadMental;
  }
  public function setEnfermedadMental($value) {
      $this->EnfermedadMental= $value;
  }
  
  final public function getMecanismoMuerte() {
      return $this->MecanismoMuerte;
  }
  public function setMecanismoMuerte($value) {
      $this->MecanismoMuerte= $value;
  }
  
  final public function getEmbarazada() {
      return $this->Embarazada;
  }
  public function setEmbarazada($value) {
      //sI, NO, NA
      $this->Embarazada= $value;
  }

  final public function getFrecuencia() {
      return $this->Frecuencia;
  }
  public function setFrecuencia($value) {
      //PV, RE
      $this->Frecuencia= $value;
  }  
  
  final public function getTrabajoRemunerado() {
      return $this->TrabajoRemunerado;
  }
  public function setTrabajoRemunerado($value) {
      //SI, NO
      $this->TrabajoRemunerado= $value;
  }

  final public function getAsisteCentroEducativo() {
      return $this->AsisteCentroEducativo;
  }
  public function setAsisteCentroEducativo($value) {
      //SI, NO, NA
      $this->AsisteCentroEducativo= $value;
  }  
  
  final public function getNumeroHijos() {
      return $this->NumeroHijos;
  }
  public function setNumeroHijos($value) {
      //>=0
      $this->NumeroHijos= $value;
  } 
  
  final public function getNombreAsumido()
  {
    return $this->NombreAsumido;
  }

  public function setNombreAsumido($value)
  {
    $this->NombreAsumido = $value;
  }  

  final public function getbApoderado()
  {
    return $this->bApoderado;
  }

  public function setbApoderado($value)
  {
      $this->bApoderado = $value;
//    if ($value== '0')
//        $this->bApoderado = 'false';
//    else
//        $this->bApoderado = 'true';
  }  
  
  final public function getApoderadoNombre()
  {
    return $this->ApoderadoNombre;
  }

  public function setApoderadoNombre($value)
  {
    $this->ApoderadoNombre = $value;
  }  
  
  final public function getApoderadoColegio()
  {
    return $this->ApoderadoColegio;
  }

  public function setApoderadoColegio($value)
  {
    $this->ApoderadoColegio = $value;
  }    

  final public function getConocido()
  {
	return $this->Conocido;
  }

  public function setConocido($value)
  {
	$this->Conocido= $value;
  }

  final public function getRelacionImputado()
  {
    return $this->RelacionImputado;
  }

  public function setRelacionImputado($value)
  {
    $this->RelacionImputado = $value;
  }

  final public function getEstaVivo()
  {
    return $this->EstaVivo;
  }

  public function setEstaVivo($value)
  {
    $this->EstaVivo = $value;
  }

  final public function getDenunciaid()
  {
    return $this->tdenunciaid;
  }

  public function setDenunciaid($value)
  {
    $this->tdenunciaid = $value;
  }

  //otros metodos
  public function Guardar($copiado)
  { 

	$objORM= new ORM_Ofendido;

	$objORM->GuardarOfendido($this, $copiado);
  }


  public function Modificar()
  {

	$objORM= new ORM_Ofendido;

	$objORM->ModificarOfendido($this);
  }

  final public function getRepresentanteLegal()
  {
	return $this->RepresentanteLegal;
  }

  public function setRepresentanteLegal($value)
  {
	$this->RepresentanteLegal= $value;
  }

  final public function getEsMenor()
  {
	return $this->EsMenor;
  }

  public function setEsMenor($value)
  {
	$this->EsMenor= $value;
  }

//recuperar denunciante de disco
  public function Recuperar($value)
  {
		//$value representa numero de denuncia
		$objORM= new ORM_Ofendido;

		$rsCursor= $objORM->RecuperarOfendido($value);

		$row = pg_fetch_array($rsCursor);

                
		$this->setIdentidad($row["cdocumentoid"]);
		$this->setNombreCompleto($row["cnombres"]);
		$this->setApellidoCompleto($row["capellidos"]);
		$this->setGenero($row["cgenero"]);
		$this->setEstadoCivil($row["nestadocivil"]);
		$this->setProfesion($row["nprofesionid"]);
		$this->setOcupacion($row["nocupacionid"]);
		$this->setEscolaridad($row["nescolaridadid"]);
		$this->setNacionalidad($row["cnacionalidadid"]);
		$this->setGrupoEtnico($row["netniaid"]);
		$this->setDiscapacidad($row["ndiscapacidadid"]);
		$this->setConocido($row["nconocido"]);
		$this->setEdad($row["iedad"]);
		$this->setUmeDidaEdad($row["cunidadmedidaedad"]);
		$this->setRangoEdad($row["crangoedad"]);
		$this->setDepartamentoid($row["cdepartamentoid"]);
		$this->setMunicipioid($row["cmunicipioid"]);
		$this->setAldeaId($row["caldeaid"]);
		$this->setDetalle($row["cdetalle"]);
		$this->setBarrioId($row["cbarrioid"]);
		$this->setOrientacionSex($row["corientacionsexual"]);
		$this->setPersonaId($row["tpersonaid"]);
		$this->setdenunciaid($row["tdenunciaid"]);
                $this->setRepresentanteLegal($row["crepresentantelegal"]);
                $this->setEsMenor($row["cesmenor"]); 
                $this->setTipoDocumento($row["ntipodocumento"]);                
                $this->setTelefono($row["ctelefono"]); 
                $this->setPersonaNatural($row["bpersonanatural"]);
                $this->setNombreAsumido($row["cnombreasumido"]);
                $this->setRTN($row["crtn"]);
                $this->setbApoderado($row["bapoderadolegal"]);
                $this->setApoderadoNombre($row["capoderadolegal"]);
                $this->setApoderadoColegio($row["ccolegioabogado"]);
                               
                //recostruir la lista de ofendido existentes
		$rsCursor= $objORM->RecuperarListaOfendidos($value);
                
                $oOfendidoIndice= 0;
                while($row = pg_fetch_array($rsCursor)){
                    $oOfendidoCola= $oOfendidoCola.",".$row[tpersonaid];
                    $oOfendidoIndice++;
                }                 
                $oOfendidoCola= substr($oOfendidoCola, 1);
                
                //publicar las variables en las session
                session_start();
                $_SESSION['oOfendidoIndice']= $oOfendidoIndice;
                $_SESSION['oOfendidoCola']= $oOfendidoCola;                
  }
  
//recuperar denunciante de disco
  public function RecuperarId($valdenuncia, $valofendido)
  {
		//$value representa numero de denuncia
		$objORM= new ORM_Ofendido;

		$rsCursor= $objORM->RecuperarOfendidoId($valdenuncia, $valofendido);

		$row = pg_fetch_array($rsCursor);
//exit("sale".$row[ctelefono]);
		$this->setIdentidad($row["cdocumentoid"]);
		$this->setNombreCompleto($row["cnombres"]);
		$this->setApellidoCompleto($row["capellidos"]);
		$this->setGenero($row["cgenero"]);
		$this->setEstadoCivil($row["nestadocivil"]);
		$this->setProfesion($row["nprofesionid"]);
		$this->setOcupacion($row["nocupacionid"]);
		$this->setEscolaridad($row["nescolaridadid"]);
		$this->setNacionalidad($row["cnacionalidadid"]);
		$this->setGrupoEtnico($row["netniaid"]);
		$this->setDiscapacidad($row["ndiscapacidadid"]);
		$this->setConocido($row["nconocido"]);
		$this->setEdad($row["iedad"]);
		$this->setUmeDidaEdad($row["cunidadmedidaedad"]);
		$this->setRangoEdad($row["crangoedad"]);
		$this->setDepartamentoid($row["cdepartamentoid"]);
		$this->setMunicipioid($row["cmunicipioid"]);
		$this->setAldeaId($row["caldeaid"]);
		$this->setDetalle($row["cdetalle"]);
		$this->setBarrioId($row["cbarrioid"]);
		$this->setOrientacionSex($row["corientacionsexual"]);
		$this->setPersonaId($row["tpersonaid"]);
		$this->setdenunciaid($row["tdenunciaid"]);
                $this->setRepresentanteLegal($row["crepresentantelegal"]);
                $this->setEsMenor($row["cesmenor"]); 
                $this->setTipoDocumento($row["ntipodocumento"]);                
                $this->setTelefono($row["ctelefono"]); 
                $this->setPersonaNatural($row["bpersonanatural"]);
                $this->setNombreAsumido($row["cnombreasumido"]);
                $this->setRTN($row["crtn"]);
                $this->setbApoderado($row["bapoderadolegal"]);
                $this->setApoderadoNombre($row["capoderadolegal"]);
                $this->setApoderadoColegio($row["ccolegioabogado"]);
//exit($row[cTelefono]);                                
                //recostruir la lista de ofendido existentes
		$rsCursor= $objORM->RecuperarListaOfendidos($valdenuncia);
                
                $oOfendidoIndice= 0;
                while($row = pg_fetch_array($rsCursor)){
                    if(!isset($oOfendidoCola)){
                        $oOfendidoCola= $row["tpersonaid"];
                    }
                    else{
                        $oOfendidoCola= $oOfendidoCola.",".$row["tpersonaid"];
                    }                    
                    $oOfendidoIndice++;
                }                 
                $oOfendidoCola= substr($oOfendidoCola, 1);
                
                //publicar las variables en las session
//                session_start();
                $_SESSION['oOfendidoIndice']= $oOfendidoIndice;
                $_SESSION['oOfendidoCola']= $oOfendidoCola;                 
  }  
}
?>
