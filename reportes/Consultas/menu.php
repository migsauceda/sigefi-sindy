<?php 
    session_start();
   
    
    include("../../clases/class_conexion_pg.php");
    include_once "../../funciones/php_funciones.php"; 
    
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Reportes</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
 
<div class="container">
  <h2>Seleccione un Reporte</h2>
  <div class="panel panel-primary">
    <div class="panel-heading">Reportes</div>
    <div class="panel-body">

      <table style="width:100%">
        <tr>
          <th><?php echo "<a href='../Consultas/Consulta1.php'>* Reporte de Relacion Imputado-Ofendido</a>"; ?></th>
        </tr>
        <tr>
          <th><?php echo "<a href='../Consultas/Consulta2.php'>* Reporte de Relacion Imputado-Arma-Delito</a>"; ?></th>
        </tr>
      </table>
      
    </div>
    <div class="panel-footer"> </div>
  </div>
</div>

</body>
</html>
