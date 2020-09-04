<?php    
session_start();
//funciones genericas
include_once "clases/class_conexion_pg.php";
include_once "funciones/php_funciones.php";
        
//validar si esta conectado
if (!isset($_SESSION['usuario'])){header("location:index.php");} 

//validar derechos si ingreso como receptor
if ($_SESSION['tipoacceso']== 'Fiscal'){ 
    if  (Ejecutar(2)== false){
    ?>
    <script type="text/javascript">
    alert("No tiene acceso a esta opción ");
    top.location = "aplicacion.php"; 
    </script>    
    <?php
    }
    else if (!isset($_SESSION['denunciaid'])){
    ?>
        <script type="text/javascript">
        alert("Use la opción Buscar para recuperar el expediente a modificar");
        top.location = "aplicacion.php"; 
        </script>  
    <?php
    }
}
else
    //validar derechos si ingreso como fiscal
    if ($_SESSION['tipoacceso']== 'Receptor'){
        if (Ejecutar(1)== false && Ejecutar(2)== false){
        ?>
        <script type="text/javascript">
        alert("No tiene acceso a esta opción r");
        top.location = "aplicacion.php"; 
        </script>    
        <?php
        }
    }
 else {
        ?>
        <script type="text/javascript">
        alert("No tiene acceso a esta opción");
        top.location = "aplicacion.php"; 
        </script>    
        <?php        
}



if (isset($_GET['CambiarEstado'])){  
    if($_GET['CambiarEstado']== 'SI'){ 
        //se inicia una nueva denuncia
        ValidarEstado();    
    }
    else{ 
    //el parámetro GET NUEVA se genera en banner_horizontal.php al responder
    //que se quiere continuar con una denuncia nueva        
    if($_GET['CambiarEstado']== 'NUEVA'){  
        //borrar registros en tabla control de estados, para que no quede denuncia pendiente    
        $Usr= $_SESSION['usuario'];
        $sql= "select controlestados_delete('".$Usr."',".$_SESSION['denunciaid'].");";

        $objConexion= new Conexion();
        $rsp= $objConexion->ejecutarProcedimiento($sql);                       

        $_SESSION['CambiarTab']= '0';
        $_SESSION['generales']= 'f';
        $_SESSION['denunciante']= 'f';
        $_SESSION['ofendido']= 'f';
        $_SESSION['denunciado']= 'f';                
  
        unset($oDenuncia);
        unset($oDenunciante);
        unset($oOfendido);
        unset($oDenunciado);
        
        unset($_SESSION["oDenuncia"]);
        unset($_SESSION["oDenunciante"]);
        unset($_SESSION["oOfendido"]);
        unset($_SESSION["oDenunciado"]);       
        unset($_SESSION["denunciaid"]);
        
        //sessions para controlar varios imputados, denunciados y ofendidos
        unset($_SESSION["oDenuncianteCola"]);
        unset($_SESSION["oDenunciadoCola"]);
        unset($_SESSION["oOfendidoCola"]);
        
    }
    //cargar los objetos que existen 
    if (isset($_SESSION["estado"])){ 
        if($_SESSION["estado"]== "Completando"){
            //crear obj denuncia
            if ($_SESSION['generales']== 't'){
                include_once("clases/Denuncia.php");         
                $oDenuncia= new Denuncia;
                $oDenuncia->Recuperar($_SESSION['denunciaid']);             
                $_SESSION["oDenuncia"]= $oDenuncia;  
            }

            //crear obj denunciante
            if($_SESSION['denunciante']== 't'){
                include_once("clases/Denunciante.php");         
                $oDenunciante= new Denunciante;
                $oDenunciante->Recuperar($_SESSION['denunciaid']);                
                $_SESSION["oDenunciante"]= $oDenunciante; 
            }    
            
            //crear obj ofendido o victima
            if($_SESSION['ofendido']== 't'){
                include_once("clases/Ofendido.php");  
                $oOfendido= new Ofendido();           
                $oOfendido->Recuperar($_SESSION['denunciaid']);   
                $_SESSION["oOfendido"]= $oOfendido;  
            }             
            
            //crear obj denunciado o imputado
            if($_SESSION['denunciado']== 't'){
                include_once("clases/Imputado.php");  
                $oDenunciado= new Imputado;
                $oDenunciado->Recuperar($_SESSION['denunciaid']);   
                $_SESSION["oDenunciado"]= $oDenunciado;
            }  
        }        
     }       
   }
}            
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" rel="stylesheet" href="css/Estilos.css">
	<link type="text/css" rel="stylesheet" href="java_script/css/smoothness/jquery-ui-1.10.4.custom.css">
	<script type="text/javascript" src="java_script/js/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="java_script/js/jquery-ui-1.10.4.custom.js"></script>
    
        <script type="text/javascript">    
            $(document).ready(function() {
            //cargar tabs
            $(function() {
                $( "#tabs" ).tabs();
                //alert("listo");
            });        
          
            //cuando se haga clic en cada tab
//            $("a").click(function() {
//                var TabActual = $("#tabs").tabs('option', 'selected');
//
////                alert(TabActual);
//                return true;
//            });

//        $("#tabs" ).tabs({                                                                  
//            activate:function(event,ui){                                                       
////                            alert(ui.newTab.context.id);  
//                            alert(ui.newTab.context.id);
//                    }                                                                          
//         });

            //cuando se hace clic en el
            $("#tabs").tabs({
                activate: function(event, ui) { 
                    var Cambiar;
                    var indice;
                    
                    Cambiar= "<?php echo $_SESSION['CambiarTab']; ?>";
                    
                    indice= ui.newTab.index();

                    switch (indice){                        
                        case 1://denunciante
                            //Cambiar= "<?php //echo(CambiarAtab('Denunciante')); ?>";                            

                            if (Cambiar== 0){
                                alert("Debe guardar los Datos Generales de la denuncia");
                            
                                window.location="crear_denuncia.php";
                            }
                            else
                                return true;
                            
                            break;
                            
                        case 2://denunciado

                            if (Cambiar== 0){
                                alert("Debe guardar los Datos Generales de la denuncia");
                            
                                window.location="crear_denuncia.php";
                            }
                            else
                                return true;
                            
                            break;
                            
                        case 3://ofendido

                            if (Cambiar== 0){
                                alert("Debe guardar los Datos Generales de la denuncia");
                            
                                window.location="crear_denuncia.php";
                            }
                            else{
                                return false;                            
                            }
                            break;
                            
                        case 4://relacion

                            if (Cambiar== 0){
                                alert("Debe guardar los Datos Generales de la denuncia");
                            
                                window.location="crear_denuncia.php";
                            }
                            else{
                                return true;
                            }
                            
                            break;        
                            
                        case 5://finalizar

                            if (Cambiar== 0){
                                alert("Debe guardar los Datos Generales de la denuncia");
                            
                                window.location="crear_denuncia.php";
                            }
                            else
//                                parent.principal.location=parent.principal.location
                                location.href= 'administracion/ProcesaFinalizarDenuncia.php';
                                return true;
                            
                            break;                            
                    }
                    //return Cambiar;                  
                    //alert(ui.index);                    
                    //ui.index= 3;                    
                }
            });  //tabs      
            });  //ready       
        </script>                          
    </head>
