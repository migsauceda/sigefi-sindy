<?php
include "conexion.php";

include("../clases/Usuario.php");
session_start();
if (isset($_SESSION['objUsuario'])){
		$objUsuario= $_SESSION['objUsuario'];
}
 $rol=$objUsuario->getRolId();


$idact=$_POST["id"];
$fiscal=$_POST["fiscal"];
$act="select hora_inicio,hora_fin,descripcion,fecha_alarma,e.estado,fecha_actividad,cdescripcion,expediente
from mini_sedi.tbl_agenda as ag
inner join mini_sedi.tbl_actividad as act on act.nactividadid = ag.actividad
inner join mini_sedi.tbl_agenda_estado as e on e.estadoid = ag.estado
where agendaid=$idact";
$conss=pg_query($act);
$fila=pg_fetch_array($conss);

$horainicio 				=$fila["hora_inicio"];
$horafin    				=$fila["hora_fin"];
$expediente 				=$fila["expediente"];
$alarma     				=$fila["fecha_alarma"];
$actividad  				=$fila["cdescripcion"];
$desc       				=$fila["descripcion"];
$estado     				=$fila["estado"];
$fecha_actividad		=$fila["fecha_actividad"];

?>
  <div class="modal-body">
    <table width="100%" class="table table-bordered">
			<tr>
          <td width="30%"> <b>Fecha:</b> </td><td> <?php echo date("d-m-Y", strtotime($fecha_actividad)); ?> <br> </td>
      </tr>

			<tr>
          <td width="30%"> <b>Código del expediente:</b> </td><td> <?php echo $expediente; ?> <br> </td>
      </tr>
      <tr>
          <td width="30%"> <b>Actividad:</b></td> <td><?php echo $actividad; ?> <br></td>
      </tr>
      <tr>
          <td width="30%"> <b>Descripción:</b></td> <td><?php echo $desc; ?> <br></td>
      </tr>
      <tr>
          <td width="30%"> <b>Hora Inicio:</b></td><td> <?php echo $horainicio; ?> <br></td>
      </tr>
      <tr>
          <td width="30%"> <b>Hora Fin:</b> </td><td> <?php echo $horafin; ?> <br></td>
      </tr>
      <tr>
          <td width="30%"> <b>Estado:</b> </td><td> <?php echo $estado; ?> <br></td>
      </tr>

      <tr>
            <?php
              if ($alarma==NULL) {
                ?>
                 <td width="30%"> <b>Recordatorio:</b> </td> </td>
            <?php
              }
              else {
                ?>
               <td width="30%"> <b>Alarma:</b> </td><td> <?php echo  date("d-m-Y", strtotime($alarma)) ; ?> <br> </td>
            <?php
              }
            ?>

      </tr>
    </table>
  </div>
  <div class="modal-footer">
    <?php if ($rol==2) { ?>
    <a  href="javascript:void(0);" data-toggle="modal" data-dismiss="modal" data-target="#modificacion"  onclick="carga_ajax(<?php echo $idact; ?>,'modificacion','modificar_evento.php','<?php echo $fiscal; ?>')"> <img src="img/editar.png" height="20" width="20" title="Editar" /></a>
    <?php } ?>

    <?php if ($rol==3 || $rol==16) { ?>
    <a  href="javascript:void(0);" data-toggle="modal" data-dismiss="modal" data-target="#propietario"  onclick="carga_ajax(<?php echo $idact; ?>,'propietario','cambio_propietario.php')"> <img src="img/reenviar.png" height="20" width="20" title="Cambiar de Propietario" /></a>
      <?php } ?>

    <?php if ($rol==2000) { ?>
    <a  href="javascript:void(0);" data-toggle="modal" data-dismiss="modal" data-target="#recalendarizar"  onclick="carga_ajax(<?php echo $idact; ?>,'recalendarizar','recalendarizar.php')"> <img src="img/recalendarizar.png" height="20" width="20" title="Recalendarizar" /></a>
    <?php } ?>

    <?php if ($rol==2) { ?>
    <a  href="javascript:void(0);" onclick="document.location.href='borrar_actividad.php?id=<?php echo $idact; ?>&usuario=<?php echo $fiscal; ?>'"><img src="img/borrar.png" title="borrar"/></a>
    <?php } ?>


    <button type="button" class="btn btn-link" data-dismiss="modal" title="Cerrar"> <img src="img/cerrar.png" height="20" width="20"   /> </button>

  <!--  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button> -->

  </div>
