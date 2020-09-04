$(document).ready(function(){

    var serverUrl='http://172.17.0.254/sigefi/Ministerio_PublicoJQCambios/backend/api/?_url=/';

getalldelitos('delito');





$('body').on('click','.buscarvaciado',function(e){
  
    var delito=$('#delito').val();
    var fechainicio= $('#fecha_inicial_v').val();
    var fechafinal= $('#fecha_final_v').val();

    if(typeof(fechainicio)=='undefined' || fechainicio=='' || typeof(fechafinal)=='undefined' || fechafinal=='' ){
      
             getallvaciardenucia('vaciadodenuncia',delito);
			
            
       }
       else{
           if(fechainicio<fechafinal){
               getallvaciardenuciafechas('vaciadodenunciafecha',delito,fechainicio,fechafinal);
			  


           }
           else{
             //  alert('Fecha de inicio debe ser menor qu la final');
               Aviso('Fecha de inicio debe ser menor que la final');

           }


       }


 });



getalldepartamentosvaciado('deptospais');

$('body').on('change','.deptovaciado',function(e){
  var id=$(".deptovaciado" ).val();
  //alert(id);
    getallmunicipiosvaciado('municipios',id);
     // alert($('#cmunicipiodenuncia').val());
    
});


$('body').on('click','.myButtonId',function (e) {
   // alert();
       // exportTable($('#VaciadoDenunciaT').html(), 'myFilename.xls');
      /*  var table = $("#VaciadoDenunciaT" + $(this).data('target'));
        window.open('data:application/vnd.ms-excel,' + $(table).html());
e.preventDefault();*/

     window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#dvData').html()));
        e.preventDefault();
});

$('body').on('change','.municipiovaciado',function(e){
  var id=$(".municipiovaciado" ).val();
  //alert(id);
    getallaldeasvaciado('aldeas',id);
     // alert($('#cmunicipiodenuncia').val());
    
});


 


function getallvaciardenucia(api,delito){

    if(typeof(delito)=='undefined' || delito==-1){
        Aviso('Debe seleccionar una opción válida');

    }
    else{
        
$.getJSON(serverUrl+api+'/'+delito, function(data) {
    //alert(response.resdato);
    if(data.status==200){
        $('#VaciadoDenunciaT').dataTable({
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5'
            ],
            processing: true,
            bDestroy: true,
            data: data.resdato,
            aoColumns: [
            { data: "tdenunciaid"},
            { data: "fechadenuncia"},
            { data: "thoradenuncia"},
            { data: "nombrediahecho"},
            { data: "numerodiahecho"},
            { data: "nombremeshecho"},
            { data: "aniohecho"},
            { data: "thorahecho"},
             { data: "rango"},
            { data: "lugarhecho"},
            { data: "delitodescripcion"},
            { data: "narracionhecho"},
            { data: "deptohecho"},
            { data: "municipiohecho"},
            { data: "aldeahecho"},
            { data: "nombreofendido"},
            { data: "edadofendido"},
            { data: "direccionofendido"},
            { data: "sexoofendido"},
            { data: "generoofendido"},
            { data: "profesionofendido"},
            { data: "ocupacionofendido"},
            { data: "escolaridadofendido"},
            { data: "nacionalidadofendido"},
            { data: "etniafendido"},
            { data: "discapacidadofendido"},
            { data: "estadocivilofendido"},
            { data: "cantidadhijosofendido"},
            { data: "embarazoofendido"},

            { data: "frecuanciaagresionofendido"},
            { data: "trabajoremunerado"},
            { data: "estudiaofendido"},
            { data: "intentossucicidioofendido"},
            { data: "enfermedadmentalofendido"},
            { data: "mecanismomuerteofendido"},
            { data: "nombredenunciante"},
            { data: "etniaodenunciante"},
            { data: "profesiondenunciante"},
            { data: "ocupaciondenunciante"},
            { data: "escolaridaddenunciante"},
            { data: "nacionalidaddenunciante"},
            { data: "etniadenunciante"},
            { data: "discapacidaddenunciante"},
            { data: "estadocivildenunciante"},
            { data: "bandejarecepcion"},
            { data: "expedientesedi"},
            { data: "expedientejudicial"},
            { data: "expedientepolicial"},
            { data: "levantamiento"},
            { data: "transito"},
            { data: "autopsia"},
            { data: "nombreimputado"},
            { data: "etniaoimputado"},
            { data: "profesionimputado"},
            { data: "ocupacionimputado"},
            { data: "escolaridadimputado"},
            { data: "nacionalidadimputado"},
            { data: "etniaimputado"},
            { data: "discapacidadimputado"},
            { data: "estadocivilimputado"}


            ]
        });
        }
        //window.someGlobalOrWhatever = response.balance
        })
        .error(function(err) {
            error();
        })


    }
  
   
}

function getallvaciardenuciafechas(api,delito,fechainicio,fechafinal){

    if(typeof(delito)=='undefined' || delito==-1){
        Aviso('Debe seleccionar una opción válida');

    }
    else{
         $.getJSON(serverUrl+api+'/'+delito+'/'+fechainicio+'/'+fechafinal, function(data,status) {
          if(data.status==200){
                $('#VaciadoDenunciaT').dataTable({
                    dom: 'Bfrtip',
                    buttons: [

                    'excelHtml5'
                    ],
                        processing: true,
                        bDestroy: true,
                        data: data.resdato,
                       aoColumns: [
            { data: "tdenunciaid"},
            { data: "fechadenuncia"},
            { data: "thoradenuncia"},
            { data: "nombrediahecho"},
            { data: "numerodiahecho"},
            { data: "nombremeshecho"},
            { data: "aniohecho"},
            { data: "thorahecho"},
             { data: "rango"},
            { data: "lugarhecho"},
            { data: "delitodescripcion"},
            { data: "narracionhecho"},
            { data: "deptohecho"},
            { data: "municipiohecho"},
            { data: "aldeahecho"},
            { data: "nombreofendido"},
            { data: "edadofendido"},
            { data: "direccionofendido"},
            { data: "sexoofendido"},
            { data: "generoofendido"},
            { data: "profesionofendido"},
            { data: "ocupacionofendido"},
            { data: "escolaridadofendido"},
            { data: "nacionalidadofendido"},
            { data: "etniafendido"},
            { data: "discapacidadofendido"},
            { data: "estadocivilofendido"},
            { data: "cantidadhijosofendido"},
            { data: "embarazoofendido"},

            { data: "frecuanciaagresionofendido"},
            { data: "trabajoremunerado"},
            { data: "estudiaofendido"},
            { data: "intentossucicidioofendido"},
            { data: "enfermedadmentalofendido"},
            { data: "mecanismomuerteofendido"},
            { data: "nombredenunciante"},
            { data: "etniaodenunciante"},
            { data: "profesiondenunciante"},
            { data: "ocupaciondenunciante"},
            { data: "escolaridaddenunciante"},
            { data: "nacionalidaddenunciante"},
            { data: "etniadenunciante"},
            { data: "discapacidaddenunciante"},
            { data: "estadocivildenunciante"},
            { data: "bandejarecepcion"},
            { data: "expedientesedi"},
            { data: "expedientejudicial"},
            { data: "expedientepolicial"},
            { data: "levantamiento"},
            { data: "transito"},
            { data: "autopsia"},
            { data: "nombreimputado"},
            { data: "etniaoimputado"},
            { data: "profesionimputado"},
            { data: "ocupacionimputado"},
            { data: "escolaridadimputado"},
            { data: "nacionalidadimputado"},
            { data: "etniaimputado"},
            { data: "discapacidadimputado"},
            { data: "estadocivilimputado"}


            ]
                    });
        }
            
        })
        .error(function(err) {
            error();
        })


    }
    
   
}

function getalldepartamentosvaciado(api){

    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){
     
                    $.each(data.resdato, function( key, val ) {
                        
                        //$('#cdeptodenuncia2').append('<option  id="'+val.cdepartamentoid+'"  value="'+val.cdepartamentoid +'">'+ val.cdescripcion+'</option>');
                       $('#deptovaciado').append('<option  id="'+val.cdepartamentoid+'"  value="'+val.cdepartamentoid +'">'+ val.cdescripcion.toLowerCase()+'</option>');

             });
            }
        })
        .error(function(data,status,err) {
            //alert(data.status);
            error();
        })
}

