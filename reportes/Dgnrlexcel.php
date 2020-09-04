<html>
<head>
<meta charset="utf.8">
<title></title>
</head>
<body>
<?php
  include "../clases/class_conexion_pg.php";
$con= new Conexion();

              $_fecha_inicial=$_GET['fecha1'];
              $_fecha_final=$_GET['fecha2'];
              header("Content-type: application/vnd.ms-excel");
              header("Content-Disposition: attachment; filename=reporte.xls");
               echo '<table class="table table-hover table-striped table-bordered" id="example" value="consulta">        
                      <thead>
                        <tr>
                        <th>Denuncia</th>
                        <th>Fecha</th>
                        <th>Departamento</th>
                        <th>Municipio</th>
                        <th>Delito</th>
                        <th>Fiscalia</th>
                        
                        </tr>
                      </thead>
                      <tbody>';
               $sql= "SELECT distinct DE.tdenunciaid, DE.dfechadenuncia as fecha, DEP.cdescripcion AS nomb_depto, 
                      MU.cdescripcion as nomb_muni, DL.cdescripcion as nomb_delito, BA.cdescripcion as nomb_fiscalia   
                    from mini_sedi.tbl_imputado_delito as IMDL
                      INNER JOIN mini_sedi.tbl_denuncia as DE on DE.tdenunciaid = IMDL.tdenunciaid
                      inner join mini_sedi.tbl_bandejas as BA on BA.ibandejaid = DE.ibandejaid 
                      inner join mini_sedi.tbl_delito as DL on DL.ndelitoid = IMDL.ndelito
                      inner join mini_sedi.tbl_departamentopais as DEP on DEP.cdepartamentoid = DE.cdeptodenuncia
                      inner join mini_sedi.tbl_municipio as MU ON MU.cmunicipioid = DE.cmunicipiodenuncia
                    where date(DE.dfechadenuncia) between '$_fecha_inicial' and '$_fecha_final'
                    and MU.cdepartamentoid = DEP.cdepartamentoid 
                    order by DE.dfechadenuncia " ;
                     
                     $resultado= $con->ejecutarComando($sql);
                     while ($rows = pg_fetch_ASSOC($resultado))
                      {
                          echo '<tr>
                                <td>'.$rows["tdenunciaid"].'</td>
                                <td>'.$rows["fecha"].'</td>
                                <td>'.$rows["nomb_depto"].'</td>
                                <td>'.$rows["nomb_muni"].'</td>
                                <td>'.$rows["nomb_delito"].'</td>
                                <td>'.$rows["nomb_fiscalia"].'</td>
                                
                                </tr>';
                      }  
                      echo "</tbody>
        </table>";               
 
 $filename="reporte1.xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$filename."");
?>
</body>
</html>
