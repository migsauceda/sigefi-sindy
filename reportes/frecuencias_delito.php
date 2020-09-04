<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<!--controles para los campos del formulario, clases y funciones-->
<?php 	include("../clases/controles/funct_text.php");
	include("../clases/controles/funct_select.php");
	include("../clases/controles/funct_radio.php");
	include("../clases/controles/funct_check.php");
	include("../clases/controles/func_llena_combo.php");
	
	//funciones genericas
	include "../funciones/php_funciones.php";
        
        //inicia sesión
        session_start();
        
        if (!isset($_SESSION['usuario'])){	
            header("location:index.php");
        }              
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" rel="stylesheet" href="../css/smoothness/jquery-ui-1.8.12.custom.css"> 
        <link type="text/css" rel="stylesheet" href="../css/Estilos.css"> 
        
        <!-- jquery -->
        <link href="../java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
        <script src="../java_script/js/jquery-1.10.2.js"></script>
        <script src="../java_script/js/jquery-ui-1.10.4.custom.js"></script>  
    
        <script type="text/javascript" src="../java_script/funciones.js"></script>	 
        <script src="../funciones/funciones.js"></script>
        <title>Frecuencias de delitos</title>
    </head>
    <body>
    <script type="text/javascript">
        $(function() {
            $( "#txtFechaInicio" ).datepicker({ 
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true
            });

        });

        $(function() {
            $( "#txtFechaFin" ).datepicker({ 
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true
            });

        });

        function CalDenuncia(){
            $( "#txtFechaInicio" ).datepicker();

        }
        function CalHecho(){
            $( "#txtFechaFin" ).datepicker();
        }

    </script>

    <form name="frmFrecuenciaDelitos" action="rptFrecuenciasDelitos.php" method="POST">
        <br>
        <h3 style="text-align: center">Frecuencias de Delitos</h3>
        <table align="center" border="0" class="TablaCaja" cellspacing="1" cellpading="0" width="70%">
          <tbody>
            <tr class="SubTituloCentro"><Th colspan="3"><strong>Rango de Fechas y Delitos</strong></Th></tr>
            <tr class="SubTituloDerecha">
              <td>Fecha inicio</td>
              <td>Fecha fin</td>
              <td>Delito</td>
            </tr>
            <tr class="Grid">
              <td>
                  <input name="txtFechaInicio" type="text" id="txtFechaInicio" size="10" maxlength="15"/>
              </td>
              <td id="ffin">
                  <input name="txtFechaFin" type="text" id="txtFechaFin" size="10" maxlength="15"/>
              </td>
              <td id="delito">
                  <?php
                    $resDelitos= CargarDelitos();
                    combo("cboDelitos", $resDelitos, "ndelitoid", "cdescripcion", "","");
                  ?>
              </td>
            </tr>
          </tbody>
        </table>
        <br>
        <table align="center" border="0" class="TablaCaja" cellspacing="1" cellpading="0" width="70%">
          <tbody>
            <tr class="SubTituloCentro"><Th colspan="4"><strong>Ubicación </strong></Th></tr>
            <tr class="SubTituloDerecha">
              <td>Departamento</td>
              <td>Municipio</td>
              <td>Ciudad o Aldea</td>
              <td>Barrio</td>
            </tr>
            <tr class="Grid">
      <td>
	<?php 
		$resDepto2= CargarDepto();
		 combo("cboDepto2",$resDepto2,"cdepartamentoid","cdescripcion","",
                         "onchange='llena_muni(".'"cboDepto2"'.",".'"cboMuni2"'.","
                         .'"tdMuni2"'.",".'"12"'.",".'"cboAldea2"'.",".'"cboBarrio2"'
                         .")'");
	?>

      </td>
      <td id="tdMuni2">
	<?php
		combo("cboMuni2","","cmunicipioid","cdescripcion","",
                      "onchange='llena_aldea(".'"cboDepto2"'.",".'"cboMuni2"'.",
                      ".'"cboAldea2"'.",".'"tdAldea2"'.",".'"6"'.",".'"cboBarrio"'.")'");
	?>
      </td>
      <td id="tdAldea2">
	<?php
            combo("cboAldea2","","cbaldeaId","cdescripcion","","");
	?>
      </td>
      <td id="tdBarrio2">
	<?php
		combo("cboBarrio2","","cbarrioId","cdescripcion","","");
	?>
      </td>
            </tr>
          </tbody>
        </table>
        <br><hr>
        <table align="center">
          <tbody>
            <tr>
              <td><INPUT type="submit" name="btnSubmit" value="Generar reporte"></td>
              <td><INPUT type="reset" name="btnReset" value="Limpiar campos"></td>
            </tr>
          </tbody>
        </table>   
    </form>
    </body>
</html>