<!-- inclusion de archivos -->
<!--controles para los campos del formulario y conexion-->
<?php   
    include "../clases/Usuario.php";
    //clase
    include("../clases/Denuncia.php");
    //require_once '../clases/Denuncia.php';


    session_start(); 

    //funciones genericas
    include "../funciones/php_funciones.php";

    if (isset($_SESSION['objUsuario'])){
        $objUsuario= $_SESSION['objUsuario'];        
    }else{
        header("location:index.php");
    }
    
    //si el objeto ya existe, inicializarlo de nuevo para mostrar los datos
        if(isset($_SESSION["oDenuncia"])){ 
            $oDenuncia= $_SESSION["oDenuncia"];             
        }     
//exit($objUsuario->getEtapaId());

    if (isset($_GET['var'])){
    $denuncia= ($_GET['var']);
    $_SESSION["denunciaid"]= $denuncia;
}
 

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

<script type="text/javascript">
    
</script>

<strong><div align="center">Actividad (Diligencias)</div></strong>

<script type="text/javascript">
<?php if (ExisteDenunciaRAM()== "false"){ ?>
            alert("Se requiere una denuncia, utilice el menu Búsqueda");
            parent.document.location.href= '../aplicacion.php';
<?php } ?>
</script>




<br><br>
<FORM action="procesaactividad.php" method="POST" id="frmActividad"  enctype="multipart/form-data" onsubmit="return Antesdesubmit(this)">
<!--Campos ocultos para guardar datos-->
<INPUT type="hidden" name="txtFiscalid" id="txtFiscalid" size="2">
<INPUT type="hidden" name="cboMateria" id="cboMateria" size="2">
<INPUT type="hidden" name="cboEtapa" id="cboEtapa" size="2">
<INPUT type="hidden" name="txtEtapa" id="txtEtapa" size="2">
<INPUT type="hidden" name="cboSubEtapa" id="cboSubEtapa" size="2">
<INPUT type="hidden" name="txtActividad" id="txtActividad" size="2">
<INPUT type="hidden" name="txtDelito" id="txtDelito" size="2">
<INPUT type="hidden" name="txtImputados" id="txtImputados" size="2">

<!-- input ocultos para guardar info de actividades -->
 <input type="hidden" name="txtTodosActividades" id="txtTodosActividades"> 
 
 <script type="text/javascript">
    $("#txtTodosActividades").attr("value",-1);

</script>

<script type="text/javascript">

    //recorre las tabla de actividad para crear una lista
 //que se usa para grabar los datos a la base de datos
  function CrearListaActividad(TablaId) {
        //actividad
            Desde= 0;
            Hasta= 0;
            var i= 0;

            iterar = document.getElementById("actividad").rows.length;
            document.getElementById("txtTodosActividades").value="";            

            for(i=0; i <=iterar; i++)
            {                
                try{ 

                        if (document.getElementById("actividad"+i)){                            
                            if(!(document.getElementById("actividad"+i).value == '' || document.getElementById("actividad"+i).value == null)){
                                document.getElementById("txtTodosActividades").value=
                                document.getElementById("txtTodosActividades").value + 
                                document.getElementById("actividad"+i).value+";";   
                            }
                        }
                                      
                }catch(err){                    
                }                    
            }

    }

</script>




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
                <strong>Etapa</strong>&nbsp;<span id="lstEtapa"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                
                
           </td>
        </tr>  
    </tbody> 
</table>

 
<br><br>
    <!--actividad-->
    <table id="actividad" align="center" width="95%" border="0" 
           class="TablaCaja" summary="actividad">    
        <tr class="SubTituloCentro"><TH colspan="4">Actividades</TH></tr>     
        <tr class="Grid">

        <td colspan="2">
         <INPUT type="button" id="actividad_agre" name="actividad_agre" value="Agregar actividad" onclick=AgregarFila(actividad);> 
        </td>           
        </tr>
    </table>
