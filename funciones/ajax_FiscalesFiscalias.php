<?php 
include("../clases/class_conexion_pg.php");

$fiscalia= $_POST['fiscaliaid'];

$sql= "select nombres, fiscalid from fiscales_fiscalia($fiscalia)";
$conexion= new Conexion();
$cursor= $conexion->ejecutarProcedimiento($sql);
$reg= pg_fetch_array($cursor);

while ($reg){
    ?>
    <option value=<?php echo $reg[fiscalid]; ?>><?php echo $reg[nombres]; ?></option>
    <?php
    $reg= pg_fetch_array($cursor);
}
?>
