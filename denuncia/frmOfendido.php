<?php
    include("../clases/controles/funct_select.php");

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
        if (isset($_GET["btn"]) && $_GET["btn"]== "nuevo"){                               
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
        <script type="text/javascript" src="../funciones/funciones.js"></script>          

	<link href="../java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
	<script src="../java_script/js/jquery-1.10.2.js"></script>
	<script src="../java_script/js/jquery-ui-1.10.4.custom.js"></script>
        
	<!-- declara de acordion para separar persona natural de juridica -->
	<script type="text/javascript">            
	$(document).ready(function() {   
		$("#acordionOfendidox").accordion({heightStyle: "content", collapsible: true, active: false,
                                            heightStyle: "content"});                  
                                        
                $( "#acordionOfendido" ).on( "accordionactivate", function( event, ui ) {
                    indice= ui.newHeader.index();

                    if (indice== 0){
                        participante('lstOfendido2','ofendido');
                    }
                });                                        
	});	
          
        function Apoderado(){ 
            div = document.getElementById('ApoderadoDid2');
            visible= document.getElementById('apoderado').checked;

            if (!visible){ 
                div.style.display = 'none';
            }
            else{
                div.style.display = '';
            }   
        } 
        
        function NombreAsumido(){ 
            div = document.getElementById('NombreAsumidoId2');
            visible= document.getElementById('NombAsumido').checked;

            if (!visible){
                div.style.display = 'none';
            }
            else{
                div.style.display = '';
            }    
        }         


	function Recargar() {         
            var i=  document.getElementById("lstOfendido2").selectedIndex;
            var id= document.getElementById("lstOfendido2").options;
            var personaid= id[i].value;

            location.href= "frmExpediente.php?nmr="+"'"+personaid+"'&tab=3";
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

        function QuitarAnoRango(){
                $('#rdAno4')[0].checked= false;	
                $('#txtEdad').value= "";
                for(i= 0; i <= 4; i++){
                        $('input:radio[name=rdRangoEdad4]')[i].checked= false;
                }
        }        
        
        /*funcion: participantes
         *lista los ofendidos ingresados
        */
        function participante(destino, participante){ 
//            alert(destino+' '+participante);
            $.ajax({
                data: "id="+destino+"&participante="+participante,
                type: "POST",
                dataType: "html",
                url: "../funciones/ajax_DenuncianteImputadoOfendido.php",
                error: function(obj, que, otro){
                    alert("Error ajax al cargar lista de participante (denunciante, ofendido, imputado)");
                },
                success: function(data){ 
                    $("#lstOfendido").html(data);
                }
            });    
        }     
        
        
        function ActualizarListaDEnunciante(){
            //llenar el combo ofendidos ingresados
            participante('lstOfendido2','ofendido');
        }
              
        
        //activa txt para numero de documento: identidad, pasaporte, carnet de ...
        function ActivarDocumento(){ 
            $("#txtIdentidad4").removeAttr('disabled');

            if ($("#cboTipoDoc4").val() == 0){ 
                $("#txtIdentidad4").val("");
                $("#txtIdentidad4").attr('disabled','disabled');
            } 
        }      
        
        function ActualizarListaDEnunciante(){
            //llenar el combo ofendidos ingresados
            participante('lstOfendido2','ofendido');
        }   
        
        function CrearNuevo(Tipo){
            if (Tipo == "Natural")
                location.href= "frmExpediente.php?nuevo=31";
            else
                location.href= "frmExpediente.php?nuevo=32";            
        }                

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
                    $("#cboDepto4").html(data); //crea la lista de deptos
                    $("#cboDepto4 option[value="+Departamentoid+"]").attr("selected",true);
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
                            $("#cboMuni4").html(data);
                            $("#cboMuni4 option[value="+Municipioid+"]").attr("selected",true);
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
                                    $("#cboAldea4").html(data);
                                    $("#cboAldea4 option[value="+AldeaId+"]").attr("selected",true);
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
                    $("#cboBarrio4").html(data);
                    $("#cboBarrio4 option[value="+BarrioId+"]").attr("selected",true);
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
                url: "../funciones/ajax_llenadireccion.php",
                error: function(objeto, quepaso, otroobj){
                    alert("Error al cargar Departamento: "+quepaso);
                },
                success: function(data){
                    $("#cboDepto4J").html(data); //crea la lista de deptos
                    $("#cboDepto4J option[value="+Departamentoid+"]").attr("selected",true);
//                    $("#cboDeptoJ").attr("value",Departamentoid); //selecciona el depto
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
                            $("#cboMuni4J").html(data);
                            $("#cboMuni4J option[value="+Municipioid+"]").attr("selected",true);
//                            $("#cboMuniJ").attr("value",Municipioid);
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
                                    $("#cboAldea4J").html(data);
                                    $("#cboAldea4J option[value="+AldeaId+"]").attr("selected",true);
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
                url: "../funciones/ajax_llenadireccion.php",
                error: function(objeto, quepaso, otroobj){
                    alert("Error al cargar Barrio o Colonia");        
                },
                success: function(data){
                    $("#cboBarrio4J").html(data);
                    $("#cboBarrio4J option[value="+BarrioId+"]").attr("selected",true);
//                    $("#cboBarrioJ").attr("value",BarrioId);            
                }
            });
        }               
        
        function LlenarCampos(frm, datos){ 
            frm.cboCivil4.value= datos.civil; 
            frm.cboTipoDoc4.value= datos.tipodoc;          
            frm.cboEscolar4.value= datos.escolaridad; 
            frm.cboProfe4.value= datos.profesion;            
            frm.cboOcupa4.value= datos.ocupacion;
            frm.cboNacionalidad4.value= datos.nacionalidad;
            
            LlenaDireccion(datos.departamento, datos.municipio, datos.ciudad, datos.barrio);
            LlenaDireccionJ(datos.departamento, datos.municipio, datos.ciudad, datos.barrio);
            
            var frm= document.forms.frmOfendido;
            llenarsexo('selSexo4',datos.sexo, frm, datos.orientacionsex);  
      
            if (TipoPersona== 'f') //persona juridica
            {
                if (datos.tipodoc == 0)//identidad
                {
                    document.getElementById('rdTipoDoc1').checked= true;
                }
                else if(datos.tipodoc == 2)//pasaporte
                {
                   document.getElementById('rdTipoDoc2').checked= true;
                }
                else if(datos.tipodoc == 5)//colegio abogado
                {
                   document.getElementById('rdTipoDoc0').checked= true;
                }
            }
        } 
        
        function BorrarRegistro(personaid){
            $.ajax({
                data: "borrar=ofendido&id="+personaid,
                type: "POST",
                dataType: "html",
                url: "../funciones/ajax_BorrarDenuncianteImputadoOfendido.php",
                error: function(objeto, quepaso, otroobj){
                    alert("Error al borrar denunciante");        
                },
                success: function(data){
                    Recargar();
                }
            });
        }        
