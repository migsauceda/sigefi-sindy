<?php 
    
    
    include("../clases/Usuario.php");
	require_once("menus/menu_reporteria.php");

    $subBandejaId = $_POST["idsubbandeja"];

	$vista = "SELECT DISTINCT * FROM mini_sedi.vw_reporte_fiscales_subbandeja WHERE isubbandejaid = $subBandejaId;";
    $resultado = ejecutarQuery($vista);
    
    $resultSubbandeja = pg_fetch_array($resultado);

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Reporte Fiscal Jefe</title>
 	<h2 align="center"><b>Fiscales de:</b> <?php echo $resultSubbandeja["subbandeja"]; ?></h2> <br><br>
 </head>
 <body>

 		<!-- Advanced Tables -->
    <div align="left" class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr> 
                    	<th>FISCAL</th>  
                        <th>OPCIONES</th>  
                    </tr>
                </thead>
                <tbody>
                <?php
                	while ($row = pg_fetch_array($resultado)) {
                		
                		echo "
                			<tr>
                			<td align=center>".$row["nombres"]." ".$row["apellidos"]."</td>
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