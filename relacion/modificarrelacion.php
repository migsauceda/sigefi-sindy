<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
  <title>Relaciones</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <link type="text/css" rel="stylesheet" href="../css/Estilos.css"> 
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<!--variables para contar filas de alias y delitos-->
<script type="text/javascript">
	var Denunciante= 2;
	var Ofendido= 2;
	var Contador= 0;
	var Actual= 0;
</script>
</head>

<!-- inclusion de archivos -->
<!--controles para los campos del formulario y conexion-->
<?php 	
	include("../clases/controles/funct_text.php");
	include("../clases/controles/funct_select.php");	
	include("../clases/controles/funct_radio.php");
	include("../clases/controles/funct_check.php");

	include("../clases/class_conexion_pg.php");
?>
<body>

<p><div align="center"><strong>Relaciones</strong></div></p>
<br><br>

<!--script para llenar tablas-->
<!--javas scripts para llenar los combos-->
<script type="text/javascript">
<!--nacionalidad-->
function CargarImputado()
{
	<?php
	$objConexion=new Conexion(); 
	$sql= "select tpersonaid, cnombres || ' ' || capellidos as nombrecompleto "
		."from tbl_imputado where tdenunciaid= ".$_GET["denunciaid"].";";
	$resImputado=$objConexion->ejecutarComando($sql);
	?>		
}
</script>

<script type="text/javascript">
<!--nacionalidad-->
function CargarDenunciante()
{
	<?php
	$objConexion=new Conexion(); 
	$sql= "select tpersonaid, cnombres || ' ' || capellidos as nombrecompleto "
		."from tbl_denunciante where tdenunciaid= ".$_GET["denunciaid"].";";
	$resDenunciante=$objConexion->ejecutarComando($sql);
	?>		
}
</script>

<script type="text/javascript">
<!--nacionalidad-->
function CargarOfendido()
{
	<?php
	$objConexion=new Conexion(); 
	$sql= "select tpersonaid, cnombres || ' ' || capellidos as nombrecompleto "
		."from tbl_ofendido where tdenunciaid= ".$_GET["denunciaid"].";";
	$resOfendido=$objConexion->ejecutarComando($sql);
	?>		
}
</script>

<script type="text/javascript">
<!--nacionalidad-->
function CargarParentesco()
{
	<?php
	$objConexion=new Conexion(); 
	$sql= "select nparentescoid, cdescripcion, creciproco from tbl_parentescos;";
	$resParentescos=$objConexion->ejecutarComando($sql);
	?>		
}
</script>

<script type="text/javascript">
<!--nacionalidad-->
function CargarParentesco2()
{
	<?php
	$objConexion=new Conexion(); 
	$sql= "select nparentescoid, cdescripcion, creciproco from tbl_parentescos;";
	$resParentescos2=$objConexion->ejecutarComando($sql);
	?>		
}
</script>

<!--saber cuantos-->
<script type="text/javascript">
function CopiarParentesco()
{
	document.getElementById("txtcontadordenunciante").value= Denunciante;
	document.getElementById("txtcontadorofendido").value= Ofendido;
	return true;

}
</script>

