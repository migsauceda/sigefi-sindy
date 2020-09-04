<?php

include ('Usuario.php');

session_start();
if(isset($_SESSION['objUsuario']) ){
	$var=$_SESSION['objUsuario'];
		//echo $var->getPermiso(11);
if($var->getPermiso(18)!=0){

	
	//echo $var->getPermiso();

	 
?>
<!DOCTYPE html>
<html lang="en" >
    <script src="app/reportes/frecuenciaGestion/frecuenciagestion.js"></script>
<div id="wrapper">

	<div id="page-wrapper">
		<!--<div ng-include src="'./app/html/tarjeta-superior.html'"></div>-->
		    <div class="row">
                <div class="col-lg-12">
                            
                    <h1 class="page-header">Frecuencia de gestiones y resoluciones</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12 form-inline">
                     
                    <div class="form-group">
                            
                              <label >Años de la denuncia</label>
                              <select id="aniogestion" class="aniogestion">
                                  <option value="-1">----seleccione un año---</option>
                              </select>
	                      
                    </div>

                        <div class="form-group ">
                                <button class="btn-primary frecuenciagestion"> Buscar</button>
                        </div>
                                   
                    </div>
                    
                </div> <br> 
         <div class="row">

                <div class="col-lg-12">
                    <div class="row">
                       <div class="col-lg-12">
                         <div class="table-responsive">
                             <table class="table table-bordered table-hover table-striped" id="frecuenciaGestion">

                                 
                                 <thead>
                                  <tr>
                                       <th>Gestión/resolución</th>                                       
                                       <th>Total Gestión/resolución</th>
                                    
                                       
                                     
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
