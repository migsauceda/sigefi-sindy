/*variables globales
 */


/*
Funcion: llenar los combos
Relacion: generales.php
Actualizacion: 12abr2012
*/
function llena_muni(iddepto,iddestino,tddestino,op,clearAldea,clearBarrio){//llenado del select d municipios        
//   alert(iddepto+iddestino+tddestino+op+clearAldea+clearBarrio);
    $('#'+clearAldea).val("0");// se resetea el campos de Aldea
    $('#'+clearBarrio).val("0");// se resetea el campos de Barrio
    var valor = $('#'+iddepto).val();// valor de depto 
    $.ajax({
        data: "iddestino="+iddestino+"&depto="+valor+"&op="+op,
        type: "POST",
        dataType: "html",
        url: "../funciones/ajax_muni.php",
        error: function(objeto, quepaso, otroobj){
            alert("Error al cargar Municipio: "+quepaso);
        },
        success: function(data){ 
            $("#"+tddestino).html(data); 
        }
    });
}

//******************************************************************************
//
//aldea denunciado
function llena_aldea(iddepto,idmuni,iddestino,tddestino,op,clearBarrio){// llenado del select aldeas
    $('#'+clearBarrio).val("0")// se resetea el campos de Barrio
    var depto = $("#"+iddepto).val();// valor de depto
    var municipio=$("#"+idmuni).val();// valor de municipio
//    alert("mig;"+iddestino+" "+tddestino+" "+op);
    $.ajax({
        data: "iddestino="+iddestino+"&idorigen_depto="+depto+"&idorigen_muni="+municipio+"&op="+op,
        type: "POST",
        dataType: "html",
        url: "../funciones/ajax_aldea.php",
        error: function(objeto, quepaso, otroobj){
            alert("Error al cargar Aldea o Ciudad: "+quepaso);
        },
        success: function(data){
            $("#"+tddestino).html(data);
        }    
    });
}
/******************************************************************************/

function llena_barrio(iddepto,idmuni,idaldea,iddestino,tddestino,op){ //Llenado del select de barrios
    var depto = $("#"+iddepto).val();// valor de depto
    var municipio=$("#"+idmuni).val();// valor de municipio
    var aldea=$("#"+idaldea).val();// valor de aldea o Ciudad
//    alert(depto+","+municipio+","+aldea+","+iddestino+","+tddestino+","+op);

    $.ajax({
        data: "iddestino="+iddestino+"&idorigen_depto="+depto+"&idorigen_muni="+municipio+"&idorigen_aldea="+aldea+"&op="+op,
        type: "POST",
        dataType: "html",
        url: "../funciones/ajax_barrio.php",
        error: function(objeto, quepaso, otroobj){
            alert("Error al cargar Barrio o Colonia: "+quepaso);
        },
        success: function(data){
            $("#"+tddestino).html(data);
        }    
    });
}
/******************************************************************************/

/*
Funcion: llenar combo de orientacion sexual
Relacion: denunciante.php, denunciado.php
Actualizacion: 10jun2012
*/
function llenarsexo(destino, sex, frm, valor){  
//    alert(destino +" "+ sex + " " +frm+":"+valor);

    //valor por defecto
    if (typeof(valor) != "undefined") valor= 'x';
    valor = (valor) ? valor : 'x'; 

    $.ajax({
        data: "id="+destino+"&sexo="+sex,
        type: "POST",
        dataType: "html",
        url: "../funciones/ajax_OrientacionSexual.php",
        error: function(obj, que, otro){
            alert("Error ajax al cargar orientacion sex "+que);
        },
        success: function(data){ 
            if(typeof(frm.txtEdad)!= "undefined"){
                frm.txtEdad.disabled= false;  
            }

            if (frm.name== 'frmDenunciante'){ 
                frm.rdAno.disabled= false;         
                $("#selSexo1").html(data);              
            } 
          
            if (frm.name== 'frmImputado'){ 
                frm.rdAno3.disabled= false;         
                $("#selSexo2").html(data);   
            }   
            
            if (frm.name== 'frmOfendido'){
                frm.rdAno4.disabled= false;  
                $("#selSexo4").html(data); 
            }   
            

            if (valor != 'x'){  
                if (valor== 'H')
                    valor= 'het';
                else if(valor== 'L')
                    valor= 'het';
                else if(valor== 'G')
                    valor= 'gay';
                else if(valor== 'B')
                    valor= 'bis';
                else if(valor== 'T')
                    valor= 'tra';
                else if(valor== 'N')
                    valor= 'no';
             
                document.getElementById(destino).value= valor;
            }            
        }
    });   
}

/* 
Funcion: Llena combo de imputado segun la denuncia suministrada
Relacion: Formulario para crear asignar fiscalia
Actualizacion: 30ago2012
*/
function CargarImputado(denuncia)
{
    alert(denuncia);
}


/*
Funcion: Saber si una cadena esta vacia o no
Relacion: generales.php
Actualizacion: 12abr2012
*/
function vacio(q) 
{ //alert(q.length);
         for ( i = 0; i < q.length; i++ ) {  
                 if ( q.charAt(i) != " " ) {  
                         return true;
                 }  
         }  
         return false;
}

