<?php
require_once 'Persona.php';
require_once '../denuncia/ORM_Imputado.php';

//Un imputado puede participar en varias denuncias, y es una especializaci�n de la clase Persona
class Imputado extends Persona {
  private $FiscalAsignado;

  private $Fiscalia;

  private $Conocido;
  
  private $Objetos;
  private $TotalObjetos;  
  
  private $Transporte;
  private $TotalTransporte;  

  private $Armas;
  private $TotalArmas;
  
  private $Alias;
  private $TotalAlias;

  private $Delitos;
  private $TotalDelitos;
  
  private $Culposos;
  private $Tentativas;

  private $Infractor;

  private $Representante;

  private $tdenunciaid;

//  private $FicalAsignadoHistorial;
  
  public $ProximoReg;
  private $ApoderadoNombre;
  private $ApoderadoColegio;
  private $bApoderado;
  
  private $Movil;  
  private $CondicionAgresor;
  private $TrabajoRemunerado;
  private $AsisteEducacion;
  
  final public function getMovil(){
      return $this->Movil;
  }
    
  public function setMovil($value){
      $this->Movil= $value;
  }

  final public function getCondicionAgresor(){
      return $this->CondicionAgresor;
  }
  
  public function setCondicionAgresor($value){
      $this->CondicionAgresor= $value;
  }
  
  final public function getTrabajoRemunerado(){
      return $this->TrabajoRemunerado;
  }
  
  public function setTrabajoRemunerado($value){
     $this->TrabajoRemunerado= $value; 
  }
  
  final public function getAsisteEducacion(){
      return $this->AsisteEducacion;
  }
  
