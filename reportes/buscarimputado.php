<html>
<head>
<link href="tablas.css" rel="stylesheet">
<a href="menu.php">Volver Atras</a><br>
</head><br>
</br>
<body>
<?php
    
    $denuncia = $_GET['denuncia'];
    if (empty($denuncia)) {
            $denuncia = 0;
        }
    $policial = $_GET['policial'];
    if (empty($policial)){
        $policial = 'sinexpediente';
    }
    $identidad = $_GET['identidad'];
    if (empty($identidad)) {
            $identidad = 'sinidentidad';
        }
    $nombre = $_GET['nombre'];
    
    $apellido = $_GET['apellido'];
    
    $nombre = strtoupper($nombre);
    $apellido = strtoupper($apellido);
    $SelRadio = $_GET['radiob'];
    if ($SelRadio == 'rofendido')  {
            header('location: buscarofendido.php?denuncia=' . $denuncia . '&policial=' . $policial . '&identidad=' . $identidad . '&nombre=' . $nombre . '&apellido=' . $apellido);
       }
       if ($SelRadio == 'rdenunciante')  {
               header('location: buscardenunciante.php?denuncia=' . $denuncia . '&policial=' . $policial . '&identidad=' . $identidad . '&nombre=' . $nombre . '&apellido=' . $apellido);
       }
       
//include "co3.php";
       include "../clases/class_conexion_pg.php";
       $con= new Conexion();
$sql="select distinct DE.tdenunciaid, DE.cexpedientesedi, DE.cexpedientepolicial, IM.cdocumentoid, IM.cnombres, IM.capellidos,
 DE.dfechadenuncia, US.nombres, US.apellidos, DL.cdescripcion, BA.cdescripcion, SUB.cdescripcion,
   case when US.nombres is null then 'Fiscal No Asignado' else 'Fiscal Asignado' end,
   case when BA.cdescripcion is null then 'Fiscalia No Asignado' else 'Fiscalia Asignado' end,
   case when DE.cestadodenuncia = 'A'  then 'Activo' 
        when DE.cestadodenuncia = 'P'  then 'Pendiente'
        when DE.cestadodenuncia = 'D'  then 'Denuncia'
        when DE.cestadodenuncia = 'C'  then 'Concluido'
        when DE.cestadodenuncia = 'Ap' then 'Aprobado'
        when DE.cestadodenuncia = 'IP' then 'Investigación Preliminar'
        when DE.cestadodenuncia = 'CI' then 'Cierre de Investigación'
        when DE.cestadodenuncia = 'CD' then 'Cierre Definitivo'
        when DE.cestadodenuncia = 'Im' then 'Impugnado' 
        when DE.cestadodenuncia = 'Pa' then 'Pasivo'
        when DE.cestadodenuncia = 'R'  then 'Reparo'
        when DE.cestadodenuncia = 'E'  then 'Espera'
   else 'Inactivo' end 
from mini_sedi.tbl_denuncia as DE
   left join mini_sedi.tbl_imputado_fiscalia as IFIS ON IFIS.tdenunciaid = DE.tdenunciaid
   left join mini_sedi.tbl_imputado_fiscal as IMF ON IMF.tdenunciaid = DE.tdenunciaid
 inner JOIN mini_sedi.tbl_imputado as IM on IM.tdenunciaid = DE.tdenunciaid
   left join mini_sedi.tbl_usuarios as US on US.identidad = IMF.cfiscal
   left JOIN mini_sedi.tbl_bandejas as BA on BA.ibandejaid = DE.ibandejaid
 inner join mini_sedi.tbl_imputado_delito as PIMDL ON PIMDL.tdenunciaid  = DE.tdenunciaid
   inner join mini_sedi.tbl_delito as DL on DL.ndelitoid = PIMDL.ndelito
   left join mini_sedi.tbl_subbandejas as SUB on SUB.isubbandejaid = US.isubbandejaid
  where (DE.tdenunciaid = $denuncia";
    
if (!empty($nombre) and empty($apellido)) {
    $sql = $sql . " or IM.cnombres like '%$nombre%'";
        }
if (!empty($apellido) and empty($nombre)) {
    $sql = $sql . " or IM.capellidos like '%$apellido%'";
        }
if (!empty($nombre) and !empty($apellido)) {
    $sql = $sql . " or (IM.cnombres like '%$nombre%' and IM.capellidos like '%$apellido%') ";
        }
if (!empty($policial)){ $sql = $sql. " or (DE.cexpedientepolicial like '%$policial%')";
        }
$sql = $sql . " or IM.cdocumentoid= '$identidad')";
$resultado= $con->ejecutarComando($sql);
//$conx=pg_query($sql);
echo "<table border= '1'>";
echo "<tr>";
echo "<th>Clave de la Denuncia</th>";
echo "<th>Exp.Sedi</th>";
echo "<th>Exp.Policial</th>";
echo "<th>Identidad</th>";
echo "<th>Nombre del Denunciado </th>";
echo "<th>Fecha de la Denuncia</th>";
echo "<th>Nombre del Fiscal</th>";
echo "<th>Delito</th>";
echo "<th>Tomado</th>";
echo "<th>Fiscalia</th>";
echo "<th>Estado de la Denuncia</th>";

echo "</tr>";
while ($rows = pg_fetch_row($resultado))
{
echo "<tr>";
echo "<td>".$rows[0]."</td>";
echo "<td>".$rows[1]."</td>";
echo "<td>".$rows[2]. "</td>";
echo "<td>".$rows[3]. "</td>";
echo "<td>".$rows[4]." " .$rows[5]."</td>";
echo "<td>".$rows[6]. "</td>";
echo "<td>".$rows[7]." ". $rows[8]."</td>";
echo "<td>".$rows[9]."</td>";
echo "<td>".$rows[10]."</td>";
echo "<td>".$rows[11]."</td>";
echo "<td>".$rows[14]."</td>";
echo "</tr>";
}
echo "</table> \n";
//pg_close($dbconn);
$con->cerrarConexion();
?>
</body>
</html>
