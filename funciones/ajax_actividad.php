<?php

include("../clases/class_conexion_pg.php");

    $valor = $_POST['valor'];//etapa
    $iddestino = $_POST['iddestino'];//Id del objeto
    $objConexion=new Conexion(); 
    $sql= "select nactividadid, cdescripcion
            from tbl_actividad
            where netapaid= '$valor';";

    $resultado=$objConexion->ejecutarComando($sql);
    $indicador=pg_num_rows($resultado);
    if ($indicador > 0)
    {?>
        <select id='<?php echo $iddestino;?>' name ='<?php echo $iddestino;?>'>
        <option value="">Seleccione...</option>
        <?php for($i=0;$i<$indicador;$i++)
        {
            $row =pg_fetch_array($resultado);
            $code=$row[0];
            $des =$row[1];?>
            <option value='<?php echo$code?>'><?php echo$des?></option>
  <?php }?>
        </select>
  <?php }

?>