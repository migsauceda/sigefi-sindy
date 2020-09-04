<?php

include ('Usuario.php');

session_start();
if(isset($_SESSION['objUsuario']) ){
	$var=$_SESSION['objUsuario'];
		//echo $var->getPermiso(11);
if($var->getPermiso(14)!=0){

	
	//echo $var->getPermiso();

	 
?>
<!DOCTYPE html>
<html lang="en" >
    <script src="app/reportes/frecuenciaDenunciaDelito/frecuenciadelito.js"></script>
<div id="wrapper">

	<div id="page-wrapper">
		<!--<div ng-include src="'./app/html/tarjeta-superior.html'"></div>-->
		    <div class="row">
                <div class="col-lg-12">
                            
                    <h1 class="page-header">Frecuencia de denuncias recibidas por delito </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12 form-inline">
                  
                     <div class="form-group">
                            
                              <label >Nro. Delitos con</label>
                              <select id="optionselect">
                                     <option value="1">Mayor Incidencia</option>
                                     <option value="2">Menor Incidencia</option>
                              </select>
                             <input type="number" id="n_menosIncidencias">
	                      
                    </div>
                     
                    <!---<div class="form-group">
                            
                              <label >N Delitos con menor incidencia</label>
                              <input type="number" id="n_menosIncidencias"> 
	                      
                    </div><br><br>-->

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
                             <table class="table table-bordered table-hover table-striped" id="frecuenciadenuncia">

                                 
                                 <thead>
                                  <tr>
                                   <th rowspan="2" scope="col" >Descripción</th>
                                    <th colspan="4" scope="col" >Resumen</th>
                                    <th colspan="17" scope="col">Rangos de edad</th>
                                    </tr>
                                    <tr>
                                      <!--<th>cdescripcion</th>-->
                                       <th>Total delito</th>
                                       <th>Totaldelitos hombres</th>
                                       <th>Total delito mujeres</th>
                                       <th>Total delito no consignado</th>
                                       <th>(0-4)</th>
                                        <th>(5-9)</th>
                                        <th>(10-14)</th>
                                        <th>(15-19)</th>
                                        <th>(20-24)</th>                                     
                                        <th>(25-29)</th>                                    
                                        <th>(30-34)</th>  
                                        <th>(35-39)</th> 
                                        <th>(40-44)</th> 
                                        <th>(45-49)</th>
                                        <th>(50-54)</th>
                                        <th>(55-59)</th> 
                                        <th>(60-64)</th>  
                                        <th>(65-69)</th>
                                        <th>(70-74)</th> 
                                        <th>(75-79)</th> 
                                        <th>(80 o más)</th>     
                                     
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
			
    <script>
        $( function() {
            //$("#").datepicker();
            $( "#fecha_inicial_r" ).datepicker({ dateFormat: 'yy-mm-dd' });
            //$("#fecha_final").datepicker();
             $( "#fecha_final_r" ).datepicker({ dateFormat: 'yy-mm-dd' });
           
        } );
    </script>
      <script type="text/javascript">
    // This example loads data from the HTML table below.
    
    /*$(function(){
        $("#output").pivotUI($("#frecuenciadenuncia"), 
        { 
            rows: ["Delito"], 
            cols: ["Actividad"] 
        });
     });*/
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
