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
                         case when IM.aplicalgbti = 'f' then 'No pertenece' else 'Pertenece' end as nomb_lgbti,ES.cdescripcion as esco,
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
                    order by DE.tdenunciaid  " ;
                     //$resultado= pg_query($sql);
                     $resultado= $con->ejecutarComando($sql);
                     while ($rows = pg_fetch_ASSOC($resultado))
                      {
                          echo '<tr>
                                <td>'.$rows["tdenunciaid"].'</td>
                                <td>'.$rows["dfechadenuncia"].'</td>
                                <td>'.$rows["fiscalia_nomb"].'</td>
                                <td>'.$rows["delito_nomb"].'</td>
                                <td>'.$rows["nomb_imp"].''.$rows["ape_imp"].'</td>
                                <td>'.$rows["iedad"].'</td>
                                <td>'.$rows["nomb_gene"].'</td>
                                <td>'.$rows["nomb_lgbti"].'</td>
                                <td>'.$rows["esco"].'</td>
                                <td>'.$rows["nomb_ocu"].'</td>
                                <td>'.$rows["nomb_pro"].'</td>
                                <td>'.$rows["nomb_pare"].'</td>
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
