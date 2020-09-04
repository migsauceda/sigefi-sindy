
$(document).ready(function(){

    var serverUrl='http://172.17.0.254/sigefi/Ministerio_PublicoJQCambios/backend/api/?_url=/';


 $('body').on('change','.aniodenunciaimputado',function(e){
     $('#n_menosIncidenciaimputado').val('');
 });

 $('body').on('click','.frecuenciadeimputado',function(e){
 var cantidad=$('#n_menosIncidenciaimputado').val();
 var optionselect=$('#optionselectimputado').val();
 var anio=$('#aniodenunciaimputado').val();


if(typeof(cantidad)!='undefined' && cantidad!=''){  
     getallDatafrecuenciaImp('frecuenciaimputadoncantidad',cantidad,optionselect);
	        $('#aniodenunciaimputado').val(-1);		            
    }
    else if(cantidad==''){
        getallDatafrecuenciaImpAnio('frecuenciaimputadonanio',anio);
        
    } 
    else{
                Aviso('Debe ingresar algo para bucar');
    }

});


getallFrecuenciasimputado('frecuenciaimputadoanio');

getallanios('aniosdenuncias');


function getallanios(api){
     
    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){

                    $.each(data.resdato, function( key, val ) {
                        $('#aniodenunciaimputado').append('<option  id="'+val.anios+'"  value="'+val.anios +'">'+ val.anios+'</option>');
                });
            }
        })
        .error(function(data,status,err) {
            //alert(data.status);
            error(err);
        })
}

function getallFrecuenciasimputado(api){
    
    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){

                  $('#frecuenciaImputado').dataTable({
                      dom: 'Bfrtip',
                        buttons: [
                            'excelHtml5'
                        ],
                        processing: true,
                        bDestroy: true,
                        data: data.resdato,
                         aoColumns: [
                        { data: "cdescripcion"},
                        { data: "totaldelito"},
                        { data: "totalhombres"},     
                        { data: "totalmujeres"},
                        { data: "noconsignado"},                                        
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


function getallDatafrecuenciaImp(api,cantidad,opcionselect){
    
    $.getJSON(serverUrl+api+'/'+cantidad+'/'+opcionselect, function(data,status) {
            if(data.status==200){

                  $('#frecuenciaImputado').dataTable({
                      dom: 'Bfrtip',
                        buttons: [
                            'excelHtml5'
                        ],
                        processing: true,
                        bDestroy: true,
                        data: data.resdato,
                       aoColumns: [
                        { data: "cdescripcion"},
                        { data: "totaldelito"},
                        { data: "totalhombres"},     
                        { data: "totalmujeres"},
                        { data: "noconsignado"},                                        
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

function getallDatafrecuenciaImpAnio(api,anio){
    
    $.getJSON(serverUrl+api+'/'+anio, function(data,status) {
            if(data.status==200){

                  $('#frecuenciaImputado').dataTable({
                      dom: 'Bfrtip',
                        buttons: [
                            'excelHtml5'
                        ],
                        processing: true,
                        bDestroy: true,
                        data: data.resdato,
                          aoColumns: [
                        { data: "cdescripcion"},
                        { data: "totaldelito"},
                        { data: "totalhombres"},     
                        { data: "totalmujeres"},
                        { data: "noconsignado"},                                        
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
