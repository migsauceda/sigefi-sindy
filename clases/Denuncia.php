<?php


//require_once 'Denunciante.php';
//require_once 'Ofendido.php';
//require_once 'Imputado.php';
//require_once 'ActividadProcesal.php';
//
require_once '../denuncia/ORM_Denuncia.php';

 
//Una denuncia esta formada por al menos un denunciante, un ofendido, un imputado y una actividad procesal
class Denuncia {
  private $DenunciaId;

  //Numero de denuncia SEDI
  private $Numero;

  //expediente judicial
  private $ExpedienteJudicial;

  //expediente laboral
  private $ExpedientePolicial;

  //Fecha de elaboraci�n
  private $FechaDenuncia;
  private $HoraDenuncia;

  //Fecha en la que ocurri� lo denunciado
  private $FechaHecho;
  private $HoraHecho;

  //Departamento del pa�s en la que se presenta la denuncia
  private $DepartamentoDenuncia;

  //Municipio del pa�s en la que se presenta la denuncia
  private $MunicipioDenuncia;

  //Texto de la direccion donde se tomo denuncia: depto, muni
  private $TxtDireccionDenuncia;

  //Departamento del pa�s en la que se realiz� el hecho denunciado
  private $DepartamentoHecho;

  //Departamento del pa�s en la que se realiz� el hecho denunciado
  private $MunicipioHecho;

  //Aldea o caserio del pa�s en la que se realiz� el hecho denunciado
  private $AldeaCaserioHecho;

  //Barrio o colonia del pa�s en la que se realiz� el hecho denunciado
  private $BarrioColoniaHecho;

  //Detalle de la direccion, color de casa, cuadra, pulperia, etc
  private $DetalleDireccion;

  //Texto de la direccion: depto, muni, ciudad
  private $TxtDireccionHecho;

  //Puede ser en sede judicial o policial
  private $LugarRecepcion;

  //narracion corta del hecho
  private $NarracionHecho;

  //Tendra varios estados, el jefe aprobar� la informacio�n como parte de la validaci�n de la misma
  //P. pendiente
  //A. aprobada
  //R. tiene reparo por parte del jefe
  private $Estado;

  private $Usuario;
  
  private $LugarHecho;
  
  private $Autopsia;  
  private $Levantamiento;  
  private $Transito;
  private $TomaTurno;  
  
  final public function getTomaTurno()
  {
      return $this->TomaTurno;
  }
  
  public function setTomaTurno($value) {
      $this->TomaTurno= $value;
  }  
  
  final public function getTransito()
  {
      return $this->Transito;
  }
  
  public function setTransito($value) {
      $this->Transito= $value;
  }
  
  final public function getLevantamiento()
  {
      return $this->Levantamiento;
  }
  
  public function setLevantamiento($value) {
      $this->Levantamiento= $value;
  }
  
  final public function getAutopsia()
  {
      return $this->Autopsia;
  }
  
  public function setAutopsia($value) {
      $this->Autopsia= $value;
  }
  
  final public function getLugarHecho()
  {
      return $this->LugarHecho;
  }
  
  public function setLugarHecho($value) {
      $this->LugarHecho= $value;
  }

  final public function getUsuario()
  {
    return $this->Usuario;
  }

  public function setUsuario($value)
  {
    $this->Usuario = $value;
  }

  final public function getDenunciaId() 
  {
    return $this->DenunciaId;
  }

  public function setDenunciaId($value)
  {
    $this->DenunciaId = $value;
  }

  final public function getNumero()
  {
    return $this->Numero;
  }

  public function setNumero($value)
  {
    $this->Numero = strtoupper($value);
  }

  final public function getExpedienteJudicial()
  {
    return $this->ExpedienteJudicial;
  }

  public function setExpedienteJudicial($value)
  {
    $this->ExpedienteJudicial = strtoupper($value);
  }

  final public function getExpedientePolicial()
  {
    return $this->ExpedientePolicial;
  }

  public function setExpedientePolicial($value)
  {
    $this->ExpedientePolicial = strtoupper($value);
  }

  final public function getFechaDenunciaFormato()
  {
    //recibe 20121213 y retorna 13/12/2012
    $FechaAnsi= substr($this->FechaDenuncia,6,2)."/".
    substr($this->FechaDenuncia,4,2)."/".substr($this->FechaDenuncia,0,4);
    
    $FechaAnsi= $FechaAnsi." ".$this->HoraDenuncia;
            
    return $FechaAnsi;
  }

