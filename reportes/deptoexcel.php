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
                        <th>Aldea</th>
                        <th>Barrio/Col.</th>
                        <th>Delito</th>
                        <th>Nombre Imputado</th>
                        <th>Fiscalia</th>
                        </tr>
                      </thead>
                      <tbody>';
               $sql= "SELECT distinct DE.tdenunciaid, DE.dfechadenuncia as fecha, DEP.cdescripcion AS nomb_depto, 
                      MU.cdescripcion as nomb_muni, AL.cdescripcion as nomb_aldea, BR.cdescripcion as nomb_barrio, DL.cdescripcion as nomb_delito, 
                      IM.cnombres as nomb_imp, IM.capellidos as ape_imp, BA.cdescripcion as nomb_fiscalia    
                    from mini_sedi.tbl_imputado_delito as IMDL
                      INNER JOIN mini_sedi.tbl_denuncia as DE on DE.tdenunciaid = IMDL.tdenunciaid
                      inner join mini_sedi.tbl_bandejas as BA on BA.ibandejaid = DE.ibandejaid 
                      inner join mini_sedi.tbl_delito as DL on DL.ndelitoid = IMDL.ndelito
                      inner join mini_sedi.tbl_departamentopais as DEP on DEP.cdepartamentoid = DE.cdeptodenuncia
                      inner join mini_sedi.tbl_municipio as MU ON MU.cdepartamentoid = DEP.cdepartamentoid
                      inner join mini_sedi.tbl_aldea as AL ON AL.caldeaid = DE.caldeahecho
                      inner join mini_sedi.tbl_imputado as IM ON IM.tdenunciaid = DE.tdenunciaid
                      INNER JOIN mini_sedi.tbl_barrio as BR ON BR.cbarrioid = IM.cbarrioid
                    where DE.dfechadenuncia between '$_fecha_inicial' and '$_fecha_final' and MU.cmunicipioid = DE.cmunicipiodenuncia
                    and AL.cdepartamentoid = DEP.cdepartamentoid and Al.cmunicipioid = MU.cmunicipioid 
                    and BR.cdepartamentoid = DEP.cdepartamentoid and BR.cmunicipioid = MU.cmunicipioid
                    and BR.caldeaid = AL.caldeaid
                    order by DE.tdenunciaid";
                     
                     $resultado= $con->ejecutarComando($sql);
                     while ($rows = pg_fetch_ASSOC($resultado))
                      {
                          echo '<tr>
                                <td>'.$rows["tdenunciaid"].'</td>
                                <td>'.$rows["fecha"].'</td>
                                <td>'.$rows["nomb_depto"].'</td>
                                <td>'.$rows["nomb_muni"].'</td>
                                <td>'.$rows["nomb_aldea"].'</td>
                                <td>'.$rows["nomb_barrio"].'</td>
                                <td>'.$rows["nomb_delito"].'</td>
                                <td>'.$rows["nomb_imp"].''.$rows["ape_imp"].'</td>
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
