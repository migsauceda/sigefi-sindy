<!-- inclusion de archivos -->
<!--controles para los campos del formulario y conexion-->
<?php 	
    include "../clases/Usuario.php";

    session_start(); 

    //funciones genericas
    include "../funciones/php_funciones.php";

    if (isset($_SESSION['objUsuario'])){
        $objUsuario= $_SESSION['objUsuario'];        
    }else{
        header("location:index.php");
    }
    
    
        //valida si esta conectado
//        if (!isset($_SESSION['usuario'])){	
//            header("location:index.php");
//        }        
             

        //valida derechos
        if ($objUsuario->getPermiso(5)== '0'){ 
            ?>
            <script type="text/javascript">
            alert("No tiene acceso a esta opción");    
            top.location = "../aplicacion.php";     
            </script>    
            <?php
        }        
               
    include("../clases/controles/funct_text.php");
    include("../clases/controles/funct_select.php");	
    include("../clases/controles/funct_radio.php");
    include("../clases/controles/funct_check.php");
//echo "entra2"; exit();
//	include("../clases/class_conexion_pg.php");  
        
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>actividad fiscal</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="select_dependientes_3_niveles.css">
<script type="text/javascript" src="select_dependientes_3_niveles.js"></script>
<!--variables para cookees-->
<script type="text/javascript">
	var imputados= 1;
</script>
   
    <link type="text/css" rel="stylesheet" href="../css/Estilos.css">
    <script type="text/javascript" src="../java_script/funciones.js"></script>

    <!-- jquery -->
    <link href="../java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
    <link href="../java_script/css/smoothness/jquery.datetimepicker.css" rel="stylesheet" type="text/css">
    <script src="../java_script/js/jquery-1.10.2.js"></script>
    <script src="../java_script/js/jquery-ui-1.10.4.custom.js"></script>     
    <script src="../java_script/js/jquery.datetimepicker.js"></script>                 
</head>
<style type="text/css">
    .ui-datepicker {
        font-size: 11px;
        margin-left:10px
     }     
</style>
<body>
<script type="text/javascript">
    $(function(){
        $("#txtFecha").datetimepicker({
            format:'d/m/Y H:m',
            formatTime:'H:m',
            formatDate:'DD/MM/YYYY'
        });
    });   
</script>

<strong><div align="center">Actividad (Diligencias)</div></strong>

<script type="text/javascript">
<?php if (ExisteDenunciaRAM()== "false"){ ?>
            alert("Se requiere una denuncia, utilice el menu Búsqueda");
            parent.document.location.href= '../aplicacion.php';
<?php } ?>
</script>


<!--javas scripts para llenar los combos-->
<script type="text/javascript">
//nombre fiscal -->
function AJAX(opcion)
{	
    /* valores de la variable opcion
     *  1: recuperar nombre de fiscal
     *  2: llenar combo subetapa
     *  3: llenar combo actividad
     */ 
    
    if (opcion== 1){
        $.ajax({
            data:       "opcion="+opcion+"&imputado="+$('#cboImputado').val(),
            type:       "POST",
            datatype:   "json",
            url:    "../funciones/ajax_ActividadFiscal.php",
            error: function (XMLHttpRequest, textStatus, errorThrown){
                alert("Error al cargar datos para las listas");
            },
            success: function(json_obj){ //alert(json_obj);
                //nombre completo del fiscal
                json_txt= JSON.parse(json_obj);
                $('#txtFiscal').val(json_txt.nombref);
                $('#txtFiscalid').val(json_txt.identidad);
            }
        })
         $.ajax({
            data:       "opcion="+opcion+"&imputado="+$('#cboImputado').val(),
            type:       "POST",
            dataType: "html",
            url: "../funciones/ajax_DelitoImputado.php",
                error: function(obj, que, otro){
                    alert("Error ajax al cargar lista de participante (denunciante, ofendido, imputado)");
                },
                success: function(data){  
                    $("#lstDelito").html(data);
                }
            }); 
               
        
    }

    if(opcion== 2){
        $.ajax({
            data:       "opcion="+opcion+"&etapa="+$('#cboEtapa').val(),
            type:       "POST",
            datatype:   "html",
            url:    "../funciones/ajax_ActividadFiscal.php",
            error: function (XMLHttpRequest, textStatus, errorThrown){
                alert("Error al cargar datos para las listas");
            },
            success: function(combo){
                //combo subetapa
                $('#cboSubEtapa').html(combo);
            }
        })	     
    }
    
    if(opcion== 3){
        $.ajax({
            data:       "opcion="+opcion+"&subetapa="+$('#cboSubEtapa').val()+"&etapa="+$('#cboEtapa').val(),
            type:       "POST",
            datatype:   "html",
            url:    "../funciones/ajax_ActividadFiscal.php",
            error: function (XMLHttpRequest, textStatus, errorThrown){
                alert("Error al cargar datos para las listas");
            },
            success: function(combo){
                //combo subetapa
		
                $('#cboActividad').html(combo);
            }
        })	     
    }    
}
</script>

