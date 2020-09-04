<?php


    include("../clases/Usuario.php");
	require_once("menus/menu_reporteria.php");

    session_start();
    if (isset($_SESSION['objUsuario'])){
        $objUsuario= $_SESSION['objUsuario'];
    }

    $bandejaId = $objUsuario->getBandejaId();
    $subBandejaId = $objUsuario->getSubBandejaId();

	$vista = "SELECT DISTINCT * FROM mini_sedi.vw_reporte_fiscal_jefe_fiscalia WHERE ibandejaid=$bandejaId;";
    $resultado = ejecutarQuery($vista);

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Reporte Fiscal Jefe</title>
 	<h2 align="center"><b>Reporte Jefe de Fiscalía</b></h2> <br><br>
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
