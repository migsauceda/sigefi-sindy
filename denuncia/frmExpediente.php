<?php    
include "../clases/Usuario.php";

session_start();
//funciones genericas
include_once "../clases/class_conexion_pg.php";
include_once "../funciones/php_funciones.php";

include_once "../clases/Denunciante.php";
include_once "../clases/Imputado.php";
include_once "../clases/Ofendido.php";
        
if (isset($_SESSION['objUsuario'])){
    $objUsuario= $_SESSION['objUsuario'];        
}else{
    header("location:index.php");
}

if (isset($_GET['var'])){
    $denuncia= ($_GET['var']);
    $_SESSION["denunciaid"]= $denuncia;
}

 //echo $_SESSION["denunciaid"];
//valida derechos
/*
 * COMENTADO PARA QUE TODOS PUEDAN ACCEDER A CREAR
 
if ($objUsuario->getPermiso(2)== '0' && $objUsuario->getPermiso(1)== '0'){ 
    ?>
    <script type="text/javascript">
    alert("No tiene acceso a esta opciónes");    
    top.location = "../aplicacion.php";     
    </script>    
    <?php
} 
*/
//validar si esta conectado
//if (!isset($_SESSION['usuario'])){header("location:index.php");} 
/*
 * MODIFICADA PARA QUE UN FISCAL INGRESE DENUNCIA
 
if (!isset($_SESSION['denunciaid']) && $objUsuario->getTipoUsuario()== 'Fiscal'){
    ?>
        <script type="text/javascript">
        alert("Si es fiscal y desea modificar un expediente, use la opción Buscar y seleccione el número");
        top.location = "../aplicacion.php"; 
        </script>  
    <?php
}
*/

if (isset($_GET['CambiarEstado'])){  
    if($_GET['CambiarEstado']== 'SI'){ 
        //se inicia una nueva denuncia
        ValidarEstado();    
    }
    else{ 
    //el parámetro GET NUEVA se genera en banner_horizontal.php al responder
    //que se quiere continuar con una denuncia nueva       
    if(isset($_GET['CambiarEstado'])){
        if ($_GET['CambiarEstado']== 'NUEVA'){ 
            //borrar registros en tabla control de estados, para que no quede denuncia pendiente    
            //$Usr= $_SESSION['usuario']; 
            if (!isset($_SESSION['denunciaid'])){
                $_SESSION['denunciaid']= 0;
            }
            $Usr= $objUsuario->getUsuario();
            $sql= "select mini_sedi.controlestados_delete('".$Usr."',".$_SESSION['denunciaid'].");";


            $objConexion= new Conexion();
            $rsp= $objConexion->ejecutarProcedimiento($sql);                       

            $_SESSION['CambiarTab']= '0';
            $_SESSION['generales']= 'f';
            $_SESSION['denunciante']= 'f';
            $_SESSION['ofendido']= 'f';
            $_SESSION['denunciado']= 'f';    
            $_SESSION['relaciones']= 'f';

            unset($oDenuncia);
            unset($oDenunciante);
            unset($oOfendido);
            unset($oDenunciado);
            unset($oRelaciones); 

            unset($_SESSION["oDenuncia"]);
            unset($_SESSION["oDenunciante"]);
            unset($_SESSION["oOfendido"]);
            unset($_SESSION["oDenunciado"]);       
            unset($_SESSION["oRelaciones"]);
            unset($_SESSION["denunciaid"]);            

            //sessions para controlar varios imputados, denunciados y ofendidos
            unset($_SESSION["oDenuncianteCola"]);
            unset($_SESSION["oDenunciadoCola"]);
            unset($_SESSION["oOfendidoCola"]); 
        }
    }
       //cargar los objetos que existen if session estado   
   } //else de incia una nueva denuncia osea cuando la denucia esta en proceso
} 

