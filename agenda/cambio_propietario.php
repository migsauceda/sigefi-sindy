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
$fiscal1=$filaa["fiscal"];
?>
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Cambiar de propietario</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form name="propietario" method="post" action="g_cambio_propietario.php">
        <div class="modal-body">
          <h6>Actividad</h6>
          <table width="100%" class="table">
            <tr>
                <td width="30%"> <b><?php echo $nombre; ?></b></td> <td><b><?php echo date("d-m-Y", strtotime($fecha)) ; ?></b> <br></td>
            </tr>
          </table>

          <br>
          <div class="form-group">
            <label for="fecha">Seleccione el fiscal al cual asignara la actividad</label>
            <br>
            <select name="fiscal" class="form-control" data-live-search="true" required="">
  						<option value="">--</option>
      				<?php
      			  $sql="select usuario,nombres,apellidos from mini_sedi.tbl_usuarios where fiscal ='true'order by usuario;";
      				$con=pg_query($sql);
      				while ($fila=pg_fetch_array($con))
              {
  						echo "<option value=".$fila['usuario']." data-tokens=".$fila['usuario']." >". $fila['nombres']." ".$fila['apellidos']."</option>";
  					  }
  				    ?>
  					</select>

            <input type="hidden" name="actividad" value="<?php echo $idaga; ?>" />
            <input type="hidden" name="fiscal1" value="<?php echo $fiscal1; ?>" />
          </div>


        </div>
        <div class="modal-footer">
          <input type="image"  value="guardar" src="img/guardar.png"/>
          <button type="button" class="btn btn-default" data-dismiss="modal"> <img src="img/cerrar.png" height="20" width="20"  title="Cerrar" /> </button>
        </div>
      </form>
      </div>
    </div>
