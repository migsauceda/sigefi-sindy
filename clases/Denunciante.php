<?php
//include_once("../clases/class_conexion_pg.php");
require_once 'Persona.php';

require_once '../denuncia/ORM_Denunciante.php';

//Un denunciante puede participar en varias denuncias, y es una especializaci�n de la clase Persona
class Denunciante extends Persona {
  private $RelacionImputado;
  private $Conocido;
  private $tdenunciaid;
  private $ApoderadoNombre;
  private $ApoderadoColegio;
  private $bApoderado;
  private $NombreAsumido;

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
  
  final public function getRelacionImputado()
  {
    return $this->RelacionImputado;
  }

  public function setRelacionImputado($value)
  {
    $this->RelacionImputado = $value;
  }

  final public function getConocido()
  {
    return $this->Conocido;
  }

  public function setConocido($value)
  {
    $this->Conocido = $value;
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
  public function Guardar()
  {

	$objORM= new ORM_Denunciante;

	$objORM->GuardarDenunciante($this);
  }

  public function Modificar()
  {

	$objORM= new ORM_Denunciante;

	$objORM->ModificarDenunciante($this);
  }


//recuperar denunciante de disco, recupera el primero
  public function Recuperar($value)
  { 
		//$value representa numero de denuncia
		$objORM= new ORM_Denunciante;

		$rsCursor= $objORM->RecuperarDenunciante($value);

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
                $this->setTxtDireccion($row["cdireccion"]);
                $this->setTipoDocumento($row["ntipodocumento"]);
                $this->setTelefono($row["ctelefono"]);
                $this->setApoderadoNombre($row["capoderadolegal"]);
                $this->setApoderadoColegio($row["ccolegioabogado"]);
                $this->setbApoderado($row["bapoderadolegal"]);
                $this->setPersonaNatural($row["bpersonanatural"]);
                $this->setRTN($row["crtn"]);
                $this->setIntegraLGBTI($row["aplicalgbti"]);
                $this->setNombreAsumido($row["cnombreasumido"]);
                
                //recostruir la lista de imputados existentes
		$rsCursor= $objORM->RecuperarListaDenunciante($value);
                
                $oDenuncianteIndice= 0;
                while($row = pg_fetch_array($rsCursor)){
                    $oDenuncianteCola= $oDenuncianteCola.",".$row["tpersonaid"];
                    $oDenuncianteIndice++;
                }                 
                $oDenuncianteCola= substr($oDenuncianteCola, 1);               
                //publicar las variables en las session
                session_start();
                $_SESSION['oDenuncianteIndice']= $oDenuncianteIndice;
                $_SESSION['oDenuncianteCola']= $oDenuncianteCola;                
  }
  
//recuperar denunciante de disco, recupera según numeros de denuncia y denunciante
  public function RecuperarId($valdenuncia, $valdenunciante)
  {
		//$value representa numero de denuncia
		$objORM= new ORM_Denunciante;

		$rsCursor= $objORM->RecuperarDenuncianteId($valdenuncia, $valdenunciante);

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
                $this->setTxtDireccion($row["cdireccion"]);
                $this->setTipoDocumento($row["ntipodocumento"]);
                $this->setTelefono($row["ctelefono"]);
                $this->setApoderadoNombre($row["capoderadolegal"]);
                $this->setApoderadoColegio($row["ccolegioabogado"]);
                $this->setbApoderado($row["bapoderadolegal"]);                
                $this->setPersonaNatural($row["bpersonanatural"]);
                $this->setRTN($row["crtn"]);
                $this->setIntegraLGBTI($row["aplicalgbti"]);
                $this->setNombreAsumido($row["cnombreasumido"]);

                //recostruir la lista de imputados existentes
		$rsCursor= $objORM->RecuperarListaDenunciante($valdenuncia);
                
                $oDenuncianteIndice= 0;
                while($row = pg_fetch_array($rsCursor)){
                    if (!isset($oDenuncianteCola)){
                        $oDenuncianteCola= $row["tpersonaid"];
                    }else{
                        $oDenuncianteCola= $oDenuncianteCola.",".$row["tpersonaid"];
                    }                    
                    $oDenuncianteIndice++;
                }                 
                $oDenuncianteCola= substr($oDenuncianteCola, 1);
                
                //publicar las variables en las session
//                session_start();
                $_SESSION['oDenuncianteIndice']= $oDenuncianteIndice;
                $_SESSION['oDenuncianteCola']= $oDenuncianteCola;                  
  }  
}
?>