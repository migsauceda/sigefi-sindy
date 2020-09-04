<?php

include ('Usuario.php');

session_start();
if(isset($_SESSION['objUsuario']) ){
	$var=$_SESSION['objUsuario'];
		//echo $var->getPermiso(11);
if($var->getPermiso(21)!=0){

	
	//echo $var->getPermiso();

	 
?> 
<!DOCTYPE html>
<html lang="en" >
    <head>
        <script src="app/reportes/vaciadodenuncia/vaciadodenuncia.js"></script>
    </head>
<div id="wrapper">

	<div id="page-wrapper">
		<!--<div ng-include src="'./app/html/tarjeta-superior.html'"></div>-->
		    <div class="row">
                <div class="col-lg-12">
                            
                    <h1 class="page-header">Reporte vaciado denuncia</h1>
                </div>
            </div>

          

                <!-- <div class="container form-inline">
            
                
                    <div class="form-group ">
                        <label id="delito2">Departamento</label>
                        <select id="deptovaciado" name="deptovaciado" class="select deptovaciado">
                                                    
                                     <option value="-1">--Seleccionar--</option>       
                        </select>
                    </div>
                
               
                    <div class="form-group ">
                        <label id="municipiovaciado2">Municipio</label>
                        
                         <select id="municipiovaciado" name="municipiovaciado" class="select municipiovaciado">
                                                    
                                            
                        </select>
                    </div>
                
                
                
                    <div class="form-group ">
                        <label id="aldeavaciado2">Aldea/Ciudad</label>
                        <select id="aldeavaciado" name="aldeavaciado" class="select aldeavaciado">
                                                    
                                            
                        </select>
                 
                    </div>

             </div>-->
			 <div class="row">
                <div class="col-lg-12 form-inline">
                  
                  
                     
                    <div class="form-group ">
                        <label id="delito2">Delito</label>
                        <select id="delito" name="delito" class="select delito">
                                                    
                                            
                        </select>
                    </div>
                
               
                    <div class="form-group ">
                        <label id="delito2">Fecha incial</label>
                        <input type="text" id="fecha_inicial_v" name="fecha_inicial_v"> 
                    </div>
                
                
                
                    <div class="form-group ">
                        <label id="delito2">Fecha final</label>
                        <input type="text" id="fecha_final_v" name="fecha_final_v">
                 
                    </div>

                   
				  
					
					

                        
                                 
                    </div>
                    
                </div> <br> 
                <div class="form-group ">
				<button type="submit" aling='center' class="btn-primary buscarvaciado">Buscar</button><br><br>
            
                </div>
       
 
          
            <div class="row container">
               <!--- <div class="col-lg-12">
                     <div class="form-group row">
                           
                         
                             <div class="col-sm-6">
                   <button type="submit" aling='center' class="btn-primary buscar">Buscar</button>
                 </div>
                                   
                    </div>
                </div>  <br><br> <br><br><br><br> <br><br>-->
            <div class="row">
                <div class="col-lg-12">
                            <div class="row">
                              
                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        
                                        <div id="dv">
                                         <table class="table table-bordered" id="VaciadoDenunciaT">
                                            <thead>
                                                <tr>
                                                    <th>No. Denuncia</th>
                                                    <th>Fecha de denuncia</th>
                                                    <th>Hora denuncia</th>
                                                    <th>dia del hecho </th>  
                                                    <th>No.dia de hecho</th>                                                   
                                                    <th>Mes del hecho</th>                                                    
                                                    <th>Año del hecho</th>
                                                    <th>hora hecho</th>
                                                    <th>Rango de horas</th>
                                                    <th>Lugar hecho</th>
                                                    <th>Delito</th>  
                                                    <th>Narración del hecho</th>                                                    
                                                    <th>Depto. hecho</th>
                                                    <th>Municiopio de hecho</th>                                                   
                                                    <th>Aldea del hecho</th>                                                    
                                                    <th>Nombre ofendido</th>
                                                    <th>Edad ofendido</th>
                                                    <th>Dirección ofendido</th>
                                                    <th>Sexo ofendido</th>  
                                                    <th>Género ofendido</th>                                                    
                                                    <th>Profesión ofendido</th>
                                                    <th>Ocupación ofendido</th>
                                                    <th>Escolaridad ofendido</th>
                                                    <th>Nacionalidad ofendido</th>
                                                    <th>Etnia ofendido</th>                                                                                                                                                     
                                                    <th>Discapacidad ofendido</th>                                                    
                                                    <th>Estado Civil Ofendido</th>
                                                    <th>Cant. hijos ofendido</th>
                                                    <th>Embrazo ofendido</th>                                                    
                                                    <th>Frecuencia agresion ofendido</th>
                                                    <th>trabajo remunerado</th>
                                                    <th>estudio ofendido</th>
                                                    <th>Intentos sucicidio ofendido</th>
                                                    <th>Enfermedad mental ofendido</th>
                                                    <th>Mecanismo muerte ofendido</th>
                                                    <th>Nombre denunciante</th> 

                                                    <!--agreuge-->
                                                    <th>Edad denunciante </th>   
                                                    <th>Dirección denunciante</th>                                                  
                                                    <th>Sexo denunciante</th>
                                                    <th>Género denunciante</th>
                                                     <!-------------->   

                                                    <th>Etnia denunciante </th>   
                                                    <th>Profesion denunciante</th>                                                  
                                                    <th>Ocupación denunciante</th>
                                                    <th>Escolaridad denunciante</th>                                                    
                                                    <th>Nacionalidad denunciante</th>
                                                    <th>Etnia denunciante</th>
                                                    <th>Discapacidad denunciante</th>                                                    
                                                    <th>Estado civil denunciante</th>
                                                    <th>Fiscalia de recepción </th>
                                                    <th>Expediente SEDI</th>
                                                    <th>Expediente judicial</th>
                                                    <th>Expediente policial</th>
                                                    <th>Levantamiento</th>
                                                    <th>Transito</th>                                     
                                                    <th>Autopsia</th>   
                                                    <th>Nombre imputado</th> 

                                                    <th>Género imputado</th>
                                                    <th>Edad imputado</th>
                                                    <th>Dirección imputado</th>
                                                    <th>Orientación sexual imputado</th>
                                                    <th>Telefono imputado</th>
                                                    <th>Aplica LGBTI imputado</th>                                     
                                                    <th>Alias imputado</th>   
                                                    <th>Nombre Asumido imputado</th> 
                                                    <th>Condisionado imputado</th>
                                                    <th>Trabajo Remunerado imputado</th>
                                                    <th>Asiste Educación imputado</th>
                                                    <th>Infractor imputado</th>

                                                    <th>Etnia imputado</th>
                                                    <th>Profesión imputado</th>
                                                    <th>Ocupación imputado</th>
                                                    <th>Escolaridad imputado</th>
                                                    <th>Nacionalidad imputado</th>
                                                    <th>Etnia imputado</th>                                     
                                                    <th>Discapacidad imputado</th>   
                                                    <th>Estado civil imputado</th>                                                  
                                                  
                                                </tr>
                                            </thead>
                                            <!--<tbody id="tablevaciadode">
                                             
                                               
                                            </tbody>-->
                                        </table>
                                        </div>
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
            $( "#fecha_inicial_v" ).datepicker({ dateFormat: 'yy-mm-dd' });
            //$("#fecha_final").datepicker();
             $( "#fecha_final_v" ).datepicker({ dateFormat: 'yy-mm-dd' });
             
         
           
        } );
    </script>
   
    <script>
　
function TableToExcel(tableid)
{
    alert();
        var id = $('[id$="' + tableid + '"]');
        var strCopy = $('<div></div>').html(id.clone()).html(); window.clipboardData.setData("Text", strCopy);
        var objExcel = new ActiveXObject("Excel.Application");
        objExcel.visible = false; var objWorkbook = objExcel.Workbooks.Add; var objWorksheet = objWorkbook.Worksheets(1); objWorksheet.Paste; objExcel.visible = true;
        }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#btnExport").click(function () {
		//alert();
            $("#VaciadoDenunciaT").excelexportjs({
                containerid: "VaciadoDenunciaT"
               , datatype: 'table'
               , encoding: "UTF-8"
            });
        });
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
