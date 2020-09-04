<?php

include ('Usuario.php');

session_start();
if(isset($_SESSION['objUsuario']) ){
	$var=$_SESSION['objUsuario'];
		echo $var->getPermiso(23);
if($var->getPermiso(23)!=0){

	
	//echo $var->getPermiso();

	 
?> 
<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="utf-8" />
        <title>Ministerio Publico</title>
        <link href="css/layout.css" rel="stylesheet" type="text/css" />
        <link href="css/menu.css" rel="stylesheet" type="text/css" />
         <link rel="stylesheet" href="css/jquery-ui.css">
         <link rel="stylesheet" href="dist/css/bootstrap.min.css">
         <link rel="stylesheet" href="css/jquery.dataTables.min.css">
         <link rel="stylesheet" href="css/validacion.css" >
         <link rel="stylesheet" href="css/wickedpicker.min.css" >
        
  <link rel="stylesheet" type="text/css" href="css/jquery.timepicker.css" />
  <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
         
    </head>
     <header>

           
        </header>

 <div class="container" >   
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
                                  <label for="caldea">Aldea o Ciudad</label>
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
                                  <label for="caldea">Barrio</label>
                            </div>
                            <div class="col-sm-6" >
                                 <select  id="cbarrio" name="cbarrio" class="select" required>
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
                            <label for="cnarracionhecho">Narración del hecho</label>
                        </div>
                        <div class="col-sm-6" >
                            <textarea id="cnarracionhecho" cols="32" rows="8" name="cnarracionhecho" class='textarea primeramayuscula' required></textarea>
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
                                    <select  id="baplica_denuncia" name="baplica_denuncia" class="select baplica_denuncia" required> 
					  <option value="-1">--Seleccionar --</option>
                                           <option value="t">Si</option>   
                                           <option value="f">No</option>  
                                        </select> 
                            </div>
                            <div class="col-sm-2 validacion" >
                                    <span class="validacion">*</span>         
                            </div>
                </div>

                  <div class="form-group row centro"  style="display:none;" >
                             <div class="col-sm-3" >
                                 <label for="centroatencion1">Centro al que fue remitido</label>
                             </div>
                             <div class="col-sm-6" >
                                    <select  id="centroatencion" name="centroatencion" class="select" > 
					  <option value="-1">--Seleccionar --</option>
                                          
                                        </select> 
                            </div>
                            <div class="col-sm-2 validacion" >
                                    <span class="validacion">*</span>         
                            </div>
                </div>
<input type="hidden" id="ccreada" clase="ccreada" name="ccreada" value="<?php echo $var->getUsuario(); ?>">
                 <div class="form-group row decricpcionatecion" style="display:none;"  >
                        <div class="col-sm-3" >
                            <label for="cnarracionhechon">Observación respecto al centro de remisión</label>
                        </div>
                        <div class="col-sm-6" >
                            <textarea id="observacioncentroatencion" cols="32" rows="8" name="observacioncentroatencion" class='textarea primeramayuscula' >  </textarea>
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
             <!-- <div id="cboDepto">j</div>
              <div id="dicid"></div>-->
      </div>
</div>
         <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAUoy7VrZcmEqINM0dOskZtQTym20qqRk4"></script>

     <script src="js/jquery-1.6.min.js"></script>
     <script src="js/jquery-1.12.4.min.js"></script>
     <script src="js/bootstrap.min.js"></script>
     <script type="text/javascript" src="js/jquery.timepicker.js"></script>
     <script src="js/jquery-ui.min.js"></script>
     
     <script src="js/jquery.dataTables.min.js"></script>
     <script src="js/wickedpicker.min.js"></script>
  
    
       
     <script src="js/main.js"></script>
     <script src="app/principal/principal.js"></script>
     <!--<script src="app/principal/denuncias.js"></script>-->
     <script src="app/reportes/actividadFiscal/actividadfiscal.js"></script>
     <script src="app/reportes/confirmaciondenuncia/confirmaciondenuncia.js"></script>
     <!--<script src="app/reportes/estadoexpediente/estadoexpediente.js"></script>
     <script src="app/reportes/fiscalasignado/fiscalasignado.js"></script>-->

 <script>
        $( function() {
            $("#tabs").tabs();
            $("#dfecha_hecho").datepicker({ dateFormat: 'yy-mm-dd' });
           // $('#thora_hecho').timepicker();

           var options = { twentyFour: true  }
            $('#thora_hecho').wickedpicker(options);
        

         
       


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
  
   
   	

  
