<?php

include "conexion.php";
 $hi=$_POST["horainicio"];
 $hf=$_POST["horafin"];

 $hi= strtotime( "$hi" );
 $hf= strtotime( "$hf" );

 $fecha=$_POST[ "fechaseleccionada" ];

 include("../clases/Usuario.php");
 session_start();
 if (isset($_SESSION['objUsuario'])){
 		$objUsuario= $_SESSION['objUsuario'];
 }
  $us=$objUsuario->getUsuario();

     $hora=" select hora_inicio,hora_fin from mini_sedi.tbl_agenda where fiscal='$us' and fecha_actividad='$fecha' and activo=1 order by hora_inicio";
     $con=pg_query($hora);

     while ($fila=pg_fetch_array($con)) {

        $h1=$fila["hora_inicio"];
        $h2=$fila["hora_fin"];

        $h1 = strtotime( "$h1" );
        $h2 = strtotime( "$h2" );

       if( $hi >= $h1   &&   $hi <= $h2   &&   $hf >= $h1  &&  $hf <= $h2 )
       {
            echo '<label style="color:#f70909">La hora ingresado coincide con otra actividad </label>';
            break;
       }
       elseif ($hi <= $h1   &&   $hf >= $h1)
       {
            echo '<label style="color:#f70909">La hora de fin coincide con otra actividad</label>';
            break;
       }
       elseif ($hi <= $h2   &&   $hf >= $h2)
       {
            echo '<label style="color:#f70909">La hora de inicio conicide con otra actividad programada </label>';
            break;
       }
       else {

       }


     }

 ?>
