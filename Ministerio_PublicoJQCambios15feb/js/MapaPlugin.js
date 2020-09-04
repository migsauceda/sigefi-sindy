
//llamar el mapa
$(document).ready(function(){
$('body').on('click','.openmap',function(e){
  //alert();
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
             
                CreateMapPlugin();
    
            
            }
        });
    });
function limpiar_marcadores(lista){
        for(i in lista)
        {
            //QUITAR MARCADOR DEL MAPA
            lista[i].setMap(null);
        }
    }

function CreateMapPlugin(){
  var nuevos_marcadores = [];
  var formulario = $("#formulario");

  //var lat=$('#lat').val();
  //var lon=$('#lon').val();
  //var zoom=parseInt($('#zoom').val());
  var map;
  var geocoder;
  var punto = new google.maps.LatLng(14.908915, -87.020259,8);
  var infowindow = new google.maps.InfoWindow();

  var config = {
        zoom:8,
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

})



/***********agregar siguientes librerias****************/


/******************hojas de estilo necesias*************************/

/*****************
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="dist/css/bootstrap.min.css"> 
 ***************** */

/************librerias Javascript necesarias
 * Api de Google Maps
  <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAUoy7VrZcmEqINM0dOskZtQTym20qqRk4"></script>
  
  <script src="js/jquery-1.12.4.min.js"></script>
  <script src="js/jquery-ui.min.js"></script>

*Fuciones que hacen el llamdo al APi de google Maps
  <script src="js/MapaPlugin.js"></script>
 **************** */





/*********Agregar contenido(necesario para desplegar el mapa en el popup)en el html******************* */
/*
   <button type="button" class="btn-primary  openmap"  id="moda" data-toggle="modal" >Ubicar Hecho</button>
                    <div id="dialog" style="display: none">
                            <div id="map" style="width:100%;height:500px"></div>
                                <form id="formulario" class="mapa">
                                    <label for="descripcion">Descripción</label>
                                    <input type="text" class="form-control textarea"   name="descripcion"  id="descripcion" autocomplete="off"/>
                                    <label for="direccion">Dirección</label>
                                    <input type="text" class="form-control" readonly name="direccion" id="direccion" autocomplete="off"/>
                                    <label for="lat">Lat</label>
                                    <input type="text" class="form-control" readonly  name="lat" id="lat" autocomplete="off"/>
                                    <label for="lon">lon</label>
                                <input type="text" class="form-control"  readonly name="lon" id="lon" autocomplete="off"/><br>
                                </form>

                    </div> 
*/ 