<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
  <title>Administrador Denuncias</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <link type="text/css" rel="stylesheet" href="css/smoothness/jquery-ui-1.8.12.custom.css"> 
  <script type="text/javascript" src="java_script/jquery-1.5.1.min.js"></script>
  <script type="text/javascript" src="java_script/jquery-ui-1.8.12.custom.min.js"></script>
  <script type="text/javascript" src="java_script/funciones.js"></script>

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
	<h3>Crear usuarios</h3>
	<div><iframe src="./administracion/AdmonUsr.php" frameborder="1" align="center" width="1150"  height="400" scrolling="no" ></iframe>
	</div>

	<h3>Agregar tareas a roles</h3>
	<div><iframe src="./administracion/AdmonDerechos.php" frameborder="1" align="center" width="1150"  height="400" scrolling="no" ></iframe>
	</div>

	<h3>Cambiar clave de acceso de un usuario en particular</h3>
	<div><iframe src="./administracion/CambiarClave.php" frameborder="1" align="center" width="1150"  height="400" scrolling="no" ></iframe>
	</div>
</div>


<script>
$( "#opciones" ).accordion({collapsible: true});
$( "#opciones" ).accordion({active: true});
</script>

</body>
</html>
