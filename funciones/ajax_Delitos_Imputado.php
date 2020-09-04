<?php 
include("../clases/class_conexion_pg.php");

$denunciado= $_POST['denunciado'];

$sql= "select cdescripcion
       from mini_sedi.tbl_imputado_delito id, mini_sedi.tbl_delito d
       where id.ndelito= d.ndelitoid and id.tpersonaid= $denunciado";

$conexion= new Conexion();
$cursor= $conexion->ejecutarProcedimiento($sql);
$reg= pg_fetch_array($cursor);

while ($reg){
    ?>
    <ol>
        <li><?php echo $reg[cdescripcion]; ?></li>
    </ol>
    <?php
    $reg= pg_fetch_array($cursor);
}
?>                                       