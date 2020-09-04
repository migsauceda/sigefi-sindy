<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php

?>
<html>

<head>
  <title>Administrador Denuncias</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <script type="text/javascript" src="java_script/funciones.js"></script>
  
        <!-- jquery -->
	<link href="java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
	<script src="java_script/js/jquery-1.10.2.js"></script>
	<script src="java_script/js/jquery-ui-1.10.4.custom.js"></script>  

</head>
<body>
        
<!--banner horizonatal-->
<table align="center" border="0">
  <tbody>
    <tr>
      <TD width="0"></TD>	
      <td><IMG src="./imagenes/LogoMP2.bmp" alt="LogoMP" width="171" height="125" align="left" border="0"></td>
      <TD width="200" align="center"></TD>	
      <td><h1>Administrador Sistema de Denuncias</h1></td>
     <TD width="120"></TD>	
    </tr>
  </tbody>
</table>

<br>

<div id="opciones">
	<h3>Administrar usuarios</h3>
        <div><iframe src="./administracion/AdmonUsr.php" frameborder="1" align="center" width="1150"  height="1050" scrolling="auto" ></iframe>
	</div>

<!--        <h3>Modificar </h3>
        <div><iframe src="./administracion/AdmonDerechos.php" frameborder="1" align="center" width="1150"  height="750" scrolling="auto" ></iframe>
	</div>-->
        
	<h3>Agregar tareas a roles</h3>
        <div><iframe src="./administracion/AdmonDerechos.php" frameborder="1" align="center" width="1150"  height="350" scrolling="auto" ></iframe>
	</div>
        
	<h3>Administrar bandejas</h3>
        <div><iframe src="./administracion/AdmonBandejas.php" frameborder="1" align="center" width="1350"  height="650" scrolling="auto" ></iframe>
	</div>        

<!--	<h3>Cambiar clave de acceso de un usuario en particular</h3>
	<div><iframe src="./administracion/CambiarClave.php" frameborder="1" align="center" width="1150"  height="750" scrolling="no" ></iframe>
	</div>-->
</div>


<script>
$( "#opciones" ).accordion({collapsible: true});
$( "#opciones" ).accordion({active: true});
</script>

</body>
<script type="text/javascript">
    var clave= prompt("Ingese clave de acceso: ","");
    Ok= 1;
    if (!Ok){
//        alert("1");
    }
    else{
//        alert("2");
    }
</script>  
</html>
