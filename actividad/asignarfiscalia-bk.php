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
    
    function Imputados(denuncia, destino){
        CargarImputado(denuncia);
//        alert(destino);
    }
</script>
 
<br><br>
<FORM action="procesaasignarfiscalia.php" method="POST" id="frmAsignar" onsubmit="return Antesdesubmit()">
<Table align="center" width="60%" border="1">
<TR><TD colspan="2" align="center"><strong>Asignación de Fiscalía por Imputado</strong></TD>
</TR>
<tr><td colspan="2"></td></tr>
<tr>
    <TD width="30%"><strong>Fecha asignación</strong></TD>
<TD><?php cajaTexto("txtFechaAsignacion",10);?>
</TD>
</tr>
<tr><TD><strong>Imputado / Niño infractor</strong></TD>
<TD>
    <?php
        $resDenunciado= CargarDenunciados($_GET['id']);
        combo("cboDenunciado",$resDenunciado,"personaid","nombrecompleto","","");
    ?>    
    
    <span id="Imputado" </span>
</TD>
</tr>
<tr><td colspan="2"><br></td></tr>
<tr>
<TD><strong>Fiscalia a actual</strong></TD>
<TD>
   <!-- <p id='FiscaliaActual'>Fiscalia Actual</p> -->
    <input type="hidden" id="CodFiscaliaActual">
    <input type="text" id="FiscaliaActual" readonly="true" size="40">
    <script type="text/javascript">
            //document.getElementById("FiscaliaActual").innerHTML=
            //"<?php echo($NombreFiscaliaA);?>"
            document.getElementById("FiscaliaActual").value=
                "<?php echo($NombreFiscaliaA);?>"

            document.getElementById("CodFiscaliaActual").value= 
                "<?php echo($CodNombreFiscaliaA);?>"
    </script>
</TD>
</tr>

<tr><td colspan="2"><br></td></tr>
</TD><TD><strong>Fiscalia Nueva</strong></TD>
<TD>	
        <?php
            $resFiscaliaN= CargarFiscalia();
            combo("cboFiscaliaN",$resFiscaliaN,"nfiscaliaid","cdescripcion","","");
	?>
</TD>
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
    <script type="text/javascript">
        DenunciaId= <?php echo $_GET['id']; ?>;
        Imputados(DenunciaId, 'Imputado');
    </script>
</body>
</html>