</script>                                 
</head>
<body>
<a name="inicio"></a>  

    <!-- definicion de acordion para separar persona natural de juridica -->

    <div id="acordionOfendido">        
    <div id="BotonesEscabezado" style="background-image: url('../css/smoothness/images/ui-bg_glass_75_e6e6e6_1x400.png')">
        <!--los botones generales persona natural y juridica-->    
        <table align="center" summary="botones persona natural">
            <tr>
                <td><b>Denunciantes ingresados</b></td>
                <td></td>
                <td colspan="2"><b>Agregar un nuevo denunciante</b></td>
            </tr>
            <tr>     
            <td>
                <span id="lstOfendido"></span>
                <script type="text/javascript">
                    participante('lstOfendido2','ofendido');
                </script>    
            </td>
            <td><pre>                                       </pre></td>
            <td><INPUT type="button" name="btnNuevo" value="Persona Natural" 
                       onClick="CrearNuevo('Natural');"></td> 
            <td><INPUT type="button" name="btnNuevo" value="Persona Juridica" 
                       onClick="CrearNuevo('Juridica');"></td>         
            <td></td>      
            </tr>
        </table>      
    </div>
    
    <div>            

    <div style="display:none;" id="PersonaNaturalDiv3">        
            <h3><a href="#">Persona Natural</a></h3>
    <!--inicia acordion persona natural-->       
            <form action="procesaofendido.php" method="POST" name="frmOfendido" 
            id="frmOfendido" onsubmit="return ValidarOfendido(this);">
                
            <input type="hidden" name="txtDireccion2" id="txtDireccion2">
            <input type="hidden" name="txtPersonaId" id="txtPersonaId"
                value="<?php if (isset($_SESSION['oOfendido']))
                    { echo($oOfendido->getPersonaId()); } ?>"/>
                
            <table align="center" summary="botones persona natural">
                <tr>
                <td><INPUT type="submit" name="btnSubmit" value="Guardar datos"></td>
                <td><pre>    </pre></td>
                <td><INPUT type="button" name="btnBorrar" value="Borrar actual" 
                   onClick="BorrarRegistro(document.getElementById('txtPersonaId').value);">              
                </tr>
            </table>             
            
            <br>
            <table id="tblOfendido2" align="center" border="0" 
                   class="TablaCaja" summary="persona natural">
                <tr class="SubTituloCentro">
                    <th align="center" style="width:20%">Identificación</th>
                    <th align="center" style="width:20%">Genero</th>
                    <th align="center" style="width:25%">Comunidad LGBTI</th>
                    <th align="center" style="width:18%">Apoderado legal</th>
                </tr>
                <tr>
                    <td>
                        <input type="radio" name="rdConocido" id="rdConocido" value="0" 
                               onClick="ValidarConocido('ano', document.forms.frmOfendido);"/>Anónimo<br>

                        <input type="radio" name="rdConocido" id="rdConocido" value="1" checked
                               onClick="ValidarConocido('con', document.forms.frmOfendido);"/>Conocido<br>

                        <input type="radio" name="rdConocido" id="rdConocido" value="2"
                               onClick="ValidarConocido('fe', document.forms.frmOfendido);"/>Fé Pública<br>

                        <input type="radio" name="rdConocido" id="rdConocido" value="3"
                               onClick="ValidarConocido('tpr', document.forms.frmOfendido);"/>Testigo Protegido<br>
                    </td>

                    <td>
