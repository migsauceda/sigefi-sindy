$(document).ready(function(){
    var serverUrl='http://172.17.0.254/sigefi/Ministerio_PublicoJQCambios/backend/api/?_url=/';


  


  
  $( "#tabs" ).tabs();

//var a=[];
//var b=[];

$('body').on('submit','.entrevistadenunciante',function(e){

    e.preventDefault();

   ///$('input[type=submit]').click(function(event){
      //  event.preventDefault();
 var identificacion=$('#cidentificacion').val();
 var nombres=$('#cnombres').val();
 var apellidos=$('#capellidos').val();
 var edad=$('#iedad').val();
 var direccion=$('#cdireccion').val(); 
 var telefono=$('#ctelefono').val();



/*alert(identificacion);
alert(JSON.stringify({identificacion:identificacion,
                      nombres:nombres,
                      apellidos:apellidos,
                      edad:edad,
                      direccion:direccion,
                      telefono:telefono}));*/





/*if(typeof(identificacion)=='undefined' || identificacion=='' || typeof(nombres)=='undefined' || nombres=='' || typeof(apellidos)=='undefined' || apellidos=='' || typeof(edad)=='undefined' || edad=='' || typeof(direccion)=='undefined' || direccion=='' || typeof(telefono)=='undefined' || telefono==''){
    alert('Debe Completar Todos lo campos');

}
else{
   try {
         
         submit('entrevistadenunciante',1,JSON.stringify($('form.entrevistadenunciante').serializeObject()));
         e.preventDefault();
       
    }
    catch(err) {

    }

}*/

   // });
 
 });

$('body').on('click','.sololetras',function(e){  
   // alert();
    //event.preventDefault();
 $('.validacion').css('display','block');
});

$('body').on('click','.solonumero',function(e){  
   // alert();
    //event.preventDefault();
 $('.validacion').css('display','block');
});

 


$(document.body).on('submit','.detalledenuncia',function(e){  
    //alert();
var text=$('#thora_hecho').val().replace(/ /g,'');;
$('#thora_hecho').val(text);

var a=[];
var b=[];

//formulario de datos del denunciante
var tipoidentificacion=$('#nidentificacionid').val();
var identificacion=$('#cidentificacion').val();
 var nombres=$('#cnombres').val();
 var apellidos=$('#capellidos').val();
 var edad=$('#iedad').val();
 var direccion=$('#cdireccion').val(); 
 var telefono=$('#ctelefono').val();
 var aplicalgbti=$('input:radio[name=baplicagbti]:checked').val();
 var personanatural= $('input:radio[name=bpersonanatural]:checked').val();
 var genero=$('input:radio[name=cgenero]:checked').val();
 var profesion=$('#nprofesionid').val();
 var ocupacion=$('#nocupacionid').val();
 var escolaridad=$('#nescolaridadid').val();
 var estadocivil=$('#nestadocivilid').val();
 var etnia=$('#netniaid').val(); 
 var discapacidad=$('#ndiscapacidadid').val();
 var aplicadenuncia=$('#baplica_denuncia').val();
 var centroatencion=$('#centroatencion').val();
 var observacioncentroatencion=$('#observacioncentroatencion').val();

//alert(deptodenuncia);

 //formulario de detlle de la denuncia


 var direccion_hecho=$('#cdireccion_hecho').val();
 var fecha_hecho=$('#dfecha_hecho').val();



  var text=$('#thora_hecho').val();
  text= text.replace(/ /g,'');
  var  hora_hecho=$('#thora_hecho').val().replace(/ /g,'');
        
//alert(hora_hecho);
 var narracionhecho=$('#cnarracionhecho').val();
 var deptodenuncia=$('#cdeptodenuncia').val();
 var municipio=$('#cmunicipiodenuncia').val();
 var aldea=$('#caldea').val();

//alert(aldea)
e.preventDefault();
  
a.push($('form.entrevistadenunciante').serializeObject());
b.push($('form.detalledenuncia').serializeObject());

 /*if ($('input[name="personanatural"]').is(':checked')) {
        alert('Campo correcto');
    } else {
        alert('Se debe seleccionar todos los campos');
    }*/



 $('#cdireccion_hecho').val($('#cdireccion_hecho').val()+document.getElementById("descripcion").value);


if(telefono.length<8){
     
    Aviso('Número de teléfono, debe estar completo');
    $('#tab').click();
}
else if(edad>130){
     Aviso('Ingrese una edad válida');
    $('#tab').click();

}
else if( typeof(direccion_hecho)=='undefined' || direccion_hecho=='' ||
        typeof(fecha_hecho)=='undefined' || fecha_hecho=='' || 
        typeof(hora_hecho)=='undefined' || hora_hecho=='' ||
        typeof(narracionhecho)=='undefined' || narracionhecho=='' || 
        typeof(deptodenuncia)=='undefined' || deptodenuncia==-1 ||
        typeof(municipio)=='undefined' || municipio==-1 ||
        typeof(aldea)=='undefined' || aldea==-1 ||
		typeof(aplicadenuncia)=='undefined' || aplicadenuncia==-1 
        ){
            
        Aviso('Debe completar todos lo campos');
}
else if(aplicadenuncia=='f' && ( centroatencion==-1 || observacioncentroatencion=="") ){
     Aviso('Debe completar todos lo campos');
}
else{
        if(typeof(identificacion)=='undefined' || identificacion=='' ||
           typeof(nombres)=='undefined' || nombres=='' ||
           typeof(apellidos)=='undefined' || apellidos=='' ||
           typeof(edad)=='undefined' || edad=='' || 
           typeof(direccion)=='undefined' || direccion=='' || 
           typeof(telefono)=='undefined' || telefono=='' || 
           typeof(personanatural)=='undefined' || personanatural=='' ||
           typeof(aplicalgbti)=='undefined' || aplicalgbti=='' ||
           typeof(genero)=='undefined' || genero=='' ||
		   typeof(profesion)=='undefined' || profesion==-1 ||
		   typeof(ocupacion)=='undefined' || ocupacion==-1 ||
		   typeof(escolaridad)=='undefined' || escolaridad==-1 ||
		   typeof(estadocivil)=='undefined' || estadocivil==-1 ||
		   typeof(etnia)=='undefined' || etnia==-1 ||
		   typeof(discapacidad)=='undefined' || discapacidad==-1)
		   
            {

               
                Aviso('Debe completar todos lo campos');
                $('#tab').click();

        }
        else{
            try {
                    
                       var data={
                                
                                "DataFinalPersona": a,
                                "DataFinalDenuncia":b
                        }
                        //alert(centroatencion+observacioncentroatencion);
                      submit('denuncia',1,JSON.stringify(data));

                      //alert(aplicadenuncia);
                   
                }
                catch(err) {
                        return false;
            }

            

        }
    }

});


 /*$('body').on('submit','.pruebaquery',function(e){
    e.preventDefault();
    var c=[];
    var d=[];

    c.push({nombre:'Erick8',tipo:'1'});
    d.push({color:'amarillo'});
    var data={
                                
                                "DataFinalcarro": c,
                                "DataFinaldetalle":d
        }

    var data2={nombre:'Erick',tipo:'1'};
        //alert(JSON.stringify(data));
    submit('robots',1,JSON.stringify(data));
 });*/

getallestadocivil('estadocivil');
getallescolaridad('escolaridad');
getallocupacion('ocupacion');
getallprofesion('profesion');
getalletnias('etnias');
getalltipoidentificacion('tipoidentificacion');
getalldiscapacidad('discapacidad');
getallbadejas('bandejas');
getalltipodenuncia('tipodenuncia');
getalldepartamentos('deptospais');
getallcentroremision('centroremision');

$('body').on('change','.deptos',function(e){
  var id=$("#deptos option:selected" ).val();
  //alert(id);
    //departamentosid('departamentos',id);
    getalldepartamentos('deptospais');

  
    
    $('#dialog').dialog("refresh");
});





$('body').on('change','.baplica_denuncia',function(e){
  var id=$(".baplica_denuncia" ).val();
  //alert(id);
   //$('body .baplica_denuncia').css('display','block');
  if(id=='f'){
    $('body .decricpcionatecion').css('display','block');
     $('body .centro').css('display','block');
    
  }
  else{
       $('body .decricpcionatecion').css('display','none');
       $('body .centro').css('display','none');
  }
    
     // alert($('#cmunicipiodenuncia').val());
    
});


$('body').on('change','.cdeptodenuncia',function(e){
  var id=$(".cdeptodenuncia" ).val();
  //alert(id);
    getallmunicipios('municipios',id);
     // alert($('#cmunicipiodenuncia').val());
    
});

$('body').on('change','.cmunicipiodenuncia',function(e){
  var id=$(".cmunicipiodenuncia" ).val();
  //alert(id);
    getallaldeas('aldeas',id);
    
});

$('body').on('click','.session',function(e){

   // var veousuario="<?  $_SESSION['valido']?>"; 
     var msj='<?= echo$msj; ?>';
   alert(msj); 
});




function getallcentroremision(api){

    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){
     
                    $.each(data.resdato, function( key, val ) {
                        
                        $('#centroatencion').append('<option  id="'+val.ninstitucion+'"  value="'+val.ninstitucion +'">'+ val.cdescripcion+'</option>');
                      // $('#deptos').append('<option  id="'+val.cdepartamentoid+'"  value="'+val.cdepartamentoid +'">'+ val.cdescripcion.toLowerCase()+'</option>');

             });
            }
        })
        .error(function(data,status,err) {
            //alert(data.status);
            error();
        })
}

