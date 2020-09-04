<?php 

	require_once("menus/menu_reporteria.php");

	$vista = "SELECT * FROM mini_sedi.tbl_bandejas";
	$resultado = ejecutarQuery($vista);

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Reporte Gerencia</title>
 	<h2 align="center"><b>Reporte Gerencia</b></h2> <br><br>
 </head>
 <body>

 	<!-- Advanced Tables -->
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr> 
                    	<th>FISCALÍA</th>
                        <th>OPCIONES</th>  
                    </tr>
                </thead>
                <tbody>
                <?php
                	while ($row = pg_fetch_array($resultado)) {
                		
                		echo "
                			<tr>
                			<td align=center>".$row["cdescripcion"]."</td>
                			<td align=center>
                			<form action=reporte_gerencia_subbandejas.php method=post>
            					<input type=hidden name=idbandeja value=".$row["ibandejaid"]." />
								<input type=submit name=btnVerSubbandejas class='btn btn-link' value='Ver secciones'/>
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