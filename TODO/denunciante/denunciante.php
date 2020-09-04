<?php 	
        include("../clases/controles/funct_text.php");
	include("../clases/controles/funct_select.php");	
	include("../clases/controles/funct_radio.php");
	include("../clases/controles/funct_check.php");

	//clase
	include("../clases/Denunciante.php");
        	
	//funciones genericas
	include "../funciones/php_funciones.php";
        
        //inicia sesión
        session_start();   
        
        if (!isset($_SESSION['usuario'])){	
            header("location:index.php");
        }        
        
        //usr presiono boton nuevo
        if ($_GET["btn"]== "nuevo"){ 
            //borra el objeto actual
            //primero banderas de sesion elementos de denuncia
//            $_SESSION['generales']= 'f';
            $_SESSION['denunciante']= 'f';
//            $_SESSION['denunciado']= 'f';
//            $_SESSION['ofendido']= 'f';                     

            //ahora el objeto
            unset($_SESSION['oDenunciante']);
            unset($oDenunciante);                                    
        }else{        
            //usuario presiono boton para cargar otro denunciante
            
            if(isset($_SESSION["oDenunciante"])){
                //inicializar el objeto
                $oDenunciante= $_SESSION["oDenunciante"];    
            }
//            exit($oDenunciante->getPersonaNatural());
            if (isset($_GET["nmr"])){                                 
                $id= $_GET["nmr"]; 
                
                $oDenunciante= new Denunciante(); 
                $_SESSION["oDenunciante"]= $oDenunciante;
                //recuperar el denunciante con ese id para la denuncia actual
                $oDenunciante->RecuperarId($_SESSION['denunciaid'], $id);  
            }             
        }                   
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>   
	<title>Datos generales</title>
	<meta name="generator" content="Bluefish 2.2.3" >
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link type="text/css" rel="stylesheet" href="css/Estilos.css"> 
	<script type="text/javascript" src="java_script/funciones.js"></script>    
        
        <!-- jquery -->
	<link href="java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
	<script src="java_script/js/jquery-1.10.2.js"></script>
	<script src="java_script/js/jquery-ui-1.10.4.custom.js"></script>               
        
	<script type="text/javascript">            
	$(document).ready(function() {
		$("#acordion").accordion({heightStyle: "content", collapsible: true, active: false,
                                            heightStyle: "content"});  
                                        
                $( "#acordion" ).on( "accordionactivate", function( event, ui ) {
                    indice= ui.newHeader.index();

                    if (indice== 0){
                        participante('listaden2','denunciante');
                    }
                });                                        
                
	});
	</script>        
  
	<!-- declara de acordeon para separar persona natural de juridica -->
	<script type="text/javascript">                  
          
        function Apoderado(){ 
            div = document.getElementById('ApoderadoDid');
            visible= document.getElementById('apoderado').checked;

            if (!visible){
                div.style.display = 'none';
            }
            else{
                div.style.display = '';
            }               
        } 
        
        function NombreAsumido(){ 
            div = document.getElementById('NombreAsumidoId');
            visible= document.getElementById('NombAsumido').checked;

            if (!visible){
                div.style.display = 'none';
            }
            else{
                div.style.display = '';
            }               
        }         

	function Recargar() { 
            var i= document.getElementById("listaden2").selectedIndex;
            var id= document.getElementById("listaden2").options;
            var personaid= id[i].value;
            
            location.reload();
//            alert(location.pathname);
//            location.href='denunciante/denunciante.php?nmr='+"'"+personaid+"'";
//            location.pathname= 'denunciante/denunciante.php?nmr='+"'"+personaid+"'";
//            alert(location.pathname);
	} 
         
	function ValidarNumeros(e) { 
		var keynum = window.event ? window.event.keyCode : e.which;
		if (keynum==8) return true;
		
		patron =/\d/;
		te = String.fromCharCode(keynum);
		
		if (te >= 0 && te <= 9)
			return true;
		else
			return false;
	} 

        function LlenarFormulario(){
                <?php
                if(isset($_SESSION["oDenunciante"])){
                    if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't'){
                ?>
                    //llena depto, municipio, aldea, barrio
                    LlenaDireccion("<?php echo($oDenunciante->getDepartamentoid());?>",
                                        "<?php echo($oDenunciante->getMunicipioid());?>",
                                        "<?php echo($oDenunciante->getAldeaId());?>",
                                        "<?php echo($oDenunciante->getBarrioId());?>"
                                        );                                              
                <?php
                    }
                    else {                        
                ?>
                    LlenaDireccionJ("<?php echo($oDenunciante->getDepartamentoid());?>",
                                        "<?php echo($oDenunciante->getMunicipioid());?>",
                                        "<?php echo($oDenunciante->getAldeaId());?>",
                                        "<?php echo($oDenunciante->getBarrioId());?>"
                                        );                          
                <?php
                    }                        
                }
                ?>                                                  
                }                
        
         
        function QuitarAnoRango(){
            document.getElementById('rdAno0').checked= false;
            document.getElementById('rdAno1').checked= false;
            for(i= 0; i <= 4; i++){
                    radiob= 'rdRangoEdad'+i;
                    document.getElementById(radiob).checked= false;
            }
        }    
  
        //activa txt para numero de documento: identidad, pasaporte, carnet de ...
        function ActivarDocumento(){
            $("#txtIdentidad").removeAttr('disabled');

            if ($("#cboTipoDoc").val() == 0){
                $("#txtIdentidad").val("");
                $("#txtIdentidad").attr('disabled','disabled');
            }
        }
        
        //ventana modal para copiar
        function Copiar(){ 
            if (confirm("¿Copiar a Ofendido?")){
            $.ajax({
                data: "",
                type: "POST",
                dataType: "text",
                url: "funciones/ajax_copiar_denunciante.php",
                error: function(objeto, quepaso, otroobj){
                    alert("Error al copiar datos del denunciante: "+objeto+quepaso+otroobj);        
                },
                success: function(data){
                    alert(data);
//                    document.getElementById("btnCopiar").disabled= true;
//                    location.reload();
                }
            })  
            }
        }

        /*funcion: participantes
         *lista los denunciantes ingresados
        */
        function participante(destino, participante){
//            alert(destino+' '+participante);
            $.ajax({
                data: "id="+destino+"&participante="+participante,
                type: "POST",
                dataType: "html",
                url: "funciones/ajax_DenuncianteImputadoOfendido.php",
                error: function(obj, que, otro){
                    alert("Error ajax al cargar lista de participante (denunciante, ofendido, imputado)");
                },
                success: function(data){  
                    $("#listaden").html(data); 
                }
            });    
        }   
        
        function ActualizarListaDEnunciante(){
            //llenar el combo ofendidos ingresados
            participante('listaden2','denunciante');
        }   
        
        function CrearNuevo(){
//            location.pathname= '/denunciasvn/crear_denuncia.php';
//            window.location='denunciante/denunciante.php?btn=nuevo';
            
            alert(location.pathname);
            location.href='denunciante/denunciante.php?btn=nuevo';
            location.pathname= '/denunciasvn/crear_denuncia.php';
            alert(location.pathname);            
        }
          
    </script>        
