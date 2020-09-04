<?php 
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
            <strong><h2>Reportes Gerenciales</h2></strong>
        </div>
        <!--<form action="rptRemisionPDF.php" method="post">-->
        <form action="rptPasarela.php" method="POST">
            <table border='0' align='center' cellspacing='0' cellpadding='10'>                                  
            <tr>
                <td>
                    <input type="radio" name="tiporpt" value="Alta">Alta Gerencia <br><br>
                    <input type="radio" name="tiporpt" value="Media">Gerencia Intermedia <br><br>
                    <input type="radio" name="tiporpt" value="Operativo">Personal Operativo <br><br>
                </td>
            </tr>
            </table>                        
            <br>
            <div align="center">
            <input type="submit" value="Ejecutar reporte">
            </div>
        </form>       
</body>
</html>
