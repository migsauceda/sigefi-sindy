<!inclusion de archivos>
<!controles para los campos del formulario y conexion>
<?php 	include("../clases/controles/funct_text.php");
	include("../clases/controles/funct_select.php");	
	include("../clases/controles/funct_radio.php");
	include("../clases/controles/funct_check.php");

	//clase
	include("../clases/Imputado.php");
        
	
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
            $_SESSION['denunciado']= 'f';
//            $_SESSION['ofendido']= 'f';                     

            //ahora el objeto
            unset($_SESSION['oDenunciado']);
            unset($oDenunciado);                                    
        }else{         
            //usuario presiono boton para cargar otro denunciante
            if(isset($_SESSION["oDenunciado"])){             
                //inicializar el objeto
                $oDenunciado= $_SESSION["oDenunciado"]; 
            }    
            //nmr numero denunciado
            if (isset($_GET["nmr"])){
                $id= $_GET["nmr"]; 
                
                $oDenunciado= new Imputado(); 
                $_SESSION["oDenunciado"]= $oDenunciado;
                //recuperar el denunciante con ese id para la denuncia actual
                $oDenunciado->RecuperarId($_SESSION['denunciaid'], $id);  
            }            
        }                   
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
                        participante('listaden2','denunciado');
                    }
                });                                          
	});

	function Recargar() { 
            var i= document.getElementById("listaden2").selectedIndex;
            var id= document.getElementById("listaden2").options;
            var personaid= id[i].value;
            
            location.href='../imputado/imputado.php?nmr='+"'"+personaid+"'";
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
                if(isset($_SESSION["oDenunciado"]))
                {
                    if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't')
                    { //persona natural
                ?>
                    //llena depto, municipio, aldea, barrio
                    LlenaDireccion("<?php echo($oDenunciado->getDepartamentoid());?>",
                                   "<?php echo($oDenunciado->getMunicipioid());?>",
                                   "<?php echo($oDenunciado->getAldeaId());?>",
                                   "<?php echo($oDenunciado->getBarrioId());?>");
                <?php
                    }
                    else  //persona juridico
                    {
                ?>
                    //llena depto, municipio, aldea, barrio
                    LlenaDireccionj("<?php echo($oDenunciado->getDepartamentoid());?>",
                                   "<?php echo($oDenunciado->getMunicipioid());?>",
                                   "<?php echo($oDenunciado->getAldeaId());?>",
                                   "<?php echo($oDenunciado->getBarrioId());?>");
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

       //variables para contar filas de alias y delito-->
                 Alias= 1;
                 Delitos= 1;
                 Contador= 0;
                 Actual= 0;
                 BorrarDelito= 0;
                 BorrarAlias= 0
       

        //agrega una fila y el alias correspondiente-->
        function RecuperarAlias(aliastxt)
        {
            Contador= 0;
            Alias++;
            Contador= Alias;
            //document.getElementById("Alias").value= Alias;

            var fil=document.getElementById("alias").insertRow(--Contador);

            col= document.createElement("td"); 
            col.width="5%";
            txt1= document.createElement("input");
            txt1.type= "text";
            txt1.name= "campo1"+Contador;
            txt1.id= "campo1"+Contador;
            txt1.size= 1;
            txt1.value= Contador;

            col.appendChild(txt1); 
            fil.appendChild(col);

            col= document.createElement("td"); 

            txt1= document.createElement("input");
            txt1.type= "text";
            txt1.name= "campo3"+Contador;
            txt1.id= "campo3"+Contador;
            txt1.size= 25;
            txt1.value= aliastxt;
            
            col.appendChild(txt1);
            fil.appendChild(col);

            //document.getElementById("opcion").option[0]= 5;
        }    
 
        //<!--agrega una fila y el delito correspondiente-->
        function RecuperarDelitos(delitoid, clasificacion){ 
                Contador= 0;
                Delitos++;
                Contador= Delitos;

                var fil=document.getElementById("delito").insertRow(--Contador);

                col= document.createElement("td"); 
                col.width="5%";

                txt0= document.createElement("input");
                txt0.type= "button";
                txt0.name= "campo1"+Contador;
                txt0.id= "campo1"+Contador;
                txt0.value= "Borrar";
                

                txt0.onclick= function() {BorrarFilaDelitos("delito",fil.rowIndex);};
//                
//                if (TablaId== "delitoj")
//                    txt0.onclick= function() {BorrarFilaDelitos("delitoj",fil.rowIndex);};                
        
                col.appendChild(txt0);
                fil.appendChild(col);                

                col= document.createElement("td"); 

                txt1= document.createElement("select");
                txt1.name= "delito"+Contador;
                txt1.id= "delito"+Contador;

                <?php 
                $resDelito= CargarDelito();
                while ($fila=pg_fetch_array($resDelito)){?>
                        opt= document.createElement("option")
                        opt.text=  "<?php echo($fila[cdescripcion]);?>"
                        opt.id= "opcion"+Contador;
                        opt.value= "<?php echo($fila[ndelitoid]);?>"

                        try{
                                txt1.add(opt,null);
                        }
                        catch(e)
                        {
                                txt1.add(opt);
                        }                        
                <?php
                } 		
                ?>
                        
                col.appendChild(txt1);
                fil.appendChild(col);           
                
                document.getElementById("delito"+Contador).value= delitoid;                
                
                txt2= document.createElement("input");
                txt2.type= "radio";
                txt2.name= "campo4"+Contador;
                txt2.id= "campo4"+Contador;
                txt2.value= "Culposo";  

                lbl2= document.createElement("label");
                lbl2.setAttribute("for","all");
                lbltext= document.createTextNode("Culposo");

                lbl2.appendChild(lbltext);
                col.appendChild(lbl2);
                col.appendChild(txt2);
                fil.appendChild(col);

                txt2= document.createElement("input");
                txt2.type= "radio";
                txt2.name= "campo5"+Contador;
                txt2.id= "campo5"+Contador;
                txt2.value= "Tentativa";  

                lbl2= document.createElement("label");
                lbl2.setAttribute("for","all");
                lbltext= document.createTextNode("Tentativa");

                lbl2.appendChild(lbltext);
                col.appendChild(txt2);
                col.appendChild(lbl2);                
                fil.appendChild(col);   

                if (clasificacion== 'c'){ 
                    nombrer= "campo4"+Contador; 
                    document.getElementById(nombrer).checked= true;
                }
                else if (clasificacion== 't') { 
                    nombrer= "campo5"+Contador;
                    document.getElementById(nombrer).checked= true;
                }
        }    

        //<!--agregar filas a las tablas-->
        function AgregarFila(TablaId, Valor)
        {                
                Contador= 0;
                if (TablaId== "alias")
                {
                        Alias++;
                        Contador= Alias;
                        //document.getElementById("Alias").value= Alias;
                }
                else
                {
                        Delitos++;
                        Contador= Delitos;
                        //document.getElementById("Delitos").value= Delitos;
                }

                var fil=document.getElementById(TablaId).insertRow(--Contador);

                fil.id= "campo1"+Contador;                         

                col= document.createElement("td"); 
                col.width="5%";

                txt0= document.createElement("input");
                txt0.type= "button";
                txt0.name= "campo2"+Contador;
                txt0.id= "campo2"+Contador;
                txt0.value= "Borrar";
                
                if (TablaId== "delito")
                    txt0.onclick= function() {BorrarFilaDelitos("delito",fil.rowIndex);};
                
                if (TablaId== "delitoj")
                    txt0.onclick= function() {BorrarFilaDelitos("delitoj",fil.rowIndex);};
                                
                if (TablaId== "alias")
                    txt0.onclick= function() {BorrarFilaDelitos("alias",fil.rowIndex);}
                
        
                col.appendChild(txt0);
                fil.appendChild(col);                
                        
                col= document.createElement("td"); 

                if (TablaId == "alias")
                { 
                        txt1= document.createElement("input");
                        txt1.type= "text";
                        txt1.name= "campo3"+Contador;
                        txt1.id= "campo3"+Contador;
                        txt1.size= 25;
                        txt1.value= Valor;
                        
                        col.appendChild(txt1);
                        fil.appendChild(col);
                }else
                { 
                        txt1= document.createElement("select");
                        if (TablaId== "delito"){
                            txt1.name= "delito"+Contador;
                            txt1.id= "delito"+Contador;
                        }else{
                            txt1.name= "delitoj"+Contador;
                            txt1.id= "delitoj"+Contador;                            
                        }

                        <?php 
                        $resDelito= CargarDelito();
                        while ($fila=pg_fetch_array($resDelito)){?>
                                opt= document.createElement("option");
                                opt.text=  "<?php echo($fila[cdescripcion]);?>";
                                opt.id= "opcion"+Contador;
                                opt.value= "<?php echo($fila[ndelitoid]);?>";

                                try{
                                        txt1.add(opt,null);
                                }
                                catch(e)
                                { 
                                        txt1.add(opt);
                                }
                        <?php
                        } 		
                        ?>
                                    
                        txt1.value= Valor; 
                        
                        col.appendChild(txt1);
                        fil.appendChild(col);
                        
                        txt2= document.createElement("input");
                        txt2.type= "radio";
                        txt2.name= "campo4"+Contador;
                        txt2.id= "campo4"+Contador;
                        txt2.value= "Culposo";  

                        lbl2= document.createElement("label");
                        lbl2.setAttribute("for","all");
                        lbltext= document.createTextNode("Culposo");

                        lbl2.appendChild(lbltext);
                        col.appendChild(lbl2);
                        col.appendChild(txt2);
                        fil.appendChild(col);

                        txt2= document.createElement("input");
                        txt2.type= "radio";
                        txt2.name= "campo5"+Contador;
                        txt2.id= "campo5"+Contador;
                        txt2.value= "Tentativa";  

                        lbl2= document.createElement("label");
                        lbl2.setAttribute("for","all");
                        lbltext= document.createTextNode("Tentativa");

                        lbl2.appendChild(lbltext);
                        col.appendChild(txt2);
                        col.appendChild(lbl2);                
                        fil.appendChild(col);                        
                }                                
        }


        //<!--javas scripts para llenar los combos-->
        //<!--borrar fila de tabla-->
        function BorrarFilaDelitos(tabla, fila)
        { 
            if (tabla == "delito")
            {
                document.getElementById("delito").deleteRow(fila);
                Delitos--;
            }
            else           
            if (tabla == "delitoj")
            {
                document.getElementById("delitoj").deleteRow(fila);
                Delitos--;
            }
            else
            {
                document.getElementById("alias").deleteRow(fila);
                Alias--;           
            }
        }

        function CrearListaDelitosAlias(){ 
            //alias
            Desde= 0;
            Hasta= 0;
            i= 0;
            document.getElementById("txtTodosAlias").value="";
            for(i=1; i < Alias; i++)
            {
                document.getElementById("txtTodosAlias").value=
                    document.getElementById("txtTodosAlias").value + 
                     document.getElementById("campo3"+i).value + ";";
            }

            //delitos  txtTodosDelitos
            Desde= 0;
            Hasta= 0;
            i= 0;
            document.getElementById("txtTodosDelitos").value="";
            for(i=1; i < Delitos; i++)
            { 
                document.getElementById("txtTodosDelitos").value=
                    document.getElementById("txtTodosDelitos").value + 
                    document.getElementById("delito"+i).value+";";            
            } 
            
            //calificacion tentativa
            Desde= 0;
            Hasta= 0;
            i= 0; 
            document.getElementById("txtTentativa").value=""; 
            for(i=1; i < Delitos; i++)
            { 
                if (document.getElementById("campo5"+i).checked== true)
                {                
                    document.getElementById("txtTentativa").value=
                        document.getElementById("txtTentativa").value + '1'+";";
                    
                }
                else
                {
                    document.getElementById("txtTentativa").value=
                        document.getElementById("txtTentativa").value + '0'+";"; 
                    
                }
                
            }  
            
            //calificacion culposa
            Desde= 0;
            Hasta= 0;
            i= 0;
            document.getElementById("txtCulposo").value=""; 
            for(i=1; i < Delitos; i++)
            { 
                if (document.getElementById("campo4"+i).checked== true)
                {
                    document.getElementById("txtCulposo").value=
                        document.getElementById("txtCulposo").value + '1'+";";                        
                }
                else
                {
                    document.getElementById("txtCulposo").value=
                        document.getElementById("txtCulposo").value + '0'+";";
                }
            }                         
        }

        /*funcion: participantes
         *lista los denunciantes ingresados
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
                }
            });    
        } 
        
        //llena delitos
        function llenadelitos(){ 
            Persona= "<?php if (isset($_SESSION['oDenunciado'])) echo($oDenunciado->getPersonaId()); ?>";
            Denuncia= "<?php if (isset($_SESSION['oDenunciado'])) echo($_SESSION['denunciaid']); ?>";
  
            $.ajax({
                data:       "personaid="+Persona+"&denunciaid="+Denuncia,
                type:       "POST",
                datatype:   "json",
                url:    "../funciones/ajax_LlenaDelitos.php",
                error: function (XMLHttpRequest, textStatus, errorThrown){
                    alert("Error al cargar datos para los delitos");
                },
                success: function(json_obj){  
                    //nombre completo del fiscal
                    json_txt= JSON.parse(json_obj);
                    var i= 0;
                    for (i= 0; i < json_txt.length; i++){
                        RecuperarDelitos(json_txt[i].ndelito, json_txt[i].cclasificacion);
                    }
                }
            });        
        } 

       //llena alias
        function llenaalias(){
        <?php if (isset($_SESSION['oDenunciado'])){
            $Aliasls= $oDenunciado->RecuperarAlias(); 
            while ($reg= pg_fetch_array($Aliasls))
            {?>            
                RecuperarAlias("<?php echo($reg[alias]); ?>");
            <?php                     
            }
        } 
        ?>            
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
        
</head>
<body>        
<a name="inicio"></a>

<br><br>

<!-- mostrar mensaje de grabacion exitosa -->
<!-- orm_Denunciado.php llama a esta pagina cuando tiene exito en grabar -->
<?php
if (isset($_GET["rsl2"]))
    if($_GET["rsl2"]== 100)
    {
?>
    <script type="text/javascript">
        alert("Se han guardado los datos del Denunciado");
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
        alert("Se han modificado los datos del Denunciado");
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
        alert("ERROR al guardar los datos del Denunciado: "+"<?php echo $_GET['err']; ?>");
    </script>  
<?php
    unset($_GET["rsl2"]);
    }
?> 
    
<!-- efinicion de acordion para separar persona natural de juridica -->
<div class="Denunciado">
    
<div id="acordion">        

<h3><a href="#">Persona Natural</a></h3>
<div> <!--inicia acordion persona natural-->
    <!-- IMPORTANTE se usa ValidarDenunciado porque es igual  -->
    <FORM action="procesaimputado.php" method="POST" name="frmImputado" 
        id="frmImputado" onsubmit="return ValidarDenunciado(this);">  
        
        <!-- input ocultos para guardar info sobre alias y delitos -->
        <input type="hidden" name="aliases" id="aliases" >
        <input type="hidden" name="txtTotalAlias" id="txtTotalAlias">
        <input type="hidden" name="txtTodosAlias" id= "txtTodosAlias">

        <input type="hidden" name="txtTotalDelitos" id="txtTotalDelitos">
        <input type="hidden" name="txtTodosDelitos" id="txtTodosDelitos"> 
        
        <input type="hidden" name="txtCulposo" id="txtCulposo">
        <input type="hidden" name="txtTentativa" id="txtTentativa">
        
        <script type="text/javascript">
               $("#txtTodosDelitos").attr("value",-1);
               $("#txtTodosAlias").attr("value",-1);
        </script>
        
        <input type="hidden" name="txtDireccion2" id="txtDireccion2">
        <input type="hidden" name="txtPersonaId" id="txtPersonaId"
               value="<?php if (isset($_SESSION['oDenunciado']))
                   { echo $oDenunciado->getPersonaId(); } ?>"/>        
        
    <!--los botones para guardar persona natural-->    
    <table align="center" summary="botones persona natural">
        <tr> 
        <td><INPUT type="submit" name="btnSubmit" value="Guardar datos" onClick="CrearListaDelitosAlias();"></td>
        <td><INPUT type="button" name="btnNuevo" value="Agregar nuevo" 
                   onClick="window.location='imputado.php?btn=nuevo';"></td>    
        <td><INPUT type="button" name="btnBorrar" value="Borrar actual" 
                   onClick="BorrarRegistro(document.getElementById('txtPersonaId').value);">      
        </tr>
    </table> 
    <br><br>
        
        <table id="tblDenunciado0" align="center" border="0" 
               class="TablaCaja" summary="persona natural">
            <tr class="SubTituloCentro">
                <th align="center">Identificación</th>
                <th align="center" colspan="2">Sexo y orientación sexual</th>
                <th></th>
            </tr>
            <tr>
                <td>
                    <input type="radio" name="rdConocido" id="rdConocido" value="0" 
                           onClick="ValidarConocido('des','frmdenunciado');"/>Desconocido<br>

                    <input type="radio" name="rdConocido" id="rdConocido" value="1" checked
                           onClick="ValidarConocido('con','frmdenunciado');"/>Conocido<br>
                </td>

                <td>
                    <input type="radio" name="rdSexo" id="rdSexo0" value="m" onClick="llenarsexo('selSexo1','m', forms.frmImputado);"/>Masculino<br>
                    <input type="radio" name="rdSexo" id="rdSexo1" value="f" onClick="llenarsexo('selSexo1','f', forms.frmImputado);"/>Femenino<br>    
                    <input type="radio" name="rdSexo" id="rdSexo2" value="x" onClick="llenarsexo('selSexo1','x', forms.frmImputado);"/>No consignado<br>
                </td>

                <td>
                    Orientación sexual<br>
                    <span id="sexo"></span>
                    <script type="text/javascript">                
                        llenarsexo('selSexo1','y', forms.frmOfendido);                                   
                    </script>  
                    <br>                
                </td>
            </tr> 
        </table>                                     
            
    <?php if (isset($_SESSION['oDenunciado'])) {
        if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't'){
            if ($oDenunciado->getConocido()== 0)
            {
        ?>
            <script type="text/javascript">
                $('input:radio[name=rdConocido]')[0].checked= true;            
            </script>
        <?php 
            }
            elseif($oDenunciado->getConocido()== 1)
            {
        ?>
            <script type="text/javascript">
                $('input:radio[name=rdConocido]')[1].checked= true;            
            </script>           
        <?php 
            }
        }
    }
    ?>
    <span id="sexo"></span>
    <script type="text/javascript">                
        llenarsexo('selSexo2','f', forms.frmDenunciado);
    </script>

    <?php if (isset($_SESSION['oDenunciado'])) {
        if ($oDenunciado->getGenero()== 'm')
        {
    ?>
        <script type="text/javascript">
            $('input:radio[name=rdSexo]')[0].checked= true;                       
        </script>
    <?php 
        }
        elseif($oDenunciado->getGenero()== 'f')
        {
    ?>          
        <script type="text/javascript">
            $('input:radio[name=rdSexo]')[1].checked= true;
        </script>
    <?php 
        }
        elseif($oDenunciado->getGenero()== 'x')
        {
    ?>          
        <script type="text/javascript">
            $('input:radio[name=rdSexo]')[2].checked= true;
        </script>                
    <?php
        }
    }
    ?>             
    <br><br>
    <!lista de denunciados ingresados >
    <table id="tblListaDenunciados" align="center" width="100%" border="0" 
           class="TablaCaja" summary="lista de denunciados">
        <tr class="SubTituloCentro"><TH colspan="4">Lista de denunciados ingresados</TH></tr>
        <tr>
        <td><span id="listaden"></span></td>
        </tr>                
    </table>  
    
    <script type="text/javascript">
    //llenar el combo denunciantes ingresados
    participante('listaden2','denunciado');    
    </script>
    <br><br>
    
    <table id="tblDenunciado1" align="center" width="100%" border="0" 
           class="TablaCaja" summary="persona natural">    
        <tr class="SubTituloCentro"><TH colspan="4">Datos Generales</TH></tr>        
        <tr class="Grid">
        <td align="right">Nombres</td>
        <td>
            <input name="txtNombres" type="text" id="txtNombres" size="25" maxlength="24"
                   value="<?php if (isset($_SESSION['oDenunciado']))
                       {  if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't' || $oDenunciado->getPersonaNatural()== 't') echo($oDenunciado->getNombreCompleto()); } ?>"/>  
        </td>   
        <td align="right">Apellidos</td>
        <td>            
            <input name="txtApellidos" type="text" id="txtApellidos" size="25" maxlength="24"
                   value="<?php if (isset($_SESSION['oDenunciado']))
                       { if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') echo($oDenunciado->getApellidoCompleto()); } ?>"/> 
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
                "<?php if (isset($_SESSION['oDenunciado'])) 
                    {
                        if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't')
                            echo $oDenunciado->getNacionalidad();
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
                $("#cboCivil").val("<?php if (isset($_SESSION['oDenunciado']))
                       { if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') echo($oDenunciado->getEstadoCivil()); } else { echo(0); } ?>");
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
                        "<?php if (isset($_SESSION['oDenunciado']))
                        { if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') 
                            echo($oDenunciado->getTipoDocumento()); }?>";

            </script>  
            <input name="txtIdentidad" type="text" id="txtIdentidad" size="15" maxlength="19" disabled
                value="<?php if (isset($_SESSION['oDenunciado']))
                { if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') echo($oDenunciado->getIdentidad()); }?>"/>                

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
                $("#cboEscolar").attr("value","<?php if (isset($_SESSION['oDenunciado']))
                       { if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') echo($oDenunciado->getEscolaridad()); } ?>");
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
                $("#cboProfe").attr("value","<?php if (isset($_SESSION['oDenunciado']))
                       { if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') echo($oDenunciado->getProfesion()); } ?>");
            </script>             
        </td>
        <td align="right">Ocupación</td>
        <td>	
            <?php
                $resOcupa= CargarOcupacion();
                combo("cboOcupa",$resOcupa,"nocupacionid","cdescripcion");
            ?>
            <script type="text/javascript">
                $("#cboOcupa").attr("value","<?php if (isset($_SESSION['oDenunciado']))
                       { if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') echo($oDenunciado->getOcupacion()); } ?>");
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
                   onfocus="QuitarAnoRango();"
                   value="<?php if (isset($_SESSION['oDenunciado']))
                       { if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') echo($oDenunciado->getEdad()); } else {echo "0" ;}?>"/> 

            &nbsp;&nbsp; 
            <!-- ojo valores en value con/des afectan "procesaDenunciado.php"-->
            <input type="radio" name="rdAno" id="rdAno0" value="con" 
                   onclick="ValidarEdadrb(this);"/>Años
            <input type="radio" name="rdAno" id="rdAno1" value="des" checked
                   onclick="ValidarEdadrb(this);"/>Desconocida
            
            <?php if (isset($_SESSION['oDenunciado']))
                   { 
                       if ($oDenunciado->getUmeDidaEdad()== 'a')
                       {
            ?>
                            <script type="text/javascript">
                                $('input:radio[name=rdAno]')[0].checked= true;
                            </script>                           
            <?php
                       }
                       else
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
            <!-- ojo los cambios en value, se deben confirmar en procedaDenunciado.php -->
            <input type="radio" name="rdRangoEdad" id="rdRangoEdad0" value="infante" 
                   onclick="ValidarRangoEdad(forms.frmDenunciado);"/>Infante
            
            <input type="radio" name="rdRangoEdad" id="rdRangoEdad1" value="adelescente" 
                   onclick="ValidarRangoEdad(forms.frmDenunciado);"/>Adolescente
            
            <input type="radio" name="rdRangoEdad" id="rdRangoEdad2" value="menoradulto" 
                   onclick="ValidarRangoEdad(forms.frmDenunciado);"/>Menor adulto
            
            <input type="radio" name="rdRangoEdad" id="rdRangoEdad3" value="adulto" 
                   onclick="ValidarRangoEdad(forms.frmDenunciado);"/>Adulto
            
            <input type="radio" name="rdRangoEdad" id="rdRangoEdad4" value="adultomayor" 
                   onclick="ValidarEdadrb(forms.frmDenunciado);"/>Adulto mayor
            
            <input type="radio" name="rdRangoEdad" id="rdRangoEdad5" value="noconsignado"
                   onclick="ValidarEdadrb(forms.frmDenunciado);"/>No consignado            
            
            <?php if (isset($_SESSION['oDenunciado']))
                   { 
                       if ($oDenunciado->getRangoEdad()== 'ni')
                       {
            ?>
                        <script type="text/javascript">
                            $('input:radio[name=rdRangoEdad]')[0].checked= true;
                        </script>  
            <?php
                       }
                       elseif ($oDenunciado->getRangoEdad()== 'na')
                       {
            ?>
                        <script type="text/javascript">
                            $('input:radio[name=rdRangoEdad]')[1].checked= true;
                        </script>        
            <?php
                       }
                       elseif ($oDenunciado->getRangoEdad()== 'nm')
                       {
            ?>
                        <script type="text/javascript">
                            $('input:radio[name=rdRangoEdad]')[2].checked= true;
                        </script> 
            <?php
                       }
                       elseif ($oDenunciado->getRangoEdad()== 'a')
                       {
            ?>
                        <script type="text/javascript">
                            $('input:radio[name=rdRangoEdad]')[3].checked= true;
                        </script> 
            <?php
                       }
                       elseif ($oDenunciado->getRangoEdad()== 'am')
                       {
            ?>
                        <script type="text/javascript">
                            $('input:radio[name=rdRangoEdad]')[4].checked= true;
                        </script>                                     
            <?php
                       }
                       elseif ($oDenunciado->getRangoEdad()== 'x') 
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
    
    <br><br>
    
    <table id="tblDenunciado3" align="center" width="100%" border="0" 
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
        <td colspan="4">
            <input name="txtDireccion" type="text" id="txtDireccion" size="80" maxlength="199"
                   value="<?php if (isset($_SESSION['oDenunciado']))
                       { if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') echo($oDenunciado->getDetalle()); } ?>"/>   
        </td>
        </tr>
        <tr class="Grid">
        <td align="right">Teléfonos</td>
        <td colspan="3">
            <input name="txtTelefono" type="text" id="txtTelefono" size="50" maxlength="49"
                   value="<?php if (isset($_SESSION['oDenunciado']))
                   { if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') echo($oDenunciado->getTelefono()); } ?>"/>
        </td>            
        </tr>         
    </table>
    
 <br><br>
    
    <!--- otros datos -->
    <table id="tblDenunciado4" align="center" width="100%" border="0" 
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
                    $("#cboEtnia").attr("value","<?php if (isset($_SESSION['oDenunciado']))
                        { if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') echo($oDenunciado->getGrupoEtnico()); } ?>");
                </script>                  
        </td>
        <td align="right">Discapacidad</td>
        <td>	<?php
                    $resDisca= CargarDiscapacidad();
                    combo("cboDiscapacidad",$resDisca,"ndiscapacidadid",
                            "cdescripcion","Seleccione una discapacidad");
                    ?>
                <script type="text/javascript">
                    $("#cboDiscapacidad").attr("value","<?php if (isset($_SESSION['oDenunciado']))
                        { if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') echo($oDenunciado->getDiscapacidad()); } ?>");
                </script>   
        </td>
        </tr>
    </table>
    <br><br>
    
    <! --delitos y faltas-- >   
    <table id="delito" align="center" width="100%" border="0" 
           class="TablaCaja" summary="delitos">    
        <tr class="SubTituloCentro"><TH colspan="4">Delitos y Faltas</TH></tr>     
        <tr class="Grid">
        <td colspan="2">
            <INPUT type="button" id="delito_agre" name="delito_agre" value="Agregar delitos y faltas" onclick=AgregarFila("delito",0);>
        </td>            
        </tr>
    </table>
    
    <!--alias-->
    <br><br>
    <table id="alias" align="center" width="100%" border="0" 
           class="TablaCaja" summary="alias">    
        <tr class="SubTituloCentro"><TH colspan="4">Alias</TH></tr>     
        <tr class="Grid">
        <td colspan="2">
            <INPUT type="button" id="alias_agre"  name="alias_agre" value="Agregar alias" onclick=AgregarFila("alias");>
        </td>          
        </tr>
    </table>
    
    <br><br>
    <!lista de denunciados ingresados >
    <table id="tblListaDenunciados" align="center" width="100%" border="0" 
           class="TablaCaja" summary="lista de denunciados">
        <tr class="SubTituloCentro"><TH colspan="4">Lista de denunciados ingresados</TH></tr>
        <tr>
        <td><span id="listaden"></span></td>
        </tr>
    </table>    

    <!--los botones para guardar persona natural-->
    <br>
    <table align="center" summary="botones persona natural">
        <tr> 
        <td><INPUT type="submit" name="btnSubmit" value="Guardar datos" onClick="CrearListaDelitosAlias();"></td>
        <td><INPUT type="button" name="btnNuevo" value="Agregar nuevo" 
                   onClick="window.location='imputado.php?btn=nuevo';"></td>    
        <td><INPUT type="button" name="btnBorrar" value="Borrar actual" 
                   onClick="BorrarRegistro(document.getElementById('txtPersonaId').value);">      
        </tr>
    </table>     
    
    </FORM>         
</div> <!--fin acordion persona natural-->    
        
<h3><a href="#">Persona Juridica</a></h3>
<div>
<form action="procesaimputado.php" method="POST"
        id="frmDenunciadoJuridico" onsubmit="return ValidarDenunciadoJuridico(this);">  
    <input type="hidden" id='DenunciadoJur' name='DenunciadoJur'>
    <input type="hidden" name="txtPersonaId" id="txtPersonaId"
                   value="<?php if (isset($_SESSION['oDenunciado']))
                       { if ($oDenunciado->getPersonaNatural()== '0') echo($oDenunciado->getPersonaId());} ?>"/>
    
    <table id="tblPersonaJuridica" align="center" width="95%" border= "0"
           class="TablaCaja" summary="datos persona natural">
        
    <tr class="SubTituloCentro"><th colspan="4">Datos generales de la empresa</th></tr>
    <tr>   
        <td align="right">Nombre de empresa o institución</td>
        
        <td><input list="txtEmpresasHn" name="txtEmpresasHn" size="30" maxlength="99" 
                   onblur="document.getElementById('DenunciadoJur').value= 'juridico';"
                   value="<?php if (isset($_SESSION['oDenunciado']))
                        { if ($oDenunciado->getPersonaNatural()== '0') echo($oDenunciado->getNombreCompleto());  } ?>"/>
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
                   value="<?php if (isset($_SESSION['oDenunciado']))
                        { if ($oDenunciado->getPersonaNatural()== '0') echo($oDenunciado->getIdentidad());  } ?>">
        </td> 
    </tr>
    <tr>
        <td align="right">Nacionalidad</td>
        <td>
            <?php
            $resNacionJ= CargarNacionalidad();
            combo("cboNacionalidadJ",$resNacionJ,"cnacionalidadid","cdescripcion");
            ?>
            <script type="text/javascript">
                document.getElementById('cboNacionalidad').value= 
                "<?php if (isset($_SESSION['oDenunciado'])) 
                    {
                        if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't')
                            echo $oDenunciado->getNacionalidad();
                    }
                    else
                    {
                        echo 'HN'; 
                    }
                ?>";
            </script>                     
        </td>        
        <td align="right">Teléfonos</td>
        <td>
            <input type="text" id="txtTelefono" name="txtTelefono" size="15" maxlength="59"
                   value="<?php if (isset($_SESSION['oDenunciado']))
                       { if ($oDenunciado->getPersonaNatural()== '0') echo($oDenunciado->getTelefono()); } ?>">
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
                   value="<?php if (isset($_SESSION['oDenunciado']))
                       { if ($oDenunciado->getPersonaNatural()== '0') echo($oDenunciado->getTxtDireccion());} ?>">
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
                           value="<?php if (isset($_SESSION['oDenunciado']))
                           { if ($oDenunciado->getPersonaNatural()== '0') echo($oDenunciado->getApoderadoNombre()); } ?>"/> 
                </td>
                <td align="right">Identificación</td>
                <td>            
                    <input name="txtColegioJ" type="text" id="txtColegioJ" size="15" maxlength="20"
                           value="<?php if (isset($_SESSION['oDenunciado']))
                           { if ($oDenunciado->getPersonaNatural()== '0') 
                               if ($oDenunciado->getTipoDocumento() != 5)
                                   echo($oDenunciado->getIdentidad());
                               else
                                   echo($oDenunciado->getApoderadoColegio());                                
                           } ?>"/>                     
                    <input name="rdTipoDoc" id="rdTipoDoc" type="radio" type="radio" value="colegio" checked>Número colegiado
                    <input name="rdTipoDoc" id="rdTipoDoc" type="radio" type="radio" value="identidad">Identidad
                    <input name="rdTipoDoc" id="rdTipoDoc" type="radio" type="radio" value="pasaporte">Pasaporte
                </td>                
            </tr>
        </table>     
    <br>
    <br>
    <! --delitos y faltas-- >   
    <table id="delitoj" align="center" width="95%" border="0" 
           class="TablaCaja" summary="delitosj">    
        <tr class="SubTituloCentro"><TH colspan="4">Delitos y Faltas</TH></tr>     
        <tr class="Grid">
        <td colspan="2">
            <INPUT type="button" id="delito_agrej" name="delito_agrej" value="Agregar delitos y faltas" onclick=AgregarFila("delitoj");>           
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
</div> <!--fin acordion-->
</div>
</body>
</html>

<script type="text/javascript">   
    
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
                    $("#cboDepto").html(data);
                    $("#cboDepto option[value="+Departamentoid+"]").attr("selected",true);
//                    $("#cboDepto").attr("value",Departamentoid);
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
    
        // direccion para persona juridica        
        function LlenaDireccionj(Departamentoid, Municipioid, AldeaId, BarrioId){
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
    
    LlenarFormulario();  
    
    //llenar el combo denunciantes ingresados
    participante('listaden2','denunciado');
    
    <?php 
        if (isset($_SESSION['oDenunciado']))
        {
    ?>
            llenadelitos();
    <?php
        }
    ?>;
    
    llenaalias();

    //saber cual radio sexo esta seleccionado: masculino, femenino
    Sexo= $('input[name=rdSexo]:checked', '#frmImputado').val();   
 
     //llenar la lista de preferencia sexual     
    <?php if (isset($_SESSION['oDenunciado'])){ ?>  
        Orientacion= "<?php echo($oDenunciado->getOrientacionSex());?>";
    <?php 
    }
    ?>
        
    llenarsexo('selSexo2',Sexo, frmImputado,Orientacion);  
    
   /*funcion: borrar un registro
    * 
     */
     function BorrarRegistro(){
        var rsp= confirm("Presione Aceptar para Borrar los datos que está viendo en pantalla.\n"+
                        "<?php echo $oDenunciado->getNombreCompleto(); ?>"+" "+
                        "<?php echo $oDenunciado->getApellidoCompleto(); ?>");
        if (rsp== true) 
            window.location="../administracion/BorrarRegistros.php?reg=denunciado&id=<?php echo $oDenunciado->getPersonaId(); ?>";
     }      
    
</script>