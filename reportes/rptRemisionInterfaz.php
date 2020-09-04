<?php 
session_start();
    include_once '../clases/class_conexion_pg.php';
    
    $objConexion= new Conexion();
    $query = "SELECT * FROM mini_sedi.tbl_bandejas;";
    $consulta= $objConexion->ejecutarComando($sql);
      $bande = $_SESSION['bandeja'];
 ?>
<html>    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link href="../java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
        <!--<link href="../java_script/css/smoothness/jquery.datetimepicker.css" rel="stylesheet" type="text/css">-->
        <script src="../java_script/js/jquery-1.10.2.js"></script>
        <script src="../java_script/js/jquery-ui-1.10.4.custom.js"></script>     
        <!--<script src="../java_script/js/jquery.datetimepicker.js"></script>-->  
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
            <strong><h2>Listado de Denuncias Ingresadas<br>
                    en el Rango de Fechas Indicado</h2></strong>
        </div>
        <form action="rptRemisionPDF.php" method="post">
            <table border='0' align='center' cellspacing='0' cellpadding='10'>
            
                <tr>
                <td>Fecha Inicio: <input name="txtInicio" type="text" id="txtInicio" size="17" maxlength="16" required/> </td>
                <td>Fecha Fin: <input name="txtFin" type="text" id="txtFin" size="17" maxlength="16" required/> </td>
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
