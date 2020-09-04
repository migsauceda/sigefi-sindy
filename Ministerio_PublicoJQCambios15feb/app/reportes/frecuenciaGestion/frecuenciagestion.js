
$(document).ready(function(){

    var serverUrl='http://172.17.0.254/sigefi/Ministerio_PublicoJQCambios/backend/api/?_url=/';


 $('body').on('change','.aniodenuncia',function(e){
     $('#n_menosIncidenciasdia').val('');
 });

 $('body').on('click','.frecuenciagestion',function(e){

 var anio=$('#aniogestion').val();


    if(anio!=-1){  
	      getallFrecuenciaGestionAnio('frecuenciaresolucionanio',anio);       
    }

    else{
                Aviso('Debe ingresar un año para realizar la búsqueda');
    }

});


getallFrecuenciaGestion('frecuenciaresolucion');

getallanios('aniosdenuncias');


function getallanios(api){
     
    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){

                    $.each(data.resdato, function( key, val ) {
                        $('#aniogestion').append('<option  id="'+val.anios+'"  value="'+val.anios +'">'+ val.anios+'</option>');
                });
            }
        })
        .error(function(data,status,err) {
            //alert(data.status);
            error(err);
        })
}

function getallFrecuenciaGestion(api){
    
    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){

                  $('#frecuenciaGestion').dataTable({
                      dom: 'Bfrtip',
                        buttons: [
                            'excelHtml5'
                        ],
                        processing: true,
                        bDestroy: true,
                        data: data.resdato,
                         aoColumns: [
                        { data: "actividad"},
                        { data: "totalactividad"}
                 
                        ]
                    });

             
            }
            
        })
        .error(function(err) {
            error();
        })
}



function getallFrecuenciaGestionAnio(api,anio){
    
    $.getJSON(serverUrl+api+'/'+anio, function(data,status) {
            if(data.status==200){

                  $('#frecuenciaGestion').dataTable({
                      dom: 'Bfrtip',
                        buttons: [
                            'excelHtml5'
                        ],
                        processing: true,
                        bDestroy: true,
                        data: data.resdato,
                          aoColumns: [
                              { data: "actividad"},
                              { data: "totalactividad"}
                        ]
                    });

             
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
