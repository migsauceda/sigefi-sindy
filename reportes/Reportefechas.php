<!DOCTYPE html>
<html>
<head>
<meta charset="utf.8">
    <title></title>
</head>
<body>



<?php
 include "../clases/class_conexion_pg.php";
$con= new Conexion();
 
?>
<html lang="es">
<head>
<title>Reporte de Denuncias por un Rango de Fechas</title>
<meta charset = "utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
 
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    
    
<script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable();
} );
</script>
</head>
<body>
    <header>
        <div class="alert alert-info" align="center">
        <h2>Reporte de Denuncias por un Rango de Fechas </h2>
        </div>
    </header>
    <form method="POST" class="form" action="">
                        
                    <div class="alert alert-info" align="center"> 
                      Fecha Inicio:  
                    <input class="" type="date" name="fecha1" >
            
                      Fecha Final:               
                     <input class="" type="date" name="fecha2" >
           
                                      
                     <button type="submit" class="btn btn-primary btn-md" name="generar" value="Consultar" > Consultar</button>
                    </div>
      
          <?php
          if (isset($_POST['generar']))
          {
               $_fecha_inicial=$_POST['fecha1'];
               $_fecha_final=$_POST['fecha2'];
               echo '<div align="center"><a type="button" href="fechaexcel.php?fecha1='.$_fecha_inicial.'&fecha2='.$_fecha_final.'" target="blank" class="btn btn-success">Exportar a Excel</a></div>
                    <table class="table table-hover table-striped table-bordered" id="example" value="consulta">        
                      <thead>
                        <tr>
                        <th>N Denuncia</th>
                        <th>Exp.Policial</th>
                        <th>Fecha Denuncia</th>
                        <th>Nombre del Imputado</th>
                        <th>Nombre del Ofendido</th>
                        <th>Delito</th>
                        <th>Fiscalia</th>
                        <th>Usuario</th>
                        </tr>
                      </thead>
                      <tbody>';
               $sql= "SELECT distinct DE.tdenunciaid, DE.cexpedientepolicial, DE.dfechadenuncia, IM.cnombres as imputado_nombre, IM.capellidos as imputado_apellido,
                     OFE.cnombres as ofendido_nombre, OFE.capellidos as ofendido_apellido, DL.cdescripcion as delito, BA.cdescripcion as fiscalia, DE.ccreada
                     from mini_sedi.tbl_denuncia as DE
                     inner join mini_sedi.tbl_ofendido as OFE on OFE.tdenunciaid = DE.tdenunciaid
                     inner join mini_sedi.tbl_imputado as IM ON IM.tdenunciaid = DE.tdenunciaid
                     inner join mini_sedi.tbl_bandejas as BA on BA.ibandejaid = DE.ibandejaid
                     inner join mini_sedi.tbl_usuarios as US ON US.usuario = DE.ccreada
                     inner join mini_sedi.tbl_imputado_delito as IMDL ON IMDL.tdenunciaid = DE.tdenunciaid
                     inner join mini_sedi.tbl_delito as DL ON DL.ndelitoid = IMDL.ndelito
                    where US.rol= '11'
                    and DE.cdeptodenuncia = '8' and DE.cmunicipiodenuncia= '1'
                    and date(DE.dfechadenuncia) between '$_fecha_inicial' and '$_fecha_final'
                    order by DE.ccreada " ;
                    // $resultado= pg_query($sql);
                     $resultado= $con->ejecutarComando($sql);
                     while ($rows = pg_fetch_ASSOC($resultado))
                      {
                          echo '<tr>
                                <td>'.$rows["tdenunciaid"].'</td>
                                <td>'.$rows["cexpedientepolicial"].'</td>
                                <td>'.$rows["dfechadenuncia"].'</td>
                                <td>'.$rows["imputado_nombre"].' '.$rows["imputado_apellido"].'</td>
                                <td>'.$rows["ofendido_nombre"].' '.$rows["ofendido_apellido"].'</td>
                                <td>'.$rows["delito"].'</td>
                                <td>'.$rows["fiscalia"].'</td>
                                <td>'.$rows["ccreada"].'</td>
                                </tr>';
                       }  
                    echo "</tbody>
                    </table>";
          }
         
                
          ?>
          
        </div>
        <div class="col-md-1"> </div>
      </div>
           
     </form>
     </body>
</html>
