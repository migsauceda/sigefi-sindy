<?php
//aldea o ciudad

include("../clases/class_conexion_pg.php");

//se reciben datos
$IdOrigen_depto= $_POST['idorigen_depto'];
$IdOrigen_muni= $_POST['idorigen_muni'];
$IdDestino= $_POST['iddestino'];
$Op= $_POST['op'];


$sql= "SELECT caldeaid, cdescripcion FROM tbl_aldea
            WHERE cdepartamentoid= '$IdOrigen_depto' AND cmunicipioid= '$IdOrigen_muni'
             order by cdescripcion;";


$objConexion= new Conexion();
$resultado=$objConexion->ejecutarComando($sql);
$total= pg_num_rows($resultado);
if ($total > 0){
?>  

    <select id='<?php echo $IdDestino;?>' name ='<?php echo $IdDestino;?>' onchange="
            llena_barrio2('cboDepto2','cboMuni2','cboAldea2','cboBarrio2','tdBarrio2','14'); 
    " >
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
<?php } else echo $sql;?>     
