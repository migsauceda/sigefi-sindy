<?php
    session_start();
    
    include("../clases/class_conexion_pg.php");    
    $participante= $_POST['participante'];
    $destino= $_POST['id'];
    
    $DenunciaId= $_SESSION['denunciaid'];
    
    $sql= ""; //vacio para evitar error ajax al inicio
    
    if (isset($_SESSION['denunciaid'])){
        $objConexion= new Conexion();

        if($participante== "denunciante"){
            $sql= "SELECT 
                    tbl_denunciante.tpersonaid, 
                    tbl_denunciante.cnombres, 
                    tbl_denunciante.capellidos, 
                    tbl_denunciante.tdenunciaid,
                    case tbl_denunciante.bpersonanatural when 't' then '(Natural)' else '(Juridico)' end
                  FROM 
                    mini_sedi.tbl_denunciante
                  WHERE 
                    tbl_denunciante.tdenunciaid = ". $DenunciaId;
        }
        elseif($participante=="denunciado"){
            $sql= "SELECT 
                    tbl_imputado.tpersonaid, 
                    tbl_imputado.cnombres, 
                    tbl_imputado.capellidos, 
                    tbl_imputado.tdenunciaid,
                    case tbl_imputado.bpersonanatural when 't' then '(Natural)' else '(Juridico)' end
                  FROM 
                    mini_sedi.tbl_imputado
                  WHERE 
                    tbl_imputado.tdenunciaid = ". $DenunciaId;  
        }
        else{
            //ofendido
            $sql= "SELECT 
                    tbl_ofendido.tpersonaid, 
                    tbl_ofendido.cnombres, 
                    tbl_ofendido.capellidos, 
                    tbl_ofendido.tdenunciaid,
                    case tbl_ofendido.bpersonanatural when 't' then '(Natural)' else '(Juridico)' end
                  FROM 
                    mini_sedi.tbl_ofendido
                  WHERE 
                    tbl_ofendido.tdenunciaid = ". $DenunciaId;                 
        }

        $cursor= $objConexion->ejecutarComando($sql);   
    }
    
?>
<select id="<?php echo $destino; ?>" name="<?php echo $destino; ?>" onchange='Recargar();'>
    <option value="0">--Seleccione para cargar lista-- </option>
    <?php 
    while($reg= pg_fetch_array($cursor)){
        echo "<option value=$reg[0]>$reg[1]; $reg[2]; $reg[4]</option>";
    }
    ?>
</select>