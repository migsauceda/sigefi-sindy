<?php

    include("../clases/Usuario.php");
	require_once("menus/menu_reporteria.php");


    $bandejaId = $_POST["idbandeja"];

	$vista = "SELECT * FROM mini_sedi.vw_reporte_fiscal_jefe_fiscalia WHERE ibandejaid= $bandejaId";
    $resultado = ejecutarQuery($vista);

    $vista2 = "SELECT * FROM mini_sedi.vw_reporte_fiscal_jefe_fiscalia WHERE ibandejaid= $bandejaId";
    $resultBandeja = ejecutarQuery($vista2);
    $resultBandeja = pg_fetch_array($resultBandeja);

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Reporte de Secciones</title>
 	<h2 align="center"><b>Secciones de:</b> <?php echo $resultBandeja["bandeja"]; ?></h2> <br><br>
 </head>
 <body>

 		<!-- Advanced Tables -->
    <div align="left" class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>

                    <tr>
                    	<th>SECCIÓN</th>
                        <th>OPCIONES</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                	while ($row = pg_fetch_array($resultado)) {

                		echo "
                			<tr>
                			<td align=center>".$row["subbandeja"]."</td>
                			<td align=center>
                			<form action=reporte_fiscales_asignados_subbandejas.php method=post>
            					<input type=hidden name=idsubbandeja value=".$row["isubbandejaid"]." />
								<input type=submit name=btnVerFiscal class='btn btn-link' value='Ver fiscales'/>
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
