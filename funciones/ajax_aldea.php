<?php
//aldea o ciudad

include("../clases/class_conexion_pg.php");

//se reciben datos
$IdOrigen_depto= $_POST['idorigen_depto'];
$IdOrigen_muni= $_POST['idorigen_muni'];
$IdDestino= $_POST['iddestino'];
$Op= $_POST['op'];

if($Op== '13' || $Op== '23' || $Op== '33' || $Op== '43' || $Op== '53' || $Op== '63' || $Op== '73'){
    $sql= "SELECT caldeaid, cdescripcion FROM tbl_aldea
                WHERE cdepartamentoid= '$IdOrigen_depto' AND cmunicipioid= '$IdOrigen_muni'
                 order by cdescripcion;";
}
$objConexion= new Conexion();
$resultado=$objConexion->ejecutarComando($sql);
$total= pg_num_rows($resultado);
if ($total > 0){
?>  

    <select id='<?php echo $IdDestino;?>' name ='<?php echo $IdDestino;?>' onchange="
        <?php if ($Op== '13') //generales
        { ?>
//            alert('dgdththjydj');   
            llena_barrio('cboDepto2','cboMuni2','cboAldea2','cboBarrio2','tdBarrio2','14');       
        <?php } ?> 
        <?php if ($Op== '23') //denunciante natural
        { ?>
            //alert('dgdththjydj');   
            llena_barrio('cboDepto','cboMuni','cboAldea','cboBarrio','tdBarrio','24');       
        <?php } ?>            
        <?php if ($Op== '33') //denunciante juridico
        { ?>
            //alert('dgdththjydj');   
            llena_barrio('cboDeptoJ','cboMuniJ','cboAldeaJ','cboBarrioJ','tdBarrioJ','34');       
        <?php } ?>  
        <?php if ($Op== '43') //denunciado natural
        { ?>  
            llena_barrio('cboDepto3','cboMuni3','cboAldea3','cboBarrio3','tdBarrio3','44');       
        <?php } ?>            
        <?php if ($Op== '53') //denunciado juridico
        { ?>
            //alert('dgdththjydj');   
            llena_barrio('cboDepto3J','cboMuni3J','cboAldea3J','cboBarrio3J','tdBarrio3J','54');       
        <?php } ?>  
        <?php if ($Op== '63') //ofendido natural
        { ?>  
            llena_barrio('cboDepto4','cboMuni4','cboAldea4','cboBarrio4','tdBarrio4','64');       
        <?php } ?>            
        <?php if ($Op== '73') //ofendido juridico
        { ?>
//            alert('dgdththjydj');   
            llena_barrio('cboDepto4J','cboMuni4J','cboAldea4J','cboBarrio4J','tdBarrio4J','74');       
        <?php } ?>              
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
<?php } ?>     
