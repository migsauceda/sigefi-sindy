<?php
include("../clases/class_conexion_pg.php");

$opcion= $_POST['opcion'];

$objConexion=new Conexion(); 
switch ($opcion){
    case 1:
        $imputado= $_POST['imputado'];
//        $sql= "select capellidos || ', ' || cnombres as nombref, cfiscalid from tbl_imputado_fiscal, tbl_usuarios where bactivo= '1' and " 
//	."identidad= cfiscalid and timputadoid= ".$imputado.";";
        
        $sql= "select apellidos || ', ' || nombres as nombref, identidad 
               from mini_sedi.tbl_imputado_fiscal, mini_sedi.tbl_usuarios where tbl_imputado_fiscal.bactivo= '1' and 
               identidad= cfiscal and timputadoid= ".$imputado.";";
        $resFiscal=$objConexion->ejecutarComando($sql);
        $registro= pg_fetch_assoc($resFiscal);
   
        echo json_encode($registro);
        break;
    
    case 2:
        $etapa= $_POST['etapa'];
	$sql= "select nsubetapaid, cdescripcion from tbl_subetapa "
                ."where netapaid= ".$etapa.";";
	$resSubEtapa=$objConexion->ejecutarComando($sql);   
        $reg= pg_fetch_assoc($resSubEtapa);
        
	?><option value="0">--Seleccione--</option><?php 
        while ($reg){
            ?>
            <option value="<?php echo $reg[nsubetapaid]; ?>"><?php echo $reg[cdescripcion]; ?></option>
            <?php
            $reg= pg_fetch_assoc($resSubEtapa);
        }
        break;
        
    case 3:
        $etapa= $_POST['etapa'];
        $subetapa= $_POST['subetapa'];
	$sql= "select nactividadid, cdescripcion from tbl_actividad 
		where nsubetapaid= ".$subetapa." and "
                ."netapaid= ".$etapa.";";
	$resActividad=$objConexion->ejecutarComando($sql); 
        $reg= pg_fetch_assoc($resActividad);

        ?><option value="0">--Seleccione--</option><?php 
        while ($reg){
            ?>
            <option value="<?php echo $reg[nactividadid]; ?>"><?php echo $reg[cdescripcion]; ?></option>
            <?php
            $reg= pg_fetch_assoc($resActividad);
        }
        break;        
}

?>
