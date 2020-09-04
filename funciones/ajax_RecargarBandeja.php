<?php
include("../clases/class_conexion_pg.php");

$Bandeja= $_POST[bandeja];

$objConexion=new Conexion(); 
$sql= "select isubbandejaid, cdescripcion from mini_sedi.tbl_subbandejas
        where ibandejaid= $Bandeja order by cdescripcion;";
$resSubBandeja=$objConexion->ejecutarComando($sql);

while ($fila=pg_fetch_array($resSubBandeja)){
    $Campo= $fila[isubbandejaid];
    $Descripcion= $fila[cdescripcion];
    ?>
    <option value='<?php echo $Campo?>'><?php echo $Descripcion?></option>
    <?php
}  
?>