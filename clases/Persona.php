<?php

//Es la generalizazi�n para Denunciante, Ofendido e Imputado
class Persona {
  private $PersonaId;

  private $NombreCompleto;

  private $ApellidoCompleto;

  private $Identidad;
  private $TipoDocumento;

  private $Genero;
  private $GeneroTxt;
  
  private $Sexo;
  private $SexoTxt;  

  private $Profesion;
  private $ProfesionTxt;

  private $Ocupacion;
  private $OcupacionTxt;

  private $Escolaridad;
  private $EscolaridadTxt;

  private $Nacionalidad;
  private $NacionalidadTxt;

  private $EstadoCivil;
  private $EstadoCivilTxt;

  private $GrupoEtnico;
  private $GrupoEtnicoTxt;

  private $Discapacidad;
  private $DiscapacidadTxt;

  private $Edad;

  private $UmeDidaEdad;
  private $UmeDidaEdadTxt;

  private $RangoEdad;
  private $RangoEdadTxt;

  private $Departamentoid;
  private $DepartamentoidTxt;

  private $Municipioid;
  private $MunicipioidTxt;

  private $AldeaId;
  private $AldeaIdTxt;

  private $BarrioId;
  private $BarrioIdTxt;

  private $Detalle;

  private $OrientacionSex;
  private $OrientacionSexTxt;

  private $TxtDireccion;
  
  private $Telefono;
  
  private $PersonaNatural;
  
  private $RTN;
  
  private $IntegraLGBTI;

  public function setIntegraLGBTI($value){
        $this->IntegraLGBTI = $value;
      
  }
  final public function getIntegraLGBTI(){
      return $this->IntegraLGBTI;      
  }  
  
  public function setRTN($value){$this->RTN = $value;}
  final public function getRTN(){return $this->RTN;}  
  
  public function setPersonaNatural($value){$this->PersonaNatural = $value;}
  final public function getPersonaNatural(){return $this->PersonaNatural;}
  
  public function setTelefono($value){$this->Telefono = strtoupper($value);}
  final public function getTelefono(){return $this->Telefono;}
  
  public function setTxtDireccion($value){$this->TxtDireccion = strtoupper($value);}
  final public function getTxtDireccion(){return $this->TxtDireccion;}

  public function setProfesionTxt($value){$this->ProfesionTxt= strtoupper($value); }
  final public function getProfesionTxt(){return $this->ProfesionTxt;}

  public function setOcupacionTxt($value){$this->OcupacionTxt= strtoupper($value); }
  final public function getOcupacionTxt(){return $this->OcupacionTxt;}

  public function setEscolaridadTxt($value){$this->EscolaridadTxt= strtoupper($value); }
  final public function getEscolaridadTxt(){return $this->EscolaridadTxt;}

  public function setNacionalidadTxt($value){$this->NacionalidadTxt= strtoupper($value); }
  final public function getNacionalidadTxt(){return $this->NacionalidadTxt;}

  public function setEstadoCivilTxt($value){$this->EstadoCivilTxt= strtoupper($value); }
  final public function getEstadoCivilTxt(){return $this->EstadoCivilTxt;}

  public function setGrupoEtnicoTxt($value){$this->GrupoEtnicoTxt= strtoupper($value); }
  final public function getGrupoEtnicoTxt(){return $this->GrupoEtnicoTxt;}

  public function setDiscapacidadTxt($value){$this->DiscapacidadTxt= strtoupper($value); }
  final public function getDiscapacidadTxt(){return $this->DiscapacidadTxt;}

  public function setUmeDidaEdadTxt($value){$this->UmeDidaEdadTxt= strtoupper($value); }
  final public function getUmeDidaEdadTxt(){return $this->UmeDidaEdadTxt;}

  public function setRangoEdadTxt($value){$this->RangoEdadTxt= strtoupper($value); }
  final public function getRangoEdadTxt(){return $this->RangoEdadTxt;}

  public function setDepartamentoidTxt($value){$this->DepartamentoidTxt= strtoupper($value); }
  final public function getDepartamentoidTxt(){return $this->DepartamentoidTxt;}

  public function setMunicipioidTxt($value){$this->MunicipioidTxt= strtoupper($value); }
  final public function getMunicipioidTxt(){return $this->MunicipioidTxt;}

  public function setAldeaIdTxt($value){$this->AldeaIdTxt= strtoupper($value); }
  final public function getAldeaIdTxt(){return $this->AldeaIdTxt;}

  public function setBarrioIdTxt($value){$this->BarrioIdTxt= strtoupper($value); }
  final public function getBarrioIdTxt(){return $this->BarrioIdTxt;}

  public function setGeneroTxt($value){$this->GeneroTxt= strtoupper($value); }
  final public function getGeneroTxt(){return $this->GeneroTxt;}

  public function setSexoTxt($value){$this->SexoTxt= strtoupper($value); }
  final public function getSexoTxt(){return $this->SexoTxt;}
  