<br>


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
      <td><INPUT type="submit" name="btnSubmit" value="Guardar datos" 
                 onClick="CrearListaActividad('actividad');"></td>
      

    </tr>
  </tbody>
</table>
</FORM>

<script type="text/javascript">
    var Contador= 0;
    var Contadeli= 0;
    var Contasub= 1;
    var Contaopt= 1;
    var MismaEtapa= false;
    var EtapaAnterior="";

    //variable para contar actividad
    var  Actividad= 0; 
    var  BorrarActividad= 0;
    var fil=document.getElementById("tblActividad2").insertRow(Contador++);
    var imp=document.getElementById("tblGenerales").insertRow(++Contadeli);

    //llama las funciones para llenar los campos y hace submit-->
    function Antesdesubmit(frm){ 
        var ok= true;
        var ActividadId= [];
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
       
         if (frm.txtTodosActividades.value == "" || frm.txtTodosActividades.value == "-1")
    {
        alert("Debe ingresar al menos una actividad:"+frm.txtTodosActividades.value);
        return false;
    }
        
//        alert(Contasub); alert(ActividadId); alert(DelitoId); alert(SubEtapaId); 
//        alert(ImputadoId);

        document.getElementById("txtFiscalid").value= "<?php echo $objUsuario->getIdentidad(); ?>";     
        document.getElementById("cboMateria").value= document.getElementById("cmbMateria").value; 
        document.getElementById("cboEtapa").value= document.getElementById("cmbEtapa").value; 
        //document.getElementById("cboEtapa").value= document.getElementById("cmbEtapa").value;
        document.getElementById("cboSubEtapa").value= SubEtapaId; 
        
        
        
        document.getElementById("txtDelito").value= DelitoId;
        document.getElementById("txtImputados").value= ImputadoId;  

        var arrEtapa= document.getElementById("cboEtapa").value();                
        var n= arrEtapa.length;        
        MismaEtapa= true;
        for(i= 0; i < n; i++){
            if(arrEtapa[i] !== arrEtapa[i-1]) MismaEtapa= false;
        }
        if (MismaEtapa) {
            document.getElementById("").value= arrEtapa[0];
        }

        
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



function copiarMateria(){ 
    var Etapaid = document.getElementById("cmbEtapa").value;
    var Materiaid= document.getElementById("cmbMateria").value;
    
}

function copiarEtapa(){ 
    var Etapaid = document.getElementById("cmbEtapa").value;
    var Materiaid= document.getElementById("cmbMateria").value;
    

    AgregarFila1(8, Etapaid, Materiaid);
}
 
 
   


    function AgregarFila1(fila, Etapaid, Materiaid)
{ 
   
     Contador= 0;
     Actividad++;
     Contador= Actividad;

     
    var fil=document.getElementById("actividad").insertRow(--Contador);
    fil.id = "campo1"+Contador;
    col= document.createElement("td");
    col.width="5%";
    

    txt0= document.createElement("input");
    txt0.type= "button";
    txt0.name= "campo1"+Contador;
    txt0.id= "campo1"+Contador;
    txt0.value= "Borrar";

    txt0.onclick= function() {BorrarFilaActividad("actividad",fil.rowIndex);};

    col.appendChild(txt0);
    fil.appendChild(col);  

    col= document.createElement("td"); 

    txt1= document.createElement("select");
    txt1.name= "actividad"+Contador;
    txt1.id= "actividad"+Contador;


        $.ajax({
        data:       {Etapaid:Etapaid,Materiaid: Materiaid,op: "mostrar", },
        type:       "POST",
        url:    "../funciones/php_funciones.php",
        error: function (XMLHttpRequest, textStatus, errorThrown){
            alert("Error al cargar datos para las listas de etapas");
        },
        success: function(json_obj_del){ //alert(json_obj);
            var json=JSON.parse(json_obj_del);


      for (var i = 0 ; json.length>=i; i++) {
     opt= document.createElement("option");
                            opt.text= json[i]['cdescripcion'];
                            opt.id= "opcion"+Contador;
                            opt.value= json[i]['nactividadid'];

                            try{
                                    txt1.add(opt,null);
                            }
                            catch(e)
                            { 
                                    txt1.add(opt);
                            }

}
 
        }


    }); 

    col.appendChild(txt1);
    fil.appendChild(col);

    document.getElementById("actividad"+Contador).value= Etapaid;     
    
    
}
function AgregarFila(fila, Etapaid, Materiaid)
{ 
    //alert(Etapaid);
   
   Contador= 0;
   Actividad++;
   Contador= Actividad;
     
 
    var fil=document.getElementById("actividad").insertRow(--Contador);
    fil.id = "campo1"+Contador;
    col= document.createElement("td");
    col.width="5%";
    

    txt0= document.createElement("input");
    txt0.type= "button";
    txt0.name= "campo1"+Contador;
    txt0.id= "campo1"+Contador;
    txt0.value= "Borrar";

    txt0.onclick= function() {BorrarFilaActividad("actividad",fil.rowIndex);};

    col.appendChild(txt0);
    fil.appendChild(col);  

    col= document.createElement("td"); 

    txt1= document.createElement("select");
    txt1.name= "actividad"+Contador;
    txt1.id= "actividad"+Contador;


        $.ajax({
        data:       {op: "listarfila", },
        type:       "POST",
        url:    "../funciones/php_funciones.php",
        error: function (XMLHttpRequest, textStatus, errorThrown){
            alert("Error al cargar datos para las listas de etapas");
        },
        success: function(json_obj_del){ //alert(json_obj);
            var json=JSON.parse(json_obj_del);


for (var i = 0 ; json.length>=i; i++) {
     opt= document.createElement("option");
                            opt.text= json[i]['cdescripcion'];
                            opt.id= "opcion"+Contador;
                            opt.value= json[i]['nactividadid'];

                            try{
                                    txt1.add(opt,null);
                            }
                            catch(e)
                            { 
                                    txt1.add(opt);
                            }

}
 
        }


    }); 

    col.appendChild(txt1);
    fil.appendChild(col);

    document.getElementById("actividad"+Contador).value= Etapaid;     
    
    
}

function BorrarFilaActividad(fila) { 
    document.getElementById("actividad").deleteRow(fila);
    Actividad--;  
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
        success: function(json_obj_del){ //alert(json_obj);
            
            var Cursor= JSON.parse(json_obj_del); 
            
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

            var materia =document.getElementById("cmbMateria");
            materia.addEventListener("change", copiarMateria);         
        }
    });     

    //agrega el combo de etapa
    $.ajax({
        data:       "opcion=etapa&subetapa=0",
        type:       "POST",
        datatype:   "json",
        url:    "../funciones/ajax_ActividadFiscal2.php",
        error: function (XMLHttpRequest, textStatus, errorThrown){
            alert("Error al cargar datos para las listas de etapas");
        },
        success: function(json_obj){ //alert(json_obj);
           var Cursor= JSON.parse(json_obj); 

            //actividad
            comboetap= document.createElement("select");
            comboetap.name= "cmbEtapa";
            comboetap.id= "cmbEtapa";
            comboetap.value= "0";  
        
            for(var i= 0; i < Cursor.length; i++){
                        opt= document.createElement("option");
                        opt.text=  Cursor[i].descripcion;
                        opt.id= "optEtapa"+i;
                        opt.value= Cursor[i].etapaid;

                        try{
                                comboetap.add(opt,null);
                        }
                        catch(e)
                        {
                                comboetap.add(opt);
                        }                 
            }
            lstEtapa= document.getElementById("lstEtapa"); 
            lstEtapa.appendChild(comboetap);

            var etapa =document.getElementById("cmbEtapa");
            etapa.addEventListener("change", copiarEtapa);

        }
    });      
    
    
</script>    
</body>
</html>
