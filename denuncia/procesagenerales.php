<?php 
include("../clases/Denuncia.php");

include("../clases/class_conexion_pg.php");

//iniciar sessionsession_start();

//crear objeto Denuncia
$objDenuncia= new Denuncia;

//recuperar el numero de denuncia de la variable de sesion y 
//guardarlo en el objeto
if(isset($_SESSION["oDenuncia"])){
    if (isset($_SESSION['denunciaid'])){
        $objDenuncia->setDenunciaId($_SESSION['denunciaid']);    
    }  
}
//asignar valores a propiedades
//$objDenuncia->setDenunciaId($_POST[txtDenunciaId]);

$objDenuncia->setNumero($_POST["txtDenuncia"]);

$objDenuncia->setExpedienteJudicial($_POST["txtExpediente"]);

$objDenuncia->setExpedientePolicial($_POST["txtExpPolicial"]);

//guarda fecha y hora, ver codigo del metodo
$objDenuncia->setFechaDenuncia($_POST["txtFechaDenuncia"]); 

//guarda fecha y hora, ver codigo del metodo
$objDenuncia->setFechaHecho($_POST["txtFechaHecho"]);

$objDenuncia->setDepartamentoDenuncia($_POST["cboDepto0"]);

$objDenuncia->setMunicipioDenuncia($_POST["cboMuni0"]);

$objDenuncia->setDepartamentoHecho($_POST["cboDepto2"]);

$objDenuncia->setMunicipioHecho($_POST["cboMuni2"]);

$objDenuncia->setAldeaCaserioHecho($_POST["cboAldea2"]);

$objDenuncia->setBarrioColoniaHecho($_POST["cboBarrio2"]);

$objDenuncia->setDetalleDireccion($_POST["txtDetalle"]);

$objDenuncia->setLugarRecepcion($_POST["cboRecepcion"]);

$objDenuncia->setNarracionHecho($_POST["hechos"]);

$objDenuncia->setTxtDireccionDenuncia($_POST["txtDireccionDenuncia"]);

$objDenuncia->setTxtDireccionHecho($_POST["txtDireccionHecho"]);

$objDenuncia->setEstado("D"); 

$objDenuncia->setLugarHecho($_POST["cboClaseLugar"]);

$objDenuncia->setAutopsia($_POST["txtAutopsia"]);

$objDenuncia->setLevantamiento($_POST["txtLevantamiento"]);

$objDenuncia->setTransito($_POST["txtTransito"]);

$objDenuncia->setTomaTurno($_POST["txtEntrevista"]);

//guardar el objeto en una sesion
$_SESSION["oDenuncia"]= $objDenuncia;

/*saber si llamar a modificar o a insertar nuevo
    * si existe la variable de sesion $_SESSION['denunciaid']== 't'; modificar
    */

if (isset($_SESSION['generales'])){ 
    if($_SESSION['generales']== 't'){           
        $objDenuncia->Modificar();
    }
    else{        
        $_SESSION['generales']= 't';
        $objDenuncia->Guardar();        
    }
}
?>