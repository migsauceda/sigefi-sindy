<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
	//funcion generar combo
	include("../clases/controles/funct_select.php");

	//funciones genericas php
	include "../funciones/php_funciones.php";        
    
        if (isset($_GET[codigo])){
            $codigo= $_GET[codigo];            
            
            if($codigo == 0){
                echo "<script type='text/javascript'>  
                  alert('Operación exitosa');
                  </script>";
            }
            else{
                $Descripcion= "Error: ".$_GET[descripcion];
                echo "<script type='text/javascript'>  
                  alert($Descripcion);
                  </script>";                
            }
        }           
?>

<html>

<head>
  <title></title>
  <meta name="generator" content="Bluefish 2.2.3" >
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link type="text/css" rel="stylesheet" href="../css/Estilos.css"> 
  
        <!-- jquery -->
	<link href="../java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
	<script src="../java_script/js/jquery-1.10.2.js"></script>
	<script src="../java_script/js/jquery-ui-1.10.4.custom.js"></script>  
        
  <script type="text/javascript">  
        var codigo= <?php if (isset($codigo)){ echo $codigo;}else{ echo 0;} ?>;

        if (codigo > 0) {
            Descripcion= '<?php echo $Descripcion; ?>';
            alert(Descripcion);
        }

	var contador=0;
	function Accion(){
            if (document.getElementById("actualizar").checked== true)
                Data= "actualizar";  //actualiza info usr

            if (document.getElementById("cambiar").checked== true)
                Data= "generar"; //cambia password

            if (document.getElementById("usuario").checked== true)
                Data= "crear"; //crea nuevo usr             
            
            if (document.getElementById("inactivar").checked== true)
                Data= "inactivar"; //activar /inactivar usr

            document.getElementById('txtAccion').value= Data; 
            
            if (Data== 'crear'){ //crear usr
                if (document.getElementById('NomPropio').value == "" || //validar
                    document.getElementById('NomUsr').value == "" ||
//                    document.getElementById('cboDependencia').value == 0 || 
                                            document.getElementById('identidad').value == "" ||
                                            document.getElementById('pass').value=="" || 
                                            document.getElementById('passR').value=="" ||
                                            document.getElementById('cboPerfil').value==0) {
                    alert("No deben haber campos en blanco");
                    return;
                }
                valor= document.getElementById('identidad').value;
                if (!(/^\d{4}-\d{4}-\d{5}$/.test(valor))){
                    alert("El número de tarjeta identidad está mal escrito");
                    return;
                }                
            }
            
            //modificar perfil
//            if (Data== 'actualizar'){
//                if (document.getElementById('NomPropio').value == "" || //validar
//                    document.getElementById('NomUsr').value == "" ||                
//            }
            
            //verifica clave
            if (Data== 'crear' || Data== 'generar'){
                Guardar= 0;
                //crear o cambiar usr con datos ok
                if (document.getElementById('passR').value!=document.getElementById('pass').value){
                        alert('Las contraseñas no coinciden')
                        document.getElementById('pass').value=""
                        document.getElementById('passR').value=""                                           
                }
                else{                  
                    Clave= document.getElementById('passR').value; 
                    Especial= false; Numero= false; Mayuscula= false; Minuscula= false; 
                    if (Clave.length >= 8)
                        Conta= true;
                    else
                        Conta= false;
                    for(i= 0; i < Clave.length; i++){
                        Codigo= Clave.charCodeAt(i);
                        //caracter especial
                        if (Codigo >= 33 && Codigo <= 47){
                            Especial= true;
                        }
                        //numero
                        if (Codigo >= 48 && Codigo <= 57){
                            Numero= true;
                        }
                        //mayuscula
                        if (Codigo >= 65 && Codigo <= 90){
                            Mayuscula= true;
                        }                               
                        //minuscula
                        if (Codigo >= 97 && Codigo <= 122){
                            Minuscula= true;
                        }                                             
                    }
                    if (!(Especial && Numero && Mayuscula && Minuscula && Conta)){
                        alert("La clave debe contener al menos 8 caracteres entre especiales números, letras mayúsculas, minúsculas");
                    }
                    else{
                        Guardar= 1;
                    }
                }
            }
            
            if (Data== 'inactivar' || Data== 'actualizar'){
                Guardar= 1;
            }
            
            if (Guardar== 1)
                frmCambiar.submit();
        }

    function CargarDependencia(dato, valor){ 
        if (valor === undefined) valor= -1;
        $.ajax({
                data: "accion="+dato,
                type: "POST",
                dataType: "html",
                url: "../funciones/ajax_admonusr.php",
                error: function(objeto, quepaso, otroobj){
                        alert("Error al cargar Fiscalias");
                },
                success: function(data){
                    $("#cboDependencia").html(data);
                    document.getElementById("cboDependencia").value= valor;

                    //bandeja
                    $.ajax({
                        data:"accion=bandeja"+"&valor="+valor,
                        type: "POST",
                        dataType: "html",
                        url: "../funciones/ajax_admonusr.php",
                        error: function(objeto, quepaso, otroobj){
                            alert("Error al cargar Sub Bandeja");
                        },
                        success: function(data){                                
                            $("#cboUsaBandeja").html(data);
                            document.getElementById('txtBandeja').value= "SiBandeja";

                            //subbandeja
                            $.ajax({
                                data:"accion=subbandeja"+"&valor="+valor,
                                type: "POST",
                                dataType: "html",
                                url: "../funciones/ajax_admonusr.php",
                                error: function(objeto, quepaso, otroobj){
                                    alert("Error al cargar Sub Bandeja");
                                },
                                success: function(data){                                
                                    $("#cboSubBandeja").html(data);
                                    document.getElementById('txtBandeja').value= "SiBandeja";

                                    CargarPerfil('perfil');                                    
                                }
                             })                        
                        }
                    })
                }
        })
    }
        
  function CargarPerfil(dato, valor){ 
      if (valor === undefined) valor= -1;
      $.ajax({
          data: "accion="+dato+"&valor="+valor,
          type: "POST",
          dataType: "html",
          url: "../funciones/ajax_admonusr.php",
          error: function(objeto, quepaso, otroobj){
                  alert("Error al cargar Perfiles");
          },
          success: function(data){ 
                $("#cboPerfil").html(data);
                  
                document.getElementById('cboPerfil').value= valor;
          }                
      })
  }
   
    function CargarBandeja(dato, bandeja, subbandeja, perfil){
        //if ($(chkBandeja).val()== "bandeja")
        if (bandeja === undefined) bandeja= -1;
        if (subbandeja === undefined) subbandeja= -1;
        if (perfil === undefined) perfil= -1;
        $.ajax({
                data: "accion="+dato,
                type: "POST",
                dataType: "html",
                url: "../funciones/ajax_admonusr.php",
                error: function(objeto, quepaso, otroobj){
                        alert("Error al cargar Bandeja");
                },
                success: function(data){
                    $("#cboUsaBandeja").html(data);             
                    document.getElementById('cboUsaBandeja').value= bandeja;

                    //subbandeja
                    $.ajax({
                        data:"accion=subbandeja"+"&valor="+bandeja,
                        type: "POST",
                        dataType: "html",
                        url: "../funciones/ajax_admonusr.php",
                        error: function(objeto, quepaso, otroobj){
                            alert("Error al cargar Sub Bandeja");
                        },
                        success: function(data){
                            $("#cboSubBandeja").html(data);
                            document.getElementById('cboSubBandeja').value= subbandeja;
                            CargarPerfil('perfil', perfil);                                                        
                        }
                    })
                }
        }) 
    }

    function filtrarUsuarios(){
        filtro=document.getElementById('NomUsr').value;		
        if (filtro!=""){
                contador++;
                if(contador%2==0){
                        divResultado = document.getElementById('divUsuarios');
                        ajaxf=objetoAjax();
                        ajaxf.open("GET", 'consulta_filtro_usr.php?filtro='+filtro+'&campo=usr');
                        ajaxf.onreadystatechange=function() {
                                if (ajaxf.readyState==4) {
                                        divResultado.innerHTML=ajaxf.responseText;
                                }
                        }
                        ajaxf.send(null)
                }
        }else{
                contador=0	
        }
    }
    
    function filtrarNombreUsr(){		
        filtro=document.getElementById('NomPropio').value;
        if (filtro!=""){
                contador++;
                if(contador%2==0){
                        divResultado = document.getElementById('divNombre');
                        ajaxf=objetoAjax();
                        ajaxf.open("GET", 'consulta_filtro_nombUsr.php?filtro='+filtro+'&campo=nombre');
                        ajaxf.onreadystatechange=function() {
                                if (ajaxf.readyState==4) {
                                        divResultado.innerHTML=ajaxf.responseText;
                                }
                        }
                        ajaxf.send(null)
                }
        }else{
                contador=0	
        }
    }
    
    function filtrarApellidoUsr(){		
        filtro=document.getElementById('ApePropio').value;
        if (filtro!=""){
                contador++;
                if(contador%2==0){
                        divResultado = document.getElementById('divApellido');
                        ajaxf=objetoAjax();
                        ajaxf.open("GET", 'consulta_filtro_nombUsr.php?filtro='+filtro+'&campo=apellido');
                        ajaxf.onreadystatechange=function() {
                                if (ajaxf.readyState==4) {
                                        divResultado.innerHTML=ajaxf.responseText;
                                }
                        }
                        ajaxf.send(null)
                }
        }else{
                contador=0	
        }
    }    
    
    function objetoAjax(){			
        var xmlhttp=false;
        try {
                        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
                        try {
                           xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                        } catch (E) {
                                        xmlhttp = false;
                        }
        }
        if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
                        xmlhttp = new XMLHttpRequest();
        }
        return xmlhttp;
    }
    
    function mostrarNombreUsr(campo){ 
        if(campo== 'usr'){
            datos= document.getElementById('cboUsuario').value;
        }else if(campo== 'nombre'){
            datos= document.getElementById('cboNombre').value;
        }else {
            datos= document.getElementById('cboApellido').value;
        }     
        $.ajax({
                data: "usr="+datos,
                type: "POST",
                dataType: "text",
                url: "../administracion/consulta_dato_completousr.php",
                error: function(objeto, quepaso, otroobj){
                        alert("Error al cargar datos del usuario");
                },
                success: function(data){  
                    var objjson= JSON.parse(data);

                    document.getElementById("NomPropio").value= 
                        objjson.usuariodata[0].nombres;

                    document.getElementById("ApePropio").value= 
                        objjson.usuariodata[0].apellidos;                                

                    document.getElementById("NomUsr").value= 
                        objjson.usuariodata[0].usuario;

                    document.getElementById("identidad").value= 
                        objjson.usuariodata[0].identidad;                            

                    //bandeja denuncias
                    document.getElementById("chkBandeja").checked= true;
                    CargarBandeja('bandeja', objjson.usuariodata[0].ibandejaid, objjson.usuariodata[0].isubbandejaid, objjson.usuariodata[0].rol);
                    
                    //Es fiscal o no
                    if(objjson.usuariodata[0].fiscal== 't'){
                        document.getElementById('chkFiscal').checked= true;
                    }
                    else{
                        document.getElementById('chkFiscal').checked= false;
                    }
                    
                    //activo o no
                    if(objjson.usuariodata[0].activo== 't'){
                        document.getElementById('chkUsrActivo').checked= true;
                    }
                    else{
                        document.getElementById('chkUsrActivo').checked= false;
                    }
                }
        })            
    }
    
    function mostrarUsr(){            
        document.getElementById('NomUsr').value=document.getElementById('cboUsuario').value;
        CargarInformacion(document.getElementById('NomUsr').value, 'usr');
    } 
        
    function ActivarCampos(activar){ 
        //se deshabilitan todos por si se esta cambiando de rdbutton
        document.getElementById("NomPropio").disabled= true;
        document.getElementById("ApePropio").disabled= true;
        document.getElementById("NomUsr").disabled= true;

        document.getElementById("chkBandeja").disabled= true;             

        document.getElementById("cboPerfil").disabled= true;  
        document.getElementById("cboUsaBandeja").disabled= true;            
        document.getElementById("cboSubBandeja").disabled= true; 
        
        document.getElementById("identidad").disabled= true;
        document.getElementById("pass").disabled= true;
        document.getElementById("passR").disabled= true;  
        
        //ahora se habilitan
        document.getElementById("NomPropio").disabled= false;
        document.getElementById("ApePropio").disabled= false;
        document.getElementById("NomUsr").disabled= false;
        
        document.getElementById("chkUsrActivo").disabled= true;
        
        if (activar== 'inactivar'){ 
            document.getElementById("chkUsrActivo").disabled= false;
        }
        
        if (activar== 'actualizar'){ 
            //actualizar perfil                
//            document.getElementById("chkPerfil").disabled= false;  
            document.getElementById("chkBandeja").disabled= false;       
//            document.getElementById("chkSubBandeja").disabled= false;     
//            document.getElementById("chkLugar").disabled= false;        
            
            document.getElementById("cboPerfil").disabled= false;  
            document.getElementById("chkFiscal").disabled= false;             
            document.getElementById("cboUsaBandeja").disabled= false;  
            document.getElementById("cboSubBandeja").disabled= false;   
        }
        if (activar== 'cambiar'){ 
            //cambiar clave de acceso
            document.getElementById("pass").disabled= false;
            document.getElementById("passR").disabled= false;
        }
        if (activar=='usuario'){
            //crear usuario  
            document.getElementById("identidad").disabled= false;
            document.getElementById("pass").disabled= false;
            document.getElementById("passR").disabled= false;

//            document.getElementById("chkPerfil").disabled= false;  
            document.getElementById("chkBandeja").disabled= false;   
//            document.getElementById("chkSubBandeja").disabled= false;   
//            document.getElementById("chkLugar").disabled= false;

            document.getElementById("cboPerfil").disabled= false;  
//            document.getElementById("cboDependencia").disabled= false;             
            document.getElementById("cboUsaBandeja").disabled= false;
            document.getElementById("cboSubBandeja").disabled= false;   
            
            document.getElementById("NomPropio").disabled= false;
            document.getElementById("ApePropio").disabled= false;
            document.getElementById("NomUsr").disabled= false;            
            
            document.getElementById("chkFiscal").disabled= false;
        }
        }
  </script>