/*
Funcion: validar datos entrada del frm generales
Relacion: generales.php
Actualizacion: 12abr2012
*/
function ValidarGenerales(frm)
{ 
    if (frm.cboClaseLugar.value== 0){
            alert("Debe ingresar datos en 'Clase de lugar de hechos'");
            return false;        
    }
    
    if (vacio(frm.txtFechaDenuncia.value)== false) {
            alert("Debe ingresar datos en 'Fecha de Denuncia'");
            return false;
    }	

    if (frm.cboRecepcion.value== 0) {
            alert("Debe ingresar datos en 'Lugar de Recepcion'");
            return false;
    }	

//    if (vacio(frm.txtDetalle.value)== false) {
//            alert("Debe ingresar datos en 'Detalle de Direccion'");
//            return false;
//    }

    if (vacio(frm.hechos.value)== false) {
            alert("Debe ingresar datos en 'Narracion de hechos'");
            return false;
    }

    var fdenuncia= new Date();
    fdenuncia.setFullYear(frm.txtFechaDenuncia.value.substring(6,10));
    fdenuncia.setMonth(frm.txtFechaDenuncia.value.substring(3,5)-1);
    fdenuncia.setDate(frm.txtFechaDenuncia.value.substring(0,2));
    fdenuncia.setHours(frm.txtFechaDenuncia.value.substring(11,13));                     
    fdenuncia.setMinutes(frm.txtFechaDenuncia.value.substring(14,16));
    fdenuncia.setSeconds(frm.txtFechaDenuncia.value.substring(17,19));
    
    var fhecho=    new Date(frm.txtFechaHecho.value.substring(6,10),
                            frm.txtFechaHecho.value.substring(3,5)-1,
                            frm.txtFechaHecho.value.substring(0,2),
                            frm.txtFechaDenuncia.value.substring(11,13),
                            frm.txtFechaDenuncia.value.substring(14,16),
                            frm.txtFechaDenuncia.value.substring(17,19));    
                                                        
    var factual= new Date();
//    alert(frm.txtFechaDenuncia.value+" "+fdenuncia + factual+fhecho);
    if (fdenuncia <= fhecho){
        alert("Error: La fecha y hora de la denuncia no puede ser anterior o igual a la del hecho");
        return false;
    }
    
    if (fdenuncia > factual){
        alert("Error: La fecha de la denuncia no puede ser mayor al día de hoy");
        return false;
    }
    
    return true;
}
/*************************** Inicia Denunciante ********************************/
/*
Funcion: validar si el denunciante es conocido, anonimo o de identidad protegida
Relacion: denunciante.php
Actualizacion: 31may2012
*/
function ValidarConocido(valor, frm){ 
    //se pasa el nombre del formulario como cadena
    //luego se valida el nombre de el para discriminar campos
    //frmdenunciante, frmdenunciado, frmofendido
    if (valor== "tpr" || valor== "ano" || valor== "ofi" || valor== "fe" || valor== "des") 
    {       
        //para denunciante
        if (valor== "ano" && frm.name == 'frmDenunciante'){
            frm.rdSexo2.checked= true;
            frm.rdRangoEdad5.checked= true;
            frm.txtEdad.value= "0";
            frm.rdAno1.checked= true;            
            frm.txtNombres.value= "-- ANÓNIMO --";
            frm.txtApellidos.value= "-- ANÓNIMO --";  
        } else
        if (valor== "ofi" && frm.name == 'frmDenunciante')
        {
            frm.rdSexo2.checked= true;
            frm.rdRangoEdad5.checked= true;
            frm.txtEdad.value= "0";
            frm.rdAno1.checked= true;
            frm.txtNombres.value= "-- OFICIO --";
            frm.txtApellidos.value= "-- OFICIO --"; 
        }    
        //para ofendido
        if (valor== "ano" && frm.name == 'frmOfendido'){
            frm.rdSexo2.checked= true;
            frm.rdRangoEdad4.checked= true;
            frm.txtEdad.value= "0";
            frm.rdAno1.checked= true;            
            frm.txtNombres.value= "-- ANÓNIMO --";
            frm.txtApellidos.value= "-- ANÓNIMO --";  
        } else
        if (valor== "fe" && frm.name == 'frmOfendido')
        {
            frm.rdSexo2.checked= true;
            frm.rdRangoEdad4.checked= true;
            frm.txtEdad.value= "0";
            frm.rdAno1.checked= true;
            frm.txtNombres.value= "-- La Fé Publica --";
            frm.txtApellidos.value= "-- La Fé Publica --";
        } else
        if (valor== "tpr"  && frm.name == 'frmOfendido')
        {
            frm.rdSexo2.checked= true;
            frm.rdRangoEdad4.checked= true;
            frm.txtEdad.value= "0";
            frm.rdAno1.checked= true;
            frm.txtNombres.value= "-- TESTIGO PROTEGIDO --";
            frm.txtApellidos.value= "-- TESTIGO PROTEGIDO --"; 
        }                       
        //denuciado    
        if (valor== "des")
        {  
            frm.rdSexo3.checked= true;            
            frm.txtEdad3.value= "0";
            frm.rdAno3.checked= true;
            frm.rdRangoEdad3.checked= true;
            frm.txtNombres.value= "-- DESCONOCIDO --";
            frm.txtApellidos.value= "-- DESCONOCIDO --"; 
        }
        
            //****//
        if (valor== "fe"){ 
            frm.rdSexo2.checked= true;
            frm.rdRangoEdad5.checked= true; 
            frm.txtEdad.value= "0"; 
            frm.rdAno1.checked= true; 
            frm.txtNombres.value= "-- La Fé Publica --";
            frm.txtApellidos.value= "-- La Fé Publica --";              
        } else        
        if (valor== "ofi")
        {
            frm.rdSexo2.checked= true;
            frm.rdRangoEdad5.checked= true;
            frm.txtEdad.value= "0";
            frm.rdAno1.checked= true;
            frm.txtNombres.value= "-- OFICIO --";
            frm.txtApellidos.value= "-- OFICIO --"; 
        } else
        if (valor== "des")
        { 
            frm.rdSexo2.checked= true;
            frm.txtEdad.value= "0";
            frm.rdAno1.checked= true;
            frm.rdRangoEdad5.checked= true;
            frm.txtNombres.value= "-- DESCONOCIDO --";
            frm.txtApellidos.value= "-- DESCONOCIDO --"; 
        } else
        if (valor== "tpr")
        {
            frm.rdSexo2.checked= true;
            frm.rdRangoEdad5.checked= true;
            frm.txtEdad.value= "0";
            frm.rdAno1.checked= true;
            frm.txtNombres.value= "-- TESTIGO PROTEGIDO --";
            frm.txtApellidos.value= "-- TESTIGO PROTEGIDO --"; 
        }            
        
        frm.rdSexo1.disabled= true;
        frm.rdSexo0.disabled= true;
        
        if (frm.name != 'frmImputado')
        {
            frm.apoderado.disabled= true;
        }
        
        frm.txtNombres.disabled= true;
        frm.txtApellidos.disabled= true;
        
        frm.cboNacionalidad.disabled= true;
        frm.cboCivil.disabled= true;
        
        frm.txtIdentidad.disabled= true;
        frm.cboTipoDoc.disabled= true;
        frm.cboEscolar.disabled= true;
        
        frm.cboProfe.disabled= true;
        frm.cboOcupa.disabled= true;
        
        frm.txtEdad.disabled= true;
        frm.rdAno0.disabled= true;
        frm.rdAno1.disabled= true;
        
        if (frm.name == 'frmOfendido')
        {        
            frm.rdAno2.disabled= true;
            frm.rdAno3.disabled= true; 
        }       
        
        frm.rdRangoEdad0.disabled= true;
        frm.rdRangoEdad1.disabled= true;
        frm.rdRangoEdad2.disabled= true;
        frm.rdRangoEdad3.disabled= true;
        frm.rdRangoEdad4.disabled= true;
        frm.rdRangoEdad5.disabled= true;
        
        frm.cboDepto.disabled= true;
        frm.cboMuni.disabled= true;
        frm.cboAldea.disabled= true;
        frm.cboBarrio.disabled= true;
        
        frm.txtDireccion.disabled= true;
        
        frm.cboEtnia.disabled= true;
        frm.cboDiscapacidad.disabled= true;        
    } 
    else{
        frm.rdSexo0.disabled= false;
        frm.rdSexo1.disabled= false;
        
        if (frm.name != 'frmImputado')
        {
            frm.apoderado.disabled= false;
        }
        
        frm.txtNombres.disabled= false;
        frm.txtApellidos.disabled= false;
        
        frm.cboNacionalidad.disabled= false;
        frm.cboCivil.disabled= false;
        
        frm.txtIdentidad.disabled= false;
        frm.cboTipoDoc.disabled= false;
        frm.cboEscolar.disabled= false;
        
        frm.cboProfe.disabled= false;
        frm.cboOcupa.disabled= false;
        
        frm.txtEdad.disabled= false;
        frm.rdAno0.disabled= false;
        frm.rdAno1.disabled= false;
        
        if (frm.name== 'frmOfendido')
        {        
            frm.rdAno2.disabled= false;
            frm.rdAno3.disabled= false; 
        }       
        
        frm.rdRangoEdad0.disabled= false;
        frm.rdRangoEdad1.disabled= false;
        frm.rdRangoEdad2.disabled= false;
        frm.rdRangoEdad3.disabled= false;
        frm.rdRangoEdad4.disabled= false;
        frm.rdRangoEdad5.disabled= false;                
        
        frm.cboDepto.disabled= false;
        frm.cboMuni.disabled= false;
        frm.cboAldea.disabled= false;
        frm.cboBarrio.disabled= false;
        
        frm.txtDireccion.disabled= false;        
        
        frm.cboEtnia.disabled= false;
        frm.cboDiscapacidad.disabled= false;           
    }
//    alert(frm.rdConocido[2].value);    
}

