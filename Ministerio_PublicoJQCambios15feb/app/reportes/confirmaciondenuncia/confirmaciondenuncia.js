


$(document).ready(function(){

    var serverUrl='http://172.17.0.254/sigefi/Ministerio_PublicoJQCambios/backend/api/?_url=/';



$('body').on('click','.buscar_confirmacion',function(e){
    var nombre=$('#nombre').val();
   // alert(nombre);
    if(typeof(nombre)=='undefined' || nombre==''){
       // getallconfirmacondenuncia('confirmaciondenuncia');
       Aviso('Debe ingresar un nombre para realizar la busqueda');
         
    }
    else{
        getallconfirmacondenunciaNombre('confirmaciondenuncia',nombre);  
    }
  
    
 });



function getallconfirmacondenuncia(api){
    

    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){

                  $('#Confirmaciondenunciat').dataTable({
                        processing: true,
                        bDestroy: true,
                        data: data.resdato,
                        aoColumns: [
                        { data: "tdenunciaid"},
                        { data: "tpersonaid"},
                        { data: "cnombres"},
                        { data: "crtn"},
                        { data: "nombredelito"},
                        { data: "dfechaasignacion"},
                        { data: "basignadafiscalia"},
                        { data: "cexpedientesedi"},
                        { data: "bandeja"},
                        { data: "subbandeja"}
                        ]
                    });

                /*$('#tableresultado').html('');
                    $.each(data.resdato, function( key, val ) {
                        // '<td>'+ val.nfiscaliaid+'</td>'+
                        // '<td>'+ val.timputadoid+'</td>'+
                        $('#tableresultado').append('<tr>'+
                                        '<td>'+ val.tdenunciaid+'</td>'+
                                        '<td>'+ val.tpersonaid+'</td>'+
                                        '<td>'+ val.cnombres+'</td>'+
                                        '<td>'+ val.crtn+'</td>'+
                                        '<td>'+val.nombredelito+'</td>'+
                                       
                                       
                                        '<td>'+ val.dfechaasignacion+'</td>'+
                                        '<td>'+val.basignadafiscalia+'</td>'+
                                        '<td>'+ val.cexpedientesedi+'</td>'+
                                        '<td>'+val.bandeja+'</td>'+
                                        '<td>'+val.subbandeja+'</td></tr>');
                });
                $('#Confirmaciondenunciat').DataTable();*/
            }
            
        })
        .error(function(err) {
            error();
        })
}

function getallconfirmacondenunciaNombre(api,nombre){
    
    $.getJSON(serverUrl+api+'/'+nombre, function(data,status) {
        //'<td>'+ val.nfiscaliaid+'</td>'+
        //'<td>'+ val.timputadoid+'</td>'+
            if(data.status==200){

                 $('#Confirmaciondenunciat').dataTable({
                        processing: true,
                        bDestroy: true,
                        data: data.resdato,
                        aoColumns: [
                        { data: "tdenunciaid"},
                        { data: "tpersonaid"},
                        { data: "cnombres"},
                        { data: "crtn"},
                        { data: "nombredelito"},
                        { data: "dfechaasignacion"},
                        { data: "basignadafiscalia"},
                        { data: "cexpedientesedi"},
                        { data: "bandeja"},
                        { data: "subbandeja"}
                        ]
                    });

               /* $('#tableresultado').html('');
                    $.each(data.resdato, function( key, val ) {
                        $('#tableresultado').append('<tr>'+
                                        '<td>'+ val.tdenunciaid+'</td>'+
                                        '<td>'+ val.tpersonaid+'</td>'+
                                        '<td>'+ val.cnombres+'</td>'+
                                        '<td>'+ val.crtn+'</td>'+
                                        '<td>'+val.nombredelito+'</td>'+
                                        
                                        
                                        '<td>'+ val.dfechaasignacion+'</td>'+
                                        '<td>'+val.basignadafiscalia+'</td>'+
                                        '<td>'+ val.cexpedientesedi+'</td>'+
                                        '<td>'+val.bandeja+'</td>'+
                                        '<td>'+val.subbandeja+'</td></tr>');
                });
    $('#Confirmaciondenunciat').DataTable();*/
            }
             
        })
        .error(function(err) {
            error();
        })
}





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






})

