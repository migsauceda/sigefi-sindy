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
    $objOfendido->setPersonaId($_POST[txtPersonaId]);    
}

//$objOfendido->setPersonaId($_POST[txtPersonaId]);
//$objOfendido->setdenunciaid($_POST[txtDenunciaId]);

if($_POST[OfendidoJur]== 'juridico'){
    $objOfendido->setNombreCompleto($_POST[txtEmpresasHn]);    
    $objOfendido->setNacionalidad($_POST[cboNacionalidad]);
    $objOfendido->setDepartamentoid($_POST[cboDeptoJ]); 
    $objOfendido->setMunicipioid($_POST[cboMuniJ]);
    $objOfendido->setAldeaId($_POST[cboAldeaJ]);
    $objOfendido->setBarrioId($_POST[cboBarrioJ]);
    $objOfendido->setDetalle($_POST[txtDireccionJuridica]);
    $objOfendido->setTxtDireccion($_POST[txtDireccionJuridica]);
    $objOfendido->setTipoDocumento($_POST[cboTipoDoc]);
    $objOfendido->setTelefono($_POST[txtTelefono]);

    //apoderado legal
    $TipoDoc= $_POST[rdTipoDoc];
    if ($TipoDoc== "identidad"){
        $UsaApoderado= 'f';
        $objOfendido->setIdentidad($_POST[txtColegioJ]);
        $objOfendido->setTipoDocumento(1);
    }
    elseif ($TipoDoc== "pasaporte"){
        $UsaApoderado= 'f';
        $objOfendido->setIdentidad($_POST[txtColegioJ]);
        $objOfendido->setTipoDocumento(2);
    }
    elseif ($TipoDoc== "colegio"){
        $UsaApoderado= 't';
        $objOfendido->setApoderadoColegio($_POST[txtColegioJ]);
        $objOfendido->setIdentidad($_POST[txtRtn]);
        $objOfendido->setApoderadoNombre($_POST[txtApoderadoJ]);
        $objOfendido->setTipoDocumento(5);        
    }

    $objOfendido->setbApoderado($UsaApoderado);    
    
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
    $objOfendido->setPersonaNatural(0);
}else
{ 
    $objOfendido->setPersonaNatural(1); 
    
    $objOfendido->setNombreCompleto($_POST[txtNombres]);

    $objOfendido->setApellidoCompleto($_POST[txtApellidos]);

    $objOfendido->setIdentidad($_POST[txtIdentidad]);

    $objOfendido->setProfesion($_POST[cboProfe]);

    $objOfendido->setOcupacion($_POST[cboOcupa]);

    $objOfendido->setEscolaridad($_POST[cboEscolar]);

    $objOfendido->setNacionalidad($_POST[cboNacionalidad]);

    $objOfendido->setEstadoCivil($_POST[cboCivil]);

    $objOfendido->setGrupoEtnico($_POST[cboEtnia]);

    $objOfendido->setDiscapacidad($_POST[cboDiscapacidad]);

    $objOfendido->setEdad($_POST[txtEdad]);

    $objOfendido->setDepartamentoid($_POST[cboDepto]); 

    $objOfendido->setMunicipioid($_POST[cboMuni]);

    $objOfendido->setAldeaId($_POST[cboAldea]);

    $objOfendido->setBarrioId($_POST[cboBarrio]);

    $objOfendido->setDetalle($_POST[txtDireccion]);

    $objOfendido->setTxtDireccion($_POST[txtDireccion2]);

    $objOfendido->setTipoDocumento($_POST[cboTipoDoc]);

    $objOfendido->setTelefono($_POST[txtTelefono]); 
    
    $objOfendido->setNombreAsumido($_POST[txtNombreAsum]); 

    //apoderado legal
    $UsaApoderado= $_POST[bApoderado];
    if ($UsaApoderado== 0)
        $UsaApoderado= 'f';
    else
        $UsaApoderado= 't';

    $objOfendido->setbApoderado($UsaApoderado);

    $objOfendido->setApoderadoNombre($_POST[txtApoderado]);

    $objOfendido->setApoderadoColegio($_POST[txtColegio]);

    //genero
    $VlorGenero= $_POST['rdSexo'];
    if($VlorGenero== "f")
            $Genero= "f";
    if ($VlorGenero== "m")
            $Genero= "m";
    if ($VlorGenero!= "m" && $VlorGenero!= "f")
        $Genero= "x";

    $objOfendido->setGenero($Genero);

    //umedida edad
    $VlorEdad= $_POST['rdAno'];
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
    $VlrOrientacion = $_POST['selSexo1'];
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
//    exit($_SESSION['ofendido']);
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