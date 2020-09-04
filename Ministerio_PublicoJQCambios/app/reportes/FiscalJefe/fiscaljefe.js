
$(document).ready(function(){

    //var serverUrl='http://172.17.100.55/sigefi_vpn/Ministerio_PublicoJQCambios/backend/api/?_url=/';
    var ip= $('#ipreal').val().split(".");
    if (ip[0]== 172 && ip[1]== 17){
        //teguicigalpa
        var serverUrl='http://172.17.0.254/sigefi_vpn/Ministerio_PublicoJQCambios/backend/api/?_url=/';
    }
    else{
        //regional
        var serverUrl='http://172.17.100.55/sigefi_vpn/Ministerio_PublicoJQCambios/backend/api/?_url=/';
    }
alert("lin 14");
getallusuario('confirmaciondenunciajefe',$('#usersesion').val());



$('body').on('click','.buscar_actividadfiscajefe',function(e){
alert("btn buscar");
       var idusuario=$('#idusuariohijo').val();
      // alert(idusuario);
       var fechainicio=$('#fecha_inicial_j').val();
       var fechafinal=$('#fecha_final_j').val();

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



function getallusuario(api,user){
alert(api+user);
    $.getJSON(serverUrl+api+'/'+user, function(data,status) {
            if(data.status==200){

                    $.each(data.resdato, function( key, val ) {
                        $('#idusuariohijo').append('<option  id="'+val.usuario+'"  value="'+val.usuario +'">'+ val.nombres+'</option>');
                });
            }
        })
        .error(function(data,status,err) {
            //alert(data.status);
            error(err);
        })
}




function getallconfirmaciondenuncia(api,idusuario){

    $.getJSON(serverUrl+api+'/'+idusuario, function(data,status) {
            if(data.status==200){

                  $('#ActividadFiscalTJefe').dataTable({
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

function getallconfirmaciondenunciaF(api,idusuario,fechainicio,fechafinal){

    $.getJSON(serverUrl+api+'/'+idusuario+'/'+fechainicio+'/'+fechafinal, function(data,status) {
            if(data.status==200){
                $('#ActividadFiscalTJefe').dataTable({
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
