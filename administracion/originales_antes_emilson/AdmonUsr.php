<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
	//funcion generar combo
	include("../clases/controles/funct_select.php");

	//funciones genericas php
	include "../funciones/php_funciones.php";
?>

<html>

<head>
  <title></title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link type="text/css" rel="stylesheet" href="../css/Estilos.css"> 
  <script type="text/javascript" src="../java_script/jquery-1.5.1.min.js"></script>
  <script type="text/javascript" src="../java_script/jquery-ui-1.8.12.custom.min.js"></script>

  <script type="text/javascript">
	function Accion(Data){		
                document.getElementById('txtAccion').value= Data;
                if (Data== 'crear'){
                    if (document.getElementById('NomPropio').value == "" ||
                        document.getElementById('NomUsr').value == "" ||
                        document.getElementById('cboDependencia').value == 0){
                        alert("No deben haber campos en blanco")
                    }
                    else{			
                        frmCambiar.submit();
                    }
                }
                else{
                    frmCambiar.submit();
                }
	}

	function CargarDependencia(dato){
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
            		}
		})
	}

	function CargarBandeja(dato){
		//if ($(chkBandeja).val()== "bandeja")
		if ($('input[name=chkBandeja]').attr('checked'))
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
					document.getElementById('txtBandeja').value= "SiBandeja";
				}
			})
		else{
			$("#cboUsaBandeja option").remove();
			document.getElementById('txtBandeja').value= "NoBandeja";
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
	<tr class="TrBlanco"><TD>
		<table id="Campos" align="center" border="0" >
		<tbody>
			<tr>
			<td align="right">Nombre propio:</td>
			<td>
				<INPUT type="text" name="NomPropio" id= "NomPropio" size="30" maxlength="50">
				<INPUT type="button" name="btnBuscar1" id="btnBuscar1" value="Buscar">
			</td>
			</tr>
			<tr align="right">
			<td>Nombre usuario:</td>
			<td>
				<INPUT type="text" name="NomUsr" id= "NomUsr" size="30" maxlength="30">	  
				<INPUT type="button" name="btnBuscar2" id="btnBuscar2" value="Buscar">
			</td>
			</tr>
			<tr align="right">
			<td>Bandeja denuncias:</td>
			<td align="left">                            
				<select name="cboUsaBandeja" id="cboUsaBandeja">
				</select>  
				<input type="hidden" name="txtBandeja" id="txtBandeja" value="NoBandeja">
				<INPUT type="checkbox" name="chkBandeja" id="chkBandeja" value="Bandeja" onclick="CargarBandeja('bandeja')">
			</td>                        
			</tr>
			<tr align="center">
			<td colspan="2">
				<input type="radio" name="lugar" id="lugar" onclick="CargarDependencia('receptor')">Receptor de denuncia

				<input type="radio" name="lugar" id="lugar" onclick="CargarDependencia('fiscal')">
				Fiscal
			</td>
			<tr align="center">
			<td colspan="2">
				<select name="cboDependencia" id="cboDependencia">
				</select>	
			</td>
			</tr>
		</tbody>
		</table>
	</TD></tr>
	</tbody>
	</table>
	
	<br><br>
	<table align="center" border="0" >
	<tr class="TrBlanco">
	<td colspan="2" align="center">
		<INPUT type="hidden" name="txtAccion" id="txtAccion">
		<INPUT type="button" name="btnGenerar" value="Generar clave" onclick="Accion('generar');">
		<INPUT type="button" name="btnCrear" value="Crear usuario" onclick="Accion('crear');">
	</td>
	</tr>
	</table>
	</table>
</FORM>
</body>
</html>