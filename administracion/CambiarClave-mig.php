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
    <FORM action="ProcesaCambiarClave.php" method="POST">
	<div align="center"><strong><h2>Cambiar Clave de Acceso</h2></strong></div>
	<br><br><br>
	<table align="center" border="1">
	<TR><TD>
	<table align="center">
	<tbody align="left">
	<tr>
	<td><strong>Clave actual:</strong></td>
	<td><INPUT type="password" name="PassActual" size="20" maxlength="50"></td>
	</tr>
	<tr>
	<td><strong>Clave nueva:</strong></td>
	<td><INPUT type="password" name="PassNueva" size="20" maxlength="50"></td>
	</tr>
	<tr>
	<td><strong>Repita nueva:</strong></td>
	<td><INPUT type="password" name="PassRepita" size="20" maxlength="50"></td>
	</tr>
	<tr><TD colspan="2"><hr></TD></tr>	
	<TR>
	<TD colspan="2" align="center">
	<INPUT type="submit" name="Cambiar" value="Cambiar">
	<INPUT type="reset" name="Cancelar" value="Cancelar"></TD>
	</TR>
	</tbody>
	</table>
	</TD></TR>
	</table>	

    </FORM>
        <?php
        // put your code here
        ?>
    </body>
</html>
