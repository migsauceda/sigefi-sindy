<?php
//aldea o ciudad

include("../clases/class_conexion_pg.php");

//se reciben datos
$IdOrigen_depto= $_POST['idorigen_depto'];
$IdOrigen_muni= $_POST['idorigen_muni'];
$IdOrigen_Aldea= $_POST['idorigen_aldea'];
$IdDestino= $_POST['iddestino'];
$Op= $_POST['op'];

if($Op== '14' || $Op== '24' || $Op== '34' || $Op== '44' || $Op== '54' || $Op== '64' || $Op== '74'){
    $sql= "SELECT cbarrioid, cdescripcion FROM tbl_barrio
            WHERE cdepartamentoid= '$IdOrigen_depto' AND cmunicipioid= '$IdOrigen_muni' 
            AND caldeaid='$IdOrigen_Aldea' 
            ORDER BY cdescripcion ASC";
}
//exit($sql);
$objConexion= new Conexion();
$resultado=$objConexion->ejecutarComando($sql);
$total= pg_num_rows($resultado);
if ($total > 0){
?>  

    <select id='<?php echo $IdDestino;?>' name ='<?php echo $IdDestino;?>'>
        <option value="">Seleccione...</option>
        <?php for($i= 0; $i < $total; $i++){
            $row =pg_fetch_array($resultado);
            $code=$row[0];
            $des =$row[1];
        ?>
        <option value='<?php echo $code ?>'><?php echo $des ?></option>     
        <?php }        
        ?>
    </select>       
<?php } ?>     