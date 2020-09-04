
$(document).ready(function(){

    var serverUrl='http://172.17.0.254/sigefi/Ministerio_PublicoJQCambios/backend/api/?_url=/';


getallusuario('confirmaciondenunciajefe','CRodriguez');



$('body').on('click','.buscar_gestionfiscal',function(e){
       var idusuario=$('#idusuariogestion').val();
      // alert(idusuario);
       var fechainicio=$('#fecha_inicial_g').val();
       var fechafinal=$('#fecha_final_g').val();

       if(typeof(fechainicio)=='undefined' || fechainicio=='' || typeof(fechafinal)=='undefined' || fechafinal=='' ){
      
             getallgestionfiscal('vaciadogestionfiscal',idusuario);
       }
       else{
           if(fechainicio<fechafinal){
               getallgestionF('vaciadogestionfiscalfechas',idusuario,fechainicio,fechafinal);


           }
           else{
             //  alert('Fecha de inicio debe ser menor qu la final');
               Aviso('Fecha de inicio debe ser menor que la final');

           }


       }
    
 });



function getallusuario(api,user){
     
    $.getJSON(serverUrl+api+'/'+user, function(data,status) {
            if(data.status==200){

                    $.each(data.resdato, function( key, val ) {
                        $('#idusuariogestion').append('<option  id="'+val.usuario+'"  value="'+val.usuario +'">'+ val.nombres+'</option>');
                });
            }
        })
        .error(function(data,status,err) {
            //alert(data.status);
            error(err);
        })
}




function getallgestionfiscal(api,idusuario){
    
    $.getJSON(serverUrl+api+'/'+idusuario, function(data,status) {
            if(data.status==200){

                  $('#vaciadogestionfiscalTB').dataTable({
                       dom: 'Bfrtip',
                        buttons: [
                            'excelHtml5'
                        ],
                        processing: true,
                        bDestroy: true,
                        data: data.resdato,
                         aoColumns: [
                             { data: "nrodenuncia"},
                             { data: "fechadenuncia"},
                             { data: "horagestion"},
                             { data: "fiscalia"},
                             { data: "unidad"},
                             { data: "etapa"},                        
                             { data: "subetapa"}, 
                             { data: "gestionresolucion"}, 
                             { data: "nombreimputado"}                 
                        ]
                    });


               /* $('#tablaresjefe').html('');
                    $.each(data.resdato, function( key, val ) {
                        $('#tablaresjefe').append('<tr>'+
                                        '<td>'+ val.fiscalia_asignada+'</td>'+
                                        '<td>'+ val.descripcion_actividad+'</td>'+
                                        '<td>'+ val.materia_descripcion+'</td>'+
                                        '<td>'+ val.descripcion_etapa+'</td>'+
                                        '<td>'+val.descripcion_sub_etapa+'</td>'+
                                        '<td>'+ val.dfechadenuncia+'</td>'+
                                        '<td>'+ val.cexpedientesedi+'</td>'+
                                        '<td>'+ val.tdenunciaid+'</td>'+
                                        '<td>'+val.crtn+'</td>'+
                                        '<td>'+ val.cnombres+'</td>'+
                                        '<td>'+val.basignadafiscalia+'</td>'+
                                        '</tr>');
                });
    $('#ActividadFiscalTJefe').DataTable();*/
            }
            
        })
        .error(function(err) {
            error();
        })
}

function getallgestionF(api,idusuario,fechainicio,fechafinal){
    
    $.getJSON(serverUrl+api+'/'+idusuario+'/'+fechainicio+'/'+fechafinal, function(data,status) {
            if(data.status==200){
                
                  $('#vaciadogestionfiscalTB').dataTable({
                        processing: true,
                        bDestroy: true,
                        data: data.resdato,
                         aoColumns: [
                             { data: "nrodenuncia"},
                             { data: "fechadenuncia"},
                             { data: "horagestion"},
                             { data: "fiscalia"},
                             { data: "unidad"},
                             { data: "etapa"},                        
                             { data: "subetapa"}, 
                             { data: "gestionresolucion"}, 
                             { data: "nombreimputado"}                 
                        ]
                    });

                
              /*  $('#tablaresjefe').html('');
                    $.each(data.resdato, function( key, val ) {
                        $('#tablaresjefe').append('<tr>'+
                                        '<td>'+ val.fiscalia_asignada+'</td>'+
                                        '<td>'+ val.descripcion_actividad+'</td>'+
                                        '<td>'+ val.materia_descripcion+'</td>'+
                                        '<td>'+ val.descripcion_etapa+'</td>'+
                                        '<td>'+val.descripcion_sub_etapa+'</td>'+
                                        '<td>'+ val.dfechadenuncia+'</td>'+
                                        '<td>'+ val.cexpedientesedi+'</td>'+
                                        '<td>'+ val.tdenunciaid+'</td>'+
                                        '<td>'+val.crtn+'</td>'+
                                        '<td>'+ val.cnombres+'</td>'+
                                        '<td>'+val.basignadafiscalia+'</td>'+
                                        '</tr>');
                });
    $('#ActividadFiscalTJefe').DataTable();*/
            }
             
        })
        .error(function(err) {
            error();
        })
}



function successok(action){
  $("<div></div>").html('Se Agregó Correctamente').dialog({
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
    $("<div></div>").html('ha ocurrido un error').dialog({
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


function vacio(){
     $("<div></div>").html('No tiene Elementos Asignados').dialog({
        title: 'Elemento Vacios',
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




})