<!--                        <input type="radio" name="rdSexo4" id="rdSexo0" value="m" onClick="llenarsexo('selSexo4','m', forms.frmOfendido);"/>Masculino<br>
                        <input type="radio" name="rdSexo4" id="rdSexo1" value="f" onClick="llenarsexo('selSexo4','f', forms.frmOfendido);"/>Femenino<br>    
                        <input type="radio" name="rdSexo4" id="rdSexo2" value="x" onClick="llenarsexo('selSexo4','x', forms.frmOfendido);"/>No consignado<br>-->
                        <input type="radio" name="rdSexo4" id="rdSexo0" value="m" onclick="txtEdad.disabled= false;"/>Masculino<br>
                        <input type="radio" name="rdSexo4" id="rdSexo1" value="f" onclick="txtEdad.disabled= false;"/>Femenino<br>    
                        <input type="radio" name="rdSexo4" id="rdSexo2" value="x" onclick="txtEdad.disabled= false;"/>No consignado<br>                        
                    </td>

                    <td>
<!--                        Orientación sexual<br>
                        <select name="selSexo4" id="selSexo4"></select>
                        <span id="selSexo4"></span>
                        <script type="text/javascript"> 
//                            var frm= document.forms.frmOfendido;
//                            llenarsexo('selSexo1','y', frm.name);     
                        </script>  
                        <br>   -->
                        <input type="checkbox" name="AplicaLGBTI" id="AplicaLGBTI" value="0"/>Integra comunidad
                        <br><br>                                        
                        <input type="checkbox" name="NombAsumido" id="NombAsumido" value="0" onclick="NombreAsumido();"/>Nombre asumido
                    </td>                        
                    <td>
                        <input type="checkbox" name="apoderado" id="apoderado" value="0" onclick="Apoderado();"/>Apoderado Legal     
                    </td>                        
                </tr> 
            </table>                                  

    <!--Orientacion sexual-->
    <script type="text/javascript">         
        var frm= document.forms.frmOfendido;