</head>
<body>         

<a name="inicio"></a>

<br><br>

<!-- mostrar mensaje de grabacion exitosa -->
<!-- orm_denunciante.php llama a esta pagina cuando tiene exito en grabar -->
<?php
if (isset($_GET["rsl2"]))
    if($_GET["rsl2"]== 100)
    {
?>
        <script type="text/javascript">
            Copiar();
        </script>    
<?php
    unset($_GET["rsl2"]);
    }
?> 

<?php
if (isset($_GET["rsl2"]))
    if($_GET["rsl2"]== 200)
    {
?>
    <script type="text/javascript">
        alert("Se han modificado los datos del denunciante");
        Copiar();
    </script>    
<?php
    unset($_GET["rsl2"]);
    }
?> 
    
<?php
if (isset($_GET["rsl2"]))
    if($_GET["rsl2"]== 300)
    {
?>
    <script type="text/javascript">
        alert("ERROR al guardar los datos: "+"<?php echo $_GET['err']; ?>");
    </script>    
<?php
    unset($_GET["rsl2"]);
    }
?>     

<!-- efinicion de acordeon para separar persona natural de juridica -->
<!--<div class="denunciante">  14 mier mayo psicocita mig  paty ced: 95 88 46 73 -->

<!--cpcedeno@grupoficohsa.hn--> 

<div id="acordion">        

<h3><a href="#">Persona Natural</a></h3>

