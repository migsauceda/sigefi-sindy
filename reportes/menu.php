<!DOCTYPE html>
<html>
<head>
<title>
</title>
</head>
<body>
<br>
<br>
<div style = border= 1 width= "50%" align="left" >
<form method="GET" action="buscarimputado.php">
<fieldset>
<label class="radio-inline" border-radius:0;>
<input type="radio" name="radiob" value="rdenunciado">Busca Denunciado
<input type="radio" name="radiob" value="rdenunciante">Busca Denunciante
<input type="radio" name="radiob" value="rofendido">Busca Ofendido
</label> <br>
<br>
N* DENUNCIA:
<input type="text" id="denuncia" name="denuncia" size="20" >
<label class="radio-inline"></label><br></br>
<fieldset>
<legend>Busqueda</legend>
N* Policial:
<input type="text" id="policial" name="policial" size="20" >
<label class="radio-inline"></label>
N* Identidad:
<input type="text" id="identidad" name="identidad" size="20" >
<label class="radio-inline"></label><br></br>
NOMBRE:
<input type="text" id="nombre" name="nombre" size="20" >
<label class="radio-inline"></label>
APELLIDO:
<input type="text" id="apellido" name="apellido" size="20" >
<label class="radio-inline"></label> <br></br>
</fieldset><br>
<center> <input type="submit" name="buscar" value="Buscar"></center>
</fieldset>
</form>
</div>
</body>
</html>


