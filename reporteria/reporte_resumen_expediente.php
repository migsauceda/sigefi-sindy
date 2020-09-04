<?php

	require_once("menus/menu_reporteria.php");

	$denuncia = $_POST["denuncia"];
  $identidad = $_POST["identidad"];

	$vista = "SELECT DISTINCT * FROM mini_sedi.vw_reporte_resumen_expediente WHERE tdenunciaid = '$denuncia';";
  $resultado = ejecutarQuery($vista);
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Reporte resumen de expediente</title>
 	<h2 align="center"><b>Resumen del Expediente:</b> <?php echo $denuncia; ?>
    </h2> <br><br>
 </head>
 <body>

 	<!-- Advanced Tables -->
    <div align="left" class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>IMPUTADO</th>
                        <th>OFENDIDO</th>
                        <th>ACTIVIDAD</th>
                        <th>FECHA DE REGISTRO</th>
                        <th>DELITO</th>
                        <th>ETAPA</th>
                        <th>FISCAL</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                	while ($row = pg_fetch_array($resultado)) {

                		echo "
                			<tr>
                			<td align=center>".$row["cnombres"]." ".$row["capellidos"]."</td>
                			<td align=center>".$row["nombresofe"]." ".$row["apellidosofe"]."</td>
                			<td align=center>".$row["actividad"]."</td>
                			<td align=center>".$row["dfecha"]."</td>
                			<td align=center>".$row["delito"]."</td>
                			<td align=center>".$row["etapa"]."</td>
                			<td align=center>".$row["nombres"]." ".$row["apellidos"]."</td>
                			</tr>
                		";
                	}
                ?>
                </tbody>
            </table>
        </div>
    </div>

 	<div align="center">
 		<h4>
 	 		<a href="javascript:window.history.back();"><b>Regresar</b></a>
 	 	</h4>

 	</div>
 	<br>

 </body>
 </html>