</head>

<body>    
<br><br><br>
<div align="center"><strong><h2>Administrar Usuario</h2></strong></div>

<FORM action="ProcesaNuevoUsr.php" method="POST" name="frmCambiar" id="frmCambiar">  
    <table id="Borde" align="center" border="0" class="EstiloTabla" cellspacing="1" cellpading="0">
    <tbody>
    <tr>
        <td colspan="2">
            <input type="radio" name="admin" value="actualizar" id="actualizar" onclick="ActivarCampos('actualizar');">Actualizar perfil
            <input type="radio" name="admin" value="cambiar" id="cambiar" onclick="ActivarCampos('cambiar');">Cambiar Clave
            <input type="radio" name="admin" value="usuario" id="usuario" onclick="ActivarCampos('usuario');">Crear Usuario
            <input type="radio" name="admin" value="inactivar" id="inactivar" onclick="ActivarCampos('inactivar');">Inactivar/activar Usuario<br><br>
        </td>
    </tr>
    </tbody>
    </table>
    <table align="center" id="Borde2" border="0" class="EstiloTabla" cellspacing="1" cellpading="0">
    <tbody>
    <tr class="TrBlanco">
        <td>
            <tr>
            <td align="right">Usuario activo:</td>
                <td>
                    <INPUT type="checkbox" name="chkUsrActivo" id= "chkUsrActivo" disabled>                        
                </td>            
            </tr>
            
            <tr>
                <td align="right">Nombre propio:</td>
                <td>
                    <INPUT type="text" name="NomPropio" id= "NomPropio" size="30" maxlength="50" onKeyUp="filtrarNombreUsr()" disabled>
                    <INPUT type="button" name="btnBuscar1" id="btnBuscar1" value="Buscar">
                </td>            
            </tr>
            
            <tr>
                <td></td>
                <td>
                    <div id="divNombre">
                    <select id="cboNombre" name="cboNombre" size="5" multiple style="width:100%">
                    </select>
                    </div>
                </td>                
            </tr>
            
                <tr>
                <td align="right">Apellido propio:</td>
                <td>
                        <INPUT type="text" name="ApePropio" id= "ApePropio" size="30" maxlength="50" onKeyUp="filtrarApellidoUsr()" disabled>
                        <INPUT type="button" name="btnBuscar1" id="btnBuscar1" value="Buscar">
                </td>
                </tr>

                <tr>
                <td></td>
                <td>
                    <div id="divApellido">
                    <select id="cboApellido" name="cboApellido" size="5" multiple style="width:100%">
                    </select>
                    </div>
                </td>
                </tr>
                
                <tr>
                <td align="right">Nombre usuario:</td>
                <td>
                    <INPUT type="text" name="NomUsr" id= "NomUsr" size="30" maxlength="30" onkeyup="filtrarUsuarios()" disabled>
                    <INPUT type="button" name="btnBuscar2" id="btnBuscar2" value="Buscar">
                </td>
                </tr>

                <tr>
                <td></td>
                <td align="right">	  
                    <div id="divUsuarios">
                    <select id="cboUsuario" name="cboUsuario" size="5" multiple style="width:100%">
                    </select>
                    </div>                    
                </td>
                </tr>

                <tr>
                    <td align="right">Contrase&ntilde;a:</td>
                    <td><INPUT type="password" name="pass" id="pass" size="30" disabled></td>
                </tr>

                <tr>
                    <td align="right">Repita Contrase&ntilde;a:</td>
                    <td><INPUT type="password" name="passR" id="passR" size="30" disabled></td>
                </tr>

                <tr>
                    <td align="right">Vencimiento de Contrase&ntilde;a:</td>
                    <td><INPUT type="date" name="Vence" id="Vence" size="30" disabled></td>
                </tr>

                <tr>
                    <td align="right">Tarjeta de Identidad:</td>
                    <td><INPUT type="text" name="identidad" id="identidad" size="30" maxlength="15" disabled>
                        <br>
                        Usar guiones
                    </td>
                </tr>                             
                