<script type="text/javascript">
//llama las funciones para llenar los campos y hace submit-->
function Antesdesubmit(){
    Ok= true;
    CamposFaltantes= "";
    if (document.getElementById("txtFecha").value== "")
    {
        Ok= false;
        CamposFaltantes= "Fecha en la que se hace la acción";
    }
    
    if (document.getElementById("txtFiscal").value== "")
    {
        Ok= false;
        CamposFaltantes= CamposFaltantes + "Fiscal que hace la acción\n";
    }
    
    if (document.getElementById("cboMateria").value== "0")
    {
        Ok= false;
        CamposFaltantes= CamposFaltantes + "Matéria\n";
    }
    
    if (document.getElementById("cboEtapa").value== "0")
    {
        Ok= false;
        CamposFaltantes= CamposFaltantes + "Etapa\n";
    }

    if (document.getElementById("cboSubEtapa").value== "0")
    {
        Ok= false;
        CamposFaltantes= CamposFaltantes + "Sub Etapa\n";
    }
    
    if (Ok== false)
    {
        alert("La siguiente información es requerida: \n"+CamposFaltantes);
    }
    return Ok;
}
</script>

<br><br>
<FORM action="procesaactividad.php" method="POST" id="frmActividad"  enctype="multipart/form-data" onsubmit="return Antesdesubmit()">
    <table align="center" width="95%" border="0" id="tblGenerales" class="TablaCaja">
  <tbody>
    <tr class="SubTituloCentro">
        <th colspan="4">Generales</th>
    </tr>
    <tr>
      <td width="25%"><div align="right"><strong>Fecha en la que se hace <br>la diligencia fiscal</strong></div></td>
      <td width="20%"><input name="txtFecha" type="text" id="txtFecha" size="17" maxlength="16" required/>
      </td>
      <td width="30%"><div align="right"><strong>Fiscal que hace <br>la diligencia</strong></div></td>
      <td>
	<?php cajaTexto("txtFiscal",30,"","readonly='true'");?>
	<INPUT type="hidden" name="txtFiscalid" id="txtFiscalid" size="2">
      </td>
    </tr>
    <tr>
      <td><div align="right"><strong>Imputado o Niño Infractor</strong></div></td>
      <td colspan="3">
	<?php
            $resImputado= CargarImputados();
            combo("cboImputado",$resImputado,"tpersonaid","cnombrecompleto","1","onchange='AJAX(1)'");
	?>      
      </td>
    </tr>
  </tbody>
</table>
    <br>
    <table align="center" width="95%" border="0" id="tblGenerales" class="TablaCaja">
  <tbody>
    <tr class="SubTituloCentro">
        <th colspan="4">Delitos</th>
    </tr>
    <tr>
      <td width="25%"><span id="lstDelito"></span></div></td>
      <td width="20%"></td>
    </tr>
  </tbody>
</table>
<br>
<table align="center" width="95%" border="0" id="tblActividad" class="TablaCaja">
    <tbody>
        <!--materia -->
        <tr class="SubTituloCentro">
            <th colspan="2">Datos de la Materia</th>
        </tr>        
        <tr>
            <td width="25%">
            <div align="right"><strong>Materia</strong></div>
          </td>
          <td>
            <?php
                $resMateria= CargarMateria();
                combo("cboMateria",$resMateria,"nmateria","cdescripcion");
            ?>
          </td>
        </tr>
        <!--etapa -->
        <tr>
          <td>
            <div align="right"><strong>Etapa</strong></div>
          </td>
          <td>
            <?php
                $resEtapa= CargarEtapa();
                combo("cboEtapa",$resEtapa,"netapaid","cdescripcion","","onchange='AJAX(2)'");
            ?>
          </td>
        </tr>
         <!--actividad -->
        <tr>
          <td>
            <div align="right"><strong>Subetapa</strong></div>
          </td>
          <td>
            <?php
                    combo("cboSubEtapa",$resSubEtapa,"nsubetapaid","cdescripcion","","onchange='AJAX(3)')");
            ?>
          </td>
        </tr>
        <!--actividad 2 -->
        <tr>
          <td>
            <div align="right"><strong>Actividad</strong></div>
          </td>
          <td>
            <?php
                    combo("cboActividad",$resActividad,"nactividadid","cdescripcion");
            ?>
          </td>
        </tr>
    </tbody>
</table>
 <br>
    <table align="center" width="95%" border="0" id="tblGenerales" class="TablaCaja">
  <tbody>
    <tr class="SubTituloCentro">
        <th colspan="4">Documento Relacionado</th>
    </tr>
    <tr>
        <td width="25%"><div>
                <strong>Descripcion del Archivo</strong><br />
                <input type="text" id="desc" name="desc" size="55"/><br />
                <strong>Archivo</strong><br />
                <input type="file" name="archivoa" id="archivoa" />
            </div></td>
      <td width="20%"></td>
    </tr>
  </tbody>
</table>

<br>
<table align="center">
  <tbody>
    <tr>
      <td><INPUT type="submit" name="btnSubmit" value="Guardar datos"></td>
      <!--<td><INPUT type="reset" name="btnReset" value="Limpiar campos"></td>-->
    </tr>
  </tbody>
</table>
</FORM>
</body>
</html>