//        llenarsexo('selSexo4','f', frm);
    </script>

    <?php if (isset($_SESSION['oOfendido'])) { 
        if ($oOfendido->getGenero()== 'm')
        {
    ?>
        <script type="text/javascript"> 
            $('input:radio[name=rdSexo4]')[0].checked= true;  
        </script>
    <?php 
        }
        elseif($oOfendido->getGenero()== 'f')
        {
    ?>          
        <script type="text/javascript">
            $('input:radio[name=rdSexo4]')[1].checked= true; 
        </script>
    <?php 
        }
        elseif($oOfendido->getGenero()== 'x') 
        {
    ?>          
        <script type="text/javascript">
            $('input:radio[name=rdSexo4]')[2].checked= true; 
        </script>                
    <?php
        }
    }
    ?>             
    <br>                
            <!-- apoderado legal -->
            <div id="ApoderadoDid2">
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
            <div id="NombreAsumidoId2">
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
            </div>  
            <!-- para mostrar la tabla de apoderado legal -->
            <script type="text/javascript"> Apoderado(); </script>
            
            <!-- para mostrar la tabla de apoderado legal -->
            <script type="text/javascript"> NombreAsumido(); </script>                          
          
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
                $resNacion4= CargarNacionalidad();
                combo("cboNacionalidad4",$resNacion4,"cnacionalidadid","cdescripcion");
                ?>                          
            </td>
            <td align="right">Estado civil</td>
            <td>	
                <?php
                    $resCivil4= CargarEstadoCivil();
                    combo("cboCivil4",$resCivil4,"ncivil","cdescripcion");
                ?>    
            </td>
            </tr>              
            <!-- -->
            <tr class="Grid">
            <td align="right">Pasaporte/Identidad</td>
            <td>  
                Tipo de documento
                <?php
                    $resTipodoc4= CargarTipoDocumento();
                    combo("cboTipoDoc4",$resTipodoc4,"ndocumentoid","cdescripcion","","onchange='ActivarDocumento()'");
                ?>

                <input name="txtIdentidad4" type="text" id="txtIdentidad4" size="15" maxlength="19" disabled
                    value="<?php if (isset($_SESSION['oOfendido']))
                    { if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') 
                        echo($oOfendido->getIdentidad()); }?>"/>                

                <script type="text/javascript">
                    if ($("#cboTipoDoc4").val() != 0){
                        $("#txtIdentidad4").removeAttr('disabled');
                    }   
                    
                if (txtIdentidad4 != null){
                    txtIdentidad4.disabled= false;
                }                     
                </script>
            </td>
            <td align="right">Escolaridad</td>
            <td>
                <?php
                    $resEscolar4= CargarEscolaridad();
                    combo("cboEscolar4",$resEscolar4,"nescolaridadid","cdescripcion");
                ?>    
            </td>
            </tr>  
            
            <!-- -->
            <tr class="Grid">
                <td align="right">Profesion/oficio</td>
                <td>
                    <?php
                        $resProfe4= CargarProfesion();
                        combo("cboProfe4",$resProfe4,"nprofesionid","cdescripcion");
                    ?>
                </td>
                <td align="right">Ocupación</td>
                <td>	
                    <?php
                        $resOcupa4= CargarOcupacion();
                        combo("cboOcupa4",$resOcupa4,"nocupacionid","cdescripcion");
                    ?>
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
                <input type="radio" name="rdAno4" id="rdAno0" value="con" 
                    onclick="ValidarEdadrb(this);"/>Años
                <input type="radio" name="rdAno4" id="rdAno2" value="mes" 
                    onclick="ValidarEdadrb(this);"/>Meses  
                <input type="radio" name="rdAno4" id="rdAno3" value="dia" 
                    onclick="ValidarEdadrb(this);"/>Días                  
                <input type="radio" name="rdAno4" id="rdAno1" value="des" checked
                    onclick="ValidarEdadrb(this);"/>Desconocida

                <?php if (isset($_SESSION['oOfendido']))
                    if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't')
                    { 
                        if ($oOfendido->getUmeDidaEdad()== 'a')
                        {
                ?>
                            <script type="text/javascript">
                                $('input:radio[name=rdAno4]')[0].checked= true;
                            </script>                            
                <?php
                        }
                        if ($oOfendido->getUmeDidaEdad()== 'm')
                        {
                ?>
                            <script type="text/javascript">
                                $('input:radio[name=rdAno4]')[1].checked= true;
                            </script>  
                <?php
                        }
                        if ($oOfendido->getUmeDidaEdad()== 'd')
                        {
                ?>    
                            <script type="text/javascript">
                                $('input:radio[name=rdAno4]')[2].checked= true;
                            </script>    
                <?php
                        }
                        if ($oOfendido->getUmeDidaEdad()== 'x')
                        {
                ?>    
                            <script type="text/javascript">
                                $('input:radio[name=rdAno4]')[3].checked= true;
                            </script>                              
                <?php
                        }
                    }
                ?>
                </td>                
                <td colspan="2"> 
                    <!-- ojo los cambios en value, se deben confirmar en pro esaofendido.php -->
                    <input type="radio" name="rdRangoEdad4" id="rdRangoEdad40" value="infante" 
                        onclick="ValidarRangoEdadOfendido(forms.frmOfendido);"/>Infante

                    <input type="radio" name="rdRangoEdad4" id="rdRangoEdad41" value="adelescente" 
                        onclick="ValidarRangoEdadOfendido(forms.frmOfendido);"/>Adolescente

                    <input type="radio" name="rdRangoEdad4" id="rdRangoEdad42" value="menoradulto" 
                        onclick="ValidarRangoEdadOfendido(forms.frmOfendido);"/>Menor adulto

                    <input type="radio" name="rdRangoEdad4" id="rdRangoEdad43" value="adulto" 
                        onclick="ValidarRangoEdadOfendido(forms.frmOfendido);"/>Adulto

                    <input type="radio" name="rdRangoEdad4" id="rdRangoEdad44" value="adultomayor" 
                        onclick="ValidarRangoEdadOfendido(forms.frmOfendido);"/>Adulto mayor  
                    
                    <input type="radio" name="rdRangoEdad4" id="rdRangoEdad45" value="noconsignado"
                        onclick="ValidarRangoEdadOfendido(forms.frmOfendido);"/>No consignado    

                    <?php if (isset($_SESSION['oOfendido']))
                        if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't')
                        { 
                            if ($oOfendido->getRangoEdad()== 'ni')
                            {
                    ?>
                                <script type="text/javascript">
                                    $('input:radio[name=rdRangoEdad4]')[0].checked= true;
                                </script>  
                    <?php
                            }
                            elseif ($oOfendido->getRangoEdad()== 'na')
                            {
                    ?>
                                <script type="text/javascript">
                                    $('input:radio[name=rdRangoEdad4]')[1].checked= true;
                                </script>        
                    <?php
                            }
                            elseif ($oOfendido->getRangoEdad()== 'nm')
                            {
                    ?>
                                <script type="text/javascript">
                                    $('input:radio[name=rdRangoEdad4]')[2].checked= true;
                                </script> 
                    <?php
                            }
                            elseif ($oOfendido->getRangoEdad()== 'a')
                            {
                    ?>
                                <script type="text/javascript">
                                    $('input:radio[name=rdRangoEdad4]')[3].checked= true;
                                </script> 
                    <?php
                            }
                            elseif ($oOfendido->getRangoEdad()== 'am')
                            {
                    ?>
                                <script type="text/javascript">
                                    $('input:radio[name=rdRangoEdad4]')[4].checked= true;
                                </script>                                     
                    <?php
                            }
                            elseif ($oOfendido->getRangoEdad()== 'x')
                            {
                    ?>    
                                <script type="text/javascript">
                                    $('input:radio[name=rdRangoEdad4]')[5].checked= true;
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
<table align="center" border="0" class="TablaCaja" width="100%">
  <tbody>
    <tr class="SubTituloCentro"><Th colspan="4"><strong>Dirección Domiciliar</strong></Th></tr>
    <tr class="SubTituloDerecha">
      <td>Departamento</td>
      <td>Municipio</td>
      <td>Ciudad o Aldea</td>
      <td>Barrio</td>
    </tr>
    <tr class="Grid">
      <td>
	<?php 
		$resDepto4= CargarDepto();
		 combo("cboDepto4",$resDepto4,"cdepartamentoid","cdescripcion","",
                         "onchange='llena_muni(".'"cboDepto4"'.",".'"cboMuni4"'.","
                         .'"tdMuni4"'.",".'"62"'.",".'"cboAldea4"'.",".'"cboBarrio4"'
                         .")'");
	?>
      </td>
      <td id="tdMuni4">
	<?php
		combo("cboMuni4","","cmunicipioid","cdescripcion","",
                      "onchange='llena_aldea(".'"cboDepto4"'.",".'"cboMuni4"'.",
                      ".'"cboAldea4"'.",".'"tdAldea4"'.",".'"43"'.",".'"cboBarrio"'.")'");
	?>
      </td>
      <td id="tdAldea4">
	<?php
            combo("cboAldea4","","cbaldeaId","cdescripcion","","");
	?>
      </td>
      <td id="tdBarrio4">

      </td>
    </tr>
    <tr>
      <td colspan="4">Detalle de dirección:<br>
            <input name="txtDireccion" type="text" id="txtDireccion" size="80" maxlength="199"
                   value="<?php if (isset($_SESSION['oOfendido']))
                       { if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') echo($oOfendido->getDetalle()); } ?>"/>   
      </td>
    </tr>    
    <tr>
        <td colspan="4">Teléfonos:<br>
        <input name="txtTelefono" type="text" id="txtTelefono" size="50" maxlength="49"
               value="<?php if (isset($_SESSION['oOfendido']))
               { if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') echo($oOfendido->getTelefono()); } ?>"/>
    </td>            
    </tr>             
  </tbody>
</table>    
            
    <!--violacion--> 
    <br><br>
    <table id="delito" align="center" width="100%" border="0" 
           class="TablaCaja" summary="delitos">    
        <tr class="SubTituloCentro"><TH colspan="5">Para delitos sexuales</TH></tr>     
        <tr class="Grid">
            <td><br>
                Víctima embarazada:<br>
                <input type="radio" name="rdEmbarazada" id="rdEmbarazada" value="SI">Si<br>
                <input type="radio" name="rdEmbarazada" id="rdEmbarazada" value="NO">No<br>
                <input type="radio" name="rdEmbarazada" id="rdEmbarazada" value="NA" checked>No Aplica
            </td>
            <td>
                Frecuencia:<br>
                <input type="radio" name="rdFrecuencia" id="rdFrecuencia" value="PV">Primera vez<br>
                <input type="radio" name="rdFrecuencia" id="rdFrecuencia" value="RE">Reincidente<br>
                <input type="radio" name="rdFrecuencia" id="rdFrecuencia" value="NA" checked>No Aplica
            </td>            
            <td>
                Posee trabajo remunerado:<br>
                <input type="radio" name="rdTrabajo" id="rdTrabajo" value="SI">Si<br>
                <input type="radio" name="rdTrabajo" id="rdTrabajo" value="NO" checked="">No<br>
                <input type="radio" name="rdTrabajo" id="rdTrabajo" value="NA" checked="">No Aplica
            </td>  
            <td><br>
                Asiste a centro educacional:<br>
                <input type="radio" name="rdEstudia" id="rdEstudia" value="SI">Si<br>
                <input type="radio" name="rdEstudia" id="rdEstudia" value="NO">No<br>
                <input type="radio" name="rdEstudia" id="rdEstudia" value="NA" checked>No Aplica
            </td>            
            <td>
                Número de hijos:<br>
                <input type="text" name="txtHijos" id="txtHijos" value="-1">
            </td>             
        </td>            
        </tr>
    </table>      
    
    <!--suicidio--> 
    <br><br>
    <table id="delito" align="center" width="100%" border="0" 
           class="TablaCaja" summary="delitos">    
        <tr class="SubTituloCentro"><TH colspan="3">Para suicidio</TH></tr>     
        <tr class="Grid">
            <td><br>
                Hubieron intentos previos:<br>
                <input type="radio" name="rdPrevios" id="rdPrevios" value="SI">Si<br>
                <input type="radio" name="rdPrevios" id="rdPrevios" value="NO">No<br>
                <input type="radio" name="rdPrevios" id="rdPrevios" value="NA" checked>No Aplica
            </td>
            <td>
                Antecedentes de enfermedad mental:<br>
                <input type="radio" name="rdMental" id="rdMental" value="SI">Si<br>
                <input type="radio" name="rdMental" id="rdMental" value="NO">No<br>
                <input type="radio" name="rdMental" id="rdMental" value="NA" checked>No Aplica
            </td>            
            <td>
                Mecanismo de muerte:<br>
                <select name="cboMuerte" id="cboMuerte">
                    <option value="NA">No Aplica</option>
                    <option value="M1">Mecanismo 1</option>
                    <option value="M2">Mecanismo 2</option>
                </select>
            </td>             
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
                            $resEtnia4= CargarEtnia();
                            combo("cboEtnia4",$resEtnia4,"netniaid","cdescripcion",
                                    "Seleccione una etnia");
                            ?>
                        <script type="text/javascript">
                            $("#cboEtnia4").val("<?php if (isset($_SESSION['oOfendido']))
                                if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't')
                                { echo($oOfendido->getGrupoEtnico()); } else { echo(0); } ?>");
                        </script>                
                </td>
                <td align="right">Discapacidad</td>
                <td>	<?php
                            $resDisca4= CargarDiscapacidad();
                            combo("cboDiscapacidad4",$resDisca4,"ndiscapacidadid",
                                    "cdescripcion","Seleccione una discapacidad");
                            ?>
                        <script type="text/javascript">
                            $("#cboDiscapacidad4").val("<?php if (isset($_SESSION['oOfendido']))
                                if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't')
                                { echo($oOfendido->getDiscapacidad()); } else { echo(0); }?>");
                        </script>                
                </td>
                </tr>                
            </table>
                
            <br><br>
            <!--los botones para guardar-->
            <br>
            <table align="center" summary="botones persona natural">
                <tr>
                <td><INPUT type="submit" name="btnSubmit" value="Guardar datos"></td>
                <td><INPUT type="button" name="btnBorrar" value="Borrar actual" 
                   onClick="BorrarRegistro(document.getElementById('txtPersonaId').value);">              
                </tr>
            </table>  

        </form>
       
        
    </div><!--fin acordion persona natural-->
    
    <div style="display:none;" id="PersonaJuridicaDiv3">
        <h3>Persona Juridica</h3>

<form action="procesaofendido.php" method="POST" name="frmOfendidoJuridico" 
      id="frmOfendidoJuridico" onsubmit="return ValidarOfendidoJuridico(this);">        

    <input type="hidden" name="txtNaturalJuridico4" id="txtNaturalJuridico4">
    <input type="hidden" id='OfendidoJur4' name='OfendidoJur4'>
    <input type="hidden" name="txtPersonaId" id="txtPersonaId"
                   value="<?php if (isset($_SESSION['oOfendido']))
                       { if ($oOfendido->getPersonaNatural()== '0' || $oOfendido->getPersonaNatural()== 't') echo($oOfendido->getPersonaId());} ?>"/>
    
    <table id="tblPersonaJuridica4" align="center" border= "0"
           class="TablaCaja" summary="datos persona natural">
        
    <tr class="SubTituloCentro"><th colspan="4">Datos generales de la empresa</th></tr>
       
        <td align="right">Nombre de empresa o institución</td>
        
        <td><input list="txtEmpresasHn4J" name="txtEmpresasHn4J" size="30" maxlength="99" required
                   onblur="document.getElementById('OfendidoJur4').value= 'juridico';"
                   value="<?php if (isset($_SESSION['oOfendido']))
                        { if ($oOfendido->getPersonaNatural()== '0' || $oOfendido->getPersonaNatural()== 'f') echo($oOfendido->getNombreCompleto());  } ?>"/>
            <datalist id="txtEmpresasHn4J">
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
            <input type="text" id="txtRtn4J" name="txtRtn4J" size="15" maxlength="19"
                   value="<?php if (isset($_SESSION['oOfendido']))
                        { if ($oOfendido->getPersonaNatural()== '0' || $oOfendido->getPersonaNatural()== 'f') echo($oOfendido->getRTN());  } ?>">
        </td> 
    <tr>
        <td align="right">Nacionalidad</td>
        <td>
            <?php
            $resNacionJ= CargarNacionalidad();
            combo("cboNacionalidad4J",$resNacionJ,"cnacionalidadid","cdescripcion");
            ?>     
        </td>        
        <td align="right">Teléfonos</td>
        <td>
            <input type="text" id="txtTelefono4J" name="txtTelefono4J" size="15" maxlength="59"
                   value="<?php if (isset($_SESSION['oOfendido']))
                       { if ($oOfendido->getPersonaNatural()== '0' || $oOfendido->getPersonaNatural()== 'f') echo($oOfendido->getTelefono()); } ?>">
        </td>
        <td></td>
    </tr>
        <tr class="Grid">
        <td align="right">Departamento</td>
        <td>
            <?php
                    $resDepto= CargarDepto();
                    combo("cboDepto4J",$resDepto,"cdepartamentoid","cdescripcion","",
                            "onchange='llena_muni(".'"cboDepto4J"'.",".'"cboMuni4J"'.",
                                ".'"tdMuni4J"'.",".'"72"'.",".'"cboAldea4J"'.",".'"cboBarrio4J"'.")'");
            ?>
        </td>
        <td align="right">Municipio</td>
        <td id="tdMuni4J">
            <select name="cboMuni4J" id="cboMuni4J"></select>
        </td>
        </tr>
        <tr class="Grid">
        <td align="right">Aldea</td>
        <td id="tdAldea4J">
            <select name="cboAldea4J" id="cboAldea4J"></select>
        </td>
        <td align="right">Barrio</td>
        <td id="tdBarrio4J">
            <select name="cboBarrio4J" id="cboBarrio4J"></select>
        </td>
        </tr>
     <tr>
        <td align="right">Detalle dirección</td>
        <td colspan="3">
            <input list="txtDireccionJuridica4" name="txtDireccionJuridica4" size="80" maxlength="199" required
                   value="<?php if (isset($_SESSION['oOfendido']))
                       { if ($oOfendido->getPersonaNatural()== '0' || $oOfendido->getPersonaNatural()== 'f') echo($oOfendido->getDetalle());} ?>">
        </td>
     </tr>    
    </table>  
    <br><br>
        <table id="tblApoderado" align="center" border="0" 
               class="TablaCaja" summary="apoderado legal">
            <tr class="SubTituloCentro"><th colspan="4">Representante o apoderado Legal</th></tr>
            <tr class=" Grid">
                <td align="right">Nombre completo</td>
                <td>            
                    <input name="txtApoderado4J" type="text" id="txtApoderado4J" size="25" maxlength="50"
                           value="<?php if (isset($_SESSION['oOfendido']))
                           { if ($oOfendido->getPersonaNatural()== '0' || $oOfendido->getPersonaNatural()== 'f') echo($oOfendido->getApoderadoNombre()); } ?>"/> 
                </td>
                <td align="right">Identificación</td>
                <td>            
                    <input name="txtColegio4J" type="text" id="txtColegio4J" size="15" maxlength="20"
                           value="<?php if (isset($_SESSION['oOfendido']))
                           { if ($oOfendido->getPersonaNatural()== '0' || $oOfendido->getPersonaNatural()== 'f') 
                                   echo($oOfendido->getIdentidad());
                               else
                                   echo("-- No consignado --");                                 
                           } ?>"/>                     
                    <input name="rdTipoDoc" id="rdTipoDoc0" type="radio" value="colegio" checked>Número colegiado
                    <input name="rdTipoDoc" id="rdTipoDoc1" type="radio" value="identidad">Identidad
                    <input name="rdTipoDoc" id="rdTipoDoc2" type="radio" value="pasaporte">Pasaporte
                </td>            
            </tr>
        </table>     
    <!--los botones para guardar-->
    <br>
    <table align="center" summary="botones persona natural">
        <tr>     
        <td><INPUT type="submit" name="btnSubmit" value="Guardar datos" onclick="document.getElementById('txtNaturalJuridico').value= 'Juridico';"></td>
        <td><INPUT type="button" name="btnNuevo" value="Agregar nuevo" 
                   onClick="window.location='denunciante.php?btn=nuevo';"></td>  
        </tr>
    </table>   
</form>              
        
    </div>
</div>

<script type="text/javascript"> 
    //    hacer visible el div persona natural o persona juridica
    //    hacer visible el div persona natural
    Natural= "<?php
        if (isset($_SESSION['PersonaNaturalJuridica'])){ 
        echo($_SESSION['PersonaNaturalJuridica']);} 
    ?>";
    
    if (Natural == 'Natural') 
        document.getElementById('PersonaNaturalDiv3').style.display= 'block';
    
    //    hacer visible el div persona juridica
    Juridica= "<?php
        if (isset($_SESSION['PersonaNaturalJuridica'])){ 
        echo($_SESSION['PersonaNaturalJuridica']);} 
    ?>";
        
    if (Juridica == 'Juridica') 
        document.getElementById('PersonaJuridicaDiv3').style.display= 'block';  

    //cuando se selecciona un denunciante y saber que div mostrar
    TipoPersona= "<?php if (isset($oOfendido)){ echo($oOfendido->getPersonaNatural());}
                        else { echo 'x';}
                  ?>";
                    
    if (TipoPersona== 't') //persona natural
    {
        Natural = 'Natural';
        document.getElementById('PersonaNaturalDiv3').style.display= 'block';
    }
    if (TipoPersona== 'f') //persona juridica
    {
        Natural = 'Juridica';
        document.getElementById('PersonaJuridicaDiv3').style.display= 'block';  
        document.getElementById('OfendidoJur4').value= "juridico";
    }  
    <?php if (isset($_SESSION['oOfendido']))
        {?>    
            datos= new Array();
            datos.civil= "<?php 
                                if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') 
                                echo($oOfendido->getEstadoCivil());                        
                                else echo(0); ?>";

            datos.tipodoc= "<?php  if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') 
                                   echo($oOfendido->getTipoDocumento());                        
                                   else echo(0); ?>";                           

            datos.escolaridad= "<?php if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') 
                                      echo($oOfendido->getEscolaridad());                        
                                      else echo(0); ?>";

            datos.nacionalidad= "<?php 
                                    if (isset($oOfendido))
                                        echo($oOfendido->getNacionalidad());                        
                                        else echo "AA"; ?>";

            datos.profesion= "<?php if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') 
                                    echo($oOfendido->getProfesion());                        
                                    else echo(0); ?>";

            datos.ocupacion= "<?php if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') 
                                    echo($oOfendido->getOcupacion());                        
                                    else echo(0); ?>";

            datos.departamento= "<?php 
                                if (isset($oOfendido))
                                   echo($oOfendido->getDepartamentoid());                        
                                else echo(0);?>";

            datos.municipio= "<?php
                                if (isset($oOfendido))
                                   echo($oOfendido->getMunicipioid());                        
                                else  echo(0); ?>";

            datos.ciudad= "<?php 
                                if (isset($oOfendido))
                                   echo($oOfendido->getAldeaId());                        
                                 else echo(0); ?>";

            datos.barrio= "<?php 
                                if (isset($oOfendido))
                                   echo($oOfendido->getBarrioId()); 
                                else  echo(0); ?>";                           
    
            datos.personaid= "<?php if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') 
                                   echo($oOfendido->getPersonaId()); ?>";
                             
            datos.sexo= "<?php if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') 
                                   echo($oOfendido->getGenero()); ?>"; 
                                       
            datos.orientacionsex= "<?php if ($oOfendido->getPersonaNatural()== '1' || $oOfendido->getPersonaNatural()== 't') 
                                   echo($oOfendido->getOrientacionSex()); ?>";                                       

            frm= document.forms.frmOfendido; 
            LlenarCampos(frm, datos); 
            
            frmOfendidoJuridico.cboNacionalidad4J.value= datos.nacionalidad; 
            frmOfendido.cboNacionalidad4.value= datos.nacionalidad; 
    <?php     
    }    
    else
    { ?> 
        frmOfendido.cboNacionalidad4.value= "HN";
        frmOfendidoJuridico.cboNacionalidad4J.value= "HN";      
    <?php        
    }
    ?>  
</script>  
</body>
</html>
