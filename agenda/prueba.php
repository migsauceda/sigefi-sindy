<!doctype html>
<html lang="en">
  <head>
    <link href='bootstrap4/css/bootstrap.min.css' rel="stylesheet"/>
    <script src='js/jquery.min.js'></script>
<script type="text/javascript">
$(document).ready(function () {
 $('#entradafilter').keyup(function () {
    var rex = new RegExp($(this).val(), 'i');
      $('.contenidobusqueda tr').hide();
      $('.contenidobusqueda tr').filter(function () {
          return rex.test($(this).text());
      }).show();

      })

});
</script>

  </head>
  <body>


    <?php
    include "conexion.php";

    $act="select hora_inicio,hora_fin,descripcion,fecha_alarma,estado,fecha_actividad,cdescripcion,expediente
    from mini_sedi.tbl_agenda as ag
    inner join mini_sedi.tbl_actividad as act on act.nactividadid = ag.actividad";

    $conss=pg_query($act);
    $fila=pg_fetch_array($conss);


    $horafin=$fila["hora_fin"];
    $expediente=$fila["expediente"];
    $alarma=$fila["fecha_alarma"];
    $actividad=$fila["cdescripcion"];
    $desc=$fila["descripcion"];
?>

<div class="input-group"> <span class="input-group-addon">Filtrado</span>
<input id="entradafilter" type="text" class="form-control">
</div>

    <table width="50%" class="table table-striped">

      <thead>
      <th>codigo</th><th>actividad</th>
      </thead>
      <tbody class="contenidobusqueda">
      <tr>
          <td width="30%"> Código del expediente: </td><td> <?php echo $expediente; ?> <br> </td>
      </tr>
      <tr>
          <td width="30%"> Actividad:</b> <td><?php echo $actividad; ?> <br></td>
      </tr>
    </tbody>
    </table>


  </body>
</html>
