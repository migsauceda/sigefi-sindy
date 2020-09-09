<?php
	include("../clases/Denunciante.php");
	include("../clases/class_conexion_pg.php");
        //include("../funciones/php_funciones.php");

//iniciar session
if(!isset($_SESSION["oDenuncia"])){        
    session_start();
}
//crear objeto denunciante
$objDenunciante= new Denunciante;

//recuperar el numero de denuncia de la variable de sesion y 
//guardarlo en el objeto
if(isset($_SESSION["oDenuncia"])){                         
    if (isset($_SESSION['denunciaid'])){
        $objDenunciante->setDenunciaId($_SESSION['denunciaid']);                  
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
if(!isset($_SESSION["oDenunciante"])){
    //id para persona, se crea si no existe obj denunciante
    $personaid= microtime(true);
    $personaid= floor($personaid);
    
    //asignar valores a las propiedades
    $objDenunciante->setPersonaId($personaid);    
}
else{    
    $objDenunciante->setPersonaId($_POST["txtPersonaId"]);    
}

//$objDenunciante->setPersonaId($_POST[txtPersonaId]);
//$objDenunciante->setdenunciaid($_POST[txtDenunciaId]);    

if(isset($_POST["DenuncianteJur"]) && $_POST["DenuncianteJur"]== 'juridico'){ 
    $objDenunciante->setNombreCompleto($_POST["txtEmpresasHn"]);    
    $objDenunciante->setApellidoCompleto('');
    $objDenunciante->setNacionalidad($_POST["cboNacionalidadJ"]);
    $objDenunciante->setDepartamentoid($_POST["cboDeptoJ"]); 
    $objDenunciante->setMunicipioid($_POST["cboMuniJ"]);
    $objDenunciante->setAldeaId($_POST["cboAldeaJ"]);
    $objDenunciante->setBarrioId($_POST["cboBarrioJ"]);
    $objDenunciante->setDetalle($_POST["txtDireccionJuridica"]);
    $objDenunciante->setTxtDireccion($_POST["txtDireccionJuridica"]);
    $objDenunciante->setTelefono($_POST["txtTelefonoj"]);
    $objDenunciante->setRTN($_POST["txtRtn"]);

    //apoderado legal
    $TipoDoc= $_POST[rdTipoDoc];
    if ($TipoDoc== "identidad"){
        $UsaApoderado= 'f';
        $objDenunciante->setIdentidad($_POST["txtColegioJ"]);
        $objDenunciante->setTipoDocumento(1); //estos son id en la tabla tbl_tipodocumento
    }
    elseif ($TipoDoc== "pasaporte"){
        $UsaApoderado= 'f';
        $objDenunciante->setIdentidad($_POST["txtColegioJ"]);
        $objDenunciante->setTipoDocumento(2);
    }
    elseif ($TipoDoc== "colegio"){
        $UsaApoderado= 't';
        $objDenunciante->setIdentidad($_POST["txtColegioJ"]);
        $objDenunciante->setTipoDocumento(5);
        $objDenunciante->setApoderadoColegio($_POST["txtColegioJ"]);                       
    }
    elseif ($TipoDoc== "nodefinido"){
        $UsaApoderado= 'f';
        $objDenunciante->setIdentidad($_POST["txtColegioJ"]);
        $objDenunciante->setTipoDocumento(0);
        $objDenunciante->setApoderadoColegio($_POST["txtColegioJ"]);                       
    }    

    $objDenunciante->setbApoderado($UsaApoderado);
    $objDenunciante->setApoderadoNombre($_POST["txtApoderadoJ"]);
    
    $objDenunciante->setEstadoCivil(0);
    $objDenunciante->setEscolaridad(0);
    $objDenunciante->setProfesion(0);
    $objDenunciante->setOcupacion(0);
    $objDenunciante->setGrupoEtnico(0);
    $objDenunciante->setDiscapacidad(0);
    
    $objDenunciante->setEdad(0);
    $objDenunciante->setGenero('x');
    $objDenunciante->setRangoEdad('x');
    $objDenunciante->setUmeDidaEdad('x');
   
    $objDenunciante->setOrientacionSex('N');
    $objDenunciante->setIntegraLGBTI('f'); 
    $objDenunciante->setPersonaNatural('f');
    
    //se conoce o no el denunciante
    //conocido= 1; anonimo= 0; oculto= 2; oficio= 3
    $ValorConocido= $_POST['Oficioso'];
    if($ValorConocido== '3')
    {
            $Conocido= '3';
    }    
    else
    {
        $Conocido= '1';
    }
    $objDenunciante->setConocido($Conocido);
    
}else
{ 
    $objDenunciante->setPersonaNatural('t'); 
    
    $objDenunciante->setNombreCompleto($_POST["txtNombres"]);

    $objDenunciante->setApellidoCompleto($_POST["txtApellidos"]);

    $objDenunciante->setIdentidad($_POST["txtIdentidad"]);

    $objDenunciante->setProfesion($_POST["cboProfe"]);

    $objDenunciante->setOcupacion($_POST["cboOcupa"]);

    $objDenunciante->setEscolaridad($_POST["cboEscolar"]);

    $objDenunciante->setNacionalidad($_POST["cboNacionalidad"]);

    $objDenunciante->setEstadoCivil($_POST["cboCivil"]);

    $objDenunciante->setGrupoEtnico($_POST["cboEtnia"]);

    $objDenunciante->setDiscapacidad($_POST["cboDiscapacidad"]);

    $objDenunciante->setEdad($_POST["txtEdad"]);

    $objDenunciante->setDepartamentoid($_POST["cboDepto"]); 

    $objDenunciante->setMunicipioid($_POST["cboMuni"]);

    $objDenunciante->setAldeaId($_POST["cboAldea"]);

    $objDenunciante->setBarrioId($_POST["cboBarrio"]);

    $objDenunciante->setDetalle($_POST["txtDireccion"]);

    $objDenunciante->setTxtDireccion($_POST["txtDireccion2"]);

    $objDenunciante->setTipoDocumento($_POST["cboTipoDoc"]);

    $objDenunciante->setTelefono($_POST["txtTelefono"]); 
    
    $lgbti= $_POST["rdAplicaLGBTI"];
    if($lgbti== "si"){
        $objDenunciante->setIntegraLGBTI('t');
    }
    else{
        $objDenunciante->setIntegraLGBTI('f'); 
    }
    
    $objDenunciante->setNombreAsumido($_POST["txtNombreAsum"]); 

    //apoderado legal
    if(isset($_POST["bApoderado"]))
    {$UsaApoderado= $_POST["bApoderado"];}else { $UsaApoderado= 0;};
    if ($UsaApoderado== 0)
        $UsaApoderado= 'f';
    else
        $UsaApoderado= 't';

    $objDenunciante->setbApoderado($UsaApoderado);

    $objDenunciante->setApoderadoNombre($_POST["txtApoderado"]);

    $objDenunciante->setApoderadoColegio($_POST["txtColegio"]);

    //genero
    $VlorGenero= $_POST['rdSexo'];
    if($VlorGenero== "f")
            $Genero= "f";
    if ($VlorGenero== "m")
            $Genero= "m";
    if ($VlorGenero!= "m" && $VlorGenero!= "f")
        $Genero= "x";

    $objDenunciante->setGenero($Genero);

    //umedida edad
    $VlorEdad= $_POST['rdAno'];
    if($VlorEdad== "con")
            $UEdad= "a";

    if($VlorEdad== "des")
            $UEdad= "x";

    $objDenunciante->setUmeDidaEdad($UEdad); 

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

    $objDenunciante->setRangoEdad($RangoEdad); 

    //se conoce o no el denunciante
    //conocido= 1; anonimo= 0; oculto= 2; oficio= 3
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

    $objDenunciante->setConocido($Conocido);


    //orientacion sexual "no","het","gay","bis","tra", "les";
    if(isset($_POST['selSexo1'])){
        $VlrOrientacion = $_POST['selSexo1'];
    }else
    {
       $VlrOrientacion= "no"; 
    }
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

    $objDenunciante->setOrientacionSex($OrientacionSex); 
    
    
}



//guardar el objeto en una sesion
$_SESSION["oDenunciante"]= $objDenunciante;

/*saber si llamar a modificar o a insertar nuevo
    * si existe la variable de sesion $_SESSION['denunciaid']== 't'; modificar
    */      
if (isset($_SESSION['denunciante'])){
    if($_SESSION['denunciante']== 't'){
        $objDenunciante->Modificar();
    }
    else{       
        //guardar el denunciante actual
        $_SESSION['denunciante']= 't';
        $objDenunciante->Guardar();        
    }
}
?>