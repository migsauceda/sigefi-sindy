<?php
    $sexo= $_POST['sexo'];
    $destino= $_POST['id'];
    
    if($sexo== "m"){
        $nombre= array("No consignado", "Heterosexual", "Homosexual", "Bisexual", "Transexual");
        $valor= array("no","het","gay","bis","tra");
    }
    elseif($sexo=="f"){
        $nombre= array("No consignado", "Heterosexual", "Lesbiana", "Bisexual", "Transexual");
        $valor= array("no","het","les","bis","tra");        
    }
    else{
        $nombre= array("No consignado");
        $valor= array("no");                
    }
?>
<select id="<?php echo $destino; ?>" name="<?php echo $destino; ?>">
    <option value="<?php echo $valor[0]; ?>" > <?php echo $nombre[0]; ?></option>
    <?php 
        for($i= 1; $i < count($nombre); $i++){
    ?>
        <option value="<?php echo $valor[$i]; ?>" > <?php echo $nombre[$i]; ?></option>
    <?php 
        }
    ?>
</select>