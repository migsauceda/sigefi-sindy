<?php

include ('Usuario.php');

session_start();
if(isset($_SESSION['objUsuario'])){
	$var=$_SESSION['objUsuario'];

	//echo $var->getUsuario();

	
if($var->getPermiso(12)!=0){

	
	//echo $var->getPermiso();

	 

?>
<!DOCTYPE html>
<html lang="en" >
      <head>
        <script src="app/reportes/ReportePersonal/reportepersonal.js"></script>
    </head>
<div id="wrapper">

	<div id="page-wrapper">
		<!--<div ng-include src="'./app/html/tarjeta-superior.html'"></div>-->
		    <div class="row">
                <div class="col-lg-12">
                            
                    <h1 class="page-header">Reportes expedientes personales</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12 form-inline">
                  
                     
                    <div class="form-group ">
                              
                             

                              <label for="fecha_inicial">Fecha inicial</label>
                               <input type="text" id="fecha_inicial_p" name="fecha_inicial_p">
                               <!-- <input type="date" id="fecha_inicial">-->
                            
                      </div>

                       <div class="form-group ">
                             
                              <label for="fecha_final">Fecha final</label>
                               <!--<input type="date" id="fecha_final">-->
                                <input type="text" id="fecha_final_p" name="fecha_final_p">
                             
	                    </div><br><br>

                <input type="hidden" id="usersesion" clase="usersesion" value="<?php echo $var->getUsuario(); ?>">
                        <div class="form-group ">
                                <button class="btn-primary buscar_actividadfiscalPe"> Buscar</button>
                        </div>
                                   
                    </div>
                    
                </div> <br> 
         <div class="row">

                <div class="col-lg-12">
                    <div class="row">
                       <div class="col-lg-12">
                         <div class="table-responsive">
                             <table class="table table-bordered table-hover table-striped" id="ActividadFiscalTPersona">
                                 <thead>
                                    <tr>
                                     <th>Fecha denuncia</th>
                                     <th>No. denuncia</th>
                                     <th>Nombre imputado</th>
                                     <!--agregar nombre ofendido-->
                                    
                                     <!--Breve observacion-->
                                     <th>Fiscalía</th>
                                      <th>Delito</th>
                                       <th>Fecha diligencia</th>
                                     <th>Actividad</th>
                                     <th>Materia</th>
                                     <th>Etapa</th>
                                     <th>Sub etapa</th>                                     
                                     <th>Expediente</th>                                    
                                     <th>Rtn imputado</th>                                     
                                     <th>Fiscalía asignada</th>
                                     
                                   </tr>
                                     
                                   </tr>
                                   </thead>
                                    <tbody  id="tablarespersonal">
                                 

                                               
                                               
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
            $( "#fecha_inicial_p" ).datepicker({ dateFormat: 'yy-mm-dd' });
            //$("#fecha_final").datepicker();
             $( "#fecha_final_p" ).datepicker({ dateFormat: 'yy-mm-dd' });
			
           
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
