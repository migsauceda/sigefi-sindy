<?php

    include("../clases/Usuario.php");
	  require_once("menus/menu_reporteria.php");

    session_start();
    if (isset($_SESSION['objUsuario'])){
        $objUsuario= $_SESSION['objUsuario'];
    }

    $bandejaId = $objUsuario->getBandejaId();
    $subBandejaId = $objUsuario->getSubBandejaId();

	  $vista = "SELECT DISTINCT * FROM mini_sedi.vw_reporte_jefe_seccion WHERE isubbandejaid=$subBandejaId;";
    $resultado = ejecutarQuery($vista);

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Reporte Jefe de Sección</title>
 	<h2 align="center"><b>Reporte Jefe de Sección </b></h2> <br><br>
 </head>
 <body>

 		<!-- Advanced Tables -->
    <div align="left" class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                    	<th>NOMBRE DEL FISCAL</th>
                    	<th>SECCIÓN</th>
                        <th>OPCIONES</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                	while ($row = pg_fetch_array($resultado)) {

                		echo "
                			<tr>
                			<td align=center>".$row["nombres"]." ".$row["apellidos"]."</td>
                			<td align=center>".$row["subbandeja"]."</td>
                			<td align=center>
                			<form action=subreporte_carga_individual.php method=post>
            					<input type=hidden name=idfiscal value=".$row["identidad"]." />
      								<input type=submit name=btnVerFiscal class='btn btn-link' value='Ver expedientes'/>
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
