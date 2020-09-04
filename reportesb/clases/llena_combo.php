<?php
include('../conexion/cls_conexion.php');
if (isset($_GET['combo'])){
	$combo=$_GET['combo'];				
}
if (isset($_GET['opcion'])){
	$opcion=$_GET['opcion'];				
}
if (isset($_GET['fiscaliaid'])){
	$fiscaliaid=$_GET['fiscaliaid'];				
}

$conexion=new cls_conexion();
$conexion->conectar();

//1 = todas
if ($opcion==1){
	$resultado=$conexion->consultar("select * from tbl_fiscal");
}else{
	$resultado=$conexion->consultar("select * from tbl_fiscal where nfiscaliaid='$fiscaliaid'");
}

echo "<select id='fiscal$combo' name='fiscal$combo'>
	  <option value='---'>---</option>
	  <option value='todos'>Todos</option>";
while ($row=pg_fetch_assoc($resultado)){	
	echo "<option value='$row[cfiscalid]'>$row[cnombres] $row[capellidos]</option>";
}
echo "</select>";
?>