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

    $query = "SELECT nfiscaliaid, cdescripcion
      FROM mini_sedi.tbl_fiscalia;";
    $consulta = $objConexion->ejecutarComando($query) or die("Error en la Consulta SQL");    
?>

<html>
    <head>      
        <title>Fiscalia</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <script src="../java_script/js/jquery-1.10.2.js"></script>
        <script src="../java_script/js/jquery-ui-1.10.4.custom.js"></script> 
	<link href="../java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">>
        <link rel="stylesheet" href="/resources/demos/style.css">
    </head>
    <body>
        <table align='center'><tr><td>
            <br>
            <h3>Lista de fiscales</h3><hr><br></td></tr> 
        </table>
        
        <form action="rptActividadImputadoInterfaz.php" method="post" >
            <table border='0' align='center' cellspacing='0' cellpadding='10'>
            <tr><td>
                <select name= "bandejas" id= "bandejas"  >
                <?php
                    do {
                           echo '<option value=" ' .$row["nfiscaliaid"].' ">'.$row["cdescripcion"].'</option>';
                    }while ($row = pg_fetch_array($consulta));
                ?> 
                </select>
            </td></tr>
            </table>
       
            <table <input align='center'>
                <tr><th><input type="submit" value="Ejecutar reporte" name="verifica"></th></tr>   
            </table>
        </form>          
    </body>
</html>