<div> 
     <!--inicia acordeon persona natural-->
    <form action="denunciante/procesadenunciante.php" method="POST" name="frmDenunciante" 
        id="frmDenunciante" onsubmit="return ValidarDenunciante(this);">       
        
    <input type="hidden" name="txtDireccion2" id="txtDireccion2">
    <input type="hidden" name="txtPersonaId" id="txtPersonaId"
           value="<?php if (isset($_SESSION['oDenunciante']))
               echo($oDenunciante->getPersonaId()); ?>"/>         
    
    <!--los botones para guardar-->    
    <table align="center" summary="botones persona natural">
        <tr>     
        <td><INPUT type="submit" name="btnSubmit" value="Guardar datos"></td>
        <td><INPUT type="button" name="btnNuevo" value="Agregar nuevo" 
                   onClick="CrearNuevo();"></td> 
        <td><INPUT type="button" name="btnBorrar" value="Borrar actual" 
                   onClick="BorrarRegistro(document.getElementById('txtPersonaId').value);"></td>      
        </tr>
    </table>  
    
    <table id="tblDenunciante1" align="center" border="0" 
           class="TablaCaja" summary="persona natural">
        <tr class="SubTituloCentro">
            <th align="center">Identificación</th>
            <th align="center" colspan="2">Sexo y orientación sexual</th>
            <th></th>
            <th align="left">Apoderado legal</th>
        </tr>
        <tr>
            <td>
                <input type="radio" name="rdConocido" id="rdConocido" value="0" 
                       onClick="ValidarConocido('ano', 'frmdenunciante');"/>Anónimo<br>

                <input type="radio" name="rdConocido" id="rdConocido" value="2" disabled
                       onClick="ValidarConocido('ocu', 'frmdenunciante');"/>Ocultar Identidad<br>            

                <input type="radio" name="rdConocido" id="rdConocido" value="1" checked
                       onClick="ValidarConocido('con', 'frmdenunciante');"/>Conocido<br>

                <input type="radio" name="rdConocido" id="rdConocido" value="3"
                       onClick="ValidarConocido('ofi', 'frmdenunciante');"/>De Oficio<br>
            </td>
            
            <td>
                <input type="radio" name="rdSexo" id="rdSexo0" value="m" onClick="llenarsexo('selSexo1','m', forms.frmDenunciante);"/>Masculino<br>
                <input type="radio" name="rdSexo" id="rdSexo1" value="f" onClick="llenarsexo('selSexo1','f', forms.frmDenunciante);"/>Femenino<br>    
                <input type="radio" name="rdSexo" id="rdSexo2" value="x" onClick="llenarsexo('selSexo1','x', forms.frmDenunciante);"/>No consignado<br>                
            </td>
            
            <td>
                Orientación sexual<br>
                <span id="sexo"></span>
                <script type="text/javascript">    
                    var frm= document.forms.frmDenunciante;
                    llenarsexo('selSexo1','y', frm);                                   
                </script>  
                <br>     
                <input type="checkbox" name="NombAsumido" id="NombAsumido" value="0" onclick="NombreAsumido();"/>Nombre asumido
            </td>
            <td></td>
            <td>
                <input type="checkbox" name="apoderado" id="apoderado" value="0" onclick="Apoderado();"/>Apoderado Legal     
            </td>
        </tr> 
    </table>

    <!--radios de conocido o no-->
    <?php if (isset($_SESSION['oDenunciante'])) {
        if ($oDenunciante->getConocido()== 0)
        {
    ?>
        <script type="text/javascript">
            $('input:radio[name=rdConocido]')[0].checked= true;  
        </script>
    <?php 
        }
        elseif($oDenunciante->getConocido()== 1)
        {
    ?>
        <script type="text/javascript">
            $('input:radio[name=rdConocido]')[2].checked= true;            
        </script>           
    <?php 
        }
        elseif($oDenunciante->getConocido()== 2)
        {
    ?>
        <script type="text/javascript">
            $('input:radio[name=rdConocido]')[1].checked= true;            
        </script>      
    <?php
        }
        elseif($oDenunciante->getConocido()== 3)
        {
    ?>
        <script type="text/javascript">                    
            $('input:radio[name=rdConocido]')[3].checked= true;      
        </script>      
    <?php
        }
    }
    ?>

    <!--radios de sexo-->
    <?php if (isset($_SESSION['oDenunciante'])) {
        if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't'){
            if ($oDenunciante->getGenero()== 'm')
            {
        ?>
            <script type="text/javascript">
                $('input:radio[name=rdSexo]')[0].checked= true; 
            </script>
        <?php 
            }
            elseif($oDenunciante->getGenero()== 'f')
            {
        ?>          
            <script type="text/javascript">
                $('input:radio[name=rdSexo]')[1].checked= true;
            </script>                                
        <?php
            }
            elseif($oDenunciante->getGenero()== 'x')
            {                
        ?>
            <script type="text/javascript">
                $('input:radio[name=rdSexo]')[2].checked= true;
            </script>                 
        <?php
            }
        }
    }
    ?>      

    <!--llena check de nombre asumido-->
    <?php if (isset($_SESSION['oDenunciante'])) {    
        if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't'){
            $asumido= $oDenunciante->getNombreAsumido();
            if (!empty($asumido))        
            {
    ?>
                <script type="text/javascript">             
                    document.getElementById("NombAsumido").checked= true; 
                </script>
    <?php  
            }            
            else
            {
    ?>
                <script type="text/javascript">             
                    document.getElementById("NombAsumido").checked= false; 
                </script>    
    <?php 
            }
        }
    }
    ?>     
    
    <!-- apoderado legal -->    
    <br>
    <div id="ApoderadoDid">
        <table id="tblApoderado" align="center" width="95%" border="0" 
               class="TablaCaja" summary="apoderado legal">
            <tr class="SubTituloCentro"><th colspan="4">Apoderado Legal</th></tr>
            <tr class=" Grid">
                <td align="right">Nombre completo</td>
                <td>            
                    <input name="txtApoderado" type="text" id="txtApoderado" size="25" maxlength="24"
                           value="<?php if (isset($_SESSION['oDenunciante']))
                           { if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getApoderadoNombre()); } ?>"/> 
                </td>
                <td align="right">Número Colegio</td>
                <td>            
                    <input name="txtColegio" type="text" id="txtColegio" size="25" maxlength="5"
                           value="<?php if (isset($_SESSION['oDenunciante']))
                           { if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getApoderadoColegio()); } ?>"/> 
                </td>            
            </tr>
        </table> 
        <br>
    </div>
    
    <!-- nombre asumido -->
    <div id="NombreAsumidoId">
        <table id="tblNombreAsum" align="center" width="95%" border="0" 
               class="TablaCaja" summary="nombreasumido legal">
            <tr class="SubTituloCentro"><th colspan="4">Nombre asumido</th></tr>
            <tr class=" Grid">
                <td align="right">Nombre asumido</td>
                <td>            
                    <input name="txtNombreAsum" type="text" id="txtNombreAsum" size="25" maxlength="24"
                           value="<?php if (isset($_SESSION['oDenunciante']))
                           { if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getNombreAsumido()); } ?>"/> 
                </td>          
            </tr>
        </table> 
    </div>    
    
    <!-- para mostrar la tabla de apoderado legal -->
    <script type="text/javascript">
        Apoderado();
    </script>
    
    <!-- para mostrar la tabla de apoderado legal -->
    <script type="text/javascript">
        NombreAsumido();
    </script>    

    <br><br>
    <!lista de denunciantes ingresados >
    <table id="tblListaDenunciante" align="center" width="100%" border="0" 
           class="TablaCaja" summary="lista de denunciante">
        <tr class="SubTituloCentro"><TH colspan="4">Lista de denunciantes ingresados</TH></tr>
        <tr>
        <td><span id="listaden"></span></td>
        </tr>
    </table>
    <br><br>
    
    <script type="text/javascript">
        participante('listaden2','denunciante');
    </script>    

    <table id="tblDenunciante2" align="center"  border="0"  width="100%"
           class="TablaCaja" summary="persona natural">    
        <tr class="SubTituloCentro"><TH colspan="4">Datos Generales</TH></tr>
        <tr class="Grid">
        <td align="right">Nombres</td>
        <td>
            <input name="txtNombres" type="text" id="txtNombres" size="25" maxlength="24"
                   value="<?php if (isset($_SESSION['oDenunciante']))
                       { if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getNombreCompleto()); } ?>"/>  
        </td>    
        <td align="right">Apellidos</td>
        <td>            
            <input name="txtApellidos" type="text" id="txtApellidos" size="25" maxlength="24"
                   value="<?php if (isset($_SESSION['oDenunciante']))
                       { if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getApellidoCompleto()); } ?>"/> 
        </td>
        </tr>
        <tr class="Grid">
        <td align="right">Nacionalidad</td>
        <td>
            <?php
            $resNacion= CargarNacionalidad();
            combo("cboNacionalidad",$resNacion,"cnacionalidadid","cdescripcion");
            ?>
            <script type="text/javascript">
                document.getElementById('cboNacionalidad').value= 
                "<?php if (isset($_SESSION['oDenunciante'])) 
                    {
                        if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't')
                            echo $oDenunciante->getNacionalidad();
                    }
                    else
                    {
                        echo 'HN'; 
                    }
                ?>";
            </script>            
        </td>
        <td align="right">Estado civil</td>
        <td>	
            <?php
                $resCivil= CargarEstadoCivil();
                combo("cboCivil",$resCivil,"ncivil","cdescripcion");
            ?>
            <script type="text/javascript">                          
                $("#cboCivil").val("<?php if (isset($_SESSION['oDenunciante']))
                       { if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getEstadoCivil()); } else { echo(0); } ?>");                           
            </script>              
        </td>
        </tr>
        <tr class="Grid">
        <td align="right">Pasaporte/Identidad</td>
        <td>  
            Tipo de documento
            <?php
                $resTipodoc= CargarTipoDocumento();
                combo("cboTipoDoc",$resTipodoc,"ndocumentoid","cdescripcion","","onchange='ActivarDocumento()'");
            ?>
            <script type="text/javascript">
                document.getElementById("cboTipoDoc").value= 
                        "<?php if (isset($_SESSION['oDenunciante']))
                        { if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't') 
                            echo($oDenunciante->getTipoDocumento()); }?>";

            </script>  
            <input name="txtIdentidad" type="text" id="txtIdentidad" size="15" maxlength="19" disabled
                value="<?php if (isset($_SESSION['oDenunciante']))
                { if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getIdentidad()); }?>"/>                

            <script type="text/javascript">
                if ($("#cboTipoDoc").val() != 0){
                    $("#txtIdentidad").removeAttr('disabled');
                }                    
            </script>            
        </td>
        <td align="right">Escolaridad</td>
        <td>
            <?php
                $resEscolar= CargarEscolaridad();
                combo("cboEscolar",$resEscolar,"nescolaridadid","cdescripcion");
            ?>    
            <script type="text/javascript">
                $("#cboEscolar").attr("value","<?php if (isset($_SESSION['oDenunciante']))
                       { if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getEscolaridad()); } ?>");
            </script>            
        </td>
        </tr>
        <tr class="Grid">
        <td align="right">Profesion/oficio</td>
        <td>
            <?php
                $resProfe= CargarProfesion();
                combo("cboProfe",$resProfe,"nprofesionid","cdescripcion");
            ?>
            <script type="text/javascript">
                $("#cboProfe").attr("value","<?php if (isset($_SESSION['oDenunciante']))
                       { if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getProfesion()); } ?>");
            </script>              
        </td>
        <td align="right">Ocupación</td>
        <td>	
            <?php
                $resOcupa= CargarOcupacion();
                combo("cboOcupa",$resOcupa,"nocupacionid","cdescripcion");
            ?>
            <script type="text/javascript">
                $("#cboOcupa").attr("value","<?php if (isset($_SESSION['oDenunciante']))
                       { if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getOcupacion()); } ?>");
            </script>               
        </td>
        </tr>
        <tr class="Grid">
        <td align="right">Edad</td>
        <td> 
            <!--<input type="txtEdad2" onkeypress="return ValidarNumeros(event)">-->
