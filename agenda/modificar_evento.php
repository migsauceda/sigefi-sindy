<?php
include "conexion.php";
$idagm=$_POST["id"];
$fiscal=$_POST["fiscal"];
$actm="select hora_inicio,hora_fin,descripcion,fecha_alarma,estado,fecha_actividad,cdescripcion,expediente,actividad,estado
from mini_sedi.tbl_agenda as ag
inner join mini_sedi.tbl_actividad as act on act.nactividadid = ag.actividad
where agendaid=$idagm";
$conm=pg_query($actm);
$fila=pg_fetch_array($conm);

$horainiciom        =$fila["hora_inicio"];
$horafinm           =$fila["hora_fin"];
$expedientem        =$fila["expediente"];
$alarmam            =$fila["fecha_alarma"];
$nombActividad      =$fila["cdescripcion"];
$desc               =$fila["descripcion"];
$actividad          =$fila["actividad"];
$fecha_alarma       =$fila["fecha_alarma"];
$estado             =$fila["estado"];
$fecha_actividad		=$fila["fecha_actividad"];

?>
<div class="modal-dialog ">
  <div class="modal-content">
      <form method="post" name="modif" action="agendamg.php">
        <input type="hidden" name="fiscal" value="<?php echo $fiscal ?>" />
        <div class="modal-header">
      <h4 class="modal-title" id="modal-title">Modificar Actividad</h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>

    </div>
    <div class="modal-body">

      
      <input type="hidden" name="idag"	id="idag" value="<?php echo $idagm;?>"/>

      Número de expediente <input type="text" name="expediente" value="<?php echo $expedientem  ;?>" /><br>
      Actividad
      <br>
        <select class="selectpicker form-control" data-live-search="true"  name="actividad" required="">
          <option value="">--</option>
      <?php
      $sql='SELECT nactividadid, cdescripcion, netapaid, nsubetapaid FROM mini_sedi.tbl_actividad order by cdescripcion;';
      $con=pg_query($sql);
      while ($fila=pg_fetch_array($con)) {
          if ($fila['nactividadid']==$actividad) {
            echo "<option selected value=".$fila['nactividadid']." data-tokens=".$fila['nactividadid'].">".$fila['cdescripcion']."</option>";
          }
          else {
          echo "<option value=".$fila['nactividadid']." data-tokens=".$fila['nactividadid'].">".$fila['cdescripcion']."</option>";
          }
        }
      ?>
        </select>
        <br>
      Descripción <br> <textarea class="form-control" name="desc" rows="1" cols="50" style=" resize:none; " required><?php echo $desc;?></textarea><br>

      <table>
        <tr>
          <td>
            <label for="fecha">Fecha de la actividad</label>
          </td>
          <td>
            <input type="date" name="fecha_act"	id="fecha_act" value="<?php echo $fecha_actividad;?>" required/>
          </td>
        </tr>
        <tr>
          <td>
            <label for="horainicio">Hora Inicio</label>
          </td>
          <td>
            <input type="time" name="horainicio"  required="" value="<?php echo $horainiciom; ?>" />
          </td>
        </tr>
        <tr>
          <td>
          <label for="horafin">Hora Fin</label>
          </td>
          <td>
          <input type="time" name="horafin"  required="" value="<?php echo $horafinm;?>"/>
          </td>
        </tr>
      </table>
      Estado
      <br>
        <select class="selectpicker form-control" data-live-search="true"  name="estado" required="">
          <option value="">--</option>
      <?php
      $sql='SELECT estadoid, estado FROM mini_sedi.tbl_agenda_estado where activo = 1 order by estadoid;';
      $con=pg_query($sql);
      while ($fila=pg_fetch_array($con)) {
          if ($fila['estadoid']==$estado) {
          echo "<option selected value=".$fila['estadoid']." data-tokens=".$fila['estadoid'].">".$fila['estado']."</option>";
          }
          else {
                   echo "<option value=".$fila['estadoid']." data-tokens=".$fila['estadoid'].">".$fila['estado']."</option>";
          }
        }
      ?>
        </select>
        <br>

      Recordatorio <input type="date" name="recordatorio" value="<?php echo $fecha_alarma  ;?>" /><br>
      Motivo de la edición <br> <textarea class="form-control" name="mot" rows="1" cols="50" style=" resize:none; " required></textarea><br>

    </div>
    <div class="modal-footer">

      <input type="image"  value="guardar" src="img/guardar.png"/>
      <button type="button" class="btn btn-default" data-dismiss="modal"> <img src="img/cerrar.png" height="20" width="20"  title="Cerrar" /> </button>

    </div>
      </form>
  </div>

</div>
