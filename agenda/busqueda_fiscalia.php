<?php
  include("../clases/Usuario.php");
	require_once("../reporteria/conexionp.php");

	
    session_start();
    if (isset($_SESSION['objUsuario'])){
        $objUsuario= $_SESSION['objUsuario'];
    }
	
    $bandejaId = $objUsuario->getBandejaId();
    $vista = "SELECT DISTINCT * FROM mini_sedi.vw_reporte_fiscal_jefe_fiscalia WHERE ibandejaid=$bandejaId;";
    $resultado = ejecutarQuery($vista);

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<link href="assets/css/bootstrap.css" rel="stylesheet" />
      <!-- FontAwesome Styles-->
      <link href="assets/css/font-awesome.css" rel="stylesheet" />
      <!-- Morris Chart Styles-->
      <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
      <!-- Custom Styles-->
      <link href="assets/css/custom-styles.css" rel="stylesheet" />
      <!-- Google Fonts-->
      <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

 	<h2 align="center"><b>Seleccion de Fiscalía</b></h2> <br><br>
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
                			<form action=busqueda_fiscal.php method=post>
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

 <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>

    <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
         <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>


 </body>
 </html>
