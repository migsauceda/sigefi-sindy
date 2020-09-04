<?php
	require_once("menus/menu_reporteria.php");

	$denuncia = $_POST["denuncia"];
	$idImputado = $_POST["idImputado"];
	$nombresImputado = $_POST["nombreImputado"];
  $apellidosImputado = $_POST["apellidoImputado"];

	$vista = "SELECT DISTINCT delito FROM mini_sedi.vw_reporte_imputados
						WHERE tdenunciaid='$denuncia' AND tpersonaid = '$idImputado'";
  $resultado = ejecutarQuery($vista);
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Reporte delitos imputado</title>
 	<h2 align="center"><b>Imputado:</b> <?php echo $nombresImputado." ".$apellidosImputado; ?>
    </h2> <br><br>
 </head>
 <body>

 	<!-- Advanced Tables -->
    <div align="left" class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>DELITOS</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                	while ($row = pg_fetch_array($resultado)) {

                		echo "
                			<tr>
                				<td align=center>".$row["delito"]."</td>
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
