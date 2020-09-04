<?php

include ('Usuario.php');

session_start();
if(isset($_SESSION['objUsuario']) ){
	$var=$_SESSION['objUsuario'];
		//echo $var->getPermiso(11);
if($var->getPermiso(15)!=0){

	
	//echo $var->getPermiso();

	 
?>
<!DOCTYPE html>
<html lang="en" >
    <script src="app/reportes/frecuenciaDenunciaDepto/frecuenciadenunciadepto.js"></script>
<div id="wrapper">

	<div id="page-wrapper">
		<!--<div ng-include src="'./app/html/tarjeta-superior.html'"></div>-->
		    <div class="row">
                <div class="col-lg-12">
                            
                    <h1 class="page-header">Frecuencia de denuncias recibidas por delito en cada departamento del país por mes </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12 form-inline">
                  
                     <div class="form-group">
                            
                              <label >Nro. Delitos con</label>
                              <select id="optionselectdepto">
                                     <option value="1">Mayor Incidencia</option>
                                     <option value="2">Menor Incidencia</option>
                              </select>
                             <input type="number" id="n_menosIncidenciasdepto">
	                      
                    </div>
                     
                    <div class="form-group">
                            
                              <label >Años de la denuncia</label>
                              <select id="aniodenunciadepto" class="aniodenunciadepto">
                                  <option value="-1">----seleccione un año---</option>
                              </select>
	                      
                    </div>

                     <!-- <div class="form-group ">
                            <label>Fecha inicial</label>
                            <input type="text" id="fecha_inicial_r">                                   
                      </div>

                       <div class="form-group ">
                             
                              <label >Fecha final</label>
                               
                                <input type="text" id="fecha_final_r" >
                             
	                    </div><br><br>-->

                        <div class="form-group ">
                                <button class="btn-primary frecuenciadelitos"> Buscar</button>
                        </div>
                                   
                    </div>
                    
                </div> <br> 
         <div class="row">

                <div class="col-lg-12">
                    <div class="row">
                       <div class="col-lg-12">
                         <div class="table-responsive">
                             <table class="table table-bordered table-hover table-striped" id="frecuenciadenunciaDepto">

                                 
                                 <thead>
                                  <tr>
                                   <th rowspan="2" scope="col" >Descripción</th>
                                    <th colspan="2" scope="col" >Resumen</th>
                                    <th colspan="13" scope="col">Mes</th>
                                    </tr>
                                    <tr>
                                       <th>Depto.</th>
                                       
                                       <th>Total denuncias</th>
                                       <th>Enero</th>
                                       <th>Febrero</th>
                                       <th>Marzo</th>
                                       <th>Abril</th>
                                       <th>Mayo</th>
                                       <th>Junio</th>
                                       <th>Julio</th>                                     
                                       <th>Agosto</th>                                    
                                       <th>Septiembre</th>  
                                       <th>Octubre</th> 
                                       <th>Noviembre</th> 
                                       <th>Diciembre</th>
                                       
                                     
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
                <div id="output" style="margin: 30px;"></div>
        </div>
                <!-- /.col-lg-12 -->
            </div>
	</div>
			

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
