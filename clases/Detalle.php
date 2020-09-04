<?php


require_once 'Articulo.php';

class Detalle {
  private $Cantidad = 0;

  private $PrecioTotal = 0;

  final public function getCantidad()
  {
    return $this->Cantidad;
  }

  public function setCantidad($value)
  {
    $this->Cantidad = $value;
  }

  final public function getPrecioTotal()
  {
    return $this->PrecioTotal;
  }

  public function setPrecioTotal($value)
  {
    $this->PrecioTotal = $value;
  }

  private $Articulo;


}
?>
