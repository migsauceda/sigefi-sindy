<!-- inclusion de archivos -->
<!--controles para los campos del formulario y conexion-->
<?php 	
    include "../clases/Usuario.php";

    session_start(); 

    //funciones genericas
    include "../funciones/php_funciones.php";

    if (isset($_SESSION['objUsuario'])){
        $objUsuario= $_SESSION['objUsuario'];        
    }else{
        header("location:index.php");
    }
//exit($objUsuario->getEtapaId());

    //valida derechos
    if ($objUsuario->getPermiso(5)== '0'){ 
        ?>
        <script type="text/javascript">
        alert("No tiene acceso a esta opción");    
        top.location = "../aplicacion.php";     
        </script>    
        <?php
    }        
               
    include("../clases/controles/funct_text.php");
    include("../clases/controles/funct_select.php");	
    include("../clases/controles/funct_radio.php");
    include("../clases/controles/funct_check.php");
       
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>actividad fiscal</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="select_dependientes_3_niveles.css">
<script type="text/javascript" src="select_dependientes_3_niveles.js"></script>
<!--variables para cookees-->
<script type="text/javascript">
	var imputados= 1;
</script>
   
    <link type="text/css" rel="stylesheet" href="../css/Estilos.css">
    <script type="text/javascript" src="../java_script/funciones.js"></script>

    <!-- jquery -->
    <link href="../java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
    <link href="../java_script/css/smoothness/jquery.datetimepicker.css" rel="stylesheet" type="text/css">
    <script src="../java_script/js/jquery-1.10.2.js"></script>
    <script src="../java_script/js/jquery-ui-1.10.4.custom.js"></script>     
    <script src="../java_script/js/jquery.datetimepicker.js"></script>                 
</head>
<style type="text/css">
    .ui-datepicker {
        font-size: 11px;
        margin-left:10px
     }     
</style>
<body>
<script type="text/javascript">
    $(function(){
        $("#txtFecha").datetimepicker({
            format:'d/m/Y H:m',
            formatTime:'H:m',
            formatDate:'DD/MM/YYYY'
        });
    });   
</script>

<strong><div align="center">Actividad (Diligencias)</div></strong>

<script type="text/javascript">
<?php if (ExisteDenunciaRAM()== "false"){ ?>
            alert("Se requiere una denuncia, utilice el menu Búsqueda");
            parent.document.location.href= '../aplicacion.php';
<?php } ?>
</script>


<script type="text/javascript">

</script>

<br><br>
<FORM action="procesaactividad.php" method="POST" id="frmActividad"  enctype="multipart/form-data" onsubmit="return Antesdesubmit()">
<!--Campos ocultos para guardar datos-->
<INPUT type="hidden" name="txtFiscalid" id="txtFiscalid" size="2">
<INPUT type="hidden" name="cboMateria" id="cboMateria" size="2">
<INPUT type="hidden" name="cboEtapa" id="cboEtapa" size="2">
<INPUT type="hidden" name="txtEtapa" id="txtEtapa" size="2">
<INPUT type="hidden" name="cboSubEtapa" id="cboSubEtapa" size="2">
<INPUT type="hidden" name="txtActividad" id="txtActividad" size="2">
<INPUT type="hidden" name="txtDelito" id="txtDelito" size="2">
<INPUT type="hidden" name="txtImputados" id="txtImputados" size="2">

<table align="center" width="95%" border="0" id="tblGenerales" class="TablaCaja">
  <tbody>
    <tr class="SubTituloCentro">
        <th colspan="4">Imputado o Niño Infractor</th>
    </tr>
<!--    <tr>
        <td width="25%"><span class="lstImputados" id="lsImputados"></span></td>
    </tr>-->
  </tbody>
</table>

<br>
<table align="center" width="95%" border="0" id="tblActividad2" class="TablaCaja">
    <tbody> 
        <tr class="SubTituloCentro">
            <th colspan="2">Actividades Realizadas</th>
        </tr>
        <tr>
           <td>
                <strong>Fecha de diligencia fiscal</strong>
                <input name="txtFecha" type="text" id="txtFecha" size="17" maxlength="16" required/>  
                <strong>Materia</strong>&nbsp;<span id="lstMateria"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <!--<strong>Etapa</strong>&nbsp;<span id="lstEtapa"></span><input type="text" name="txtEtapa" id="txtEtapa" readonly><br>-->
           </td>
        </tr>  
    </tbody> 