<body>   
    <div class="tabuladores">
    <div id="tabs">
            <ul>
                    <li><a href="#tabs-1">Generales</a></li>
                    <li><a href="#tabs-2">Denunciante</a></li>
                    <li><a href="#tabs-3">Denunciado</a></li>
                    <li><a href="#tabs-4">Ofendido</a></li>
                    <li><a href="#tabs-5">Relaciones</a></li>
                    
                    <?php 
                        if ($_SESSION['tipoacceso']== 'Fiscal') {
                    ?>  
                        <li><a href="#tabs-7">Resumen Histórico </a></li>                        
                    <?php
                        }
                    ?>                    
                    
                    <?php 
                        if ($_SESSION['tipoacceso']== 'Receptor') {
                    ?>                        
                        <li><a href="#tabs-6">Finalizar </a></li>
                    <?php
                        }
                    ?>
            </ul>
            <!--datos generales de la denuncia-->
            <div id="tabs-1">
                <div style="padding:0">
                    <iframe id="generales" src="generales/generales.php" align="center" width="1170" height="1200" frameborder="0" scrolling="auto">	
                    </iframe>
            </div>
            </div>

            <!--datos del denunciante-->
            <div id="tabs-2">
                <div style="padding:0">
                    <iframe id="denunciante" src="denunciante/denunciante.php" align="center" width="1170" height="1200" frameborder="0" scrolling="auto">	
                    </iframe>
                </div>
            </div>

            <!--datos del denunciado o imputado-->
            <div id="tabs-3">
                <div style="padding:0">
                    <iframe id="imputado" src="imputado/imputado.php" align="center" width="1170" height="1400" frameborder="0" scrolling="auto">	
                    </iframe>
                </div>
            </div>

            <!--datos de ofendido o victima-->
            <div id="tabs-4">
                <div style="padding:0">
                    <!--<span id="tabOfendido"></span>-->
                    <iframe id="ofendido" src="ofendido/ofendido.php" align="center" width="1170" height="1200" frameborder="0" scrolling="auto">	
                    </iframe>
                </div>
            </div>

            <!--ralaciones estre denunciando, denunciante y victima-->
            <div id="tabs-5">
                <div style="padding:0">
                    <iframe id="relacion" src="relacion/relacion.php" align="center" width="1215" height="1225" frameborder="0" scrolling="auto">	
                    </iframe>
                </div>
            </div>
            
            <!--finalizar ingreso de denuncia-->
            <?php 
            if ($_SESSION['tipoacceso']== 'Receptor') {
            ?> 
                <div id="tabs-6">
                    <div style="padding:0">
                        <iframe id="finalizar" src="administracion/ProcesaFinalizarDenuncia.php" align="center" width="1225" height="450" frameborder="0" scrolling="auto">	
                        </iframe>
                    </div>
                </div>              
            <?php 
                        }
            ?>
          
            
            <!--muestra resumen histórico del expediente-->
            <?php 
            if ($_SESSION['tipoacceso']== 'Fiscal') {
            ?> 
                <div id="tabs-7">
                    <div style="padding:0">
                        <iframe id="finalizar" src="administracion/ProcesaFinalizarDenuncia.php" align="center" width="1225" height="450" frameborder="0" scrolling="auto">	
                        </iframe>
                    </div>
                </div>              
            <?php 
                        }
            ?>
    </div>
    </div>            
</body>
</html