/*
Funcion: validar datos entrada del frm denunciante
Relacion: denunciante.php
Actualizacion: 31may2012
*/
function ValidarDenunciante(frm)
{ 
    //si es denuncia anonima, no validar nada y regresar true
    if (frm.rdConocido[0].checked== true || frm.rdConocido[3].checked== true){ 
        document.getElementById("rdSexo0").disabled= false;
        document.getElementById("rdSexo1").disabled= false;
        
        document.getElementById("apoderado").disabled= false;
        
        document.getElementById("txtNombres").disabled= false;
        document.getElementById("txtApellidos").disabled= false;
        
        document.getElementById("cboNacionalidad").disabled= false;
        document.getElementById("cboCivil").disabled= false;
        
        document.getElementById("txtIdentidad").disabled= false;
        document.getElementById("cboTipoDoc").disabled= false;
        document.getElementById("cboEscolar").disabled= false;
        
        document.getElementById("cboProfe").disabled= false;
        document.getElementById("cboOcupa").disabled= false;
        
        document.getElementById("txtEdad").disabled= false;
        document.getElementById("rdAno0").disabled= false;
        document.getElementById("rdAno1").disabled= false;      
        document.getElementById("rdRangoEdad0").disabled= false;
        document.getElementById("rdRangoEdad1").disabled= false;
        document.getElementById("rdRangoEdad2").disabled= false;
        document.getElementById("rdRangoEdad3").disabled= false;
        document.getElementById("rdRangoEdad4").disabled= false;
        document.getElementById("rdRangoEdad5").disabled= false;
        
        document.getElementById("cboDepto").disabled= false;
        document.getElementById("cboMuni").disabled= false;
        document.getElementById("cboAldea").disabled= false;
        document.getElementById("cboBarrio").disabled= false;
        
        document.getElementById("txtDireccion").disabled= false;
        
        document.getElementById("cboEtnia").disabled= false;
        document.getElementById("cboDiscapacidad").disabled= false;             
        
        return true;
    }
        

    Ok= true;
    CamposFaltantes="";

    if (frm.cboDepto.value== ""){ alert("d");
        frm.cboDepto.value= "0";
    }

    if (frm.cboMuni.value== ""){ alert("m");
        frm.cboMuni.value= "0";
    }

    if (frm.cboAldea.value== ""){ alert("a");
        frm.cboAldea.value= "0";
    }

    if (frm.cboBarrio.value== ""){ alert("b");
        frm.cboBarrio.value= "0";
    }        

    //validar direccion de tal modo que no existan inconsistencias como 
    //ciudad sin depto, depto sin municipio, etc
    if (frm.cboDepto.value== "0"){
        frm.cboMuni.value= "0";
        frm.cboAldea.value= "0";
        frm.cboBarrio.value= "0";
    }else if(frm.cboMuni.value== "0"){
        frm.cboAldea.value= "0";
        frm.cboBarrio.value= "0";
    }else if (frm.cboAldea.value== "0"){
        frm.cboBarrio.value= "0";
    }
  
    if (frm.cboNacionalidad.value== 0 || frm.cboNacionalidad.value== "")
    {
            Ok= false;
            CamposFaltantes= "Nacionalidad\n";
            frm.cboNacionalidad.value= "AA";
    }


    if (frm.cboCivil.value== "")
    {
            Ok= false;
            CamposFaltantes= CamposFaltantes + "Estado civil\n";
            frm.cboCivil.value= "0";
    }

    if (frm.cboEscolar.value== "")
    {
            Ok= false;
            CamposFaltantes= CamposFaltantes + "Escolaridad\n";
            frm.cboEscolar.value= "0";
    }

    if (frm.cboProfe.value== "")
    {
            Ok= false;
            CamposFaltantes= CamposFaltantes + "Profesión\n";
            frm.cboProfe.value= "0";
    }

    if (frm.cboOcupa.value== "")
    {
            Ok= false;
            CamposFaltantes= CamposFaltantes + "Ocupasión\n";
            frm.cboOcupa.value= "0";
    }

    if (frm.cboEtnia.value== "")
    {
            Ok= false;
            CamposFaltantes= CamposFaltantes + "Pueblo indígena\n";
            frm.cboEtnia.value= "0";
    }

    if (frm.cboDiscapacidad.value== "")
    {
            Ok= false;
            CamposFaltantes= CamposFaltantes + "Discapacidad\n";
            frm.cboDiscapacidad.value= "0";
    }

    if (Ok== false)
    {
            var Guardar= confirm ("La siguiente información hace falta, \npresione"
                       +" Cancelar para corregir\n"
                       +CamposFaltantes)
            if (Guardar== true)
            {
                    Ok= true;
            }
            else
            {
                    Ok= false;
            }
    }

    if (frm.txtIdentidad.value!= "" && frm.cboTipoDoc.value== "0")
    {
            Ok= false;
            alert("Debe ingresar un valor en tipo de documento,\n\
o borrar el número en Pasaporte o Identidad.");
            frm.cboTipoDoc.value= "0"; 
    }

    if ((frm.txtEdad.value== "0" ||
        (frm.txtEdad.value== "")) &&
        frm.rdAno[1].checked== false)
    {

        Ok= false;
    }

    if (frm.rdSexo[0].checked==false &&
        frm.rdSexo[1].checked==false &&
        frm.rdSexo[2].checked==false)
    {
        alert("Debe ingresar un valor en Sexo.");
        Ok= false;
    }
    
    if (frm.rdRangoEdad[0].checked== false &&
        frm.rdRangoEdad[1].checked== false &&
        frm.rdRangoEdad[2].checked== false &&
        frm.rdRangoEdad[3].checked== false &&
        frm.rdRangoEdad[4].checked== false)
    {
        alert('Si la edad es desconocida debe seleccionar un rango de edad:\n\n\
            Infante, Adolescente, Menor Adulto, Adulto o Adulto Mayor.\n\n\
            Si la edad no es desconocida escriba la edad y seleccione años.');
        Ok= false;
    }

  return Ok;
}

