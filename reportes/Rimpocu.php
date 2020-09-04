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
<title>Reporte Imputado Ocupacion por un Rango de Fechas</title>
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
        <h2>Reporte Imputado Ocupacion por un Rango de Fechas </h2>
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
               echo '<div align="center"><a type="button" href="impocuexcel.php?fecha1='.$_fecha_inicial.'&fecha2='.$_fecha_final.'" target="blank" class="btn btn-success">Exportar a Excel</a></div>
                    <table class="table table-hover table-striped table-bordered" id="example" value="consulta">        
                      <thead>
                        <tr>
                        <th>Denuncia</th>
                        <th>Fecha</th>
                        <th>Fiscalia</th>
                        <th>Delito</th>
                        <th>Nombre del Imputado</th>
                        <th>EDAD</th>
                        <th>Genero</th>
                        <th>LGBTI</th>
                        <th>Escolaridad</th>
                        <th>Ocupacion</th>
                        <th>Profesion</th>
                        <th>Parentesco</th>
                        </tr>
                      </thead>
                      <tbody>';
               $sql= "SELECT distinct DE.tdenunciaid, DE.dfechadenuncia, BA.cdescripcion as fiscalia_nomb, 
                         DL.cdescripcion as delito_nomb, IM.cnombres as nomb_imp, IM.capellidos as ape_imp, IM.iedad,
                         case when IM.cgenero = 'x' then 'No Consignado' else IM.cgenero end as nomb_gene,
                         case when IM.aplicalgbti = 'f' then 'No pertenece' else 'Pertenece' end as nomb_lgbti, ES.cdescripcion,
                         OCU.cdescripcion as nomb_ocu, PRO.cdescripcion as nomb_pro, PA.cdescripcion as nomb_pare 
                     from mini_sedi.tbl_imputado_delito as IMDL
                        inner join mini_sedi.tbl_denuncia as DE on DE.tdenunciaid = IMDL.tdenunciaid
                        inner join mini_sedi.tbl_delito as DL ON DL.ndelitoid = IMDL.ndelito
                        inner join mini_sedi.tbl_bandejas as BA on BA.ibandejaid = DE.ibandejaid 
                        inner join mini_sedi.tbl_imputado as IM ON IM.tdenunciaid = DE.tdenunciaid
                        inner join mini_sedi.tbl_ocupacion as OCU ON OCU.nocupacionid = IM.nocupacionid
                        inner join mini_sedi.tbl_imputado_denunciante as IMD ON IMD.tdenunciaid = DE.tdenunciaid
                        inner join mini_sedi.tbl_parentescos as PA on PA.nparentescoid = IMD.nparentescoid
                        INNER JOIN mini_sedi.tbl_profesion as PRO on PRO.nprofesionid = IM.nprofesionid
                        inner join mini_sedi.tbl_escolaridad as ES ON ES.nescolaridadid = IM.nescolaridadid
                    where date(DE.dfechadenuncia) between '$_fecha_inicial' and '$_fecha_final'
                    order by DE.tdenunciaid " ;
                    // $resultado= pg_query($sql);
                     $resultado= $con->ejecutarComando($sql);
                     while ($rows = pg_fetch_ASSOC($resultado))
                      {
                          echo '<tr>
                                <td>'.$rows["tdenunciaid"].'</td>
                                <td>'.$rows["dfechadenuncia"].'</td>
                                <td>'.$rows["fiscalia_nomb"].'</td>
                                <td>'.$rows["delito_nomb"].'</td>
                                <td>'.$rows["nomb_imp"].' '.$rows["ape_imp"].'</td>
                                <td>'.$rows["iedad"].'</td>
                                <td>'.$rows["nomb_gene"].'</td>
                                <td>'.$rows["nomb_lgbti"].'</td>
                                <td>'.$rows["cdescripcion"].'</td>
                                <td>'.$rows["nomb_ocu"].'</td>
                                <td>'.$rows["nomb_pro"].'</td>
                                <td>'.$rows["nomb_pare"].'</td>
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