function getalldepartamentos(api){

    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){
     
                    $.each(data.resdato, function( key, val ) {
                        
                        $('#cdeptodenuncia').append('<option  id="'+val.cdepartamentoid+'"  value="'+val.cdepartamentoid +'">'+ val.cdescripcion+'</option>');
                       $('#deptos').append('<option  id="'+val.cdepartamentoid+'"  value="'+val.cdepartamentoid +'">'+ val.cdescripcion.toLowerCase()+'</option>');

             });
            }
        })
        .error(function(data,status,err) {
            //alert(data.status);
            error();
        })
}

function getallestadocivil(api){
    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){
     
                    $.each(data.resdato, function( key, val ) {
                        $('#nestadocivilid').append('<option  id="'+val.ncivil+'"  value="'+val.ncivil +'">'+ val.cdescripcion+'</option>');
                });
            }
        })
        .error(function(err) {
            error();
        })
}


function getallbadejas(api){
    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){
     
                    $.each(data.resdato, function( key, val ) {
                        $('#nidbandejaid').append('<option  id="'+val.ibandejaid+'"  value="'+val.ibandejaid +'">'+ val.cdescripcion+'</option>');
                });
            }
        })
        .error(function(err) {
            error();
        })
}

function getalltipodenuncia(api){
    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){
     
                    $.each(data.resdato, function( key, val ) {
                        $('#ntipodenunciaid').append('<option  id="'+val.istipodenucnia+'"  value="'+val.istipodenucnia +'">'+ val.cdescripcion+'</option>');
                });
            }
        })
        .error(function(err) {
            error();
        })
}


