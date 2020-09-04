<?php
session_start();
?>
<html>
    
<head>
  <title></title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link href="favicon.ico" type="image/x-icon" rel="shortcut icon" />
</head>

<body>
<!--banner horizonatal-->
<table align="center" border="0">
  <tbody>
    <tr>
    <tr align="center">
      <TD></TD>	
      <TD><IMG src="./imagenes/LogoMPSI2.png" alt="LogoMP" width="260" height="90" align="middle" border="0"></TD>
      <td width="160"></td>
      <td><h1>SISTEMA DE EXPEDIENTES</h1></td>
    </tr>        
    </tr>
  </tbody>
</table>


<!--si ya ha hecho intentos de inciar sesion, la funcion autenticar del
archivo php_funciones llama nuevamente a esta pagina index.php-->
<?php 
	if (isset($_SESSION['valido']))
	{           
		if($_SESSION['valido']== 0)
		{
		echo
		"<script>
			alert('Combinación de Usuario y Contraseña NO válidos');
		</script>";
		}
                
                unset($_SESSION["valido"]);
	}   
?>

<!--ingresar login y password ya sea por primera vez o en reintentos -->
<br><br>
<form name="frmPasswd" action="./funciones/ajax_llamar_funciones.php?Parametro=autenticar" method="POST"> 
<input type="hidden" name="txtAutenticar" id="txtAutenticar">
<script type="text/javascript">
	document.getElementById("txtAutenticar").value= "autenticar";
</script>
<hr align="center" width="90%">
<br>
  <table align="center" id="tblloginid">
  <tbody>
    <tr>
      <td><div align="right"><strong>Usuario:</strong></div></td>
      <td><INPUT type="text" name="txtUsr" size="20" maxlength="20" id="txtUsr"></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Contraseña:</strong></div></td>
      <td><INPUT type="password" name="txtPasswd" size="20" maxlength="50" id="txtPasswd"></td>
    </tr>
  </tbody>
</table>
<br><br>

<table id="botones" align="center">
  <tbody>
    <tr>
      <td>
          <!-- <INPUT type="button" name="btnAcceder" value="Acceder" onClick="Autenticar();"> -->
          <INPUT type="submit" name="btnAcceder" value="Acceder" id="btnAcceder">
      </td>
      <td></td>
    </tr>
  </tbody>
</table>
</form>
<center><a href="/Tutoriales">Tutoriales</a></center>
</body>
</html>