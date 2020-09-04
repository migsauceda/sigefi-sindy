<?php

include ('Usuario.php');

session_start();
if(isset($_SESSION['objUsuario']) ){
	$var=$_SESSION['objUsuario'];
		//echo $var->getPermiso(11);
if($var->getPermiso(22)!=0){

	
	//echo $var->getPermiso();

	 
?> 
<!DOCTYPE html>
<html lang="en" >
    <head>
        <script src="app/reportes/VaciadoGetionFiscal/vaciadogestionfiscal.js"></script>
    </head>
<div id="wrapper">

	<div id="page-wrapper">
		<!--<div ng-include src="'./app/html/tarjeta-superior.html'"></div>-->
		    <div class="row">
                <div class="col-lg-12">
                            
                    <h1 class="page-header">Vaciado gestión fiscal </h1>
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
                                <select  id="idusuariogestion" name="idusuariogestion" class="select idusuariogestion">
                                        
                                 
                                 </select> 
                            
                     </div>

                      <div class="form-group ">
                              
                             

                              <label for="fecha_inicial">Fecha inicial</label>
                               <input type="text" id="fecha_inicial_g" name="fecha_inicial_j">
                              
                            
                      </div>

                       <div class="form-group ">
                             
                              <label for="fecha_final">Fecha final</label>
                                <input type="text" id="fecha_final_g" name="fecha_final_j">
                             
	                    </div><br><br>

                        <div class="form-group ">
                                <button class="btn-primary buscar_gestionfiscal"> Buscar</button>
                        </div>
                                   
                    </div>
                    
                </div> <br> 
         <div class="row">

                <div class="col-lg-12">
                    <div class="row">
                       <div class="col-lg-12">
                         <div class="table-responsive">
                             <table class="table table-bordered table-hover table-striped" id="vaciadogestionfiscalTB">
                                 <thead>
                                    <tr>
                                        <th>Nro. denuncia</th> 
                                        <th>Nro. persona</th>                                      
                                        <th>Hora Gestión</th>  
                                        <th>Fiscalia</th>                                
                                        <th>Unidad</th>
                                        <th>Etapa</th>
                                        <th>Sub Etapa</th>
                                        <th>Gestión/Resolución</th>
                                        <th>Nombre imputado</th>
                                    
                                    
                                     
                                     
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
            $( "#fecha_inicial_g" ).datepicker({ dateFormat: 'yy-mm-dd' });
            //$("#fecha_final").datepicker();
             $( "#fecha_final_g" ).datepicker({ dateFormat: 'yy-mm-dd' });
           
        });
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
