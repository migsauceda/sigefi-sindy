/*variables globales
 */


/*
Funcion: llenar los combos
Relacion: generales.php
Actualizacion: 12abr2012
*/
function llena_muni(iddepto,iddestino,tddestino,op,clearAldea,clearBarrio){//llenado del select d municipios    
    $('#'+clearAldea).val("0")// se resetea el campos de Aldea
    $('#'+clearBarrio).val("0")// se resetea el campos de Barrio
    var valor = $("#"+iddepto).val();// valor de depto
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

function llena_aldea(iddepto,idmuni,iddestino,tddestino,op,clearBarrio){// llenado del select aldeas
    $('#'+clearBarrio).val("0")// se resetea el campos de Barrio
    var depto = $("#"+iddepto).val();// valor de depto
    var municipio=$("#"+idmuni).val();// valor de municipio
//    alert(iddestino+" "+tddestino+" "+op);
    $.ajax({
        data: "iddestino="+iddestino+"&idorigen_depto="+depto+"&idorigen_muni="+municipio+"&op="+op,
        type: "POST",
        dataType: "html",
        url: "../funciones/ajax_aldea.php",
        error: function(objeto, quepaso, otroobj){
            alert("Error al cargar Municipio: "+quepaso);
        },
        success: function(data){
            $("#"+tddestino).html(data);
        }    
    });
}

function llena_barrio(iddepto,idmuni,idaldea,iddestino,tddestino,op){ //Llenado del select de barrios
    var depto = $("#"+iddepto).val();// valor de depto
    var municipio=$("#"+idmuni).val();// valor de municipio
    var aldea=$("#"+idaldea).val();// valor de aldea o Ciudad
    //alert(depto+","+municipio+","+aldea+","+iddestino+","+tddestino+","+op);

    $.ajax({
        data: "iddestino="+iddestino+"&idorigen_depto="+depto+"&idorigen_muni="+municipio+"&idorigen_aldea="+aldea+"&op="+op,
        type: "POST",
        dataType: "html",
        url: "../funciones/ajax_barrio.php",
        error: function(objeto, quepaso, otroobj){
            alert("Error al cargar Municipio: "+quepaso);
        },
        success: function(data){
            $("#"+tddestino).html(data);
        }    
    });
}

/*
Funcion: llenar combo de orientacion sexual
Relacion: denunciante.php, denunciado.php
Actualizacion: 10jun2012
*/
function llenarsexo(destino, sex, frm, valor){
//    alert(destino +  sex + frm+":"+valor);

    //valor por defecto
    valor = (typeof valor == 'undefined') ? 'x': valor ;
    $.ajax({
        data: "id="+destino+"&sexo="+sex,
        type: "POST",
        dataType: "html",
        url: "../funciones/ajax_OrientacionSexual.php",
        error: function(obj, que, otro){
            alert("Error ajax al cargar orientacion sex "+que);
        },
        success: function(data){
            frm.txtEdad.disabled= false;
            frm.rdAno.disabled= false;            
            $("#sexo").html(data);
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
{
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
    //alert("entra a validar gnerales javascript");
    /*valores para las direcciones*/
//    if (frm.cboBarrio2.selectedIndex== -1)
//    {      
//        if (frm.cboAldea2.selectedIndex > 0)
//            frm.txtDireccionHecho.value=   "Indefinido," + 
//                frm.cboAldea2.options[frm.cboAldea2.selectedIndex].text + ", ";
//            
//        if (frm.cboMuni2.selectedIndex > 0)
//            frm.txtDireccionHecho.value= frm.txtDireccionHecho.value +
//                frm.cboMuni2.options[frm.cboMuni2.selectedIndex].text + ", ";
//            
//        if (frm.cboDepto2.selectedIndex > 0)
//            frm.txtDireccionHecho.value= frm.txtDireccionHecho.value +
//                frm.cboDepto2.options[frm.cboDepto2.selectedIndex].text;
//    }
//    else
//    {         
//        if (frm.cboBarrio2.selectedindex > 0)
//            frm.txtDireccionHecho.value= 
//                frm.cboBarrio2.options[frm.cboBarrio2.selectedIndex].text + ", ";
//            
//        if (frm.cboAldea2.selectedIndex > 0)
//            frm.txtDireccionHecho.value=   
//                frm.cboAldea2.options[frm.cboAldea2.selectedIndex].text + ", ";
//            
//        if (frm.cboMuni2.selectedIndex > 0)
//            frm.txtDireccionHecho.value= frm.txtDireccionHecho.value +
//                frm.cboMuni2.options[frm.cboMuni2.selectedIndex].text + ", ";
//            
//        if (frm.cboDepto2.selectedIndex > 0)
//            frm.txtDireccionHecho.value= frm.txtDireccionHecho.value +
//                frm.cboDepto2.options[frm.cboDepto2.selectedIndex].text;
//    }

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
//alert("sale de validar");

    return true;
}
/*************************** Inicia Denunciante ********************************/
/*
Funcion: validar si el denunciante es conocido, anonimo o de identidad protegida
Relacion: denunciante.php
Actualizacion: 31may2012
*/
function ValidarConocido(frm, valor){ 
    //denunciante anonimo, no se sabrá nada de elg
    if (valor== "ano" || valor== "ofi") 
    {       
        if (valor== "ano"){
            document.getElementById("txtNombres").value= "-- ANÓNIMO --";
            document.getElementById("txtApellidos").value= "-- ANÓNIMO --";  
        } else
        {
            document.getElementById("txtNombres").value= "-- OFICIO --";
            document.getElementById("txtApellidos").value= "-- OFICIO --"; 
        }
        
        document.getElementById("rdSexo1").disabled= true;
        document.getElementById("rdSexo0").disabled= true;
        
        document.getElementById("apoderado").disabled= true;
        
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

/*
Funcion: validar datos entrada del frm denunciante
Relacion: denunciante.php
Actualizacion: 31may2012
*/
function ValidarDenunciante(frm)
{
    //si es denuncia anonima, no validar nada y regresar true
    if (frm.rdConocido[0].checked== true || frm.rdConocido[3].checked== true)
        return true;

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
    
//alert("validar denucnante.");
    return Ok;

}

/*
Funcion: validar datos entrada del frm denunciado
Relacion: denunciado.php
Actualizacion: 20ene2014
*/
function ValidarDenunciadoJuridico(frm){
    
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
    if (frm.rdConocido[0].checked== true)
        return true;
    
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
        frm.rdRangoEdad[4].checked== false)
    {
        alert('Si la edad es desconocida debe seleccionar un rango de edad:\n\n\
            Infante, Adolescente, Menor Adulto, Adulto o Adulto Mayor.\n\n\
            Si la edad no es desconocida escriba la edad y seleccione años.');
        Ok= false;
    }
    
//alert("validar denucnante.");
    return Ok;

}
/*
Funcion: validar si es niño, adulto, etc
Relacion: denunciante.php
Actualizacion: 02jun2012
*/
function ValidarEdadrb(msj){
    frm= msj.form;
    if (frm.rdSexo[0].checked===false && frm.rdSexo[1].checked===false && frm.rdSexo[2].checked===false)
    {      
        alert("Debe seleccionar un Sexo o marcar en Desconocido");
        frm.txtEdad.value= "";
        frm.rdAno[1].checked= true;
        return;
    }
    
    //validar dias, meses... año
    if (frm.name=="frmOfendido"){
        if (frm.rdAno[1].checked== true && frm.txtEdad.value >= 12) //meses
        {
            frm.txtEdad.value= Math.round(frm.txtEdad.value/12);
            frm.rdAno[0].checked= true;

        }
        
        if (frm.rdAno[2].checked== true) //dias
        {
            //menor o igual a un año
            if (frm.txtEdad.value <= 365){
                frm.rdRangoEdad[0].checked= true;
                return;
            }
            
            //mayor a un año se pasa a años
            frm.txtEdad.value= Math.round(frm.txtEdad.value/365);
            frm.rdAno[0].checked= true;
        }
     
        if (frm.rdAno[3].checked== true){ //desconocido para ofendido
                frm.txtEdad.value= "";
                return;            
        }
//        alert('ofendido');
//        return;
    }
    else{
        if(frm.rdAno[1].checked== true) //desconocido para denunciante e imputado
        {           
                //frm.rdAno[1].checked=true;
                frm.txtEdad.value= "";
                return;
        }    
    }
    
    
    //*******************************************
    //desde aki infante
    //*******************************************
    //si es masculino
    if (frm.txtEdad.value > 0 &&
        frm.txtEdad.value < 12 &&
        frm.rdSexo[0].checked==true
        ){
            frm.rdRangoEdad[0].checked= true;
        }
    else
    //si es femenino
    if (frm.txtEdad.value > 0 &&
        frm.txtEdad.value < 14 &&
        frm.rdSexo[1].checked==true){                        
            frm.rdRangoEdad[0].checked= true;
        }
    else
    //*******************************************
    //desde aki adolescente
    //*******************************************
    //si es masculino
    if (frm.txtEdad.value >= 12 &&
        frm.txtEdad.value < 18 &&
        frm.rdSexo[0].checked==true
        )
            frm.rdRangoEdad[1].checked= true;
    else
    //si es femenino
    if (frm.txtEdad.value >= 14 &&
        frm.txtEdad.value < 18 &&
        frm.rdSexo[1].checked==true
        )
            frm.rdRangoEdad[1].checked= true;
    else
    //*******************************************
    //desde aki menor adulto
    //*******************************************
    //si es masculino ***
    if (frm.txtEdad.value >= 18 &&
        frm.txtEdad.value < 21 &&
        frm.rdSexo[0].checked==true
        )
            frm.rdRangoEdad[2].checked= true;
    else
    //si es femenino
    if (frm.txtEdad.value >= 18 &&
        frm.txtEdad.value < 21 &&
        frm.rdSexo[1].checked==true
        )
            frm.rdRangoEdad[2].checked= true;
    else
    //*******************************************
    //adulto
    //*******************************************
    if (frm.txtEdad.value >= 21 &&
        frm.txtEdad.value < 60
        )
            frm.rdRangoEdad[3].checked= true;
    else
    //adulto mayor
    if (frm.txtEdad.value >= 60)
        frm.rdRangoEdad[4].checked= true;        
    

    //dar el foco al campo Edad
    //frm.txtEdad.focus();        
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
                    frm.rdAno[1].checked=true;
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
    //si es denunciado desconocido, no validar nada y regresar falso
    if (frm.rdConocido[0].checked== true)
        return true;
    
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
        frm.rdRangoEdad[4].checked== false)
    {
        alert('Si la edad es desconocida debe seleccionar un rango de edad:\n\n\
            Infante, Adolescente, Menor Adulto, Adulto o Adulto Mayor.\n\n\
            Si la edad no es desconocida escriba la edad y seleccione años.');
        Ok= false;
    }

    if (frm.txtTodosDelitos.value == "")
    {
        alert("Debe ingresar un delito");
        Ok= false;
    }
    return Ok;

}

function ValidarDenuncianteJuridico(frm){
    frm.DenuncianteJur= 'juridico';
    if (frm.rdTipoDoc[0].checked== true){ //numero de colegiado, no más de 5
        if (frm.txtColegioJ.length > 5){
            alert("El número de colegiado no pude ser mayor a cinco dígitos");
            Ok= false;
        }
    }
    
    return Ok;
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
