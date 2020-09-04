<?php
include("../clases/class_conexion_pg.php");

$denunciado= $_POST['denunciado'];

$sql= "
    select case when crangoedad= 'a' then 'Adulto' 
            when crangoedad= 'ni' then  'Infante'
            when crangoedad= 'na' then 'Adolescente'
            when crangoedad= 'nm' then 'Menor adulto'
            when crangoedad= 'am' then 'Adulto mayor'
            else 'desconocido'
            end as rango,
    iedad, 
    case when cunidadmedidaedad= 'a' then 'años'
            when cunidadmedidaedad= 'm' then 'meses'
            when cunidadmedidaedad= 'd' then 'días'
            else 'desconocido'
            end as unidad
    from mini_sedi.tbl_imputado 
    where tpersonaid= $denunciado";

$conexion= new Conexion();
$cursor= $conexion->ejecutarProcedimiento($sql);
$reg= pg_fetch_array($cursor);

while ($reg){
    echo $reg[rango]." ".$reg[iedad]." ".$reg[unidad]; 
    $reg= pg_fetch_array($cursor);
}
?>
