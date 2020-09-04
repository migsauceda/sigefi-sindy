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
<title>Reporte por Imputado con un Rango de Fechas </title>
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
        <h2>Reporte por Imputado con un Rango de Fechas </h2>
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
               echo '<div align="center"><a type="button" href="impexcel.php?fecha1='.$_fecha_inicial.'&fecha2='.$_fecha_final.'" target="blank" class="btn btn-success">Exportar a Excel</a></div>
                    <table class="table table-hover table-striped table-bordered" id="example" value="consulta">        
                      <thead>
                        <tr>
                        <th>Denuncia</th>
                        <th>Fecha</th>
                        <th>Fiscalia</th>
                        <th>Delito</th>
                        <th>Nombre Imputado</th>
                        <th>Genero</th>
                        <th>LGBTI</th>
                        <th>Edad</th>
                        <th>Etnia</th>
                        </tr>
                      </thead>
                      <tbody>';
               $sql= "SELECT distinct DE.tdenunciaid, DE.dfechadenuncia as nomb_fecha, BA.cdescripcion as fiscalia_nom , 
                      DL.cdescripcion as delito_nom, IM.cnombres as nombre_imp, IM.capellidos as apellido_imp, 
                      case when IM.cgenero = 'x' then 'No Consignado' else IM.cgenero end as nomb_gene, 
                      case when IM.aplicalgbti = 'f' then 'No pertenece' else 'Pertenece' end as nomb_lgbti,  
                        IM.iedad as nomb_edad, ET.cdescripcion 
                          from mini_sedi.tbl_imputado_actividad_delito as IMACD
                        INNER JOIN mini_sedi.tbl_denuncia as DE on DE.tdenunciaid = IMACD.tdenunciaid
                        inner join mini_sedi.tbl_delito as DL ON DL.ndelitoid = IMACD.ndelito
                        inner join mini_sedi.tbl_bandejas as BA on BA.ibandejaid = DE.ibandejaid
                        inner join mini_sedi.tbl_imputado as IM on IM.tdenunciaid = DE.tdenunciaid
                        INNER JOIN mini_sedi.tbl_etnia as ET ON ET.netniaid = IM.netniaid
                    where date(DE.dfechadenuncia) between '$_fecha_inicial' and '$_fecha_final'
                    order by DE.dfechadenuncia desc " ;
                    // $resultado= pg_query($sql);
                     $resultado= $con->ejecutarComando($sql);
                     while ($rows = pg_fetch_ASSOC($resultado))
                      {
                          echo '<tr>
                                <td>'.$rows["tdenunciaid"].'</td>
                                <td>'.$rows["nomb_fecha"].'</td>
                                <td>'.$rows["fiscalia_nom"].'</td>
                                <td>'.$rows["delito_nom"].'</td>
                                <td>'.$rows["nombre_imp"].' '.$rows["apellido_imp"].'</td>
                                <td>'.$rows["nomb_gene"].'</td>
                                <td>'.$rows["nomb_lgbti"].'</td>
                                <td>'.$rows["nomb_edad"].'</td>
                                <td>'.$rows["cdescripcion"].'</td>
                                
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
