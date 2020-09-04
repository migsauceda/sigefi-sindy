


$(document).ready(function(){

    //var serverUrl='http://172.17.100.55/sigefi_vpn/Ministerio_PublicoJQCambios/backend/api/?_url=/';
    var ip= $('#ipreal').val().split(".");
    if (ip[0]== 172 && ip[1]== 17 && ip[2]== 0 && ip[3]== 254){
        //teguicigalpa
        var serverUrl='http://172.17.0.254/sigefi_vpn/Ministerio_PublicoJQCambios/backend/api/?_url=/';
    }
    else{
        //regional
        var serverUrl='http://172.17.100.55/sigefi_vpn/Ministerio_PublicoJQCambios/backend/api/?_url=/';
    }

 $('body').on('click','.confirmaciondenuncia',function(e){
        getallbandejas('bandejas');
 });

$('body').on('click','.buscar_confirmacion',function(e){
    var nombre=$('#nombre').val();
    var usuario=$('#idusuariofiscal').val();
    //alert(usuario);
    if((typeof(nombre)=='undefined' || nombre=='') && usuario==null){
       // getallconfirmacondenuncia('confirmaciondenuncia');
       Aviso('Debe ingresar un nombre para realizar la busqueda');

    }
    else if((typeof(nombre)!='undefined' || nombre!='') && (usuario!=null)){
            getallconfirmacondenunciaNombre('confirmaciondenunciafiscal',usuario);
    }
    else{
        getallconfirmacondenunciaNombre('confirmaciondenuncia',nombre);
    }


 });

$('body').on('change','.idusuariofiscal',function(e){
     //alert();
      $('#nombre').val('');
 });

$('body').on('change','.ibandejaidfiscal',function(e){
        var idbandeja2=$('.ibandejaidfiscal').val();
        getallusers('usuariofiscalia',idbandeja2);

 });

function getallbandejas(api){

    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){

                    $.each(data.resdato, function( key, val ) {
                        $('#ibandejaidfiscal').append('<option  id="'+val.ibandejaid+'"  value="'+val.ibandejaid +'">'+ val.cdescripcion+'</option>');
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

       // alert(data.resdato.length);
            if(data.status==200){

                    $.each(data.resdato, function( key, val ) {
                        $('#idusuariofiscal').append('<option  id="'+val.usuario+'"  value="'+val.usuario +'">'+ val.nombres+'</option>');
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
                        { data: "nombresofendido"},
                        { data: "crtn"},
                        { data: "nombredelito"},
                        {data:"fiscalasiganado"},
                         { data: "bandeja"},
                        { data: "subbandeja"},
                        { data: "dfechaasignacion"},
                        { data: "basignadafiscalia"},
                        { data: "cexpedientesedi"}


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
                        { data: "nombresofendido"},
                        { data: "crtn"},
                        { data: "nombredelito"},
                       // {data:"fiscalasiganado"},
                         { data: "bandeja"},
                        { data: "subbandeja"},
                        { data: "dfechaasignacion"},
                        { data: "basignadafiscalia"},
                        { data: "cexpedientesedi"},
                          { data: "ctransito"},
                        { data: "clevantamiento"},

                        { data: "cautopsia"}

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

function vacio(){
     $("<div></div>").html('No tiene elementos asignados').dialog({
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
