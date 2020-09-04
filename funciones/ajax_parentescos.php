<?php
    include("../clases/class_conexion_pg.php");
    
    $objConexion=new Conexion(); 
    $sql= "select nparentescoid, cdescripcion, creciproco from tbl_parentescos;";
    $resParentescos= $objConexion->ejecutarComando($sql);
    $registro= $objConexion->ejecutarComando($sql);
    $indicador=pg_num_rows($resParentescos);    
       
    if ($indicador > 0){
    ?>
    <select id="<?php echo $destino; ?>" name="<?php echo $destino; ?>">
        <option value="">Seleccione...</option>
        <?php 
            for($i= 1; $i < count($indicador); $i++){
        ?>
            <option value="<?php echo $registro[nparentescoid]; ?>" > <?php echo $registro[cdescripcion]; ?></option>
        <?php 
            }
        ?>
    </select>
      <?php }
?>