  public function setAsisteEducacion($value){
      $this->AsisteEducacion= $value;
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

  function __construct()
  {
	
  }

  final public function getInfractor()
  {
        return $this->Infractor;
  }

  public function setInfractor($value)
  {
      $this->Infractor= $value;
  }

  final public function getRepresentante()
  {
        return $this->Representante;
  }

  public function setRepresentante($value)
  {
      $this->Representante= $value;
  }

  final public function getConocido()
  {
	return $this->Conocido;
  }

  public function setConocido($value)
  {
	$this->Conocido= $value;
  }

  final public function getFiscalAsignado()
  {
    return $this->FiscalAsignado;
  }

  public function setFiscalAsignado($value)
  {
    $this->FiscalAsignado = $value;
  }

  final public function getFiscalia()
  {
    return $this->Fiscalia;
  }

  public function setFiscalia($value)
  {
    $this->Fiscalia = $value;
  }
  
//
  final public function getTransporte()
  {
	return $this->Transporte;
  }

  public function setTransporte($value)
  {
      //$value es una cadena con elementos separados por ;
      //se cambia el ; por , y se elimina la ultima que no esta seguida de algo
      //ejm: viene: alias1;alias2; se cambia por alias1,alias2 se borro el ultimo
      
      $tmp= str_replace(";", ",", $value);
      $tam= strlen($tmp);
      if (substr($tmp,$tam-1,1)== ",")
              $tmp= substr($tmp,0,$tam-1);
      
	$this->Transporte= $tmp;   
  }

  public function setTotalTransporte($value)
  {
	$this->TotalTransporte= $value;
  }

  final public function getTotalTransporte()
  {
	return $this->TotalTransporte;
  }
//      
//
  final public function getArmas()
  {
	return $this->Armas;
  }

  public function setArmas($value)
  {
      //$value es una cadena con elementos separados por ;
      //se cambia el ; por , y se elimina la ultima que no esta seguida de algo
      //ejm: viene: alias1;alias2; se cambia por alias1,alias2 se borro el ultimo
      
      $tmp= str_replace(";", ",", $value);
      $tam= strlen($tmp);
      if (substr($tmp,$tam-1,1)== ",")
              $tmp= substr($tmp,0,$tam-1);
      
	$this->Armas= $tmp;   
  }

  public function setTotalArmas($value)
  {
	$this->TotalArmas= $value;
  }

  final public function getTotalArmas()
  {
	return $this->TotalArmas;
  }
//      
//
  final public function getObjetos()
  {
	return $this->Objetos;
  }

  public function setObjetos($value)
  {
      //$value es una cadena con elementos separados por ;
      //se cambia el ; por , y se elimina la ultima que no esta seguida de algo
      //ejm: viene: alias1;alias2; se cambia por alias1,alias2 se borro el ultimo
      
      $tmp= str_replace(";", ",", $value);
      $tam= strlen($tmp);
      if (substr($tmp,$tam-1,1)== ",")
              $tmp= substr($tmp,0,$tam-1);
      
	$this->Objetos= $tmp;   
  }

  public function setTotalObjetos($value)
  {
	$this->TotalObjetos= $value;
  }

  final public function getTotalObjetos()
  {
	return $this->TotalObjetos;
  }

//  
  final public function getAlias()
  {
	return $this->Alias;
  }

  public function setAlias($value)
  {
      //$value es una cadena con elementos separados por ;
      //se cambia el ; por , y se elimina la ultima que no esta seguida de algo
      //ejm: viene: alias1;alias2; se cambia por alias1,alias2 se borro el ultimo
      
      $tmp= str_replace(";", ",", $value);
      $tam= strlen($tmp);
      if (substr($tmp,$tam-1,1)== ",")
              $tmp= substr($tmp,0,$tam-1);
      
	$this->Alias= strtoupper($tmp);   
  }

  public function setTotalAlias($value)
  {
	$this->TotalAlias= $value;
  }

  final public function getTotalAlias()
  {
	return $this->TotalAlias;
  }

  final public function getDelitos()
  {
	return $this->Delitos;
  }

  public function setDelitos($value)
  {
      //$value es una cadena con elementos separados por ;
      //se cambia el ; por , y se elimina la ultima que no esta seguida de algo
      //ejm: viene: 23;56; se cambia por 23,56 se borro el ultimo
      
      $tmp= str_replace(";", ",", $value);
      $tam= strlen($tmp);
      if (substr($tmp,$tam-1,1)== ",")
              $tmp= substr($tmp,0,$tam-1);
      
	$this->Delitos= $tmp;
  }

  public function setTotalDelitos($value)
  {
	$this->TotalDelitos= $value;
  }

  final public function getTotalDelitos()
  {
	return $this->TotalDelitos;
  }
//-----------
    public function setCulposos($value) {
      $tmp= str_replace(";", ",", $value);
      $tam= strlen($tmp);
      if (substr($tmp,$tam-1,1)== ",")
              $tmp= substr($tmp,0,$tam-1);
      
	        $this->Culposos= $tmp;        
    }

    public function getCulposos() {
        return $this->Culposos;
    }
    
    public function getTentativas(){
        return $this->Tentativas;
    }

    public function setTentativas($value) {
      $tmp= str_replace(";", ",", $value);
      $tam= strlen($tmp);
      if (substr($tmp,$tam-1,1)== ",")
              $tmp= substr($tmp,0,$tam-1);
      
	$this->Tentativas= $tmp;        
    }
//--------------
  final public function getDenunciaid()
  {
    return $this->tdenunciaid;
  }

  public function setDenunciaid($value)
  {
    $this->tdenunciaid = $value;
  }


  //otros metodos
  public function Guardar()
  {

	$objORM= new ORM_Imputado;

	$objORM->GuardarImputado($this);
  }


  public function Modificar()
  {

	$objORM= new ORM_Imputado;
      
	$objORM->ModificarImputado($this);
  }

//recuperar lista de delitos asignados
  public function RecuperarAlias(){
      $objORM= new ORM_Imputado;
      
      $rsCursor= $objORM->RecuperarAlias($this->getPersonaId());
      
      return $rsCursor;
  }  
  
//recuperar lista de delitos asignados
  public function RecuperarDelitos(){ 
      $objORM= new ORM_Imputado;
      
      $rsCursor= $objORM->RecuperarDelitos($this->getPersonaId());

      return $rsCursor; 
  }
  
//recuperar denunciante de disco
  public function Recuperar($value)
  {     
		//$value representa numero de denuncia
		$objORM= new ORM_Imputado;

		$rsCursor= $objORM->Recuperarimputado($value);

                $row = pg_fetch_array($rsCursor); 
                
		//$this->ProximoReg= $value;
		//$row = pg_fetch_array($rsCursor,$this->ProximoReg);
                               
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
                $this->setRepresentante($row["crepresentantelegalmenor"]);
                $this->setInfractor($row["bmenorinfractor"]);
                $this->setTxtDireccion($row["cdireccion"]);
                $this->setTipoDocumento($row["ntipodocumento"]);
                $this->setTelefono($row["ctelefono"]);
                $this->setApoderadoNombre($row["capoderadolegal"]);
                $this->setApoderadoColegio($row["ccolegioabogado"]);                
                $this->setPersonaNatural($row["bpersonanatural"]);
                $this->setRTN($row["crtn"]);
                $this->setCondicionAgresor($row["ccondicion"]);
                $this->setTrabajoRemunerado($row["ctrabajoremunerado"]);
                $this->setAsisteEducacion($row["casisteeducacion"]);                
                $this->setIntegraLGBTI($row["aplicalgbti"]);
                $this->setSexo($row["csexo"]);
                //recostruir la lista de imputados existentes
		$rsCursor= $objORM->RecuperarListaImputados($value);
                
                $oDenunciadoIndice= 0;
                while($row = pg_fetch_array($rsCursor)){
                    if(!isset($oDenunciadoCola)){
                        $oDenunciadoCola= $row["tpersonaid"];
                    }
                    else{
                        $oDenunciadoCola= $oDenunciadoCola.",".$row["tpersonaid"];
                    }
                    $oDenunciadoIndice++;
                }                 
                $oDenunciadoCola= substr($oDenunciadoCola, 1);
                
                //publicar las variables en las session
//                session_start();
                $_SESSION['oDenunciadoIndice']= $oDenunciadoIndice;
                $_SESSION['oDenunciadoCola']= $oDenunciadoCola;
//                exit($oDenunciadoIndice.$oDenunciadoCola); 
  }

//recuperar denunciante de disco
  public function RecuperarId($valdenuncia, $valdenunciado)
  {     
		//$value representa numero de denuncia
		$objORM= new ORM_Imputado;
                
		$rsCursor= $objORM->RecuperarimputadoId($valdenuncia, $valdenunciado);
                $row = pg_fetch_array($rsCursor); 
                
		//$this->ProximoReg= $value;
		//$row = pg_fetch_array($rsCursor,$this->ProximoReg);
                               
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
                $this->setRepresentante($row["crepresentantelegalmenor"]);
                $this->setInfractor($row["bmenorinfractor"]);
                $this->setTxtDireccion($row["cdireccion"]);
                $this->setTipoDocumento($row["ntipodocumento"]);
                $this->setTelefono($row["ctelefono"]);
                $this->setApoderadoNombre($row["capoderadolegal"]);
                $this->setApoderadoColegio($row["ccolegioabogado"]);
                $this->setPersonaNatural($row["bpersonanatural"]);
                $this->setRTN($row["crtn"]);
                $this->setCondicionAgresor($row["ccondicion"]);
                $this->setTrabajoRemunerado($row["ctrabajoremunerado"]);
                $this->setAsisteEducacion($row["casisteeducacion"]);                
                $this->setIntegraLGBTI($row["aplicalgbti"]);
                $this->setSexo($row["csexo"]);
                //recostruir la lista de imputados existentes
		$rsCursor= $objORM->RecuperarListaImputados($valdenuncia);
                
                $oDenunciadoIndice= 0;
                while($row = pg_fetch_array($rsCursor)){
                    if (!isset($oDenunciadoCola)){
                        $oDenunciadoCola= $row["tpersonaid"];
                    }
                    else{
                        $oDenunciadoCola= $oDenunciadoCola.",".$row["tpersonaid"];
                    }
                    $oDenunciadoIndice++;
                }                 
                $oDenunciadoCola= substr($oDenunciadoCola, 1);
                
                //publicar las variables en las session
//                session_start();
                $_SESSION['oDenunciadoIndice']= $oDenunciadoIndice;
                $_SESSION['oDenunciadoCola']= $oDenunciadoCola; 
  }  
}
?>