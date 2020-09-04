<?php

include ('Usuario.php');

session_start();
if(isset($_SESSION['objUsuario']) ){
	$var=$_SESSION['objUsuario'];
		//echo $var->getPermiso(11);
if($var->getPermiso(11)!=0){


	//echo $var->getPermiso();


?>
<!DOCTYPE html>
<html lang="en" >
    <head>
        <script src="app/reportes/FiscalJefe/fiscaljefe.js"></script>
    </head>
<div id="wrapper">

	<div id="page-wrapper">
		<!--<div ng-include src="'./app/html/tarjeta-superior.html'"></div>-->
		    <div class="row">
                <div class="col-lg-12">

                    <h1 class="page-header">Reportes fiscal en jefe </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12 form-inline">

                     <!--<div class="form-group">

                              <label for="ibandejaid">Fiscalía</label>
                                <select  id="ibandejaid" name="ibandejaid" class="select ibandejaid">


                                 </select>

                    </div>-->

                     <div class="form-group ">

                              <label for="idusuario">Usuario</label>
                                <select  id="idusuariohijo" name="idusuariohijo" class="select idusuariohijo">


                                 </select>

                     </div>

                      <div class="form-group ">



                              <label for="fecha_inicial">Fecha inicial</label>
                               <input type="text" id="fecha_inicial_j" name="fecha_inicial_j">
                               <!-- <input type="date" id="fecha_inicial">-->

                      </div>

                       <div class="form-group ">

                              <label for="fecha_final">Fecha final</label>
                               <!--<input type="date" id="fecha_final">-->
                                <input type="text" id="fecha_final_j" name="fecha_final_j">

	                    </div><br><br>
 	
		<input type="text" id="usersesion" clase="usersesion" value="<?php echo $var->getUsuario(); ?>">
		<input type="hidden" id="ipreal" clase="ipreal" value="<?php echo $var->getRealIP(); ?>">
                        <div class="form-group ">
                                <button class="btn-primary buscar_actividadfiscajefe"> Buscar</button>
                        </div>

                    </div>

                </div> <br>
         <div class="row">

                <div class="col-lg-12">
                    <div class="row">
                       <div class="col-lg-12">
                         <div class="table-responsive">
                             <table class="table table-bordered table-hover table-striped" id="ActividadFiscalTJefe">
                                  <thead>
                                    <tr>
                                    <th>Fecha denuncia</th>
                                     <th>No. denuncia</th>
                                     <th>Nombre imputado</th>
                                      <th>Nombre ofendido</th>
                                     <!--agregar nombre ofendido-->

                                     <!--Breve observacion-->
                                    <!-- <th>Fiscalía</th>-->
                                      <th>Delito</th>
                                       <th>Fecha diligencia</th>
                                     <th>Actividad</th>
                                     <th>Sub etapa</th>
                                     <th>Etapa</th>
                                     <th>Materia</th>
                                     <th>Obervación</th>


                                    <!-- <th>Expediente</th> -->
                                     <!--<th>Rtn imputado</th>  -->
                                     <!--<th>Fiscalía asignada</th>-->

                                   </tr>
                                   </thead>
                                    <tbody  id="tablaresjefe">




                                    </tbody>
                                </table>
                             </div>



                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->

                </div>

        </div>
                <!-- /.col-lg-12 -->
            </div>
	</div>

    <script>
        $( function() {
            //$("#").datepicker();
            $( "#fecha_inicial_j" ).datepicker({ dateFormat: 'yy-mm-dd' });
            //$("#fecha_final").datepicker();
             $( "#fecha_final_j" ).datepicker({ dateFormat: 'yy-mm-dd' });

        } );
    </script>
    </html>
<?php
	}
  else{
       echo '<script>alert("No tiene permiso para esta opcion");</script>';
	}
}
else
{
	echo '<script>location.href = "error.html"</script>';
}
