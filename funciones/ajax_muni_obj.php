<?php
include "../clases/class_conexion_pg.php";
include "../clases/DeptoMuniCiudad.php";
?>
<select name="MuniBandeja" id="MuniBandeja">
    <?php   
        $muni= new DeptoMuniCiudad($_POST["data"]);
        $cursor= $muni->getMunicipioLista();
        echo "<option value='1'>Seleccione</option>";
        while ($reg= pg_fetch_array($cursor)){    
            echo "<option value=  $reg[cmunicipioid] >$reg[cdescripcion]</option>";    
        }    
    ?>
</select>