<!--                <tr align="right">
                    <td>Lugar de trabajo:</td>
                    <td align="left">                            
                        <select name="cboDependencia" id="cboDependencia" onchange="CargarDependencia('lugar', this.value)">
                        </select>  
                        <input type="hidden" name="txtLugarTrabajo" id="txtLugarTrabajo" value="NoLugar">				
                        <INPUT type="checkbox" name="chkLugar" id="chkLugar" value="Lugar" onclick="CargarDependencia('lugar')" disabled>                                
                    </td>                        
                </tr> -->
                
                <tr align="right">                           
                    <td>Bandeja:</td>
                    <td align="left">                            
                        <select name="cboUsaBandeja" id="cboUsaBandeja" onchange="CargarBandeja('bandeja', this.value)">
                        </select>  
                        <input type="hidden" name="txtBandeja" id="txtBandeja" value="NoBandeja">
                        <INPUT type="checkbox" name="chkBandeja" id="chkBandeja" value="Bandeja" onclick="CargarBandeja('bandeja')">
                    </td>                        
                </tr>    
                
                <tr align="right">                                                
                    <td>Sub Bandeja:</td>
                    <td align="left">                            
                        <select name="cboSubBandeja" id="cboSubBandeja" disabled>
                            </select>  
                            <input type="hidden" name="txtSubBandeja" id="txtSubBandeja" value="NoBandeja">
                            <INPUT type="checkbox" name="chkSubBandeja" id="chkSubBandeja" value="SubBandeja" disabled>                            
                    </td>                        
                </tr>  
                
                <tr align="right">
                    <td>Rol:</td>
                    <td align="left">                            
                            <select name="cboPerfil" id="cboPerfil" disabled>
                            </select>  
                            <input type="hidden" name="txtPerfil" id="txtPerfil" value="NoPerfil">
                            <INPUT type="checkbox" name="chkPerfil" id="chkPerfil" value="Perfil" onclick="CargarPerfil('perfil')" disabled>                                
                    </td>                        
                </tr>                    

                <tr align="right">
                    <td>El usuario es fiscal:</td>
                    <td align="left">                             
                            <input type="hidden" name="txtFiscal" id="txtFiscal" value="NoLugar">				
                            <INPUT type="checkbox" name="chkFiscal" id="chkFiscal" value="Fiscal" disabled>                                
                    </td>                        
                </tr>             
                