//cargar los objetos que existen 
    if (isset($_SESSION["estado"])){ 
        if($_SESSION["estado"]== "Completando"){ 

            //crear obj denuncia
            if ($_SESSION['generales']== 't'){  
                include_once("../clases/Denuncia.php");       
                $oDenuncia= new Denuncia(); 
                $oDenuncia->Recuperar($_SESSION['denunciaid']); 
                $_SESSION["oDenuncia"]= $oDenuncia;
//                exit($_SESSION["oDenuncia"]);
            }

            //crear obj denunciante
            if($_SESSION['denunciante']== 't'){ 
                include_once("../clases/Denunciante.php");         
                $oDenunciante= new Denunciante;
                $oDenunciante->Recuperar($_SESSION['denunciaid']); 
                $_SESSION["oDenunciante"]= $oDenunciante;                 
            }    
            
            //crear obj ofendido o victima
            if($_SESSION['ofendido']== 't'){
                include_once("../clases/Ofendido.php");  
                $oOfendido= new Ofendido();           
                $oOfendido->Recuperar($_SESSION['denunciaid']);   
                $_SESSION["oOfendido"]= $oOfendido;  
            }             
            
            //crear obj denunciado o imputado
            if($_SESSION['denunciado']== 't'){
                include_once("../clases/Imputado.php");  
                $oDenunciado= new Imputado;
                $oDenunciado->Recuperar($_SESSION['denunciaid']);   
                $_SESSION["oDenunciado"]= $oDenunciado;
            }
            
            //relaciones
            if ($_SESSION['relaciones']== 't'){
                $_SESSION['oRelaciones']= "nulo"; //mientras se mejora la clase relacion
            }
        }        
     } //cargar los objetos que existen if session estado 

/*se carga la pagina despues de hacer agregar/modificar/eliminar elemento de denuncia:
generales, denunciado, denunciante, ofendido... para mostrar mensaje de grabado/modificado
tab indica el tabulador al que se debe cambiar */
if (isset($_GET['tab'])){
    $tab= $_GET['tab'];
    if (isset($_GET['rsl']))
        $rsl= $_GET['rsl'];
    if(isset($_GET['err']))
        $err= "Error: ".$_GET['err'];
    $activar= 1;   
}

/*
 * crear un registro en blanco, despues de presionar boton nuevo en denunciante
 * denunciado u ofendido, se recibe el tab a cambiar
 */
if (isset($_GET['nuevo'])){ 
    $tab= $_GET['nuevo'];
    $activar= 1; 
    $rsl= 99; //para que no entre al switch de mensajes de exito
 
    if ($tab== 11 || $tab== 12){ //nuevo denunciante
        $_SESSION['denunciante']= 'f';
        unset($_SESSION['oDenunciante']);
        unset($oDenunciante); 
        if ($tab== 11)
            $_SESSION['PersonaNaturalJuridica']= 'Natural'; 
        if ($tab== 12)
            $_SESSION['PersonaNaturalJuridica']= 'Juridica'; 
        $tab= 1;
    }
    elseif ($tab== 21 || $tab== 22) { //nuevo denunciado
        $_SESSION['denunciado']= 'f';
        unset($_SESSION['oDenunciado']);
        unset($oDenunciado);     
        if ($tab== 21)
            $_SESSION['PersonaNaturalJuridica']= 'Natural'; 
        if ($tab== 22)
            $_SESSION['PersonaNaturalJuridica']= 'Juridica'; 
        $tab= 2;        
    }    
    elseif ($tab== 31 || $tab== 32) {
        $_SESSION['ofendido']= 'f';
        unset($_SESSION['oOfendido']);
        unset($oOfendido);     
        if ($tab== 31)
            $_SESSION['PersonaNaturalJuridica']= 'Natural'; 
        if ($tab== 32)
            $_SESSION['PersonaNaturalJuridica']= 'Juridica'; 
        $tab= 3;                
    }
}  
else{
    unset($_SESSION['PersonaNaturalJuridica']);
}

/*
 * crear un registro en blanco, despues de borrarlo en denunciante, 
 * denunciado u ofendido. se recibe el numero de tab a cambiar y el cod 300
 * de exito
 */
