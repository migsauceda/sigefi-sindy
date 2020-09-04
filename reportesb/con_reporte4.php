<?php session_start();
	include('conexion/cls_conexion.php');
?>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <script language='javascript' src="js/popcalendar.js"></script> 
        <script type="text/javascript" src="js/eventos.js"></script>
        <script type="text/javascript" src="js/tabla4.js"></script>
    </head>
    <body>
<h3 style="text-transform:uppercase"><center>Frecuencia de denuncias asignadas por fiscal&iacute;a, por rango de fechas y estado</center></h3><br><br>
<center><table border="1" id="tabla">
<tr>
	<th></th>
	<th align="center">Fiscal&iacute;a</th>
	<th align="center">Fecha Inicial</th>
    <th align="center">Fecha Final</th>
    <th align="center">Estado</th>
</tr>
<tr>
	<td>1</td>
    <td><select id="fiscalia1" name="fiscalia1">
    		<?php 
				$conexion=new cls_conexion();
				$conexion->conectar();
				$resultado=$conexion->consultar("select * from tbl_fiscalia");
				echo "<option value='---'>---</option>";
				echo "<option value='todas'>Todas</option>";
				while ($row=pg_fetch_assoc($resultado)){	
					echo "<option value='$row[nfiscaliaid]'>$row[cdescripcion]</option>";
				}
			?>
    	</select>
    </td>
	<td align="center"><input name="fechaIni1" id="fechaIni1" type="text" size="10" readonly><input type="button" value="..." onClick="popUpCalendar(this, fechaIni1, 'yyyy-mm-dd');"></td>
    <td align="center"><input name="fechaFin1" id="fechaFin1" type="text" size="10" readonly><input type="button" value="..." onClick="popUpCalendar(this, fechaFin1, 'yyyy-mm-dd');"></td>
    <td align="center"><select id="estado1" name="estado1">
    						<option value='---'>---</option>
							<option value='true'>Activo</option>
                            <option value='false'>Inactivo</option>
                        </select>
    </td>
</tr>
</table></center>

	<center><input type="button" name="filtro" id="filto" value="Agregar Filtro" onClick="addRowToTable();">
    <input onClick="removeRowFromTable();" value="Eliminar" type="button">
    <input type="button" name="buscar" id="buscar" value="Buscar" onClick="buscar_rpt4(fechaIni1.value, fechaFin1.value, estado1.value, fiscalia1.value)"></center>
<br><br>

<center>
<div id="1">
<iframe src="" id="rpt" name="rpt" height="900" width="800" frameborder="1">
</iframe></div>
</center>
</body>
</html>