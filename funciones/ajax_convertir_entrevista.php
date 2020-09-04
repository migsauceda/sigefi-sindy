<?php
include "../clases/Usuario.php";
include("../clases/class_conexion_pg.php");
include("../clases/Denuncia.php");
include("../clases/Denunciante.php");

session_start();

//conocer usuario
$objUsuario= $_SESSION['objUsuario'];

//conocer numero de entrevista
$Entevistaid = $_POST['entrevistaid'];

//generar numero de denuncia
$gall= microtime(true);
$gall= floor($gall);
$gall= $gall + rand(1, 50);

$_SESSION['denunciaid']= $gall;
$DenunciaId= $_SESSION['denunciaid'];

//sub bandeja
$Bandeja= $objUsuario->getSubBandejaId(); 

//nombre de usuario
$usuario= $objUsuario->getUsuario();

//generar id de denunciante
$personaid= microtime(true);
$personaid= floor($personaid);
        
////convertir
$objConexion=new Conexion(); 
$sql= "SELECT codigo, descripcion from mini_sedi.convertir_entrevista_denuncia(
	$Entevistaid, 
	$DenunciaId, 
	$personaid, 
	'$usuario',
        $Bandeja
)";

$resultado=$objConexion->ejecutarComando($sql);
$indicador=  pg_fetch_array($resultado);
if ($indicador['codigo'] != 0){
    echo $indicador['descripcion'];
}
else{
    //inicializar variables de sesion
    $_SESSION['validarestado']= 'no';
    $_SESSION['CambiarTab']= 1;
    $_SESSION['generales']= 't';
    $_SESSION['denunciante']= 't';
    
    //crear objeto Denuncia
    $objDenuncia= new Denuncia; 
    $objDenuncia->Recuperar($DenunciaId);

    //guardar el objeto en una sesion
    $_SESSION["oDenuncia"]= $objDenuncia;
    
    //crea objeto denunciado
    $objDenunciante= new Denunciante; 
    $objDenunciante->RecuperarId($DenunciaId, $personaid);
    
    //guardar el objeto en una sesion
    $_SESSION["oDenunciante"]= $objDenunciante;
    
    

    echo $DenunciaId."---".$indicador['codigo'];
}  
?>

