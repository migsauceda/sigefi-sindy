
$(document).ready(function(){

    var serverUrl='http://172.17.0.254/sigefi/Ministerio_PublicoJQCambios/backend/api/?_url=/';


 $('body').on('click','.actividadfiscal',function(e){
        getallbandejas('bandejas');
 });


$('body').on('change','.ibandejaid',function(e){
        var idbandeja2=$('.ibandejaid').val();
        getallusers('usuariofiscalia',idbandeja2);
      
 });

$('body').on('click','.buscar_actividadfiscal',function(e){
       var idusuario=$('.idusuario').val();
       var fechainicio=$('#fecha_inicial').val();
       var fechafinal=$('#fecha_final').val();

       if(typeof(fechainicio)=='undefined' || fechainicio=='' || typeof(fechafinal)=='undefined' || fechafinal=='' ){
      
             getallconfirmaciondenuncia('actividadfiscal',idusuario);
       }
       else{
           if(fechainicio<fechafinal){
               getallconfirmaciondenunciaF('actividadfiscal',idusuario,fechainicio,fechafinal);


           }
           else{
             //  alert('Fecha de inicio debe ser menor qu la final');
               Aviso('Fecha de inicio debe ser menor que la final');

           }


       }
    
 });



function getallbandejas(api){
     
    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){

                    $.each(data.resdato, function( key, val ) {
                        $('#ibandejaid').append('<option  id="'+val.ibandejaid+'"  value="'+val.ibandejaid +'">'+ val.cdescripcion+'</option>');
                });
            }
        })
        .error(function(data,status,err) {
            //alert(data.status);
            error(err);
        })
}

function getallusers(api,idbandeja){
    $.getJSON(serverUrl+api+'/'+idbandeja, function(data,status) {
        $('#idusuario').html('');
       // alert(data.resdato.length);
            if(data.status==200){
                    
                    $.each(data.resdato, function( key, val ) {
                        $('#idusuario').append('<option  id="'+val.usuario+'"  value="'+val.usuario +'">'+ val.nombres+'</option>');
                });
            }
        })
        .error(function(data,status) {
            if(data.status==200){
                vacio();
                $('#idusuario').html('');
            }
            else{
                 error(err);
            }
           
           
        })
}



function getallconfirmaciondenuncia(api,idusuario){
    
    $.getJSON(serverUrl+api+'/'+idusuario, function(data,status) {
            if(data.status==200){

                  $('#ActividadFiscalT').dataTable({
                        processing: true,
                        bDestroy: true,
                        data: data.resdato,
                         aoColumns: [
                        { data: "dfechadenuncia"},
                        { data: "tdenunciaid"},
                        { data: "cnombres"},                        
                        { data: "fiscalia_asignada"}, 
                        { data: "delito"}, 
                         { data: "fecharegistro"},                       
                        { data: "descripcion_actividad"},
                        { data: "materia_descripcion"},
                        { data: "descripcion_etapa"},
                        { data: "descripcion_sub_etapa"},                        
                        { data: "cexpedientesedi"},  
                        { data: "crtn"},                   
                        { data: "basignadafiscalia"}
                        ]
                    });
                /*$('#tablares').html('');
                    $.each(data.resdato, function( key, val ) {
                        $('#tablares').append('<tr>'+
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
    $('#ActividadFiscalT').DataTable();*/
            }
            
        })
        .error(function(err) {
            error();
        })
}

function getallconfirmaciondenunciaF(api,idusuario,fechainicio,fechafinal){
    
    $.getJSON(serverUrl+api+'/'+idusuario+'/'+fechainicio+'/'+fechafinal, function(data,status) {
            if(data.status==200){
                $('#ActividadFiscalT').dataTable({
                        processing: true,
                        bDestroy: true,
                        data: data.resdato,
                         aoColumns: [
                        { data: "dfechadenuncia"},
                        { data: "tdenunciaid"},
                        { data: "cnombres"},                        
                        { data: "fiscalia_asignada"}, 
                        { data: "delito"}, 
                        { data: "fecharegistro"},                      
                        { data: "descripcion_actividad"},
                        { data: "materia_descripcion"},
                        { data: "descripcion_etapa"},
                        { data: "descripcion_sub_etapa"},                        
                        { data: "cexpedientesedi"},  
                        { data: "crtn"},                   
                        { data: "basignadafiscalia"}
                        ]
                    });
               /* $('#tablares').html('');
                    $.each(data.resdato, function( key, val ) {
                        $('#tablares').append('<tr>'+
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
    $('#ActividadFiscalT').DataTable();*/
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
