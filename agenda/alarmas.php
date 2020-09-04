<?php
    include "../clases/class_conexion_pg.php";
    $con=new Conexion();
    include("../clases/Usuario.php");
//    include "funciones/php_funciones.php";

    session_start();

    if (isset($_SESSION['objUsuario'])){
        $objUsuario= $_SESSION['objUsuario'];
    }
   $usuario=$objUsuario->getUsuario();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link href='../reporteria/bootstrap-4/css/bootstrap.min.css' rel="stylesheet"/>
    <script src='../reporteria/bootstrap-4/js/bootstrap.min.js'></script>
  </head>
  <body>


    <br><br>
    <div style="width:50%; margin-left:auto; margin-right:auto">

      <div align="right">
        <form id="alarmas" method="post" action="agenda.php">
        <input type="hidden" name="usuario" value="<?php echo $usuario; ?>">
        <input type="submit" class="btn btn-link"  value="Ver Agenda">
        </form>
      </div>
    <div class="page-header" align="center">  <h3>Alarma de Actividades</h3>  </div>
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Actividad</th>
          <th scope="col">Fecha</th>
        </tr>
      </thead>
      <tbody>

<?php
$fecha_hoy=date("Y-m-d");
$act="select cdescripcion,fecha_actividad from mini_sedi.tbl_agenda as ag
inner join mini_sedi.tbl_actividad as act on act.nactividadid=ag.actividad
where fecha_alarma='$fecha_hoy' and fiscal='$usuario' and activo = 1";
$res= $con->ejecutarComando($act);
$contador=1;
while ($fila=pg_fetch_array($res)) {
  echo  '<tr>';
  echo  '<th scope="row">'.$contador.'</th>';
  echo  '<td>'.$fila["cdescripcion"].'</td>';
  echo  '<td>'.date("d-m-Y", strtotime($fila["fecha_actividad"])).'</td>';
  echo  '</tr>';
  $contador++;
}

?>
      </tbody>
    </table>
</div>


  </body>
</html>
