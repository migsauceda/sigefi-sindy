<?php
/*
Funcion: Copiar los datos del obj denunciante al obj ofendido en caso de ser los mismos
Relacion: Formulario para crear nueva denuncia (datos ofendido) y modificarla
Actualizacion: 15nov2012
*/
//si existe el denunciante

require_once '../clases/Ofendido.php';  

require_once '../clases/Denunciante.php'; 

session_start();
if($_SESSION['denunciante']== 't'){
    //crear el ofendido o victima
    $_SESSION['ofendido']= 'f';   
    $oOfendido= new Ofendido();                       

    //hacer la copia
    $oDenunciante= $_SESSION["oDenunciante"];      

    $oOfendido->setConocido($oDenunciante->getConocido());
    
    $oOfendido->setPersonaNatural($oDenunciante->getPersonaNatural());
    
    $oOfendido->setPersonaId($oDenunciante->getPersonaId());
    $oOfendido->setNombreCompleto($oDenunciante->getNombreCompleto());
    $oOfendido->setApellidoCompleto($oDenunciante->getApellidoCompleto());
    
    $oOfendido->setIdentidad($oDenunciante->getIdentidad());
    $oOfendido->setTipoDocumento($oDenunciante->getTipoDocumento());    
    
    $oOfendido->setGenero($oDenunciante->getGenero());
    $oOfendido->setGeneroTxt($oDenunciante->getGeneroTxt());
    
    $oOfendido->setProfesion($oDenunciante->getProfesion());
    $oOfendido->setProfesionTxt($oDenunciante->getProfesionTxt());
    
    $oOfendido->setOcupacion($oDenunciante->getOcupacion());    
    $oOfendido->setOcupacionTxt($oDenunciante->getOcupacionTxt());
    
    $oOfendido->setEscolaridad($oDenunciante->getEscolaridad());
    $oOfendido->setEscolaridadTxt($oDenunciante->getEscolaridadTxt());
    
    $oOfendido->setNacionalidad($oDenunciante->getNacionalidad());
    $oOfendido->setNacionalidadTxt($oDenunciante->getNacionalidadTxt());
    
    $oOfendido->setEstadoCivil($oDenunciante->getEstadoCivil());
    $oOfendido->setEstadoCivilTxt($oDenunciante->getEstadoCivilTxt());
    
    $oOfendido->setGrupoEtnico($oDenunciante->getGrupoEtnico());
    $oOfendido->setGrupoEtnicoTxt($oDenunciante->getGrupoEtnicoTxt());
    
    $oOfendido->setDiscapacidad($oDenunciante->getDiscapacidad());    
    $oOfendido->setDiscapacidadTxt($oDenunciante->getDiscapacidadTxt());
    
    $oOfendido->setEdad($oDenunciante->getEdad());
    $oOfendido->setUmeDidaEdad($oDenunciante->getUmeDidaEdad());
    $oOfendido->setUmeDidaEdadTxt($oDenunciante->getUmeDidaEdadTxt());
    $oOfendido->setRangoEdad($oDenunciante->getRangoEdad());    
    $oOfendido->setRangoEdadTxt($oDenunciante->getRangoEdadTxt());   

    $oOfendido->setDepartamentoid($oDenunciante->getDepartamentoid());
    $oOfendido->setDepartamentoidTxt($oDenunciante->getDepartamentoidTxt());
    $oOfendido->setMunicipioid($oDenunciante->getMunicipioid());
    $oOfendido->setMunicipioidTxt($oDenunciante->getMunicipioidTxt());
    $oOfendido->setAldeaId($oDenunciante->getAldeaId());    
    $oOfendido->setAldeaIdTxt($oDenunciante->getAldeaIdTxt());           
    $oOfendido->setBarrioId($oDenunciante->getBarrioId());
    $oOfendido->setBarrioIdTxt($oDenunciante->getBarrioIdTxt());
    $oOfendido->setDetalle($oDenunciante->getDetalle());
    
    $oOfendido->setOrientacionSex($oDenunciante->getOrientacionSex());
    $oOfendido->setOrientacionSexTxt($oDenunciante->getOrientacionSexTxt());    
    $oOfendido->setTxtDireccion($oDenunciante->getTxtDireccion());     
    
    $oOfendido->setTelefono($oDenunciante->getTelefono());       
    
    $oOfendido->setNombreAsumido($oDenunciante->getNombreAsumido());
    
    $oOfendido->setbApoderado($oDenunciante->getbApoderado());
    $oOfendido->setApoderadoNombre($oDenunciante->getApoderadoNombre());
    $oOfendido->setApoderadoColegio($oDenunciante->getApoderadoColegio());
    $oOfendido->setRTN($oDenunciante->getRTN());
    
    $oOfendido->setNumeroHijos(-1);

    $_SESSION["oOfendido"]= $oOfendido;     
    $_SESSION['ofendido']= 't';
    
    include("../clases/class_conexion_pg.php");

    $oOfendido->Guardar('1'); 
    
//    require_once 'Ofendido.php';
    echo "Datos copiados con éxito";
}   
else{
    echo "No existen datos en Denunciante";
}
?>
