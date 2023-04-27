<?php
	include("../clases/Ofendido.php");
	include("../clases/class_conexion_pg.php");
        include("../funciones/php_funciones.php");

//iniciar session
session_start();

//crear objeto ofendido
$objOfendido= new Ofendido();

//recuperar el numero de denuncia de la variable de sesion y 
//guardarlo en el objeto
if(isset($_SESSION["oDenuncia"])){                         
    if (isset($_SESSION['denunciaid'])){
        $objOfendido->setDenunciaId($_SESSION['denunciaid']);                  
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

//saber si es nuevo ofendido
if(!isset($_SESSION["oOfendido"])){
    //id para persona, se crea si no existe obj ofendido
    $personaid= microtime(true);
    $personaid= floor($personaid);
    
    //asignar valores a las propiedades
    $objOfendido->setPersonaId($personaid);    
}
else{
    $objOfendido->setPersonaId($_POST["txtPersonaId"]);    
}

//$objOfendido->setPersonaId($_POST[txtPersonaId]);
//$objOfendido->setdenunciaid($_POST[txtDenunciaId]);

if(isset($_POST["OfendidoJur4"]) && $_POST["OfendidoJur4"]== 'juridico'){
    //el nombre se llena en blanco para no tener problemas al guardar
    $objOfendido->setApellidoCompleto("--N/A--");
    $objOfendido->setNombreCompleto($_POST["txtEmpresasHn4J"]);    
    $objOfendido->setNacionalidad($_POST["cboNacionalidad4J"]);
    $objOfendido->setDepartamentoid($_POST["cboDepto4J"]); 
    $objOfendido->setMunicipioid($_POST["cboMuni4J"]);
    $objOfendido->setAldeaId($_POST["cboAldea4J"]);
    $objOfendido->setBarrioId($_POST["cboBarrio4J"]);
    $objOfendido->setDetalle($_POST["txtDireccionJuridica4"]);
    $objOfendido->setTxtDireccion($_POST["txtDireccionJuridica4"]);
    $objOfendido->setTelefono($_POST["txtTelefono4J"]);
    $objOfendido->setRTN($_POST["txtRtn4J"]);
    $objOfendido->setNumeroHijos(0);

    //apoderado legal
    $TipoDoc= $_POST["rdTipoDoc"];
    if ($TipoDoc== "identidad"){
        $UsaApoderado= 'f';
        $objOfendido->setIdentidad($_POST["txtColegio4J"]);
        $objOfendido->setTipoDocumento(1);
    }
    elseif ($TipoDoc== "pasaporte"){
        $UsaApoderado= 'f';
        $objOfendido->setIdentidad($_POST["txtColegio4J"]);
        $objOfendido->setTipoDocumento(2);
    }
    elseif ($TipoDoc== "colegio"){
        $UsaApoderado= 't';
        $objOfendido->setIdentidad($_POST["txtColegio4J"]);
        $objOfendido->setTipoDocumento(5);
        $objOfendido->setApoderadoColegio($_POST["txtColegio4J"]);                       
    }

    $objOfendido->setbApoderado($UsaApoderado);    
    $objOfendido->setApoderadoNombre($_POST["txtApoderado4J"]);
    
    $objOfendido->setEstadoCivil(0);
    $objOfendido->setEscolaridad(0);
    $objOfendido->setProfesion(0);
    $objOfendido->setOcupacion(0);
    $objOfendido->setGrupoEtnico(0);
    $objOfendido->setDiscapacidad(0);
    
    $objOfendido->setEdad(0);
    $objOfendido->setGenero('x');
    $objOfendido->setRangoEdad('x');
    $objOfendido->setUmeDidaEdad('x');

    $Conocido= '-1';    
    $objOfendido->setConocido($Conocido);    
    $objOfendido->setOrientacionSex('N');
    $objOfendido->setIntegraLGBTI('f');
    $objOfendido->setPersonaNatural(0);
}else
{ 
    $objOfendido->setPersonaNatural(1); 
    
    $objOfendido->setNombreCompleto($_POST["txtNombres"]);

    $objOfendido->setApellidoCompleto($_POST["txtApellidos"]);

    $objOfendido->setTipoDocumento($_POST["cboTipoDoc4"]);
    $objOfendido->setIdentidad($_POST["txtIdentidad4"]);

    $objOfendido->setProfesion($_POST["cboProfe4"]);

    $objOfendido->setOcupacion($_POST["cboOcupa4"]);

    $objOfendido->setEscolaridad($_POST["cboEscolar4"]);

    $objOfendido->setNacionalidad($_POST["cboNacionalidad4"]);

    $objOfendido->setEstadoCivil($_POST["cboCivil4"]);

    $objOfendido->setGrupoEtnico($_POST["cboEtnia4"]);

    $objOfendido->setDiscapacidad($_POST["cboDiscapacidad4"]);

    $objOfendido->setEdad($_POST["txtEdad4"]);

    $objOfendido->setDepartamentoid($_POST["cboDepto4"]); 

    $objOfendido->setMunicipioid($_POST["cboMuni4"]);

    $objOfendido->setAldeaId($_POST["cboAldea4"]);

    $objOfendido->setBarrioId($_POST["cboBarrio4"]);

    $objOfendido->setDetalle($_POST["txtDireccion"]);

    $objOfendido->setTxtDireccion($_POST["txtDireccion2"]);

    $objOfendido->setTelefono($_POST["txtTelefono"]); 
    
    $objOfendido->setNombreAsumido($_POST["txtNombreAsum"]); 
    
    $objOfendido->setIntentoSuicidio($_POST["rdPrevios"]);
    $objOfendido->setEnfermedadMental($_POST["rdMental"]);
    $objOfendido->setMecanismoMuerte($_POST["cboMuerte"]);
    
    $objOfendido->setEmbarazada($_POST["rdEmbarazada"]);
    $objOfendido->setFrecuencia($_POST["rdFrecuencia"]);    
    $objOfendido->setAsisteCentroEducativo($_POST["rdEstudia"]);        
    $objOfendido->setTrabajoRemunerado($_POST["rdTrabajo"]);
    
    $NumeroHijos= $_POST["txtHijos"];
    if (is_numeric($NumeroHijos))
        $objOfendido->setNumeroHijos($NumeroHijos);
    else
        $objOfendido->setNumeroHijos(0);
    
    //apoderado legal
    $UsaApoderado= $_POST["bApoderado"];
    if ($UsaApoderado== 0)
        $UsaApoderado= 'f';
    else
        $UsaApoderado= 't';

    $objOfendido->setbApoderado($UsaApoderado);

    $objOfendido->setApoderadoNombre($_POST["txtApoderado"]);

    $objOfendido->setApoderadoColegio($_POST["txtColegio"]);

    //genero
    $VlorGenero= $_POST['rdSexo4'];
    if($VlorGenero== "f")
            $Genero= "f";
    if ($VlorGenero== "m")
            $Genero= "m";
    if ($VlorGenero!= "m" && $VlorGenero!= "f")
        $Genero= "x";

    $objOfendido->setGenero($Genero);
    
    //lgbti
    $lgbti= $_POST["rdAplicaLGBTI4"];
    if($lgbti== "si"){
        $objOfendido->setIntegraLGBTI('t');
    }
    else{
        $objOfendido->setIntegraLGBTI('f'); 
    }    

    //umedida edad
    $VlorEdad= $_POST['rdAno4'];
    if($VlorEdad== "con")
            $UEdad= "a";

    if($VlorEdad== "mes")
            $UEdad= "m";

    if($VlorEdad== "dia")
            $UEdad= "d";

    if($VlorEdad== "des")
            $UEdad= "x";

    $objOfendido->setUmeDidaEdad($UEdad);    

    //rango edad
    $ValorRangoEdad= $_POST['rdRangoEdad4'];
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

    $objOfendido->setRangoEdad($RangoEdad); 

    //se conoce o no el denunciante
    //conocido= 1; anonimo= 0; fe publica= 2; testigo portegido= 3
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

    $objOfendido->setConocido($Conocido);

    //orientacion sexual "no","het","gay","bis","tra", "les";
    $VlrOrientacion = $_POST['selSexo4'];
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

    $objOfendido->setOrientacionSex($OrientacionSex); 
    
}


//guardar el objeto en una sesion
$_SESSION["oOfendido"]= $objOfendido;

/*saber si llamar a modificar o a insertar nuevo
    * si existe la variable de sesion $_SESSION['denunciaid']== 't'; modificar
    */      

if (isset($_SESSION['ofendido'])){
    if($_SESSION['ofendido']== 't'){ 
        //$_SESSION['ofendido']= 'f';
        $objOfendido->Modificar();
    }
    else{
        $_SESSION['ofendido']= 't';
        $objOfendido->Guardar();        
    }
}
?>