if (isset($_GET['borrar'])){ 
    $tab= $_GET['borrar'];
    $activar= 1; 
    $rsl= 99; //para que no entre al switch de mensajes de exito
    
    if ($tab== 1){ 
        $_SESSION['denunciante']= 'f';
        unset($_SESSION['oDenunciante']);
        unset($oDenunciante); 
    }
    elseif ($tab== 2) {
        $_SESSION['denunciado']= 'f';
        unset($_SESSION['oDenunciado']);
        unset($oDenunciado);    
    }    
    elseif ($tab== 3) {
        $_SESSION['ofendido']= 'f';
        unset($_SESSION['oOfendido']);
        unset($oOfendido);    
    }
}  


/*
 * cargar un registro de la lista de ingresados
 */
if (isset($_GET['nmr'])){
    $id= $_GET['nmr']; 
    $tab= $_GET['tab'];
    $rsl= 99; //para que no entre al switch de mensajes de exito
    
    if($tab== 1){ 
        $oDenunciante= new Denunciante(); 
        $_SESSION["oDenunciante"]= $oDenunciante;
        //recuperar el denunciante con ese id para la denuncia actual
        $oDenunciante->RecuperarId($_SESSION['denunciaid'], $id);   
    }
    elseif ($tab== 2) { 
        $oDenunciado= new Imputado(); 
        $_SESSION["oDenunciado"]= $oDenunciado;
        //recuperar el denunciante con ese id para la denuncia actual
        $oDenunciado->RecuperarId($_SESSION['denunciaid'], $id);
    }    
    elseif ($tab== 3) { 
        $oOfendido= new Ofendido(); 
        $_SESSION["oOfendido"]= $oOfendido;
        //recuperar el denunciante con ese id para la denuncia actual
        $oOfendido->RecuperarId($_SESSION['denunciaid'], $id); 
    }
    elseif ($tab== 4) { 
        $oRalaciones= new Relaciones(); 
        $_SESSION["oRelaciones"]= $oRelaciones;
        //recuperar el denunciante con ese id para la denuncia actual
        $oRelaciones->RecuperarId($_SESSION['denunciaid'], $id); 
    }    

}
?>
        
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Expediente</title> 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--<link type="text/css" rel="stylesheet" href="../css/Estilos.css">-->

    <link href="../java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
    <!--<link href="../java_script/css/smoothness/jquery.datetimepicker.css" rel="stylesheet" type="text/css">-->
    <script src="../java_script/js/jquery-1.10.2.js"></script>
    <script src="../java_script/js/jquery-ui-1.10.4.custom.js"></script>     
    <!--<script src="../java_script/js/jquery.datetimepicker.js"></script>-->    
  <script>
        //ventana modal para copiar
        function Copiar(){ 
            if (confirm("¿Copiar a Ofendido?")){
            $.ajax({
                data: "",
                type: "POST",
                dataType: "text",
                url: "../funciones/ajax_copiar_denunciante.php",
                error: function(objeto, quepaso, otroobj){
                    alert("Error al copiar datos del denunciante: "+objeto+quepaso+otroobj);        
                },
                success: function(data){
                    alert(data);
                }
            }); 
            }
        }   
        
        $(function() {
          $( "#tabs" ).tabs({
            beforeLoad: function( event, ui ) {
              ui.jqXHR.error(function() {
                ui.panel.html(
                  "Espere mientras se recupera la información. " +
                  "Si este mensaje no desaparece llame a soporte técnico." );
              });
            }
          });
        }); 

        $(document).ready(function() { 
            var tab=     "<?php if(isset($tab)){echo $tab;} else{ echo 0;}?>";
            var rsl=     "<?php if(isset($rsl)){echo $rsl;} else{echo -1;} ?>";
            var activar= "<?php if(isset($activar)) {echo $activar;} else{echo 0;}?>";

            if (activar == 1){
                switch(tab){
                    case "0":
                        if (rsl== 0) alert("<?php if (isset($err)){ echo $err;} ?>");
                        if (rsl== 100) alert("Se han Grabado los datos generales");
                        if (rsl== 200) alert("Se han Modificado los datos generales");    
                        act= 0;
                        break;
                    case "1":
                        if (rsl== 0) alert("<?php if (isset($err)){ echo $err;} ?>");
                        if (rsl== 100) {
                            alert("Se han Grabado los datos Denunciante");
                            Copiar();
                        }
                        if (rsl== 200) {
                            alert("Se han Modificado los datos del Denunciante");
                        }
                        if (rsl== 300) alert("se han Borrado los datos del Denunciante");
                        act= 1;                           
                        break;
                    case "2":
                        if (rsl== 0) alert("<?php if (isset($err)){ echo $err;} ?>");
                        if (rsl== 100) alert("Se han Grabado los datos del Denunciado");
                        if (rsl== 200) alert("Se han Modificado los datos del Denunciado");
                        if (rsl== 300) alert("se han Borrado los datos del Denunciado"); 
                        act= 2;
                        break;
                    case "3":
                        if (rsl== 0) alert("<?php if (isset($err)){ echo $err;} ?>");
                        if (rsl== 100) alert("Se han Grabado los datos del Ofendido");
                        if (rsl== 200) alert("Se han Modificado los datos del Ofendido");
                        if (rsl== 300) alert("se han Borrado los datos del Ofendido");
                        act= 3;
                        break;
                    case "4":
                        if (rsl== 0) alert("<?php if (isset($err)){ echo $err;} ?>");
                        if (rsl== 100) alert("Se han Grabado los datos Relaciones");
                        if (rsl== 200) alert("Se han Modificado los datos Relaciones");
                        act= 4;
                        break;                        
                }

                //activar el tabulador numero act  
                if (activar == 1){
                    $( "#tabs" ).tabs( {active: act} ); 
                }
            }   

            //cuando se hace clic en el
            $("#tabs").tabs({
                activate: function(event, ui) {
                    var Cambiar;
                    var indice;

                    Cambiar= "<?php if(isset($_SESSION['CambiarTab'])){ echo $_SESSION['CambiarTab'];}else {echo 0;} ?>";

                    indice= ui.newTab.index();
//alert(Cambiar+indice);
                    switch (indice){                        
                        case 1://denunciante

                            if (Cambiar== 0){
                                alert("Debe guardar los Datos Generales de la denuncia");

                                window.location="frmExpediente.php";
                            }
                            else{
//                                alert("entra");
                                return true;
                            }

                            break;

                        case 2://denunciado

                            if (Cambiar== 0){
                                alert("Debe guardar los Datos Generales de la denuncia");

                                window.location="frmExpediente.php";
                            }
                            else
                                return true;

                            break;

                        case 3://ofendido

                            if (Cambiar== 0){
                                alert("Debe guardar los Datos Generales de la denuncia");

                                window.location="frmExpediente.php";
                            }
                            else{
                                return true;                            
                            }
                            break;

                        case 4://relacion

                            if (Cambiar== 0){
                                alert("Debe guardar los Datos Generales de la denuncia");

                                window.location="frmExpediente.php";
                            }
                            else{
                                return true;
                            }

                            break;        

                        case 5://finalizar

                            if (Cambiar== 0){
                                alert("Debe guardar los Datos Generales de la denuncia");

                                window.location="frmExpediente.php";
                            }
                            else{
                                return true;
                            }

                            break;                           
                    }
                    return Cambiar;                  
//                        alert(ui.index);                    
//                        ui.index= 4;                    
                }
            });  //tabs     
        }); 
  </script>
</head>
<body>
 
<div id="tabs">
  <ul>
        <li><a href="frmGenerales.php">Generales</a></li>              
        <li><a href="frmDenunciante.php">Denunciante</a></li>
        <li><a href="frmDenunciado.php">Denunciado</a></li> 
        <li><a href="frmOfendido.php">Ofendido</a></li>
        <li><a href="frmRelacion.php">Relaciones</a></li> 
        <?php 
            if ($_SESSION['tipoacceso']== 'Fiscal') {
        ?>  
            <li><a href="frmAdministracion.php">Resumen Histórico </a></li>  
            <li><a href="frmProcesaFinalizarDenuncia.php">Finalizar</a></li>
        <?php
            }
        ?>                    

        <?php 
            if ($_SESSION['tipoacceso']== 'Receptor') {
        ?>                        
            <li><a href="frmProcesaFinalizarDenuncia.php">Finalizar</a></li>
        <?php
            }
        ?>              
  </ul>   
</div>
</body>
</html>