/*
Funcion: validar datos entrada del frm denunciado
Relacion: denunciado.php
Actualizacion: 20ene2014
*/
function ValidarDenunciadoJuridico(frm){
    if (frm.txtTodosDelitos3j.value == "" || frm.txtTodosDelitos3j.value == "-1")
    {
        alert("Debe ingresar un delito");
        return false;
    }    
    
    if (frm.txtEmpresasHn3.value == "" || frm.txtEmpresasHn3.value == "-1")
    {
        alert("Debe ingresar el nombre de una empresa");
        return false;
    }
    
    return true;
//    if (frm.rdTipoDoc[0].checked)
//        frm.txtTipoDoc3.value= 'colegio';
//    if (frm.rdTipoDoc[1].checked)
//        frm.txtTipoDoc3.value= 'identidad';
//    if (frm.rdTipoDoc[2].checked)
//        frm.txtTipoDoc3.value= 'pasaporte';    
    
//    alert(frm.txtTipoDoc3.value);
//    alert(frm.cboAldea3J.value);
//    alert(frm.cboBarrio3J.value);
//    
//    return  false;
}

/************************** inicio ofendido *****************************/
/*
Funcion: validar datos entrada del frm denunciante
Relacion: denunciante.php
Actualizacion: 31may2012
*/
function ValidarOfendido(frm)
{
    //si es denuncia anonima, no validar nada y regresar falso
    if (frm.rdConocido[0].checked== true || frm.rdConocido[2].checked== true || frm.rdConocido[3].checked== true)
    {
        document.getElementById("rdSexo0").disabled= false;
        document.getElementById("rdSexo1").disabled= false;
        
        document.getElementById("apoderado").disabled= false;
        
        document.getElementById("txtNombres").disabled= false;
        document.getElementById("txtApellidos").disabled= false;
        
        document.getElementById("cboNacionalidad").disabled= false;
        document.getElementById("cboCivil").disabled= false;
        
        document.getElementById("txtIdentidad").disabled= false;
        document.getElementById("cboTipoDoc").disabled= false;
        document.getElementById("cboEscolar").disabled= false;
        
        document.getElementById("cboProfe").disabled= false;
        document.getElementById("cboOcupa").disabled= false;
        
        document.getElementById("txtEdad").disabled= false;
        document.getElementById("rdAno0").disabled= false;
        document.getElementById("rdAno1").disabled= false;
        document.getElementById("rdAno2").disabled= false;
        document.getElementById("rdAno3").disabled= false;        
        document.getElementById("rdRangoEdad0").disabled= false;
        document.getElementById("rdRangoEdad1").disabled= false;
        document.getElementById("rdRangoEdad2").disabled= false;
        document.getElementById("rdRangoEdad3").disabled= false;
        document.getElementById("rdRangoEdad4").disabled= false;
        document.getElementById("rdRangoEdad5").disabled= false;
        
        document.getElementById("cboDepto").disabled= false;
        document.getElementById("cboMuni").disabled= false;
        document.getElementById("cboAldea").disabled= false;
        document.getElementById("cboBarrio").disabled= false;
        
        document.getElementById("txtDireccion").disabled= false;
        
        document.getElementById("cboEtnia").disabled= false;
        document.getElementById("cboDiscapacidad").disabled= false;                   
        
        return true;
    }        
        
    
    Ok= true;
    CamposFaltantes="";

    if (frm.cboDepto.value== ""){
        frm.cboDepto.value= "0";
    }

    if (frm.cboMuni.value== ""){
        frm.cboMuni.value= "0";
    }
    
    if (frm.cboAldea.value== ""){
        frm.cboAldea.value= "0";
    }
    
    if (frm.cboBarrio.value== ""){
        frm.cboBarrio.value= "0";
    }
    
    //validar direccion de tal modo que no existan inconsistencias como 
    //ciudad sin depto, depto sin municipio, etc
    if (frm.cboDepto.value== "0"){
        frm.cboMuni.value= "0";
        frm.cboAldea.value= "0";
        frm.cboBarrio.value= "0";
    }else if(frm.cboMuni.value== "0"){
        frm.cboAldea.value= "0";
        frm.cboBarrio.value= "0";
    }else if (frm.cboAldea.value= "0"){
        frm.cboBarrio.value= "0";
    }    
    
    if (frm.cboNacionalidad.value== 0 || frm.cboNacionalidad.value== "")
    {
            Ok= false;
            CamposFaltantes= "Nacionalidad\n";
            frm.cboNacionalidad.value= "AA";
    }

    if (frm.cboCivil.value== "")
    {
            Ok= false;
            CamposFaltantes= CamposFaltantes + "Estado civil\n";
            frm.cboCivil.value= "0";
    }

    if (frm.cboEscolar.value== "")
    {
            Ok= false;
            CamposFaltantes= CamposFaltantes + "Escolaridad\n";
            frm.cboEscolar.value= "0";
    }

    if (frm.cboProfe.value== "")
    {
            Ok= false;
            CamposFaltantes= CamposFaltantes + "Profesión\n";
            frm.cboProfe.value= "0";
    }

    if (frm.cboOcupa.value== "")
    {
            Ok= false;
            CamposFaltantes= CamposFaltantes + "Ocupasión\n";
            frm.cboOcupa.value= "0";
    }

    if (frm.cboEtnia.value== "")
    {
            Ok= false;
            CamposFaltantes= CamposFaltantes + "Pueblo indígena\n";
            frm.cboEtnia.value= "0";
    }

    if (frm.cboDiscapacidad.value== "")
    {
            Ok= false;
            CamposFaltantes= CamposFaltantes + "Discapacidad\n";
            frm.cboDiscapacidad.value= "0";
    }

    if (Ok== false)
    {
            var Guardar= confirm ("La siguiente información hace falta, \npresione"
                       +" Cancelar para corregir\n"
                       +CamposFaltantes)
            if (Guardar== true)
            {
                    Ok= true;
            }
            else
            {
                    Ok= false;
            }
    }

    if (frm.txtIdentidad.value!= "" && frm.cboTipoDoc.value== "0")
    {
            Ok= false;
            alert("Debe ingresar un valor en tipo de documento,\n\
o borrar el número en Pasaporte o Identidad.");
            frm.cboTipoDoc.value= "0"; 
    }

    if ((frm.txtEdad.value== "0" ||
        (frm.txtEdad.value== "")) &&
        frm.rdAno[3].checked== false)
    {
        alert("Debe ingresar un valor en Edad o seleccionar Desconocida.");
        Ok= false;
    }

    if (frm.rdSexo[0].checked==false &&
        frm.rdSexo[1].checked==false &&
        frm.rdSexo[2].checked==false)
    {
        alert("Debe ingresar un valor en Sexo.");
        Ok= false;
    }
    
    if (frm.rdRangoEdad[0].checked== false &&
        frm.rdRangoEdad[1].checked== false &&
        frm.rdRangoEdad[2].checked== false &&
        frm.rdRangoEdad[3].checked== false &&
        frm.rdRangoEdad[4].checked== false &&
        frm.rdRangoEdad[5].checked== false)
    {
        alert('Si la edad es desconocida debe seleccionar un rango de edad:\n\n\
            Infante, Adolescente, Menor Adulto, Adulto,  Adulto Mayor o No consignado.\n\n\
            Si la edad no es desconocida escriba la edad y seleccione años.');
        Ok= false;
    }    

    return Ok;

}
/*
Funcion: validar si es niño, adulto, etc
Relacion: denunciante.php
Actualizacion: 02jun2012
*/
function ValidarEdadrb(msj){ 
    frm= msj.form;

    if (frm.name=="frmDenunciante"){
        prdSexo= frm.rdSexo;
        prdAno= frm.rdAno;
        prdRangoEdad= frm.rdRangoEdad; 
        prdEdad= frm.txtEdad;
    }else
        if (frm.name=="frmImputado"){ 
            prdSexo= frm.rdSexo3; 
            prdAno= frm.rdAno3; 
            prdRangoEdad= frm.rdRangoEdad3; 
            prdEdad= frm.txtEdad3;
        }else
        { 
            prdSexo= frm.rdSexo4;
            prdAno= frm.rdAno4;
            prdRangoEdad= frm.rdRangoEdad4;            
            prdEdad= frm.txtEdad4;
        }

    if (prdSexo[0].checked===false && prdSexo[1].checked===false && prdSexo[2].checked===false)
    {      
        alert("Debe seleccionar un Sexo o marcar en Desconocido");
        prdEdad.value= "";
        frm.prdAno[1].checked= true;
        return;
    }
   
    //validar dias, meses... año
    if (frm.name=="frmOfendido"){
        if (prdAno[1].checked== true && prdEdad.value >= 12) //meses
        {
            prdEdad.value= Math.round(prdEdad.value/12);
            prdAno[0].checked= true;

        }
        
        if (prdAno[2].checked== true) //dias
        {
            //menor o igual a un año
            if (prdEdad.value <= 365){
                prdRangoEdad[0].checked= true;
                return;
            }
            
            //mayor a un año se pasa a años
            prdEdad.value= Math.round(prdEdad.value/365);
            prdAno[0].checked= true;
        }
     
        if (prdAno[3].checked== true){ //desconocido para ofendido
                prdEdad.value= "";
                return;            
        }
//        alert('ofendido');
//        return;
    }
    else{ 
        if(prdAno[1].checked== true) //desconocido para denunciante e imputado
        {           
                //frm.rdAno[1].checked=true;
                prdEdad.value= "";
                return;
        }    
    }
    //*******************************************
    //desde aki infante
    //*******************************************
    //si es masculino
    if (prdEdad.value > 0 &&
        prdEdad.value < 12 &&
        prdSexo[0].checked==true
        ){ 
            prdRangoEdad[0].checked= true;
        }
    else
    //si es femenino
    if (prdEdad.value > 0 &&
        prdEdad.value < 14 &&
        prdSexo[1].checked==true){ 
            prdRangoEdad[0].checked= true; alert("fin");
        }
    else
    //*******************************************
    //desde aki adolescente
    //*******************************************
    //si es masculino
    if (prdEdad.value >= 12 &&
        prdEdad.value < 18 &&
        prdSexo[0].checked==true
        )
            prdRangoEdad[1].checked= true;
    else
    //si es femenino
    if (prdEdad.value >= 14 &&
        prdEdad.value < 18 &&
        prdSexo[1].checked==true
        )
            prdRangoEdad[1].checked= true;
    else
    //*******************************************
    //desde aki menor adulto
    //*******************************************
    //si es masculino ***
    if (prdEdad.value >= 18 &&
        prdEdad.value < 21 &&
        prdSexo[0].checked==true
        )
            prdRangoEdad[2].checked= true;
    else
    //si es femenino
    if (prdEdad.value >= 18 &&
        prdEdad.value < 21 &&
        prdSexo[1].checked==true
        )
            prdRangoEdad[2].checked= true;
    else
    //*******************************************
    //adulto
    //*******************************************
    if (prdEdad.value >= 21 &&
        prdEdad.value < 60
        )
            prdRangoEdad[3].checked= true;
    else
    //adulto mayor
    if (prdEdad.value >= 60)
        prdRangoEdad[4].checked= true;        


    //dar el foco al campo Edad
    //prdEdad.focus();        
}