  final public function getHoraDenuncia()
  {
    return $this->HoraDenuncia;
  }
  
  final public function getFechaDenuncia()
  {
    return $this->FechaDenuncia;
  }

  public function setFechaDenuncia($value)
  {
    // viene con este formato:  27/04/2011  y se transfroma a 20110427
    //nota al incluir la hora la linea anterior queda sin efecto y la info se recibe asi:
    // 99/99/9999 00:00 am
    $FechaAnsi= substr($value,6,4).substr($value,3,2).substr($value,0,2);
    $this->FechaDenuncia = $FechaAnsi;
    
    $HoraAnsi= substr($value,11,2).':'.substr($value,14,2);
    $this->HoraDenuncia = $HoraAnsi;
  }

  public function setHoraDenuncia($value){
      $this->HoraDenuncia= $value;
  }
  
  final public function getFechaHecho()
  {
    return $this->FechaHecho;
  }
  
  final public function getHoraHecho()
  {
    return $this->HoraHecho;
  }  

  final public function getFechaHechoFormato()
  {
    //recibe 20110423 y retorna 23/04/2011
    $FechaAnsi= substr($this->FechaHecho,6,2)."/".
    substr($this->FechaHecho,4,2)."/".substr($this->FechaHecho,0,4);
    
    $FechaAnsi= $FechaAnsi." ".$this->HoraHecho;
    
    if (substr($this->FechaHecho,0,4)== '1900' || $FechaAnsi== '//')
        $FechaAnsi= '';        
    
    return $FechaAnsi;
  }

  public function setFechaHecho($value)
  {
    if (!empty($value)){
        // viene con este formato:  27/04/2011  y se transfroma a 20110427
        $FechaAnsi= substr($value,6,4).substr($value,3,2).substr($value,0,2);
        $this->FechaHecho = $FechaAnsi;
        
        $HoraAnsi= substr($value,11,2).':'.substr($value,14,2);
        
//        $this->FechaHecho = '19000101';
        if($HoraAnsi== '') $HoraAnsi= '00:00';
        
        $this->HoraHecho = $HoraAnsi;        
    }
    else {
        $this->FechaHecho = '19000101';
        
//        if($HoraAnsi== '') $HoraAnsi= '00:00';
        $this->HoraHecho = '00:00';        
    }
  }

  public function setHoraHecho($value){
      if (!empty($value)){
          $this->HoraHecho= $value;
      }
      else{
          $this->HoraHecho = '00:00';
      }
  }

  final public function getDepartamentoDenuncia()
  {
    return $this->DepartamentoDenuncia;
  }

  public function setDepartamentoDenuncia($value)
  {
    if (!isset($value)) $value= '0';
    if ($value== '') $value= '0';
    $this->DepartamentoDenuncia = $value; 
  }

  final public function getMunicipioDenuncia()
  {
    return $this->MunicipioDenuncia;
  }

  public function setMunicipioDenuncia($value)
  {
    if (!isset($value)) $value= '0';
    if ($value== '') $value= '0';
    $this->MunicipioDenuncia = $value; 
  }

  public function setTxtDireccionDenuncia($value)
  {
      $this->TxtDireccionDenuncia = strtoupper($value);
  }

  final public function getTxtDireccionDenuncia()
  {
      return $this->TxtDireccionDenuncia;
  }

  final public function getDepartamentoHecho()
  {
    return $this->DepartamentoHecho;
  }

  public function setDepartamentoHecho($value)
  {
    if (!isset($value)) $value= '0';
    if ($value== '') $value= '0';
    $this->DepartamentoHecho = $value;
  }

  final public function getMunicipioHecho()
  {
    return $this->MunicipioHecho;
  }

  public function setMunicipioHecho($value)
  {
    if (!isset($value)) $value= '0';
    if ($value== '') $value= '0';
    $this->MunicipioHecho = $value;
  }

  final public function getAldeaCaserioHecho()
  {
    return $this->AldeaCaserioHecho;
  }

  public function setAldeaCaserioHecho($value)
  {
    if (!isset($value)) $value= '0';
    if ($value== '') $value= '0';
    $this->AldeaCaserioHecho = $value;
  }

  final public function getBarrioColoniaHecho()
  {
    return $this->BarrioColoniaHecho;
  }

  public function setBarrioColoniaHecho($value)
  {
    if (!isset($value)) $value= '0';
    if ($value== '') $value= '0';
    $this->BarrioColoniaHecho = $value;
  }