function getallescolaridad(api){
    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){
     
                    $.each(data.resdato, function( key, val ) {
                        $('#nescolaridadid').append('<option  id="'+val.nescolaridadid+'" value="'+val.nescolaridadid+'">'+ val.cdescripcion+'</option>');
                });
            }
        })
        .error(function(err) {
            error();
        })
}

function getallocupacion(api){
    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){
     
                    $.each(data.resdato, function( key, val ) {
                        $('#nocupacionid').append('<option  id="'+val.nocupacionid+'" value="'+val.nocupacionid+'">'+ val.cdescripcion+'</option>');
                });
            }
        })
        .error(function(err) {
            error();
        })
}

function getallprofesion(api){
    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){
     
                    $.each(data.resdato, function( key, val ) {
                        $('#nprofesionid').append('<option  id="'+val.nprofesionid+'" value="'+val.nprofesionid+'">'+ val.cdescripcion+'</option>');
                });
            }
        })
        .error(function(err) {
            error();
        })
}

function getalletnias(api){
    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){
     
                    $.each(data.resdato, function( key, val ) {
                        $('#netniaid').append('<option  id="'+val.netniaid+'" value="'+val.netniaid+'">'+ val.cdescripcion+'</option>');
                });
            }
        })
        .error(function(err) {
            error();
        })
}

function getalltipoidentificacion(api){
    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){
     
                    $.each(data.resdato, function( key, val ) {
                        $('#nidentificacionid').append('<option  id="'+val.ndocumentoid+'" value="'+ val.ndocumentoid+'">'+ val.cdescripcion+'</option>');
                });
            }
        })
        .error(function(err) {
            
            error();
               
        })
}

