<?php

    include("../clases/controles/funct_text.php");
    include("../clases/controles/funct_select.php");	
    include("../clases/controles/funct_radio.php");
    include("../clases/controles/funct_check.php");

    //clase
    include("../clases/Ofendido.php");


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
//            $_SESSION['denunciante']= 'f';
//            $_SESSION['denunciado']= 'f';
            $_SESSION['ofendido']= 'f';                     

            //ahora el objeto
            unset($_SESSION['oOfendido']);
            unset($oOfendido);                                    
        }else{         
            //usuario presiono boton para cargar otro denunciante
            
            if(isset($_SESSION["oOfendido"])){
                //inicializar el objeto
                $oOfendido= $_SESSION["oOfendido"];    
            }
            
            if (isset($_GET["nmr"])){ 
                $id= $_GET["nmr"]; 
                
                $oOfendido= new Ofendido(); 
                $_SESSION["oOfendido"]= $oOfendido;
                //recuperar el denunciante con ese id para la denuncia actual
                $oOfendido->RecuperarId($_SESSION['denunciaid'], $id);  
            }                        
        }                          
?>

<html>
<head>
	<title>Datos generales</title>
	<meta name="generator" content="Bluefish 2.2.3" >
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link type="text/css" rel="stylesheet" href="../css/Estilos.css">
        <script type="text/javascript" src="../java_script/funciones.js"></script>

	<link href="../java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
	<script src="../java_script/js/jquery-1.10.2.js"></script>
	<script src="../java_script/js/jquery-ui-1.10.4.custom.js"></script>
        
	<!-- declara de acordion para separar persona natural de juridica -->
	<script type="text/javascript">            
	$(document).ready(function() {   
		$("#acordion").accordion({heightStyle: "content", collapsible: true, active: false,
                                            heightStyle: "content"});                  
                                        
                $( "#acordion" ).on( "accordionactivate", function( event, ui ) {
                    indice= ui.newHeader.index();

                    if (indice== 0){
                        participante('listaden2','ofendido');
                    }
                });                                        
	});	
          
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
            var i=  document.getElementById("listaden2").selectedIndex;
            var id= document.getElementById("listaden2").options;
            var personaid= id[i].value;

            location.href='../ofendido/ofendido.php?nmr='+"'"+personaid+"'"; 
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
                if(isset($_SESSION["oOfendido"])){
                    if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't'){
                ?>
                    //llena depto, municipio, aldea, barrio
                    LlenaDireccion("<?php echo($oOfendido->getDepartamentoid());?>",
                                   "<?php echo($oOfendido->getMunicipioid());?>",
                                   "<?php echo($oOfendido->getAldeaId());?>",
                                   "<?php echo($oOfendido->getBarrioId());?>");
                <?php
                    }
                    else{
                ?>
                    LlenaDireccionJ("<?php echo($oOfendido->getDepartamentoid());?>",
                                   "<?php echo($oOfendido->getMunicipioid());?>",
                                   "<?php echo($oOfendido->getAldeaId());?>",
                                   "<?php echo($oOfendido->getBarrioId());?>");  
                <?php
                    }                        
                }
                ?>                           
        }                

        function QuitarAnoRango(){
                $('#rdAno')[0].checked= false;	
                $('#txtEdad').value= "";
                for(i= 0; i <= 4; i++){
                        $('input:radio[name=rdRangoEdad]')[i].checked= false;
                }
        }        
        
        /*funcion: participantes
         *lista los ofendidos ingresados
        */
        function participante(destino, participante){ 
            $.ajax({
                data: "id="+destino+"&participante="+participante,
                type: "POST",
                dataType: "html",
                url: "../funciones/ajax_DenuncianteImputadoOfendido.php",
                error: function(obj, que, otro){
                    alert("Error ajax al cargar lista de participante (denunciante, ofendido, imputado)");
                },
                success: function(data){  
                    $("#listaden").html(data);
                    $("#listaden0").html(data);
                }
            });    
        }     
        
        
        function ActualizarListaDEnunciante(){
            //llenar el combo ofendidos ingresados
            participante('listaden2','ofendido');
        }
              
        
        //activa txt para numero de documento: identidad, pasaporte, carnet de ...
        function ActivarDocumento(){
            $("#txtIdentidad").removeAttr('disabled');

            if ($("#cboTipoDoc").val() == 0){
                $("#txtIdentidad").val("");
                $("#txtIdentidad").attr('disabled','disabled');
            }
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
            alert("Se han guardado los datos del denunciante");
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
        alert("Se han modificado los datos del ofendido");
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
    
    <!-- definicion de acordion para separar persona natural de juridica -->

    <div id="acordion">        
    
    <h3><a href="#">Persona Natural</a></h3>

    <div> <!--inicia acordion persona natural-->       
            <form action="procesaofendido.php" method="POST" name="frmOfendido" 
            id="frmOfendido" onsubmit="return ValidarOfendido(this);">
                
            <input type="hidden" name="txtDireccion2" id="txtDireccion2">
            <input type="hidden" name="txtPersonaId" id="txtPersonaId"
                value="<?php if (isset($_SESSION['oOfendido']))
                    { echo($oOfendido->getPersonaId()); } ?>"/>
                
            <table align="center" summary="botones persona natural">
                <tr>
                <td><INPUT type="submit" name="btnSubmit" value="Guardar datos"></td>
                <td><INPUT type="button" name="btnAgregar" value="Agregar nuevo"
                           onClick="window.location='ofendido.php?btn=nuevo'"></td>
                <td><INPUT type="button" name="btnBorrar" value="Borrar actual" 
                   onClick="BorrarRegistro(document.getElementById('txtPersonaId').value);">              
                </tr>
            </table>             
            
            <br>
            <table id="tblOfendido2" align="center" border="0" 
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
                               onClick="ValidarConocido('ano');"/>Anónimo<br>

                        <input type="radio" name="rdConocido" id="rdConocido" value="1" checked
                               onClick="ValidarConocido('con');"/>Conocido<br>

                        <input type="radio" name="rdConocido" id="rdConocido" value="2"
                               onClick="ValidarConocido('fe');"/>Fé Pública<br>

                        <input type="radio" name="rdConocido" id="rdConocido" value="3"
                               onClick="ValidarConocido('tpr');"/>Testigo Protegido<br>
                    </td>

                    <td>
                        <input type="radio" name="rdSexo" id="rdSexo0" value="m" onClick="llenarsexo('selSexo1','m', forms.frmOfendido);"/>Masculino<br>
                        <input type="radio" name="rdSexo" id="rdSexo1" value="f" onClick="llenarsexo('selSexo1','f', forms.frmOfendido);"/>Femenino<br>    
                        <input type="radio" name="rdSexo" id="rdSexo2" value="x" onClick="llenarsexo('selSexo1','x', forms.frmOfendido);"/>No consignado<br>
                    </td>

                    <td>
                        Orientación sexual<br>
                        <span id="sexo"></span>
                        <script type="text/javascript">                
                            llenarsexo('selSexo1','y', forms.frmOfendido);     
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

            <!--radios para el sexo-->
            <?php if (isset($_SESSION['oOfendido'])) {
                if ($oOfendido->getGenero()== 'm')
                {
            ?>
                <script type="text/javascript">
                    $('input:radio[name=rdSexo]')[0].checked= true; 
                </script>
            <?php 
                }
                elseif($oOfendido->getGenero()== 'f')
                {
            ?>          
                <script type="text/javascript">
                    $('input:radio[name=rdSexo]')[1].checked= true;
                </script>
            <?php
                }
                elseif($oOfendido->getGenero()== 'x')
                {
            ?>        
                <script type="text/javascript">
                    $('input:radio[name=rdSexo]')[2].checked= true;
                </script>                 
            <?php
                }
            ?>
            <?php
            }
            ?>

            <!-- apoderado legal -->
            <br>
            <div id="ApoderadoDid">
                <table id="tblApoderado" align="center" width="100%" border="0" 
                       class="TablaCaja" summary="apoderado legal">
                    <tr class="SubTituloCentro"><th colspan="4">Apoderado Legal</th></tr>
                    <tr class=" Grid">
                        <td align="right">Nombre completo</td>
                        <td>            
                            <input name="txtApoderado" type="text" id="txtApoderado" size="25" maxlength="24"
                                   value="<?php if (isset($_SESSION['oOfendido']))
                                   { if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') echo($oOfendido->getApoderadoNombre()); } ?>"/> 
                        </td>
                        <td align="right">Número Colegio</td>
                        <td>            
                            <input name="txtColegio" type="text" id="txtColegio" size="25" maxlength="5"
                                   value="<?php if (isset($_SESSION['oOfendido']))
                                   { if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') echo($oOfendido->getApoderadoColegio()); } ?>"/> 
                        </td>            
                    </tr>
                </table> 
                <br>
            </div>

            <!-- nombre asumido -->
            <br>
            <div id="NombreAsumidoId">
                <table id="tblNombreAsum" align="center" width="100%" border="0" 
                       class="TablaCaja" summary="nombreasumido legal">
                    <tr class="SubTituloCentro"><th colspan="4">Nombre asumido</th></tr>
                    <tr class=" Grid">
                        <td align="right">Nombre asumido</td>
                        <td>            
                            <input name="txtNombreAsum" type="text" id="txtNombreAsum" size="25" maxlength="24"
                                   value="<?php if (isset($_SESSION['oOfendido']))
                                   { if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') echo($oOfendido->getNombreAsumido()); } ?>"/> 
                        </td>          
                    </tr>
                </table> 
                <br>
            </div>  
            
            <!-- para mostrar la tabla de apoderado legal -->
            <script type="text/javascript">
                Apoderado();
            </script>

            <!-- para mostrar la tabla de apoderado legal -->
            <script type="text/javascript">
                NombreAsumido();
            </script>                
            
            <!lista de ofendido ingresados >
            <table id="tblListaOfendido" align="center" width="100%" border="0" 
                   class="TablaCaja" summary="lista de denunciante">
                <tr class="SubTituloCentro"><TH colspan="4">Lista de ofendidos ingresados</TH></tr>
                <tr>
                <td><span id="listaden"></span></td>
                </tr>
            </table>   
            
            <!--los botones para guardar-->             
            <script type="text/javascript">
                participante('listaden2','ofendido');
            </script>
            <br><br>
            
            <table id="tblOfendido2" align="center" border="0" width="100%"
                       class="TablaCaja" summary="persona natural">     
            <tr class="SubTituloCentro"><TH colspan="4">Datos Generales</TH></tr>
            <tr class="Grid">
            <td align="right">Nombres</td>
            <td>
                <input name="txtNombres" type="text" id="txtNombres" size="25" maxlength="25"
                    value="<?php if (isset($_SESSION['oOfendido']))
                    { if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') 
                            echo($oOfendido->getNombreCompleto()); } ?>"/>                         

            </td>            
            <td align="right">Apellidos</td>
            <td>            
                <input name="txtApellidos" type="text" id="txtApellidos" size="25" maxlength="25"
                    value="<?php if (isset($_SESSION['oOfendido']))
                    { if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') 
                        echo($oOfendido->getApellidoCompleto()); } ?>"/>

            </tr>
            <!-- -->        
            <tr class="Grid">
            <td align="right">Nacionalidad</td>
            <td>
                <?php
                $resNacion= CargarNacionalidad();
                combo("cboNacionalidad",$resNacion,"cnacionalidadid","cdescripcion");
                ?>
                <script type="text/javascript">
                    document.getElementById('cboNacionalidad').value= 
                    "<?php if (isset($_SESSION['oOfendido'])) 
                        {
                            if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't')
                                echo $oOfendido->getNacionalidad();
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
                    $("#cboCivil").val("<?php if (isset($_SESSION['oOfendido']))
                    { if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') echo($oOfendido->getEstadoCivil()); }
                    else { echo(0); } ?>");                           
                </script>              
            </td>
            </tr>
            <!-- -->
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
                            "<?php if (isset($_SESSION['oOfendido']))
                            { if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') 
                                echo($oOfendido->getTipoDocumento()); }?>";
                                    
                </script>  
                <input name="txtIdentidad" type="text" id="txtIdentidad" size="15" maxlength="19" disabled
                    value="<?php if (isset($_SESSION['oOfendido']))
                    { if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') echo($oOfendido->getIdentidad()); }?>"/>                

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
                    $("#cboEscolar").attr("value","<?php if (isset($_SESSION['oOfendido']))
                    { if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') echo($oOfendido->getEscolaridad()); }?>"/>
                </script>            
            </td>
            </tr>            
            <!-- -->
            <tr class="Grid">
                <td align="right">Profesion/oficio</td>
                <td>
                    <?php
                        $resProfe= CargarProfesion();
                        combo("cboProfe",$resProfe,"nprofesionid","cdescripcion");
                    ?>
                    <script type="text/javascript">
                        $("#cboProfe").attr("value","<?php if (isset($_SESSION['oOfendido']))
                        { if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') echo($oOfendido->getProfesion()); }?>"/>
                    </script>              
                </td>
                <td align="right">Ocupación</td>
                <td>	
                    <?php
                        $resOcupa= CargarOcupacion();
                        combo("cboOcupa",$resOcupa,"nocupacionid","cdescripcion");
                    ?>
                    <script type="text/javascript">
                        $("#cboOcupa").attr("value","<?php if (isset($_SESSION['oOfendido']))
                        { if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') echo($oOfendido->getOcupacion()); }?>"/>
                    </script>               
                </td>
            </tr>  
            <!-- -->
            <tr class="Grid">
            <td align="right">Edad</td>
            <td> 
                <!--<input type="txtEdad2" onkeypress="return ValidarNumeros(event)">-->
<!--                OJO no se debe modificar el nombre y id de este campo pq lo usa la
                funcion javascript llenarsexo, que se dispara de los radios sexo-->
                <input name="txtEdad" type="text" id="txtEdad" size="5" maxlength="3"
                    onkeypress="return ValidarNumeros(event);" disabled="disabled"
                    onfocus="QuitarAnoRango()"
                    value="<?php if (isset($_SESSION['oOfendido']))
                        { if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') echo($oOfendido->getEdad()); } else { echo "0";} ?>"/>   

                <!-- ojo valores en value con/des afectan "procesaofendido.php"-->
                <input type="radio" name="rdAno" id="rdAno0" value="con" 
                    onclick="ValidarEdadrb(this);"/>Años
                <input type="radio" name="rdAno" id="rdAno2" value="mes" 
                    onclick="ValidarEdadrb(this);"/>Meses  
                <input type="radio" name="rdAno" id="rdAno3" value="dia" 
                    onclick="ValidarEdadrb(this);"/>Días                  
                <input type="radio" name="rdAno" id="rdAno1" value="des" checked
                    onclick="ValidarEdadrb(this);"/>Desconocida

                <?php if (isset($_SESSION['oOfendido']))
                    if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't')
                    { 
                        if ($oOfendido->getUmeDidaEdad()== 'a')
                        {
                ?>
                            <script type="text/javascript">
                                $('input:radio[name=rdAno]')[0].checked= true;
                            </script>                            
                <?php
                        }
                        if ($oOfendido->getUmeDidaEdad()== 'm')
                        {
                ?>
                            <script type="text/javascript">
                                $('input:radio[name=rdAno]')[1].checked= true;
                            </script>  
                <?php
                        }
                        if ($oOfendido->getUmeDidaEdad()== 'd')
                        {
                ?>    
                            <script type="text/javascript">
                                $('input:radio[name=rdAno]')[2].checked= true;
                            </script>    
                <?php
                        }
                        if ($oOfendido->getUmeDidaEdad()== 'x')
                        {
                ?>    
                            <script type="text/javascript">
                                $('input:radio[name=rdAno]')[3].checked= true;
                            </script>                              
                <?php
                        }
                    }
                ?>
                </td>
                
                <td colspan="2"> 
                    <!-- ojo los cambios en value, se deben confirmar en pro esaofendido.php -->
                    <input type="radio" name="rdRangoEdad" id="rdRangoEdad0" value="infante" 
                        onclick="ValidarRangoEdadOfendido(forms.frmOfendido);"/>Infante

                    <input type="radio" name="rdRangoEdad" id="rdRangoEdad1" value="adelescente" 
                        onclick="ValidarRangoEdadOfendido(forms.frmOfendido);"/>Adolescente

                    <input type="radio" name="rdRangoEdad" id="rdRangoEdad2" value="menoradulto" 
                        onclick="ValidarRangoEdadOfendido(forms.frmOfendido);"/>Menor adulto

                    <input type="radio" name="rdRangoEdad" id="rdRangoEdad3" value="adulto" 
                        onclick="ValidarRangoEdadOfendido(forms.frmOfendido);"/>Adulto

                    <input type="radio" name="rdRangoEdad" id="rdRangoEdad4" value="adultomayor" 
                        onclick="ValidarRangoEdadOfendido(forms.frmOfendido);"/>Adulto mayor  
                    
                    <input type="radio" name="rdRangoEdad" id="rdRangoEdad5" value="noconsignado"
                        onclick="ValidarRangoEdadOfendido(forms.frmOfendido);"/>No consignado    

                    <?php if (isset($_SESSION['oOfendido']))
                        if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't')
                        { 
                            if ($oOfendido->getRangoEdad()== 'ni')
                            {
                    ?>
                                <script type="text/javascript">
                                    $('input:radio[name=rdRangoEdad]')[0].checked= true;
                                </script>  
                    <?php
                            }
                            elseif ($oOfendido->getRangoEdad()== 'na')
                            {
                    ?>
                                <script type="text/javascript">
                                    $('input:radio[name=rdRangoEdad]')[1].checked= true;
                                </script>        
                    <?php
                            }
                            elseif ($oOfendido->getRangoEdad()== 'nm')
                            {
                    ?>
                                <script type="text/javascript">
                                    $('input:radio[name=rdRangoEdad]')[2].checked= true;
                                </script> 
                    <?php
                            }
                            elseif ($oOfendido->getRangoEdad()== 'a')
                            {
                    ?>
                                <script type="text/javascript">
                                    $('input:radio[name=rdRangoEdad]')[3].checked= true;
                                </script> 
                    <?php
                            }
                            elseif ($oOfendido->getRangoEdad()== 'am')
                            {
                    ?>
                                <script type="text/javascript">
                                    $('input:radio[name=rdRangoEdad]')[4].checked= true;
                                </script>                                     
                    <?php
                            }
                            elseif ($oOfendido->getRangoEdad()== 'x')
                            {
                    ?>    
                                <script type="text/javascript">
                                    $('input:radio[name=rdRangoEdad]')[5].checked= true;
                                </script> 
                    <?php
                            }
                        }
                    ?>
                </td>                
                </tr>
            </table>
            <!-- -->
            <br><br>
            
            <table id="tblOfendido3" align="center" border="0" width="100%"
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
                <!-- -->
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
                <td colspan="4">
                    <input name="txtDireccion" type="text" id="txtDireccion" size="80" maxlength="199"
                        value="<?php if (isset($_SESSION['oOfendido']))
                            if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't')
                            { echo($oOfendido->getDetalle()); } ?>"/>   
                </td>
                </tr>
                <tr class="Grid">
                <td align="right">Teléfonos</td>
                <td colspan="3">
            <input name="txtTelefono" type="text" id="txtTelefono" size="50" maxlength="49"
                   value="<?php if (isset($_SESSION['oOfendido']))
                   if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't')
                   { echo($oOfendido->getTelefono()); } ?>"/>
                </td>            
                </tr>                
            </table>
                <!-- -->                        
            <br><br>
            
            <table id="tblOfendido4" align="center" width="100%" border="0" 
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
                            $("#cboEtnia").attr("value","<?php if (isset($_SESSION['oOfendido']))
                                if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't')
                                { echo($oOfendido->getGrupoEtnico()); } ?>");
                        </script>                
                </td>
                <td align="right">Discapacidad</td>
                <td>	<?php
                            $resDisca= CargarDiscapacidad();
                            combo("cboDiscapacidad",$resDisca,"ndiscapacidadid",
                                    "cdescripcion","Seleccione una discapacidad");
                            ?>
                        <script type="text/javascript">
                            $("#cboDiscapacidad").attr("value","<?php if (isset($_SESSION['oOfendido']))
                                if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't')
                                { echo($oOfendido->getDiscapacidad()); } ?>");
                        </script>                
                </td>
                </tr>                
            </table>
                
    <br><br>
    <!lista de ofendido ingresados >
    <table id="tblListaOfendido" align="center" width="100%" border="0" 
           class="TablaCaja" summary="lista de denunciante">
        <tr class="SubTituloCentro"><TH colspan="4">Lista de ofendidos ingresados</TH></tr>
        <tr>
        <td><span id="listaden"></span></td>
        </tr>
    </table>
                
            <!--los botones para guardar-->
            <br>
            <table align="center" summary="botones persona natural">
                <tr>
                <td><INPUT type="submit" name="btnSubmit" value="Guardar datos"></td>
                <td><INPUT type="button" name="btnAgregar" value="Agregar nuevo"
                           onClick="window.location='ofendido.php?btn=nuevo'"></td>
                <td><INPUT type="button" name="btnBorrar" value="Borrar actual" 
                   onClick="BorrarRegistro(document.getElementById('txtPersonaId').value);">              
                </tr>
            </table>  
            <script type="text/javascript">
                participante('listaden2','ofendido');
            </script>
        </form>
       
        
    </div><!--fin acordion persona natural-->
    <h3><a href="#">Persona Juridica</a></h3>
    <div>
<form action="procesaofendido.php" method="POST"
        id="frmDenuncianteJuridico" onsubmit="return ValidarDenuncianteJuridico(this);">  
    <input type="hidden" id='OfendidoJur' name='OfendidoJur'>
    <input type="hidden" name="txtPersonaId" id="txtPersonaId"
                   value="<?php if (isset($_SESSION['oOfendido']))
                       { if ($oOfendido->getPersonaNatural()== '0' || $oOfendido->getPersonaNatural()== 'f') echo($oOfendido->getPersonaId());} ?>"/>
    
    <table id="tblPersonaJuridica" align="center" width="95%" border= "0"
           class="TablaCaja" summary="datos persona natural">
        
    <tr class="SubTituloCentro"><th colspan="4">Datos generales de la empresa</th></tr>
       
        <td align="right">Nombre de empresa o institución</td>
        
        <td><input list="txtEmpresasHn" name="txtEmpresasHn" size="30" maxlength="99" 
                   onblur="document.getElementById('OfendidoJur').value= 'juridico';"
                   value="<?php if (isset($_SESSION['oOfendido']))
                        { if ($oOfendido->getPersonaNatural()== '0' || $oOfendido->getPersonaNatural()== 'f') echo($oOfendido->getNombreCompleto());  } ?>"/>
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
                   value="<?php if (isset($_SESSION['oOfendido']))
                        { if ($oOfendido->getPersonaNatural()== '0' || $oOfendido->getPersonaNatural()== 'f') echo($oOfendido->getIdentidad());  } ?>">
        </td> 
    <tr>
        <td align="right">Nacionalidad</td>
        <td>
            <?php
            $resNacionJ= CargarNacionalidad();
            combo("cboNacionalidadJ",$resNacionJ,"cnacionalidadid","cdescripcion");
            ?>
            <script type="text/javascript">
                $("#cboNacionalidadJ").attr("value","<?php if (isset($_SESSION['oOfendido']))
                       { if ($oOfendido->getPersonaNatural()== '0' || $oOfendido->getPersonaNatural()== 'f') echo($oOfendido->getNacionalidad()); } else { echo('HN'); } ?>");
            </script>         
        </td>        
        <td align="right">Teléfonos</td>
        <td>
            <input type="text" id="txtTelefono" name="txtTelefono" size="15" maxlength="59"
                   value="<?php if (isset($_SESSION['oOfendido']))
                       { if ($oOfendido->getPersonaNatural()== '0' || $oOfendido->getPersonaNatural()== 'f') echo($oOfendido->getTelefono()); } ?>">
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
            <input list="txtDireccionJuridica" name="txtDireccionJuridica" size="100" maxlength="199" required
                   value="<?php if (isset($_SESSION['oOfendido']))
                       { if ($oOfendido->getPersonaNatural()== '0' || $oOfendido->getPersonaNatural()== 'f') echo($oOfendido->getTxtDireccion());} ?>">
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
                           value="<?php if (isset($_SESSION['oOfendido']))
                           { if ($oOfendido->getPersonaNatural()== '0' || $oOfendido->getPersonaNatural()== 'f') echo($oOfendido->getApoderadoNombre()); } ?>"/> 
                </td>
                <td align="right">Identificación</td>
                <td>            
                    <input name="txtColegioJ" type="text" id="txtColegioJ" size="15" maxlength="20"
                           value="<?php if (isset($_SESSION['oOfendido']))
                           { if ($oOfendido->getPersonaNatural()== '0' || $oOfendido->getPersonaNatural()== 'f') 
                               if ($oOfendido->getTipoDocumento() != 5)
                                   echo($oOfendido->getIdentidad());
                               else
                                   echo($oOfendido->getApoderadoColegio());                                
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
    </div>
    </div>
</body>
</html>

<script type="text/javascript">    
    function LlenaDireccion(Departamentoid, Municipioid, AldeaId, BarrioId){
//        alert(Departamentoid+" "+Municipioid+" "+AldeaId+" "+BarrioId);
        $.ajax({
            data:"accion=depto",
            type: "POST",
            dataType: "html",
            url: "../funciones/ajax_llenadireccion.php",
            error: function(objeto, quepaso, otroobj){
                alert("Error al cargar Departamento: "+quepaso);
            },
            success: function(data){
                $("#cboDepto").html(data); //crea la lista de deptos
                $("#cboDepto option[value="+Departamentoid+"]").attr("selected",true);
//                $("#cboDepto").attr("value",Departamentoid); //selecciona el depto
                //ajax para llenar el municipio
                $.ajax({
                    data: "accion=muni&coddepto="+Departamentoid,
                    type: "POST",
                    dataType: "html",
                    url: "../funciones/ajax_llenadireccion.php",
                    error: function(objeto, quepaso, otroobj){
                        alert("Error al cargar Municipio: "+quepaso);
                    },
                    success: function(data){
                        $("#cboMuni").html(data);
                        $("#cboMuni option[value="+Municipioid+"]").attr("selected",true);
//                        $("#cboMuni").attr("value",Municipioid);
                        //ajax para llenar la ciudad o aldea
                        $.ajax({                        
                            data: "accion=aldea&codmuni="+Municipioid+"&coddepto="+Departamentoid+"&codaldea="+AldeaId,
                            type: "POST",
                            dataType: "html",
                            url: "../funciones/ajax_llenadireccion.php",
                            error: function(objeto, quepaso, otroobj){
                                alert("Error al cargar Aldea o Ciudad: "+quepaso);
                            },
                            success: function(data){
                                $("#cboAldea").html(data);
                                $("#cboAldea option[value="+AldeaId+"]").attr("selected",true);
//                                $("#cboAldea").attr("value",AldeaId);
                            }
                        })
                    }
                })
            }
        })    
        $.ajax({
            data: "accion=barrio&codmuni="+Municipioid+"&coddepto="+Departamentoid+"&codaldea="+AldeaId+"&codbarrio="+BarrioId,
            type: "POST",
            dataType: "html",
            url: "../funciones/ajax_llenadireccion.php",
            error: function(objeto, quepaso, otroobj){
                alert("Error al cargar Barrio o Colonia");        
            },
            success: function(data){
                $("#cboBarrio").html(data);
                $("#cboBarrio option[value="+BarrioId+"]").attr("selected",true);
//                $("#cboBarrio").attr("value",BarrioId);            
            }
        })        
    }
</script> 


<script type="text/javascript">          
    //llenar el combo ofendidos ingresados
//    participante('listaden2','ofendido');

    
    //saber cual radio sexo esta seleccionado: masculino, femenino
    Sexo= $('input[name=rdSexo]:checked', '#frmOfendido').val();    
 
     //llenar la lista de preferencia sexual     
    <?php if (isset($_SESSION['oOfendido'])){ ?>  
        Orientacion= "<?php echo($oOfendido->getOrientacionSex());?>";
    <?php 
    }
    ?>
        
    llenarsexo('selSexo2',Sexo,frmOfendido,Orientacion);       

    
    <!--validar la identificador: ofendido, conocido, anonimo, fe publica, testigo prot-->
    <?php if (isset($_SESSION['oOfendido'])) {
        //anonimo
        if ($oOfendido->getConocido()== 0) 
        {
    ?>
            $('input:radio[name=rdConocido]')[0].checked= true;            
            ValidarConocido('ano');
    <?php 
        }
        //conocido
        elseif($oOfendido->getConocido()== 1)
        {
    ?>
            $('input:radio[name=rdConocido]')[1].checked= true; 
    <?php 
        }
        //fe publica
        elseif($oOfendido->getConocido()== 2)
        {
    ?>
            $('input:radio[name=rdConocido]')[2].checked= true; 
            ValidarConocido('fe'); 
    <?php                
        }
        //testigo potegido
        elseif($oOfendido->getConocido()== 3)
        {
    ?>
            $('input:radio[name=rdConocido]')[3].checked= true;            
            ValidarConocido('tpr');
    <?php
        }
    }
    ?>
                       

    /*funcion: borrar un registro
    * 
     */
     function BorrarRegistro(){
        var rsp= confirm("Presione Aceptar para Borrar los datos que está viendo en pantalla.\n"+
                        "<?php echo $oOfendido->getNombreCompleto(); ?>"+" "+
                        "<?php echo $oOfendido->getApellidoCompleto(); ?>");
        if (rsp== true) 
            window.location="../administracion/BorrarRegistros.php?reg=ofendido&id=<?php echo $oOfendido->getPersonaId(); ?>";
     }
</script>  