<?php
//municipio 

include("../clases/class_conexion_pg.php");

//se reciben datos
$IdDestino= $_POST['iddestino'];
$Depto= $_POST['depto'];
$Op= $_POST['op'];

$sql= "SELECT cmunicipioid, cdescripcion FROM tbl_municipio
            WHERE cdepartamentoid= '$Depto' order by cdescripcion;";

$objConexion= new Conexion();
$resultado=$objConexion->ejecutarComando($sql);
$total= pg_num_rows($resultado);
if ($total > 0){
?>  

    <select id='<?php echo $IdDestino;?>' name ='<?php echo $IdDestino;?>' onchange="
                llena_aldea_denunciado('cboDepto2','cboMuni2','cboAldea2','tdAldea2','13'); 
    ">
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