  public function setOrientacionSexTxt($value){$this->OrientacionSexTxt= strtoupper($value); }
  final public function getOrientacionSexTxt(){return $this->OrientacionSexTxt;}

  final public function getPersonaId()
  {
    return $this->PersonaId;
  }

  public function setPersonaId($value)
  {
    $this->PersonaId = $value;
  }

  final public function getTipoDocumento()
  {
    return $this->TipoDocumento;
  }

  public function setTipoDocumento($value)
  {
    if ($value== NULL)
        $value= 0;          
    $this->TipoDocumento = strtoupper($value);
  }  

  final public function getNombreCompleto()
  {
    return $this->NombreCompleto;
  }

  public function setNombreCompleto($value)
  {
//    if (is_null($value) || $value=='')
//        $value= '-- Desconocido --';
    $this->NombreCompleto = strtoupper($value);
  }

  final public function getApellidoCompleto()
  {
    return $this->ApellidoCompleto;
  }

  public function setApellidoCompleto($value)
  {
//    if (is_null($value) || $value=='')
//        $value= '-- Desconocido --';      
    $this->ApellidoCompleto = strtoupper($value);
  }

  final public function getIdentidad()
  {
    return $this->Identidad;
  }

  public function setIdentidad($value)
  {
    $this->Identidad = $value;
  }

  final public function getGenero()
  {
    return $this->Genero;
  }

  public function setGenero($value)
  {
    $this->Genero = $value;
  }

  final public function getSexo()
  {
    return $this->Sexo;
  }

  public function setSexo($value)
  {
    $this->Sexo = $value;
  }  
  
  
  final public function getProfesion()
  {
    return $this->Profesion;
  }

  public function setProfesion($value)
  {
    if ($value== NULL)
        $value= 0;      
    $this->Profesion = $value;
  }

  final public function getOcupacion()
  {
    return $this->Ocupacion;
  }

  public function setOcupacion($value)
  {
    if ($value== NULL)
        $value= 0;
    $this->Ocupacion = $value;
  }

  final public function getEscolaridad()
  {
    return $this->Escolaridad;
  }

  public function setEscolaridad($value)
  {
    if ($value== NULL)
        $value= 0;      
    $this->Escolaridad = $value;
  }

  final public function getNacionalidad()
  {
    return $this->Nacionalidad;
  }

  public function setNacionalidad($value)
  {
    if ($value== NULL)
        $value= "AA";      
    $this->Nacionalidad = $value;
  }

  final public function getEstadoCivil()
  {
    return $this->EstadoCivil;
  }

  public function setEstadoCivil($value)
  {
    if ($value== NULL)
        $value= 0;      
    $this->EstadoCivil = $value;
  }

  final public function getGrupoEtnico()
  {
    return $this->GrupoEtnico;
  }

  public function setGrupoEtnico($value)
  {
    if ($value== NULL)
        $value= 0;      
    $this->GrupoEtnico = $value;
  }

  final public function getDiscapacidad()
  {  
    return $this->Discapacidad;
  }

  public function setDiscapacidad($value)
  {
    if ($value== NULL)
        $value= 0;          
    $this->Discapacidad = $value;
  }

  public function setEdad($value)
  {
        if (is_numeric($value))
            $this->Edad= $value;
        else
            $this->Edad= 0;
  }

  final public function getEdad()
  {
    return $this->Edad;
  }

  public function setUmeDidaEdad($value)
  {
	$this->UmeDidaEdad= $value;
  }

  final public function getUmeDidaEdad()
  {
    return $this->UmeDidaEdad;
  }

  public function setRangoEdad($value){
	$this->RangoEdad= $value;
  }

  final public function getRangoEdad()
  {
    return $this->RangoEdad;
  }

  public function setDepartamentoid($value){
      if (!isset($value)) $value= '0';
      if ($value== '')
          $value= '0';
	$this->Departamentoid= $value;
  }

  final public function getDepartamentoid()
  {
    return $this->Departamentoid;
  }

  public function setMunicipioid($value){
      if ($value== '')
          $value= '0';
	$this->Municipioid= $value;
  }

  final public function getMunicipioid()
  {
    return $this->Municipioid;
  }

  public function setAldeaId($value){
      if ($value== '')
          $value= '0';      
	$this->AldeaId= $value;
  }

  final public function getAldeaId()
  {
    return $this->AldeaId;
  }

  public function setBarrioId($value){
      if ($value== '')
          $value= '0';      
	$this->BarrioId= $value;
  }

  final public function getBarrioId()
  {
    return $this->BarrioId;
  }

  public function setDetalle($value){
	$this->Detalle= strtoupper($value);
  }

  final public function getDetalle()
  {
    return $this->Detalle;
  }

  public function setOrientacionSex($value){
	$this->OrientacionSex= $value;
  }

  final public function getOrientacionSex()
  {
    return $this->OrientacionSex;
  }
}
?>
