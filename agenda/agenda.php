<!DOCTYPE html>
<?php

include("../clases/Usuario.php");
session_start();
if (isset($_SESSION['objUsuario'])){
		$objUsuario= $_SESSION['objUsuario'];
}
 $rol=$objUsuario->getRolId();

include 'conexion.php';
$fiscal="";
if (isset($_POST["usuario"])) {
	$fiscal=$_POST["usuario"];
}
if (isset($_GET["usuario"])) {
	$fiscal=$_GET["usuario"];
}

?>
<html>
<head>
<meta charset='utf-8' />
<link href='css/fullcalendar.min.css' rel='stylesheet' />
<link href='css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<link href='bootstrap4/css/bootstrap.min.css' rel="stylesheet"/>
<link href='css/iconos.css' rel='stylesheet' />
<link rel="stylesheet" href="css/calendario.css">
<script src='js/moment.min.js'></script>
<script src='js/jquery.min.js'></script>
<script src='js/fullcalendar.min.js'></script>
<script src='bootstrap4/js/bootstrap.min.js'></script>
<script src='js/es.js'></script>
<script src='js/funciones.js'></script>

<script type="text/javascript">
function validar_hora1(fechaact,div,url){
if (document.getElementById("hora_inicio").value!="" && document.getElementById("hora_fin").value!="") {
				if(document.getElementById("hora_inicio").value > document.getElementById("hora_fin").value)
				{
					$("#hora_inicio").val("");
					$("#hora_fin").val("");
				}
				var horainicio 				= document.getElementById("hora_inicio").value;
				var horafin						= document.getElementById("hora_fin").value;
				var fechaseleccionada =	document.getElementById("fecha_act").value;
				validar_hora(horainicio,horafin,fechaseleccionada,div,url);
}
else {}
}
</script>

<script>
	$(document).ready(function() {
		var initialLocaleCode = 'es';
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay,listMonth'
			},
			defaultDate: '<?php echo date("Y-m-d"); ?>',
			locale: initialLocaleCode,
			buttonIcons: false,
			weekNumbers: true,
			navLinks: true,
			editable: false,
			eventLimit: false,
			events: [
				<?php
				$sql1="	SELECT agendaid, ac.cdescripcion, agendaid, hora_inicio, hora_fin, descripcion, motivo_reasignacions, fiscal, fecha_alarma, estado, fecha_actividad, actividad,color_grupo
								FROM mini_sedi.tbl_agenda as ag
								inner join mini_sedi.tbl_actividad as ac on ag.actividad=ac.nactividadid
								where ag.fiscal='$fiscal' and activo=1";
				$cons=pg_query($sql1);
				while ($fila1=pg_fetch_array($cons)) {
				?>
				{
					id:			'<?php echo $fila1["agendaid"]; ?>',
					title: 	'<?php echo $fila1["cdescripcion"]; ?>',
					start:	'<?php echo $fila1["fecha_actividad"]; ?>T<?php echo $fila1["hora_inicio"]; ?>',
					end:		'<?php echo $fila1["fecha_actividad"]; ?>T<?php echo $fila1["hora_fin"]; ?>',
					color:	'<?php echo $fila1["color_grupo"]; ?>'
				},
				<?php }?>
			],


							dayClick: function(date, jsEvent, view) {

											rol=document.getElementById("rol");
											if (rol.value==2) {
												$('#fecha_act').val(date.format("YYYY-MM-DD"));
												$('#title-fecha').html(date.format("DD-MM-YYYY"));
												$('#actividad').modal('show');
											}
											else {

											}

							},


						eventClick: function(calEvent) {
										carga_ajax(calEvent.id,'cambiar','detalle_evento.php','<?php echo $fiscal; ?>');
										$('#detalle').modal('show');
				    			}

		});
	});
</script>
</head>
<body>

		<?php
		if ($rol==3 || $rol==16)
				{

					$sqlUsuario="select nombres,apellidos from mini_sedi.tbl_usuarios where usuario='$fiscal'";
					$consUsuario=pg_query($sqlUsuario);
					while ($filaUsuario=pg_fetch_array($consUsuario)) {
					echo '<div align="center">';
					echo '<b>Fiscal:</b>';
					echo ' '.$filaUsuario["nombres"]."&nbsp".$filaUsuario["apellidos"];

					echo '</div>';
				}
		}
		?>
<div id='calendar'></div>
<div class="container"></div>

<div class="modal fadeIn" id="actividad" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modal-title">Asignar Actividad</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				Ingrese actividad para la fecha <b> <div id='title-fecha'> </div> </b>
				<form method="post" name="actividad" action="agendag.php">
				<input type="hidden" name="rol" id="rol" value="<?php echo $objUsuario->getRolId(); ?>"/>
				<input type="hidden" name="fecha_act"	id="fecha_act"/>

				<input type="hidden" name="fiscal" id="fiscal" value="<?php echo $fiscal ?>" />
					<br>
				<input id="tab-1" type="radio" name="tab-group" required  onclick="carga_ajax('1','activ','categorias_actividad.php')"/>
						<label for="tab-1">Actividad Fiscal</label>
						<input id="tab-2" type="radio" name="tab-group" onclick="carga_ajax('2','activ','categorias_actividad.php')" />
						<label for="tab-2">Otras Actividades</label>
						<div id="activ"></div>

				Descripción <br> <textarea class="form-control" name="desc" rows="2" cols="50" style=" resize:none; " required/></textarea><br>
				Hora Inicio <input type="time" name="horainicio" id="hora_inicio"  required="" onblur="validar_hora1(getElementById('fecha_act').value,'val_hora','validar_hora.php')" /> &nbsp;
				Hora Fin 		<input type="time" name="horafin"    id="hora_fin"  	 required="" onblur="validar_hora1(getElementById('fecha_act').value,'val_hora','validar_hora.php')" /><br>
				<div id="val_hora"></div><br>
				Recordatorio <input type="date" name="recordatorio"	id="recordatorio"/>

			</div>
			<div class="modal-footer">
				<input type="image"  value="guardar" src="img/guardar.png"/>
				<button type="button" class="btn btn-link" data-dismiss="modal"> <img src="img/cerrar.png" height="20" width="20"  title="Cerrar" /> </button>
			</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fadeIn" id="detalle" role="dialog">
<div class="modal-dialog ">
<div class="modal-content">
	<div class="modal-header">
		<h4 class="modal-title" id="modal-title">Detalle de la Actividad</h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
		<div id="cambiar">
		</div>
</div>
</div>
</div>

<div align="left" class="modal fadeIn" id="modificacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>
<div class="modal fadeIn" id="propietario" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>
<div class="modal fadeIn" id="recalendarizar" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"></div>

<?php
if ($rol==2) {
?>
	<div align="center">
			<h4>
					<a href="javascript:location.href='alarmas.php'"><b>Regresar</b></a>
			</h4>
	</div>
<?php
}
 ?>

 <?php
 if ($rol==3) {
 ?>
 	<div align="center">
 			<h4>
 					<a href="javascript:location.href='busqueda_fiscalia.php'"><b>Regresar</b></a>
 			</h4>
 	</div>
 <?php
 }
  ?>

	<?php
	if ($rol==16) {
	?>
	 <div align="center">
			 <h4>
					 <a href="javascript:location.href='busqueda_fiscal2.php'"><b>Regresar</b></a>
			 </h4>
	 </div>
	<?php
	}
	 ?>

</body>
</html>
