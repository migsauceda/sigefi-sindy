<?php


require_once 'Denuncia.php';

//Son todas las actividades que hace un fiscal una vez recibida la denuncia
class ActividadProcesal {
  private $FechaPresentacion;

  //Diligencia fiscal o judicial
  private $Tipo;

  private $Fiscal;

  //Mujer, ni�ez, tercera edad, etc
  private $Materia;

  private $Descripcion;

  private $Motivo;

  private $Etapa;


  final public function getFechaPresentacion()
  {
    return $this->FechaPresentacion;
  }

  public function setFechaPresentacion($value)
  {
    $this->FechaPresentacion = $value;
  }

  final public function getTipo()
  {
    return $this->Tipo;
  }

  public function setTipo($value)
  {
    $this->Tipo = $value;
  }

  final public function getFiscal()
  {
    return $this->Fiscal;
  }

  public function setFiscal($value)
  {
    $this->Fiscal = $value;
  }

  final public function getMateria()
  {
    return $this->Materia;
  }

  public function setMateria($value)
  {
    $this->Materia = $value;
  }

  final public function getDescripcion()
  {
    return $this->Descripcion;
  }

  public function setDescripcion($value)
  {
    $this->Descripcion = $value;
  }

  final public function getMotivo()
  {
    return $this->Motivo;
  }

  public function setMotivo($value)
  {
    $this->Motivo = $value;
  }

  final public function getEtapa()
  {
    return $this->Etapa;
  }

  public function setEtapa($value)
  {
    $this->Etapa = $value;
  }

}
?>