function getallmunicipiosvaciado(api,depto){
    //alert(depto);
    if(typeof(depto)=='undefined' || depto==-1){
        Aviso('No tiene elementos asignados');
         $('#municipiovaciado').html('');
         $('#municipiovaciado').append('<option value="-1">--Seleccionar-- </option>');
    }
    else{
           $.getJSON(serverUrl+api+'/'+depto, function(data,status) {
            if(data.status==200){
                $('#municipiovaciado').html('');
				 $('#aldeavaciado').html('');
				$('#aldeavaciado').append('<option value="-1">--Seleccionar--</option>');
                $('#municipiovaciado').append('<option value="-1">--Seleccionar--</option>');
                    $.each(data.resdato, function( key, val ) {
                        $('#municipiovaciado').append('<option  id="'+val.cmunicipioid+'" value="'+ val.cmunicipioid+'">'+ val.cdescripcion+'</option>');
                });
            }
        })
        .error(function(err) {
            error();
        })

    }
 
}

function getallaldeasvaciado(api,municipio){
    //alert(municipio);

    if(typeof(municipio)=='undefined' || municipio==-1){
        $('#aldeavaciado').html('');
        $('#aldeavaciado').append('<option value="-1">--Seleccionar-- </option>');

    }
    else{
            $.getJSON(serverUrl+api+'/'+municipio, function(data,status) {
            if(data.status==200){
                $('#aldeavaciado').html('');
                $('#aldeavaciado').append('<option value="-1">--Seleccionar--</option>');
                    $.each(data.resdato, function( key, val ) {
                        $('#aldeavaciado').append('<option  id="'+val.caldeaid+'" value="'+ val.caldeaid+'">'+ val.cdescripcion+'</option>');
                });
            }
        })
        .error(function(err) {
            error();
        })

    }

}

