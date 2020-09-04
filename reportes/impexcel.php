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
                          from mini_sedi.tbl_imputado_delito as IMACD
                        INNER JOIN mini_sedi.tbl_denuncia as DE on DE.tdenunciaid = IMACD.tdenunciaid
                        inner join mini_sedi.tbl_delito as DL ON DL.ndelitoid = IMACD.ndelito
                        inner join mini_sedi.tbl_bandejas as BA on BA.ibandejaid = DE.ibandejaid
                        inner join mini_sedi.tbl_imputado as IM on IM.tdenunciaid = DE.tdenunciaid
                        INNER JOIN mini_sedi.tbl_etnia as ET ON ET.netniaid = IM.netniaid
                    where date(DE.dfechadenuncia) between '$_fecha_inicial' and '$_fecha_final'
                    order by DE.dfechadenuncia desc ";
                     
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
 
 $filename="reporte1.xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$filename."");
?>
</body>
</html>
