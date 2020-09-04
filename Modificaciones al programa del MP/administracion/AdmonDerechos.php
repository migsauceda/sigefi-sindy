<?php
	include('../clases/class_conexion_pg.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
  <title>Asignar Tareas a Roles</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <script type="text/javascript">
  	function guardarRol(){
		rol=document.getElementById('txtNombreRol').value;
		ajaxf=objetoAjax();
		ajaxf.open("GET", 'guardaRol.php?rol='+rol);
		ajaxf.onreadystatechange=function() {
			if (ajaxf.readyState==4) {
				alert('Rol Guardado')
				document.getElementById('txtNombreRol').value="";
				//divResultado.innerHTML=ajaxf.responseText;
			}
		}
		ajaxf.send(null)
	}
	
	function guardarTarea(){
		tarea=document.getElementById('txtNombreTarea').value;
		ajaxf=objetoAjax();
		ajaxf.open("GET", 'guardaTarea.php?tarea='+tarea);
		ajaxf.onreadystatechange=function() {
			if (ajaxf.readyState==4) {
				alert('Tarea Guardada')
				document.getElementById('txtNombreTarea').value=""
				//divResultado.innerHTML=ajaxf.responseText;
			}
		}
		ajaxf.send(null)
	} 
	function objetoAjax(){			
			var xmlhttp=false;
			try {
					xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
					try {
					   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					} catch (E) {
							xmlhttp = false;
					}
			}
			if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
					xmlhttp = new XMLHttpRequest();
			}
			return xmlhttp;
	}
	function mostrarTareas(){
		rol=document.getElementById('cboRol').value;
		if (rol!="---"){
			divResultado=document.getElementById('div_todas_tareas');
			ajaxf=objetoAjax();
			ajaxf.open("GET", 'muestraTareas.php?rol='+rol);
			ajaxf.onreadystatechange=function() {
				if (ajaxf.readyState==4) {
					divResultado.innerHTML=ajaxf.responseText;
					mostrarTareasAsignadas();
					
					/*var date = new Date();
					var curDate = null;
					millis=1250;
					do { 
					curDate = new Date(); 
					} 
					while(curDate-date < millis);*/
				}
			}
			ajaxf.send(null)
			
		}
	}
	function mostrarTareasAsignadas(){
		rol=document.getElementById('cboRol').value;
		divResultado1=document.getElementById('div_tareas_asignadas');
		ajax1=objetoAjax();
		ajax1.open("GET", 'muestraTareasAsignadas.php?rol='+rol);
		ajax1.onreadystatechange=function() {
			if (ajax1.readyState==4) {
				divResultado1.innerHTML=ajax1.responseText;
			}
		}
		ajax1.send(null)
	}
	function asignarTarea(valor){
		rol=document.getElementById('cboRol').value;
		if (valor=="una"){
			tarea=document.getElementById('cboTareas').value;
			if ((rol!="---") && (document.getElementById('cboTareas').selectedIndex>=0)){
				ajax2=objetoAjax();
				ajax2.open("GET", 'asignarTarea.php?rol='+rol+'&tarea='+tarea+"&valor="+valor);
				ajax2.onreadystatechange=function() {
					if (ajax2.readyState==4) {					
						alert('Tarea Asignada')
						mostrarTareas();
						//divResultado1.innerHTML=ajax1.responseText;					
					}
				}
				ajax2.send(null)
			}
		}
		else {
			var i=0
			var tareas=""
			for (i=0;i<document.getElementById('cboTareas').length;i++){
				tareas=tareas+"&tarea"+i+"="+document.getElementById('cboTareas').options[i].value
			}
			tareas=tareas+"&cantidadTareas="+document.getElementById('cboTareas').length
			if (rol!="---"){
				ajax3=objetoAjax();
				ajax3.open("GET", 'asignarTarea.php?rol='+rol+tareas+"&valor="+valor);
				ajax3.onreadystatechange=function() {
					if (ajax3.readyState==4) {					
						alert('Tareas Asignadas')
						mostrarTareas();
						//document.getElementById('1').innerHTML=ajax3.responseText;					
					}
				}
				ajax3.send(null)
			}
		}
	}
	function quitarTareas(valor){
		rol=document.getElementById('cboRol').value;
		if (valor=="una"){
			tarea=document.getElementById('cboTareasAsignadas').value;
			if ((rol!="---") && (document.getElementById('cboTareasAsignadas').selectedIndex>=0)){
				ajax4=objetoAjax();
				ajax4.open("GET", 'quitarTarea.php?rol='+rol+'&tarea='+tarea+"&valor="+valor);
				ajax4.onreadystatechange=function() {
					if (ajax4.readyState==4) {					
						alert('Tarea Desasignada')
						mostrarTareas();
						//divResultado1.innerHTML=ajax1.responseText;					
					}
				}
				ajax4.send(null)
			}
		}
		else {
			var i=0
			var tareas=""
			for (i=0;i<document.getElementById('cboTareasAsignadas').length;i++){
				tareas=tareas+"&tarea"+i+"="+document.getElementById('cboTareasAsignadas').options[i].value
			}
			tareas=tareas+"&cantidadTareas="+document.getElementById('cboTareasAsignadas').length
			if (rol!="---"){
				ajax5=objetoAjax();
				ajax5.open("GET", 'quitarTarea.php?rol='+rol+tareas+"&valor="+valor);
				ajax5.onreadystatechange=function() {
					if (ajax5.readyState==4) {					
						alert('Tareas Desasignadas')
						mostrarTareas();
						//document.getElementById('1').innerHTML=ajax3.responseText;					
					}
				}
				ajax5.send(null)
			}
		}
	}
  </script>