function getalldelitos(api){
    //alert(municipio);

    /*if(typeof(municipio)=='undefined' || municipio==-1){
        $('#caldea').html('');
        $('#caldea').append('<option value="-1">--Seleccionar-- </option>');

    }
    else{*/
        $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){
                $('#delito').html('');
                $('#delito').append('<option value="-1">--Seleccionar--</option>');
                    $.each(data.resdato, function( key, val ) {
                        $('#delito').append('<option  id="'+val.ndelitoid+'" value="'+ val.ndelitoid+'">'+ val.cdescripcion+'</option>');
                });
            }
        })
        .error(function(err) {
            error();
        })

   // }

}
/*function getallconfirmacondenunciaNombre(api,nombre){
    
    $.getJSON(serverUrl+api+'/'+nombre, function(data,status) {
            if(data.status==200){
                $('#tablevaciado').html('');
                    $.each(data.resdato, function( key, val ) {
                        $('#tablevaciado').append('<tr>'+
                                        '<td>'+ val.tdenunciaid+'</td>'+
                                        '<td>'+ val.tpersonaid+'</td>'+
                                        '<td>'+ val.cnombres+'</td>'+
                                        '<td>'+ val.crtn+'</td>'+
                                        '<td>'+val.ndelito+'</td>'+
                                        '<td>'+ val.nfiscaliaid+'</td>'+
                                        '<td>'+ val.timputadoid+'</td>'+
                                        '<td>'+ val.dfechaasignacion+'</td>'+
                                        '<td>'+val.basignadafiscalia+'</td>'+
                                        '<td>'+ val.cexpedientesedi+'</td>'+
                                        '<td>'+val.bandeja+'</td>'+
                                        '<td>'+val.sub_bandeja+'</td></tr>');
                });
            }
           
           
        })
        .error(function(err) {
            error();
        })
}*/




function successok(action){
  $("<div></div>").html('Se Guardo Correctamente').dialog({
        title: 'Se Realizó Correctamente',
        resizable: false,
        modal: true,
        buttons: {
            "Ok": function() 
            {
                $( this ).dialog( "close" );
            }
        }
    });

}

function error(err){
    $("<div></div>").html('ha ocurrido un error'+err).dialog({
        title: 'Ocurrió un Error',
        resizable: false,
        modal: true,
        buttons: {
            "Ok": function() 
            {
                $( this ).dialog( "close" );
            }
        }
    });
 
}

function Aviso(texto){
    $("<div></div>").html(texto).dialog({
        title: 'Aviso',
        resizable: false,
    
        modal: true,
        buttons: {
            "Aceptar": function() 
            {
                $( this ).dialog( "close" );
            }
        }
    });
}



    function exportTable(myTable, filename) {
            //IE
            if (isIE()) {
                csvData = myTable;
                if (window.navigator.msSaveBlob) {
                    var blob = new Blob([csvData], {
                        type: "text/html"
                    });
                    navigator.msSaveBlob(blob, filename);
                }
            } //other browser
            else {
                window.open("data:application/vnd.ms-excel," + encodeURIComponent(myTable));
            }}
           
      


})