<form name="frmRelaciones" id="frmRelaciones" action="procesarelaciones" method="POST" onsubmit="return CopiarParentesco();">

	<!--agregar filas a las tablas-->
	<script type="text/javascript">
	function AgregarFila()
	{ 
	
		Contador= 1;
		//Denunciante++;
		//Contador= Denunciante;		

		<?php 
		while ($fila=pg_fetch_array($resDenunciante)){?>		
			//id del denunciante
			var fil=document.getElementById("tblDenunciante").insertRow(++Contador);
	
			col= document.createElement("td"); 
			col.width="5%";
			txt1= document.createElement("input");
			txt1.type= "text";
			txt1.name= "denid"+Contador;
			txt1.id= "denid"+Contador;
			txt1.size= 1;
	
			txt1.value= "<?php echo($fila[tpersonaid]);?>"
	
			col.appendChild(txt1); 
			fil.appendChild(col);
	
			//nombre del denunciante
			//col= document.createElement("td"); 
			//col.width="5%";
			txt1= document.createElement("input");
			txt1.type= "text";
			txt1.name= "dennombre"+Contador;
			txt1.id= "dennombre"+Contador;
			txt1.size= 25;
			txt1.value= "<?php echo($fila[nombrecompleto]);?>"
	
			col.appendChild(txt1); 
			fil.appendChild(col);
	
			//lista de parentescos
			col= document.createElement("td"); 
			txt1= document.createElement("select");
			txt1.name= "parent"; //+Contador;
			txt1.id= "parent"; //+Contador;
	
			<?php 
			while ($fila2=pg_fetch_array($resParentescos)){?>
				opt= document.createElement("option");
				opt.text=  "<?php echo($fila2[cdescripcion]);?>"
				opt.id= "opcion"; //+Contador;
				opt.value= "<?php echo($fila2[nparentescoid]);?>"
	
				try{
					txt1.add(opt,null);
				}
				catch(e)
				{
					txt1.add(opt);
				}
			<?php
			} 		
			?>
			col.appendChild(txt1);
			fil.appendChild(col);
		<?php
		} 		
		?>
		Denunciante= Contador;
		//fin while 	
	
	
		//para agrgar en ofendido
		Contador= 1;
	
		<?php 
		while ($fila3=pg_fetch_array($resOfendido)){?>
			//id del ofendido
			var fil2=document.getElementById("tblOfendido").insertRow(++Contador);
	
			col2= document.createElement("td"); 
			col2.width="5%";
			txt12= document.createElement("input");
			txt12.type= "text";
			txt12.name= "ofenid"+Contador;
			txt12.id= "ofenid"+Contador;
			txt12.size= 1;
	
			txt12.value= "<?php echo($fila3[tpersonaid]);?>"
	
			col2.appendChild(txt12); 
			fil2.appendChild(col2);
	
			//nombre del ofendido
			txt12= document.createElement("input");
			txt12.type= "text";
			txt12.name= "ofennombre"+Contador;
			txt12.id= "ofennombre"+Contador;
			txt12.size= 25;
			txt12.value= "<?php echo($fila3[nombrecompleto]);?>"
	
			col2.appendChild(txt12); 
			fil2.appendChild(col2);
	
			//lista de parentescos
			col2= document.createElement("td"); 
			txt12= document.createElement("select");
			txt12.name= "parentofen"+Contador;
			txt12.id= "parentofen"+Contador;
	
			<?php 
			while ($fila4=pg_fetch_array($resParentescos2)){?>
				opt= document.createElement("option");
				opt.text=  "<?php echo($fila4[cdescripcion]);?>"
				opt.id= "opcionofen"; //+Contador;
				opt.value= "<?php echo($fila4[nparentescoid]);?>"
	
				try{
					txt12.add(opt,null);
				}
				catch(e)
				{
					txt12.add(opt);
				}
			<?php
			} 		
			?>
	
			col2.appendChild(txt12);
			fil2.appendChild(col2);
		<?php
		} 		
		?>
		Ofendido= Contador;

		//fin while 
	}
	</script>	

	<input type="hidden" name="txtcontadordenunciante" id="txtcontadordenunciante">
	<input type="hidden" name="txtcontadorofendido" id="txtcontadorofendido">
     
        
	<table id="tblRelacion1" name="tblRelacion1" align="center" border="0"
               width="95%" class="TablaCaja">
	<tbody>
	<tr class="Grid">
	<td >La relación entre el <strong>denunciado: </strong>
	<?php
		combo("cboImputado",$resImputado,"tpersonaid","nombrecompleto","","onchange='AgregarFila(\"tblDenunciante\")';");
	?>
        <br>
        y el <strong>denunciante: </strong>
        <?php
		combo("cboImputado",$resImputado,"tpersonaid","nombrecompleto","","onchange='AgregarFila(\"tblDenunciante\")';");
	?>
        es de:
        <?php
		combo("cboImputado",$resImputado,"tpersonaid","nombrecompleto","","onchange='AgregarFila(\"tblDenunciante\")';");
	?>        
	</td>
	</tr>
	</tbody>
	</table>

	<br>
	<table align="center">
	<TR><TD><input type="submit" value="Guardar"></TD>
	</TR>
	</table>
</form>


</body>
</html>
