<?php
include "conexion.php";
$idaga=$_POST["id"];
$acta="select cdescripcion,expediente,fecha_actividad,fiscal
from mini_sedi.tbl_agenda as ag
inner join mini_sedi.tbl_actividad as act on act.nactividadid = ag.actividad
where agendaid=$idaga";
$cona=pg_query($acta);
$filaa=pg_fetch_array($cona);
$nombre=$filaa["cdescripcion"];
$fecha=$filaa["fecha_actividad"];
$fiscal=$filaa["fiscal"];
?>
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Recalendarizar</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form name="propietario" method="post" action="g_recalendarizar.php">
        <div class="modal-body">
          <h6>Actividad</h6>
          <table width="100%" class="table">
            <tr>
                <td width="30%"> <b><?php echo $nombre; ?></b></td> <td><b><?php echo date("d-m-Y", strtotime($fecha)) ; ?></b> <br></td>
            </tr>
          </table>

          <br>
          <div class="form-group">
            <label for="fecha">Fecha a asignar actividad</label>
            <br>
            <input type="date" name="reasignacion"	id="reasignacion" required/>
            <br><br>
            <label for="mot">Motivo de la edición</label> <br> <textarea class="form-control" name="mot" rows="2" cols="50" style=" resize:none; " required></textarea><br>

            <input type="hidden" name="actividad" value="<?php echo $idaga; ?>" />
            <input type="hidden" name="fiscal" value="<?php echo $fiscal; ?>" />
          </div>


        </div>
        <div class="modal-footer">
          <input type="image"  value="guardar" src="img/guardar.png"/>
          <button type="button" class="btn btn-default" data-dismiss="modal"> <img src="img/cerrar.png" height="20" width="20"  title="Cerrar" /> </button>
        </div>
      </form>
      </div>
    </div>
