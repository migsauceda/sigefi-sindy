<?php
	include("../clases/Imputado.php");
	include("../clases/class_conexion_pg.php");
        include("../funciones/php_funciones.php");

//iniciar session
session_start();

//crear objeto denunciante
$objImputado= new Imputado;

//recuperar el numero de denuncia de la variable de sesion y 
//guardarlo en el objeto
if(isset($_SESSION["oDenuncia"])){   
    if (isset($_SESSION['denunciaid'])){
        $objImputado->setDenunciaId($_SESSION['denunciaid']);    
    }
    else
    {
        echo "<script type='text/javascript'>
            alert('Error: No existe DenunciaId');
            </script>";
    }
}
else {
        echo "<script type='text/javascript'>
            alert('Error: No existe objeto Denuncia');
            </script>";    
}

//saber si es nuevo denunciante
if(!isset($_SESSION["oDenunciado"])){
    //id para persona, se crea si no existe obj denunciante
    $personaid= microtime(true);
    $personaid= floor($personaid);
    
    //asignar valores a las propiedades
    $objImputado->setPersonaId($personaid);    
}
else{
    if(isset($_POST["Denunciado3Jur"]) && $_POST["Denunciado3Jur"]== 'juridico'){
        $objImputado->setPersonaId($_POST["txtPersonaId3j"]);    
    }
    else {
        $objImputado->setPersonaId($_POST["txtPersonaId"]);    
    }
}

