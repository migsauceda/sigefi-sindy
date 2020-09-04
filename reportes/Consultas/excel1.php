<?php 

header('Content-type:application/xls');
	header('Content-Disposition: attachment; filename=Reporte1.xls');

	  include("../../clases/class_conexion_pg.php");
    include_once "../../funciones/php_funciones.php"; 
	

$fechaminima=$_GET['fecha1'];
$fechamaxima=$_GET['fecha2'];




 ?>

  <table id="myexample" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
      <thead class="bg-gray">
        <tr role="row">
             <th style="text-align: center">tdenunciaid</th>
            <th style="text-align: center">recepcion</th>
            <th style="text-align: center">imputado</th>
            <th style="text-align: center">sex_imp</th>
            <th style="text-align: center">ofendido</th>
            <th style="text-align: center">genero_ofen</th>
            <th style="text-align: center">parentesco_imp_ofen</th>
            <th style="text-align: center">cdescripcion</th>
            <th style="text-align: center">dfechadenuncia</th>
            <th style="text-align: center">depto</th>
            <th style="text-align: center">muni</th>
            <th style="text-align: center">ocupacion</th>
            <th style="text-align: center">estadocivil</th>
            <th style="text-align: center">escolaridad</th>
            <th style="text-align: center">iedad</th>
            <th style="text-align: center">cunidadmedidaedad</th>
            

            
         </tr>
      </thead>
      
      <tbody>
 
          <?php 
  


          
         $consultarNuevo= BusquedaconsultarNuevo($fechaminima, $fechamaxima);
          while ($fila= pg_fetch_array($consultarNuevo)) {
          
           ?>

           <tr>
             <td style="text-align: center; background-color:<?php echo $Color?>"><?php echo $fila['tdenunciaid'];?></td>
             <td style="text-align: center; background-color:<?php echo $Color?>"><?php echo $fila['recepcion'];?></td>
             <td style="text-align: center; background-color:<?php echo $Color?>"><?php echo $fila['imputado'];?></td>
             <td style="text-align: center; background-color:<?php echo $Color?>"><?php echo $fila['sex_imp'];?></td>
               <td style="text-align: center; background-color:<?php echo $Color?>"><?php echo $fila['ofendido'];?></td>
             <td style="text-align: center; background-color:<?php echo $Color?>"><?php echo $fila['genero_ofen'];?></td>
             <td style="text-align: center; background-color:<?php echo $Color?>"><?php echo $fila['parentesco_imp_ofen'];?></td>
             <td style="text-align: center; background-color:<?php echo $Color?>"><?php echo $fila['cdescripcion'];?></td>
               <td style="text-align: center; background-color:<?php echo $Color?>"><?php echo $fila['dfechadenuncia'];?></td>
             <td style="text-align: center; background-color:<?php echo $Color?>"><?php echo $fila['depto'];?></td>
             <td style="text-align: center; background-color:<?php echo $Color?>"><?php echo $fila['muni'];?></td>
             <td style="text-align: center; background-color:<?php echo $Color?>"><?php echo $fila['ocupacion'];?></td>
               <td style="text-align: center; background-color:<?php echo $Color?>"><?php echo $fila['estadocivil'];?></td>
             <td style="text-align: center; background-color:<?php echo $Color?>"><?php echo $fila['escolaridad'];?></td>
             <td style="text-align: center; background-color:<?php echo $Color?>"><?php echo $fila['iedad'];?></td>
             <td style="text-align: center; background-color:<?php echo $Color?>"><?php echo $fila['cunidadmedidaedad'];?></td>
           

             

           </tr>

           <?php 
         }
       
           ?>
     </tbody>
   </table>