<!--                observaciones:
                1.es posible que el lugar de toma de denuncia no sea la fiscalia
                2.se quiere tener separado el personal fiscal y el admon (receptor de denuncias)
                3.no necesariamente el receptor trabajara en una fiscalia-->

<!--                <tr align="right">
                    <td>Lugar de trabajo del nuevo<br> usuario según su cargo</td>
                    <td>                            
                        <input type="radio" name="lugar" id="lugar1" onclick="CargarDependencia('receptor')" disabled>Receptor de denuncia (Lugares donde se reciben)
                    </td>
                </tr>
                <tr align="right">
                    <td></td>
                    <td>
                        <input type="radio" name="lugar" id="lugar2" onclick="CargarDependencia('fiscal')" disabled>Fiscal (Lista de fiscalias)
                    </td>
                </tr>-->
                
        </td>
    </tr>
    </tbody>
    </table>
    <table align="center" border="0" >
    <tr class="TrBlanco">
    <td colspan="2" align="center">
            <INPUT type="hidden" name="txtAccion" id="txtAccion">
            <input type="hidden" name="txtTipoUsr" id="txtTipoUsr">
            <INPUT type="button" name="btnEjecutar" value="Ejecutar" onclick="Accion();">
    </td>
    </tr>
    </table>    
</FORM>
</body>
</html>