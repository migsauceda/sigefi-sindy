
$(document).ready(function(){

    var serverUrl='http://172.17.0.254/sigefi/Ministerio_PublicoJQCambios/backend/api/?_url=/';


 $('body').on('click','.frecuenciadelitos',function(e){
 var cantidad=$('#n_menosIncidencias').val();
 var optionselect=$('#optionselect').val();



if(typeof(cantidad)!='undefined' && cantidad!=''){  
     getallDenRecibidadFrecuencias('frecuenciadenunciarecibidalimite',cantidad,optionselect);
			            
}
  
else{
               Aviso('Ingres cantidad');

}


 //alert();
//alert(cantidad+optionselect);
    
});



getallData('frecuenciadenunciarecibida');


function getallData(api){
    
    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){

                  $('#frecuenciadenuncia').dataTable({
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
                         { data: "edad_0_4"},                       
                        { data: "edad_5_9"},
                        { data: "edad_10_14"},
                        { data: "edad_15_19"},
                        { data: "edad_20_24"},                        
                        { data: "edad_25_29"},  
                        { data: "edad_30_34"},
                        { data: "edad_35_39"},                       
                        { data: "edad_40_44"},
                        { data: "edad45_49"},
                        { data: "edad_50_54"},                        
                        { data: "edad_55_59"},  
                        { data: "edad_60_64"},
                        { data: "edad_65_69"},
                        { data: "edad_70_74"},                        
                        { data: "edad_75_79"},  
                        { data: "edad_80mas"}
                        ]
                    });

             
            }
            
        })
        .error(function(err) {
            error();
        })
}


function getallDenRecibidadFrecuencias(api,cantidad,opcionselect){
    
    $.getJSON(serverUrl+api+'/'+cantidad+'/'+opcionselect, function(data,status) {
            if(data.status==200){

                  $('#frecuenciadenuncia').dataTable({
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
                         { data: "edad_0_4"},                       
                        { data: "edad_5_9"},
                        { data: "edad_10_14"},
                        { data: "edad_15_19"},
                        { data: "edad_20_24"},                        
                        { data: "edad_25_29"},  
                        { data: "edad_30_34"},
                        { data: "edad_35_39"},                       
                        { data: "edad_40_44"},
                        { data: "edad45_49"},
                        { data: "edad_50_54"},                        
                        { data: "edad_55_59"},  
                        { data: "edad_60_64"},
                        { data: "edad_65_69"},
                        { data: "edad_70_74"},                        
                        { data: "edad_75_79"},  
                        { data: "edad_80mas"}
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
