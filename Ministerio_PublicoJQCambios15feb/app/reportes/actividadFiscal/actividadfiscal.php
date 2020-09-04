<?php

include ('Usuario.php');

session_start();
if(isset($_SESSION['objUsuario']) ){
	$var=$_SESSION['objUsuario'];
		//echo $var->getPermiso(11);
if($var->getPermiso(10)!=0){

	
	//echo $var->getPermiso();

	 
?>
<!DOCTYPE html>
<html lang="en" >
<div id="wrapper">

	<div id="page-wrapper">
		<!--<div ng-include src="'./app/html/tarjeta-superior.html'"></div>-->
		    <div class="row">
                <div class="col-lg-12">
                            
                    <h1 class="page-header">Reportes de actividad fiscal</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12 form-inline">
                  
                     <div class="form-group">
                            
                              <label for="ibandejaid">Fiscalía</label>
                                <select  id="ibandejaid" name="ibandejaid" class="select ibandejaid">
                                        
                                 
                                 </select> 
	                      
                    </div>
                     
                     <div class="form-group ">
                            
                              <label for="idusuario">Usuario</label>
                                <select  id="idusuario" name="idusuario" class="select idusuario">
                                        
                                 
                                 </select> 
                            
                     </div>

                      <div class="form-group ">
                              
                             

                              <label for="fecha_inicial">Fecha inicial</label>
                               <input type="text" id="fecha_inicial" name="fecha_inicial">
                               <!-- <input type="date" id="fecha_inicial">-->
                            
                      </div>

                       <div class="form-group ">
                             
                              <label for="fecha_final">Fecha final</label>
                               <!--<input type="date" id="fecha_final">-->
                                <input type="text" id="fecha_final" name="fecha_final">
                             
	                    </div><br><br>

                        <div class="form-group ">
                                <button class="btn-primary buscar_actividadfiscal"> Buscar</button>
                        </div>
                                   
                    </div>
                    
                </div> <br> 
         <div class="row">

                <div class="col-lg-12">
                    <div class="row">
                       <div class="col-lg-12">
                         <div class="table-responsive">
                             <table class="table table-bordered table-hover table-striped" id="ActividadFiscalT">
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
                                   </thead>
                                    <tbody  id="tablares">
                                 

                                               
                                               
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
            $( "#fecha_inicial" ).datepicker({ dateFormat: 'yy-mm-dd' });
            //$("#fecha_final").datepicker();
             $( "#fecha_final" ).datepicker({ dateFormat: 'yy-mm-dd' });
           
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