<!--                OJO no se debe modificar el nombre y id de este campo pq lo usa la
                funcion javascript llenarsexo, que se dispara de los radios sexo-->            
            <input name="txtEdad" type="text" id="txtEdad" size="5" maxlength="3"
                   onkeypress="return ValidarNumeros(event);" disabled="disabled" 
                   onclick="QuitarAnoRango();"
                   value="<?php if (isset($_SESSION['oDenunciante']))
                       { if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getEdad()); } else {echo "0";} ?>"/>   

            &nbsp;&nbsp; 
            <!-- ojo valores en value con/des afectan "procesadenunciante.php"-->
            <input type="radio" name="rdAno" id="rdAno0" value="con" 
                   onclick="ValidarEdadrb(this);"/> Años
            <input type="radio" name="rdAno" id="rdAno1" value="des" checked 
                   onclick="ValidarEdadrb(this);"/> Desconocida
            
            <?php if (isset($_SESSION['oDenunciante']))
                  if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't')
                  { 
                       if ($oDenunciante->getUmeDidaEdad()== 'a')
                       {
            ?>
                        <script type="text/javascript">
                            $('input:radio[name=rdAno]')[0].checked= true;
                        </script>                            
            <?php
                       }
                       elseif ($oDenunciante->getUmeDidaEdad()== 'x')
                       {
            ?>
                        <script type="text/javascript">
                            $('input:radio[name=rdAno]')[1].checked= true;
                        </script> 
            <?php
                       }
                  }
            ?>
        </td>
        <td colspan="2">
            <!-- ojo los cambios en value, se deben confirmar en procesadenunciante.php -->
            <input type="radio" name="rdRangoEdad" id="rdRangoEdad0" value="infante" 
                   onclick="ValidarRangoEdad(forms.frmDenunciante);"/>Infante
            
            <input type="radio" name="rdRangoEdad" id="rdRangoEdad1" value="adelescente" 
                   onclick="ValidarRangoEdad(forms.frmDenunciante);"/>Adolescente
            
            <input type="radio" name="rdRangoEdad" id="rdRangoEdad2" value="menoradulto" 
                   onclick="ValidarRangoEdad(forms.frmDenunciante);"/>Menor adulto
            
            <input type="radio" name="rdRangoEdad" id="rdRangoEdad3" value="adulto" 
                   onclick="ValidarRangoEdad(forms.frmDenunciante);"/>Adulto
            
            <input type="radio" name="rdRangoEdad" id="rdRangoEdad4" value="adultomayor" 
                   onclick="ValidarRangoEdad(forms.frmDenunciante);"/>Adulto mayor  

            <input type="radio" name="rdRangoEdad" id="rdRangoEdad5" value="noconsignado" 
                   onclick="ValidarRangoEdad(forms.frmDenunciante);"/>No consignado 
            
            <?php if (isset($_SESSION['oDenunciante']))
                  if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't')
                   { 
                       if ($oDenunciante->getRangoEdad()== 'ni')
                       {
            ?>
                        <script type="text/javascript">
                            $('input:radio[name=rdRangoEdad]')[0].checked= true;
                        </script>  
            <?php
                       }
                       elseif ($oDenunciante->getRangoEdad()== 'na')
                       {
            ?>
                        <script type="text/javascript">
                            $('input:radio[name=rdRangoEdad]')[1].checked= true;
                        </script>        
            <?php
                       }
                       elseif ($oDenunciante->getRangoEdad()== 'nm')
                       {
            ?>
                        <script type="text/javascript">
                            $('input:radio[name=rdRangoEdad]')[2].checked= true;
                        </script> 
            <?php
                       }
                       elseif ($oDenunciante->getRangoEdad()== 'a')
                       {
            ?>
                        <script type="text/javascript">
                            $('input:radio[name=rdRangoEdad]')[3].checked= true;
                        </script> 
            <?php
                       }
                       elseif ($oDenunciante->getRangoEdad()== 'am')
                       {
            ?>
                        <script type="text/javascript">
                            $('input:radio[name=rdRangoEdad]')[4].checked= true;
                        </script>                                     
            <?php
                       }
                   }
            ?>
        </td>
        </tr>
    </table>
    
    <br><br>
    
    <table id="tblDenunciante3" align="center"  border="0" width="100%"
           class="TablaCaja" summary="persona natural">    
        <tr class="SubTituloCentro"><TH colspan="4">Dirección Domiciliar</TH></tr>
        <tr class="Grid">
        <td align="right">Departamento</td>
        <td>
            <?php
                    $resDepto= CargarDepto();
                    combo("cboDepto",$resDepto,"cdepartamentoid","cdescripcion","",
                            "onchange='llena_muni(".'"cboDepto"'.",".'"cboMuni"'.",
                                ".'"tdMuni"'.",".'"22"'.",".'"cboAldea"'.",".'"cboBarrio"'.")'");
            ?>
        </td>
        <td align="right">Municipio</td>
        <td id="tdMuni">
            <?php
                //$resMuni= CargarMunicipio();
                combo("cboMuni",$resMuni,"cmunicipioid","cdescripcion","","onchange='llena_aldea(".'"cboDepto"'.",".'"cboMuni"'.",
                                ".'"cboAldea"'.",".'"tdAldea"'.",".'"22"'.",".'"cboBarrio"'.")'");
            ?>
        </td>
        </tr>
        <tr class="Grid">
        <td align="right">Aldea</td>
        <td id="tdAldea">
            <?php
                //$resAldea= CargarAldea();
		combo("cboAldea","","caldeaid","cdescripcion","",
                      "onchange='llena_barrio(".'"cboDepto"'.",".'"cboMuni"'.",
                      ".'"cboAldea"'.",".'"cboBarrio"'.",".'"tdBarrio"'.",".'"6"'.")'");                
            ?>
        </td>
        <td align="right">Barrio</td>
        <td id="tdBarrio">
            <?php
                //$resBarrio= CargarBarrio();
                combo("cboBarrio","","cbarrioId","cdescripcion","","");
            ?>
        </td>
        </tr>
        <tr class="Grid">
            <td align="right">Detalle dirección</td>
        <td colspan="3">
            <input name="txtDireccion" type="text" id="txtDireccion" size="80" maxlength="199"
                   value="<?php if (isset($_SESSION['oDenunciante']))
                       { if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getDetalle()); } ?>"/>   
        </td>
        </tr>
        <tr class="Grid">
        <td align="right">Teléfonos</td>
        <td colspan="3">
            <input name="txtTelefono" type="text" id="txtTelefono" size="50" maxlength="49"
                   value="<?php if (isset($_SESSION['oDenunciante']))
                   { if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getTelefono()); } ?>"/>
        </td>            
        </tr>
    </table>
    
    <br><br>
    
    <table id="tblDenunciante4" align="center" width="100%" border="0" 
           class="TablaCaja" summary="persona natural">  
        <tr class="SubTituloCentro"><TH colspan="4">Otros Datos</TH></tr>
        <tr class="Grid">
            <td align="right">Pueblo indígena</td>
        <td>	
                <?php
                    $resEtnia= CargarEtnia();
                    combo("cboEtnia",$resEtnia,"netniaid","cdescripcion",
                            "Seleccione una etnia");
                ?>
                <script type="text/javascript">
                    $("#cboEtnia").attr("value","<?php if (isset($_SESSION['oDenunciante']))
                        { if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getGrupoEtnico()); } ?>");
                </script>                
        </td>
        <td align="right">Discapacidad</td>
        <td>	<?php
                    $resDisca= CargarDiscapacidad();
                    combo("cboDiscapacidad",$resDisca,"ndiscapacidadid",
                            "cdescripcion","Seleccione una discapacidad");
                ?>
                <script type="text/javascript">
                    $("#cboDiscapacidad").attr("value","<?php if (isset($_SESSION['oDenunciante']))
                        { if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getDiscapacidad()); } ?>");
                </script>                
        </td>
        </tr>        
    </table>
    <br><br>
    <!lista de denunciantes ingresados >
    <table id="tblListaDenunciante" align="center" width="100%" border="0" 
           class="TablaCaja" summary="lista de denunciante">
        <tr class="SubTituloCentro"><TH colspan="4">Lista de denunciantes ingresados</TH></tr>
        <tr>
        <td><span id="listaden"></span></td>
        </tr>
    </table>
    
    <!--los botones para guardar-->
    <br>
    <table align="center" summary="botones persona natural">
        <tr>     
        <td><INPUT type="submit" name="btnSubmit" value="Guardar datos"></td>
        <td><INPUT type="button" name="btnNuevo" value="Agregar nuevo" 
                   onClick="window.location='denunciante.php?btn=nuevo';"></td> 
        <td><INPUT type="button" name="btnBorrar" value="Borrar actual" 
                   onClick="BorrarRegistro(document.getElementById('txtPersonaId').value);"></td>      
        </tr>
    </table>
    </FORM>           
