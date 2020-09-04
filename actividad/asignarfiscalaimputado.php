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
  <title>Asignar Fiscal</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link type="text/css" rel="stylesheet" href="../css/Estilos.css"> 
    <script type="text/javascript" src="../java_script/funciones.js"></script>

    <!-- jquery -->
    <link href="../java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
    <script src="../java_script/js/jquery-1.10.2.js"></script>
    <script src="../java_script/js/jquery-ui-1.10.4.custom.js"></script>
              

    <style type="text/css">
        .ui-datepicker {
            font-size: 11px;
            margin-left:10px
         }
    </style>

<script type="text/javascript">
//variables globales para codigo de fiscal y fiscalia repectivamente
    var CodFiscal;
    var CodFiscalia;
</script>

<script type="text/javascript">
//agrega fiscal y fiscalia actualmente asignados
    $(document).ready(function(){
    $("#cboImputado").change(function(){
        $.ajax({
            data: "accion=Recuperar&Imputado="+$("#cboImputado").attr("value"),
            type: "POST",
            dataType: "json",
            url: "procesaasignarfiscalaimputado.php",
            success: function(data){
                $("#FiscaliaActual").attr("value",data.DesFiscalia);
                $("#FiscalActual").attr("value",data.DesFiscal);
                CodFiscal= data.CodFiscal;
                CodFiscalia= data.CodFiscalia;
                //siguiente ajax llena combo fiscales por fiscalia ya asignada
                $.ajax({
                  data: "accion=Fiscales&Fiscalia="+CodFiscalia,
                  type: "POST",
                  dataType: "html",
                  url: "procesaasignarfiscalaimputado.php",
                  success: function(data){
                      $("#CodFiscalActual").attr("value",CodFiscal);
                      $("#cboFiscalN").html(data);
                  }
               });
            }
        });
    });
    });
</script>

</head>
<body >

<script type="text/javascript">
    $(function() {
        $( "#txtFechaAsignacion" ).datepicker({
            dateFormat: 'dd / mm / yy',
            changeMonth: true,
            changeYear: true
        });
    });

    function CalDenuncia(){
        $( "#txtFechaAsignacion" ).datepicker();

    }
</script>
    
<script type="text/javascript">
<!--imputados-->
function CargarImputado()
{	
	<?php
	$objConexion=new Conexion(); 
	$imputados= $_COOKIE["denuncia"];
	$sql= "SELECT tpersonaid, cnombres || ' ' || capellidos as nombrecompleto FROM tbl_imputado "
	."where tdenunciaid= ".$imputados.";";
	$resImputado=$objConexion->ejecutarComando($sql);
	?>        
}
</script>

<!--carga la pagina y se envio el depto-->
<?php
	if (!$_POST)
        {
?>
<br><br>
<FORM action="procesaasignarfiscalaimputado.php" method="POST" id="frmAsignar">
<Table align="center" width="50%" border="1">
    <TR><TD colspan="2" align="center"><strong>Asignación de Fiscal por Imputado</strong></TD>
    </TR>
    <tr><td colspan="2"></td></tr>
    <tr>
        <TD width="30%"><strong>Fecha asignación</strong></TD>
    <TD><?php cajaTexto("txtFechaAsignacion",10);?>
    </TD>
    </tr>
    <tr><TD><strong>Imputado</strong></TD>
    <TD>
            <?php
                    combo("cboImputado",$resImputado,"tpersonaid","nombrecompleto");
            ?>
    </TD>
    </tr>
    <tr><td colspan="2"><br></td></tr>
    <tr>
    <TD><strong>Fiscalia Actual</strong></TD>
    <TD>
       <!-- <p id='FiscaliaActual'>Fiscalia Actual</p> -->
        <input type="hidden" name="CodFiscaliaActual" id="CodFiscaliaActual">
        <input type="text" id="FiscaliaActual" readonly="true" size="40">
    </TD>
    </tr>

    <tr>
    <TD><strong>Fiscal Actual</strong></TD>
    <TD>
        <!-- <p id='FiscalActual' style="0">Fiscal Actual</p> -->
        <input type="hidden" id="CodFiscalActual" name="CodFiscalActual">
        <input type="text" id="FiscalActual" readonly="true" size="40" >
    </TD>
    </tr>
    <tr><td colspan="2"><br></td></tr>
    <tr>
    <TD><strong>Nuevo Fiscal</strong></TD>
    <TD>
        <select id="cboFiscalN" name="cboFiscalN">
        <option value=-1>Seleccione opción...</option>
        </select>
    </TD>
    </tr>
</Table>

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
<?php
} //cierra el if del isset(!$_POST)
else {

}
?>



</body>
</html>
