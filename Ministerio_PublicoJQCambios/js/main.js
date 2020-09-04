
$(document).ready(function(){



//var serverUrl='http://localhost:1080/Ministerio_PublicoJQcambios/backend/api/';
    $('#menu').load('app/html/header.html');
    //$('#menu-tarjetas').load('app/html/tarjeta-superior.html');
    //$('#container-tab').load('app/principal/principal.php');

//$('#container-tab').load('app/reportes/actividadFiscal/actividadfiscal.php');
    //

    // $('#container-tab').load('app/reportes/reportes.tpl.html');
    //$("#tabs").tabs();

    /*$('a').on('click','prueba1',function(){
        e.preventDefault();
        alert();

    });*/


$('#regresar').click(function(){
    //alert();
    // e.preventDefault();
    //$('#container-tab').load('app/principal/principal.php');
    location.href = "index.php";
     
   // return false;
});

$('body').on('click','.preentrevista',function(e){
    e.preventDefault();
    location.reload();
    return false;
 });
$('body').on('click','.actividadfiscal',function(e){
    e.preventDefault();
    $('#container-tab').load('app/reportes/actividadFiscal/actividadfiscal.php');
    return false;
 });

$('body').on('click','.estadoexpediente',function(e){
    e.preventDefault();
    $('#container-tab').load('app/reportes/confirmaciondenuncia/confirmaciondenuncia.php');
    return false;
 

 });

 $('body').on('click','.confirmaciondenuncia',function(e){
    e.preventDefault();
    $('#container-tab').load('app/reportes/confirmaciondenuncia/confirmaciondenuncia.php');
    return false;
 });

 $('body').on('click','.fiscalasignado',function(e){
    e.preventDefault();
    $('#container-tab').load('app/reportes/fiscalasignado/fiscalasignado.php');
    return false;
 });

 $('body').on('click','.vaciadodenuncia',function(e){
    e.preventDefault();
    $('#container-tab').load('app/reportes/vaciadodenuncia/vaciadodenuncia.php');
    return false;
 });

 
 $('body').on('click','.fiscaljefe',function(e){
    e.preventDefault();
    $('#container-tab').load('app/reportes/FiscalJefe/fiscaljefe.php');
    return false;
 });

 
 $('body').on('click','.reportepersonal',function(e){
    e.preventDefault();
    $('#container-tab').load('app/reportes/ReportePersonal/reportepersona.php');
    return false;
 });

$('body').on('click','.freReReci',function(e){
    e.preventDefault();
    $('#container-tab').load('app/reportes/frecuenciaDenunciaDelito/frecuenciaDenunciaDelito.php');
    return false;
 });
$('body').on('click','.freReRecimes',function(e){
    e.preventDefault();
    $('#container-tab').load('app/reportes/frecuenciaDenunciaDepto/frecuenciadenunciadepto.php');
    return false;
 });
 

$('body').on('click','.freReRecidia',function(e){
    e.preventDefault();
    $('#container-tab').load('app/reportes/frecuenciaDenunciaDia/frecuenciadenunciadia.php');
    return false;
 });


 $('body').on('click','.freReimputado',function(e){
    e.preventDefault();
    $('#container-tab').load('app/reportes/frecuenciaImputado/frecuenciaimputado.php');
    return false;
 });

 $('body').on('click','.freGestion',function(e){
    e.preventDefault();
    $('#container-tab').load('app/reportes/frecuenciaGestion/frecuenciagestion.php');
    return false;
 });

  $('body').on('click','.freetapas',function(e){
    e.preventDefault();
    $('#container-tab').load('app/reportes/frecuenciaetapas/frecuenciaetapas.php');
    return false;
 });

  $('body').on('click','.freSubetapas',function(e){
    e.preventDefault();
    $('#container-tab').load('app/reportes/frecuenciasubetapas/frecuenciasubetapa.php');
    return false;
 });

 $('body').on('click','.vaciadogestinofiscal',function(e){
    e.preventDefault();
    $('#container-tab').load('app/reportes/VaciadoGetionFiscal/vaciadogestionfiscal.php');
    return false;
 });

 function soloNumeros(e) 
{ 
    alert();
   /* var key = window.Event ? e.which : e.keyCode ;
    return ((key >= 48 && key <= 57) || (key==8)) ;*/
};

 //$(".solonumero").keypress(function(){
     var cont=0;
$('body').on('keypress','.solonumero',function(e){
    
       var key = window.Event ? e.which : e.keyCode ;
       return ((key >= 48 && key <= 57) || (key==8)) ;

  /* var length=$(this).attr('maxlength');
    //alert(length);
    if(cont<=length){
         
       
         
    }
    else{
        alert('tamaño sobrepasa el maximo');
    }
    
    alert(cont);*/
   
});

$('body').on('keypress','.sololetras',function(e){
     key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }

       // alert();

        text=$(this).val();
        text= text.replace(/\s+/gi,' ');

        $(this).val(text);

        //text=text.replace(/\s+/gi,' ');
        //alert(text);
        
});

$('body').on('keypress','.textarea',function(e){
    

        text=$(this).val();
        text= text.replace(/\s+/gi,' ');

        $(this).val(text);

        //text=text.replace(/\s+/gi,' ');
        //alert(text);
        
});


$('body').on('keypress','.inicialesmayuscula',function(e){
    
text=$(this).val();
$(this).val(ucWords(text));   
});


$('body').on('keypress','.primeramayuscula',function(e){
    
text=$(this).val();
$(this).val(MaysPrimera(text));   
});


});

$(document).ready(function() {
        $('.sololetras').blur(function() {
        var value = $.trim( $(this).val() );
        $(this).val( value );
       // alert();
        });
});

function ucWords(string){
 
   var arrayWords;
   var returnString = "";
   var len;
   
   arrayWords = string.split(" ");
   len = arrayWords.length;

    for(i=0;i < len ;i++){
        if(i != (len-1)){
        returnString = returnString+ucFirst(arrayWords[i])+" ";
            }
        else{
                returnString = returnString+ucFirst(arrayWords[i]);
            }
        }
        return returnString;
}
function ucFirst(string){
 return string.substr(0,1).toUpperCase()+string.substr(1,string.length).toLowerCase();
}

function MaysPrimera(string){
  return string.charAt(0).toUpperCase() + string.slice(1);
}