  final public function getDetalleDireccion()
  {
    return $this->DetalleDireccion;
  }

  public function setTxtDireccionHecho($value)
  {
      $this->TxtDireccionHecho = strtoupper($value);
  }

  final public function getTxtDireccionHecho()
  {
      return $this->TxtDireccionHecho;
  }

  public function setDetalleDireccion($value)
  {
    $this->DetalleDireccion = strtoupper($value);
  }

  final public function getLugarRecepcion()
  {
    return $this->LugarRecepcion;
  }

  public function setLugarRecepcion($value)
  {
    $this->LugarRecepcion = $value;
  }

  final public function getEstado()
  {
    return $this->Estado;
  }

  public function setEstado($value)
  {
    $this->Estado = $value;
  }

  final public function getNarracionHecho()
  {
    return $this->NarracionHecho;
  }

  public function setNarracionHecho($value)
  {
    $this->NarracionHecho = strtoupper(trim($value));
  }

//otros metodos
  public function Guardar()
  {
  $objORM= new ORM_Denuncia;

  $objORM->GuardarDenuncia($this);
  }

  public function Modificar()
  {
  $objORM= new ORM_Denuncia;

  $objORM->ModificarDenuncia($this);
  }
//recuperar denuncia de disco
  public function Recuperar($value)
  {
    $objORM= new ORM_Denuncia;
    
    $rsCursor= $objORM->RecuperarDenuncia($value);    
    
    $row = pg_fetch_array($rsCursor);
    $this->DenunciaId= $row[tdenunciaid];
    $this->Numero=  $row[cexpedientesedi];
    $this->ExpedienteJudicial=  $row[cexpedientejudicial];
                
                $this->HoraDenuncia= $row[thoradenuncia];
                $this->HoraHecho= $row[thorahecho];                
                
                //recibe 2012-12-13 y retorna 20121213
                $FechaAnsi= substr($row[dfechadenuncia],0,4).
                substr($row[dfechadenuncia],5,2).substr($row[dfechadenuncia],8,2);                    
                $this->FechaDenuncia= $FechaAnsi." ".$this->HoraDenuncia;
                
     
                //recibe 2012-12-13 y retorna 20121213
                $FechaAnsi= substr($row[dfechahecho],0,4).
                substr($row[dfechahecho],5,2).substr($row[dfechahecho],8,2);                                    
    $this->FechaHecho= $FechaAnsi." ".$this->HoraHecho;
                if ($this->FechaHecho== '19000101')
                    $this->FechaHecho= '';

    $this->DepartamentoDenuncia=  $row[cdeptodenuncia];
    $this->MunicipioDenuncia=   $row[cmunicipiodenuncia];
    $this->DepartamentoHecho=   $row[cdeptohecho];
    $this->MunicipioHecho=  $row[cmunicipiohecho];
    $this->AldeaCaserioHecho=   $row[caldeahecho];
    $this->BarrioColoniaHecho=  $row[ccaseriohecho];
    $this->LugarRecepcion=  $row[nlugarrecepcion];
    $this->Estado=    $row[cestadodenuncia];
    $this->DetalleDireccion=  $row[cdetalledireccionhecho];
    $this->NarracionHecho= $row[cnarracionhecho];
                $this->ExpedientePolicial=  $row[cexpedientepolicial];
                $this->LugarHecho= $row[nlugarid];
                
//    $objDenuncia->setDenunciaId('tdenunciaid');
//    $objDenuncia->setFechaDenuncia(dfechadenuncia);
//    $objDenuncia->setFechaHecho(dfechahecho);
//    $objDenuncia->setHoraDenuncia(thoradenuncia);
//    $objDenuncia->setHoraHecho(thorahecho);
//    $objDenuncia->setDepartamentoDenuncia(cdeptodenuncia);
//    $objDenuncia->setMunicipioDenuncia(cmunicipiodenuncia);
//    $objDenuncia->setDepartamentoHecho(cdeptohecho);
//    $objDenuncia->setMunicipioHecho(cmunicipiohecho);
//    $objDenuncia->setAldeaCaserioHecho(caldeahecho);
//    $objDenuncia->setBarrioColoniaHecho(ccaseriohecho);
//    $objDenuncia->setNarracionHecho(cnarracionhecho);
//    $objDenuncia->setEstado('A');
//    $objDenuncia->setLugarRecepcion(nlugarrecepcion);
//    $objDenuncia->setDetalleDireccion(cdetalledireccionhecho);                
  }
}
?>