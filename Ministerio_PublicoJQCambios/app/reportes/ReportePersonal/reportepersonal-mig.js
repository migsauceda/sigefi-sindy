
$(document).ready(function(){

    var serverUrl='http://172.17.0.254/sigefi/Ministerio_PublicoJQCambios/backend/api/?_url=/';




$('body').on('click','.buscar_actividadfiscalPe',function(e){
    //alert();
       var fechainicio=$('#fecha_inicial_p').val();
       var fechafinal=$('#fecha_final_p').val();
       var user=$('#usersesion').val();

       /*if(typeof(fechainicio)=='undefined' || fechainicio=='' || typeof(fechafinal)=='undefined' || fechafinal=='' ){
      
             getallconfirmaciondenuncia('actividadfiscal',idusuario);
       }
	   
       else{*/
	  
           if(fechainicio<fechafinal){
               getallconfirmaciondenunciaF('actividadfiscalpersona',user,fechainicio,fechafinal);


           }
           else if(typeof(fechainicio)=='undefined' || fechainicio=='' ||  typeof(fechafinal)=='undefined' || fechafinal==''){
                 Aviso('Debe seleccionar una fecha de inicio y una final');
           }
           else{
             //  alert('Fecha de inicio debe ser menor qu la final');
               Aviso('Fecha de inicio debe ser menor que la final');

           }


      // }
    
 });



function getallconfirmaciondenunciaF(api,idusuario,fechainicio,fechafinal){
    //alert(serverUrl+api+'/'+idusuario+'/'+fechainicio+'/'+fechafinal);
    $.getJSON(serverUrl+api+'/'+idusuario+'/'+fechainicio+'/'+fechafinal, function(data,status) {
            if(data.status==200){
                $('#ActividadFiscalTPersona').dataTable({
                        processing: true,
                        bDestroy: true,
                        data: data.resdato,
                        aoColumns: [
                        { data: "dfechadenuncia"},
                        { data: "tdenunciaid"},
                        { data: "cnombres"}, 
                        { data: "cnombresofendido"},                        
                       // { data: "fiscalia_asignada"}, 
                        { data: "delito"}, 
                         { data: "fecharegistro"},                       
                        { data: "descripcion_actividad"},
                         { data: "descripcion_sub_etapa"},
                         { data: "descripcion_etapa"},
                        { data: "materia_descripcion"},
                        { data: "cobservacion"}
                        
                                            
                       // { data: "cexpedientesedi"},  
                       // { data: "crtn"},                   
                        //{ data: "basignadafiscalia"}
                        ]
                    });
               /* $('#tablarespersonal').html('');
                    $.each(data.resdato, function( key, val ) {
                        $('#tablarespersonal').append('<tr>'+
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
    $('#ActividadFiscalTPersona').DataTable();*/
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
