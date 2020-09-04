<?php session_start();
//	include('conexion/cls_conexion.php');
        include('../clases/class_conexion_pg.php');
?>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <script language='javascript' src="js/popcalendar.js"></script> 
        <script type="text/javascript" src="js/eventos.js"></script>
        <script type="text/javascript" src="js/tabla5.js"></script>
	<script type="text/javascript" src="../java_script/jquery-1.5.1.min.js"></script>
	<script type="text/javascript" src="../java_script/jquery-ui-1.8.12.custom.min.js"></script>        
    </head>
    <body>
        
<script type="text/javascript">
function llena_cboFiscal(fiscalia){
    $.ajax({
        data:   "fiscaliaid="+fiscalia,
        type:   "POST",
        dataType: "html",
        url: "../funciones/ajax_FiscalesFiscalias.php",
        error: function(obj, que, otro){
            alert("Error al recuperar datos de fiscales");
        },
        success: function(data){
            $("#fiscal1").html(data);
        }
            
    });
}
</script>
        
<h3 style="text-transform:uppercase"><center>Frecuencia de denuncias asignadas por fiscal, por rango de fechas y estado</center></h3><br><br>
<center><table border="1" id="tabla">
<tr>
	<th></th>
	<th align="center">Fiscal&iacute;a</th>
    <th align="center">Fiscal</th>
	<th align="center">Fecha Inicial</th>
    <th align="center">Fecha Final</th>
    <th align="center">Estado</th>
</tr>
<tr>
	<td>1</td>
    <td><select id="fiscalia1" name="fiscalia1" onChange="llena_cboFiscal(this.value)">
    		<?php 
				$conexion=new Conexion();
				$resultado=$conexion->ejecutarProcedimiento("select * from tbl_fiscalia");
				echo "<option value='---'>---</option>";
				echo "<option value='todas'>Todas</option>";
				while ($row=pg_fetch_assoc($resultado)){	
					echo "<option value='$row[nfiscaliaid]'>$row[cdescripcion]</option>";
				}
			?>
    	</select>
    </td>
    <td><div id="2"><select id="fiscal1" name="fiscal1">
    		<option value="---">----</option>
    	</select></div>
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
    <input type="button" name="buscar" id="buscar" value="Buscar" onClick="buscar_rpt5(fechaIni1.value, fechaFin1.value, estado1.value, fiscalia1.value, fiscal1.value)"></center>
<br><br>

<center>
<div id="1">
<iframe src="" id="rpt" name="rpt" height="900" width="800" frameborder="1">
</iframe></div>
</center>
</body>
</html>