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
                        <th>Nombre Ofendido</th>
                        <th>Genero</th>
                        <th>LGBTI</th>
                        <th>Edad</th>
                        <th>Etnia</th>
                        </tr>
                      </thead>
                      <tbody>';
               $sql= "SELECT distinct DE.tdenunciaid, DE.dfechadenuncia, BA.cdescripcion as fiscalia_nom , 
                DL.cdescripcion as delito_nom, OFE.cnombres as nombre_ofe, OFE.capellidos as apellido_ofe, 
                case when OFE.cgenero = 'x' then 'No Consignado' else OFE.cgenero end as nomb_gene,
                case when OFE.aplicalgbti = 'f' then 'No pertenece' else 'Pertenece' end as nomb_lgbti,
                      OFE.iedad as nomb_edad, ET.cdescripcion
                from mini_sedi.tbl_imputado_delito as IMACD
                        INNER JOIN mini_sedi.tbl_denuncia as DE on DE.tdenunciaid = IMACD.tdenunciaid
                        inner join mini_sedi.tbl_delito as DL ON DL.ndelitoid = IMACD.ndelito
                        inner join mini_sedi.tbl_bandejas as BA on BA.ibandejaid = DE.ibandejaid
                        inner join mini_sedi.tbl_ofendido as OFE on OFE.tdenunciaid = DE.tdenunciaid
                        inner join mini_sedi.tbl_etnia as ET ON ET.netniaid = OFE.netniaid
                where date(DE.dfechadenuncia) between '$_fecha_inicial' and '$_fecha_final'
                    order by DE.dfechadenuncia desc" ;
                     
                     $resultado= $con->ejecutarComando($sql);
                     while ($rows = pg_fetch_ASSOC($resultado))
                      {
                          echo '<tr>
                                <td>'.$rows["tdenunciaid"].'</td>
                                <td>'.$rows["dfechadenuncia"].'</td>
                                <td>'.$rows["fiscalia_nom"].'</td>
                                <td>'.$rows["delito_nom"].'</td>
                                <td>'.$rows["nombre_ofe"].' '.$rows["apellido_ofe"].'</td>
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
