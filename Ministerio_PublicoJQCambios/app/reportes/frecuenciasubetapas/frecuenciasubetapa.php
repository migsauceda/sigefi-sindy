<?php

include ('Usuario.php');

session_start();
if(isset($_SESSION['objUsuario']) ){
	$var=$_SESSION['objUsuario'];
		//echo $var->getPermiso(11);
if($var->getPermiso(20)!=0){

	
	//echo $var->getPermiso();

	 
?>
<!DOCTYPE html>
<html lang="en" >
    <script src="app/reportes/frecuenciasubetapas/frecuenciasubetapa.js"></script>
<div id="wrapper">

	<div id="page-wrapper">
		<!--<div ng-include src="'./app/html/tarjeta-superior.html'"></div>-->
		    <div class="row">
                <div class="col-lg-12">
                            
                    <h1 class="page-header">Frecuencia de Subetapas</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12 form-inline">
                     
                    <div class="form-group">
                            
                              <label >Años de la denuncia</label>
                              <select id="aniosubetapa" class="aniosubetapa">
                                  <option value="-1">----seleccione un año---</option>
                              </select>
	                      
                    </div>

                        <div class="form-group ">
                                <button class="btn-primary frecuencisubetapa"> Buscar</button>
                        </div>
                                   
                    </div>
                    
                </div> <br> 
         <div class="row">

                <div class="col-lg-12">
                    <div class="row">
                       <div class="col-lg-12">
                         <div class="table-responsive">
                             <table class="table table-bordered table-hover table-striped" id="frecuenciaSubEtapas">

                                 
                                 <thead>
                                  <tr>
                                       <th>Sub Etapa</th>                                       
                                       <th>Total Sub Etapa</th>
                                    
                                       
                                     
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
