<?php   
    include "../clases/Usuario.php";
    
    session_start();
    if (isset($_SESSION['objUsuario'])){
        $objUsuario= $_SESSION['objUsuario'];        
    }else{
        header("location:index.php");
    }
    
    $_SESSION['fiscalia'] = $objUsuario->getSubBandejaId();
    
    include('../clases/class_conexion_pg.php');
    $objConexion=new Conexion(); 
?>

<html>
<head>
	<meta charset="utf-8">
	<title>Actividades</title>	
        <script src="../java_script/js/jquery-1.10.2.js"></script>
        <script src="../java_script/js/jquery-ui-1.10.4.custom.js"></script> 
	<link href="../java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">

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
</head>
<body>
    
    <?php if($objUsuario->getPermiso(11)== '1'){ ?>
    <table align='center'><tr><td>
                <h3>Fiscales en ésta fiscalía</h3><hr><br></td></tr> </table>
    <div id="fiscal" width:150px>
    <?php
    $OficinaId= $objUsuario->getOficinaId();
    $query = "SELECT (cnombres||' '||capellidos) as nombre_fiscal, cfiscalid, nfiscaliaid
        FROM mini_sedi.tbl_fiscal WHERE nfiscaliaid = $OficinaId ORDER BY nombre_fiscal ;";
    
        $consulta=$objConexion->ejecutarComando($query) or die("Error en la Consulta SQL1");
        while ($row = pg_fetch_array($consulta)) {
    ?>
        <h3><a href="#"><?php echo '<option value=" ' .$row["cfiscalid"].' ">'.$row["nombre_fiscal"].'</option>';?></a></h3>
            <div class="denuncia">
            <?php
                $FiscalId = $row["cfiscalid"];
                    $query2 = "SELECT distinct(tbl_denuncia.tdenunciaid), tbl_imputado_fiscal.cfiscal, (tbl_fiscal.cnombres||' '||tbl_fiscal.capellidos) as fiscal
                               FROM  mini_sedi.tbl_denuncia, mini_sedi.tbl_imputado_fiscal, mini_sedi.tbl_fiscal
                               WHERE 
                               tbl_imputado_fiscal.tdenunciaid = tbl_denuncia.tdenunciaid AND
                               tbl_fiscal.cfiscalid = tbl_imputado_fiscal.cfiscal AND
                               tbl_imputado_fiscal.cfiscal =  '$FiscalId';";
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
    <?php
        }else if ($objUsuario->getPermiso(12)== '1'){
        ?> 
    <table align='center'><tr><td>
                <h3>Expedientes por Denuncias</h3><hr><br></td></tr> </table>
    <div id="fiscal" width:150px>
    <?php $fiscalid = $objUsuario->getIdentidad();
                    $querya = "SELECT distinct(tbl_denuncia.tdenunciaid), tbl_imputado_fiscal.cfiscal, (tbl_usuarios.nombres||' '||tbl_usuarios.apellidos) as fiscal
                               FROM  mini_sedi.tbl_denuncia, mini_sedi.tbl_imputado_fiscal, mini_sedi.tbl_usuarios
                               WHERE 
                               tbl_imputado_fiscal.tdenunciaid = tbl_denuncia.tdenunciaid AND
                               tbl_usuarios.identidad = tbl_imputado_fiscal.cfiscal AND
                               tbl_imputado_fiscal.cfiscal =  '$fiscalid';";
                   
                    $consultaa = $objConexion->ejecutarComando($querya) or die("Error en la Consulta SQL21");
                    $numReg = pg_num_rows($consultaa);
                    
            if($numReg>0){
                
        while ($filaa = pg_fetch_array($consultaa)) {
    ?>
        <h6><a href="#"><?php echo '<option value=" ' .$filaa["tdenunciaid"].' ">'.$filaa["tdenunciaid"].'</option>'?></a></h6>
                           <div>
                    <?php
                    $denunciaid= $filaa["tdenunciaid"];
                            $query3 = "SELECT identidad, fiscal, tdenunciaid, cdescripcion, dfecha, imputado
                                        FROM mini_sedi.actividad_fiscal WHERE
                                        identidad= '$fiscalid' AND
                                        tdenunciaid=  $denunciaid
                                        ORDER BY dfecha DESC";
//                            exit($query3);
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
        ?> 
        <?php
        }
        ?> 
    </div>
    
    
    <?php
        }
        ?> 
</body>
</html>