</table>
<br>
<table align="center" width="95%" border="0" id="tblDocumentos" class="TablaCaja">
  <tbody>
    <tr class="SubTituloCentro">
        <th colspan="4">Documento Relacionado</th>
    </tr>
    <tr>
        <td width="25%"><div>
                <strong>Descripcion del Archivo</strong><br />
                <input type="text" id="desc" name="desc" size="55"/><br />
                <strong>Archivo</strong><br />
                <input type="file" name="archivoa" id="archivoa" />
            </div></td>
      <td width="20%"></td>
    </tr>
  </tbody>
</table>
<br>
<table align="center">
  <tbody>
    <tr>
      <td><INPUT type="submit" name="btnSubmit" value="Guardar datos"></td>
      <!--<td><INPUT type="reset" name="btnReset" value="Limpiar campos"></td>-->
    </tr>
  </tbody>
</table>
</FORM>

<script type="text/javascript">
    var Contador= 2;
    var Contadeli= 0;
    var Contasub= 1;
    var Contaopt= 1;
    var MismaEtapa= false;
    var EtapaAnterior="";
    var fil=document.getElementById("tblActividad2").insertRow(Contador++);
    var imp=document.getElementById("tblGenerales").insertRow(++Contadeli);

    //llama las funciones para llenar los campos y hace submit-->
    function Antesdesubmit(){ 
        var ok= true;
        var ActividadId= [];
        for(aux= Contador; aux >= 4; aux--){
            ActividadId.push(document.getElementById("txtActividadId"+aux).value);
        }
        ActividadId.toString();

        var DelitoId= [];
        for(aux= Contadeli; aux >= 2; aux--){
            DelitoId.push(document.getElementById("txtDelitoId"+aux).value);
        }
        DelitoId.toString();
        
//        var SubEtapaId= [];
//        for(aux= Contasub; aux >= 2; aux--){
//            SubEtapaId.push(document.getElementById("cmbSubEtapa"+aux).value);
//        }
//        SubEtapaId.toString();
        SubEtapaId= 0;
        
        var ImputadoId= [];
        var cmbImputado= document.getElementById("cmbImputados");
        for(var i= 0; i < cmbImputado.options.length; i++ ){
            if(cmbImputado.options[i].selected){
                ImputadoId.push(cmbImputado.options[i].value);
            }
        }
        
        var arrEtapa= document.getElementById("txtEtapa").value.split(",");                
        var n= arrEtapa.length;        
        MismaEtapa= true;
        for(i= 1; i < n; i++){
            if(arrEtapa[i] !== arrEtapa[i-1]) MismaEtapa= false;
        }
        if (MismaEtapa) {
            document.getElementById("txtEtapa").value= arrEtapa[0];
        }
        
//        alert(Contasub); alert(ActividadId); alert(DelitoId); alert(SubEtapaId); 
//        alert(ImputadoId);

        document.getElementById("txtFiscalid").value= "<?php echo $objUsuario->getIdentidad(); ?>";     
        document.getElementById("cboMateria").value= document.getElementById("cmbMateria").value; 
        document.getElementById("cboSubEtapa").value= SubEtapaId; 
        document.getElementById("txtActividad").value= ActividadId; 
        
        var arrActividad= document.getElementById("txtActividad").value.split(",");
        var n= arrActividad.length;
        var i= 0;
        ActividadIdlst="";
        while (i < n){
            if(i > 0) {
                ActividadIdlst += ",";
            }
            ActividadIdlst += arrActividad[i];
            i= i + 2;
        } 
        document.getElementById("txtActividad").value= ActividadIdlst;
        document.getElementById("txtDelito").value= DelitoId;
        document.getElementById("txtImputados").value= ImputadoId;  
        
        //validar que se selecciono imputado
        if (ImputadoId.length == 0){
            alert("Error: Debe seleccionar al menos un imputado");
            ok= false;
        }   
        
        //validar que se selecciono delito
        if (DelitoId.length == 0){
            alert("Error: Debe seleccionar al menos un delito");
            ok= false;
        }        
        
        //validar que se selecciono actividad
        if (ActividadId.length == 0){
            alert("Error: Debe seleccionar al menos una actividad");
            ok= false;
        }
        
        //validar que sea la misma etapa para todos
        if (!MismaEtapa){
            alert("Error: existen actividades de distintas etapas procesales");
            ok= false;
        }
        
        //validar fecha
        var Fecha = document.getElementById("txtFecha").value.split("/");
        dia= Fecha[0];
        mes= Fecha[1];
        anio= Fecha[2].substring(0,4);
        //alert(dia+', '+mes+', '+anio+', '+hoy.getFullYear()+', '+hoy.getMonth()+', '+hoy.getDate());
        var hoy= new Date();
/*
        if(hoy.getFullYear() < anio){
            alert("Error: pretende registrar una actividad en un año superior al actual que es "+hoy.getFullYear());
            ok= false;
        }
	else{
		//enero es 0 diciembre es 11
		if(hoy.getMonth()+1 < mes){
		    alert("Error: pretende registrar una actividad en un mes superior al actual que es "+hoy.getMonth()+1);
		    ok= false;
		}  
		else{ 
			if(hoy.getDate() < dia){
			    alert("Error: pretende registrar una actividad en un dia superior al actual que es"+hoy.getDate());
			    ok= false;
			}  
		}
	}       
*/
        //return false;
        return ok;
    }
    
    function AgregarDelitos(){
        //agrega los delitos comunes
        var arrImputados = [];
        for (var i=0; i < cmbImputados.length;i++){ 
            if(cmbImputados.options[i].selected){                 
                arrImputados.push(cmbImputados.options[i].value);
            }
            arrImputados.toString();
        }   
        //ajax para conocer los delitos comunes a los imputados
        $.ajax({
           data:       "opcion=delitos&subetapa=0&imputados="+arrImputados,
           type:       "POST",
           datatype:   "json",
           url:    "../funciones/ajax_ActividadFiscal2.php",
           error: function (XMLHttpRequest, textStatus, errorThrown){
               alert("Error al cargar datos para las listas de imputados");
           },
           success: function(json_obj_del){ 
                var CursorDel= JSON.parse(json_obj_del); 
                 
                //borrar delitos viejos de la tabla html
                var Filas= tblGenerales.rows.length;
                Filas--;
                try{
                    for (j= Filas; j > 1; j--){ 
                        document.getElementById("tblGenerales").deleteRow(j);
                    }                    
                }
                catch(err){
                    alert(err)
                }

                Contadeli= 1;
                for (i= 0; CursorDel.length > i; i++){ 
                    Contadeli++;
                    var imp=document.getElementById("tblGenerales").insertRow(Contadeli);
                    
                    //crear el input con delitos                    
                    textodelito= document.createElement("label");
                    textodelito.innerHTML= CursorDel[i].delito;
                   
                    imp.appendChild(textodelito);
                    
                    codigodesc= document.createElement("input");
                    codigodesc.type= "checkbox";
                    codigodesc.name= "txtDelitoDes"+Contadeli;
                    codigodesc.id= "txtDelitoDes"+Contadeli;
                    codigodesc.checked= "checked";
                    codigodesc.class="clsDelitosCheck";
                    
                    textodelito.appendChild(codigodesc);

                    //codigo act
                    codigoid= document.createElement("hidden");
                    codigoid.name= "txtDelitoId"+Contadeli;
                    codigoid.id= "txtDelitoId"+Contadeli;                    
                    codigoid.value= CursorDel[i].delitoid;  
                    codigoid.class= "clsDelitoId";
                    
                    //agrega a la tabla
                    imp.appendChild(codigoid); 
                }       

            }
        });                                 
    }
    
    function AgregarEtapa(SubEtapaId){ 
        var tmp= SubEtapaId.split(",");
        if (document.getElementById("txtEtapa").value== ""){
            document.getElementById("txtEtapa").value += tmp[1];
        }
        else{
            document.getElementById("txtEtapa").value += ","+tmp[1];
        }
        
//        //escribir el nombre de la etapa correspondiente a la subetapa
//        $.ajax({
//           data:       "opcion=etapa&subetapa="+SubEtapaId,
//           type:       "POST",
//           datatype:   "json",
//           url:    "../funciones/ajax_ActividadFiscal2.php",
//           error: function (XMLHttpRequest, textStatus, errorThrown){
//               alert("Error al cargar datos para las listas de etapa");
//           },
//           success: function(json_obj_sub){ 
//               
//                var CursorEtapa= JSON.parse(json_obj_sub); 
//                           
//                if (EtapaAnterior== ""){
//                    MismaEtapa= true;         
//                }
//                else{
//                    if (EtapaAnterior != CursorEtapa[0].descripcion){
//                        MismaEtapa= false; 
//                    }
//                } 
//                
//                EtapaAnterior = CursorEtapa[0].descripcion
//                document.getElementById("txtEtapa").value= CursorEtapa[0].descripcion;
//                document.getElementById("cboEtapa").value= CursorEtapa[0].etapaid;  
//            }
//        });
    }
    
    function AgregarActividad(){
        //agrega tanto la actividad seleccionada como el combo de subetapa
        var ComboAct= document.getElementById("cmbActividad");
        var ActividadId= document.getElementById("cmbActividad").value;
        var ActividadDescripcion= ComboAct.options[ComboAct.selectedIndex].text;
        
       //actividad descripcion texto
        Contador++;
        descripcionact= document.createElement("input");
        descripcionact.name= "txtActividadDes"+Contador;
        descripcionact.id= "txtActividadDes"+Contador;
        descripcionact.value= ActividadDescripcion;  
        descripcionact.size= 100;
        
        //codigo act
        actividadid= document.createElement("hidden");
        actividadid.name= "txtActividadId"+Contador;
        actividadid.id= "txtActividadId"+Contador;
        actividadid.value= ActividadId;  
        actividadid.class= "clsActividad";
            
        fil.appendChild(descripcionact);
        fil.appendChild(actividadid);   
            
        //agrega la etapa de la primer actividad en el combo
        var SubEtapaId= document.getElementById("txtActividadId"+Contador).value;
        AgregarEtapa(SubEtapaId);        
        
        //crea el combo para la subetapa
//        $.ajax({
//           data:       "opcion=subetapa&subetapa="+ActividadId,
//           type:       "POST",
//           datatype:   "json",
//           url:    "../funciones/ajax_ActividadFiscal2.php",
//           error: function (XMLHttpRequest, textStatus, errorThrown){
//               alert("Error al cargar datos para las listas sub etapas");
//           },
//           success: function(json_obj_sub){ 
//          
//                var CursorSub= JSON.parse(json_obj_sub); 
//                
//                //actividad
//                Contasub++;
//                combosub= document.createElement("select");
//                combosub.name= "cmbSubEtapa"+Contasub;
//                combosub.id= "cmbSubEtapa"+Contasub;
//                combosub.class="clsSubEtapa";
////                combosub.value= "0";  
//
//                Contaopt++;
//                for(var i= 0; i < CursorSub.length; i++){ 
//                    id= Contaopt+i;
//                    opt= document.createElement("option");
//                    opt.text=  CursorSub[i].descripcion;
//                    opt.id= "opSub"+id;
//                    opt.value= CursorSub[i].subetapaid;
//
//                    try{
//                            combosub.add(opt,null);
//                    }
//                    catch(e)
//                    {
//                            combosub.add(opt);
//                    }                 
//                }   
//                //agrega a la tabla
//                fil.appendChild(descripcionact);
//                fil.appendChild(actividadid);                 
//                fil.appendChild(combosub);
//                
//                //agregar evento para repcuperar la etapa de la subetapa
//                var evento= document.getElementById("cmbSubEtapa"+Contasub);
//                evento.addEventListener('change', AgregarEtapa);   
//                
//                //agrega la etapa de la primer actividad en el combo
//                var SubEtapaId= document.getElementById("cmbSubEtapa"+Contasub).value;
//                AgregarEtapa(SubEtapaId);
//            }
//        });                
    }
    
    //agrega el combo del cual se selecciona la actividad
    var Etapa= "<?php echo $objUsuario->getEtapaId(); ?>";
    $.ajax({
        data:       "opcion=actividad&subetapa=0&etapa="+Etapa,
        type:       "POST",
        datatype:   "json",
        url:    "../funciones/ajax_ActividadFiscal2.php",
        error: function (XMLHttpRequest, textStatus, errorThrown){
            alert("Error al cargar datos para las listas de actividad");
        },
        success: function(json_obj){ //alert(json_obj);
            
            var Cursor= JSON.parse(json_obj); 
            
            //br
            br= document.createElement("br");
            fil.appendChild(br);
            
            negrita= document.createElement("strong");
            tit= document.createTextNode("Actividades:")
            negrita.appendChild(tit);

            fil.appendChild(negrita);
            
            //br
            br= document.createElement("br");
            fil.appendChild(br);
            
            //actividad
            combo= document.createElement("select");
            combo.name= "cmbActividad";
            combo.id= "cmbActividad";
//            combo.value= "0";  

            opt= document.createElement("option");
            opt.text=  "Seleccione una actividad";
            opt.id= "0";
            opt.value= "0";
            
            try{
                    combo.add(opt,null);
            }
            catch(e)
            {
                    combo.add(opt);
            }            
        
            for(var i= 0; i < Cursor.length; i++){
                        opt= document.createElement("option");
                        opt.text=  Cursor[i].actividaddesc;
                        opt.id= "optActividad"+i;
                        opt.value= Cursor[i].actividadid;

                        try{
                                combo.add(opt,null);
                        }
                        catch(e)
                        {
                                combo.add(opt);
                        }                 
            }
            fil.appendChild(combo);
            
            //br
            br2= document.createElement("br");
            fil.appendChild(br2);         
            
            //bh
//            separador= document.createElement("hr");
//            fil.appendChild(separador);    
            
            //br
            br2= document.createElement("br");
            fil.appendChild(br2);       
            //br
            br2= document.createElement("br");
            fil.appendChild(br2);              
            
            //agrega el evento al combo para agregar la actividad seleccionada
            var evento= document.getElementById("cmbActividad");
            evento.addEventListener('change', AgregarActividad);
        }
    });  
    
    //agrega el combo del cual se selecciona imputados
    $.ajax({
        data:       "opcion=imputados&subetapa=0",
        type:       "POST",
        datatype:   "json",
        url:    "../funciones/ajax_ActividadFiscal2.php",
        error: function (XMLHttpRequest, textStatus, errorThrown){
            alert("Error al cargar datos para las listas imputados");
        },
        success: function(json_obj){ //alert(json_obj);

            var Cursor= JSON.parse(json_obj); 

            //actividad
            combo= document.createElement("select");
            combo.multiple= "yes";
            combo.name= "cmbImputados";
            combo.id= "cmbImputados";
            combo.class="clsImputados";
//            combo.value= "0";  
        
            for(var i= 0; i < Cursor.length; i++){
                        opt= document.createElement("option");
                        opt.text=  Cursor[i].nombre;
                        opt.id= "optActividad"+i;
                        opt.value= Cursor[i].imputadoid;

                        try{
                                combo.add(opt,null);
                        }
                        catch(e)
                        {
                                combo.add(opt);
                        }                 
            }
            imp.appendChild(combo);
            
            //agrega el evento al combo para agregar los delitos comunes
            var evento= document.getElementById("cmbImputados");
            evento.addEventListener('change', AgregarDelitos);
        }
    });  
    
    //agrega el combo de materia
    $.ajax({
        data:       "opcion=materia&subetapa=0",
        type:       "POST",
        datatype:   "json",
        url:    "../funciones/ajax_ActividadFiscal2.php",
        error: function (XMLHttpRequest, textStatus, errorThrown){
            alert("Error al cargar datos para las listas de materia");
        },
        success: function(json_obj){ //alert(json_obj);

            var Cursor= JSON.parse(json_obj); 

            //actividad
            combomat= document.createElement("select");
            combomat.name= "cmbMateria";
            combomat.id= "cmbMateria";
            combomat.value= "0";  
        
            for(var i= 0; i < Cursor.length; i++){
                        opt= document.createElement("option");
                        opt.text=  Cursor[i].descripcion;
                        opt.id= "optMateria"+i;
                        opt.value= Cursor[i].materiaid;

                        try{
                                combomat.add(opt,null);
                        }
                        catch(e)
                        {
                                combomat.add(opt);
                        }                 
            }
            lstmateria= document.getElementById("lstMateria"); 
            lstmateria.appendChild(combomat);            
        }
    });      
    
    //agrega el combo de etapa
//    $.ajax({
//        data:       "opcion=etapa&subetapa=0",
//        type:       "POST",
//        datatype:   "json",
//        url:    "../funciones/ajax_ActividadFiscal2.php",
//        error: function (XMLHttpRequest, textStatus, errorThrown){
//            alert("Error al cargar datos para las listas");
//        },
//        success: function(json_obj){ //alert(json_obj);
//
//            var Cursor= JSON.parse(json_obj); 
//
//            //actividad
//            comboetap= document.createElement("select");
//            comboetap.name= "cmbEtapa";
//            comboetap.id= "cmbEtapa";
//            comboetap.value= "0";  
//        
//            for(var i= 0; i < Cursor.length; i++){
//                        opt= document.createElement("option");
//                        opt.text=  Cursor[i].descripcion;
//                        opt.id= "optMateria"+i;
//                        opt.value= Cursor[i].etapaid;
//
//                        try{
//                                comboetap.add(opt,null);
//                        }
//                        catch(e)
//                        {
//                                comboetap.add(opt);
//                        }                 
//            }
//            lstEtapa= document.getElementById("lstEtapa"); 
//            lstEtapa.appendChild(comboetap);            
//        }
//    });      
</script>    
</body>
</html>
