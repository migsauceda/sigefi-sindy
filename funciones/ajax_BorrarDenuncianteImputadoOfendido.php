<?php
    session_start();
    
    include("../clases/class_conexion_pg.php");    
    $borrar= $_POST['borrar'];
    $persona= $_POST['id'];
    
    $DenunciaId= $_SESSION['denunciaid'];
    
    if (isset($_SESSION['denunciaid'])){
        $objConexion= new Conexion();

        if($borrar== "denunciante"){
//            $sql= "delete FROM mini_sedi.tbl_denunciante
//                  WHERE 
//                    tbl_denunciante.tdenunciaid = $DenunciaId and 
//                    tbl_denunciante.tpersonaid = $persona";
            $Tipo= 'denunciante';
            $sql= "select borrar_denunciante_denunciado_ofendido($DenunciaId, $persona, '$Tipo')";
        }  
        elseif($borrar=="denunciado"){
//            $sql= "delete FROM mini_sedi.tbl_imputado
//                  WHERE 
//                    tbl_imputado.tdenunciaid = $DenunciaId and
//                    tbl_imputado.tpersonaid = $persona";
            $Tipo= 'denunciado';
            $sql= "select borrar_denunciante_denunciado_ofendido($DenunciaId, $persona, '$Tipo')";
        }
        elseif($borrar=="ofendido"){
            //ofendido
//            $sql= "delete FROM mini_sedi.tbl_ofendido
//                  WHERE 
//                    tbl_ofendido.tdenunciaid = $DenunciaId and
//                    tbl_ofendido.tpersonaid = $persona";                 
            $Tipo= 'ofendido';
            $sql= "select borrar_denunciante_denunciado_ofendido($DenunciaId, $persona, "."'".$Tipo."')";
        }
    }
//echo $sql;
    $cursor= $objConexion->ejecutarComando($sql);   
    $err= pg_fetch_array($cursor);
?>