function getalldiscapacidad(api){
    $.getJSON(serverUrl+api, function(data,status) {
            if(data.status==200){
     
                    $.each(data.resdato, function( key, val ) {
                        $('#ndiscapacidadid').append('<option  id="'+val.ndiscapacidadid+'" value="'+ val.ndiscapacidadid+'">'+ val.cdescripcion+'</option>');
                });
            }
        })
        .error(function(err) {
            error();
        })
}



function getallmunicipios(api,depto){
    //alert(depto);
    if(typeof(depto)=='undefined' || depto==-1){
        Aviso('No tiene elementos asignados');
         $('#cmunicipiodenuncia').html('');
          $('#cmunicipiodenuncia').append('<option value="-1">--Seleccionar-- </option>');
    }
    else{
           $.getJSON(serverUrl+api+'/'+depto, function(data,status) {
            if(data.status==200){
                $('#cmunicipiodenuncia').html('');
				 $('#caldea').html('');
				$('#caldea').append('<option value="-1">--Seleccionar--</option>');
                $('#cmunicipiodenuncia').append('<option value="-1">--Seleccionar--</option>');
                    $.each(data.resdato, function( key, val ) {
                        $('#cmunicipiodenuncia').append('<option  id="'+val.cmunicipioid+'" value="'+ val.cmunicipioid+'">'+ val.cdescripcion+'</option>');
                });
            }
        })
        .error(function(err) {
            error();
        })

    }
 
}

function getallaldeas(api,municipio){
    //alert(municipio);

    if(typeof(municipio)=='undefined' || municipio==-1){
        $('#caldea').html('');
        $('#caldea').append('<option value="-1">--Seleccionar-- </option>');

    }
    else{
            $.getJSON(serverUrl+api+'/'+municipio, function(data,status) {
            if(data.status==200){
                $('#caldea').html('');
                $('#caldea').append('<option value="-1">--Seleccionar--</option>');
                    $.each(data.resdato, function( key, val ) {
                        $('#caldea').append('<option  id="'+val.caldeaid+'" value="'+ val.caldeaid+'">'+ val.cdescripcion+'</option>');
                });
            }
        })
        .error(function(err) {
            error();
        })

    }

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

   // alert(data);
$('#json').html(data);
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
        headers: {
		  'Content-Type': 'application/json;charset=utf-8'
		},
        type : typeFn,
        dataType : 'json',
        success : function(data) {

 
//alert(data.status)
            if(data.status==200){
                successok(type);
                limpiaForm('form.detalledenuncia');
                 limpiaForm('form.entrevistadenunciante');
                  $('.validacion').css('display','none');
            }
    
        },
        error : function(xhr, status) {
            //xhr, status
           //error(JSON.stringify(xhr), status);
           
        }
      
    });
}

