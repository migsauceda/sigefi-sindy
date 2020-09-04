<?php session_start();
	include('conexion/cls_conexion.php');
        
    //funciones genericas
    include "../funciones/php_funciones.php";
    
    //valida si esta conectado
    if (!isset($_SESSION['usuario'])){	
        header("location:index.php");
    } 
    
    //valida derechos
    if (Ejecutar(6)== false){
        ?>
        <script type="text/javascript">
        alert("No tiene acceso a esta opción");
        top.location = "../aplicacion.php";        
        </script>    
        <?php
    }        
?>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <script language='javascript' src="js/popcalendar.js"></script> 
        <script type="text/javascript" src="js/eventos.js"></script>
    </head>
    <body>
<h3 style="text-transform:uppercase"><center>Denuncia completa</center></h3><br>
<center><table border="1" id="tabla">
<tr>
	<th></th>
	<th salign="center">Denuncia</th>
</tr>
<tr>
	<td>1</td>
    <td align="center"><select id="denuncia" name="denuncia">
    		<?php 
				$conexion=new cls_conexion();
				$conexion->conectar();
				$resultado=$conexion->consultar("select * from tbl_denuncia");
				echo "<option value='---'>---</option>";
				while ($row=pg_fetch_assoc($resultado)){	
					echo "<option value='$row[tdenunciaid]'>$row[tdenunciaid]</option>";
				}
			?>
    	</select>
    </td>
</tr>
</table></center>

	<center><input type="button" name="buscar" id="buscar" value="Buscar" onClick="buscar_rpt1(denuncia.value)"></center>
<br><br>

<center>
<div id="1">
<iframe src="" id="rpt" name="rpt" height="900" width="800" frameborder="1">
</iframe></div>
</center>
</body>
</html>