if(isset($_POST["Denunciado3Jur"]) && $_POST["Denunciado3Jur"]== 'juridico'){ 
    
    $objImputado->setNombreCompleto($_POST["txtEmpresasHn3"]);    
    $objImputado->setNacionalidad($_POST["cboNacionalidad3J"]);
    $objImputado->setDepartamentoid($_POST["cboDepto3J"]); 
    $objImputado->setMunicipioid($_POST["cboMuni3J"]);
    $objImputado->setAldeaId($_POST["cboAldea3J"]);
    $objImputado->setBarrioId($_POST["cboBarrio3J"]);
    $objImputado->setDetalle($_POST["txtDireccionJuridica3"]);
    $objImputado->setTxtDireccion($_POST["txtDireccionJuridica3"]);
    $objImputado->setTipoDocumento($_POST["cboTipoDoc3"]);
    $objImputado->setTelefono($_POST["txtTelefono3"]);
    $objImputado->setRTN($_POST["txtRtn3"]);

    //apoderado legal
    $TipoDoc= $_POST["rdTipoDoc3"];
    if ($TipoDoc== "identidad"){
        $UsaApoderado= 'f';
        $objImputado->setIdentidad($_POST["txtColegio3J"]);
        $objImputado->setTipoDocumento(1);
    }
    elseif ($TipoDoc== "pasaporte"){
        $UsaApoderado= 'f';
        $objImputado->setIdentidad($_POST["txtColegio3J"]);
        $objImputado->setTipoDocumento(2);
    }
    elseif ($TipoDoc== "colegio"){
        $UsaApoderado= 't';
        $objImputado->setIdentidad($_POST["txtColegio3J"]);
        $objImputado->setTipoDocumento(5);
        $objImputado->setApoderadoColegio($_POST["txtColegio3J"]);        
    }

    $objImputado->setbApoderado($UsaApoderado);      
    $objImputado->setApoderadoNombre($_POST["txtApoderado3J"]);
//    $objImputado->setRepresentante($_POST[txtApoderado3J]);
    
    $objImputado->setEstadoCivil(0);
    $objImputado->setEscolaridad(0);
    $objImputado->setProfesion(0);
    $objImputado->setOcupacion(0);
    $objImputado->setGrupoEtnico(0);
    $objImputado->setDiscapacidad(0);
    
    $objImputado->setEdad(0);
    $objImputado->setGenero('x');
    $objImputado->setRangoEdad('x');
    $objImputado->setUmeDidaEdad('x');

    $Conocido= '-1';    
    $objImputado->setConocido($Conocido);    
    $objImputado->setOrientacionSex('N');
    $objDenunciante->setIntegraLGBTI('f'); 
    $objImputado->setPersonaNatural(0);        
    
    //movil no tiene
    $objImputado->setMovil(1); 
  
    //delitos 
    $objImputado->setDelitos($_POST["txtTodosDelitos3j"]); 
}  else 
{
    $objImputado->setPersonaNatural(1); 
    //asignar valores a las propiedades
    $objImputado->setNombreCompleto($_POST["txtNombres"]);

    $objImputado->setApellidoCompleto($_POST["txtApellidos"]);

    $objImputado->setIdentidad($_POST["txtIdentidad3"]);

    $objImputado->setProfesion($_POST["cboProfe3"]);

    $objImputado->setOcupacion($_POST["cboOcupa3"]);

    $objImputado->setEscolaridad($_POST["cboEscolar3"]);

    $objImputado->setNacionalidad($_POST["cboNacionalidad3"]);

    $objImputado->setEstadoCivil($_POST["cboCivil3"]);

    $objImputado->setGrupoEtnico($_POST["cboEtnia3"]);

    $objImputado->setDiscapacidad($_POST["cboDiscapacidad3"]);

    $objImputado->setEdad($_POST["txtEdad3"]);

    $objImputado->setDepartamentoid($_POST["cboDepto3"]);

    $objImputado->setMunicipioid($_POST["cboMuni3"]);

    $objImputado->setAldeaId($_POST["cboAldea3"]);

    $objImputado->setBarrioId($_POST["cboBarrio3"]);

    $objImputado->setDetalle($_POST["txtDireccion"]);

    $objImputado->setArmas($_POST["txtTodosArmas"]);

    $objImputado->setTransporte($_POST["txtTodosTransporte"]);
    
    $objImputado->setObjetos($_POST["txtTodosObjetos"]);
    
    $objImputado->setAlias($_POST["txtTodosAlias3"]);

    $objImputado->setDelitos($_POST["txtTodosDelitos3"]);
    
    $objImputado->setTentativas($_POST["txtTentativa"]);
    
    $objImputado->setCulposos($_POST["txtCulposo"]);

    $objImputado->setRepresentante($_POST["txtNombrePadre"]);

    $objImputado->setDetalle($_POST["txtDireccion3"]);

    $objImputado->setTxtDireccion($_POST["txtDireccion3"]);

    $objImputado->setTipoDocumento($_POST["cboTipoDoc3"]);

    $objImputado->setTelefono($_POST["txtTelefono"]);
    
    $objImputado->setTelefono($_POST["txtTelefono"]);
        
    $objImputado->setCondicionAgresor($_POST["rdCondicion"]);
    $objImputado->setTrabajoRemunerado($_POST["rdTrabajo"]);
    $objImputado->setAsisteEducacion($_POST["rdEstudia"]);
        
    //el movil esta en blanco
    $movil= $_POST["cboMovil"];    
    if (empty($movil) || $movil== '' || $movil== ' '){
        $movil= 1;
    }
    $objImputado->setMovil($movil); 
    
    //genero (como se siente, hombre o mujer)
    $VlorGenero= $_POST['rdSexo3'];
    if($VlorGenero== "f")
            $Genero= "f";
    if ($VlorGenero== "m")
            $Genero= "m";
    if ($VlorGenero!= "m" && $VlorGenero!= "f")
        $Genero= "x";

    $objImputado->setGenero($Genero);

    //sexo (lo que tiene entre piernas)
    $VlorSexo= $_POST['rdSexo33'];
    if($VlorSexo== "f")
            $Sexo= "f";
    if ($VlorSexo== "m")
            $Sexo= "m";
    if ($VlorSexo!= "m" && $VlorSexo!= "f")
        $Sexo= "x";

    $objImputado->setSexo($Sexo);

    //umedida edad
    $VlorEdad= $_POST['rdAno3'];
    if($VlorEdad== "con")
            $UEdad= "a";

    if($VlorEdad== "des")
            $UEdad= "x";

    $objImputado->setUmeDidaEdad($UEdad);

    //rango edad
    $ValorRangoEdad= $_POST['rdRangoEdad3'];
    if($ValorRangoEdad== 'infante')
            $RangoEdad= "ni";

    if($ValorRangoEdad== 'adelescente')
            $RangoEdad= "na";

    if($ValorRangoEdad== 'menoradulto')
            $RangoEdad= "nm";

    if($ValorRangoEdad== 'adulto')
            $RangoEdad= "a";

    if($ValorRangoEdad== 'adultomayor')
            $RangoEdad= "am";

    if($ValorRangoEdad== 'noconsignado')
            $RangoEdad= "x";    
    
    $objImputado->setRangoEdad($RangoEdad);

    //se conoce o no el denunciado
    //conocido= 1; anonimo= 0; oculto= 2
    $ValorConocido= $_POST['rdConocido'];
    if($ValorConocido== '1')
    {
            $Conocido= '1';
    }
    elseif($ValorConocido== '0')
    {
            $Conocido= '0';
    }
    elseif($ValorConocido== '2')
    {
            $Conocido= '2';
    }
    elseif($ValorConocido== '3')
    {
            $Conocido= '3';
    }
    else
    {
        $Conocido= '-1';
    }

    $objImputado->setConocido($Conocido);

    //orientacion sexual
    $VlrOrientacion = $_POST['selSexo2'];
    if($VlrOrientacion== "het")
            $OrientacionSex= "H";

    if($VlrOrientacion== "les")
            $OrientacionSex= "L";

    if($VlrOrientacion== "gay")
            $OrientacionSex= "G";

    if($VlrOrientacion== "bis")
            $OrientacionSex= "B";

    if($VlrOrientacion== "tra")
            $OrientacionSex= "T";

    if($VlrOrientacion== "no")
            $OrientacionSex= "N";

    $objImputado->setOrientacionSex($OrientacionSex);        
    
    $lgbti= $_POST['rdAplicaLGBTI3'];

    if ($lgbti== "si"){
        $objImputado->setIntegraLGBTI('t');
    }else{
        $objImputado->setIntegraLGBTI('f');
    }
    
}

//guardar el objeto en una sesion
$_SESSION["oDenunciado"]= $objImputado;
        
/*saber si llamar a modificar o a insertar nuevo
    * si existe la variable de sesion $_SESSION['denunciaid']== 't'; modificar
    */    
if (isset($_SESSION['denunciado'])){
    if($_SESSION['denunciado']== 't'){  
        $objImputado->Modificar();        
    }
    else{
        $_SESSION['denunciado']= 't'; 
        $objImputado->Guardar();        
    }
}
?>