function successok(action){
  $("<div></div>").html('Se agregó correctamente').dialog({
        title: '',
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

function error(xhr, status){
    $("<div></div>").html('Ha ocurrido un error').dialog({
        title: '',
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
    $("<div></div>").html('No tiene elemento asignado').dialog({
        title: '',
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
                Cerrar: function () {
                    $(this).dialog('close');
                }
            },
            open: function () {
             
                CreateMap();
    
            
            }
        });
    });


function CreateMap(){
  var nuevos_marcadores = [];
  var formulario = $("#formulario");
  var lat=$('#lat').val();
  var lon=$('#lon').val();
  var zoom=parseInt($('#zoom').val());
  var map;
  var geocoder;
  var punto = new google.maps.LatLng(lat,lon,zoom);
  var infowindow = new google.maps.InfoWindow();

  var config = {
        zoom:zoom,
        center:punto,
        disableDefaultUI: false,
        draggable: true,
        disableDoubleClickZoom: true,
        mapTypeControl: false,
        scaleControl: true,
        scrollwheel: true,
        panControl: true,
        streetViewControl: true,
        draggable: true,
        overviewMapControl: true,
        overviewMapControlOptions: {
           opened: false,
        },
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.DEFAULT
        }
     };

  var mapa = new google.maps.Map($("#map")[0], config );
  geocoder = new google.maps.Geocoder();

  google.maps.event.addListener(mapa, "click", function(event){
      placeMarker(event.latLng);   
       //ALMACENAR UN MARCADOR EN EL ARRAY nuevos_marcadores
      nuevos_marcadores.push(marker);
       //BORRAR MARCADORES NUEVOS
         limpiar_marcadores(nuevos_marcadores);
          marker.setMap(mapa);
   });

 var marker;
        
    function placeMarker(location) {
                if(marker){ //on vérifie si le marqueur existe
                    marker.setPosition(location); //on change sa position
                }else{
                    marker = new google.maps.Marker({ //on créé le marqueur
                        position: location, 
                        map: map
                    });
                }
             
                formulario.find("input[name='lat']").val(location.lat());
                formulario.find("input[name='lon']").val(location.lng());

                $('#lat2').val(formulario.find("input[name='lat']").val());
                $('#long2').val(formulario.find("input[name='lon']").val());
                 
            
                getAddress(location);
    }

    function getAddress(latLng) {
        geocoder.geocode( {'latLng': latLng},
          function(results, status) {
              //alert(results[0].formatted_address);
            if(status == google.maps.GeocoderStatus.OK) {
              if(results[0]) {
                document.getElementById("direccion").value = results[0].formatted_address;
                $('#cdireccion_hecho').val(results[0].formatted_address);
              }
              else {
                document.getElementById("direccion").value = "No results";
                 $('#cdireccion_hecho').val("No results");
              }
            }
            else {
              document.getElementById("direccion").value = status;
               $('#cdireccion_hecho').val(status);
            }
          });
        }
        


}
 
   function codeAddress() {
         
        //obtengo la direccion del formulario
        var address = document.getElementById("direccion2").value;
        //hago la llamada al geodecoder
        geocoder.geocode( { 'address': address}, function(results, status) {
         
        //si el estado de la llamado es OK
        if (status == google.maps.GeocoderStatus.OK) {
            alert('ok');
            //centro el mapa en las coordenadas obtenidas
            map.setCenter(results[0].geometry.location);
            //coloco el marcador en dichas coordenadas
           marker.setPosition(results[0].geometry.location);
            //actualizo el formulario      
            //updatePosition(results[0].geometry.location);
             
            //Añado un listener para cuando el markador se termine de arrastrar
            //actualize el formulario con las nuevas coordenadas
            google.maps.event.addListener(marker, 'dragend', function(){
                updatePosition(marker.getPosition());
            });
      } else {
          //si no es OK devuelvo error
          alert("No podemos encontrar la direcci&oacute;n, error: " + status);
      }
    });
  }
 // Replace the _create event


var orig_create = $.ui.dialog.prototype._create;

$.ui.dialog.prototype._create = function(){
    orig_create.apply(this,arguments);
    var self = this;
    if(this.options.url!=''){
        self.element.load(self.options.url); // auto load the url selected
    };
};
  
  $.widget( "ui.dialog", $.ui.dialog, {
    refresh: function() {
        if(this.options.url!=''){
            this.element.load(this.options.url);
           
            // Other things when a dialog is reloaded
            //alert('reloaded');
            
        }
    }
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


function limpiaForm(miForm) {
    $(':input', miForm).each(function() {
            var type = this.type;
            var tag = this.tagName.toLowerCase();
            switch (type) {
                 case 'checkbox':
                     this.checked = false;
                     break;
                 case 'radio':
                     this.checked = false;
                     break;
                  default:
                     this.value = "";
                }
            
            switch (tag) {
                case 'textarea':
                this.value = "";
                break;
                case 'select':
                this.selectedIndex = 0;
                break;
                default:
                            ;//No hago nada
            }
        });//FIN EACH
}//FIN FUNCIÓN

 /*$('body').on('click','.recargar',function(e){
    e.preventDefault();
    $('#dialog').dialog("refresh");
     CreateMap();
 });*/



/*$('body').on('click','.pasar',function(e){
     e.preventDefault();
      geocoder = new google.maps.Geocoder();
 var address = "Santa Barbara";
 
 var mapOptions = {
            zoom: 14,
            center: new google.maps.LatLng(88.1121, 103.12121)
        };
 map = new google.maps.Map(document.getElementById('map'),
            mapOptions);
 //buscamos el domicilio por medio de geocoder
 geocoder.geocode({ 'address': address }, function (results, status) {
           //si el domicilio se encuentra lo ubicamos
       //no valla ser que ponen crater 1512 de Marte Sistema Solar
 
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
            }
 });
    
});*/


})
