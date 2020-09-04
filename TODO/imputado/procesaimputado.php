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
    $objImputado->setPersonaId($_POST[txtPersonaId]);    
}

if($_POST[DenunciadoJur]== 'juridico'){
    $objImputado->setNombreCompleto($_POST[txtEmpresasHn]);    
    $objImputado->setNacionalidad($_POST[cboNacionalidad]);
    $objImputado->setDepartamentoid($_POST[cboDeptoJ]); 
    $objImputado->setMunicipioid($_POST[cboMuniJ]);
    $objImputado->setAldeaId($_POST[cboAldeaJ]);
    $objImputado->setBarrioId($_POST[cboBarrioJ]);
    $objImputado->setDetalle($_POST[txtDireccionJuridica]);
    $objImputado->setTxtDireccion($_POST[txtDireccionJuridica]);
    $objImputado->setTipoDocumento($_POST[cboTipoDoc]);
    $objImputado->setTelefono($_POST[txtTelefono]);

    //apoderado legal
    $TipoDoc= $_POST[rdTipoDoc];
    if ($TipoDoc== "identidad"){
        $UsaApoderado= 'f';
        $objImputado->setIdentidad($_POST[txtColegioJ]);
        $objImputado->setTipoDocumento(1);
    }
    elseif ($TipoDoc== "pasaporte"){
        $UsaApoderado= 'f';
        $objImputado->setIdentidad($_POST[txtColegioJ]);
        $objImputado->setTipoDocumento(2);
    }
    elseif ($TipoDoc== "colegio"){
        $UsaApoderado= 't';
        $objImputado->setApoderadoColegio($_POST[txtColegioJ]);
        $objImputado->setIdentidad($_POST[txtRtn]);
        $objImputado->setApoderadoNombre($_POST[txtApoderadoJ]);
        $objImputado->setTipoDocumento(5);        
    }

    $objImputado->setbApoderado($UsaApoderado);    
    
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
    $objImputado->setPersonaNatural(0);        
}  else 
{
    $objImputado->setPersonaNatural(1); 
    //asignar valores a las propiedades
    $objImputado->setNombreCompleto($_POST[txtNombres]);

    $objImputado->setApellidoCompleto($_POST[txtApellidos]);

    $objImputado->setIdentidad($_POST[txtIdentidad]);

    $objImputado->setProfesion($_POST[cboProfe]);

    $objImputado->setOcupacion($_POST[cboOcupa]);

    $objImputado->setEscolaridad($_POST[cboEscolar]);

    $objImputado->setNacionalidad($_POST[cboNacionalidad]);

    $objImputado->setEstadoCivil($_POST[cboCivil]);

    $objImputado->setGrupoEtnico($_POST[cboEtnia]);

    $objImputado->setDiscapacidad($_POST[cboDiscapacidad]);

    $objImputado->setEdad($_POST[txtEdad]);

    $objImputado->setDepartamentoid($_POST[cboDepto]);

    $objImputado->setMunicipioid($_POST[cboMuni]);

    $objImputado->setAldeaId($_POST[cboAldea]);

    $objImputado->setBarrioId($_POST[cboBarrio]);

    $objImputado->setDetalle($_POST[txtDireccion]);

    $objImputado->setAlias($_POST[txtTodosAlias]);

    $objImputado->setDelitos($_POST[txtTodosDelitos]);
    
    $objImputado->setTentativas($_POST[txtTentativa]);
    
    $objImputado->setCulposos($_POST[txtCulposo]);

    $objImputado->setRepresentante($_POST[txtNombrePadre]);

    $objImputado->setTxtDireccion($_POST[txtDireccion2]);

    $objImputado->setTipoDocumento($_POST[cboTipoDoc]);

    $objImputado->setTelefono($_POST[txtTelefono]);

    //genero
    $VlorGenero= $_POST['rdSexo'];
    if($VlorGenero== "f")
            $Genero= "f";
    if ($VlorGenero== "m")
            $Genero= "m";
    if ($VlorGenero!= "m" && $VlorGenero!= "f")
        $Genero= "x";

    $objImputado->setGenero($Genero);

    //umedida edad
    $VlorEdad= $_POST['rdAno'];
    if($VlorEdad== "con")
            $UEdad= "a";

    if($VlorEdad== "des")
            $UEdad= "x";

    $objImputado->setUmeDidaEdad($UEdad);

    //rango edad
    $ValorRangoEdad= $_POST['rdRangoEdad'];
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

    //se conoce o no el denunciante
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