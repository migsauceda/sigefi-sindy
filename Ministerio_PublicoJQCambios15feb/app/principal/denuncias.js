$(document).ready(function(){
    var serverUrl='http://localhost:1080/Ministerio_PublicoJQcambios/backend/api/';
$('body').on('submit','.entrevistadenunciante',function(e){
    
    e.preventDefault();
    //$('#result').text(JSON.stringify($('form.pruebita').serializeObject()));

//alert(JSON.stringify($('form.datospersonales').serializeObject()))
    submit('entrevistadenunciante',1,JSON.stringify($('form.entrevistadenunciante').serializeObject()))
    return false;

   
 });

 $('body').on('submit','.mapa',function(e){
    e.preventDefault();
    submit('geopocision',1,JSON.stringify($('form.mapa').serializeObject()))
    getallpociciones('geopocision');
    return false;
 });

getalltipodenuncia('tipodenuncia');
getalldepartamentos('deptospais');


$('body').on('change','.deptos',function(e){
  var id=$("#deptos option:selected" ).val();
    departamentosid('departamentos',id);
    
    $('#dialog').dialog("refresh");
});


function getalltipodenuncia(api){
    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){
     
                    $.each(data.resdato, function( key, val ) {
                        $('#istipodenucnia').append('<option  id="'+val.istipodenucnia+'"  value="'+val.istipodenucnia +'">'+ val.cdescripcion+'</option>');
                });
            }
        })
        .error(function(err) {
            error();
        })
}

function getalldepartamentos(api){
    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){
     
                    $.each(data.resdato, function( key, val ) {
                        $('#cdepartamentoid').append('<option  id="'+val.cdepartamentoid+'"  value="'+val.cdepartamentoid +'">'+ val.cdescripcion+'</option>');
                });
            }
        })
        .error(function(err) {
            error();
        })
}



function getallpociciones(api){
    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){
                    $.each(data.respocision, function( key, val ) {
                        $('#pocisiones').append('<tr>'+
                                        '<td>'+ val.id+'</td>'+
                                        '<td>'+ val.descripcion+'</td>'+
                                        '<td>'+ val.lat+'</td>'+
                                        '<td>'+val.lon+'</td>'+
                                         '<td><a href="#"><font color="blue">Editar</font></a></td>'+
                                        '</tr>');
                });
            }
        })
        .error(function(err) {
            error();
        })
}



function submit(urlapi,type,data){

    //alert(data);
 var typeFn;

 switch(type) {
    case 2:
        typeFn='PUT'
        break;
    case 3:
       typeFn='DELETE'
        break;
    default:
         typeFn='POST'
}
    $.ajax({
        url : serverUrl+urlapi,
        data : data,
        type : typeFn,
        dataType : 'json',
        success : function(data) {


            if(data.status==200){
                successok(type);
            }
    
        },
        error : function(xhr, status) {
           error(JSON.stringify(xhr));
        }
      
    });
}

function successok(action){
  $("<div></div>").html('Se Guardo Correctamente').dialog({
        title: 'Bien',
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
        title: 'Error',
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

$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};



function limpiar_marcadores(lista){
        for(i in lista)
        {
            //QUITAR MARCADOR DEL MAPA
            lista[i].setMap(null);
        }
    }


 $('body').on('click','.tab2',function(e){
       var minZoomLevel = 8;
        $("#dialog").dialog({
            modal: true,
            title: "Google Map",
            width: 1200,
            hright: 450,
            buttons: {
                Close: function () {
                    $(this).dialog('close');
                }
            },
            open: function () {
             
                CreateMap();
    
            
            }
        });
    });

 $('body').on('click','.cargar',function(e){
    e.preventDefault();
     
    $('#dialog').dialog({
    
           modal: true,
            title: "Google Map",
            width: 900,
            hright: 450,
            buttons: {
                Close: function () {
                    $(this).dialog('close');
                }
            },
        buttons: {
                Close: function () {
                    $(this).dialog('close');
                }
            },
        open: function () {
                CreateMap();
            }
    });
 });





})