
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
                     $resultado= pg_query($sql);
                     $resultado= $con->ejecutarComando($sql);
                     while ($rows = pg_fetch_ASSOC($resultado))
                      {
                          echo '<tr>
                                <td>'.$rows["tdenunciaid"].'</td>
                                <td>'.$rows["cexpedientepolicial"].'</td>
                                <td>'.$rows["dfechadenuncia"].'</td>
                                <td>'.$rows["imputado_nombre"].' '. $rows["imputado_apellido"].'</td>
                                <td>'.$rows["ofendido_nombre"].' '.$rows["ofendido_apellido"].'</td>
                                <td>'.$rows["delito"].'</td>
                                <td>'.$rows["fiscalia"].'</td>
                                <td>'.$rows["ccreada"].'</td>
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
