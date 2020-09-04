<?php session_start(); 
    $_SESSION["estado"]= "Incompleta";    
?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <div align="center"><strong><h2>¡ATENCIÓN!</h2></strong></div>
        <h3><div align="center"><strong>Los siguientes datos corresponden a una denuncia incompleta</strong></div></h3>
	<hr>
	<br>

	<table align="center">
	<caption><div align="center"><strong><u>Datos de la denuncia</u></strong></div></caption>
	<tbody align="right">
	<tr>
	<td>Usuario</td>
	<td><INPUT type="text" name="usr" id="usr" size="10"></td>
	</tr>
	<tr>
	<td>Fecha</td>
	<td><INPUT type="text" name="fecha" id="fecha" size="10"></td>
	</tr>
	<tr>
	<td>Número único</td>
	<td><INPUT type="text" name="numero" id="numero" size="10"></td>
	</tr>
	<tr>
	<td>Datos generales</td>
        <td><INPUT type="text" name="generales" id="generales" size="10"></td>
	</tr>
	<tr>
	<td>Datos del denunciante</td>
	<td><INPUT type="text" name="denunciante" id="denunciante" size="10"></td>
	</tr>
	<tr>
	<td>Datos del denunciado</td>
	<td><INPUT type="text" name="denunciado" id="denunciado" size="10"></td>
	</tr>
	<tr>
	<td>Datos del ofendido</td>
	<td><INPUT type="text" name="ofendido" id="ofendido" size="10"></td>
	</tr>
	</tbody>
	</table>

	<br><br>

	<div align="center"><em>¿Seleccione la acción a realizar?</em></div>
	<div align="center">	
	<SELECT name="accion" id="accion">
		<option value="1">Completar la denuncia</option>
		<option value="0">Ignorar denuncia</option>
     	</SELECT>
	</div>

	<script type="text/javascript">
	function ValidarSubmit()
	{

		document.getElementById("usrh").value= 
			document.getElementById("usr").value;
		document.getElementById("fechah").value=
			document.getElementById("fecha").value;
		document.getElementById("accionh").value=
			document.getElementById("accion").value;
                document.getElementById("numeroh").value=
			document.getElementById("numero").value;

		return true;
	}
	</script>
	<FORM action="../funciones/php_funciones.php" method="POST" onsubmit="return ValidarSubmit()">
                <input type="hidden" name="txtDenunciaPendiente" id="txtDenunciaPendiente">
                <script type="text/javascript">
                        document.getElementById("txtDenunciaPendiente").value= "frmpendiente";
                </script>                
		<INPUT type="hidden" name="usrh" id="usrh">
		<INPUT type="hidden" name="fechah" id="fechah">
		<INPUT type="hidden" name="accionh" id="accionh">
                <INPUT type="hidden" name="numeroh" id="numeroh">
                <INPUT type="hidden" name="banderah" id="banderah">

		<br>
		<div align="center"><INPUT type="submit" name="submit" value="Ejecutar"></div>
 	</FORM>

        <script type="text/javascript">
        document.getElementById("usr").value= "<?php echo $_SESSION['usuario'];?>";
        document.getElementById("fecha").value= "<?php echo $_SESSION['fecha'];?>";
        document.getElementById("numero").value= "<?php echo $_SESSION['denunciaid'];?>";
        document.getElementById("generales").value= 
            "<?php if ($_SESSION['generales']== 'f') echo 'Incompleto'; else echo 'Completo';?>";
        document.getElementById("denunciante").value= 
            "<?php if ($_SESSION['denunciante']== 'f') echo 'Incompleto'; else echo 'Completo';?>";
        document.getElementById("denunciado").value= 
            "<?php if ($_SESSION['denunciado']== 'f') echo 'Incompleto'; else echo 'Completo';?>";
        document.getElementById("ofendido").value= 
            "<?php if ($_SESSION['ofendido']== 'f') echo 'Incompleto'; else echo 'Completo';?>";
        </script>
    </body>
</html>