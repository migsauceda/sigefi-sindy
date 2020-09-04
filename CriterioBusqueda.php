<?php
/*Programa: CrieterioBusqueda.php
 *Elaborado: Miguel Sauceda
 *Utilidad: Llena combos de busqueda mediante funciones
*/
include("clases/class_conexion_pg.php");

$Tabla= $_GET[Tabla];

$objConexion=new Conexion();
$sql= "select distinct ccampotxt, ccampo from mini_sedi.tbl_criterio " 
    ."where ctabla= " ."'".$Tabla."'"." order by ccampotxt;";

$resCampo=$objConexion->ejecutarComando($sql);


//agregar opciones
?>
<option value=-1>Seleccione opción...</option>
<?php 
while ($fila=pg_fetch_array($resCampo)){
    $Campo= $fila[ccampo];
    $Descripcion= $fila[ccampotxt]
    ?>
    <option value='<?php echo $Campo?>'><?php echo $Descripcion?></option>
<?php
}
?>
