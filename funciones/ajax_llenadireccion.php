<?php
    include("../clases/class_conexion_pg.php");

    $Accion= $_POST[accion];

    $objConexion=new Conexion();

    switch ($Accion){
        case "depto":{
            $sql= "select cdepartamentoid, cdescripcion from tbl_departamentopais";

            $resCampo=$objConexion->ejecutarComando($sql);
            while ($fila=pg_fetch_array($resCampo)){
                $Campo= $fila[cdepartamentoid];
                $Descripcion= $fila[cdescripcion];
                ?>
                <option value='<?php echo $Campo?>'><?php echo $Descripcion?></option>
                <?php
            }
	    break;            
        }
        case "muni":{
            $sql= "select cmunicipioid, cdescripcion "
                ."from tbl_municipio "
                ."where cdepartamentoid= '".$_POST[coddepto]."';";

            $resCampo=$objConexion->ejecutarComando($sql);
//            $fila=pg_fetch_array($resCampo);
            while ($fila=pg_fetch_array($resCampo)){
                $Descripcion= $fila[cdescripcion];
                $Campo= $fila[cmunicipioid];
                ?>
                <option value='<?php echo $Campo?>'><?php echo $Descripcion?></option>
                <?php
            }
	    break;
        }
        case "aldea":{
            $sql= "select caldeaid, cdescripcion from tbl_aldea "
                ."where cdepartamentoid= '".$_POST[coddepto]."' and "
                ."cmunicipioid= '".$_POST[codmuni]."' and "
                ."caldeaid= '".$_POST[codaldea]."';";

            $resCampo=$objConexion->ejecutarComando($sql);
//            $fila=pg_fetch_array($resCampo);
            while ($fila=pg_fetch_array($resCampo)){
                $Descripcion= $fila[cdescripcion];
                $Campo= $fila[caldeaid];
                ?>
                <option value='<?php echo $Campo?>'><?php echo $Descripcion?></option>
                <?php
            }
	    break;
        }
        case "barrio":{            
            $sql= "select cbarrioid, cdescripcion from tbl_barrio "
                ."where cdepartamentoid= '".$_POST[coddepto]."' and "
                ."cmunicipioid= '".$_POST[codmuni]."' and "
                ."caldeaid= '".$_POST[codaldea]."';";
            
            $resCampo=$objConexion->ejecutarComando($sql);
            while ($fila=pg_fetch_array($resCampo)){
                $Descripcion= $fila[cdescripcion];
                $Campo= $fila[cbarrioid];            
            ?>
                <option value='<?php echo $Campo?>'><?php echo $Descripcion?></option>
            <?php
            }
	    break;
        }
    }
?>
