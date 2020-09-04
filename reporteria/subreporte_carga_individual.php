<?php

    require_once("menus/menu_reporteria.php");

    //vista para ver los expedientes del fiscal seleccionado
    $identidad = $_POST["idfiscal"];
	  $vista = "SELECT DISTINCT * FROM mini_sedi.vw_reporte_carga_individual WHERE cfiscal = '$identidad';";
    $resultado = ejecutarQuery($vista);

    //vista para ver el nombre y apellido del fiscal que se seleccionado
    //se vuelve ejecutar la visat porque si se toma la anterior se ejecuta en en el nombre y no prosigue a mostrar los datos sa la tab,a
    $vistaNombre = "SELECT DISTINCT * FROM mini_sedi.vw_reporte_carga_individual WHERE cfiscal = '$identidad';";
    $resultadoNombre = ejecutarQuery($vistaNombre);
    $nombre = pg_fetch_array($resultadoNombre);
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Reporte de Carga Individual</title>
 	<h2 align="center"><b>Reporte de Carga Individual</b></h2> <br>
    <h3 align="center"><b>Carga de:</b> <?php echo $nombre["nombres"]." ".$nombre["apellidos"] ?></h3><br>
 </head>
 <body>

 	<!-- Advanced Tables -->
    <div align="left" class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                    	  <th>NÚMERO DE EXPEDIENTE</th>
                        <th>FECHA DE LA DENUNCIA</th>
                        <th>OPCIONES</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                	while ($row = pg_fetch_array($resultado)) {
                		echo "
                			<tr>
                  			<td align=center>".$row["tdenunciaid"]."</td>
                  			<td align=center>".$row["dfechadenuncia"]."</td>
                  			<td align=center>
                          <form action=reporte_resumen_expediente_v2.php method=post>
                            <input type=hidden name=denuncia value=".$row["tdenunciaid"]." />
                            <input type=hidden name=identidad value=".$row["cfiscal"]." />
                            <input type=submit name=btnVerDetalleExpediente class='btn btn-link' value='Ver detalle del expediente'/>
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
