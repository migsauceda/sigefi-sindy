<!doctype html>
<!inclusion de archivos>
<!controles para los campos del formulario y conexion>
<?php 	
        include "../clases/Usuario.php";
	include("../clases/controles/funct_select.php");

	//clase
	include("../clases/Denunciante.php");
       	
	//funciones genericas
	include "../funciones/php_funciones.php";
        
        //inicia sesión
        session_start();   

        if (isset($_SESSION['objUsuario'])){
            $objUsuario= $_SESSION['objUsuario'];        
        }else{
            header("location:index.php");
        }
        
        //usr presiono boton nuevo
        if (isset($_GET["btn"]) && $_GET["btn"]== "nuevo"){ 
            //borra el objeto actual
            $_SESSION['denunciante']= 'f';
                   
            //ahora el objeto
            unset($_SESSION['oDenunciante']);
            unset($oDenunciante);             
        }else{   
            //usuario presiono boton para cargar otro denunciante            
            if(isset($_SESSION["oDenunciante"])){
                //inicializar el objeto
                $oDenunciante= $_SESSION["oDenunciante"];               
                
            }
            
            if (isset($_GET["nmr"])){             
                $id= $_GET["nmr"]; 
                
                $oDenunciante= new Denunciante(); 
                $_SESSION["oDenunciante"]= $oDenunciante;
                //recuperar el denunciante con ese id para la denuncia actual
                $oDenunciante->RecuperarId($_SESSION['denunciaid'], $id);  
            }       
        }                
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Formulario Denunciante</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link type="text/css" rel="stylesheet" href="../css/Estilos.css">
  <script type="text/javascript" src="../funciones/funciones.js"></script>    

  <link href="../java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
  <link href="../java_script/css/smoothness/jquery.datetimepicker.css" rel="stylesheet" type="text/css">
  <script src="../java_script/js/jquery-1.10.2.js"></script>
  <script src="../java_script/js/jquery-ui-1.10.4.custom.js"></script>     
  <script src="../java_script/js/jquery.datetimepicker.js"></script>  
  <script>
	$(document).ready(function() {   
		$("#acordionDenunciantex").accordion({heightStyle: "content", collapsible: true, active: false,
                                            heightStyle: "content"});                  
                                        
                $( "#acordionDenunciantex" ).on( "accordionactivate", function( event, ui ) {
                    indice= ui.newHeader.index();

                    if (indice== 0){
                        participante('listaden2','denunciante');
                    }
                });                                        
	});   
        
        function Apoderado(){ 
            div = document.getElementById('ApoderadoDid');
            visible= document.getElementById('apoderado').checked;

            if (!visible){
                div.style.display = 'none';
                document.getElementById('txtApoderado').value= null;
                document.getElementById('txtColegio').value= null;
            }
            else{
                div.style.display = '';
            }    
        } 
        
        function esVacio(val){
            return (val === undefined || val == null || val.length <= 0) ? true:false;
        }
        
        function NombreAsumido(){ 
            div = document.getElementById('NombreAsumidoId');
            visible= document.getElementById('NombAsumido').checked;

            if (!visible){
                div.style.display = 'none';
                document.getElementById('txtNombreAsum').value= null;

            }
            else{
                div.style.display = '';
            }               
        }         

	function Recargar() { 
            var i=  document.getElementById("listaden2").selectedIndex;
            var id= document.getElementById("listaden2").options;
            var personaid= id[i].value;

            location.href= "frmExpediente.php?nmr="+personaid+"&tab=1";            
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

        /*funcion: participantes
         *lista los denunciantes ingresados
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
                    $("#listaden").html(data); 
                }
            });    
        }   
        
        function ActualizarListaDEnunciante(){
            //llenar el combo ofendidos ingresados
            participante('listaden2','denunciante');
        }   
        
        function CrearNuevo(Tipo){              
            if (Tipo == "Natural"){ 
                location.href= "frmExpediente.php?nuevo=11";
            }
            else{
                location.href= "frmExpediente.php?nuevo=12";
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

        //llena depto, municipio, aldea, barrio
        function LlenaDireccion(Departamentoid, Municipioid, AldeaId, BarrioId){
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
                    $("#cboDepto").html(data); //crea la lista de deptos
                    $("#cboDepto option[value="+Departamentoid+"]").attr("selected",true);
//                    document.getElementById('cboDepto').value= Departamentoid;
//                    $("#cboDepto").attr("value",Departamentoid); //selecciona el depto
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
//                            $("#cboMuni").attr("value",Municipioid);
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
                url: "../funciones/ajax_llenadireccion.php",
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
                url: "../funciones/ajax_llenadireccion.php",
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
                        url: "../funciones/ajax_llenadireccion.php",
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
                                url: "../funciones/ajax_llenadireccion.php",
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
                url: "../funciones/ajax_llenadireccion.php",
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
        
        function LlenarCampos(frm, datos){ 
            frm.cboCivil.value= datos.civil;
            frm.cboTipoDoc.value= datos.tipodoc;           
            frm.cboEscolar.value= datos.escolaridad; 
            frm.cboProfe.value= datos.profesion;            
            frm.cboOcupa.value= datos.ocupacion;
            frm.cboNacionalidad.value= datos.nacionalidad;             
            
            if (datos.lgbti== "t") 
                document.getElementById('rdLGBTI_Si').checked = true;
            else
                document.getElementById('rdLGBTI_No').checked = true;

         
            if (esVacio(datos.nombreasumido)){
                document.getElementById('NombAsumido').checked= false;
                NombreAsumido();
            }
            else{
                document.getElementById('NombAsumido').checked= true;
                document.getElementById('txtNombreAsum').value= datos.nombreasumido;
                NombreAsumido();
            }

            if (esVacio(datos.apoderadolegal)){
                document.getElementById('apoderado').checked= false;
            }
            else{
                document.getElementById('apoderado').checked= true;
                document.getElementById('txtApoderado').value= datos.apoderadolegal;
                document.getElementById('txtColegio').value= datos.apoderadocolegio;
                Apoderado();
            }
            
            LlenaDireccion(datos.departamento, datos.municipio, datos.ciudad, datos.barrio);
            LlenaDireccionJ(datos.departamento, datos.municipio, datos.ciudad, datos.barrio);

            var frm= document.forms.frmDenunciante;
            llenarsexo('selSexo1',datos.sexo, frm, datos.orientacionsex);             
            
            if (TipoPersona== 'f') //persona juridica
            {
                if (datos.tipodoc == 1)//identidad
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
                
                document.getElementById('txtEmpresasHn').focus(); 
            }
            
            if (datos.conocido == 0){ //anonimo 
                ValidarConocido('ano', document.forms.frmDenunciante);
            } 

            if (datos.natural== 'f') {
                if (datos.conocido == 3){ //oficio
                    $("#Oficioso").prop('checked', 'checked');
                    $("#rdTipoDoc3").prop('checked', 'checked');
                }                             
            }
            
        }   
        
        function BorrarRegistro(personaid){
            $.ajax({
                data: "borrar=denunciante&id="+personaid,
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
        
        $('#Oficioso').click(function(){            
            if(this.checked){                
                $("#txtEmpresasHn").val("---De Oficio---");
                $("#txtRtn").val("---N/A---");
                $("#txtTelefonoj").val("---N/A---");
                $("#txtDireccionJuridica").val("---N/A---");
                $("#txtApoderadoJ").val("---N/A---");
                $("#txtColegioJ").val("---N/A---");
                $("#rdTipoDoc3").prop('checked', true);
                
            }
            else{
                $("#txtEmpresasHn").val("");
                $("#txtRtn").val("");
                $("#txtTelefonoj").val("");
                $("#txtDireccionJuridica").val("");
                $("#txtApoderadoJ").val("");
                $("#txtColegioJ").val("");                
            }
        });        
  </script>
</head>
<body>

<!--cpcedeno@grupoficohsa.hn--> 

<div id="acordionDenunciante">      
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
                <span id="listaden"></span>
                <script type="text/javascript"> 
                    participante('listaden2','denunciante'); 
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

    <div style="display:none;" id="PersonaNaturalDiv">   
        <!--inicia acordeon persona natural-->
        <h3><a href="#">Persona Natural</a></h3>
    <!--<h3>Persona Natural</h3> -->
    
        <form action="procesadenunciante.php" method="POST" name="frmDenunciante" 
        id="frmDenunciante" onsubmit="return ValidarDenunciante(this);">       
    
        <input type="hidden" name="txtNaturalJuridico" id="txtNaturalJuridico">
        <input type="hidden" name="txtDireccion2" id="txtDireccion2">
        <input type="hidden" name="txtPersonaId" id="txtPersonaId"     
               value="<?php if (isset($_SESSION['oDenunciante']))
                   echo($oDenunciante->getPersonaId()); ?>"/>                 
        <!--los botones para guardar-->    
        <table align="center" summary="botones persona natural">
            <tr>     
                <td><INPUT type="submit" name="btnSubmit" value="Guardar datos" onclick="document.getElementById('txtNaturalJuridico').value= 'Natural';"></td>
            <td><pre>    </pre></td> 
            <td><INPUT type="button" name="btnBorrar" value="Borrar actual" 
                       onClick="BorrarRegistro(document.getElementById('txtPersonaId').value);"></td>      
            <td><pre>    </pre></td> 
                <td><input type="button" name="btnCopiar" value="Copiar a ofendido"
                           onclick="Copiar();"></td>
            </tr>
        </table>  
    
        <br>
        <table id="tblDenunciante1" align="center" border="0" 
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
                           onClick="ValidarConocido('ano', document.forms.frmDenunciante);"/>Anónimo<br>

                    <input type="radio" name="rdConocido" id="rdConocido" value="2" disabled
                           onClick="ValidarConocido('ocu', document.forms.frmDenunciante);"/>Ocultar Identidad<br>            

                    <input type="radio" name="rdConocido" id="rdConocido" value="1" checked
                           onClick="ValidarConocido('con', document.forms.frmDenunciante);"/>Conocido<br>

                    <input type="radio" name="rdConocido" id="rdConocido" value="3"
                           onClick="ValidarConocido('ofi', document.forms.frmDenunciante);"/>De Oficio<br>
                </td>
            
                <td>
<!--                <input type="radio" name="rdSexo" id="rdSexo0" value="m" onClick="llenarsexo('selSexo1','m', forms.frmDenunciante);"/>Masculino<br>
                <input type="radio" name="rdSexo" id="rdSexo1" value="f" onClick="llenarsexo('selSexo1','f', forms.frmDenunciante);"/>Femenino<br>    
                <input type="radio" name="rdSexo" id="rdSexo2" value="x" onClick="llenarsexo('selSexo1','x', forms.frmDenunciante);"/>No consignado<br>                -->
                <input type="radio" name="rdSexo" id="rdSexo0" value="m" onclick="txtEdad.disabled= false;"/>Masculino<br>
                <input type="radio" name="rdSexo" id="rdSexo1" value="f" onclick="txtEdad.disabled= false;"/>Femenino<br>    
                <input type="radio" name="rdSexo" id="rdSexo2" value="x" onclick="txtEdad.disabled= false;"/>No consignado<br>                                
                </td>
            
                <td>
<!--                Orientación sexual<br>
                <select name="selSexo1" id="selSexo1"></select>-->
                <!--<span id="selSexo1"></span>-->

                <input type="radio" name="rdAplicaLGBTI" value="si" id="rdLGBTI_Si"/>Si Integra comunidad
                    <br>
                <input type="radio" name="rdAplicaLGBTI" value="no" id="rdLGBTI_No"/>No Integra comunidad
                    <br>
                <input type="checkbox" name="NombAsumido" id="NombAsumido" value="0" onclick="NombreAsumido();"/>Nombre asumido
            
                </td>
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

    <!--Orientacion sexual-->
    <script type="text/javascript">         
//        var frm= document.forms.frmDenunciante;
//        llenarsexo('selSexo1','f', frm);
    </script>
    
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
                    document.getElementById("NombAsumido").checked= false; 
                </script>
    <?php  
            }            
            else
            {
    ?> 
                <script type="text/javascript">            
                    document.getElementById("NombAsumido").checked= true; 
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
                    <input name="txtApoderado" type="text" id="txtApoderado" size="25" maxlength="49"
                           value="<?php if (isset($_SESSION['oDenunciante']))
                           { if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getApoderadoNombre()); } ?>"/> 
                </td>
                <td align="right">Número Colegio</td>
                <td>            
                    <input name="txtColegio" type="text" id="txtColegio" size="25" maxlength="24"
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
        </td>
        <td align="right">Estado civil</td>
        <td>	
            <?php
                $resCivil= CargarEstadoCivil();
                combo("cboCivil",$resCivil,"ncivil","cdescripcion");
            ?>             
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
            <input name="txtIdentidad" type="text" id="txtIdentidad" size="15" maxlength="19" disabled
                value="<?php if (isset($_SESSION['oDenunciante']))
                { if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getIdentidad()); }?>"/>                

            <script type="text/javascript">
                if ($("#cboTipoDoc").val() != 0){
                    $("#txtIdentidad").removeAttr('disabled');
                }          

                if (txtIdentidad != null){
                    txtIdentidad.disabled= false;
                }                
            </script>            
        </td>
        <td align="right">Escolaridad</td>
        <td>
            <?php
                $resEscolar= CargarEscolaridad();
                combo("cboEscolar",$resEscolar,"nescolaridadid","cdescripcion");
            ?>               
        </td>
        </tr>
        <tr class="Grid">
        <td align="right">Profesion/oficio</td>
        <td>
            <?php
                $resProfe= CargarProfesion();
                combo("cboProfe",$resProfe,"nprofesionid","cdescripcion");
            ?>              
        </td>
        <td align="right">Ocupación</td>
        <td>	
            <?php
                $resOcupa= CargarOcupacion();
                combo("cboOcupa",$resOcupa,"nocupacionid","cdescripcion");
            ?>             
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
                combo("cboMuni","","cmunicipioid","cdescripcion","",
                      "onchange='llena_aldea(".'"cboDepto"'.",".'"cboMuni"'.",
                      ".'"cboAldea"'.",".'"tdAldea"'.",".'"23"'.",".'"cboBarrio"'.")'");            
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
                      ".'"cboAldea"'.",".'"cboBarrio"'.",".'"tdBarrio"'.",".'"24"'.")'");                
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
                    $("#cboEtnia").val("<?php if (isset($_SESSION['oDenunciante']))
                        { if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't') 
                            echo($oDenunciante->getGrupoEtnico()); } else { echo(0); } ?>");
                </script>                
        </td>
        <td align="right">Discapacidad</td>
        <td>	<?php
                    $resDisca= CargarDiscapacidad();
                    combo("cboDiscapacidad",$resDisca,"ndiscapacidadid",
                            "cdescripcion","Seleccione una discapacidad");
                ?>
                <script type="text/javascript">
                    $("#cboDiscapacidad").val("<?php if (isset($_SESSION['oDenunciante']))
                        { if ($oDenunciante->getPersonaNatural()== '1' || $oDenunciante->getPersonaNatural()== 't') echo($oDenunciante->getDiscapacidad()); } else { echo(0); } ?>");
                </script>                
        </td>
        </tr>        
    </table>
    
    <!--los botones para guardar-->
    <br>
    <table align="center" summary="botones persona natural">
        <tr>     
        <td><INPUT type="submit" name="btnSubmit" value="Guardar datos"></td>
        <td><pre>    </pre></td>
        <td><INPUT type="button" name="btnBorrar" value="Borrar actual" 
                   onClick="BorrarRegistro(document.getElementById('txtPersonaId').value);"></td>      
        <td><pre>    </pre></td> 
            <td><input type="button" name="btnCopiar" value="Copiar a ofendido"
                       onclick="Copiar();"></td>
        </tr>        
    </table>
    </FORM>           
</div> <!-- fin persona natural-->           

<div style="display:none;" id="PersonaJuridicaDiv">
<h3>Persona Juridica</h3>
   
<form action="procesadenunciante.php" method="POST"
        id="frmDenuncianteJuridico" onsubmit="return ValidarDenuncianteJuridico(this);">  
    <input type="hidden" name="txtNaturalJuridico" id="txtNaturalJuridico">
    <input type="hidden" id='DenuncianteJur' name='DenuncianteJur'>
    <input type="hidden" name="txtPersonaId" id="txtPersonaId"
                   value="<?php if (isset($_SESSION['oDenunciante']))
                       { if ($oDenunciante->getPersonaNatural()== '0' || $oDenunciante->getPersonaNatural()== 'f') echo($oDenunciante->getPersonaId());} ?>"/>
    
    <table id="tblPersonaJuridica" align="center" border= "0"
           class="TablaCaja" summary="datos persona natural">
        
    <tr class="SubTituloCentro"><th colspan="4">Datos generales de la empresa</th></tr>
       
        <td align="right">Nombre de empresa o institución</td>
        
        <td><input list="txtEmpresasHn" name="txtEmpresasHn" id="txtEmpresasHn" size="30" maxlength="50" 
                   onblur="document.getElementById('DenuncianteJur').value= 'juridico';"
                   value="<?php if (isset($_SESSION['oDenunciante']))
                        { if ($oDenunciante->getPersonaNatural()== '0' || $oDenunciante->getPersonaNatural()== 'f') echo($oDenunciante->getNombreCompleto());  } ?>"/>            
            <datalist id="txtEmpresasHn">
                <?php
                    $resEmpresas= CargarEmpresasHN();
                    while ($Rol= pg_fetch_array($resEmpresas)) {
                        echo "<option value='$Rol[cdescripcion]'>";
                    }
                ?>
            </datalist> 
            <input type="checkbox" name="Oficioso" id="Oficioso" value="3">Acción oficiosa
        </td>
        <td align="right">RTN</td>
        <td>            
            <input type="text" id="txtRtn" name="txtRtn" size="15" maxlength="19"
                   value="<?php if (isset($_SESSION['oDenunciante']))
                        { if ($oDenunciante->getPersonaNatural()== '0' || $oDenunciante->getPersonaNatural()== 'f') echo($oDenunciante->getRTN());  } ?>">
        </td> 
    <tr>
        <td align="right">Nacionalidad</td>
        <td>
            <?php
            $resNacionJ= CargarNacionalidad();
            combo("cboNacionalidadJ",$resNacionJ,"cnacionalidadid","cdescripcion");            
            ?>        
        </td>        
        <td align="right">Teléfonos</td>
        <td>
            <input type="text" id="txtTelefonoj" name="txtTelefonoj" size="15" maxlength="59"
                   value="<?php if (isset($_SESSION['oDenunciante']))
                       { if ($oDenunciante->getPersonaNatural()== '0' || $oDenunciante->getPersonaNatural()== 'f') echo($oDenunciante->getTelefono()); } ?>">
        </td>
        <td></td>
    </tr>
        <tr class="Grid">
        <td align="right">Departamento</td>
        <td>
            <?php
                    $resDepto= CargarDepto();
                    combo("cboDeptoJ",$resDepto,"cdepartamentoid","cdescripcion","",
                            "onchange='llena_muni(".'"cboDeptoJ"'.",".'"cboMuniJ"'.",
                                ".'"tdMuniJ"'.",".'"32"'.",".'"cboAldeaJ"'.",".'"cboBarrioJ"'.")'");
            ?>
        </td>
        <td align="right">Municipio</td>
        <td id="tdMuniJ">
            <select id="cboMuniJ" name="cboMuniJ"></select>
        </td>
        </tr>
        <tr class="Grid">
        <td align="right">Aldea</td>
        <td id="tdAldeaJ">
            <select id="cboAldeaJ" name="cboAldeaJ"></select>
        </td>
        <td align="right">Barrio</td>
        <td id="tdBarrioJ">
            <select id="cboBarrioJ" name="cboBarrioJ"></select>
        </td>
        </tr>
     <tr>
        <td align="right">Detalle dirección</td>
        <td colspan="3">
            <input list="txtDireccionJuridica" name="txtDireccionJuridica" id="txtDireccionJuridica" size="80" maxlength="100" required
                   value="<?php if (isset($_SESSION['oDenunciante']))
                       { if ($oDenunciante->getPersonaNatural()== '0' || $oDenunciante->getPersonaNatural()== 'f') echo($oDenunciante->getTxtDireccion());} ?>">
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
                    <input name="txtApoderadoJ" type="text" id="txtApoderadoJ" size="45" maxlength="60"
                           value="<?php if (isset($_SESSION['oDenunciante']))
                           { if ($oDenunciante->getPersonaNatural()== '0' || $oDenunciante->getPersonaNatural()== 'f') echo($oDenunciante->getApoderadoNombre()); } ?>"/> 
                </td>
            </tr>
            <tr>
                <td align="right">Identificación</td>
                <td>            
                    <input name="txtColegioJ" type="text" id="txtColegioJ" size="15" maxlength="20"
                           value="<?php if (isset($_SESSION['oDenunciante']))
                           { if ($oDenunciante->getPersonaNatural()== '0' || $oDenunciante->getPersonaNatural()== 'f') 
                                   echo($oDenunciante->getIdentidad());
                               else
                                   echo("-- No consignado --");                                
                           } ?>"/>                     
                    <input name="rdTipoDoc" id="rdTipoDoc0" type="radio" value="colegio" >Número colegiado
                    <input name="rdTipoDoc" id="rdTipoDoc1" type="radio" value="identidad">Identidad
                    <input name="rdTipoDoc" id="rdTipoDoc2" type="radio" value="pasaporte">Pasaporte
                    <input name="rdTipoDoc" id="rdTipoDoc3" type="radio" value="nodefinido" checked="">Sin identificación
                </td>            
            </tr>
        </table>     
    <!--los botones para guardar-->
    <br>
    <table align="center" summary="botones persona juridica">
        <tr>     
        <td><INPUT type="submit" name="btnSubmit" value="Guardar datos" onclick="document.getElementById('DenuncianteJur').value= 'juridico';"></td>
        <td><INPUT type="button" name="btnBorrar" value="Borrar actual" 
                   onClick="BorrarRegistro(document.getElementById('txtPersonaId').value);"></td>      
        </tr>
    </table>   
</form>      

</div> <!-- fin persona juridica-->  

</div> <!--fin acordeon-->

<script type="text/javascript">
    //    hacer visible el div persona natural o persona juridica
    //    hacer visible el div persona natural
    Natural= "<?php
        if (isset($_SESSION['PersonaNaturalJuridica'])){ 
        echo($_SESSION['PersonaNaturalJuridica']);} 
    ?>";
    
    if (Natural == 'Natural') 
        document.getElementById('PersonaNaturalDiv').style.display= 'block';
    
    //    hacer visible el div persona juridica
    Juridica= "<?php
        if (isset($_SESSION['PersonaNaturalJuridica'])){ 
        echo($_SESSION['PersonaNaturalJuridica']);} 
    ?>";

    if (Juridica == 'Juridica') {
        document.getElementById('PersonaJuridicaDiv').style.display= 'block';  
        document.getElementById('txtEmpresasHn').focus(); 
    }

    //cuando se selecciona un denunciante y saber que div mostrar
    TipoPersona= "<?php if (isset($oDenunciante)){ echo($oDenunciante->getPersonaNatural());}
                        else { echo 'x';}
                  ?>";
                   
    if (TipoPersona== 't') //persona natural
    {
        Natural = 'Natural';
        document.getElementById('PersonaNaturalDiv').style.display= 'block';
    }
    if (TipoPersona== 'f') //persona juridica
    {
        Natural = 'Juridica';
        document.getElementById('PersonaJuridicaDiv').style.display= 'block';  
    }
    
        <?php
        if (isset($_SESSION['oDenunciante']))
        {?>  
            datos= new Array(); 
            //0:anónimo, 1:conocido, 2:ocultar id, 3:oficio
            datos.conocido= "<?php echo($oDenunciante->getConocido());?>";
            
            datos.natural= "<?php echo($oDenunciante->getPersonaNatural());?>";
                
            datos.civil= "<?php echo($oDenunciante->getEstadoCivil());?>";

            datos.tipodoc= "<?php echo($oDenunciante->getTipoDocumento());?>";                           

            datos.escolaridad= "<?php echo($oDenunciante->getEscolaridad());?>";

            datos.nacionalidad= "<?php if ($oDenunciante->getPersonaNatural() == '1' || $oDenunciante->getPersonaNatural() == 't'
                                            || $oDenunciante->getPersonaNatural() == 'f') {
                echo($oDenunciante->getNacionalidad());
            } else {
                echo "HN";
            }
            ?>";

            datos.profesion= "<?php echo($oDenunciante->getProfesion());?>";

            datos.ocupacion= "<?php echo($oDenunciante->getOcupacion());?>";

            datos.departamento= "<?php echo($oDenunciante->getDepartamentoid());?>";

            datos.municipio= "<?php echo($oDenunciante->getMunicipioid());?>";

            datos.ciudad= "<?php echo($oDenunciante->getAldeaId());?>";

            datos.barrio= "<?php echo($oDenunciante->getBarrioId());?>";                           
    
            datos.personaid= "<?php echo($oDenunciante->getPersonaId());?>";
                             
            datos.sexo= "<?php echo($oDenunciante->getGenero());?>"; 
                                       
            datos.orientacionsex= "<?php echo($oDenunciante->getOrientacionSex());?>";   
                
            datos.lgbti= "<?php echo($oDenunciante->getIntegraLGBTI());?>"; 
                
            datos.nombreasumido= "<?php echo($oDenunciante->getNombreAsumido());?>"; 
                
            datos.apoderadolegal= "<?php echo($oDenunciante->getApoderadoNombre());?>"; 

            datos.apoderadocolegio= "<?php echo($oDenunciante->getApoderadoColegio());?>"; 
                
            frm= document.forms.frmDenunciante;
            LlenarCampos(frm, datos);   
           
            frmDenuncianteJuridico.cboNacionalidadJ.value= datos.nacionalidad;    
            frmDenunciante.cboNacionalidad.value= datos.nacionalidad;    
    <?php }
    else
    { ?> 
            frmDenunciante.cboNacionalidad.value= "HN";
            frmDenuncianteJuridico.cboNacionalidadJ.value= "HN";
    <?php        
    }
    ?> 
        
    //ventana modal para copiar
    function Copiar(){ 
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
</script>

</body>
</html>