<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
  <title>Expedientes por Fiscal Logeado</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <link type="text/css" rel="stylesheet" href="../css/smoothness/jquery-ui-1.8.12.custom.css"> 
  <link type="text/css" rel="stylesheet" href="../css/Estilos.css"> 
  <script type="text/javascript" src="../java_script/jquery-1.5.1.min.js"></script>
  <script type="text/javascript" src="../java_script/jquery-ui-1.8.12.custom.min.js"></script>
</head>
<body>
<script type="text/javascript">
    //para ingresar las fechas
    $(function() {
        $( "#txtFInicio" ).datepicker({ 
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true
        });

    });

    $(function() {
        $( "#txtFFin" ).datepicker({ 
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true
        });

    });
        
    function CalDenuncia(){
        $( "#txtFInicio" ).datepicker();

    }
    function CalHecho(){
        $( "#txtFFin" ).datepicker();
    }
</script>

<br><br>

<form action="rpt_ExpedienteFiscalPDF.php" method="POST" id="rpt" name="rpt">
    <table id="tbl1" align="center" border="0"  cellspacing="0" cellpading="0" class="TablaCaja">
    <tbody>
            <tr class="SubTituloCentro"><th colspan="2">Rango de Fechas</th></tr>
            <tr class="SubTituloDerecha">
                    <th>Inicio</th>
                    <th>Fin</th>
            </tr>
            <tr class="Grid">
                    <td><INPUT type="text" name="txtFInicio" id="txtFInicio" size="10" maxlength="10"></td>
                    <td><INPUT type="text" name="txtFFin" id="txtFFin" size="10" maxlength="10"></td>
            </tr>
    </tbody>
    </table>

    <table align="center">
            <tr>
                    <td><INPUT type="checkbox" id="chbMostrarTodo" name="chbMostrarTodo" value="chk">Mostrar todos</td>
            </tr>
            <tr align="center">
                    <td colspan="2"><INPUT type="submit" name="btnBuscar" value="Buscar" ></td>
            </tr>
    </table>

    <center>
    <div id="1">
    <iframe src="" id="rpt" name="rpt" height="900" width="800" frameborder="1">
    </iframe></div>
    </center>
</form>
</body>
</html>
