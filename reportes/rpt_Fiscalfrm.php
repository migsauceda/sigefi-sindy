<?php 
session_start();
    include_once '../clases/class_conexion_pg.php';
  
 ?>
<html>    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link href="../java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
        <script src="../java_script/js/jquery-1.10.2.js"></script>
        <script src="../java_script/js/jquery-ui-1.10.4.custom.js"></script> 
        <script src="../funciones/funciones.js"></script>         
    </head>
 
    <body>
        <script type="text/javascript">
            $(function(){
                $("#txtInicio").datepicker({
                    dateFormat:'dd/mm/yy'
                });
            });

            $(function(){
                $("#txtFin").datepicker({dateFormat:'dd/mm/yy'
                });
            });    
        </script>
        
        <br><br>
        <div align="center">
            <strong><h2>Reportes Fiscales</h2></strong>
        </div>
        
        <form action="rptRemisionPDF.php" method="POST">
            <table border='0' align='rigth' cellspacing='0' cellpadding='10'>
            <tr>
                <?php
echo "-".$_SESSION['rol'];
 if($_SESSION['rol'] == 5){?>
                    <td><a href="rptActividadImputado.php">Expedientes por Denuncia</a> </td>
                    
                <?php } elseif($_SESSION['rol'] == 2 || $_SESSION['rol'] == 3){ echo "entra"; ?>
                    <td><a href="rptActividadImputadoInterfaz.php">Expedientes por Denuncia</a> </td>
                <?php } ?>
            </tr>
            </table>
            
            <br>
            <table <input align='center'>
                <tr><th><input type="submit" value="Generar reporte"></th></tr>
            </table>            
        </form>        
</form>
</body>
</html>