/*
Funcion: validar si es niño, adulto, etc
Relacion: denunciante.php
Actualizacion: 02jun2012
*/
function ValidarRangoEdad(frm){
		r= confirm("El valor en Edad se eliminará. ¿Está de acuerdo?");
		if (r== true)
		{
                    frm.txtEdad.value= "";
                    frm.txtEdad.disabled= true;
                    
                    if (frm.name == 'frmDenunciante')
                        frm.rdAno[1].checked=true;
                        
                    if (frm.name == 'frmImputado')
                        frm.rdAno3[1].checked=true;                        
		}
}

/*
Funcion: validar si es niño, adulto, etc
Relacion: denunciante.php
Actualizacion: 02jun2012
*/
function ValidarRangoEdadOfendido(frm){
		r= confirm("El valor en Edad se eliminará. ¿Está de acuerdo?");
		if (r== true)
		{
                    frm.txtEdad.value= "";
                    frm.rdAno[3].checked=true;
		}
}

/**************************** fin denunciante ********************************/
/**************************** inicio denunciado*******************************/
/*
Funcion: validar si el denunciante es conocido, anonimo o de identidad protegida
Relacion: denunciante.php
Actualizacion: 31may2012
*/
function ValidarDesConocido(frm, valor){
    //alert(valor);
    //denunciante anonimo, no se sabrá nada de elg
    if (valor== "ano") 
    {       
        document.getElementById("rdSexo0").disabled= true;
        document.getElementById("rdSexo1").disabled= true;
        
//        document.getElementById("apoderado").disabled= true;
        
        document.getElementById("txtNombres").disabled= true;
        document.getElementById("txtApellidos").disabled= true;
        
        document.getElementById("cboNacionalidad").disabled= true;
        document.getElementById("cboCivil").disabled= true;
        
        document.getElementById("txtIdentidad").disabled= true;
        document.getElementById("cboTipoDoc").disabled= true;
        document.getElementById("cboEscolar").disabled= true;
        
        document.getElementById("cboProfe").disabled= true;
        document.getElementById("cboOcupa").disabled= true;
        
        document.getElementById("txtEdad").disabled= true;
        document.getElementById("rdAno0").disabled= true;
        document.getElementById("rdAno1").disabled= true;
        document.getElementById("rdRangoEdad0").disabled= true;
        document.getElementById("rdRangoEdad1").disabled= true;
        document.getElementById("rdRangoEdad2").disabled= true;
        document.getElementById("rdRangoEdad3").disabled= true;
        document.getElementById("rdRangoEdad4").disabled= true;
        
        document.getElementById("cboDepto").disabled= true;
        document.getElementById("cboMuni").disabled= true;
        document.getElementById("cboAldea").disabled= true;
        document.getElementById("cboBarrio").disabled= true;
        
        document.getElementById("txtDireccion").disabled= true;
        
        document.getElementById("cboEtnia").disabled= true;
        document.getElementById("cboDiscapacidad").disabled= true;
    } 
    else{
        document.getElementById("rdSexo0").disabled= false;
        document.getElementById("rdSexo1").disabled= false;
        
//        document.getElementById("apoderado").disabled= false;
        
        document.getElementById("txtNombres").disabled= false;
        document.getElementById("txtApellidos").disabled= false;
        
        document.getElementById("cboNacionalidad").disabled= false;
        document.getElementById("cboCivil").disabled= false;
        
        document.getElementById("txtIdentidad").disabled= false;
        document.getElementById("cboTipoDoc").disabled= false;
        document.getElementById("cboEscolar").disabled= false;
        
        document.getElementById("cboProfe").disabled= false;
        document.getElementById("cboOcupa").disabled= false;
        
        document.getElementById("txtEdad").disabled= false;
        document.getElementById("rdAno0").disabled= false;
        document.getElementById("rdAno1").disabled= false;
        document.getElementById("rdRangoEdad0").disabled= false;
        document.getElementById("rdRangoEdad1").disabled= false;
        document.getElementById("rdRangoEdad2").disabled= false;
        document.getElementById("rdRangoEdad3").disabled= false;
        document.getElementById("rdRangoEdad4").disabled= false;
        
        document.getElementById("cboDepto").disabled= false;
        document.getElementById("cboMuni").disabled= false;
        document.getElementById("cboAldea").disabled= false;
        document.getElementById("cboBarrio").disabled= false;
        
        document.getElementById("txtDireccion").disabled= false;
        
        document.getElementById("cboEtnia").disabled= false;
        document.getElementById("cboDiscapacidad").disabled= false;           
    }
    //alert(frm.rdConocido[2].value);
    
}

