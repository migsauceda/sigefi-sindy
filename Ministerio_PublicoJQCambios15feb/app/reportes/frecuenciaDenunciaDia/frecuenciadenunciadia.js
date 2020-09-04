
$(document).ready(function(){

    var serverUrl='http://172.17.0.254/sigefi/Ministerio_PublicoJQCambios/backend/api/?_url=/';


 $('body').on('change','.aniodenuncia',function(e){
     $('#n_menosIncidenciasdia').val('');
 });

 $('body').on('click','.frecuenciadendia',function(e){
 var cantidad=$('#n_menosIncidenciasdia').val();
 var optionselect=$('#optionselectdia').val();
 var anio=$('#aniodenunciadia').val();


if(typeof(cantidad)!='undefined' && cantidad!=''){  
     getallImputadoLimite('frecuenciaimputadoncantidad',cantidad,optionselect);
	        $('#aniodenunciadia').val(-1);		            
    }
    else if(cantidad==''){
        getallDatafrecuenciaDeptoAnio('frecuenciadendiaanio',anio);
        
    } 
    else{
                Aviso('Debe ingresar algo para bucar');
    }

});


getallDatafrecuenciaDia('frecuenciadendia');

getallanios('aniosdenuncias');


function getallanios(api){
     
    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){

                    $.each(data.resdato, function( key, val ) {
                        $('#aniodenunciadia').append('<option  id="'+val.anios+'"  value="'+val.anios +'">'+ val.anios+'</option>');
                });
            }
        })
        .error(function(data,status,err) {
            //alert(data.status);
            error(err);
        })
}

function getallDatafrecuenciaDia(api){
    
    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){

                  $('#frecuenciadenunciaDia').dataTable({
                      dom: 'Bfrtip',
                        buttons: [
                            'excelHtml5'
                        ],
                        processing: true,
                        bDestroy: true,
                        data: data.resdato,
                         aoColumns: [
                        { data: "cdescripcion"},
                        { data: "dia"},
                        { data: "totaldenuncia"},                                             
                        { data: "enero"}, 
                        { data: "febrero"}, 
                         { data: "marzo"},                       
                        { data: "abril"},
                        { data: "mayo"},
                        { data: "junio"},
                        { data: "julio"},                        
                        { data: "agosto"},  
                        { data: "septiembre"},
                        { data: "octubre"},                       
                        { data: "noviembre"},
                        { data: "diciembre"}
                        ]
                    });

             
            }
            
        })
        .error(function(err) {
            error();
        })
}


function getallImputadoLimite(api,cantidad,opcionselect){
    
    $.getJSON(serverUrl+api+'/'+cantidad+'/'+opcionselect, function(data,status) {
            if(data.status==200){

                  $('#frecuenciadenunciaDia').dataTable({
                      dom: 'Bfrtip',
                        buttons: [
                            'excelHtml5'
                        ],
                        processing: true,
                        bDestroy: true,
                        data: data.resdato,
                          aoColumns: [
                        { data: "cdescripcion"},
                        { data: "dia"},
                        { data: "totaldenuncia"},  
                                            
                        { data: "enero"}, 
                        { data: "febrero"}, 
                         { data: "marzo"},                       
                        { data: "abril"},
                        { data: "mayo"},
                        { data: "junio"},
                        { data: "julio"},                        
                        { data: "agosto"},  
                        { data: "septiembre"},
                        { data: "octubre"},                       
                        { data: "noviembre"},
                        { data: "diciembre"}
                        ]
                    });

             
            }
            
        })
        .error(function(err) {
            error();
        })
}

function getallDatafrecuenciaDeptoAnio(api,anio){
    
    $.getJSON(serverUrl+api+'/'+anio, function(data,status) {
            if(data.status==200){

                  $('#frecuenciadenunciaDia').dataTable({
                      dom: 'Bfrtip',
                        buttons: [
                            'excelHtml5'
                        ],
                        processing: true,
                        bDestroy: true,
                        data: data.resdato,
                          aoColumns: [
                        { data: "cdescripcion"},
                        { data: "dia"},
                        { data: "totaldenuncia"},  
                                            
                        { data: "enero"}, 
                        { data: "febrero"}, 
                         { data: "marzo"},                       
                        { data: "abril"},
                        { data: "mayo"},
                        { data: "junio"},
                        { data: "julio"},                        
                        { data: "agosto"},  
                        { data: "septiembre"},
                        { data: "octubre"},                       
                        { data: "noviembre"},
                        { data: "diciembre"}
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
