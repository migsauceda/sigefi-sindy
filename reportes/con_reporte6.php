<?php session_start();
	include('../clases/class_conexion_pg.php');
?>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <script language='javascript' src="js/popcalendar.js"></script> 
        <script type="text/javascript" src="js/eventos.js"></script>
    </head>
    <body>
<h3 style="text-transform:uppercase"><center>Historial de actividad fiscal por caso por denunciado</center></h3><br>
<center><table border="1" id="tabla">
<tr>
	<th></th>
	<th salign="center">Denuncia</th>
</tr>
<tr>
	<td>1</td>
    <td align="center"><select id="denuncia" name="denuncia">
    		<?php 
				$conexion=new Conexion();				
                                $sql= "select denuncia, activo, fecha, nombre, sexo, rangoedad from imputados_asignados('".$_SESSION['identidad']."')";
				$resultado=$conexion->ejecutarProcedimiento($sql);
				echo "<option value='---'>---</option>";
				while ($row=pg_fetch_assoc($resultado)){	
                                        $Datos= $row[denuncia]."; ".$row[fecha]."; ".$row[nombre]."; ".$row[rangoedad]."; ".$row[sexo]."; ".$row[activo];
					echo "<option value='$row[denuncia]'>$Datos</option>";
				}
			?>
    	</select>
    </td>
</tr>
</table></center>

	<center><input type="button" name="buscar" id="buscar" value="Buscar" onClick="buscar_rpt6(denuncia.value)"></center>
<br><br>

<center>
<div id="1">
<iframe src="" id="rpt" name="rpt" height="900" width="800" frameborder="1">
</iframe></div>
</center>
</body>
</html>