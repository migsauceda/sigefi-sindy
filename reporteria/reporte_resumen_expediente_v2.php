<?php
		require_once("menus/menu_reporteria.php");

		$denuncia = $_POST["denuncia"];
    $identidad = $_POST["identidad"];

		//vista para ver el nombre y apellido del imputado o imputados
		$vista = "SELECT DISTINCT tdenunciaid, tpersonaid, cnombres, capellidos FROM mini_sedi.vw_reporte_imputados WHERE tdenunciaid = '$denuncia';";
    $resultado = ejecutarQuery($vista);

		//consulta para ver el nombre del fiscal seleccionado
		$vistaNombre = "SELECT DISTINCT * FROM mini_sedi.vw_reporte_imputados WHERE identidad = '$identidad';";
		$result = ejecutarQuery($vistaNombre);
		$nombre = pg_fetch_array($result);

 		//vista para ver el nombre y apellido del ofendido u ofendidos
		$vistaOfendidos = "SELECT DISTINCT tdenunciaid, cnombres, capellidos FROM mini_sedi.vw_reporte_ofendidos WHERE tdenunciaid = '$denuncia';";
    $resultadoOfendidos = ejecutarQuery($vistaOfendidos);
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Reporte de imputados</title>
 	<h2 align="center"><b>Imputados y Ofendidos de la Denuncia: </b><?php echo $denuncia; ?> </h2> <br>
  <h3 align="center"><b>Carga de:</b> <?php echo $nombre["nombres"]." ".$nombre["apellidos"] ?></h3><br>
 </head>
 <body>
 	<!-- Advanced Tables -->
    <div align="left" class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="">
                <thead>
                    <tr>
                        <th>IMPUTADO</th>
                        <th>OPCIONES</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                	while ($row = pg_fetch_array($resultado)) {
                		echo "
                			<tr>
                			<td align=center>".$row["cnombres"]." ".$row["capellidos"]."</td>
											<td align=center>
												<form action=imputado_actividades.php method=post>
													<input type=hidden name=denuncia value='".$row["tdenunciaid"]."' />
													<input type=hidden name=idImputado value='".$row["tpersonaid"]."' />
													<input type=hidden name=nombreImputado value='".$row["cnombres"]."' />
													<input type=hidden name=apellidoImputado value='".$row["capellidos"]."' />
													<input type=submit name=btnVerDetalleOfendido class='btn btn-link' value='Ver actividades'/>
												</form>
												<form action=imputado_delitos.php method=post>
													<input type=hidden name=denuncia value='".$row["tdenunciaid"]."' />
													<input type=hidden name=idImputado value='".$row["tpersonaid"]."' />
													<input type=hidden name=nombreImputado value='".$row["cnombres"]."' />
													<input type=hidden name=apellidoImputado value='".$row["capellidos"]."' />
													<input type=submit name=btnVerDetalleOfendido class='btn btn-link' value='Ver delitos'/>
												</form>
											</td>
                			</tr>
                		";
                	}
                ?>
                </tbody>
								<thead>
                    <tr>
                        <th>OFENDIDO</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                	while ($row = pg_fetch_array($resultadoOfendidos)) {
                		echo "
                			<tr>
                			<td align=center>".$row["cnombres"]." ".$row["capellidos"]."</td>

												<td align=center>
													<form action=ofendido_actividades.php method=post>
														<input type=hidden name=denuncia value='".$row["tdenunciaid"]."' />
														<input type=hidden name=nombreOfendido value='".$row["cnombres"]."' />
														<input type=hidden name=apellidoOfendido value='".$row["capellidos"]."' />
														<input type=submit name=btnVerDetalleOfendido class='btn btn-link' value='Ver actividades'/>
													</form>
													<form action=ofendido_delitos.php method=post>
														<input type=hidden name=denuncia value='".$row["tdenunciaid"]."' />
														<input type=hidden name=nombreOfendido value='".$row["cnombres"]."' />
														<input type=hidden name=apellidoOfendido value='".$row["capellidos"]."' />
														<input type=submit name=btnVerDetalleOfendido class='btn btn-link' value='Ver delitos'/>
													</form>
												</td>
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