function ValidarDenunciado(frm){
//    alert(frm.cboMovil.value);
    if (frm.txtTodosDelitos3.value == "" || frm.txtTodosDelitos3.value == "-1")
    {
        alert("Debe ingresar un delito:"+frm.txtTodosDelitos3.value);
        return false;
    }

    //si es denunciado desconocido, no validar nada y regresar falso
    if (frm.rdConocido[0].checked== true)
    {    
        document.getElementById("rdSexo0").disabled= false;
        document.getElementById("rdSexo1").disabled= false;
        
        //document.getElementById("apoderado").disabled= false;
        
        document.getElementById("txtNombres").disabled= false;
        document.getElementById("txtApellidos").disabled= false;
        
        document.getElementById("cboNacionalidad3").disabled= false;
        document.getElementById("cboCivil3").disabled= false;
        
        document.getElementById("txtIdentidad3").disabled= false;
        document.getElementById("cboTipoDoc3").disabled= false;
        document.getElementById("cboEscolar3").disabled= false;
        
        document.getElementById("cboProfe3").disabled= false;
        document.getElementById("cboOcupa3").disabled= false;
        
        document.getElementById("txtEdad3").disabled= false; 
        document.getElementById("rdAno30").disabled= false; 
        document.getElementById("rdAno31").disabled= false;  
        document.getElementById("rdRangoEdad30").disabled= false;
        document.getElementById("rdRangoEdad31").disabled= false;
        document.getElementById("rdRangoEdad32").disabled= false;
        document.getElementById("rdRangoEdad33").disabled= false;
        document.getElementById("rdRangoEdad34").disabled= false;
        document.getElementById("rdRangoEdad35").disabled= false;
       
        document.getElementById("cboDepto3").disabled= false;
        document.getElementById("cboMuni3").disabled= false;
        document.getElementById("cboAldea3").disabled= false;
        document.getElementById("cboBarrio3").disabled= false;
     
        document.getElementById("txtDireccion3").disabled= false;
        
        document.getElementById("cboEtnia3").disabled= false;
        document.getElementById("cboDiscapacidad3").disabled= false;             
        
        return true;
    }
    
    Ok= true;
    CamposFaltantes="";

    if (frm.cboDepto3.value== ""){
        frm.cboDepto3.value= "0";
    }

    if (frm.cboMuni3.value== ""){
        frm.cboMuni3.value= "0";
    }
    
    if (frm.cboAldea3.value== ""){
        frm.cboAldea3.value= "0";
    }
    
    if (frm.cboBarrio3.value== ""){
        frm.cboBarrio3.value= "0";
    }

    //validar direccion de tal modo que no existan inconsistencias como 
    //ciudad sin depto, depto sin municipio, etc
    if (frm.cboDepto3.value== "0"){
        frm.cboMuni3.value= "0";
        frm.cboAldea3.value= "0";
        frm.cboBarrio3.value= "0";
    }else if(frm.cboMuni3.value== "0"){
        frm.cboAldea3.value= "0";
        frm.cboBarrio3.value= "0";
    }else if (frm.cboAldea3.value== "0"){
        frm.cboBarrio3.value= "0";
    }

    if (frm.cboNacionalidad3.value== 0 || frm.cboNacionalidad3.value== "")
    {
            Ok= false;
            CamposFaltantes= "Nacionalidad\n";
            frm.cboNacionalidad3.value= "AA";
    }

    if (frm.cboCivil3.value== "")
    {
            Ok= false;
            CamposFaltantes= CamposFaltantes + "Estado civil\n";
            frm.cboCivil3.value= "0";
    }

    if (frm.cboEscolar3.value== "")
    {
            Ok= false;
            CamposFaltantes= CamposFaltantes + "Escolaridad\n";
            frm.cboEscolar3.value= "0";
    }

    if (frm.cboProfe3.value== "")
    {
            Ok= false;
            CamposFaltantes= CamposFaltantes + "Profesión\n";
            frm.cboProfe3.value= "0";
    }

    if (frm.cboOcupa3.value== "")
    {
            Ok= false;
            CamposFaltantes= CamposFaltantes + "Ocupasión\n";
            frm.cboOcupa3.value= "0";
    }

    if (frm.cboEtnia3.value== "")
    {
            Ok= false;
            CamposFaltantes= CamposFaltantes + "Pueblo indígena\n";
            frm.cboEtnia3.value= "0";
    }

    if (frm.cboDiscapacidad3.value== "")
    {
            Ok= false;
            CamposFaltantes= CamposFaltantes + "Discapacidad\n";
            frm.cboDiscapacidad3.value= "0";
    }

    if (Ok== false)
    {
            var Guardar= confirm ("La siguiente información hace falta, \npresione"
                       +" Cancelar para corregir\n"
                       +CamposFaltantes)
            if (Guardar== true)
            {
                    Ok= true;
            }
            else
            {
                    Ok= false;
            }
    }

    if (frm.txtIdentidad3.value!= "" && frm.cboTipoDoc3.value== "0")
    {
            Ok= false;
            alert("Debe ingresar un valor en tipo de documento,\n\
    o borrar el número en Pasaporte o Identidad.");
            frm.cboTipoDoc3.value= "0"; 
    }        

    if ((frm.txtEdad3.value== "0" ||
        (frm.txtEdad3.value== "")) &&
        frm.rdAno3[1].checked== false)
    {
        alert("Debe ingresar un valor en Edad o seleccionar Desconocida.");
        Ok= false;
    }

    if (frm.rdSexo3[0].checked==false &&
        frm.rdSexo3[1].checked==false &&
        frm.rdSexo3[2].checked==false)
    {
        alert("Debe ingresar un valor en Genero.");
        Ok= false;
    }

    if (frm.rdRangoEdad3[0].checked== false &&
        frm.rdRangoEdad3[1].checked== false &&
        frm.rdRangoEdad3[2].checked== false &&
        frm.rdRangoEdad3[3].checked== false &&
        frm.rdRangoEdad3[4].checked== false &&
        frm.rdRangoEdad3[5].checked== false)
    {
        alert('Si la edad es desconocida debe seleccionar un rango de edad:\n\n\
            Infante, Adolescente, Menor Adulto, Adulto o Adulto Mayor.\n\n\
            Si la edad no es desconocida escriba la edad y seleccione años.');
        Ok= false;
    }

    return Ok;
//return false;
}

