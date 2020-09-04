<?php
include("../clases/class_conexion_pg.php");

$txtjson= $_POST[txtjson];
$json= json_decode($txtjson);

$objConexion= new Conexion();

//inicia transaccion
$objConexion->begintransaction();

//variable para saber si hacer commit
$commit= "false";
$resultado= "false";
$error;

for($i= 0; $i < count($json); $i++){
    //desactivar el expediente al fiscal actual
    $sql1= "update mini_sedi.tbl_imputado_fiscal set bactivo= false "
            . "where tdenunciaid= '".$json[$i]->denuncia."' and cfiscal= '".$json[$i]->origen."';";
      
    $resultado1= $objConexion->Insertar($sql1);
 
    //asignar al nuevo fiscal
    $sql2= "insert into mini_sedi.tbl_imputado_fiscal (cfiscal, tdenunciaid, timputadoid, dfechaasignacion, bactivo, dfechatransaccion) "
            . "select distinct '".$json[$i]->destino."', tdenunciaid, timputadoid, now(), true, now() "
            . "from mini_sedi.tbl_imputado_fiscal "
            . "where cfiscal= '".$json[$i]->origen."' and tdenunciaid= '".$json[$i]->denuncia."';";

    $resultado2= $objConexion->Insertar($sql2);
    
    if (!$resultado1 and !$resultado2)
    {
        $commit= "false";    
        $error= pg_result_error(pg_get_result($objConexion->Conexion()));
        break;
    }
    else{
        $commit= "true";
    }
}    

if ($commit== "true"){
    $objConexion->commit();    ?>
    <script language="javascript">
        alert("Asignación exitosa");
    </script>    
<?php }
else{
    $objConexion->rollback();?>
    <script language="javascript">
        alert("Error no se pudieron asignar los expedientes\n"+"<?php echo $error; ?>");
    </script>        
<?php }
?>