</head>

<body>

<div align="center"><strong>Crer Roles</strong></div>
<table align="center" id="tblRoles">
  <tbody>
    <tr>
      <td></td>
    </tr>
  </tbody>
</table>
<table align="center">
  <tbody>
    <tr>
      <td>Nuevo rol: <INPUT type="text" name="txtNombreRol" id="txtNombreRol"> <INPUT type="button" name="btnRol" value="Agregar Rol" onClick="guardarRol()"></td>
    </tr>
  </tbody>
</table>
<br>
<div align="center"><strong>Crer Tareas</strong></div>
<table align="center" id="tblTarea">
  <tbody>
    <tr>
      <td></td>
    </tr>
  </tbody>
</table>
<table align="center">
  <tbody>
    <tr>
      <td>Nueva tarea: <INPUT type="text" name="txtNombreTarea" id="txtNombreTarea"> 
      <INPUT type="button" name="btnTarea" value="Agregar Tarea" onClick="guardarTarea()"></td>
    </tr>
  </tbody>
</table>
<br>
<div align="center"><strong>Asignar Tareas a Roles</strong></div>
<table align="center" id="tblAsignar">
  <tbody>
    <tr>
      <td></td>
    </tr>
  </tbody>
</table>
<table align="center" width="50%">
  <tbody>
    <tr>
	  <td align="center">Rol   <SELECT name="cboRol" id="cboRol" onChange="mostrarTareas()">
      	<?php
			$conexion=new Conexion();
			$consulta="select * from tbl_rol";
			$sql=$conexion->ejecutarComando($consulta);
			echo "<option value='---'>---</option>";
			while ($row=pg_fetch_assoc($sql)){		
				echo "<option value='$row[rolid]'>$row[descripcion]</option>";
			}
		?>
      </SELECT></td>      
    </tr>
    <!--<tr>
      <td align="center">Tarea <SELECT name="cboTarea" id="cboTarea"></SELECT></td>
    </tr>-->
    <tr>
    	<td>
        	<table width="100%">
            	<tr>
                	<td align="center">Tareas</td>
                    <td width="10%"></td>
                    <td align="center">Tareas Asignadas</td>
                </tr>
        		<tr>
        			<td><div id="div_todas_tareas"><select id="cboTareas" name="cboTareas" size="7" multiple style="width:100%">
            </select></div>
        			</td>
                    <td width="10%" align="center">
                    	<INPUT type="button" name="agregar" id="agregar" value=">" onClick="asignarTarea('una')"><br>
                        <INPUT type="button" name="agregarTodas" id="agregarTodas" value=">>" onClick="asignarTarea('todas')"><br>
                        <INPUT type="button" name="quitar" id="quitar" value="<" onClick="quitarTareas('una')"><br>
                        <INPUT type="button" name="quitarTodas" id="quitarTodas" value="<<" onClick="quitarTareas('todas')"><br>
                    </td>
			        <td><div id="div_tareas_asignadas"><select id="cboTareasAsignadas" name="cboTareasAsignadas" size="7" multiple style="width:100%">
                </select></div>
        			</td>    
        		</tr>
        	</table> 
        </td>
    </tr>
    <!--<tr>
      <td><INPUT type="text" name="txtAsignar"> <INPUT type="button" name="btnAsignar" value="Asignar"></td>
    </tr>-->
  </tbody>
</table>

</body>

</html>
