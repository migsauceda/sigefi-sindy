<html>
<head>
	<meta charset="utf-8">
	<title>Actividades</title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<link rel="stylesheet" href="/resources/demos/style.css">
	<script>
            
	$(function() {
  

    $( "#fiscal" ).accordion({            
        active: false,
        autoHeight: false,
        collapsible: true,
        multi: false,
        heightStyle: "content"
    });
 
    $( ".denuncia" ).accordion({            
        active: false,
        autoHeight: false,
        collapsible: true,
         multi: false,
         heightStyle: "content"
    });
 
});
	</script>
        
<?php     
include('../clases/class_conexion_pg.php');
$objConexion=new Conexion(); 
?> 
    <?php
        $query = "SELECT (cnombres||' '||capellidos) as nombre_fiscal, cfiscalid, nfiscaliaid
        FROM mini_sedi.tbl_fiscal ORDER BY nombre_fiscal;";
        $consulta=$objConexion->ejecutarComando($query) or die("Error en la Consulta SQL");
    ?>
</head>
<body><table align='center'><tr><td>
                <h3>Expedientes por Fiscal</h3><hr><br></td></tr> </table>
    <div id="fiscal" width:150px>
    <?php
        while ($row = pg_fetch_array($consulta)) {
    ?>
        <h3><a href="#"><?php echo '<option value=" ' .$row["cfiscalid"].' ">'.$row["nombre_fiscal"].'</option>';?></a></h3>
            <div class="denuncia">
            <?php
                $fiscalid=$row["cfiscalid"];
                    $query2 = "SELECT distinct(tbl_denuncia.tdenunciaid), tbl_imputado_fiscal.cfiscal, (tbl_fiscal.cnombres||' '||tbl_fiscal.capellidos) as fiscal
                               FROM  mini_sedi.tbl_denuncia, mini_sedi.tbl_imputado_fiscal, mini_sedi.tbl_fiscal
                               WHERE 
                               tbl_imputado_fiscal.tdenunciaid = tbl_denuncia.tdenunciaid AND
                               tbl_fiscal.cfiscalid = tbl_imputado_fiscal.cfiscal AND
                               tbl_imputado_fiscal.cfiscal =  '$fiscalid';";
                    $consulta2 = $objConexion->ejecutarComando($query2) or die("Error en la Consulta SQL");
                    $numReg = pg_num_rows($consulta2);
            if($numReg>0){
                while ($fila=pg_fetch_array($consulta2)) {
    
                        echo '<h2><a href="#"><option value=" ' .$fila["tdenunciaid"].' ">'.$fila["tdenunciaid"].'</option></a></h2>';
            ?>
                <div>
                    <?php
                    $denunciaid=$fila["tdenunciaid"];
                            $query3 = "SELECT cfiscalid, fiscal, tdenunciaid, cdescripcion, dfecha, imputado
                                        FROM mini_sedi.actividad_fiscal WHERE
                                        cfiscalid= '$fiscalid' AND
                                        tdenunciaid=  $denunciaid
                                        ORDER BY dfecha DESC";
                            $consulta3 = $objConexion->ejecutarComando($query3) or die("Error en la Consulta SQL");
                            $numReg = pg_num_rows($consulta3);
                            $orden = 1;
                        if($numReg>0){
                            echo "<table border='0' align='center' cellspacing='0' cellpadding='10'>
                                    <tr bgcolor=''>
                                    <th># Orden</th>
                                    <th># Actividad</th>
                                    <th>Fecha</th>
                                    <th >Imputado</th>";
                        while ($fila2=pg_fetch_array($consulta3)) {
                            echo '<tr>';
                                echo "<td align='center'>$orden</td>";
                                echo "<td align='center'>".$fila2['cdescripcion']."</td>";
                                echo "<td align='center'>".$fila2['dfecha']. "</td>";
                               echo "<td align='center'>".$fila2['imputado']. "</td>";
                               echo '</tr>';
                                $orden = $orden + 1;
                        }
                                echo "</table>";
                        }else{
                                echo "No hay Registros";
                        }
                    ?>
                </div>          
        
            <?php
                }
            }else{
                echo "No hay Registros";
            }
            ?>
            </div>
         
        <?php
        }
        ?> 
    </div>
</body>
</html>