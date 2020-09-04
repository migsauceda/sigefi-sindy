<?php

  include("../clases/Usuario.php");
  require_once("../reporteria/conexionp.php");


  session_start();
  if (isset($_SESSION['objUsuario'])){
      $objUsuario= $_SESSION['objUsuario'];
  }


  if (isset($_POST["idsubbandeja"])) {
    $subBandejaId = $_POST["idsubbandeja"];
  }
    else {
    header("location:busqueda_fiscalia.php");
    }

	  $vista = "SELECT DISTINCT * FROM mini_sedi.vw_reporte_fiscales_subbandeja WHERE isubbandejaid = $subBandejaId;";
    $resultado = ejecutarQuery($vista);
    $resultSubbandeja = pg_fetch_array($resultado);

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
                			<form action=agenda.php method=post>
            					<input type='hidden' name='usuario' value='".$row["usuario"]."' />
                      <input type='hidden' name='nombres' value='".$row["nombres"]."' />
                      <input type='hidden' name='apellidos' value='".$row["apellidos"]."' />
                      <input type='hidden' name='subbandeja' value='".$row["subbandeja"]."' />
                      <input type='hidden' name='supervision' value='1' />
								<input type=submit name=btnVerFiscal class='btn btn-link' value='Ver Agenda'/>
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
