<!DOCTYPE html>
<html>
<head>
<meta charset="utf.8">
    <title></title>
</head>
<body>

<?php
  session_start();
 include "clases/class_conexion_pg.php";
 include "funciones/consultas.php";
 include "clases/Usuario.php";


    if (isset($_SESSION['objUsuario'])){
        $con= $_SESSION['objUsuario'];        
    }else{
        header("location:index.php");
    }


$_SESSION['generales']= 't';
$_SESSION['denunciante']= 't';
$_SESSION['denunciado']= 't';   
$_SESSION['ofendido']= 't';
$_SESSION['relaciones']= 't';
$_SESSION['denunciaid'];

$_SESSION["estado"]= "Completando";

$Bandeja= $_POST[bandeja];


$con= new Conexion();
$usuario=$_SESSION['usuario'];


$_SESSION['CambiarTab']= 1;
//$_SESSION["denunciaid"]= $_POST["post_denunciaid"];

//$ubicacion= $objUsuario->getBandejaId();   
 
?>
<html lang="es">
<head>
<title>Resultado de Busqueda</title>
<meta charset = "utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
 
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

    
    
<script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable();
} );
</script>




</head>
<body>
    <header>
        <div class="alert alert-info" align="center">
        <h2>Busqueda de Expediente  </h2>
        </div>
    </header>
    <form method="POST" class="form" action="">


    <?php

    
      session_start();
        echo '
                    <table class="table table-hover table-striped table-bordered" id="example" value="consulta">        
                      <thead>
                        <tr>
                        <th>Número denuncia</th>
                        <th>Fecha denuncia</th>
                        <th>Delito</th>
                        <th>Ofendido</th>
                        <th>Imputado</th>
                        <th>Denunciante</th>
                        <th>accion</th>
                        <th>accion</th>
                        <th>accion</th> 
                         </tr>
                      </thead>
                      <tbody>';

        if ($_SESSION['tipoacceso']== 'Receptor') {
         $bandeja= $_SESSION['bandeja'];
         
        
         $sql= "SELECT DISTINCT td.tdenunciaid ,td.dfechadenuncia, d.cdescripcion, o.cnombres as ofendido , 
                ti.cnombres as imputado, den.cnombres as denunciante
         FROM mini_sedi.tbl_denuncia td 
         INNER JOIN mini_sedi.tbl_imputado_delito tid on tid.tdenunciaid = td.tdenunciaid 
         INNER JOIN  mini_sedi.tbl_denunciante den on den.tdenunciaid = td.tdenunciaid 
         INNER JOIN mini_sedi.tbl_ofendido o on o.tdenunciaid = td.tdenunciaid 
         INNER JOIN mini_sedi.tbl_bandejas tb on tb.ibandejaid = td.ibandejaid 
         INNER JOIN mini_sedi.tbl_imputado ti on ti.tpersonaid = tid.tpersonaid 
         INNER JOIN mini_sedi.tbl_imputado ti2 on ti2.tdenunciaid = td.tdenunciaid 
         INNER JOIN mini_sedi.tbl_delito d on d.ndelitoid = tid.ndelito 
         INNER JOIN mini_sedi.tbl_usuarios tu on tu.ibandejaid = tb.ibandejaid 
         WHERE td.basignadafiscalia = 'f' and tu.usuario='$usuario' and tu.ibandejaid =$bandeja;";
         }

         if ($_SESSION['tipoacceso']== 'Fiscal') {
         $identidad= $_SESSION['identidad'];
         $ubicacion= $_SESSION['oficina'];
         
         $sql= "SELECT td.tdenunciaid ,td.dfechadenuncia, td2.cdescripcion, to2.cnombres as ofendido,ti.cnombres as imputado,td3.cnombres as denunciante
        FROM mini_sedi.tbl_denuncia td
        INNER JOIN mini_sedi.tbl_ofendido to2 ON to2.tdenunciaid =td.tdenunciaid 
        INNER JOIN mini_sedi.tbl_denunciante td3 ON td3.tdenunciaid =td.tdenunciaid 
        INNER JOIN mini_sedi.tbl_imputado_fiscal tif  ON tif.tdenunciaid = td.tdenunciaid
        INNER JOIN mini_sedi.tbl_imputado_delito tid ON tid.tdenunciaid = td.tdenunciaid
        INNER JOIN mini_sedi.tbl_imputado ti ON ti.tpersonaid = tid.tpersonaid 
        INNER JOIN mini_sedi.tbl_delito td2 ON td2.ndelitoid = tid.ndelito 
        INNER JOIN mini_sedi.tbl_usuarios tu ON tu.identidad = tif.cfiscal 
        where td.basignadafiscal='t' AND tif.bactivo = 't' AND tu.identidad= '$identidad';";
             
         }

                     $resultado= $con->ejecutarComando($sql);
                     while ($rows = pg_fetch_ASSOC($resultado))
                      {
                          echo '<tr>
                                <td>'.$rows["tdenunciaid"].'</td>
                                <td>'.$rows["dfechadenuncia"].'</td>
                                <td>'.$rows["cdescripcion"].'</td>
                                <td>'.$rows["ofendido"].'</td>
                                <td>'.$rows["imputado"].'</td>
                                <td>'.$rows["denunciante"].'</td>
                                <td><a href="denuncia/frmExpediente.php?var='.$rows["tdenunciaid"].'">Modificar</a></td>
                                <td width= 70%><a href="actividad/actividadb.php?var='.$rows["tdenunciaid"].'">Agregar diligencia fiscal</a></td>
                                <td><a href="reportes/denuncia_pdf.php?denunciaprn='.$rows["tdenunciaid"].'">Imprimir</a></td>
                                </tr>';
                       }  
                    echo "</tbody>
                    </table>";

          
                
          ?>
               
          
        </div>
        <div class="col-md-1"> </div>
      </div>
    
   
 
       
     </form>
     </body>
</html>
