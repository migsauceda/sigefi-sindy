<?php
session_start();
include("../clases/class_conexion_pg.php");

$objConexion= new Conexion();

//por cada denunciado vs denunciante
$DenunciadoDenunciante= array();
$fila= 0;
for($i= $_POST['txtcontadorimputado']; $i > 0; $i--){
    $ElementoArreglo1= $ElementoArreglo1 . $_POST['denunciadoid'.($i-1)] . ',';
    
    for($j= $_POST['txtcontadordenunciante']; $j > 0; $j--){
        $ElementoArreglo1= $ElementoArreglo1 . $_POST['denuncianteid'.$fila] . ',';
        $ElementoArreglo1= $ElementoArreglo1 . $_POST['parid'.$fila] . ',';
        $fila++;
    }
}
$max= strlen($ElementoArreglo1);
$ElementoArreglo1= substr($ElementoArreglo1, 0,$max-1);

//por cada denunciado   vs ofendido
$DenunciadoDenunciado= array();
$fila= 0;
for($i= $_POST['txtcontadorimputado']; $i > 0; $i--){
    $ElementoArreglo2= $ElementoArreglo2 . $_POST['denunciadoid'.($i-1)] . ',';
    
    for($j= $_POST['txtcontadorofendido']; $j > 0; $j--){
        $ElementoArreglo2= $ElementoArreglo2 . $_POST['ofendidoid'.$fila] . ',';
        $ElementoArreglo2= $ElementoArreglo2 . $_POST['parid2'.$fila] . ',';
        $fila++;
    }
}
$max= strlen($ElementoArreglo2);
$ElementoArreglo2= substr($ElementoArreglo2, 0,$max-1);

//enviar a la base de datos
$sql= "SELECT relacion_insert("
    .$_SESSION['denunciaid'].", "
    ."array[".$ElementoArreglo1."], "
    ."array[".$ElementoArreglo2."], "
    .$_POST['txtcontadordenunciante'].", "
    .$_POST['txtcontadorimputado'].", "
    .$_POST['txtcontadorofendido']
.")";
//exit($sql);
//ejecutar query
$reg= $objConexion->ejecutarComando($sql);
$err= pg_fetch_array($reg);  

if ($err['codigo']!= 0){
    //error
    $mostrar= '<script type="text/javascript">';
    $mostrar.= 'alert("Error al guardar datos, verifique que no esten duplicados")';
    $mostrar.= '</script>';
    echo $mostrar;        
}
else{
    //mostrar mensaje de exito, en el formulario generales
//    header("location: ../relacion/relacion.php?rsl=100");    
    header("location: frmExpediente.php?tab=4&rsl=100");
}

echo $ElementoArreglo1 . " ---- " . $ElementoArreglo2;
?>