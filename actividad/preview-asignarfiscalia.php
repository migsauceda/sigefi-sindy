<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<!-- inclusion de archivos -->
<!--controles para los campos del formulario y conexion-->
<?php 	include("../clases/controles/funct_text.php");
	include("../clases/controles/funct_select.php");	
	include("../clases/controles/funct_radio.php");
	include("../clases/controles/funct_check.php");

	include("../clases/class_conexion_pg.php");

	//funciones genericas
	include "../funciones/php_funciones.php";        
?>
<head>
  <title>Asignar Fiscalia</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

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

<script type="text/javascript">
//saber fiscalia asignada, si es el caso
//    $(document).ready(function(){
//    $("#cboImputado").change(function(){
//        alert("jquery");
//        $.ajax({
//            data: "accion=Fiscalia&Imputado="+$("#cboImputado").attr("value"),
//            type: "POST",
//            dataType: "json",
//            url: "procesaasignarfiscalia.php",
//            success: function(data){
//                $("#FiscaliaActual").attr("value",data.DesFiscalia);
//            }
//        });
//    });
//    });
</script>

</head>

<body >

<script type="text/javascript">
    $(function() {
        $( "#txtFechaAsignacion" ).datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true
        });
    });

    function CalDenuncia(){
        $( "#txtFechaAsignacion" ).datepicker();
    }
</script>
 
<br><br>
<FORM action="procesaasignarfiscalia.php" method="POST" id="frmAsignar" onsubmit="return Antesdesubmit()">
    <!--campos ocultos para numero de denuncia y numero actual de fiscalia -->
    <input type="hidden" id='CodFiscaliaActual' name="CodFiscaliaActual">
    <input type="hidden" id='DenunciaId' name="DenunciaId">
<table>
  <tbody>
    <TR><TD colspan="2" align="center"><strong>Asignación de Fiscalía por123 Imputado</strong></TD></TR>
    <tr>
      <td>Fecha de asignación</td>
      <td><?php cajaTexto("txtFechaAsignacion",10);?></td>
    </tr>
    <tr>
      <td>Imputado/Niño Infractor</td>
      <td>Fiscalía a asignar</td>
    </tr>
    <?php
	$resDenunciado= CargarDenunciados($_GET['id']);	
	while ($registro= pg_fetch_array($resDenunciado)){
		echo "<tr>";
		echo "<td></td>";
		echo "<td></td>";
	}
	echo "</tr>";
//            $resFiscaliaN= CargarFiscalia();
//            combo("cboFiscaliaN",$resFiscaliaN,"nfiscaliaid","cdescripcion","","");
    ?>
  </tbody>
</table>
</FORM>

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
    <script type="text/javascript">        
        document.getElementById("CodFiscaliaActual").value= "123";
        document.getElementById("DenunciaId").value= <?php echo $_GET['id']; ?>;
    </script>
</body>
</html>
