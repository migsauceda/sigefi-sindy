<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<!-- inclusion de archivos -->
<!--controles para los campos del formulario y conexion-->
<?php 	include("../clases/controles/funct_text.php");
	include("../clases/controles/funct_select.php");	
	include("../clases/controles/funct_radio.php");
	include("../clases/controles/funct_check.php");

	include("../clases/class_conexion_pg.php");
?>
<head>
  <title>actividad fiscal</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<!--variables para cookees-->
<script type="text/javascript">
	var imputados= 1;
</script>

<!--calendario-->
    <link type="text/css" rel="stylesheet" href="../css/smoothness/jquery-ui-1.8.12.custom.css">
    <script type="text/javascript" src="../java_script/jquery-1.5.1.min.js"></script>
    <script type="text/javascript" src="../java_script/jquery-ui-1.8.12.custom.min.js"></script>
    <script type="text/javascript" src="../java_script/funciones.js"></script>


    <style type="text/css">
        .ui-datepicker {
            font-size: 11px;
            margin-left:10px
         }
    </style>
</head>
<body>

<strong><div align="center">Actividad (Niño en Riesgo)</div></strong>

<script type="text/javascript">
    $(function() {
        $( "#txtFecha" ).datepicker({
            dateFormat: 'dd / mm / yy',
            changeMonth: true,
            changeYear: true
        });
    });

    function CalDenuncia(){
        $( "#txtFecha" ).datepicker();

    }
</script>

<!--javas scripts para llenar los combos-->
<script type="text/javascript">
<!--etapa ok-->
function CargarEtapa()
{
	<?php
	$objConexion=new Conexion(); 
	$sql= "select netapaid, cdescripcion from tbl_etapa;";
	$resEtapa=$objConexion->ejecutarComando($sql);
	?>		
}
</script>

<script type="text/javascript">
<!--actividad ok-->
function Cargaractividad()
{
	<?php
	$objConexion=new Conexion(); 
	$sql= "select nactividadid, cdescripcion from tbl_actividad 
		where netapaid= 1;";
        //el uno es porke esta actividad es riesgo
	$resActividad=$objConexion->ejecutarComando($sql);
	?>		
}
</script>


<script type="text/javascript">
<!--fiscales ok-->
function CargarMateria()
{
	<?php
	$objConexion=new Conexion(); 
	$sql= "SELECT nmateria, cdescripcion FROM tbl_materia "
            ."where nmateria= 1;";
	$resMateria=$objConexion->ejecutarComando($sql);
	?>		
}
</script>

<script type="text/javascript">
<!--imputados ok-->
function CargarImputado()
{	
	<?php
	$objConexion=new Conexion(); 
	$imputados= $_COOKIE["denuncia"];
	$sql= "SELECT tpersonaid, cnombres || ' ' || capellidos as cnombrecompleto, "
            ."cesmenor "
            ."FROM tbl_ofendido where tdenunciaid= ".$imputados
            ." and cesmenor= 'r';";
	$resEnRiesgo=$objConexion->ejecutarComando($sql);
	?>
}
</script>

<script type="text/javascript">
<!--nombre fiscal -->
function CargarNombreFiscal()
{	
	<?php
	$objConexion=new Conexion(); 
	$imputado= $_POST[txtImputadoPHP];
	$sql= "select capellidos, cfiscalid from tbl_imputado_fiscal, tbl_fiscal where bactivo= '1' and " 
	."cfiscal= cfiscalid and timputadoid= ".$_POST[txtImputadoPHP].";";
	$resFiscal=$objConexion->ejecutarComando($sql);
	$registro= pg_fetch_array($resFiscal);
	
	?>	
}
</script>

<!--recargar todos los input text-->
<script type="text/javascript">
function RecargaInput()
{
	document.getElementById("txtFecha").value= "<?php echo($_POST[txtFechaPHP]);?>";
	document.getElementById("cboImputado").value= "<?php echo($_POST[txtImputadoPHP]);?>";
	document.getElementById("cboMateria").value= "<?php echo($_POST[txtMateriaPHP]);?>";
	document.getElementById("cboEtapa").value= "<?php echo($_POST[txtEtapaPHP]);?>";
	document.getElementById("cboActividad").value= "<?php echo($_POST[txtActividadPHP]);?>";

	document.getElementById("txtFiscal").value= "<?php echo($registro["capellidos"]);?>";
	document.getElementById("txtFiscalid").value= "<?php echo($_POST[txtFiscalidPHP]);?>";
	//document.getElementById("txtFiscalid").value= "<?php echo($registro["cfiscalid"]);?>";
}
</script>

<!--formulario para campos tmp al recargar pagina-->
<FORM method="POST" name="paraphp" id="paraphp" action="actividad.php?enviado=enviado">
  <INPUT type="hidden" name="txtFechaPHP" id="txtFechaPHP">
  <INPUT type="hidden" name="txtFiscalPHP" id="txtFiscalPHP">
  <INPUT type="hidden" name="txtFiscalidPHP" id="txtFiscalidPHP">
  <INPUT type="hidden" name="txtImputadoPHP" id="txtImputadoPHP">
  <INPUT type="hidden" name="txtMateriaPHP" id="txtMateriaPHP">
  <INPUT type="hidden" name="txtEtapaPHP" id="txtEtapaPHP">
  <INPUT type="hidden" name="txtActividadPHP" id="txtActividadPHP">
