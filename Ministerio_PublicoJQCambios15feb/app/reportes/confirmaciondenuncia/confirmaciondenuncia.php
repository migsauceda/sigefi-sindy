<?php

include ('Usuario.php');

session_start();
if(isset($_SESSION['objUsuario']) ){
	$var=$_SESSION['objUsuario'];
		//echo $var->getPermiso(11);
if($var->getPermiso(13)!=0){

	
	//echo $var->getPermiso();

	 
?>
<!DOCTYPE html>
<html lang="en" >
                            
    <h1 class="page-header">Reportes  confirmación denuncia</h1>
             
				 <div class="row">
                <div class="col-lg-12 form-inline">
                  
                  
                     
                    <div class="form-group ">
                        <label for="nombre">Nombre</label>
						<input type="text" id="nombre">
                    </div>
                
               
                    <div class="form-group ">
                        <button class="btn-primary buscar_confirmacion"> Buscar</button>
                    </div>
                
                
                
                    

                   
				  
					
					

                        
                                 
                    </div>
                    
                </div> <br> 
				
				
				
                <!-- /.col-lg-12 -->
           
            <br><br> 
            <!-- /.row -->
            <div class="row">

                <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">

                                         <table class="table table-bordered table-hover table-striped myTable" id="Confirmaciondenunciat">
                                            <thead>
                                                <tr>
                                                    <th>No. denuncias</th>
                                                    <th>No. persona</th>
                                                    <th>Nombres</th>
                                                    <th>RTN</th>
                                                    <th>Delito</th>
                                                   <!-- <th>Fiscalía</th>-->
                                                   <!-- <th>Imputado</th>-->
                                                    <th>Fecha asignación</th>
                                                    <th>Fiscalía asignada</th>
                                                    <th>No. expediente</th>
                                                    <th>Bandeja</th>
                                                    <th>Sub bandeja</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableresultado">
                                           
                                            </tbody>
                                        </table>
                                    </div>
                               
                                
                                
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                     
                </div>
                <!-- /.col-lg-12 -->
            </div>
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