function ValidarDenuncianteJuridico(frm){
    frm.DenuncianteJur= 'juridico';
    Ok= false;
    if (frm.rdTipoDoc[0].checked== true){ //numero de colegiado, no más de 5
        if (frm.txtColegioJ.length > 5){
            alert("El número de colegiado no pude ser mayor a cinco dígitos");
            return false;
        }        
    }
    if (frm.txtEmpresasHn.value == "" || frm.txtEmpresasHn.value == "-1")
    {
        alert("Debe ingresar el nombre de una empresa");
        return false;
    }    
    
    return true;
}

/*************************** fin denunciado o imputado ***********************/
/*
Funcion: agregar parentesco
*/
function xyz(msg)
{
	alert(msg);
        
        return true;
}

/*
Funcion: validar datos unicamente numeros
Relacion: denunciante.php
Actualizacion: 30may2012
*/
function ValidarNumeros(e) { 
/*
patron = /\d/; // Solo acepta n�meros
patron = /\w/; // Acepta n�meros y letras
patron = /\D/; // No acepta n�meros
patron =/[A-Za-z��\s]/; // igual que el ejemplo, pero acepta tambi�n las letras
patron = /[ajt69]/; solo estos
*/    
} 


//retornar fecha ANSI
//recibe cadena representando fecha mm/dd/aaaa
function FechaANSI(Fecha){
    mes= Fecha.substring(0,2);
    dia= Fecha.substring(3,5);
    anio= Fecha.substring(6,11);

    return anio+mes+dia;
}

/*
funcion de prueba
*/
function prueba(msg)
{
	alert(msg);
        
        return true;
}