</div> <!-- fin persona natural-->           
<h3>Persona Juridica</h3>
<div>

<form action="procesadenunciante.php" method="POST"
        id="frmDenuncianteJuridico" onsubmit="return ValidarDenuncianteJuridico(this);">  
    <input type="hidden" id='DenuncianteJur' name='DenuncianteJur'>
    <input type="hidden" name="txtPersonaId" id="txtPersonaId"
                   value="<?php if (isset($_SESSION['oDenunciante']))
                       { if ($oDenunciante->getPersonaNatural()== '0' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getPersonaId());} ?>"/>
    
    <table id="tblPersonaJuridica" align="center" width="95%" border= "0"
           class="TablaCaja" summary="datos persona natural">
        
    <tr class="SubTituloCentro"><th colspan="4">Datos generales de la empresa</th></tr>
       
        <td align="right">Nombre de empresa o institución</td>
        
        <td><input list="txtEmpresasHn" name="txtEmpresasHn" size="30" maxlength="99" 
                   onblur="document.getElementById('DenuncianteJur').value= 'juridico';"
                   value="<?php if (isset($_SESSION['oDenunciante']))
                        { if ($oDenunciante->getPersonaNatural()== '0' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getNombreCompleto());  } ?>"/>
            <datalist id="txtEmpresasHn">
                <?php
                    $resEmpresas= CargarEmpresasHN();
                    while ($Rol= pg_fetch_array($resEmpresas)) {
                        echo "<option value='$Rol[cdescripcion]'>";
                    }
                ?>
            </datalist>    
        </td>
        <td align="right">RTN</td>
        <td>            
            <input type="text" id="txtRtn" name="txtRtn" size="15" maxlength="19"
                   value="<?php if (isset($_SESSION['oDenunciante']))
                        { if ($oDenunciante->getPersonaNatural()== '0' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getIdentidad());  } ?>">
        </td> 
    <tr>
        <td align="right">Nacionalidad</td>
        <td>
            <?php
            $resNacionJ= CargarNacionalidad();
            combo("cboNacionalidadJ",$resNacionJ,"cnacionalidadid","cdescripcion");
            ?>
            <script type="text/javascript">
                $("#cboNacionalidadJ").attr("value","<?php if (isset($_SESSION['oDenunciante']))
                       { if ($oDenunciante->getPersonaNatural()== '0' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getNacionalidad()); } else { echo('HN'); } ?>");
            </script>         
        </td>        
        <td align="right">Teléfonos</td>
        <td>
            <input type="text" id="txtTelefono" name="txtTelefono" size="15" maxlength="59"
                   value="<?php if (isset($_SESSION['oDenunciante']))
                       { if ($oDenunciante->getPersonaNatural()== '0' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getTelefono()); } ?>">
        </td>
        <td></td>
    </tr>
        <tr class="Grid">
        <td align="right">Departamento</td>
        <td>
            <?php
                    $resDeptoJ= CargarDepto();
                    combo("cboDeptoJ",$resDeptoJ,"cdepartamentoid","cdescripcion","",
                            "onchange='llena_muni(".'"cboDeptoJ"'.",".'"cboMuniJ"'.",
                                ".'"tdMuniJ"'.",".'"32"'.",".'"cboAldeaJ"'.",".'"cboBarrioJ"'.")'");
            ?>
        </td>
        <td align="right">Municipio</td>
        <td id="tdMuniJ">
            <?php
//                $resMuniJ= CargarMunicipio();                
            ?>
        </td>
        </tr>
        <tr class="Grid">
        <td align="right">Aldea</td>
        <td id="tdAldeaJ">
            <?php
//                $resAldeaJ= CargarAldea();
		combo("cboAldeaJ","","caldeaid","cdescripcion","",
                      "onchange='llena_barrio(".'"cboDeptoJ"'.",".'"cboMuniJ"'.",
                      ".'"cboAldeaJ"'.",".'"cboBarrioJ"'.",".'"tdBarrioJ"'.",".'"6"'.")'");                
            ?>
        </td>
        <td align="right">Barrio</td>
        <td id="tdBarrioJ">
            <?php
                //$resBarrio= CargarBarrio();
                combo("cboBarrioJ","","cbarrioId","cdescripcion","","");
            ?>
        </td>
        </tr>
     <tr>
        <td align="right">Detalle dirección</td>
        <td colspan="3">
            <input list="txtDireccionJuridica" name="txtDireccionJuridica" size="80" maxlength="199" required
                   value="<?php if (isset($_SESSION['oDenunciante']))
                       { if ($oDenunciante->getPersonaNatural()== '0' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getTxtDireccion());} ?>">
        </td>
     </tr>    
    </table>  
    <br><br>
        <table id="tblApoderado" align="center" width="95%" border="0" 
               class="TablaCaja" summary="apoderado legal">
            <tr class="SubTituloCentro"><th colspan="4">Representante o apoderado Legal</th></tr>
            <tr class=" Grid">
                <td align="right">Nombre completo</td>
                <td>            
                    <input name="txtApoderadoJ" type="text" id="txtApoderadoJ" size="25" maxlength="50"
                           value="<?php if (isset($_SESSION['oDenunciante']))
                           { if ($oDenunciante->getPersonaNatural()== '0' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getApoderadoNombre()); } ?>"/> 
                </td>
                <td align="right">Identificación</td>
                <td>            
                    <input name="txtColegioJ" type="text" id="txtColegioJ" size="15" maxlength="20"
                           value="<?php if (isset($_SESSION['oDenunciante']))
                           { if ($oDenunciante->getPersonaNatural()== '0' || $oDenunciante->getPersonaNatural()== 't') 
                               if ($oDenunciante->getTipoDocumento() != 5)
                                   echo($oDenunciante->getIdentidad());
                               else
                                   echo($oDenunciante->getApoderadoColegio());                                
                           } ?>"/>                     
                    <input name="rdTipoDoc" id="rdTipoDoc" type="radio" type="radio" value="colegio" checked>Número colegiado
                    <input name="rdTipoDoc" id="rdTipoDoc" type="radio" type="radio" value="identidad">Identidad
                    <input name="rdTipoDoc" id="rdTipoDoc" type="radio" type="radio" value="pasaporte">Pasaporte
                </td>            
            </tr>
        </table>     
    <!--los botones para guardar-->
    <br>
    <table align="center" summary="botones persona natural">
        <tr>     
        <td><INPUT type="submit" name="btnSubmit" value="Guardar datos"></td>
        <td><INPUT type="button" name="btnNuevo" value="Agregar nuevo" 
                   onClick="window.location='denunciante.php?btn=nuevo';"></td>  
        </tr>
    </table>   
</form>      
</div> <!-- fin persona juridica-->  

</div> <!--fin acordeon-->

<script type="text/javascript">
         //llenar el combo denunciantes ingresados
        participante('listaden2','denunciante'); 

        LlenarFormulario();    

        //saber cual radio sexo esta seleccionado: masculino, femenino
        Sexo= $('input[name=rdSexo]:checked', '#frmDenunciante').val();    

        //llenar la lista de preferencia sexual
        <?php if (isset($_SESSION['oDenunciante'])){ ?>  
            Orientacion= "<?php echo($oDenunciante->getOrientacionSex());?>";
        <?php 
        }
        ?>

        llenarsexo('selSexo1',Sexo,frmDenunciante,Orientacion);  
        
        <?php if (isset($_SESSION['oDenunciante'])) {
            if ($oDenunciante->getConocido()== 0)
            {
        ?>
                ValidarConocido('ano');
        <?php }
            if ($oDenunciante->getConocido()== 3)
            {
        ?>                
                ValidarConocido('ofi');  
        <?php
            }
        }
        ?>        
            
           
        //llena depto, municipio, aldea, barrio
        function LlenaDireccion(Departamentoid, Municipioid, AldeaId, BarrioId){
//            alert(Departamentoid+" "+Municipioid+" "+AldeaId+" "+BarrioId); 
            
            $.ajax({
                data:"accion=depto",
                type: "POST",
                dataType: "html",
                url: "funciones/ajax_llenadireccion.php",
                error: function(objeto, quepaso, otroobj){
                    alert("Error al cargar Departamento: "+quepaso);
                },
                success: function(data){
                    $("#cboDepto").html(data); //crea la lista de deptos
                    $("#cboDepto option[value="+Departamentoid+"]").attr("selected",true);
//                    document.getElementById('cboDepto').value= Departamentoid;
//                    $("#cboDepto").attr("value",Departamentoid); //selecciona el depto
                    //ajax para llenar el municipio
                    $.ajax({
                        data: "accion=muni&coddepto="+Departamentoid,
                        type: "POST",
                        dataType: "html",
                        url: "funciones/ajax_llenadireccion.php",
                        error: function(objeto, quepaso, otroobj){
                            alert("Error al cargar Municipio: "+quepaso);
                        },
                        success: function(data){
                            $("#cboMuni").html(data);
                            $("#cboMuni option[value="+Municipioid+"]").attr("selected",true);
//                            $("#cboMuni").attr("value",Municipioid);
                            //ajax para llenar la ciudad o aldea
                            $.ajax({                        
                                data: "accion=aldea&codmuni="+Municipioid+"&coddepto="+Departamentoid+"&codaldea="+AldeaId,
                                type: "POST",
                                dataType: "html",
                                url: "funciones/ajax_llenadireccion.php",
                                error: function(objeto, quepaso, otroobj){
                                    alert("Error al cargar Aldea o Ciudad: "+quepaso);
                                },
                                success: function(data){
                                    $("#cboAldea").html(data);
                                    $("#cboAldea option[value="+AldeaId+"]").attr("selected",true);
//                                    $("#cboAldea").attr("value",AldeaId);
                                }
                            });
                        }
                    });
                }
            }); 
            $.ajax({
                data: "accion=barrio&codmuni="+Municipioid+"&coddepto="+Departamentoid+"&codaldea="+AldeaId+"&codbarrio="+BarrioId,
                type: "POST",
                dataType: "html",
                url: "funciones/ajax_llenadireccion.php",
                error: function(objeto, quepaso, otroobj){
                    alert("Error al cargar Barrio o Colonia");        
                },
                success: function(data){
                    $("#cboBarrio").html(data);
                    $("#cboBarrio option[value="+BarrioId+"]").attr("selected",true);
//                    $("#cboBarrio").attr("value",BarrioId);            
                }
            });
        }
        
        //llena depto, municipio, aldea, barrio
        function LlenaDireccionJ(Departamentoid, Municipioid, AldeaId, BarrioId){
//            alert(Departamentoid+" "+Municipioid+" "+AldeaId+" "+BarrioId);
            $.ajax({
                data:"accion=depto",
                type: "POST",
                dataType: "html",
                url: "funciones/ajax_llenadireccion.php",
                error: function(objeto, quepaso, otroobj){
                    alert("Error al cargar Departamento: "+quepaso);
                },
                success: function(data){
                    $("#cboDeptoJ").html(data); //crea la lista de deptos
                    $("#cboDeptoJ option[value="+Departamentoid+"]").attr("selected",true);
//                    $("#cboDeptoJ").attr("value",Departamentoid); //selecciona el depto
                    //ajax para llenar el municipio
                    $.ajax({
                        data: "accion=muni&coddepto="+Departamentoid,
                        type: "POST",
                        dataType: "html",
                        url: "funciones/ajax_llenadireccion.php",
                        error: function(objeto, quepaso, otroobj){
                            alert("Error al cargar Municipio: "+quepaso);
                        },
                        success: function(data){
                            $("#cboMuniJ").html(data);
                            $("#cboMuniJ option[value="+Municipioid+"]").attr("selected",true);
//                            $("#cboMuniJ").attr("value",Municipioid);
                            //ajax para llenar la ciudad o aldea
                            $.ajax({                        
                                data: "accion=aldea&codmuni="+Municipioid+"&coddepto="+Departamentoid+"&codaldea="+AldeaId,
                                type: "POST",
                                dataType: "html",
                                url: "funciones/ajax_llenadireccion.php",
                                error: function(objeto, quepaso, otroobj){
                                    alert("Error al cargar Aldea o Ciudad: "+quepaso);
                                },
                                success: function(data){
                                    $("#cboAldeaJ").html(data);
                                    $("#cboAldeaJ option[value="+AldeaId+"]").attr("selected",true);
//                                    $("#cboAldeaJ").attr("value",AldeaId);
                                }
                            });
                        }
                    });
                }
            }); 
            $.ajax({
                data: "accion=barrio&codmuni="+Municipioid+"&coddepto="+Departamentoid+"&codaldea="+AldeaId+"&codbarrio="+BarrioId,
                type: "POST",
                dataType: "html",
                url: "funciones/ajax_llenadireccion.php",
                error: function(objeto, quepaso, otroobj){
                    alert("Error al cargar Barrio o Colonia");        
                },
                success: function(data){
                    $("#cboBarrioJ").html(data);
                    $("#cboBarrioJ option[value="+BarrioId+"]").attr("selected",true);
//                    $("#cboBarrioJ").attr("value",BarrioId);            
                }
            });
        }
        
        
   
        
        /*funcion: borrar un registro
        * 
         */
         function BorrarRegistro(){
            var rsp= confirm("Presione Aceptar para Borrar los datos que está viendo en pantalla.\n"+
                            "<?php echo $oDenunciante->getNombreCompleto(); ?>"+" "+
                            "<?php echo $oDenunciante->getApellidoCompleto(); ?>");
            if (rsp== true) 
                window.location="administracion/BorrarRegistros.php?reg=denunciante&id=<?php echo $oDenunciante->getPersonaId(); ?>";
         }

</script>        
</body>
<!--don carlos ortiz horno: 3382 6601 97975367-->
</html>
