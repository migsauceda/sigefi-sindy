<?php
session_start();
$_SESSION['valido']=0;
if (isset($_SESSION['valido']))
{
?>
<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="utf-8" />
        <title>Ministerio Publico</title>
        <link href="css/layout.css" rel="stylesheet" type="text/css" />
        <link href="css/menu.css" rel="stylesheet" type="text/css" />
         <link rel="stylesheet" href="css/jquery-ui.css">
         <link rel="stylesheet" href="dist/css/bootstrap.min.css">
         <link rel="stylesheet" href="css/jquery.dataTables.min.css">
         <link rel="stylesheet" href="css/validacion.css" >
         <link rel="stylesheet" href="css/wickedpicker.min.css" >
         <link rel="stylesheet" href="css/buttons.dataTables.min.css" >
      
  <link rel="stylesheet" type="text/css" href="css/jquery.timepicker.css" />
  <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
         
    </head>
    <body>
      <header>

           
        </header><br>
<br>
        <div class="container">
            <div id="menu"></div>
        </div>
        <div class="container">
             
            
 
           <div id="container-tab">
               
           </div>
           
      
        </div>


    </body>

   <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAUoy7VrZcmEqINM0dOskZtQTym20qqRk4"></script>

     <script src="js/jquery-1.6.min.js"></script>
     <script src="js/jquery-1.12.4.min.js"></script>
     <script src="js/bootstrap.min.js"></script>
     <script type="text/javascript" src="js/jquery.timepicker.js"></script>
     <script src="js/jquery-ui.min.js"></script>
     
     <script src="js/jquery.dataTables.min.js"></script>
     <script src="js/wickedpicker.min.js"></script>
   
    
       
     <script src="js/main.js"></script>
     <script src="app/principal/principal.js"></script>
     <!--<script src="app/principal/denuncias.js"></script>-->
     <script src="app/reportes/actividadFiscal/actividadfiscal.js"></script>
     <script src="app/reportes/confirmaciondenuncia/confirmaciondenuncia.js"></script>
     <!--<script src="app/reportes/frecuenciaDenunciaDelito/frecuenciadelito.js"></script>-->

<script type="text/javascript" language="javascript" src="js/dataTables.buttons.min.js"></script>
<script src="js/buttons.html5.min.js"></script>
<script src="js/jszip.min.js"></script>


   


    <!-- <script src="app/reportes/estadoexpediente/estadoexpediente.js"></script>
     <script src="app/reportes/fiscalasignado/fiscalasignado.js"></script>-->
     <!--<script src="app/reportes/vaciadodenuncia/vaciadodenuncia.js"></script>-->

  
</div>

         
</html>
<?php
}
else
{
	echo '<script>location.href = "error.html"</script>';
}
