<?php
//municipio 

include("../clases/class_conexion_pg.php");

//se reciben datos
$IdDestino= $_POST['iddestino'];
$Depto= $_POST['depto'];
$Op= $_POST['op'];

if($Op== '11' || $Op== '12' || $Op== '22' || $Op== '32' || $Op== '42' || $Op== '52' || $Op== '62' || $Op== '72'){
    $sql= "SELECT cmunicipioid, cdescripcion FROM tbl_municipio
		WHERE cdepartamentoid= '$Depto' order by cdescripcion;";
}
$objConexion= new Conexion();
$resultado=$objConexion->ejecutarComando($sql);
$total= pg_num_rows($resultado);
if ($total > 0){
?>  
    <select id='<?php echo $IdDestino;?>' name ='<?php echo $IdDestino;?>' onchange="
        <?php if ($Op== '11') { ?>
                ;        
        <?php } ?> 
        <?php if ($Op== '12') //generales
        { ?>
                llena_aldea('cboDepto2','cboMuni2','cboAldea2','tdAldea2','13');                
        <?php } ?>     
        <?php if ($Op== '22') //denunciante natural
        { ?>
                llena_aldea('cboDepto','cboMuni','cboAldea','tdAldea','23');                
        <?php } ?>
        <?php if ($Op== '32') //denunciante juridico
        { ?>
                llena_aldea('cboDeptoJ','cboMuniJ','cboAldeaJ','tdAldeaJ','33');
        <?php } ?>
        <?php if ($Op== '42') //denunciado natural
        { ?>
                llena_aldea('cboDepto3','cboMuni3','cboAldea3','tdAldea3','43');                
        <?php } ?>
        <?php if ($Op== '52') //denunciado juridico
        { ?>
                llena_aldea('cboDepto3J','cboMuni3J','cboAldea3J','tdAldea3J','53');
        <?php } ?>    
        <?php if ($Op== '62') //ofendido natural
        { ?>
                llena_aldea('cboDepto4','cboMuni4','cboAldea4','tdAldea4','63');                
        <?php } ?>
        <?php if ($Op== '72') //ofendido juridico
        { ?> 
                llena_aldea('cboDepto4J','cboMuni4J','cboAldea4J','tdAldea4J','73');
        <?php } ?>             
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