</FORM>

<!--llenar los campos del formulario-->
<script type="text/javascript">
<!--llena todos los combos del formulario oculto-->
function PasarFomularioPHP(){
	document.getElementById("txtFechaPHP").value= document.getElementById("txtFecha").value;			
	document.getElementById("txtMateriaPHP").value= document.getElementById("cboMateria").value;
	document.getElementById("txtEtapaPHP").value= document.getElementById("cboEtapa").value;
	document.getElementById("txtActividadPHP").value= document.getElementById("cboActividad").value;

	document.getElementById("txtImputadoPHP").value= document.getElementById("cboImputado").value;

	document.getElementById("txtFiscalidPHP").value= "<?php echo($registro["cfiscalid"]);?>";
	//document.getElementById("txtFiscalPHP").value= document.getElementById("txtFiscalid").value;
}
</script>

<script type="text/javascript">
<!--llama las funciones para llenar los campos y hace submit-->
function hacersubmit(){
	PasarFomularioPHP(); 
	document.paraphp.submit();
	CargarNombreFiscal();
}
</script>

<script type="text/javascript">
<!--llama las funciones para llenar los campos y hace submit-->
function Antesdesubmit(){
    Ok= true;
    CamposFaltantes= "";
    if (document.getElementById("txtFecha").value== "")
    {
        Ok= false;
        CamposFaltantes= "Fecha del hecho\n";
    }
    
    if (document.getElementById("txtFiscal").value== "")
    {
        Ok= false;
        CamposFaltantes= CamposFaltantes + "Imputado\n";
    }
    
    if (document.getElementById("cboMateria").value== "0")
    {
        Ok= false;
        CamposFaltantes= CamposFaltantes + "Matéria\n";
    }
    
    if (document.getElementById("cboActividad").value== "0")
    {
        Ok= false;
        CamposFaltantes= CamposFaltantes + "Actividad\n";
    }

    if (Ok== false)
    {
        alert("La siguiente información es requerida: \n"+CamposFaltantes);
    }
    return Ok;
}
</script>

<br><br>
<FORM action="procesariesgo.php" method="POST" id="frmRiesgo" onsubmit="return Antesdesubmit()">
    <table align="center" width="95%" frame="border" id="tblGenerales">
  <tbody>
    <tr>
      <td width="25%"><div align="right"><strong>Fecha en la que se hace <br>la diligencia fiscal</strong></div></td>
      <td width="20%"><?php cajaTexto("txtFecha",10);?>
      </td>
      <td width="20%"><div align="right"><strong>Fiscal que hace <br>la diligencia</strong></div></td>
      <td colspan="5">
	<?php cajaTexto("txtFiscal",25,"","readonly='true'");?>
	<INPUT type="hidden" name="txtFiscalid" id="txtFiscalid">
      </td>
    </tr>
    <tr>
      <td><div align="right"><strong>Nombre del niño en riesgo</strong></div></td>
      <td colspan="7">
	<?php
		combo("cboImputado",$resEnRiesgo,"tpersonaid","cnombrecompleto","1","onchange='hacersubmit()')");
	?>      
      </td>
    </tr>
  </tbody>
</table>
<br>
<table align="center" width="95%" frame="box" id="tblActividad">
    <tbody>
        <!--materia -->
        <tr>
            <td width="25%">
            <div align="right"><strong>Materia</strong></div>
          </td>
          <td>
            <?php
                    combo("cboMateria",$resMateria,"nmateria","cdescripcion");
            ?>
          </td>
        </tr>
        <!--etapa -->
<!--        <tr>
          <td>
            <div align="right"><strong>Etapa</strong></div>
          </td>
          <td>
            <?php
                    combo("cboEtapa",$resEtapa,"netapaid","cdescripcion","","onchange='hacersubmit()')");
            ?>
          </td>
        </tr>
         <!--actividad -->
       <tr>
          <td>
            <div align="right"><strong>Actividad</strong></div>
          </td>
          <td>
            <?php
                    combo("cboActividad",$resActividad,"nactividadid","cdescripcion");
            ?>
          </td>
        </tr>
        <!--actividad 2 -->
        <tr>
          <td>
            <div align="right"><strong>Actividad 2</strong></div>
          </td>
          <td>
            <?php
                    combo("cboActividad2",$resActividad,"nactividadid","cdescripcion");
            ?>
          </td>
        </tr>
    </tbody>
</table>

<br>
<table align="center">
  <tbody>
    <tr>
      <td><INPUT type="submit" name="btnSubmit" value="Guardar datos"></td>
      <td><INPUT type="reset" name="btnReset" value="Limpiar campos"></td>
    </tr>
  </tbody>
</table>
</FORM>


<!--carga la pagina y se envio el depto-->
<?php
	if (isset($_GET["enviado"]))
	if (($_GET["enviado"]== "enviado"))
	{
?>
	<script type="text/javascript">
		RecargaInput();
	</script>
<?php
	}
?>
</body>
</html>
