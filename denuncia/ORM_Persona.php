<?php


require_once 'Persona.php';

class ORM_Persona {
  private $Persona;

  final public function getPersona()
  {
    return $this->Persona;
  }

  public function setPersona($value)
  {
    $this->Persona = $value;
  }

}
?>
