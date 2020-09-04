<?php



class Articulo {
  private $ArticuloId = 0;

  private $Descripcion = "";

  private $UnidadMedida = "";

  final public function getDescripcion()
  {
    return $this->Descripcion;
  }

  public function setDescripcion($value)
  {
    $this->Descripcion = $value;
  }

  final public function getArticuloId()
  {
    return $this->ArticuloId;
  }

  public function setArticuloId($value)
  {
    $this->ArticuloId = $value;
  }

  final public function getUnidadMedida()
  {
    return $this->UnidadMedida;
  }

  public function setUnidadMedida($value)
  {
    $this->UnidadMedida = $value;
  }

}
?>
