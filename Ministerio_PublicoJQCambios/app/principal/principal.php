<?php
session_start();
$_SESSION['valido']=0;
if (isset($_SESSION['valido']))
{
?>
<!DOCTYPE html>
<html lang="en" >

 <div id="tabs">

            <ul>
                <li><a href="#tabs-1" id="tab">Datos generales denunciante</a></li>
                <li><a href="#tabs-2">Detalle de la denuncias</a></li>
                <!--<li><a href="#tabs-3"  class="">Google Maps</a></li>-->
            </ul>
            <div id="tabs-1" >
 
 <!--<form id="fomulario" class="form-group form-group pruebaquery" role="form">
         <button type="submit">enviar</button>
 </form>-->
                    

               
             <form id="fomulario" class="form-group form-group entrevistadenunciante" role="form">
            <div class="row container">
                <div id="json"></div>
                    <div class="col-sm-6" >
                       
                               
                        <div class="form-group row">
                                <div class="col-sm-3" >
                                     <label for="nidentificacionid">Tipo de identificación</label>
                                </div>
                                <div class="col-sm-6" >
                                    <select  id="nidentificacionid" name="nidentificacionid" class="select sololetras" required>
					<option value="-1">--Seleccionar --</option>
                                    </select>
                                </div> 
                                <div  class="col-sm-2 validacion">
                                        <span class="validacion">*</span>
                                </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-3" >
                                    <label for="cidentificacion">Identificación</label>
                            </div>
                            <div class="col-sm-6" >
                                    <input type="text"  id="cidentificacion" name="cidentificacion" size="30"  maxlength="13"  class="solonumero" required>
                                     
                            </div>
                             <div  class="col-sm-2 validacion">
                                        <span class="validacion">*</span>
                                </div>
                        </div>
                  

                        
                        <div class="form-group row">
                                    <div class="col-sm-3" >
                                        <label for="cnombres">Nombres</label>
                                     </div>
                                    <div class="col-sm-6" >
                                         <input type="text"  id="cnombres" name="cnombres" size="30" class="sololetras inicialesmayuscula" maxlength="50" required>
                                    </div>
                                     <div  class="col-sm-2 validacion">
                                        <span class="validacion">*</span>
                                </div>
                        </div>

                           
                        <div class="form-group row">
                             <div class="col-sm-3" >
                                    <label for="capellidos" >Apellidos</label>
                             </div>
                             <div class="col-sm-6" >
                                    <input type="text"  id="capellidos" name="capellidos" size="30" class="sololetras inicialesmayuscula"  maxlength="50" required>
                             </div>
                              <div  class="col-sm-2 validacion">
                                        <span class="validacion">*</span>
                                </div>
                        </div>

                        <div class="form-group row">
                                    <div class="col-sm-3" >
                                            <label  for="cgenero">Género</label>
                                    </div>
                                    <div class="col-sm-3" >
                                            <label class="radio-inline">
                                                <input type="radio" name="cgenero" value="M" required>Masculino
                                            </label>
                                    </div>
                                    <div class="col-sm-3" >
                                            <label class="radio-inline">
                                                <input type="radio" name="cgenero" value="F">Femenino
                                         </label>
                                    </div>
                                     <div  class="col-sm-2 validacion">
                                        <span class="validacion">*</span>
                                </div>
                        </div>

                       
                        <div class="form-group row">
                                    <div class="col-sm-3" >
                                        <label for="nprofesionid">Profesión</label>
                                    </div>
                                    <div class="col-sm-6" >
                                        <select  id="nprofesionid" name="nprofesionid" class="select" required>
												  <option value="0">--Seleccionar --</option>
                                        </select>
                                    </div> 
                                     <div  class="col-sm-2 validacion">
                                        <span class="validacion">*</span>
                                </div>
                        </div>

                         <div class="form-group row">
                                    <div class="col-sm-3" >
                                        <label for="nocupacionid">Ocupación</label>
                                    </div>
                                    <div class="col-sm-6" >
                                        <select  id="nocupacionid" name="nocupacionid" class="select" required>
						<option value="-1">--Seleccionar --</option>
                                        </select>
                                    </div> 
                                     <div  class="col-sm-2 validacion">
                                        <span class="validacion">*</span>
                                </div>
                        </div>

                        
                         <div class="form-group row">
                                    <div class="col-sm-3" >
                                        <label for="nescolaridadid">Grado de escolaridad</label>
                                    </div>
                                    <div class="col-sm-6" >
                                        <select  id="nescolaridadid" name="nescolaridadid" class="select" required>
					        <option value="-1">--Seleccionar --</option>
                                        </select>
                                    </div> 
                                     <div  class="col-sm-2 validacion">
                                        <span class="validacion">*</span>
                                </div>
                        </div>

                              
                        <div class="form-group row">
                            <div class="col-sm-3" >
                                   <label for="nestadocivilid">Estado civil</label>
                            </div>
                            <div class="col-sm-6" >
                                 <select  id="nestadocivilid" name="nestadocivilid" class="select" required>  
					<option value="-1">--Seleccionar --</option>								 
                                 </select> 
                            </div>
                             <div  class="col-sm-2 validacion">
                                        <span class="validacion">*</span>
                                </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-3" >
                                 <label for="netniaid">Etnia</label>
                            </div>
                            <div class="col-sm-6" >
                                <select  id="netniaid" name="netniaid" class="select" required>
					<option value="-1">--Seleccionar --</option>
                                </select> 
                            </div>
                             <div  class="col-sm-2 validacion">
                                        <span class="validacion">*</span>
                                </div>
                         </div>

                    </div>


                <!--Div derecho-->
                    <div class="col-sm-6 borde" >

                               
                            <div class="form-group row">
                                <div class="col-sm-3" >
                                      <label for="ndiscapacidadid">Discapacidad</label>
                                </div>
                                <div class="col-sm-6" >
                                       <select  id="ndiscapacidadid" name="ndiscapacidadid" class="select" required>   
						<option value="-1">--Seleccionar --</option>									   
                                        </select> 
                                </div>
                                 <div  class="col-sm-2 validacion">
                                        <span class="validacion">*</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                    <div class="col-sm-3" >
                                         <label for="iedad">Edad</label>
                                    </div>
                                    <div class="col-sm-6" >
                                         <input type="text"  id="iedad" name="iedad" size="30"  maxlength="3" class="solonumero">
                                    </div>
                                     <div  class="col-sm-2 validacion">
                                        <span class="validacion">*</span>
                                </div>
                                   <!-- <div class="col-sm-2" >
                                    <label class="radio-inline">
                                        <input type="radio" name="des_edad"   value="1">Años
                                    </label>
                                    </div>
                                    <div class="col-sm-2" >
                                    <label class="radio-inline">
                                        <input type="radio" name="des_edad" value="0" >Desconocido
                                    </label>-
                                     </div>-->
                            </div>
                            
                    
                       <!-- <div class="form-group row">
                            <div class="col-sm-3" >
                                    <label for="orientacionsexual">Orientacion Sexual</label>
                            </div>
                            <div class="col-sm-9" >
                                    <input type="text"  id="orientacionsexual" name="orientacionsexual" size="30">
                            </div>
                        </div>-->

                        <div class="form-group row">
                            <div class="col-sm-3" >
                                    <label for="cdireccion">Dirección</label>
                            </div>
                           <!-- <div class="col-sm-6" >
                                    <input type="text"  id="cdireccion" name="cdireccion" size="30"   maxlength="200"  class="textarea" required>
                            </div>-->
                             <div class="col-sm-6" >
                                <textarea id="cdireccion"   name="cdireccion"  cols="32"  maxlength="200" required  class="textarea primeramayuscula"></textarea>
                             </div>
                             <div  class="col-sm-2 validacion">
                                        <span class="validacion">*</span>
                                </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-3" >
                                    <label for="ctelefono">Teléfono</label>
                            </div>
                            <div class="col-sm-6" >
                                    <input type="text"  id="ctelefono" name="ctelefono" size="30" class="solonumero"  maxlength="8" required>
                            </div>
                             <div  class="col-sm-2 validacion">
                                        <span class="validacion">*</span>
                                </div>
                        </div>

                        
                       <!-- <div class="form-group row">
                            <div class="col-sm-3" >
                                    <label for="cmetanombre">Metanombre</label>
                            </div>
                            <div class="col-sm-9" >
                                    <input type="text"  id="cmetanombre" name="cmetanombre" size="30" >
                            </div>
                        </div>

                         <div class="form-group row">
                            <div class="col-sm-3" >
                                    <label for="cmetaapellido">MetaApellido</label>
                            </div>
                            <div class="col-sm-9" >
                                    <input type="text"  id="cmetaapellido" name="cmetaapellido" size="30">
                            </div>
                        </div>-->
                    

                    

                        <div class="form-group row">
                                    <div class="col-sm-3" >
                                            <label  for="personanatural">Persona natural</label>
                                    </div>
                                    <div class="col-sm-3" >
                                            <label class="radio-inline">
                                                <input type="radio" name="bpersonanatural" id="f" value="F" required>No
                                            </label>
                                    </div>
                                    <div class="col-sm-3" >
                                            <label class="radio-inline">
                                                <input type="radio" name="bpersonanatural" id="m" value="T">Si
                                            </label>
                                    </div>
                                   
                                     <div  class="col-sm-2 validacion">
                                        <span class="validacion">*</span>
                                </div>
                                  
                        </div>

                        
                   

                        
                        <div class="form-group row">
                                    <div class="col-sm-3" >
                                            <label  for="aplicagbti">Pertenece LGBTI</label>
                                    </div>
                                    <div class="col-sm-3" >
                                            <label class="radio-inline">
                                                <input type="radio" name="baplicagbti"  id="f" value="F" required>No
                                            </label>
                                    </div>
                                    <div class="col-sm-3" >
                                            <label class="radio-inline">
                                                <input type="radio" name="baplicagbti" id='t' value="T">Si
                                            </label>
                                    </div>
                                   <div class="col-sm-2 validacion" >
                                           
                                               <span class="validacion">*</span>
                                            
                                    </div>
                                  
                        </div>

                    </div>
            </div>

                    <!--<button type="submit" aling='center'>Guardar</button>-->

             </form>
        
            </div>


            <div id="tabs-2">

            <form id="fomulario2" class="form-group form-group detalledenuncia" role="form">

            <div class="row container">
                    <div class="col-sm-6" >
                        
                    <!-- <div class="form-group row">
                         <div class="col-sm-3" >
                              <label for="ntipodenunciaid">Tipo de Denuncias</label>
                         </div>
                         <div class="col-sm-9" >
                              <select  id="ntipodenunciaid" name="ntipodenunciaid" class="select" required>
                                     
                              </select>
                         </div> 
                      </div>-->

                  
                     <input type="text" id="ccreada" name="ccreada" value="<?php echo $var->getUsuario(); ?>">  
 
                    <div class="form-group row">
                            <div class="col-sm-3" >
                                  <label for="cdeptodenuncia">Departamento de la denuncia</label>
                            </div>
                            <div class="col-sm-6" >
                                 <select  id="cdeptodenuncia" name="cdeptodenuncia" class="select cdeptodenuncia" required>
                                       <option value="-1">--Seleccionar--</option>
                                 </select>
                            </div> 
                             <div class="col-sm-2 validacion" >
                                    <span class="validacion">*</span>         
                            </div>
                            
                    </div>

                    <div class="form-group row">
                            <div class="col-sm-3" >
                                  <label for="cmunicipiodenuncia">Municipio</label>
                            </div>
                            <div class="col-sm-6" >
                                 <select  id="cmunicipiodenuncia" name="cmunicipiodenuncia" class="select cmunicipiodenuncia" required>
                                       <option value="-1">--Seleccionar--</option>
                                 </select>
                            </div> 
                            <div class="col-sm-2 validacion" >
                                    <span class="validacion">*</span>         
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-sm-3" >
                                  <label for="caldea">Aldea o barrio</label>
                            </div>
                            <div class="col-sm-6" >
                                 <select  id="caldea" name="caldea" class="select" required>
                                       <option value="-1">--Seleccionar --</option>
                                 </select>
                            </div> 
                            <div class="col-sm-2 validacion" >
                                    <span class="validacion">*</span>         
                            </div>
                        </div>

                         <div class="form-group row">
                             <div class="col-sm-3" >
                                   <label for="cdireccion_denuncia">Dirección denuncia</label>
                             </div>
                             <div class="col-sm-6" >
                                <textarea id="cdireccion_denuncia" cols="32" name="cdireccion_denuncia" class='textarea primeramayuscula' required></textarea>
                             </div>
                             <div class="col-sm-2 validacion" >
                                    <span class="validacion">*</span>         
                            </div>
                        </div>

                    </div>


                <!--Div derecho-->
                    <div class="col-sm-6 borde" >
                       
                           
                        <div class="form-group row">
                             <div class="col-sm-3" >
                                   <label for="cdireccion_hecho">Dirección hecho</label>
                             </div>
                             <div class="col-sm-6" >
                                <textarea id="cdireccion_hecho" cols="32" name="cdireccion_hecho" required readonly></textarea>
                             </div>
                             <div class="col-sm-2 validacion" >
                                    <span class="validacion">*</span>         
                            </div>
                        </div>
                        

                                
                         <!--<div class="form-group row">
                                <div class="col-sm-3" >
                                      <label for="nidbandejaid">Lugar Recepcion de la denuncia</label>
                                </div>
                                <div class="col-sm-9" >
                                     <select  id="nidbandejaid" name="nidbandejaid" class="select" required>
                                                
                                      </select>
                                </div> 
                        </div>-->

                     

                          <div class="form-group row">
                                <div class="col-sm-3" >
                                        <label for="dfecha_hecho">Fecha del hecho</label>
                                </div>
                                <div class="col-sm-6" >
                                       <!-- <input type="date"  id="dfecha_hecho" name="dfecha_hecho" size="30" required>-->
                                        <input type="text" id="dfecha_hecho" name="dfecha_hecho" size="30" class="sololetras solonumero" required>
                                </div>
                                <div class="col-sm-2 validacion" >
                                    <span class="validacion">*</span>         
                            </div>
                        </div>
                        
                        <div class="form-group row">
                                    <div class="col-sm-3" >
                                            <label for="thora_hecho">Hora del hecho</label>
                                    </div>
                                    <div class="col-sm-6" >
                                      <!--<input type="time" id="thora_hecho" name="thora_hecho" required>-->
                                      <input id="thora_hecho" type="text" name="thora_hecho" size="30" maxlength="7"  required class="timepicker solonumero thora_hecho"  readonly/>
                                    </div>
                                    <div class="col-sm-2 validacion" >
                                        <span class="validacion">*</span>         
                                    </div>
                         </div>
                           <div class="form-group row">
                                    <div class="col-sm-3" >
                                            <label for="thora_hecho">Latitud</label>
                                    </div>
                                    <div class="col-sm-6" >
                                       <input type="text" id="lat2" size="30" name="flatitud_lugar_hecho" required readonly/>
                                    </div>
                                    <div class="col-sm-2 validacion" >
                                       <span class="validacion">*</span>         
                                     </div>
                         </div>
                            <div class="form-group row">
                                    <div class="col-sm-3" >
                                            <label for="thora_hecho">Longitud </label>
                                    </div>
                                    <div class="col-sm-6" >
                                      <input type="text" id="long2" size="30" name="flongitud_lugar_hecho"  required readonly/>
                                    </div>
                                    <div class="col-sm-2 validacion" >
                                         <span class="validacion">*</span>         
                                    </div>
                         </div>
                        
                        <div class="form-group row">
                             <div class="col-sm-3" >
                                 <label for="baplica_denuncia">Aplica denuncia</label>
                             </div>
                             <div class="col-sm-6" >
                                    <select  id="baplica_denuncia" name="baplica_denuncia" class="select" required> 
					  <option value="-1">--Seleccionar --</option>
                                           <option value="t">Si</option>   
                                           <option value="f">No</option>  
                                        </select> 
                            </div>
                            <div class="col-sm-2 validacion" >
                                    <span class="validacion">*</span>         
                            </div>
                        </div>
                
                <div class="form-group row">
                        <div class="col-sm-3" >
                            <label for="cnarracionhecho">Narración del hecho</label>
                        </div>
                        <div class="col-sm-6" >
                            <textarea id="cnarracionhecho" cols="32" rows="8" name="cnarracionhecho" class='textarea primeramayuscula' required></textarea>
                        </div>
                        <div class="col-sm-2 validacion" >
                                    <span class="validacion">*</span>         
                        </div>
                </div>

              
           
                    </div>
            </div>

            
           <!-- <div class="col-sm-12">-->
               
               

                

                 
           <!-- </div>-->

<div class="container-fluid">

  <div class="row">
        <div class="form-group row">
               
                <div class="col-sm-6">
                    &nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" aling='center' class="btn-primary ">Guardar</button>
                 </div>
                  <div class="col-sm-6">
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn-primary  tab2"  id="moda" data-toggle="modal" >Ubicar hecho</button>

                </div>
        </div>
   
  
  </div>
</div>

       <!-- <div class="row">
            <div class="form-group">        
            <div class="col-sm-offset-2 col-sm-10">

            </div>
            </div>
            <div class="form-group">        
            <div class="col-sm-offset-2 col-sm-10">
            </div>
            </div>
        </div>-->
            
          

             </form>
             

            </div>
            
            <div id="tabs-3">
                  <!-- <button type="button" class="btn btn-info btn-lg tab3"  id="moda" data-toggle="modal" >Ver Mapa</button>-->
                  <!--<button type="button" class="btn btn-info btn-lg tab2"  id="moda" data-toggle="modal" >Ver Mapa</button>-->
                
<!--<button class="cargar">open</button>-->

                 <!-- data-toggle="modal" -->

                 <div id="dialog" style="display: none">
                     <input type="hidden" id="lat" value="14.110734">
                     <input type="hidden" id="lon" value="-87.176790">
                     <input type="hidden" id="zoom" value="8">
                     <form class="form-horizontal">
                       <div class="form-group">
                            <label for="disabledSelect" class="col-sm-2 control-label"></label>
                            <div class="col-sm-10">
                                
                            </div>
                       </div>
                     </form>

                   <!-- <form>
                        <div class="form-group">
                            <input type="text" id="direccion2" name="direccion2" value="Luro 1200, Mar del Plata, Buenos Aires, Argentina"/> 
                            <button id="pasar" onclick="codeAddress();" class="pasar">Pasar al mapa</button>
                        <label for="deptos">Departamentos:</label>
                                <select id="deptos" class="form-control deptos"><option></option></select>
                        </div>
                     
                    </form>-->
                 

                  
                    <div id="map" style="width:100%;height:500px"></div>
                                
                                <form id="formulario" class="mapa">
                                    <label for="descripcion">Descripción</label>
                                    <input type="text" class="form-control textarea"   name="descripcion"  id="descripcion" autocomplete="off"/>
                                   <label for="direccion">Dirección</label>
                                    <input type="text" class="form-control" readonly name="direccion" id="direccion" autocomplete="off"/>
                                    <label for="lat">Lat</label>
                                    <input type="text" class="form-control" readonly  name="lat" id="lat" autocomplete="off"/>
                                     <label for="lon">lon</label>
                                    <input type="text" class="form-control"  readonly name="lon" id="lon" autocomplete="off"/><br>
                                </form>


                 </div>
             
      </div>
        <script>
        $( function() {
            $("#tabs").tabs();
            $("#dfecha_hecho").datepicker({ dateFormat: 'yy-mm-dd' });
           // $('#thora_hecho').timepicker();

           var options = { twentyFour: true  }
            $('#thora_hecho').wickedpicker(options);
           // $('#thora_hecho').mask('00:00');

            /*$('#thora_hecho').mask('AA:SS:YY', {'translation': {
                                        A: {pattern: /^[1-9]/},
                                        S: {pattern: /[A-Za-z]/},
                                        Y: {pattern: /[0-9]545456/}
                                      }
                                });*/

        } );
    </script>

</html>
<?php
}
else
{
	echo '<script>location.href = "error.html"</script>';
}
  
   
   	

  
