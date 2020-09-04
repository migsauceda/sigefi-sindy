<?php
include "conexion.php";
$ids=$_POST["id"];

if ($ids==1) {
?>

<br>
Número de expediente <input class="form-control" type="text" name="expediente" required/>

<br>

Actividad Fiscal
  <select class="selectpicker form-control" data-live-search="true"  name="actividad" required="">
    <option value="">--</option>

  <?php
  $sql='SELECT nactividadid, cdescripcion, netapaid, nsubetapaid FROM mini_sedi.tbl_actividad order by cdescripcion;';
  $con=pg_query($sql);
  while ($fila=pg_fetch_array($con)) {
    echo "<option value=".$fila['nactividadid']." data-tokens=".$fila['nactividadid'].">".$fila['cdescripcion']."</option>";
  }
  ?>
  </select>

  <input type="hidden" name="color_grupo"	id="color_grupo" value="#57ed5a"/>
<?php
}

if ($ids==2) {
  ?>

  <input class="form-control" type="hidden" name="expediente" />


  Atención al Usuario
  <select class="selectpicker form-control" data-live-search="true"  name="actividad" required="">
    <option value="">--</option>
  
  </select>
  <input type="hidden" name="color_grupo"	id="color_grupo" value="#92b8f4"/>
  <?php
} ?>
